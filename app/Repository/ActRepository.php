<?php

namespace App\Repository;

class ActRepository extends AbstractRepository
{
    public function getDatabaseTable(): string {
        return "acts";
    }

    public function getDataClass(): string {
        return Act::class;
    }

    public function getScheme(): array {
        return [
            "id" => ["name" => "Идентификатор", "type" => "numeric","min" => 0],
            "reg_date" => ["name" => "Дата регистрации", "type" => "date"],
            "file" => ["name" => "Файл", "type" => "file"]
        ];
    }
}
