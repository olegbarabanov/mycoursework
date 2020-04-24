<?php

namespace App\Core\Storage;

interface StorageInterface {

    /*
        Присутствие доступа
    */

    public function isAccess(): bool;

}
