<?php

declare(strict_types=1);

namespace Bahge\App\Infra\Repositories\MySQL\Migrations;

class CreateUser
{
    const CREATE = "CREATE TABLE `users` (
      `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
      `nome` varchar(80) NOT NULL,
      `email` varchar(80) NOT NULL UNIQUE,
      `senha` varchar(80) NOT NULL,
      `habilitado` int(11) DEFAULT '0',
      `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `modified_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    public static function getSQL()
    {
        return self::CREATE;
    }


}