<?php

declare(strict_types=1);

namespace Bahge\App\Domain\Repositories;

interface MigrationsRepository
{
    public function exec():array;
}