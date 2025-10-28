<?php
header('Content-Type: application/json');

// Include database connection details
require_once "./pdo_conexion.php"; // Adjust path if necessary

// Use mysqli for connection as in the previous examples
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    echo json_encode(['error' => 'Database connection failed: ' . mysqli_connect_error()]);
    exit();
}

mysqli_set_charset($conn, "utf8");

$data = [];

try {
    // Fetch raw records and allocate expense across months by actual overlap days
    // Concentrado Expense per day = bh_concentrado_racion * bh_concentrado_costo
    // Note: end-inclusive semantics; both start and end dates are included in the calculation
    $sql = "
        SELECT 
            bh_concentrado_fecha_inicio,
            bh_concentrado_fecha_fin,
            bh_concentrado_racion,
            bh_concentrado_costo
        FROM bh_concentrado 
        WHERE bh_concentrado_racion > 0 
          AND bh_concentrado_costo > 0 
          AND bh_concentrado_fecha_inicio IS NOT NULL
        ORDER BY bh_concentrado_fecha_inicio ASC
    ";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        $monthTotals = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $startStr = $row['bh_concentrado_fecha_inicio'];
            $endStr = $row['bh_concentrado_fecha_fin'];
            $racion = (float)$row['bh_concentrado_racion'];
            $costo = (float)$row['bh_concentrado_costo'];

            if (!$startStr) { continue; }

            $startDate = new DateTime($startStr);
            $endDate = $endStr ? new DateTime($endStr) : new DateTime($startStr);

            // If end < start, zero days -> skip (we'll add 1 day to include both dates)
            if ($endDate < $startDate) { continue; }

            $perDayExpense = $racion * $costo;

            // Iterate months and allocate by overlap days (end-inclusive, so add 1 day)
            // Add 1 day to endDate to make it inclusive of the end date
            $endDateInclusive = (clone $endDate)->modify('+1 day');
            
            $monthCursor = new DateTime($startDate->format('Y-m-01'));
            $endMonth = new DateTime($endDateInclusive->format('Y-m-01'));
            while ($monthCursor <= $endMonth) {
                $monthStart = new DateTime($monthCursor->format('Y-m-01'));
                $nextMonth = (clone $monthStart)->modify('+1 month');

                $segmentStart = $startDate > $monthStart ? clone $startDate : clone $monthStart;
                $segmentEnd = $endDateInclusive < $nextMonth ? clone $endDateInclusive : clone $nextMonth;

                $overlapDays = 0;
                if ($segmentEnd > $segmentStart) {
                    $overlapInterval = $segmentStart->diff($segmentEnd);
                    $overlapDays = (int)$overlapInterval->days;
                }

                if ($overlapDays > 0) {
                    $monthKey = $monthStart->format('Y-m');
                    if (!isset($monthTotals[$monthKey])) { $monthTotals[$monthKey] = 0.0; }
                    $monthTotals[$monthKey] += ($overlapDays * $perDayExpense);
                }

                $monthCursor = $nextMonth;
            }
        }

        mysqli_free_result($result);

        ksort($monthTotals);
        
        // Calculate cumulative totals
        $cumulativeTotal = 0;
        foreach ($monthTotals as $monthKey => $amount) {
            $cumulativeTotal += $amount;
            $data[] = [
                'month' => $monthKey,
                'total_expense' => (float)$amount,
                'cumulative_expense' => (float)$cumulativeTotal,
                'month_timestamp' => strtotime($monthKey . '-01')
            ];
        }

        echo json_encode($data);
    } else {
        throw new Exception("Error executing concentrado expense query: " . mysqli_error($conn));
    }

} catch (Exception $e) {
    // Log error if needed
    error_log("Error fetching concentrado expense data: " . $e->getMessage());
    echo json_encode(['error' => 'Error processing request: ' . $e->getMessage()]);
} finally {
    // Close connection
    if (isset($conn)) {
        mysqli_close($conn);
    }
}