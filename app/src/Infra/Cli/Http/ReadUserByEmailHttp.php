<?php

declare(strict_types=1);

namespace Bahge\App\Infra\Cli\Http;

use PDO;
use Bahge\App\Domain\User\UseCases\LoadUserByEmail\LoadUserByEmail;
use Bahge\App\Infra\Repositories\MySQL\User\PdoLoadUserByEmailRepository;
use Psr\Http\Message\ServerRequestInterface as Request;

final class ReadUserByEmailHttp
{
    private PdoLoadUserByEmailRepository $repository;
    private LoadUserByEmail $usercase;
    private Request $request;

    public function __construct(
        PDO $connection, Request $request
    ) {
        $this->request = $request;
        $this->repository = new PdoLoadUserByEmailRepository($connection);
        $this->usercase = new LoadUserByEmail($this->repository, $this->request);
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