<?php
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;
use Slim\Routing\RouteCollectorProxy;

use App\Core\Storage\DatabaseStorage;
use App\Controller\AbstractController;
use Psr\Container\ContainerInterface;
use App\Core\Storage\FileStorage;

use PicoDb\Database;

require __DIR__ . '/../vendor/autoload.php';

session_start();

//$x = password_hash("admin", PASSWORD_DEFAULT);
//print_r($x);
//$res = password_verify("admin",'$2y$10$n/Z3LvTiCW4.nhKUOMyIZ.cmbzK0o/0/jveJ18aMVocKLjg5o7czG');
//var_dump($res);

//die();

class MainController
{

    protected const UNIQUE_SALT = "&54=3242342rcnn3vi43..2@#k";
    protected ContainerInterface $container;
    protected DatabaseStorage $db;
    protected FileStorage $fs;

    public function __construct(ContainerInterface $container) {
        $this->fs = new FileStorage(new SplFileInfo("../filestorage/"), static::UNIQUE_SALT);
        $this->db = new DatabaseStorage(["driver" => "sqlite", "filename" => "base.sqlite"]);
    }

    protected function makeController(string $controllerName, ...$args): ?AbstractController {
        $controllerName = "\App\\Controller\\"
                            . str_replace("_","",ucwords($controllerName,"_"))
                            . "Controller";
        try {
            return new $controllerName(...$args);
        } catch (Exception $e) {
            return null;
        }
    }

    public function main(Request $request, Response $response, $args) {
        $response->getBody()->write(file_get_contents("./index.html"));
        return $response;
    }

    public function __invoke(Request $request, Response $response, $args) {
        $method = lcfirst(str_replace("_", "", ucwords($args["action"], "_")));
        $controller = $this->makeController($args["controller"], $this->db,$this->fs);

        $data = $controller->$method($request, $response, $args);
        $response->getBody()->write(json_encode($data, JSON_UNESCAPED_UNICODE));
        return $response;
    }

}

$container = new Container();
$container->set('MainController', fn (ContainerInterface $c) => new MainController($c));
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