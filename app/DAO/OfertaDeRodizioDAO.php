<?php

namespace App\DAO;

use App\Model\OfertaDeRodizio;
use Illuminate\Support\Facades\DB;

class OfertaDeRodizioDAO
{

    /**
     * @param $id
     * @return OfertaDeRodizio
     */
    public function get($id)
    {
        $select = DB::select('SELECT * FROM med.ofertadeunidadetematica WHERE ofertadeunidadetematicaid = :ofertadeunidadetematicaid', ['ofertadeunidadetematicaid' => $id]);

        $ofertaDeRodizio = new OfertaDeRodizio();

        if (count($select)) {
            $select = $select[0];

            $ofertaDeRodizio->setId($select->ofertadeunidadetematicaid);


            $rodizioDao = new RodizioDAO();
            $ofertaDeRodizio->setRodizio($rodizioDao->get($select->unidadetematicaid));

            $ofertaDeRodizio->setInicio($select->inicio);
            $ofertaDeRodizio->setFim($select->fim);

            $turmaDao = new TurmaDAO();
            $ofertaDeRodizio->setTurma($turmaDao->get($select->turmaid));


            $ofertaDeRodizioAtividadeDao = new OfertaDeRodizioAtividadeDAO();
            $ofertaDeRodizioAtividades = $ofertaDeRodizioAtividadeDao->getAtividadeDaOferta($select->ofertadeunidadetematicaid);
            $ofertaDeRodizio->setAtividades($ofertaDeRodizioAtividades);

            $ofertaDeRodizio->setEncerramento($select->encerramento);
            $ofertaDeRodizio->setAcompanhamentoEncontro($select->acompanhamentoencontro);

        }

        return $ofertaDeRodizio;
    }
}