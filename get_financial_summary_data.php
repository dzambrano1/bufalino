<?php
header('Content-Type: application/json');

require_once './pdo_conexion.php';

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    echo json_encode(['error' => 'Database connection failed: ' . mysqli_connect_error()]);
    exit();
}

mysqli_set_charset($conn, 'utf8');

try {
    // Income totals
    $sqlMilk = "SELECT COALESCE(SUM(bh_leche_peso * bh_leche_precio), 0) AS total FROM bh_leche WHERE bh_leche_peso > 0 AND bh_leche_precio > 0";
    // Peso income: sum of the maximum slaughter value per tagid
    $sqlPeso = "
        SELECT COALESCE(SUM(max_val), 0) AS total
        FROM (
            SELECT bh_peso_tagid, MAX(bh_peso_animal * bh_peso_precio) AS max_val
            FROM bh_peso
            WHERE bh_peso_animal > 0 AND bh_peso_precio > 0 AND bh_peso_tagid IS NOT NULL
            GROUP BY bh_peso_tagid
        ) AS t
    ";

    $milkTotal = 0.0; $pesoTotal = 0.0;
    if ($res = mysqli_query($conn, $sqlMilk)) { $row = mysqli_fetch_assoc($res); $milkTotal = isset($row['total']) ? (float)$row['total'] : 0.0; mysqli_free_result($res);}    
    if ($res = mysqli_query($conn, $sqlPeso)) { $row = mysqli_fetch_assoc($res); $pesoTotal = isset($row['total']) ? (float)$row['total'] : 0.0; mysqli_free_result($res);}    
    $incomeTotal = $milkTotal + $pesoTotal;

    // Expenses totals
    // Concentrado
    $sqlConcentrado = "
        SELECT SUM(GREATEST(IFNULL(TIMESTAMPDIFF(DAY, bh_concentrado_fecha_inicio, bh_concentrado_fecha_fin), 0), 0) * bh_concentrado_racion * bh_concentrado_costo) AS total
        FROM bh_concentrado
        WHERE bh_concentrado_racion > 0 AND bh_concentrado_costo > 0 AND bh_concentrado_fecha_inicio IS NOT NULL
    ";
    $concentradoTotal = 0.0;
    if ($res = mysqli_query($conn, $sqlConcentrado)) { $row = mysqli_fetch_assoc($res); $concentradoTotal = (float)($row['total'] ?? 0); mysqli_free_result($res);}    

    // Melaza
    $sqlMelaza = "
        SELECT SUM(GREATEST(IFNULL(TIMESTAMPDIFF(DAY, bh_melaza_fecha_inicio, bh_melaza_fecha_fin), 0), 0) * bh_melaza_racion * bh_melaza_costo) AS total
        FROM bh_melaza
        WHERE bh_melaza_racion > 0 AND bh_melaza_costo > 0 AND bh_melaza_fecha_inicio IS NOT NULL
    ";
    $melazaTotal = 0.0;
    if ($res = mysqli_query($conn, $sqlMelaza)) { $row = mysqli_fetch_assoc($res); $melazaTotal = (float)($row['total'] ?? 0); mysqli_free_result($res);}    

    // Sal
    $sqlSal = "
        SELECT SUM(GREATEST(IFNULL(TIMESTAMPDIFF(DAY, bh_sal_fecha_inicio, bh_sal_fecha_fin), 0), 0) * bh_sal_racion * bh_sal_costo) AS total
        FROM bh_sal
        WHERE bh_sal_racion > 0 AND bh_sal_costo > 0 AND bh_sal_fecha_inicio IS NOT NULL
    ";
    $salTotal = 0.0;
    if ($res = mysqli_query($conn, $sqlSal)) { $row = mysqli_fetch_assoc($res); $salTotal = (float)($row['total'] ?? 0); mysqli_free_result($res);}    

    // Vacunas
    $vaccines = [
        ['table' => 'bh_aftosa', 'dosis' => 'bh_aftosa_dosis', 'costo' => 'bh_aftosa_costo'],
        ['table' => 'bh_brucelosis', 'dosis' => 'bh_brucelosis_dosis', 'costo' => 'bh_brucelosis_costo'],
        ['table' => 'bh_ibr', 'dosis' => 'bh_ibr_dosis', 'costo' => 'bh_ibr_costo'],
        ['table' => 'bh_cbr', 'dosis' => 'bh_cbr_dosis', 'costo' => 'bh_cbr_costo'],
        ['table' => 'bh_carbunco', 'dosis' => 'bh_carbunco_dosis', 'costo' => 'bh_carbunco_costo'],
        ['table' => 'bh_garrapatas', 'dosis' => 'bh_garrapatas_dosis', 'costo' => 'bh_garrapatas_costo'],
        ['table' => 'bh_lombrices', 'dosis' => 'bh_lombrices_dosis', 'costo' => 'bh_lombrices_costo']
    ];
    $vacunasTotal = 0.0;
    foreach ($vaccines as $v) {
        $sql = "SELECT SUM({$v['dosis']} * {$v['costo']}) AS total FROM {$v['table']} WHERE {$v['dosis']} > 0 AND {$v['costo']} > 0";
        if ($res = mysqli_query($conn, $sql)) { $row = mysqli_fetch_assoc($res); $vacunasTotal += (float)($row['total'] ?? 0); mysqli_free_result($res);}    
    }

    $expensesTotal = $concentradoTotal + $melazaTotal + $salTotal + $vacunasTotal;
    $grossProfit = $incomeTotal - $expensesTotal;

    $response = [
        [
            'category' => 'Ingresos',
            'amount' => round($incomeTotal, 2),
            'formatted_amount' => number_format($incomeTotal, 2),
            'details' => [
                'milk_income' => $milkTotal,
                'sales_income' => $pesoTotal
            ]
        ],
        [
            'category' => 'Gastos',
            'amount' => round($expensesTotal, 2),
            'formatted_amount' => number_format($expensesTotal, 2),
            'details' => [
                'concentrado' => $concentradoTotal,
                'melaza' => $melazaTotal,
                'sal' => $salTotal,
                'vacunas' => $vacunasTotal
            ]
        ],
        [
            'category' => 'Ganancia Bruta',
            'amount' => round($grossProfit, 2),
            'formatted_amount' => number_format($grossProfit, 2),
            'details' => []
        ]
    ];

    echo json_encode($response);

} catch (Exception $e) {
    error_log('Error building financial summary: ' . $e->getMessage());
    echo json_encode(['error' => 'Error processing request: ' . $e->getMessage()]);
} finally {
    if (isset($conn)) { mysqli_close($conn); }
}


