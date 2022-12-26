<?php

include 'helpers.php';

$input = json_decode(file_get_contents('php://input'), true);

try {
    copy(__DIR__ . '/../index.php', __DIR__ . '/../../index.php');

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
