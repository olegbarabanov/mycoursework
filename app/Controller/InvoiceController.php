<?php

namespace App\Controller;

use App\Model\AbstractModel;
use App\View\AbstractView;
use App\Model\InvoiceModel;
use App\Repository\InvoiceRepository;
use App\View\Rest\InvoiceView;

class InvoiceController extends AbstractController
{

    protected function getDefaultModel(): AbstractModel
    {
        return new InvoiceModel(new InvoiceRepository($this->db, $this->fs));
    }
    
    protected function getDefaultView(AbstractModel $model): AbstractView
    {
        return new InvoiceView($model);
    }

}
