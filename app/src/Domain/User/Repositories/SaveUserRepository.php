<?php

declare(strict_types=1);

namespace Bahge\App\Domain\User\Repositories;

use Bahge\App\Domain\User\Entities\Equipe;


interface SaveUserRepository
{
    public function saveUserRepository(Equipe $equipe):array;
}