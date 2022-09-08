<?php

declare(strict_types=1);

namespace Bahge\App\Domain\UseCases\SaveUser;


final class InputBoundarySaveUser
{
    private string $nome;
    private string $email;
    private string $senha;
    private bool $habilitado;

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;

        return $this;
    }

    public function getHabilitado()
    {
        return $this->habilitado;
    }

    public function setHabilitado($habilitado)
    {
        $this->habilitado = $habilitado;

        return $this;
    }
}