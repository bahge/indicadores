<?php

declare(strict_types=1);

namespace Bahge\App\Domain\Repositories;

use Bahge\App\Domain\Entities\Equipe;


interface SaveUserRepository
{
    public function saveUserRepository(Equipe $equipe):array;
}