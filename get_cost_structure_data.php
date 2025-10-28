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
    $totals = [
        'Concentrado' => 0.0,
        'Melaza' => 0.0,
        'Sal' => 0.0,
        'Vacunas' => 0.0
    ];

    // Concentrado: use days difference * ración * costo (consistent with concentrado endpoint)
    $sqlConcentrado = "
        SELECT 
            SUM(
                GREATEST(
                    IFNULL(TIMESTAMPDIFF(DAY, bh_concentrado_fecha_inicio, bh_concentrado_fecha_fin), 0),
                    0
                ) * bh_concentrado_racion * bh_concentrado_costo
            ) AS total
        FROM bh_concentrado
        WHERE bh_concentrado_racion > 0 AND bh_concentrado_costo > 0 AND bh_concentrado_fecha_inicio IS NOT NULL
    ";
    if ($res = mysqli_query($conn, $sqlConcentrado)) {
        $row = mysqli_fetch_assoc($res);
        $totals['Concentrado'] = (float)($row['total'] ?? 0);
        mysqli_free_result($res);
    }

    // Melaza: use same per-record total definition as in get_melaza_expense_data.php
    $sqlMelaza = "
        SELECT 
            SUM(
                GREATEST(
                    IFNULL(TIMESTAMPDIFF(DAY, bh_melaza_fecha_inicio, bh_melaza_fecha_fin), 0),
                    0
                ) * bh_melaza_racion * bh_melaza_costo
            ) AS total
        FROM bh_melaza
        WHERE bh_melaza_racion > 0 AND bh_melaza_costo > 0 AND bh_melaza_fecha_inicio IS NOT NULL
    ";
    if ($res = mysqli_query($conn, $sqlMelaza)) {
        $row = mysqli_fetch_assoc($res);
        $totals['Melaza'] = (float)($row['total'] ?? 0);
        mysqli_free_result($res);
    }

    // Sal: use same per-record total definition as in get_sal_expense_data.php
    $sqlSal = "
        SELECT 
            SUM(
                GREATEST(
                    IFNULL(TIMESTAMPDIFF(DAY, bh_sal_fecha_inicio, bh_sal_fecha_fin), 0),
                    0
                ) * bh_sal_racion * bh_sal_costo
            ) AS total
        FROM bh_sal
        WHERE bh_sal_racion > 0 AND bh_sal_costo > 0 AND bh_sal_fecha_inicio IS NOT NULL
    ";
    if ($res = mysqli_query($conn, $sqlSal)) {
        $row = mysqli_fetch_assoc($res);
        $totals['Sal'] = (float)($row['total'] ?? 0);
        mysqli_free_result($res);
    }

    // Vacunas: sum across all vaccine tables as in get_vaccine_costs_data.php
    $vaccines = [
        ['table' => 'bh_aftosa', 'dosis' => 'bh_aftosa_dosis', 'costo' => 'bh_aftosa_costo'],
        ['table' => 'bh_brucelosis', 'dosis' => 'bh_brucelosis_dosis', 'costo' => 'bh_brucelosis_costo'],
        ['table' => 'bh_ibr', 'dosis' => 'bh_ibr_dosis', 'costo' => 'bh_ibr_costo'],
        ['table' => 'bh_cbr', 'dosis' => 'bh_cbr_dosis', 'costo' => 'bh_cbr_costo'],
        ['table' => 'bh_carbunco', 'dosis' => 'bh_carbunco_dosis', 'costo' => 'bh_carbunco_costo'],
        ['table' => 'bh_garrapatas', 'dosis' => 'bh_garrapatas_dosis', 'costo' => 'bh_garrapatas_costo'],
        ['table' => 'bh_lombrices', 'dosis' => 'bh_lombrices_dosis', 'costo' => 'bh_lombrices_costo']
    ];
    $vaccinesTotal = 0.0;
    foreach ($vaccines as $v) {
        $sql = "SELECT SUM({$v['dosis']} * {$v['costo']}) AS total FROM {$v['table']} WHERE {$v['dosis']} > 0 AND {$v['costo']} > 0";
        if ($res = mysqli_query($conn, $sql)) {
            $row = mysqli_fetch_assoc($res);
            $vaccinesTotal += (float)($row['total'] ?? 0);
            mysqli_free_result($res);
        }
    }
    $totals['Vacunas'] = $vaccinesTotal;

    // Prepare response for pie chart
    $response = [];
    foreach ($totals as $label => $total) {
        $response[] = [
            'label' => $label,
            'total' => round((float)$total, 2)
        ];
    }

    echo json_encode($response);

} catch (Exception $e) {
    error_log('Error building cost structure: ' . $e->getMessage());
    echo json_encode(['error' => 'Error processing request: ' . $e->getMessage()]);
} finally {
    if (isset($conn)) {
        mysqli_close($conn);
    }
}


