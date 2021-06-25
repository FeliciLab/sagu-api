<?php


namespace App\DAO\ResidenciaMultiprofissional;

use App\DAO\Traits\ArrayMapToModel;
use App\DAO\Traits\RemoverCamposNulos;
use App\Model\ResidenciaMultiprofissional\TipoCargaHoraria;
use Illuminate\Support\Facades\DB;

class TiposCargasHorariasDAO
{
    use RemoverCamposNulos, ArrayMapToModel;

    private $model;

    /**
     * TiposCargasHorariasDAO constructor.
     * @param $model
     */
    public function __construct()
    {
        $this->model = new TipoCargaHoraria();
    }

    public function consultarTudo()
    {
        return $this->removerCamposNulosLista(
            $this->mapToModel(
                DB::table($this->model->getTable())
                    ->select('descricao', 'tipodeunidadetematicaid', 'frequenciaminima')
                    ->get()
                    ->toArray()
            )
        );
    }
}