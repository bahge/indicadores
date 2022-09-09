<?php

declare(strict_types=1);

namespace Bahge\App\Domain\User\UseCases\LoadUser;

use Exception;
use Bahge\App\Domain\User\Repositories\LoadUserRepository;
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