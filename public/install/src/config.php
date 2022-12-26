<?php

include 'helpers.php';

function updateConfig($configs)
{
    foreach ($configs as $config => $value) {
        $path = __DIR__ . '/../../../.env';

        $success = file_put_contents(
            $path,
            preg_replace(
                '/^' . $config . '=.*/m',
                $config . '="' . $value . '"',
                file_get_contents($path)
            )
        );

        if (!$success) {
            copy(__DIR__ . '/../index.php', __DIR__ . '/../../index.php');

            throw new Exception("It seems .env file has not write permission, please set .env file permission to 0644", 1);

            // $permission = substr(sprintf('%o', fileperms($path)), -4);

            // if (substr($permission, 1, 1) < 6) {
            //     chmod($path, 0644);
            // }
        }
    }
}

$input = json_decode(file_get_contents('php://input'), true);

try {
    $copied = copy(__DIR__ . '/../../../.env.example', __DIR__ . '/../../../.env');

    if (!$copied) {
        throw new Exception("We could not copy .env file due to Permission denied, please set .env file permission to 0644", 1);
    }

    updateConfig([
        'DB_HOST' => $input['host'],
        'DB_PORT' => $input['port'],
        'DB_DATABASE' => $input['database'],
        'DB_USERNAME' => $input['username'],
        'DB_PASSWORD' => $input['password'],
        'PURCHASE_CODE' => $input['purchase_code'],
    ]);

    copy(__DIR__ . '/../laravel-index.php', __DIR__ . '/../../index.php');

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
