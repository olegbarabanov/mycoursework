<?php

namespace App\View\Rest;

class UserView extends AbstractRestView
{
    public function getCollection(iterable $data) {
        array_walk($data, fn($item) => $item->password = null);
        return $data;
    }

    public function login(iterable $data) {
        return (bool) $data[0];
    }

    public function isAuth(iterable $data) {
        return (bool) $data[0];
    }
}
