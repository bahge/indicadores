<?php

declare(strict_types=1);

namespace Bahge\App\Infra\Repositories\MySQL\User;

use PDO;
use PDOException;
use DomainException;
use Bahge\App\Domain\User\Entities\Equipe;
use Bahge\App\Domain\User\Repositories\UpdateUserByIdRepository;

final class PdoUpdateUserByIdRepository implements UpdateUserByIdRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function updateUserByIdRepository(Equipe $equipe, int $id):array
    {
        try {
            $stm = $this->pdo->prepare("UPDATE users 
            SET nome = :nome,
                email = :email, 
                senha = :senha, 
                habilitado = :habilitado
            WHERE id = :id");
        
            $stm->execute([
                'nome' => $equipe->getNome(),
                'email' => $equipe->getEmail(),
                'senha' => $equipe->getSenha(),
                'habilitado' => ( $equipe->getHabilitado() == 'Habilitado' ? 1 : 0 ),
                'id' => (int) $id
            ]);

            $update = $stm->rowCount();

            if ($update > 0 ) {
                return [
                    'id' => (int) $id,
                    'mensagem' => "Sucesso, usuário: " . $equipe->getEmail() . ", atualizado."
                ];
            }

            return [
                'mensagem' => "Nenhum usuário atualizado"
            ];

        } catch (PDOException $e) {
            throw new DomainException($e->getMessage());
        }
    }
}