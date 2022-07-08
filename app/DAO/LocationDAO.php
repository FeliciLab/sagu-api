<?php

namespace App\DAO;

use Illuminate\Support\Facades\DB;

class LocationDAO
{

    public static function getCidadeIdPorCep($cep)
    {
        $select = DB::select('SELECT * FROM baslocation WHERE zipcode = :zipcode LIMIT 1', 
            [
                'zipcode' => $cep
            ]
        );
        
        if (count($select)) {
            return $select[0]->cityid;
        }

        return false;
    }
}