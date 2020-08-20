<?php

namespace App\DAO;

use App\Model\DiarioDeCampo;
use Illuminate\Support\Facades\DB;

class DiarioDeCampoDAO
{

    /**
     * @param $id
     * @return DiarioDeCampo
     */
    public function get($id)
    {
        $select = DB::select('SELECT * FROM med.diariodecampo WHERE diariodecampoid = :diariodecampoid', ['diariodecampoid' => $id]);

        $diarioDeCampo = new DiarioDeCampo();

        if (count($select)) {
            $select = $select[0];
            $diarioDeCampo->setId($select->diariodecampoid);
            $diarioDeCampo->setInicio(new \DateTime($select->inicio));
            $diarioDeCampo->setFim(new \DateTime($select->fim));
            $diarioDeCampo->setCargaHoraria($select->cargahoraria);
            $diarioDeCampo->setConteudoAbordado($select->conteudoabordado);
            $diarioDeCampo->setMinistrante($select->ministrante);
        }

        return $diarioDeCampo;
    }

    public function diarioDeCampoPorResidenteEOfertaDeRodizio($residenteId, $ofertaDeRodizioId)
    {
        $select = DB::select('SELECT * FROM med.diariodecampo WHERE residenteid = :residenteid AND ofertadeunidadetematicaid = :ofertadeunidadetematicaid ORDER BY inicio', ['residenteid' => $residenteId, 'ofertadeunidadetematicaid' => $ofertaDeRodizioId]);

        $diarios = array();
        foreach ($select as $diario) {
            $diarios[] = $this->get($diario->diariodecampoid);
        }

        return $diarios;
    }

    public function save(DiarioDeCampo $diarioDeCampo)
    {
        if (!$diarioDeCampo->getId()) {
            return $this->insert($diarioDeCampo);
        } else {
            return $this->update($diarioDeCampo);
        }



        return $diarioDeCampo;
    }

    public function insert(DiarioDeCampo $diarioDeCampo)
    {
        $result = DB::insert('insert into med.diariodecampo  (inicio, fim, cargahoraria, conteudoabordado, ministrante, ofertadeunidadetematicaid, residenteid) values (?, ?, ?, ?, ?, ?, ?)',
            [
                $diarioDeCampo->getInicio(),
                $diarioDeCampo->getFim(),
                $diarioDeCampo->getCargaHoraria(),
                $diarioDeCampo->getConteudoAbordado(),
                $diarioDeCampo->getMinistrante(),
                $diarioDeCampo->getOfertaDeRodizio()->getId(),
                $diarioDeCampo->getResidente()->getId()
            ]);

        if ( $result )  {
            $rowId = DB::connection()->getPdo()->lastInsertId();
            return $this->get($rowId);
        }
    }

    public function delete($id)
    {
        $result = DB::delete('DELETE FROM med.diariodecampo WHERE diariodecampoid = ?',
            [
                $id
            ]);

        return $result > 0 ? true : false;
    }

    public function update(DiarioDeCampo $diarioDeCampo)
    {
        DB::update('update med.diariodecampo set inicio = ?, fim = ?, cargahoraria = ?, conteudoabordado = ?, ministrante = ?, ofertadeunidadetematicaid = ?, residenteid = ? where diariodecampoid = ?',
            [
                $diarioDeCampo->getInicio(),
                $diarioDeCampo->getFim(),
                $diarioDeCampo->getCargaHoraria(),
                $diarioDeCampo->getConteudoAbordado(),
                $diarioDeCampo->getMinistrante(),
                $diarioDeCampo->getOfertaDeRodizio()->getId(),
                $diarioDeCampo->getResidente()->getId(),
                $diarioDeCampo->getId()
            ]);

        return $diarioDeCampo;
    }
}