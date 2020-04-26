<?php

namespace App\Controller;

use App\Model\AbstractModel;
use App\Model\HistoryModel;
use App\Repository\HistoryRepository;
use App\View\AbstractView;
use App\View\Rest\HistoryView;

class HistoryController extends AbstractController
{

    protected function getDefaultModel(): AbstractModel
    {
        return new HistoryModel(new HistoryRepository($this->db, $this->fs));
    }

    protected function getDefaultView(AbstractModel $model): AbstractView
    {
        return new HistoryView($model);
    }

}
