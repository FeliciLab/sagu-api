<?php

namespace App\DAO;

use App\Model\DiarioDeCampo;
use App\Model\DiarioDeCampoPreceptor;
use Illuminate\Support\Facades\DB;

class DiarioDeCampoPreceptorDAO
{

    /**
     * @param $id
     * @return DiarioDeCampoPreceptor
     */
    public function get($id)
    {
        $select = DB::select('SELECT * FROM med.diariodecampopreceptor WHERE diariodecampopreceptorid = :diariodecampopreceptorid', ['diariodecampopreceptorid' => $id]);

        $diarioDeCampoPreceptor = new DiarioDeCampoPreceptor();

        if (count($select)) {
            $select = $select[0];
            $diarioDeCampoPreceptor->setId($select->diariodecampopreceptorid);
            $diarioDeCampoPreceptor->setInicio(new \DateTime($select->inicio));
            $diarioDeCampoPreceptor->setFim(new \DateTime($select->fim));
            $diarioDeCampoPreceptor->setCargaHoraria($select->cargahoraria);
            $diarioDeCampoPreceptor->setConteudoAbordado($select->conteudoabordado);
        }

        return $diarioDeCampoPreceptor;
    }

    public function diarioDeCampoPorPreceptorEOfertaDeRodizio($preceptorId, $ofertaDeRodizioId)
    {
        $select = DB::select('SELECT * FROM med.diariodecampopreceptor WHERE preceptorid = :preceptorid AND ofertadeunidadetematicaid = :ofertadeunidadetematicaid ORDER BY inicio', ['preceptorid' => $preceptorId, 'ofertadeunidadetematicaid' => $ofertaDeRodizioId]);

        $diarios = array();
        foreach ($select as $diario) {
            $diarios[] = $this->get($diario->diariodecampopreceptorid);
        }

        return $diarios;
    }

    public function save(DiarioDeCampoPreceptor $diarioDeCampoPreceptor)
    {
        if (!$diarioDeCampoPreceptor->getId()) {
            return $this->insert($diarioDeCampoPreceptor);
        } else {
            return $this->update($diarioDeCampoPreceptor);
        }



        return $diarioDeCampoPreceptor;
    }

    public function insert(DiarioDeCampoPreceptor $diarioDeCampoPreceptor)
    {
        $result = DB::insert('insert into med.diariodecampopreceptor  (inicio, fim, cargahoraria, conteudoabordado, ofertadeunidadetematicaid, preceptorid) values (?, ?, ?, ?, ?, ?)',
            [
                $diarioDeCampoPreceptor->getInicio(),
                $diarioDeCampoPreceptor->getFim(),
                $diarioDeCampoPreceptor->getCargaHoraria(),
                $diarioDeCampoPreceptor->getConteudoAbordado(),
                $diarioDeCampoPreceptor->getOfertaDeRodizio()->getId(),
                $diarioDeCampoPreceptor->getPreceptor()->getId()
            ]);

        if ( $result )  {
            $rowId = DB::connection()->getPdo()->lastInsertId();
            return $this->get($rowId);
        }
    }

    public function delete($id)
    {
        $result = DB::delete('DELETE FROM med.diariodecampopreceptor WHERE diariodecampopreceptorid = ?',
            [
                $id
            ]);

        return $result > 0 ? true : false;
    }

    public function update(DiarioDeCampoPreceptor $diarioDeCampoPreceptor)
    {
        DB::update('update med.diariodecampopreceptor set inicio = ?, fim = ?, cargahoraria = ?, conteudoabordado = ?, ofertadeunidadetematicaid = ?, preceptorid = ? where diariodecampopreceptorid = ?',
            [
                $diarioDeCampoPreceptor->getInicio(),
                $diarioDeCampoPreceptor->getFim(),
                $diarioDeCampoPreceptor->getCargaHoraria(),
                $diarioDeCampoPreceptor->getConteudoAbordado(),
                $diarioDeCampoPreceptor->getOfertaDeRodizio()->getId(),
                $diarioDeCampoPreceptor->getPreceptor()->getId(),
                $diarioDeCampoPreceptor->getId()
            ]);

        return $diarioDeCampoPreceptor;
    }
}