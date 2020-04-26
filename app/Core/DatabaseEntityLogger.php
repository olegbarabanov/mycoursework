<?php

namespace App\Core;

use App\Repository\HistoryItem;
use App\Repository\HistoryRepository;
use SplObserver;
use SplSubject;

class DatabaseEntityLogger implements SplObserver
{

    protected HistoryRepository $repository;

    public function __construct(HistoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function update(SplSubject $subject, $event = null, $data = null): void
    {
        $item = new HistoryItem;
        $item->name = $event;
        $item->table = $subject->getDatabaseTable();
        $item->data = json_encode($data, JSON_UNESCAPED_UNICODE);
        $this->repository->insert($item);
    }

}
