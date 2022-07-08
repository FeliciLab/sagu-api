<?php

namespace App\DAO;

use App\Model\Person;
use Illuminate\Support\Facades\DB;

class DocumentoDAO
{

    public static function getContent($personId, $typeDocument)
    {
        $select = DB::select('SELECT * FROM basdocument WHERE personid = :personid AND documenttypeid = :documenttypeid LIMIT 1', 
            [
                'personid' => $personId,
                'documenttypeid' => $typeDocument
            ]
        );
        
        if (count($select)) {
            return $select[0]->content;
        }
    }

    public static function insertDocumento($personId, $tipoDocumento, $content)
    {
        return DB::insert("insert into basdocument (personid, documenttypeid, content, isDelivered) values (?, ? , ?, ?)", [
            $personId, 
            $tipoDocumento,
            $content,
            't'
        ]);
    }
}