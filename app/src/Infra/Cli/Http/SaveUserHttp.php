<?php

declare(strict_types=1);

namespace Bahge\App\Infra\Cli\Http;

use PDO;
use Bahge\App\Domain\User\UseCases\SaveUser\SaveUser;
use Psr\Http\Message\ServerRequestInterface as Request;
use Bahge\App\Domain\User\UseCases\SaveUser\InputBoundarySaveUser;
use Bahge\App\Infra\Repositories\MySQL\User\PdoSaveUserRepository;

final class SaveUserHttp
{
    private PdoSaveUserRepository $repository;
    private SaveUser $usercase;
    private Request $request;
    
    public function __construct(
        PDO $connection, Request $request
    ) {
        $this->repository = new PdoSaveUserRepository($connection);
        $this->usercase = new SaveUser($this->repository);
        $this->request = $request;
    }

    public function handle():array
    {
        $input = $this->makeInput();

        try {
            $output = $this->usercase->handle($input);

            if ($output->getId() > 0) {
                return [
                    'data' => [
                        'id' => $output->getId(), 
                        'msg' => $output->getMensagem()
                    ],
                    'code' => 201
                ];
            }

            return [
                'data' => [
                    'msg' => $output->getMensagem()
                ],
                'code' => 400
            ];

        } catch (\Exception $e) {
            return [
                'data' => [
                    $this->makeHumanErrors($e->getMessage())
                ],
                'code' => 400
            ];
        }
    }

    protected function makeInput():InputBoundarySaveUser
    {
        $req = json_decode((string) $this->request->getBody());
        $input = new InputBoundarySaveUser();
        $input
            ->setNome($req->nome)
            ->setEmail($req->email)
            ->setSenha($req->senha)
            ->setHabilitado($req->habilitado);
        return $input;
    }

    protected function makeHumanErrors(string $message):string
    {
        if (!strpos($message, 'SQLSTATE[23000]')) return 'E-mail já existe na base de dados';
        return $message;
    }
}