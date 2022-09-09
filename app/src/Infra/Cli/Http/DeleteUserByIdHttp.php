<?php

declare(strict_types=1);

namespace Bahge\App\Infra\Cli\Http;

use PDO;
use Bahge\App\Domain\User\UseCases\DeleteUserById\DeleteUserById;
use Bahge\App\Infra\Repositories\MySQL\User\PdoDeleteUserByIdRepository;

final class DeleteUserByIdHttp
{
    private PdoDeleteUserByIdRepository $repository;
    private DeleteUserById $usercase;
    private int $id;

    public function __construct(
        PDO $connection, int $id
    ) {
        $this->id = (int) $id;
        $this->repository = new PdoDeleteUserByIdRepository($connection);
        $this->usercase = new DeleteUserById($this->repository, $this->id);
    }

    public function handle():array
    {
        try {
            $output = $this->usercase->handle();

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