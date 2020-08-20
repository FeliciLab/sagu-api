<?php

namespace App\DAO;

use App\Model\OfertaDeRodizioAtividade;
use Illuminate\Support\Facades\DB;

class OfertaDeRodizioAtividadeDAO
{

    /**
     * @param $id
     */
    public function getAtividadeDaOferta($id)
    {
        $select = DB::select('SELECT * FROM med.temadaunidadetematica WHERE ofertadeunidadetematicaid = :ofertadeunidadetematicaid', ['ofertadeunidadetematicaid' => $id]);

        $ofertaDeRodizioAtividades = [];

        if (count($select)) {

            foreach ($select as $SelectOfertaDeRodizioAtividade) {
                $ofertaDeRodizioAtividade = new OfertaDeRodizioAtividade();

                $atividadeDao = new AtividadeDAO();
                $atividade = $atividadeDao->get($SelectOfertaDeRodizioAtividade->temaid);
                $ofertaDeRodizioAtividade->setAtividade($atividade);

                $ofertaDeRodizioAtividade->setCargaHoraria($SelectOfertaDeRodizioAtividade->cargahoraria);

                $ofertaDeRodizioAtividades[] = $ofertaDeRodizioAtividade;
            }
        }

        return $ofertaDeRodizioAtividades;
    }
}