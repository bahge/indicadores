<?php

declare(strict_types=1);

namespace Bahge\App\Domain\User\Repositories;

interface LoadUserByEmailRepository
{
    public function loadUserByEmailRepository(string $email):array;
}