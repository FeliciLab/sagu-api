<?php

namespace App\DAO;

use App\Model\Encontro;
use App\Model\OfertaDeRodizio;
use Illuminate\Support\Facades\DB;

class EncontroDAO
{

    /**
     * @param $id
     * @return Encontro
     */
    public function get($id)
    {
        $select = DB::select('SELECT * FROM med.encontro WHERE encontroid = :encontroid', ['encontroid' => $id]);

        $encontro = new Encontro();

        if (count($select)) {
            $select = $select[0];

            $atividadeDao = new AtividadeDAO();
            $ofertaDeRodizioDao = new OfertaDeRodizioDAO();

            $encontro->setId($select->encontroid);
            $encontro->setAtividade($atividadeDao->get($select->temaid));
            $inicio = new \DateTime($select->inicio);
            $encontro->setInicio($inicio->format('d/m/Y H:i'));
            $fim = new \DateTime($select->fim);
            $encontro->setFim($fim->format('d/m/Y H:i'));
            $encontro->setCargaHoraria($select->cargahoraria);
            $encontro->setConteudoMinistrado($select->conteudoministrado);
            $encontro->setOfertaDeRodizio($ofertaDeRodizioDao->get($select->ofertadeunidadetematicaid));
        }

        return $encontro;
    }

    public function retornaEncontrosDaOfertaDeRodizio(OfertaDeRodizio $ofertaDeRodizio)
    {
        $select = DB::select('SELECT * FROM med.encontro WHERE ofertadeunidadetematicaid = :ofertadeunidadetematicaid ORDER BY inicio', ['ofertadeunidadetematicaid' => $ofertaDeRodizio->getId()]);

        $encontros = array();
        foreach ($select as $encontro) {
            $encontros[] = $this->get($encontro->encontroid);
        }

        return $encontros;
    }
}