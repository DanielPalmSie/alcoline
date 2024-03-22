<?php

namespace Alcoline\Daniel\Infrastructure\Storage;

use PDO;
use PDOException;

class DatabaseConnection
{
    private static $instance = null;
    private PDO $connection;

    private function __construct()
    {
        $host = 'host.docker.internal'; // or your database server host
        $db   = 'mydatabase';
        $user = 'myuser';
        $pass = 'mypassword';
        $charset = 'utf8mb4';
        $port = 3306;

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

    public static function getInstance(): DatabaseConnection
    {
        if (self::$instance === null) {
            self::$instance = new DatabaseConnection();
        }

        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}