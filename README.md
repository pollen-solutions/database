# Database

[![Latest Stable Version](https://img.shields.io/packagist/v/pollen-solutions/database.svg?style=for-the-badge)](https://packagist.org/packages/pollen-solutions/database)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-green?style=for-the-badge)](LICENSE.md)
[![PHP Supported Versions](https://img.shields.io/badge/PHP->=7.4-8892BF?style=for-the-badge&logo=php)](https://www.php.net/supported-versions.php)

**Database** Component is a database toolkit for PHP. 
At the moment, it uses the Laravel database library as its sole engine.

## Installation

```bash
composer require pollen-solutions/database
```

## Basic Usage

### Add the default connexion

```php
use Pollen\Database\DatabaseManager;

$db = new DatabaseManager();

$db->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'pollen-solutions',
    'username'  => 'root',
    'password'  => 'root',
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_general_ci',
    'prefix'    => 'xyz_',
]);
```

### Using The Schema Builder

```php
use Illuminate\Database\Schema\Blueprint;
use Pollen\Database\DatabaseManagerInterface;

/** @var DatabaseManagerInterface $db */
$schema = $db->getConnection()->getSchemaBuilder();
$schema->create('posts', function (Blueprint $table) {
    $table->increments('id');
    $table->string('title');
    $table->longText('content')->nullable();
    $table->timestamps();
});

```

More usage informations on [Laravel online official documentation](https://laravel.com/docs/8.x/migrations#tables)


### Using The Query Builder

```php
use Pollen\Database\DatabaseManagerInterface;

/** @var DatabaseManagerInterface $db */
$posts = $db->getConnection()->table('posts')->get();

var_dump($posts);
exit;
```

More usage informations on [Laravel online official documentation](https://laravel.com/docs/8.x/queries)

### Optional configuration

#### Static methods call

```php
use Pollen\Database\DatabaseManagerInterface;
use Pollen\Database\DatabaseManager as DB;

/** @var DatabaseManagerInterface $db */
$db->setAsGlobal();

// Now you can call DatabaseManager methods as static.
$posts = DB::table('posts')->get();

var_dump($posts);
exit;
```

## Eloquent model

### Prerequisite

```php
use Pollen\Database\DatabaseManagerInterface;

/** @var DatabaseManagerInterface $db */
$db->bootEloquent();
```

## Advanced Usage

### Configuration parameters

#### MySQL

```php
<?php

use Pollen\Database\DatabaseManagerInterface;

/** @var DatabaseManagerInterface $db */
$db->addConnection([
    /**
     * Connection driver (required)
     * @var string
     */
    'driver'         => 'mysql',
    /**
     * Database name (required).
     * @var string
     */
    'database'       => '',
    /**
     * SQL hostname.
     * @var string
     */
    'host'           => '127.0.0.1',
    /**
     * SQL socket port.
     * @var int
     */
    'port'           => 3306,
    /**
     * Username credentials.
     * @var string
     */
    'username'       => '',
    /**
     * Password credentials.
     * @var string
     */
    'password'       => '',
    /**
     * Unix socket.
     * @var string
     */
    'unix_socket'    => '',
    /**
     * Charset.
     * @var string
     */
    'charset'        => '',
    /**
     * Collation.
     * @var string
     */
    'collation'      => '',
    /**
     * Table prefix.
     * @var string
     */
    'prefix'         => '',
    /**
     * Enable table prefix indexation.
     * @var bool
     */
    'prefix_indexes' => true,
    /**
     * Enable strict mode.
     * @var bool
     */
    'strict'         => true,
    /**
     * engine.
     * @var string|null
     */
    'engine'         => null,
    /**
     * options.
     * @var array
     */
    'options'        => []
]);
```

#### SQLite

```php
<?php

use Pollen\Database\DatabaseManagerInterface;

/** @var DatabaseManagerInterface $db */
$db->addConnection([
    /**
     * Connection driver (required)
     * @var string
     */
    'driver'                 => 'sqlite',
    /**
     * Database name (required).
     * @var string
     */
    'database'                => '',
    /**
     * Table prefix.
     * @var string
     */
    'prefix'                  => '',
    /**
     * Enable foreign key constraints.
     * @var bool
     */
    'foreign_key_constraints' => true,
]);
```

#### PostgreSQL

```php
<?php

use Pollen\Database\DatabaseManagerInterface;

/** @var DatabaseManagerInterface $db */
$db->addConnection([
    /**
     * Connection driver (required)
     * @var string
     */
    'driver'         => 'pgsql',
    /**
     * Database name (required).
     * @var string
     */
    'database'       => '',
    /**
     * SQL hostname.
     * @var string
     */
    'host'           => '127.0.0.1',
    /**
     * SQL socket port.
     * @var int
     */
    'port'           => 5432,
    /**
     * Username credentials.
     * @var string
     */
    'username'       => '',
    /**
     * Password credentials.
     * @var string
     */
    'password'       => '',
    /**
     * Charset.
     * @var string
     */
    'charset'        => '',
    /**
     * Table prefix.
     * @var string
     */
    'prefix'         => '',
    /**
     * Enable table prefix indexation.
     * @var bool
     */
    'prefix_indexes' => true,
    /**
     * Schema.
     * @var string
     */
    'schema'         => '',
    /**
     * Table prefix.
     * @var string
     */
    'sslmode'        => '',
]);
```

#### SQL Server

```php
<?php

use Pollen\Database\DatabaseManagerInterface;

/** @var DatabaseManagerInterface $db */
$db->addConnection([
    /**
     * Connection driver (required)
     * @var string
     */
    'driver'         => 'sqlsrv',
    /**
     * Database name (required).
     * @var string
     */
    'database'       => '',
    /**
     * SQL hostname.
     * @var string
     */
    'host'           => 'localhost',
    /**
     * SQL socket port.
     * @var int
     */
    /**
     * Username credentials.
     * @var string
     */
    'username'       => '',
    /**
     * Password credentials.
     * @var string
     */
    'password'       => '',
    /**
     * Charset.
     * @var string
     */
    'charset'        => '',
    /**
     * Table prefix.
     * @var string
     */
    'prefix'         => '',
    /**
     * Enable table prefix indexation.
     * @var bool
     */
    'prefix_indexes' => true,
]);
```

### Configuration with .env

Coupled with an implementation of .env , Pollen Database could automatically add the default connection.

```dotenv
# In a /var/www/html/.env file
DATABASE_URL=sqlite:///var/www/html/var/database.sqlite
```

```php
<?php

use Pollen\Database\DatabaseManager;
use Pollen\Support\Env;

Env::load('/var/www/html');

$db = (new DatabaseManager())->withDefaultEnvConnection();

try {
    $db->getConnection();
} catch (InvalidArgumentException $e) {
    trigger_error($e->getMessage());
}
exit;
```

### List of configuration params

```dotenv
# SQLite
DB_DRIVER=sqlite
DB_DATABASE=
DB_PREFIX=,
DB_FOREIGN_KEYS=true
```

```dotenv
# MySQL
DB_DRIVER=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=root
DB_PASSWORD=
DB_SOCKET=
DB_CHARSET=utf8mb4
DB_COLLATE=utf8mb4_unicode_ci
DB_PREFIX=
DB_PREFIX_INDEXES=true
DB_STRICT=true
DB_ENGINE=
```

```dotenv
# PostgreSQL
DB_DRIVER=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=
DB_USERNAME=root
DB_PASSWORD=
DB_CHARSET=utf8
DB_PREFIX=
DB_PREFIX_INDEXES=true
DB_SCHEMA=public
DB_SSLMODE=prefer
```

```dotenv
# SQL Server
DB_DRIVER=sqlsrv
DB_HOST=localhost
DB_PORT=1433
DB_DATABASE=
DB_USERNAME=root
DB_PASSWORD=
DB_CHARSET=utf8
DB_PREFIX=
DB_PREFIX_INDEXES=true
```