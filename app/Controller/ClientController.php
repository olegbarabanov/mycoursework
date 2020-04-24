<?php

namespace App\Controller;

use App\Model\AbstractModel;
use App\View\AbstractView;
use App\Model\ClientModel;
use App\Repository\ClientRepository;
use App\View\Rest\ClientView;

class ClientController extends AbstractController
{

    protected function getDefaultModel(): AbstractModel
    {
        return new ClientModel(new ClientRepository($this->db, $this->fs));
    }
    
    protected function getDefaultView(AbstractModel $model): AbstractView
    {
        return new ClientView($model);
    }

}
