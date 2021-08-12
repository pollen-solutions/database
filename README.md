# Pollen Database Component

[![Latest Stable Version](https://img.shields.io/packagist/v/pollen-solutions/database.svg?style=for-the-badge)](https://packagist.org/packages/pollen-solutions/database)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-green?style=for-the-badge)](LICENSE.md)
[![PHP Supported Versions](https://img.shields.io/badge/PHP->=7.4-8892BF?style=for-the-badge&logo=php)](https://www.php.net/supported-versions.php)

Pollen **Database** Component is a database toolkit for PHP. 
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
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'pollen-solutions',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_general_ci',
    'prefix' => 'xyz_',
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
