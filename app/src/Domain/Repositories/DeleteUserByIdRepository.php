<?php

declare(strict_types=1);

namespace Bahge\App\Domain\Repositories;

interface DeleteUserByIdRepository
{
    public function deleteUserByIdRepository(int $id):array;
}