<?php

declare(strict_types=1);

namespace Bahge\App\Domain\User\UseCases\LoadUserByEmail;

use Exception;
use Psr\Http\Message\ServerRequestInterface as Request;
use Bahge\App\Domain\User\Repositories\LoadUserByEmailRepository;

final class LoadUserByEmail
{
    private LoadUserByEmailRepository $repository;
    private Request $request;
    private string $email;

    public function __construct(LoadUserByEmailRepository $repository, Request $request)
    {
        $this->repository = $repository;
        $this->request = $request;
    }

    public function handle():array
    {
        try {
            $req = json_decode((string) $this->request->getBody());

            if (!isset($req->email)) {
                throw new Exception("E-mail é um campo obrigatório");
            }

            if (!isset($req->senha)) {
                throw new Exception("Senha é um campo obrigatório");
            }

            $output = $this->repository->loadUserByEmailRepository($req->email);

            if (isset($output[0]['senha'])) {
                unset($output[0]['senha']);
            }

            return $output;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

}