<?php

declare(strict_types=1);

namespace Bahge\App\Domain\User\Entities;

use Bahge\App\Domain\User\ValueObject\Email;

final class Equipe
{
    private int $id;
    private string $nome;
    private Email $email;
    private string $senha;
    private bool $habilitado;

    public function getNome():string
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
        return (string) $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = new Email($email);

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
        if ($this->habilitado == true) {
            return "Habilitado";
        }
        return "Desabilitado";
    }

    public function setHabilitado($habilitado)
    {
        $this->habilitado = $habilitado;

        return $this;
    }

    public function __toString()
    {
        return (string) "$this->nome;$this->email;$this->senha;" . $this->getHabilitado();
    }
 
    public function getId()
    {
        return $this->id;
    }
 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}