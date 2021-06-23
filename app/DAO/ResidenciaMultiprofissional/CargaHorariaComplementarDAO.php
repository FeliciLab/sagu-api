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
}