<?php

namespace App\Repository;

class ClientRepository extends AbstractRepository
{
    public function getDatabaseTable(): string {
        return "clients";
    }

    public function getDataClass(): string {
        return Client::class;
    }

    public function getScheme(): array {
        return [
            "id" => ["name" => "Идентификатор", "type" => "numeric","min" => 0],
            "name" => ["name" => "Клиент", "type" => "text"],
            "person" => ["name" => "Контактное лицо", "type" => "text"],
            "legal_address" => ["name" => "Юр. адрес", "type" => "text"],
            "physical_address" => ["name" => "Физический адрес", "type" => "text"],
            "reg_date" => ["name" => "Дата регистрации", "type" => "email"],
            "phone" => ["name" => "Контактный телефон", "type" => "tel"],
            "email" => ["name" => "Контактный email", "type" => "email"],
            "custom_info" => ["name" => "Прочая информация", "type" => "text", "multiple" => true]
        ];
    }
}
