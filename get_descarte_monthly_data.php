<?php
require_once './pdo_conexion.php';

header('Content-Type: application/json');

try {
    // Get filter parameters
    $year = $_GET['year'] ?? '';
    $month = $_GET['month'] ?? '';
    
    // Build the WHERE clause based on filters
    $whereClause = "WHERE estatus = 'Descartado'";
    $params = [];
    
    if (!empty($year)) {
        $whereClause .= " AND YEAR(descarte_fecha) = ?";
        $params[] = $year;
    }
    
    if (!empty($month)) {
        $whereClause .= " AND MONTH(descarte_fecha) = ?";
        $params[] = $month;
    }
    
    // Query to get monthly data
    $query = "SELECT 
                DATE_FORMAT(descarte_fecha, '%Y-%m') as month,
                SUM(descarte_precio * descarte_peso) as total_value,
                COUNT(*) as buffalo_count
              FROM bufalino 
              $whereClause
              GROUP BY DATE_FORMAT(descarte_fecha, '%Y-%m')
              ORDER BY month ASC";
    
    $stmt = $conn->prepare($query);
    $stmt->execute($params);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Fill in missing months with zero values
    $filledData = [];
    $months = [];
    
    if (!empty($results)) {
        $startDate = new DateTime($results[0]['month'] . '-01');
        $endDate = new DateTime(end($results)['month'] . '-01');
        
        $currentDate = clone $startDate;
        while ($currentDate <= $endDate) {
            $monthKey = $currentDate->format('Y-m');
            $months[] = $monthKey;
            $currentDate->add(new DateInterval('P1M'));
        }
        
        // Create a lookup array for existing data
        $dataLookup = [];
        foreach ($results as $row) {
            $dataLookup[$row['month']] = $row;
        }
        
        // Fill in all months
        foreach ($months as $month) {
            if (isset($dataLookup[$month])) {
                $filledData[] = [
                    'month' => $month,
                    'total_value' => (float)$dataLookup[$month]['total_value'],
                    'buffalo_count' => (int)$dataLookup[$month]['buffalo_count']
                ];
            } else {
                $filledData[] = [
                    'month' => $month,
                    'total_value' => 0,
                    'buffalo_count' => 0
                ];
            }
        }
    }
    
    // Get available years for filter
    $yearQuery = "SELECT DISTINCT YEAR(descarte_fecha) as year 
                  FROM bufalino 
                  WHERE estatus = 'Descartado' 
                  ORDER BY year DESC";
    $stmt = $conn->prepare($yearQuery);
    $stmt->execute();
    $years = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo json_encode([
        'success' => true,
        'data' => $filledData,
        'years' => $years,
        'total_value' => array_sum(array_column($filledData, 'total_value')),
        'total_count' => array_sum(array_column($filledData, 'buffalo_count'))
    ]);
    
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>