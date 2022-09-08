<?php

declare(strict_types=1);

namespace Bahge\App\Infra\Cli\Http;

use PDO;
use Bahge\App\Domain\UseCases\LoadUserById\LoadUserById;
use Bahge\App\Infra\Repositories\MySQL\PdoLoadUserByIdRepository;

final class ReadUserByIdHttp
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
                return [
                    'data' => null,
                    'code' => 204
                ];
            }

            return [
                'data' => $output,
                'code' => 200
            ];
        } catch (\Exception $e) {
            return [
                'data' => [
                    'msg' => $e->getMessage()
                ],
                'code' => 400
            ];
        }
        
    }
}