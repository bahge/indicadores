<?php

use Slim\Factory\AppFactory;
use PhpAmqpLib\Message\AMQPMessage;
use Bahge\App\Infra\Cli\Http\ReadUserHttp;
use Bahge\App\Infra\Cli\Http\SaveUserHttp;
use Bahge\App\Infra\Cli\Http\ReadUserByIdHttp;
use Bahge\App\Infra\Connection\MysqlConnection;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Bahge\App\Infra\Cli\Http\DeleteUserByIdHttp;
use Bahge\App\Infra\Cli\Http\UpdateUserByIdHttp;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();
$app->addRoutingMiddleware();

/**
 * Add Error Middleware
 *
 * @param bool                  $displayErrorDetails -> Should be set to false in production
 * @param bool                  $logErrors -> Parameter is passed to the default ErrorHandler
 * @param bool                  $logErrorDetails -> Display error details in error log
 * @param LoggerInterface|null  $logger -> Optional PSR-3 Logger  
 *
 * Note: This middleware should be added last. It will not handle any exceptions/errors
 * for middleware added after it.
 */
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// Define app routes
$app->get('/equipe', function (Request $request, Response $response, $args) {

  $cfg_pdo = new MysqlConnection();
  $readUserHttp = new ReadUserHttp($cfg_pdo->getConnection());
  
  createMessage("Chamou equipe");

  $output = $readUserHttp->handle();

  return makeResponse($output, $response);

});

$app->get('/equipe/{id}', function (Request $request, Response $response, $args) {

  $cfg_pdo = new MysqlConnection();
  $readUserByIdHttp = new ReadUserByIdHttp($cfg_pdo->getConnection(), (int) $args['id']);

  $output = $readUserByIdHttp->handle();

  return makeResponse($output, $response); 

});

$app->delete('/equipe/{id}', function (Request $request, Response $response, $args) {

  $cfg_pdo = new MysqlConnection();
  $deleteUserByIdHttp = new DeleteUserByIdHttp($cfg_pdo->getConnection(), (int) $args['id']);

  $output = $deleteUserByIdHttp->handle();

  return makeResponse($output, $response); 

});

$app->put('/equipe/{id}', function (Request $request, Response $response, $args) {

  $cfg_pdo = new MysqlConnection();
  $updateUserByIdHttp = new UpdateUserByIdHttp($cfg_pdo->getConnection(), $request, (int) $args['id']);

  $output = $updateUserByIdHttp->handle();

  return makeResponse($output, $response);

});

$app->post('/equipe', function (Request $request, Response $response, $args) {
  
  $cfg_pdo = new MysqlConnection();
  $saveUserHttp = new SaveUserHttp($cfg_pdo->getConnection(), $request);
  
  $output = $saveUserHttp->handle();

  return makeResponse($output, $response);

});
// Run app
$app->run();


function makeResponse(array $output, Response $response)
{
  $response->getBody()->write(
    json_encode($output['data'])
  );
  return $response
    ->withHeader('Content-Type', 'application/json')
    ->withStatus($output['code']);
}

function createMessage(string $msg) {
   
  $connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'pass', '/');
  $channel = $connection->channel();
   
  $channel->queue_declare('queue_master', false, false, false, false);
   
  $msg = new AMQPMessage($msg);
   
  $channel->basic_publish($msg, '', 'queue_master');
   
  $channel->close();
  $connection->close();

}