<?php

namespace App\DAO\ResidenciaMultiprofissional;

use App\Model\BaseModel\BaseModelSagu;
use App\Model\ResidenciaMultiprofissional\OfertaModuloNota;
use Illuminate\Support\Facades\DB;

class OfertaModuloNotaDAO
{
    public $model;

    public function __construct()
    {
        $this->model = new OfertaModuloNota();
    }

    public function get($residenteId, $ofertaId)
    {
        $select = DB::select(
            "SELECT * FROM {$this->model->getTable()} 
            WHERE residenteid = :residenteid 
              AND ofertadeunidadetematicaid = :ofertadeunidadetematicaid",
            [
                'residenteid' => $residenteId,
                'ofertadeunidadetematicaid' => $ofertaId
            ]
        );
        $ofertaModuloNota = new OfertaModuloNota();

        if (count($select)) {
            $select = $select[0];

            $ofertaModuloNota->id = $select->ofertadeunidadetematicanotasid;
            $ofertaModuloNota->residenteId = $select->residenteid;
            $ofertaModuloNota->ofertaId = $select->ofertadeunidadetematicaid;
            $ofertaModuloNota->semestre = $select->semestre;
            $ofertaModuloNota->notaDeAtividadeDeProduto = $select->notadeatividadedeproduto;
            $ofertaModuloNota->notaDeAvaliacaoDeDesempenho = $select->notadeavaliacaodedesempenho;
        }

        return $ofertaModuloNota;
    }

    public function insert(OfertaModuloNota $ofertaModuloNota)
    {
        $result = DB::insert("
                insert into {$this->model->getTable()}  
                    (residenteid, 
                     ofertadeunidadetematicaid, 
                     semestre, 
                     notadeatividadedeproduto, 
                     notadeavaliacaodedesempenho) 
                values (?, 
                        ?, 
                        ?, 
                        ?, 
                        ?)",
            [
                $ofertaModuloNota->residenteId,
                $ofertaModuloNota->ofertaId,
                $ofertaModuloNota->semestre,
                $ofertaModuloNota->notaDeAtividadeDeProduto,
                $ofertaModuloNota->notaDeAvaliacaoDeDesempenho
            ]);

        if ($result) {
            return $this->get($ofertaModuloNota->residenteId, $ofertaModuloNota->ofertaId);
        }

        return $result;
    }

    public function update(OfertaModuloNota $ofertaModuloNota)
    {
        $result = DB::update("
            UPDATE {$this->model->getTable()}
            SET 
                semestre = ?, 
                notadeatividadedeproduto = ?, 
                notadeavaliacaodedesempenho = ?
            WHERE residenteid = ?
              AND ofertadeunidadetematicaid = ?",
            [
                $ofertaModuloNota->semestre,
                $ofertaModuloNota->notaDeAtividadeDeProduto,
                $ofertaModuloNota->notaDeAvaliacaoDeDesempenho,
                $ofertaModuloNota->residenteId,
                $ofertaModuloNota->ofertaId
            ]);

        if ($result) {
            return $this->get($ofertaModuloNota->residenteId, $ofertaModuloNota->ofertaId);
        }

        return $result;
    }

    public function getNotasDoResidenteNaOferta($residenteId, $ofertaId)
    {
        $select = DB::select(
            "SELECT residenteid, ofertadeunidadetematicaid FROM {$this->model->getTable()} 
            WHERE residenteid = :residenteid 
              AND ofertadeunidadetematicaid = :ofertadeunidadetematicaid",
            [
                'residenteid' => $residenteId,
                'ofertadeunidadetematicaid' => $ofertaId
            ]
        );
        $residentesNotas = null;
        if (count($select)) {
            $residenteNota = $select[0];
            $residentesNotas = $this->get($residenteNota->residenteid, $residenteNota->ofertadeunidadetematicaid);
        }
        return $residentesNotas;
    }
}