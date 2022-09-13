<?php

declare(strict_types=1);

namespace Bahge\App\Infra\Config;

final class Dotenv
{

    static function setEnviroments($path)
    {
        $enviroments = explode("\n", file_get_contents($path. "/.env"));

        foreach ($enviroments as $enviroment) {
            putenv($enviroment);
        }
    }
}