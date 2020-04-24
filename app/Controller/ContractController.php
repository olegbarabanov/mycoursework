<?php

namespace App\Controller;

use App\Model\AbstractModel;
use App\View\AbstractView;
use App\Model\ContractModel;
use App\Repository\ContractRepository;
use App\View\Rest\ContractView;

class ContractController extends AbstractController
{

    protected function getDefaultModel(): AbstractModel
    {
        return new ContractModel(new ContractRepository($this->db, $this->fs));
    }
    
    protected function getDefaultView(AbstractModel $model): AbstractView
    {
        return new ContractView($model);
    }

}
