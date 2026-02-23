<?php
declare(strict_types=1);

namespace app\source\db;

use app\source\SingletonTrait;
use PDO;

/**
 * Class DataBase
 *
 * This class is responsible for establishing a connection to a database based on the provided configuration.
 * It supports multiple database drivers.
 */
class DataBase
{

    use SingletonTrait;

    public PDO $db;

    public function __construct(#[\SensitiveParameter] private readonly array $config)
    {
        $this->connect();
    }

    private function connect(): bool
    {
        $dbArguments = [
            'host' => $this->config['host'],
            'driver' => $this->config['driver'],
            'db_name' => $this->config['db_name'],
            'username' => $this->config['username'],
            'password' => $this->config['password']
        ];
        $connection = DataBaseFactory::getConnection($dbArguments);
        $this->setDataBaseConnection($connection);
        return true;
    }

    private function setDataBaseConnection(DBConnectionInterface $connection): PDO
    {
        return $this->db = $connection->getConnection() ?? throw new \PDOException("Error connecting to the database.");

    }
}

