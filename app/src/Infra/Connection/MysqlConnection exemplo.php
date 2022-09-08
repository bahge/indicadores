<?php

declare(strict_types=1);

namespace Bahge\App\Infra\Connection;

use PDO;

final class MysqlConnection
{
    private PDO $conn;

    private string $host = 'mysql-db';
    private string $pass = '';
    private string $user = '';
    private string $database = '';

    public function __construct()
    {
        $this->conn = new PDO("mysql:host={$this->host};
        dbname={$this->database}", $this->user, $this->pass,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
