<?php

namespace App\Controller;

use App\Core\DatabaseEntityLogger;
use App\Model\AbstractModel;
use App\Model\ContractModel;
use App\Repository\ContractRepository;
use App\Repository\HistoryRepository;
use App\View\AbstractView;
use App\View\Rest\ContractView;

class ContractController extends AbstractController
{

    protected function getDefaultModel(): AbstractModel
    {
        $repository = new ContractRepository($this->db, $this->fs);
        $repository->attach(new DatabaseEntityLogger(new HistoryRepository($this->db, $this->fs)));
        return new ContractModel($repository);
    }

    protected function getDefaultView(AbstractModel $model): AbstractView
    {
        return new ContractView($model);
    }

}
