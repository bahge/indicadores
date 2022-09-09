<?php

declare(strict_types=1);

namespace Bahge\App\Domain\User\UseCases\SaveUser;


final class OutputBoundarySaveUser
{
    private int $id;
    private string $mensagem;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getMensagem()
    {
        return $this->mensagem;
    }

    public function setMensagem($mensagem)
    {
        $this->mensagem = $mensagem;

        return $this;
    }
}