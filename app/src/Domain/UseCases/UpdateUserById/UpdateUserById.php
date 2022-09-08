<?php

declare(strict_types=1);

namespace Bahge\App\Domain\UseCases\UpdateUserById;

use Exception;
use DomainException;
use Bahge\App\Domain\Entities\Equipe;
use Bahge\App\Domain\Repositories\UpdateUserByIdRepository;
use Bahge\App\Domain\UseCases\UpdateUserById\InputBoundaryUpdateUser;

final class UpdateUserById
{
    private UpdateUserByIdRepository $repository;

    public function __construct(
        UpdateUserByIdRepository $repository
    ) {
      $this->repository = $repository;  
    }

    public function handle(InputBoundaryUpdateUser $input, int $id): array
    {
        $usuario = new Equipe();
        $usuario
            ->setNome($input->getNome())
            ->setEmail($input->getEmail())
            ->setSenha($input->getSenha())
            ->setHabilitado($input->getHabilitado());

        try {
            return $this->repository->updateUserByIdRepository($usuario, $id);
        } catch (Exception $e) {
            throw new DomainException($e->getMessage());
        }
        
    }
}