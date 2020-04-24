<?php

namespace App\Repository;

class ContractRepository extends AbstractRepository
{
    public function getDatabaseTable(): string {
        return "contracts";
    }

    public function getDataClass(): string {
        return Contract::class;
    }

    public function getScheme(?int $id = null): array {
        return [
            "id" => ["name" => "Идентификатор", "type" => "numeric","min" => 0],
            "name" => ["name" => "Наименование договора", "type" => "text"],
            "reg_date" => ["name" => "Дата регистрации", "type" => "date"],
            "end_date" => ["name" => "Дата планируемого завершения", "type" => "date"],
            "contract_type_id" => ["name" => "Тип договора", "type" => "select", "entity" => "contract_type"],
            "tech_spec" => ["name" => "Тех. задание", "type" => "file"],
            "client" => ["name" => "Клиент", "type" => "select", "entity" => "client"],
            "user" => ["name" => "Сотрудник", "type" => "select", "entity" => "user"],
            "act" => ["name" => "Закрывающий акт выполненных работ", "type" => "select", "entity" => "act"],
            "stage" => ["name" => "Стадия", "type" => "select", "entity" => "contract_stage"],
            "invoice" => ["name" => "Итоговый счет", "type" => "select", "entity" => "invoice"],
            "custom_info" => ["name" => "Прочая информация", "type" => "text", "multiple" => true]
        ];
    }
}
