<?php

declare(strict_types=1);

namespace Bahge\App\Domain\UseCases\LoadUser;

use Exception;
use Bahge\App\Domain\Repositories\LoadUserRepository;
use DomainException;

final class LoadUser
{
    private LoadUserRepository $repository;

    public function __construct(LoadUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle():array
    {
        try {
            return $this->repository->loadUserRepository();
        } catch (Exception $e) {
            throw new DomainException($e->getMessage());
        }
    }

}