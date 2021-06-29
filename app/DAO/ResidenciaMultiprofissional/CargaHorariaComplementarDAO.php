<?php

namespace App\DAO\ResidenciaMultiprofissional;

use App\Model\BaseModel\BaseModelSagu;
use App\Model\ResidenciaMultiprofissional\CargaHorariaComplementar;
use App\Model\ResidenciaMultiprofissional\OfertaModuloFalta;
use Illuminate\Support\Facades\DB;

class CargaHorariaComplementarDAO
{
    private $model;
    private $cargaHorariaComplementarTipoDAO;

    public function __construct()
    {
        $this->model = new CargaHorariaComplementar();
        $this->cargaHorariaComplementarTipoDAO = new CargaHorariaComplementarTipoDAO();
    }

    public function get($id)
    {
        $select = DB::select(
            "SELECT * FROM {$this->model->getTable()} 
            WHERE cargahorariacomplementarid = :cargahorariacomplementarid",
            [
                'cargahorariacomplementarid' => $id
            ]
        );
        $cargaHorariaComplementar = new CargaHorariaComplementar();

        if (count($select)) {
            $select = $select[0];

            $cargaHorariaComplementar->id = $select->cargahorariacomplementarid;
            $cargaHorariaComplementar->tipoCargaHorariaComplementar = $this->cargaHorariaComplementarTipoDAO->get($select->tipodecargahorariacomplementarid);
            $cargaHorariaComplementar->residente = $select->residenteid;
            $cargaHorariaComplementar->cargaHoraria = $select->cargahoraria;
            $cargaHorariaComplementar->justificativa = $select->justificativa;
            $cargaHorariaComplementar->tipoCargaHoraria = $select->tipocargahoraria;
            $cargaHorariaComplementar->oferta = $select->ofertadeunidadetematicaid;

        }

        return $cargaHorariaComplementar;
    }

    public function getCargaHorariaComplementarDoResidenteNaOferta($residenteId, $ofertaId)
    {
        $select = DB::select(
            "SELECT cargahorariacomplementarid FROM {$this->model->getTable()} 
            WHERE residenteid = :residenteid 
              AND ofertadeunidadetematicaid = :ofertadeunidadetematicaid",
            [
                'residenteid' => $residenteId,
                'ofertadeunidadetematicaid' => $ofertaId
            ]
        );


        $cargaHorariaComplementarResidente = [];
        if (count($select)) {
            foreach ($select as $cargaHorariaComplementar) {
                $cargaHorariaComplementarResidente[] = $this->get($cargaHorariaComplementar->cargahorariacomplementarid);
            }
        }
        return $cargaHorariaComplementarResidente;
    }

    public function getCargaHorariaComplementarDoResidenteNaOfertaPorTipo($residenteId, $ofertaId, $tipoCargaHoraria)
    {
        $select = DB::select(
            "SELECT cargahorariacomplementarid FROM {$this->model->getTable()} 
            WHERE residenteid = :residenteid 
              AND ofertadeunidadetematicaid = :ofertadeunidadetematicaid
              AND tipocargahoraria = :tipocargahoraria
                
            ",
            [
                'residenteid' => $residenteId,
                'ofertadeunidadetematicaid' => $ofertaId,
                'tipocargahoraria' => $tipoCargaHoraria
            ]
        );

        $cargaHorariaComplementarResidente = 0;
        if (count($select)) {
            foreach ($select as $cargaHorariaComplementar) {
                $cargaHorariaComplementarResidenteObj = $this->get($cargaHorariaComplementar->cargahorariacomplementarid);
                $cargaHorariaComplementarResidente += $cargaHorariaComplementarResidenteObj->cargaHoraria;
            }
        }
        return $cargaHorariaComplementarResidente;
    }

    public function insert(CargaHorariaComplementar $cargaHorariaComplementar)
    {
        $result = DB::insert("
                insert into {$this->model->getTable()}  
                (tipodecargahorariacomplementarid, residenteid, cargahoraria, tipocargahoraria, ofertadeunidadetematicaid, justificativa) 
                values (?, ?, ?, ?, ?, ?)",
            [
                $cargaHorariaComplementar->tipoCargaHorariaComplementar,
                $cargaHorariaComplementar->residente,
                $cargaHorariaComplementar->cargaHoraria,
                $cargaHorariaComplementar->tipoCargaHoraria,
                $cargaHorariaComplementar->oferta,
                $cargaHorariaComplementar->justificativa
            ]);

        if ($result) {
            $rowId = DB::connection()->getPdo()->lastInsertId();
            return $this->get($rowId);
        }

        return $result;
    }

    public function update(CargaHorariaComplementar $cargaHorariaComplementar)
    {
        $result = DB::update("
            UPDATE {$this->model->getTable()}
            SET 
                tipodecargahorariacomplementarid = ?, 
                residenteid = ?, 
                cargahoraria = ?, 
                tipocargahoraria = ?, 
                ofertadeunidadetematicaid = ?, 
                justificativa = ?
            WHERE cargahorariacomplementarid = ?",
            [
                $cargaHorariaComplementar->tipoCargaHorariaComplementar,
                $cargaHorariaComplementar->residente,
                $cargaHorariaComplementar->cargaHoraria,
                $cargaHorariaComplementar->tipoCargaHoraria,
                $cargaHorariaComplementar->oferta,
                $cargaHorariaComplementar->justificativa,
                $cargaHorariaComplementar->id
            ]);

        if ($result) {
            return $this->get($cargaHorariaComplementar->id);
        }

        return $result;
    }

    public function delete(CargaHorariaComplementar $cargaHorariaComplementar)
    {
        $result = DB::update("
            DELETE FROM {$this->model->getTable()}
            WHERE cargahorariacomplementarid = ?",
            [
                $cargaHorariaComplementar->id
            ]);

        return $result;
    }
}