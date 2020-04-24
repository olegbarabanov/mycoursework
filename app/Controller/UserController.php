<?php

namespace App\Controller;

use App\Model\AbstractModel;
use App\View\AbstractView;
use App\Model\UserModel;
use App\Repository\UserRepository;
use App\View\Rest\UserView;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class UserController extends AbstractController
{

    protected function getDefaultModel(): AbstractModel
    {
        return new UserModel(new UserRepository($this->db, $this->fs));
    }
    
    protected function getDefaultView(AbstractModel $model): AbstractView
    {
        return new UserView($model);
    }

    public function isAuth(Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $model = $this->getDefaultModel();
        $view = $this->getDefaultView($model);
        return $view->output("isAuth", [$model->isAuth()]);
    }

    public function login(Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $model = $this->getDefaultModel();
        $view = $this->getDefaultView($model);
        return $view->output("login", [$model->login($data["email"], $data["password"])]);
    }

    public function logout(Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $model = $this->getDefaultModel();
        $view = $this->getDefaultView($model);
        return $view->output("logout", [$model->logout()]);
    }

}
