<?php

declare(strict_types=1);

namespace Bahge\App\Infra\Repositories\MySQL;

use PDO;
use PDOException;
use DomainException;
use Bahge\App\Domain\Repositories\DeleteUserByIdRepository;

final class PdoDeleteUserByIdRepository implements DeleteUserByIdRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function deleteUserByIdRepository(int $id):array
    {
        try {
            $stm = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
            if($stm->execute(['id' => (int) $id])) {
                return [
                    'mensagem' => "Usuário apagado."
                ];
            }
            return [
                'mensagem' => "Nenhum usuário apagado."
            ];
        } catch (PDOException $e) {
            throw new DomainException($e->getMessage());
        }
    }
}