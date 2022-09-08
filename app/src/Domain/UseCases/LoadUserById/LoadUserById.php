<?php

declare(strict_types=1);

namespace Bahge\App\Domain\UseCases\LoadUserById;

use Exception;
use Bahge\App\Domain\Repositories\LoadUserByIdRepository;

final class LoadUserById
{
    private LoadUserByIdRepository $repository;
    private int $id;

    public function __construct(LoadUserByIdRepository $repository, int $id)
    {
        $this->repository = $repository;
        $this->id = (int) $id;
    }

    public function handle():array
    {
        try {
            return $this->repository->loadUserByIdRepository($this->id);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

}