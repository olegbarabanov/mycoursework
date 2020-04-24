<?php

namespace App\Repository;

class RoleRepository extends AbstractRepository
{
    public function getDatabaseTable(): string {
        return "roles";
    }

    public function getDataClass(): string {
        return Role::class;
    }

    public function getScheme(): array {
        return [
            "id" => ["name" => "Идентификатор", "type" => "numeric","min" => 0],
            "name" => ["name" => "Роль сотрудника", "type" => "text"]
        ];
    }
}
