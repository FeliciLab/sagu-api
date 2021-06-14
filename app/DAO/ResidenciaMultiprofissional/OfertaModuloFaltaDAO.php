<?php

namespace App\DAO\ResidenciaMultiprofissional;

use App\Model\ResidenciaMultiprofissional\OfertaModuloFalta;
use Illuminate\Support\Facades\DB;

class OfertaModuloFaltaDAO
{
    public $model;

    public function __construct()
    {
        $this->model = new OfertaModuloFalta();
    }

    public function get($residenteId, $ofertaId, $tipo)
    {
        $select = DB::select(
            "SELECT * FROM {$this->model->getTable()} 
            WHERE residenteid = :residenteid 
              AND ofertadeunidadetematicaid = :ofertadeunidadetematicaid 
              AND tipo =:tipo",
            [
                'residenteid' => $residenteId,
                'ofertadeunidadetematicaid' => $ofertaId,
                'tipo' => $tipo,
            ]
        );
        $ofertaModuloFalta = new OfertaModuloFalta();

        if (count($select)) {
            $select = $select[0];

            $ofertaModuloFalta->id = $select->ofertadeunidadetematicafaltadoresidenteid;
            $ofertaModuloFalta->ofertaId = $select->ofertadeunidadetematicaid;
            $ofertaModuloFalta->residenteId = $select->residenteid;
            $ofertaModuloFalta->tipo = $select->tipo;
            $ofertaModuloFalta->falta = $select->falta;
            $ofertaModuloFalta->observacao = $select->observacao;
        }

        return $ofertaModuloFalta;
    }

    public function insert(OfertaModuloFalta $ofertaModuloFalta)
    {
        $result = DB::insert("insert into {$this->model->getTable()}  (residenteid, ofertadeunidadetematicaid, tipo, falta, observacao) values (?, ?, ?, ?, ?)",
            [
                $ofertaModuloFalta->residenteId,
                $ofertaModuloFalta->ofertaId,
                $ofertaModuloFalta->tipo,
                $ofertaModuloFalta->falta,
                $ofertaModuloFalta->observacao
            ]);

        if ($result) {
            return $this->get($ofertaModuloFalta->residenteId, $ofertaModuloFalta->ofertaId, $ofertaModuloFalta->tipo);
        }

        return $result;
    }

    public function update(OfertaModuloFalta $ofertaModuloFalta)
    {
        $result = DB::update("
            UPDATE {$this->model->getTable()}
            SET 
                falta = ?, 
                observacao = ? 
            WHERE residenteid = ?
              AND ofertadeunidadetematicaid = ?
              AND tipo = ?",
            [
                $ofertaModuloFalta->falta,
                $ofertaModuloFalta->observacao,
                $ofertaModuloFalta->residenteId,
                $ofertaModuloFalta->ofertaId,
                $ofertaModuloFalta->tipo
            ]);

        if ($result) {
            return $this->get($ofertaModuloFalta->residenteId, $ofertaModuloFalta->ofertaId, $ofertaModuloFalta->tipo);
        }

        return $result;
    }
}