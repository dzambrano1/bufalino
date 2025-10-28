<?php
require_once './pdo_conexion.php';

header('Content-Type: application/json');

try {
    // Query to get monthly deceased buffalo data
    $query = "SELECT 
                DATE_FORMAT(deceso_fecha, '%Y-%m') as month,
                COUNT(*) as count,
                SUM(precio_venta) as total_value
              FROM bufalino 
              WHERE estatus = 'Muerto' 
                AND deceso_fecha IS NOT NULL
                AND precio_venta IS NOT NULL
              GROUP BY DATE_FORMAT(deceso_fecha, '%Y-%m')
              ORDER BY month ASC";
    
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Process the data to ensure all months are represented
    $data = [];
    $monthlyData = [];
    
    // Convert results to associative array by month
    foreach ($results as $row) {
        $monthlyData[$row['month']] = [
            'count' => (int)$row['count'],
            'total_value' => (float)$row['total_value']
        ];
    }
    
    // Get date range
    if (!empty($monthlyData)) {
        $months = array_keys($monthlyData);
        $startMonth = min($months);
        $endMonth = max($months);
        
        // Generate all months in range
        $current = new DateTime($startMonth . '-01');
        $end = new DateTime($endMonth . '-01');
        
        while ($current <= $end) {
            $monthKey = $current->format('Y-m');
            $data[] = [
                'month' => $monthKey,
                'count' => isset($monthlyData[$monthKey]) ? $monthlyData[$monthKey]['count'] : 0,
                'total_value' => isset($monthlyData[$monthKey]) ? $monthlyData[$monthKey]['total_value'] : 0
            ];
            $current->add(new DateInterval('P1M'));
        }
    }
    
    echo json_encode([
        'success' => true,
        'data' => $data
    ]);
    
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . $e->getMessage()
    ]);
}
?>
