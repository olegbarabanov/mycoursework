<?php

namespace App\Controller;

use App\Model\AbstractModel;
use App\View\AbstractView;
use App\Model\RoleModel;
use App\Repository\RoleRepository;
use App\View\Rest\RoleView;

class RoleController extends AbstractController
{

    protected function getDefaultModel(): AbstractModel
    {
        return new RoleModel(new RoleRepository($this->db, $this->fs));
    }
    
    protected function getDefaultView(AbstractModel $model): AbstractView
    {
        return new RoleView($model);
    }

}
