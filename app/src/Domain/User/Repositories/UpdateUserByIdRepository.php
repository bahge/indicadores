<?php

declare(strict_types=1);

namespace Bahge\App\Domain\User\Repositories;

use Bahge\App\Domain\User\Entities\Equipe;


interface UpdateUserByIdRepository
{
    public function updateUserByIdRepository(Equipe $equipe, int $id):array;
}