<?php

declare(strict_types=1);

namespace Bahge\App\Infra\Cli\Http;

use Bahge\App\Domain\UseCases\UpdateUserById\InputBoundaryUpdateUser;
use Bahge\App\Domain\UseCases\UpdateUserById\UpdateUserById;
use Bahge\App\Infra\Repositories\MySQL\PdoUpdateUserByIdRepository;
use PDO;
use Psr\Http\Message\ServerRequestInterface as Request;

final class UpdateUserByIdHttp
{
    private PdoUpdateUserByIdRepository $repository;
    private UpdateUserById $useCase;
    private Request $request;
    private int $id;

    public function __construct(
        PDO $connection,
        Request $request,
        int $id
    ) {
        $this->repository = new PdoUpdateUserByIdRepository($connection);
        $this->useCase = new UpdateUserById($this->repository);
        $this->request = $request;
        $this->id = (int) $id;
    }

    public function handle():array
    {
        $input = $this->makeInput();

        try {
            $output = $this->useCase->handle($input, $this->id);

            if (isset($output['id'])) {
                return [
                    'data' => [
                        'id' => $output['id'], 
                        'msg' => $output['mensagem']
                    ],
                    'code' => 201
                ];
            }

            return [
                'data' => [
                    'msg' => $output['mensagem']
                ],
                'code' => 400
            ];

        } catch (\Exception $e) {
            return [
                'data' => [
                    $e->getMessage()
                ],
                'code' => 400
            ];
        }
    }

    protected function makeInput():InputBoundaryUpdateUser
    {
        $req = json_decode((string) $this->request->getBody());
        $input = new InputBoundaryUpdateUser();
        $input
            ->setNome($req->nome)
            ->setEmail($req->email)
            ->setSenha($req->senha)
            ->setHabilitado($req->habilitado);
        return $input;
    }
}