<?php

namespace App\Repository;

trait RepositoryObjectTrait {

    public function getRawData(): array {
        return get_object_vars($this); 
    }

    public function __set(string $name, $value) {
        $this->$name = $value;
    }
    
    public function __get(string $name) {
        return $this->$name;
    }

}
