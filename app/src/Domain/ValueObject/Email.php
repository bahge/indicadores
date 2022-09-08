<?php

declare(strict_types=1);

namespace Bahge\App\Domain\ValueObject;

use DomainException;

final class Email
{
    private string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
        $this->ehValido();
        return $this;
    }

    private function ehValido()
    {
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } 

        throw new DomainException("E-mail inválido");
    }

    public function __toString()
    {
        return $this->email;
    }
}