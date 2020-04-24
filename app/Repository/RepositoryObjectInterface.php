<?php

namespace App\Repository;

interface RepositoryObjectInterface {

    public function getRawData(): array;

    public function __set(string $name, $value);
    
    public function __get(string $name);

}
