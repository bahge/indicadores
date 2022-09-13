<?php

declare(strict_types=1);

namespace Bahge\App\Infra\Repositories\MySQL\User;

use PDO;
use PDOException;
use DomainException;
use Bahge\App\Domain\User\Repositories\LoadUserByEmailRepository;

final class PdoLoadUserByEmailRepository implements LoadUserByEmailRepository
{
    private PDO $pdo;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function loadUserByEmailRepository(string $email):array
    {
        try {
            $stm = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stm->execute(['email' => $email]);
        
            return $stm->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            throw new DomainException($e->getMessage());
        }
    }
}