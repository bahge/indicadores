<?php

declare(strict_types=1);

namespace Bahge\App\Domain\Repositories;

use Bahge\App\Domain\Entities\Equipe;


interface UpdateUserByIdRepository
{
    public function updateUserByIdRepository(Equipe $equipe, int $id):array;
}