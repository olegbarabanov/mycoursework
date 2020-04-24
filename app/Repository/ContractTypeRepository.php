<?php

namespace App\Repository;

class ContractTypeRepository extends AbstractRepository
{
    public function getDatabaseTable(): string {
        return "contract_types";
    }

    public function getDataClass(): string {
        return ContractType::class;
    }

    public function getScheme(): array {
        return [
            "id" => ["name" => "Идентификатор", "type" => "numeric","min" => 0],
            "name" => ["name" => "Тип договора", "type" => "text"]
            ];
    }
}
