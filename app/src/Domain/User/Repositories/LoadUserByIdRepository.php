<?php

declare(strict_types=1);

namespace Bahge\App\Domain\User\Repositories;

interface LoadUserByIdRepository
{
    public function loadUserByIdRepository(int $id):array;
}