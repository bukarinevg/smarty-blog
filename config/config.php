<?php

$dbConfig = [
    'host' => getenv('DB_HOST'),
    'db_name' => getenv('DB_DATABASE'),
    'username' => getenv('DB_USERNAME'),
    'password' => getenv('DB_PASSWORD'),
    'driver' => getenv('DB_DRIVER'),
];

$smartyConfig = [
    'template_dir' => dirname(__DIR__) . '/templates',
    'compile_dir' => dirname(__DIR__) . '/public/tmp/templates_c',
    'cache_dir' => dirname(__DIR__) . '/public/tmp/cache',
];

return [
    'components' => [
        'db' => $dbConfig,
        'smarty' => $smartyConfig
    ],
];
