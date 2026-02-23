<?php
declare(strict_types=1);

namespace app\source\db;

use app\source\db\connectors\MSSQLConnection;
use app\source\db\connectors\MySQLConnection;
use app\source\db\connectors\PostgreSQLConnection;

class DataBaseFactory
{
    private array $config;

    public static function getConnection(array $config): DBConnectionInterface
    {
        $driverMap = [
            MySQLConnection::DATABASE_TYPE => MySQLConnection::class,
            PostgreSQLConnection::DATABASE_TYPE => PostgreSQLConnection::class,
            MSSQLConnection::DATABASE_TYPE => MSSQLConnection::class,
        ];

        $driver = $config['driver'] ?? '';
        if (isset($driverMap[$driver])) {
            $class = $driverMap[$driver];
            unset($config['driver']);
            return new $class(...array_values($config));
        }

        throw new \PDOException('No database connection class found for the given driver.');
    }

    public static function doesDatabaseTypeMatch(string $className, string $type): bool
    {
        $reflection = new \ReflectionClass($className);
        if ($reflection->hasConstant('DATABASE_TYPE')) {
            return $reflection->getConstant('DATABASE_TYPE') === $type;
        }
        return false;
    }
}

