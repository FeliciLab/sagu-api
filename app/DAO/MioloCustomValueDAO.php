<?php

namespace App\DAO;

use Illuminate\Support\Facades\DB;

class MioloCustomValueDAO
{
    const FIELD1 = 54;
    const FIELD2 = 41;

    public static function insert($personId, $value)
    {
        $result = DB::insert('insert into public.miolo_custom_value (customized_id, custom_field_id, value) values (?, ?, ?)',
            [
                $personId,
                self::FIELD1,
                $value
            ]);
    }
}