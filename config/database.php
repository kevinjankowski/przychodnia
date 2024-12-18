<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for database operations. This is
    | the connection which will be utilized unless another connection
    | is explicitly specified when you execute a query / statement.
    |
    */

    'default' => env('DB_CONNECTION', 'sqlite'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Below are all of the database connections defined for your application.
    | An example configuration is provided for each database system which
    | is supported by Laravel. You're free to add / remove connections.
    |
    */

    'connections' => [

        // Domyślna konfiguracja MySQL (np. dla zwykłych projektów)
        'mysql' => [
            'driver' => 'mysql',
            'read' => [
                'host' => [
                    env('DB_HOST_SLAVE', '127.0.0.1'),
                ],
                'port' => env('DB_PORT_SLAVE', '3307'), // Port dla slave
            ],
            'write' => [
                'host' => [
                    env('DB_HOST_MASTER', '127.0.0.1'),
                ],
                'port' => env('DB_PORT_MASTER', '3306'), // Port dla master
            ],
            'database' => env('DB_DATABASE_MASTER', 'forge'),
            'username' => env('DB_USERNAME_MASTER', 'forge'),
            'password' => env('DB_PASSWORD_MASTER', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        // Dodatkowe połączenie dla master (opcjonalne, dla bezpośrednich zapytań)
        'mysql-master' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_MASTER', '127.0.0.1'),
            'port' => env('DB_PORT_MASTER', '3306'),
            'database' => env('DB_DATABASE_MASTER', 'forge'),
            'username' => env('DB_USERNAME_MASTER', 'forge'),
            'password' => env('DB_PASSWORD_MASTER', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        // Dodatkowe połączenie dla slave (opcjonalne, dla bezpośrednich zapytań)
        'mysql-slave' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_SLAVE', '127.0.0.1'),
            'port' => env('DB_PORT_SLAVE', '3307'),
            'database' => env('DB_DATABASE_SLAVE', 'forge'),
            'username' => env('DB_USERNAME_SLAVE', 'forge'),
            'password' => env('DB_PASSWORD_SLAVE', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

    ],


    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run on the database.
    |
    */

    'migrations' => [
        'table' => 'migrations',
        'update_date_on_publish' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as Memcached. You may define your connection settings here.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],

];
