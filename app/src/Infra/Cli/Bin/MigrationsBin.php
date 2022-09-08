<?php

declare(strict_types=1);

namespace Bahge\App\Infra\Cli\Bin;

use PDO;
use Exception;
use Bahge\App\Domain\UseCases\Migrations\Migrations;
use Bahge\App\Infra\Repositories\MySQL\Migrations\PdoMigrationsRepository;

final class MigrationsBin
{
    private PdoMigrationsRepository $repository;
    private Migrations $usercase;

    public function __construct(
        PDO $connection
    ) {
        $this->repository = new PdoMigrationsRepository($connection);
        $this->usercase = new Migrations($this->repository);
    }

    public function handle():array
    {
        try {
            $output = $this->usercase->handle();

            if (is_array($output) && count($output) == 1) {
                $output = $output['data'];
            }

            if (empty($output)) {
                throw new Exception("Nenhum valor encontrado.");
            }

            return [
                'data' => $output
            ];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        
    }
}