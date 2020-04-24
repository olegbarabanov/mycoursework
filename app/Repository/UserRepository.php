<?php

namespace App\Repository;

use App\Core\Storage\DatabaseStorageInterface;
use App\Core\Storage\DatabaseStorage;

class UserRepository extends AbstractRepository
{
    public function getDatabaseTable(): string {
        return "users";
    }

    public function getDataClass(): string {
        return User::class;
    }

    public function isAuth(string $email, string $password): bool {
        $table = $this->getDatabaseTable();
        $user = $this->db->table($table)->eq("email", $email)->findOne();
        return isset($user) && password_verify($password, $user["password"]);
    }

    public function getScheme(): array {
        return [
            "id" => ["name" => "Идентификатор", "type" => "numeric","min" => 0],
            "name" => ["name" => "Ф.И.О.", "type" => "text"],
            "password" => ["name" => "Пароль", "type" => "password"],
            "email" => ["name" => "Контактный email", "type" => "email"],
            "custom_info" => ["name" => "Прочая информация", "type" => "text", "multiple" => true]
        ];
    }
}
