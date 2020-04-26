<?php

namespace App\Repository;

class HistoryRepository extends AbstractRepository
{
    public function getDatabaseTable(): string {
        return "history";
    }

    public function getDataClass(): string {
        return HistoryItem::class;
    }

    public function getScheme(): array {
        return [
            "id" => ["name" => "Идентификатор", "type" => "numeric","min" => 0],
            "name" => ["name" => "Название", "type" => "name"],
            "newdata" => ["name" => "Новое состояние", "type" => "text"],
            "date" => ["name" => "Дата", "type" => "date"]
        ];
    }
}
