<?php

namespace App\Repository;

class ContractStageRepository extends AbstractRepository
{
    public function getDatabaseTable(): string {
        return "contract_stages";
    }

    public function getDataClass(): string {
        return ContractStage::class;
    }

    public function getScheme(): array {
        return [
            "id" => ["name" => "Идентификатор", "type" => "numeric","min" => 0],
            "name" => ["name" => "Стадии контракта", "type" => "text"]
        ];
    }
}
