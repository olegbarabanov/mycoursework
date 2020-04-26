<?php

namespace App\Core;

class Util
{

    /**
     * convert all empty items to null in array;
     *
     * @param array $data
     *
     * @return void
     */
    public static function clearEmpty(array $data)
    {
        return array_map(fn($v) => $v === "" ? null : $v, $data);
    }

}
