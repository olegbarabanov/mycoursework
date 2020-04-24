<?php

namespace App\Model;

use App\Repository\AbstractRepository;

class UserModel extends AbstractModel
{
    public function __construct(AbstractRepository $repository){
        $_SESSION["authLogin"] ??= false;
        parent::__construct($repository);
    }

    public function isAuth(): bool {
        return (bool) $_SESSION["authLogin"];
    }

    public function logout(): void {
        unset($_SESSION["authLogin"]);
    }

    public function insert(iterable $data): iterable {
        if (empty($data)) {
            $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);
        }

        parent::insert($data);
    }

    public function update(iterable $data): iterable {
        if (empty($data)) {
            $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);
        }

        parent::update($data);
    }

    public function login(string $email, string $password): bool {
        $auth = $this->repository->isAuth($email, $password);
        return $auth && $_SESSION["authLogin"] = $email;
    }
}
