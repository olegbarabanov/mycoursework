<?php

namespace App\Controller;

use App\Model\AbstractModel;
use App\View\AbstractView;
use App\Model\ContractTypeModel;
use App\Repository\ContractTypeRepository;
use App\View\Rest\ContractTypeView;

class ContractTypeController extends AbstractController
{

    protected function getDefaultModel(): AbstractModel
    {
        return new ContractTypeModel(new ContractTypeRepository($this->db, $this->fs));
    }
    
    protected function getDefaultView(AbstractModel $model): AbstractView
    {
        return new ContractTypeView($model);
    }

}
