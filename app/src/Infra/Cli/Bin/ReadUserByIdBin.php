<?php

declare(strict_types=1);

namespace Bahge\App\Infra\Cli\Bin;

use PDO;
use Exception;
use Bahge\App\Domain\UseCases\LoadUserById\LoadUserById;
use Bahge\App\Infra\Repositories\MySQL\PdoLoadUserByIdRepository;

final class ReadUserByIdBin
{
    private PdoLoadUserByIdRepository $repository;
    private LoadUserById $usercase;
    private int $id;

    public function __construct(
        PDO $connection, int $id
    ) {
        $this->id = (int) $id;
        $this->repository = new PdoLoadUserByIdRepository($connection);
        $this->usercase = new LoadUserById($this->repository, $this->id);
    }

    public function handle():array
    {
        try {
            $output = $this->usercase->handle();

            if (is_array($output) && count($output) == 1) {
                $output = $output[0];
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