<?php 
return [
    'settings' => [
        'displayErrorDetails' => true,
        'db' => [
            'driver' => getenv('DB_DRIVER'),
            'host' => getenv('DB_HOST'),
            'port' => getenv('DB_PORT'),
            'database' => getenv('DB_DATABASE'),
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ],
        'db2' => [
            'driver' => getenv('DB2_DRIVER'),
            'host' => getenv('DB2_HOST'),
            'port' => getenv('DB2_PORT'),
            'database' => getenv('DB2_DATABASE'),
            'username' => getenv('DB2_USERNAME'),
            'password' => getenv('DB2_PASSWORD'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ],

        'jwt' => [
            'secret' => getenv('JWT_SECRET')
        ]
    ],
];
