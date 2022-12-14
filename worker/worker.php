<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;


/**
 * Inicia a conexão
 */
$connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'pass');
$channel = $connection->channel();

/**
 * Declara qual a fila que será usada
 */
$channel->queue_declare('queue_master', false, false, false, false);

echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

/**
 * Função que vai receber e tratar efetivamente a mensagem
 */
$callback = function($msg) {
  echo " [x] Received ", $msg->body, "\n";
};

/**
 * Adiciona esse "callback" para a fila 
 */
$channel->basic_consume('queue_master', '', false, true, false, false, $callback);

/**
 * Mantem a função escutando a fila por tempo indeterminado, até que seja encerrada
 */
while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();