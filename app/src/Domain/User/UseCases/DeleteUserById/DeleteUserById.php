<?php

declare(strict_types=1);

namespace Bahge\App\Domain\User\UseCases\DeleteUserById;

use Exception;
use Bahge\App\Domain\User\Repositories\DeleteUserByIdRepository;

final class DeleteUserById
{
    private DeleteUserByIdRepository $repository;
    private int $id;

    public function __construct(DeleteUserByIdRepository $repository, int $id)
    {
        $this->repository = $repository;
        $this->id = (int) $id;
    }

    public function handle():array
    {
        try {
            return $this->repository->deleteUserByIdRepository($this->id);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

}