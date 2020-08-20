<?php

namespace App\DAO;

use App\Model\Preceptor;
use Illuminate\Support\Facades\DB;

class OfertaDeRodizioPreceptorDAO
{


    public function retornaOfertasDeRodizioDoPreceptor(Preceptor $preceptor)
    {
        $select = DB::select('
            SELECT * FROM med.ofertadeunidadetematicapreceptor A 
            INNER JOIN med.ofertadeunidadetematica B 
              ON A.ofertadeunidadetematicaid = B.ofertadeunidadetematicaid
            WHERE preceptorid = :preceptorid
            ORDER BY inicio
        '
        , ['preceptorid' => $preceptor->getId()]);


        $ofertasDeRodiziosDoPreceptor = array();
        foreach ($select as $ofertaDeRodizio) {

            $ofertaDeRodizioDao = new OfertaDeRodizioDAO();

            $ofertaDeRodizio = $ofertaDeRodizioDao->get($ofertaDeRodizio->ofertadeunidadetematicaid);
            if ($ofertaDeRodizio->getEncerramento() == null) {
                $ofertasDeRodiziosDoPreceptor[] = $ofertaDeRodizio;
            }
        }

        return $ofertasDeRodiziosDoPreceptor;
    }
}