<?php

namespace App\DAO\ResidenciaMultiprofissional;

use App\Model\ResidenciaMultiprofissional\CargaHorariaComplementarTipo;
use Illuminate\Support\Facades\DB;

class CargaHorariaComplementarTipoDAO
{
    private $model;

    public function __construct()
    {
        $this->model = new CargaHorariaComplementarTipo();
    }

    public function get($id)
    {
        $select = DB::select(
            "SELECT * FROM {$this->model->getTable()} 
            WHERE tipodecargahorariacomplementarid = :tipodecargahorariacomplementarid",
            [
                'tipodecargahorariacomplementarid' => $id
            ]
        );
        $cargaHorariaComplementarTipo = new CargaHorariaComplementarTipo();

        if (count($select)) {
            $select = $select[0];

            $cargaHorariaComplementarTipo->id = $select->tipodecargahorariacomplementarid;
            $cargaHorariaComplementarTipo->descricao = $select->descricao;
        }

        return $cargaHorariaComplementarTipo;
    }

    public function retornaTodos()
    {
        $select = DB::select(
            "SELECT tipodecargahorariacomplementarid FROM {$this->model->getTable()}"
        );

        $tiposCargaHorariaComplementar = [];
        if (count($select)) {
            foreach ($select as $tipo) {
                $tiposCargaHorariaComplementar[] = $this->get($tipo->tipodecargahorariacomplementarid);
            }
        }

        return $tiposCargaHorariaComplementar;
    }
}