<?php

include 'helpers.php';

$input = json_decode(file_get_contents('php://input'), true);

// Check Database
$host = $input['host'];
$port = $input['port'];
$database = $input['database'];
$password = isset($input['password']) ? $input['password'] : '';

try {
    $conn = new PDO("mysql:host={$host};port={$port};dbname={$database}", $input['username'], $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $mysqlVer = $conn->query('select version()')->fetchColumn();
    $mysqlRequiredVersion = '5.7.9';
    $mysqlStatus = (float) $mysqlVer >= (float) $mysqlRequiredVersion;

    if (!$mysqlStatus) {
        echo json_encode([
            'success' => false,
            'error' => 'Your MySql version is ' . $mysqlVer . ' but required version >= ' . $mysqlRequiredVersion,
        ]);
        die;
    }
} catch(PDOException $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
    ]);
    die;
}

echo json_encode([
    'success' => true,
]);
