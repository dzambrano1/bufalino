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

    // Initialize monthly expenses array
    $monthlyExpenses = [];
    
    // Define expense categories with their table configurations
    $expenseCategories = [
        'Concentrado' => [
            'table' => 'bh_concentrado',
            'date_start' => 'bh_concentrado_fecha_inicio',
            'date_end' => 'bh_concentrado_fecha_fin',
            'qty_field' => 'bh_concentrado_racion',
            'price_field' => 'bh_concentrado_costo'
        ],
        'Melaza' => [
            'table' => 'bh_melaza',
            'date_start' => 'bh_melaza_fecha_inicio',
            'date_end' => 'bh_melaza_fecha_fin',
            'qty_field' => 'bh_melaza_racion',
            'price_field' => 'bh_melaza_costo'
        ],
        'Sal' => [
            'table' => 'bh_sal',
            'date_start' => 'bh_sal_fecha_inicio',
            'date_end' => 'bh_sal_fecha_fin',
            'qty_field' => 'bh_sal_racion',
            'price_field' => 'bh_sal_costo'
        ],
        'Aftosa' => [
            'table' => 'bh_aftosa',
            'date_field' => 'bh_aftosa_fecha',
            'qty_field' => 'bh_aftosa_dosis',
            'price_field' => 'bh_aftosa_costo'
        ],
        'Brucelosis' => [
            'table' => 'bh_brucelosis',
            'date_field' => 'bh_brucelosis_fecha',
            'qty_field' => 'bh_brucelosis_dosis',
            'price_field' => 'bh_brucelosis_costo'
        ],
        'IBR' => [
            'table' => 'bh_ibr',
            'date_field' => 'bh_ibr_fecha',
            'qty_field' => 'bh_ibr_dosis',
            'price_field' => 'bh_ibr_costo'
        ],
        'CBR' => [
            'table' => 'bh_cbr',
            'date_field' => 'bh_cbr_fecha',
            'qty_field' => 'bh_cbr_dosis',
            'price_field' => 'bh_cbr_costo'
        ],
        'Carbunco' => [
            'table' => 'bh_carbunco',
            'date_field' => 'bh_carbunco_fecha',
            'qty_field' => 'bh_carbunco_dosis',
            'price_field' => 'bh_carbunco_costo'
        ],
        'Garrapatas' => [
            'table' => 'bh_garrapatas',
            'date_field' => 'bh_garrapatas_fecha',
            'qty_field' => 'bh_garrapatas_dosis',
            'price_field' => 'bh_garrapatas_costo'
        ],
        'Lombrices' => [
            'table' => 'bh_lombrices',
            'date_field' => 'bh_lombrices_fecha',
            'qty_field' => 'bh_lombrices_dosis',
            'price_field' => 'bh_lombrices_costo'
        ]
    ];

    // Process each expense category
    foreach ($expenseCategories as $categoryName => $config) {
        
        if (in_array($categoryName, ['Concentrado', 'Melaza', 'Sal'])) {
            // Special handling for feed supplements with date ranges
            $sql = "SELECT 
                        DATE_FORMAT({$config['date_start']}, '%Y-%m') as month,
                        SUM({$config['qty_field']} * {$config['price_field']} * 
                            DATEDIFF({$config['date_end']}, {$config['date_start']}) + 1) as total_expense,
                        SUM({$config['qty_field']}) as total_quantity,
                        AVG({$config['price_field']}) as avg_price,
                        COUNT(*) as record_count
                    FROM {$config['table']} 
                    WHERE {$config['date_start']} IS NOT NULL 
                    AND {$config['date_end']} IS NOT NULL
                    AND {$config['qty_field']} > 0 
                    AND {$config['price_field']} > 0
                    GROUP BY DATE_FORMAT({$config['date_start']}, '%Y-%m')
                    ORDER BY month ASC";
        } else {
            // Standard processing for health/vaccine categories
            $sql = "SELECT 
                        DATE_FORMAT({$config['date_field']}, '%Y-%m') as month,
                        SUM({$config['qty_field']} * {$config['price_field']}) as total_expense,
                        SUM({$config['qty_field']}) as total_quantity,
                        AVG({$config['price_field']}) as avg_price,
                        COUNT(*) as record_count
                    FROM {$config['table']} 
                    WHERE {$config['date_field']} IS NOT NULL 
                    AND {$config['qty_field']} > 0 
                    AND {$config['price_field']} > 0
                    GROUP BY DATE_FORMAT({$config['date_field']}, '%Y-%m')
                    ORDER BY month ASC";
        }

        $result = mysqli_query($conn, $sql);
        
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $month = $row['month'];
                $expense = (float)$row['total_expense'];
                
                // Initialize month if not exists
                if (!isset($monthlyExpenses[$month])) {
                    $monthlyExpenses[$month] = [
                        'month' => $month,
                        'total_expenses' => 0,
                        'categories' => []
                    ];
                }
                
                // Add to totals
                $monthlyExpenses[$month]['total_expenses'] += $expense;
                $monthlyExpenses[$month]['categories'][$categoryName] = $expense;
            }
        }
    }

    // Convert to final format and sort by month
    $data = [];
    ksort($monthlyExpenses);
    
    foreach ($monthlyExpenses as $monthData) {
        $data[] = [
            'month' => $monthData['month'],
            'total_expenses' => (float)$monthData['total_expenses'],
            'categories' => $monthData['categories']
        ];
    }

    // Close connection
    mysqli_close($conn);

    // Return JSON response
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);

} catch (Exception $e) {
    // Log error for debugging
    error_log("Error in get_all_expenses_data.php: " . $e->getMessage());
    
    // Return error response
    http_response_code(500);
    echo json_encode(array(
        'error' => 'Error al obtener datos de gastos totales',
        'message' => $e->getMessage()
    ), JSON_UNESCAPED_UNICODE);
}
?>
