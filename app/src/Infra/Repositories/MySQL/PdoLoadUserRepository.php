<?php

declare(strict_types=1);

namespace Bahge\App\Infra\Repositories\MySQL;

use PDO;
use PDOException;
use DomainException;
use Bahge\App\Domain\Repositories\LoadUserRepository;

final class PdoLoadUserRepository implements LoadUserRepository
{
    private PDO $pdo;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function loadUserRepository():array
    {
        try {
            $stm = $this->pdo->prepare("SELECT * FROM users WHERE habilitado = 1");
            $stm->execute();
        
            return $stm->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            throw new DomainException($e->getMessage());
        }
    }
}