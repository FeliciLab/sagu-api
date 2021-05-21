<?php


namespace App\DAO\ResidenciaMultiprofissional;

use App\DAO\Traits\ArrayMapToModel;
use App\DAO\Traits\RemoverCamposNulos;
use App\Model\ResidenciaMultiprofissional\OfertaModuloTiposCargaHoraria;
use Illuminate\Support\Facades\DB;

class OfertaModuloTiposCargaHorariaDAO
{
    use RemoverCamposNulos, ArrayMapToModel;

    private $model;

    /**
     * OfertaModuloTiposCargaHoraria constructor.
     * @param $model
     */
    public function __construct()
    {
        $this->model = new OfertaModuloTiposCargaHoraria();
    }

    public function tiposCargaHorariaPorOferta($ofertaid)
    {
        return $this->removerCamposNulosLista(
            $this->mapToModel(
                DB::table($this->model->getTable())
                    ->select('tipo', 'cargahoraria')
                    ->where('ofertadeunidadetematicaid', $ofertaid)
                    ->get()                    
                    ->toArray()
            )
        );
    }
}