<?php

namespace App\Controller;

use PDO;
use App\Model\AbstractModel;
use App\View\AbstractView;
use App\Core\Storage\FileStorageInterface;
use App\Core\Storage\DatabaseStorageInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

abstract class AbstractController
{

    protected DatabaseStorageInterface $db;
    protected FileStorageInterface $fs;

    public function __construct(DatabaseStorageInterface $db, FileStorageInterface $fs)
    {
        $this->db = $db;
        $this->fs = $fs;
    }

    abstract protected function getDefaultModel(): AbstractModel;
    abstract protected function getDefaultView(AbstractModel $model): AbstractView;

    public function getCollection(Request $request, Response $response, $args)
    {
        $model = $this->getDefaultModel();
        $view = $this->getDefaultView($model);
        $params = $request->getQueryParams();
        if (!empty($args["id"])) $params["id"] = $args["id"];
        return $view->output("getCollection", $model->getCollection($params));
    }

    public function insert(Request $request, Response $response, $args): array
    {
        $data = $request->getParsedBody();
        $model = $this->getDefaultModel();
        $view = $this->getDefaultView($model);
        return $view->output("insert", $model->insert($data));
    }

    public function update(Request $request, Response $response, $args): array
    {
        $data = $request->getParsedBody();
        $model = $this->getDefaultModel();
        $view = $this->getDefaultView($model);
        return $view->output("update", $model->update($data));
    }

    public function scheme(Request $request, Response $response, $args)
    {
        $model = $this->getDefaultModel();
        $view = $this->getDefaultView($model);
        $data = !empty($args["id"])
                ? $model->getScheme(["id" => $args["id"]])                           
                : $model->getScheme();
        return $view->output("scheme", $data);
    }

    public function delete(Request $request, Response $response, $args)
    {
        $model = $this->getDefaultModel();
        $view = $this->getDefaultView($model);
        return $view->output("delete", $model->delete($args["id"]));
    }

}
