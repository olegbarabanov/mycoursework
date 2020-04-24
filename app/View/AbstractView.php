<?php

namespace App\View;

use App\Model\AbstractModel;

abstract class AbstractView {

    public function __construct(AbstractModel $model) {
        $this->model = $model;
    }

    public function output(string $handler, array $data = []) {
        return method_exists($this, $handler) ? $this->$handler($data) : $data;
    }

}
