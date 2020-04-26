<?php
use DI\Container;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use App\Controller\MainController;

require __DIR__ . '/../vendor/autoload.php';

session_start();

$container = new Container();
$container->set('MainController', fn(ContainerInterface $c) => new MainController($c));
$app = AppFactory::createFromContainer($container);
$app->get('/', \MainController::class . ':main');

$app->group('/api/v1', function (RouteCollectorProxy $group) {
    $group->get('/{controller}', \MainController::class)->setArgument("action", "get_collection");
    $group->get('/{controller}/{id:[0-9]+}', \MainController::class)->setArgument("action", "get_collection");
    $group->post('/{controller}/{id:[0-9]+}/{action}', \MainController::class);
    $group->get('/{controller}/{action}', \MainController::class);
    $group->post('/{controller}/{action}', \MainController::class);
})->add(function (Request $request, RequestHandler $handler) {
    return $handler->handle($request)->withHeader('Content-Type', 'application/json');
});

$app->run();
