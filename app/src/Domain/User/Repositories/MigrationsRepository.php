<?php

declare(strict_types=1);

namespace Bahge\App\Domain\User\Repositories;

interface MigrationsRepository
{
    public function exec():array;
}