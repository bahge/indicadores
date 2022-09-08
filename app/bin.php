<?php

use Bahge\App\Infra\Cli\Bin\MigrationsBin;
use Bahge\App\Infra\Connection\MysqlConnection;
use Bahge\App\Infra\Cli\Bin\ReadUserByIdBin;

require __DIR__ . '/vendor/autoload.php';

if ($argc == 1) {
    echo "Nenhum parâmetro encontrado." . PHP_EOL;
    exit;
} 

while ($function = current($argv)) {
    if ($function == '-id') {
        $id = (int) key($argv) + 1;
        echo ReadUserById($argv, $id);
        exit;
    }

    if ($function == '-m') {
        echo Migration();
        exit;
    }
    next($argv);
}
echo "Parâmetros inválidos" . PHP_EOL;
exit;

function ReadUserById(array $argv, int $id) {
    
    if (!array_key_exists($id, $argv)) return "Parâmetro Id não informado." . PHP_EOL;

    if ((int) $argv[$id] == 0) return "Id -{$argv[$id]}- inválido." . PHP_EOL;

    $cfg_pdo = new MysqlConnection();
    $readUserByIdHttp = new ReadUserByIdBin($cfg_pdo->getConnection(), $argv[$id]);

    try {
        $output = $readUserByIdHttp->handle();
        return makeReadUserByIdData($output['data'], $argv[$id]);
    } catch (Exception $e) {
        return $e->getMessage() . PHP_EOL;
    }
    
}

function makeReadUserByIdData($data, $id): string
{
    return "{$data['id']};{$data['nome']};{$data['email']};{$data['habilitado']}" . PHP_EOL;
}

function Migration() {

    $cfg_pdo = new MysqlConnection();
    $migration = new MigrationsBin($cfg_pdo->getConnection());

    try {
        $output = $migration->handle();
        return $output['data'];
    } catch (Exception $e) {
        return $e->getMessage() . PHP_EOL;
    }
    
}
