<?php

declare(strict_types=1);

namespace Bahge\App\Domain\UseCases\SaveUser;

use Bahge\App\Domain\Entities\Equipe;
use Bahge\App\Domain\Repositories\SaveUserRepository;
use Bahge\App\Domain\UseCases\SaveUser\InputBoundarySaveUser;
use Bahge\App\Domain\UseCases\SaveUser\OutputBoundarySaveUser;
use DomainException;
use Exception;

final class SaveUser
{
    private SaveUserRepository $repository;

    public function __construct(
        SaveUserRepository $repository
    ) {
      $this->repository = $repository;  
    }

    public function handle(InputBoundarySaveUser $input): OutputBoundarySaveUser
    {
        $usuario = new Equipe();
        $usuario
            ->setNome($input->getNome())
            ->setEmail($input->getEmail())
            ->setSenha($input->getSenha())
            ->setHabilitado($input->getHabilitado());

        $return = new OutputBoundarySaveUser();
        try {
            $output = $this->repository->saveUserRepository($usuario);
            return $return->setId($output['id'])->setMensagem($output['mensagem']);
        } catch (Exception $e) {
            throw new DomainException($e->getMessage());
        }
        
    }
}