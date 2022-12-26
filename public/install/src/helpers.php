<?php
    set_error_handler(
        function ($severity, $message, $file, $line) {
            throw new ErrorException($message, $severity, $severity, $file, $line);
        }
    );

    function dd($data)
    {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';

        die;
    }

    function dump($data)
    {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }

    function includeFile($file, $variables = [])
    {
        extract($variables);
        include __DIR__ . '/../resources/views/' . $file;
    }

    function generateRandomKey()
    {
        return 'base64:'.base64_encode(
            random_bytes('AES-256-CBC' === 'AES-128-CBC' ? 16 : 32)
        );
    }
