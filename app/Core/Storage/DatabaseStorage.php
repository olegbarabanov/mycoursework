<?php

namespace App\Core\Storage;

use PicoDb\Database;

class DatabaseStorage extends Database implements DatabaseStorageInterface  {

    public function isAccess():bool {
        return true;
    }

    public function mapArrayToObject(array $arr,object $obj){
        foreach ($arr as $prop => $value) $obj->$prop = $value;
        return $obj;
    }
  
}
