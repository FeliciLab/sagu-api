<?php

namespace App\DAO\Basico;

use Illuminate\Support\Facades\DB;

class MioloCustomValueDAO
{
    const FIELD1 = 54;


    public static function getContent($personId, $field)
    {
        $select = DB::select('SELECT DISTINCT value FROM public.miolo_custom_value WHERE customized_id = :customized_id AND custom_field_id = :custom_field_id LIMIT 1', 
            [
                'customized_id' => $personId,
                'custom_field_id' => $field
            ]
        );
        
        if (count($select)) {
            return $select[0]->value;
        }
    }

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