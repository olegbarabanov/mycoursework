<?php

namespace App\Repository;

interface RepositoryObjectPrototypeInterface {

    public function getRawData(): array;

    public function __set(string $name, $value);
    
    public function __get(string $name);

}
