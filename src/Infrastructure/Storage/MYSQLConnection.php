<?php

namespace Alcoline\Daniel\Infrastructure\Storage;

use Dotenv\Dotenv;
use PDO;
use PDOException;

class MYSQLConnection implements DatabaseConnectionInterface
{
    private PDO $connection;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../../');
        $dotenv->load();

        $host = $_ENV['DB_HOST'];
        $db   = $_ENV['MYSQL_DATABASE'];
        $user = $_ENV['MYSQL_USER'];
        $pass = $_ENV['MYSQL_PASSWORD'];
        $charset = $_ENV['DB_CHARSET'];
        $port = $_ENV['DB_PORT'];

        $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->connection = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}