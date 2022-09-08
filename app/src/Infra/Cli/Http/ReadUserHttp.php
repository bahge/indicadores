<?php

declare(strict_types=1);

namespace Bahge\App\Infra\Cli\Http;

use PDO;
use Bahge\App\Domain\UseCases\LoadUser\LoadUser;
use Bahge\App\Infra\Repositories\MySQL\PdoLoadUserRepository;

final class ReadUserHttp
{
    private PdoLoadUserRepository $repository;
    private LoadUser $usercase;

    public function __construct(
        PDO $connection
    ) {
        $this->repository = new PdoLoadUserRepository($connection);
        $this->usercase = new LoadUser($this->repository);
    }

    public function handle():array
    {
        try {
            $output = $this->usercase->handle();
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