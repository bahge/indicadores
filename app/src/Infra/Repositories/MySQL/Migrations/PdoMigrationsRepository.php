<?php

declare(strict_types=1);

namespace Bahge\App\Infra\Repositories\MySQL\Migrations;

use PDO;
use PDOException;
use DomainException;
use Bahge\App\Domain\User\Repositories\MigrationsRepository;

final class PdoMigrationsRepository implements MigrationsRepository
{
    private PDO $pdo;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function exec():array
    {
        try {
            $this->pdo->exec(CreateUser::CREATE);
            return ['data' => 'Tabela usuários criada com sucesso.'];

        } catch (PDOException $e) {
            throw new DomainException($e->getMessage());
        }
    }
}