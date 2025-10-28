<?php
require_once './pdo_conexion.php';

// Set content type to JSON
header('Content-Type: application/json');

try {
    // Enable PDO error mode
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Query to get all milk records with date range calculations
    $sql = "SELECT 
                bh_leche_fecha_inicio,
                bh_leche_fecha_fin,
                bh_leche_peso,
                bh_leche_precio
            FROM bh_leche 
            WHERE bh_leche_fecha_inicio IS NOT NULL 
            AND bh_leche_fecha_fin IS NOT NULL
            AND bh_leche_peso IS NOT NULL 
            AND bh_leche_precio IS NOT NULL
            ORDER BY bh_leche_fecha_inicio ASC";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Array to store monthly totals
    $monthlyTotals = [];
    
    // Process each record
    foreach ($records as $record) {
        $startDate = new DateTime($record['bh_leche_fecha_inicio']);
        $endDate = new DateTime($record['bh_leche_fecha_fin']);
        
        // Calculate daily revenue
        $totalDays = $startDate->diff($endDate)->days + 1; // +1 to include both start and end dates
        $dailyRevenue = ($record['bh_leche_peso'] * $record['bh_leche_precio']) / $totalDays;
        
        // Create a period to iterate through each day
        $period = new DatePeriod(
            $startDate,
            new DateInterval('P1D'),
            $endDate->modify('+1 day') // Include end date
        );
        
        // Allocate daily revenue to each month
        foreach ($period as $date) {
            $monthKey = $date->format('Y-m');
            
            if (!isset($monthlyTotals[$monthKey])) {
                $monthlyTotals[$monthKey] = 0;
            }
            
            $monthlyTotals[$monthKey] += $dailyRevenue;
        }
    }
    
    // Sort by month
    ksort($monthlyTotals);
    
    // Convert to the format expected by the frontend
    $result = [];
    $cumulativeTotal = 0;
    
    foreach ($monthlyTotals as $month => $totalRevenue) {
        $cumulativeTotal += $totalRevenue;
        
        $result[] = [
            'month' => $month,
            'total_expense' => round($totalRevenue, 2), // Keep same field name for consistency with chart code
            'cumulative_expense' => round($cumulativeTotal, 2) // Keep same field name for consistency with chart code
        ];
    }
    
    // Return the data as JSON
    echo json_encode($result);
    
} catch (PDOException $e) {
    // Return error as JSON
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    // Return error as JSON
    echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
}
?>
