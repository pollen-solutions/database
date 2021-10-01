<?php

declare(strict_types=1);

namespace Pollen\Database;

use Illuminate\Database\Capsule\Manager as BaseDatabaseManager;
use Pollen\Support\Exception\ManagerRuntimeException;
use Pollen\Support\Env;
use PDO;

class DatabaseManager extends BaseDatabaseManager implements DatabaseManagerInterface
{
    /**
     * Retrieve the database manager instance.
     *
     * @return DatabaseManagerInterface|object
     */
    public static function getInstance(): DatabaseManagerInterface
    {
        if (self::$instance instanceof self) {
            return self::$instance;
        }
        throw new ManagerRuntimeException(sprintf('Unavailable [%s] instance', __CLASS__));
    }

    /**
     * @inheritDoc
     */
    public function withDefaultEnvConnection(): DatabaseManagerInterface
    {
        $args = [];

        if ($url = Env::get('DATABASE_URL')) {
            if (preg_match('/^(sqlite|mysql|postgresql|sqlsrv)\:\/\//', $url, $matches)) {
                $driver = $matches[1] ?? null;

                if ($driver === 'postgresql') {
                    $driver = 'pgsql';
                }
            } else {
                return $this;
            }
        } else {
            $driver = Env::get('DB_DRIVER');
        }

        switch ($driver) {
            case 'sqlite' :
                $args = [
                    'driver'                  => 'sqlite',
                    'database'                => Env::get('DB_DATABASE'),
                    'prefix'                  => Env::get('DB_PREFIX', ''),
                    'foreign_key_constraints' => Env::get('DB_FOREIGN_KEYS', true),
                ];
                break;

            case 'mysql' :
                $args = [
                    'driver'         => 'mysql',
                    'host'           => Env::get('DB_HOST', '127.0.0.1'),
                    'port'           => Env::get('DB_PORT', '3306'),
                    'database'       => Env::get('DB_DATABASE'),
                    'username'       => Env::get('DB_USERNAME', 'root'),
                    'password'       => Env::get('DB_PASSWORD', ''),
                    'unix_socket'    => Env::get('DB_SOCKET', ''),
                    'charset'        => Env::get('DB_CHARSET', 'utf8mb4'),
                    'collation'      => Env::get('DB_COLLATE', 'utf8mb4_unicode_ci'),
                    'prefix'         => Env::get('DB_PREFIX', ''),
                    'prefix_indexes' => Env::get('DB_PREFIX_INDEXES', true),
                    'strict'         => Env::get('DB_STRICT', true),
                    'engine'         => Env::get('DB_ENGINE'),
                    'options'        => extension_loaded('pdo_mysql') ? array_filter([
                        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
                    ]) : [],
                ];
                break;

            case 'postgresql' :
                $args = [
                    'driver'         => 'pgsql',
                    'host'           => Env::get('DB_HOST', '127.0.0.1'),
                    'port'           => Env::get('DB_PORT', '5432'),
                    'database'       => Env::get('DB_DATABASE'),
                    'username'       => Env::get('DB_USERNAME', 'root'),
                    'password'       => Env::get('DB_PASSWORD', ''),
                    'charset'        => Env::get('DB_CHARSET', 'utf8'),
                    'prefix'         => Env::get('DB_PREFIX', ''),
                    'prefix_indexes' => Env::get('DB_PREFIX_INDEXES', true),
                    'schema'         => Env::get('DB_SCHEMA', 'public'),
                    'sslmode'        => Env::get('DB_SSLMODE', 'prefer'),
                ];
                break;

            case 'sqlsrv':
                $args = [
                    'driver'         => 'sqlsrv',
                    'host'           => Env::get('DB_HOST', 'localhost'),
                    'port'           => Env::get('DB_PORT', '1433'),
                    'database'       => Env::get('DB_DATABASE'),
                    'username'       => Env::get('DB_USERNAME', 'root'),
                    'password'       => Env::get('DB_PASSWORD', ''),
                    'charset'        => Env::get('DB_CHARSET', 'utf8'),
                    'prefix'         => Env::get('DB_PREFIX', ''),
                    'prefix_indexes' => Env::get('DB_PREFIX_INDEXES', true),
                ];
                break;
        }

        if (isset($url)) {
            $args['url'] = $url;
        } elseif (empty($args['database'])) {
            return $this;
        }

        $this->addConnection($args);

        return $this;
    }
}