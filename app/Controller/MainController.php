<?php

namespace App\Controller;

use App\Controller\AbstractController;
use App\Core\Storage\DatabaseStorage;
use App\Core\Storage\FileStorage;
use DI\Container;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class MainController
{

    protected const UNIQUE_SALT = "&54=3242342rcnn3vi43..2@#k";
    protected const DEFAULT_TEMPLATE_PATH = "./index.html";
    protected ContainerInterface $container;
    protected DatabaseStorage $db;
    protected FileStorage $fs;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->fs = new FileStorage(new \SplFileInfo("../filestorage/"), static::UNIQUE_SALT);
        $this->db = new DatabaseStorage(["driver" => "sqlite", "filename" => "base.sqlite"]);
    }

    /**
     * Convert controller name from snake_case to CamelCase and return this controller
     *
     * @param string $controllerName
     * @param mixed ...$args
     *
     * @return void
     */
    protected function makeController(string $controllerName, ...$args): ?AbstractController
    {
        $controllerName = "\App\\Controller\\"
        . str_replace("_", "", ucwords($controllerName, "_"))
            . "Controller";
        try {
            return new $controllerName(...$args);
        } catch (Exception $e) {
            return null;
        }
    }


    public function main(Request $request, Response $response, $args)
    {
        $response->getBody()->write(file_get_contents(self::DEFAULT_TEMPLATE_PATH));
        return $response;
    }

    /**
     * Call it magic method when you need initialize default controller
     *
     * @param Request $request
     * @param Response $response
     * @param mixed $args
     *
     * @return void
     */
    public function __invoke(Request $request, Response $response, $args)
    {
        $method = lcfirst(str_replace("_", "", ucwords($args["action"], "_")));
        $controller = $this->makeController($args["controller"], $this->db, $this->fs);
        $data = $controller->$method($request, $response, $args);
        $response->getBody()->write(json_encode($data, JSON_UNESCAPED_UNICODE));
        return $response;
    }

}
