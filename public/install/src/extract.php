<?php

include 'helpers.php';

$input = json_decode(file_get_contents('php://input'), true);

try {
    $zip = new ZipArchive;
    $res = $zip->open(__DIR__.'/../../../spack.zip');

    if ($res === true) {
        $zip->extractTo(__DIR__.'/../../../');
        $zip->close();

        echo json_encode([
            'success' => true,
            'current_path' => __DIR__,
            'root' => $_SERVER['DOCUMENT_ROOT'],
            'zip' => $res,
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'current_path' => __DIR__,
            'root' => $_SERVER['DOCUMENT_ROOT'],
            'zip' => $res,
        ]);
    }
} catch(Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'current_path' => __DIR__,
        'root' => $_SERVER['DOCUMENT_ROOT'],
    ]);
}
