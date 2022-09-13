<?php

declare(strict_types=1);

namespace Bahge\App\Infra\Repositories\MySQL\User;

use PDO;
use PDOException;
use DomainException;
use Bahge\App\Domain\User\Entities\Equipe;
use Bahge\App\Domain\User\Repositories\SaveUserRepository;

final class PdoSaveUserRepository implements SaveUserRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function saveUserRepository(Equipe $equipe):array
    {
     
        try {
            $stm = $this->pdo->prepare("INSERT users 
            (nome, email, senha, habilitado)
            VALUES (:nome, :email, :senha, :habilitado)");
        
            $stm->execute([
                'nome' => $equipe->getNome(),
                'email' => $equipe->getEmail(),
                'senha' => $equipe->getSenha(),
                'habilitado' => ( $equipe->getHabilitado() == 'Habilitado' ? 1 : 0 )
            ]);

            $insert = $this->pdo->lastInsertId();

            if ($insert > 0 ) {
                return [
                    'id' => (int) $insert,
                    'mensagem' => "Sucesso, usuário: " . $equipe->getEmail() . ", registrado."
                ];
            }

        } catch (PDOException $e) {
            throw new DomainException($e->getMessage());
        }

    }
}