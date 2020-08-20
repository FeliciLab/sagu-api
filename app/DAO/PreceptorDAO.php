<?php

namespace App\DAO;

use App\Model\Preceptor;
use Illuminate\Support\Facades\DB;

class PreceptorDAO
{

    /**
     * @param $id
     * @return Preceptor
     */
    public function get($id)
    {
        $select = DB::select('SELECT * FROM med.preceptoria WHERE preceptorid = :preceptorid', ['preceptorid' => $id]);

        $preceptor = new Preceptor();

        if (count($select)) {
            $select = $select[0];

            $preceptor->setId($select->preceptorid);


            $personDao = new PersonDAO();
            $preceptor->setPerson($personDao->get($select->personid));
        }

        return $preceptor;
    }

    public function retornaOfertasDeRodizioDoPreceptor($preceptorId)
    {
        $preceptor = $this->get($preceptorId);

        $ofertaDeRodizioPreceptorDao = new OfertaDeRodizioPreceptorDAO();
        return $ofertaDeRodizioPreceptorDao->retornaOfertasDeRodizioDoPreceptor($preceptor);
    }
}