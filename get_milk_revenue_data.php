<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Include database connection
require_once './pdo_conexion.php';

try {
    // Create connection using mysqli
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }

    // Set charset to UTF-8
    mysqli_set_charset($conn, "utf8");

    // SQL query to get individual milk records for proper daily revenue distribution
    // We'll process the data in PHP to handle cross-month periods correctly
    $sql = "SELECT 
                bh_leche_tagid,
                v.nombre as animal_name,
                bh_leche_peso,
                bh_leche_precio,
                bh_leche_fecha_inicio,
                bh_leche_fecha_fin,
                CASE 
                    WHEN bh_leche_fecha_fin IS NOT NULL AND bh_leche_fecha_inicio IS NOT NULL 
                    THEN DATEDIFF(bh_leche_fecha_fin, bh_leche_fecha_inicio) + 1
                    ELSE 1
                END as period_days
            FROM bh_leche l
            LEFT JOIN bufalino v ON l.bh_leche_tagid = v.tagid
            WHERE bh_leche_fecha_inicio IS NOT NULL 
            AND bh_leche_peso > 0 
            AND bh_leche_precio > 0
            ORDER BY bh_leche_fecha_inicio ASC";

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        throw new Exception("Query failed: " . mysqli_error($conn));
    }

    // Array to store monthly aggregated data
    $monthlyData = array();
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Get the daily milk production and price for this record
            $dailyMilkWeight = (float)$row['bh_leche_peso']; // Daily milk production in kg
            $pricePerKg = (float)$row['bh_leche_precio']; // Price per kg
            $dailyRevenue = $dailyMilkWeight * $pricePerKg; // Daily revenue
            
            // Get date range
            $startDate = new DateTime($row['bh_leche_fecha_inicio']);
            $endDate = $row['bh_leche_fecha_fin'] ? new DateTime($row['bh_leche_fecha_fin']) : clone $startDate;
            
            // Track milk weight and revenue for each day in the period
            $currentDate = clone $startDate;
            while ($currentDate <= $endDate) {
                $monthKey = $currentDate->format('Y-m');
                
                // Initialize month data if not exists
                if (!isset($monthlyData[$monthKey])) {
                    $monthlyData[$monthKey] = [
                        'total_revenue' => 0,
                        'total_quantity' => 0,
                        'total_days' => 0,
                        'record_count' => 0,
                        'tagids' => [],
                        'price_sum' => 0,
                        'price_count' => 0,
                        'unique_records' => []
                    ];
                }
                
                // Add daily milk weight and revenue to the month
                $monthlyData[$monthKey]['total_revenue'] += $dailyRevenue;
                $monthlyData[$monthKey]['total_quantity'] += $dailyMilkWeight;
                $monthlyData[$monthKey]['total_days'] += 1;
                
                // Track unique tag IDs for this month
                if (!in_array($row['bh_leche_tagid'], $monthlyData[$monthKey]['tagids'])) {
                    $monthlyData[$monthKey]['tagids'][] = $row['bh_leche_tagid'];
                }
                
                // Track unique records for proper averaging (avoid double counting)
                $recordKey = $row['bh_leche_tagid'] . '_' . $row['bh_leche_fecha_inicio'] . '_' . $row['bh_leche_fecha_fin'];
                if (!in_array($recordKey, $monthlyData[$monthKey]['unique_records'])) {
                    $monthlyData[$monthKey]['unique_records'][] = $recordKey;
                    $monthlyData[$monthKey]['record_count'] += 1;
                    $monthlyData[$monthKey]['price_sum'] += $pricePerKg;
                    $monthlyData[$monthKey]['price_count'] += 1;
                }
                
                // Move to next day
                $currentDate->add(new DateInterval('P1D'));
            }
        }
    }
    
    // Convert to final format
    $data = array();
    ksort($monthlyData); // Sort by month
    
    foreach ($monthlyData as $month => $monthData) {
        $avgPrice = $monthData['price_count'] > 0 ? $monthData['price_sum'] / $monthData['price_count'] : 0;
        $avgPeriodDays = $monthData['record_count'] > 0 ? $monthData['total_days'] / $monthData['record_count'] : 0;
        
        $data[] = array(
            'month' => $month,
            'total_revenue' => number_format($monthData['total_revenue'], 2, '.', ''),
            'total_quantity' => number_format($monthData['total_quantity'], 2, '.', ''),
            'avg_price' => number_format($avgPrice, 2, '.', ''),
            'avg_period_days' => number_format($avgPeriodDays, 1, '.', ''),
            'record_count' => $monthData['record_count'],
            'tagids' => implode(', ', array_unique($monthData['tagids'])),
            'value' => $monthData['total_revenue']
        );
    }

    // Close connection
    mysqli_close($conn);

    // Return JSON response
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);

} catch (Exception $e) {
    // Log error for debugging
    error_log("Error in get_milk_revenue_data.php: " . $e->getMessage());
    
    // Return error response
    http_response_code(500);
    echo json_encode(array(
        'error' => 'Error al obtener datos de ingresos por leche',
        'message' => $e->getMessage()
    ), JSON_UNESCAPED_UNICODE);
}
?> 