<?php

namespace App\Controller;

use App\Model\AbstractModel;
use App\View\AbstractView;
use App\Model\ActModel;
use App\Repository\ActRepository;
use App\View\Rest\ActView;

class ActController extends AbstractController
{

    protected function getDefaultModel(): AbstractModel
    {
        return new ActModel(new ActRepository($this->db, $this->fs));
    }
    
    protected function getDefaultView(AbstractModel $model): AbstractView
    {
        return new ActView($model);
    }

}
