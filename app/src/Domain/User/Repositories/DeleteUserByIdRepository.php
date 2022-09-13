<?php

declare(strict_types=1);

namespace Bahge\App\Domain\User\Repositories;

interface DeleteUserByIdRepository
{
    public function deleteUserByIdRepository(int $id):array;
}