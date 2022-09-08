<?php

declare(strict_types=1);

namespace Bahge\App\Domain\UseCases\Migrations;

use Exception;
use Bahge\App\Domain\Repositories\MigrationsRepository;

final class Migrations
{
    private MigrationsRepository $repository;

    public function __construct(MigrationsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle():array
    {
        try {
            return $this->repository->exec();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}