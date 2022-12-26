<?php
    include 'install/src/helpers.php';
    include 'install/src/check-status.php';

    $requirements = [
        [
            'name' => 'PHP',
            'required' => '>= 8.0.2',
            'current' => phpversion(),
            'status' => (float) phpversion() >= (float) '8.0.2'
        ],
        [
            'name' => 'max_execution_time',
            'required' => '300',
            'current' => ini_get('max_execution_time'),
            'status' => ini_get('max_execution_time') >= 300,
        ],
        [
            'name' => 'allow_url_fopen',
            'required' => '1',
            'current' => ini_get('allow_url_fopen'),
            'status' => ini_get('allow_url_fopen') == 1,
        ],
        [
            'name' => 'BCMath',
            'required' => '',
            'current' => '',
            'status' => extension_loaded('bcmath'),
        ],
        [
            'name' => 'Ctype',
            'required' => '',
            'current' => '',
            'status' => extension_loaded('ctype'),
        ],
        [
            'name' => 'cURL',
            'required' => '',
            'current' => '',
            'status' => extension_loaded('curl'),
        ],
        [
            'name' => 'DOM',
            'required' => '',
            'current' => '',
            'status' => extension_loaded('dom'),
        ],
        [
            'name' => 'Fileinfo',
            'required' => '',
            'current' => '',
            'status' => extension_loaded('fileinfo'),
        ],
        [
            'name' => 'GD',
            'required' => '',
            'current' => '',
            'status' => extension_loaded('gd'),
        ],
        [
            'name' => 'JSON',
            'required' => '',
            'current' => '',
            'status' => extension_loaded('json'),
        ],
        [
            'name' => 'Mbstring',
            'required' => '',
            'current' => '',
            'status' => extension_loaded('mbstring'),
        ],
        [
            'name' => 'OpenSSL',
            'required' => '',
            'current' => '',
            'status' => extension_loaded('openssl'),
        ],
        [
            'name' => 'PCRE',
            'required' => '',
            'current' => '',
            'status' => extension_loaded('pcre'),
        ],
        [
            'name' => 'PDO',
            'required' => '',
            'current' => '',
            'status' => extension_loaded('pdo'),
        ],
        [
            'name' => 'Tokenizer',
            'required' => '',
            'current' => '',
            'status' => extension_loaded('tokenizer'),
        ],
        [
            'name' => 'XML',
            'required' => '',
            'current' => '',
            'status' => extension_loaded('xml'),
        ],
        [
            'name' => 'Zip',
            'required' => '',
            'current' => '',
            'status' => extension_loaded('zip'),
        ],
    ];

    $permissions = [
        [
            'name' => 'storage/framework/',
            'required' => '0755',
            'current' => substr(sprintf('%o', fileperms(__DIR__ . '/../storage/framework/')), -4),
            'status' => substr(sprintf('%o', fileperms(__DIR__ . '/../storage/framework/')), -4) >= '0755',
        ],
        [
            'name' => 'storage/logs/',
            'required' => '0755',
            'current' => substr(sprintf('%o', fileperms(__DIR__ . '/../storage/logs/')), -4),
            'status' => substr(sprintf('%o', fileperms(__DIR__ . '/../storage/logs/')), -4) >= '0755',
        ],
        [
            'name' => 'bootstrap/cache/',
            'required' => '0755',
            'current' => substr(sprintf('%o', fileperms(__DIR__ . '/../bootstrap/cache/')), -4),
            'status' => substr(sprintf('%o', fileperms(__DIR__ . '/../bootstrap/cache/')), -4) >= '0755',
        ],
        [
            'name' => 'public/img/',
            'required' => '0775',
            'current' => substr(sprintf('%o', fileperms(__DIR__ . '/img/')), -4),
            'status' => substr(sprintf('%o', fileperms(__DIR__ . '/img/')), -4) >= '0775',
        ],
        [
            'name' => 'public/files/',
            'required' => '0775',
            'current' => substr(sprintf('%o', fileperms(__DIR__ . '/files/')), -4),
            'status' => substr(sprintf('%o', fileperms(__DIR__ . '/files/')), -4) >= '0775',
        ],
    ];

    $items = array_merge($requirements, $permissions);

    // Check if any of the requirement is not passed then status
    // will be false to prevent installation process.
    $status = checkStatus($items);

    include 'install/resources/views/index.php';
