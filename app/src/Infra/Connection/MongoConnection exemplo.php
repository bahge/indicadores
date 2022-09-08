<?php

declare(strict_types=1);

namespace Bahge\App\Infra\Connection;

use MongoDB\Client as Mongo;

final class MongoConnection
{
    private $conn;

    private string $pass = '';
    private string $user = '';
    private string $port = '';

    public function __construct()
    {
        $this->conn = new Mongo("mongodb://{$this->user}:{$this->pass}@mongo:{$this->port}/?authSource=admin");
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
