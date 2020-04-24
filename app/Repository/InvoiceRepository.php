<?php

namespace App\Repository;

class InvoiceRepository extends AbstractRepository
{
    public function getDatabaseTable(): string {
        return "invoices";
    }

    public function getDataClass(): string {
        return Invoice::class;
    }

    public function getScheme(): array {
        return ["fields" => [
            "id" => ["name" => "Идентификатор", "type" => "numeric","min" => 0],
            "reg_date" => ["name" => "Дата выставления счета", "type" => "date"],
            "file" => ["name" => "Файл", "type" => "file"]
        ]];
    }

}
