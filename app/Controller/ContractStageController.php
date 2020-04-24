<?php

namespace App\Controller;

use App\Model\AbstractModel;
use App\View\AbstractView;
use App\Model\ContractStageModel;
use App\Repository\ContractStageRepository;
use App\View\Rest\ContractStageView;

class ContractStageController extends AbstractController
{

    protected function getDefaultModel(): AbstractModel
    {
        return new ContractStageModel(new ContractStageRepository($this->db, $this->fs));
    }
    
    protected function getDefaultView(AbstractModel $model): AbstractView
    {
        return new ContractStageView($model);
    }

}
