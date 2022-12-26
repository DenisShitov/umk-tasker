<?php

include 'helpers.php';

$input = json_decode(file_get_contents('php://input'), true);

try {
    $contents = file_get_contents('https://spack-admin.codedott.com/api/download-spack?token='.$input['token'].'&item='.$input['item']);
    file_put_contents(__DIR__.'/../../../spack.zip', $contents);

    echo json_encode([
        'success' => true,
        'current_path' => __DIR__,
        'root' => $_SERVER['DOCUMENT_ROOT'],
    ]);
} catch(Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'current_path' => __DIR__,
        'root' => $_SERVER['DOCUMENT_ROOT'],
    ]);
}
