<?php

declare(strict_types=1);

namespace Bahge\App\Infra\Repositories\MySQL;

use PDO;
use PDOException;
use DomainException;
use Bahge\App\Domain\Repositories\LoadUserByIdRepository;

final class PdoLoadUserByIdRepository implements LoadUserByIdRepository
{
    private PDO $pdo;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function loadUserByIdRepository(int $id):array
    {
        try {
            $stm = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
            $stm->execute(['id' => $id]);
        
            return $stm->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            throw new DomainException($e->getMessage());
        }
    }
}