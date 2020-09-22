<?php


namespace App\DAO\ResidenciaMultiprofissional;


use App\Model\ResidenciaMultiprofissional\NotaPorModulo;
use Illuminate\Support\Facades\DB;

class NotaPorModuloSupervisorDAO
{
    public $model;
    public $residenteSupervisoresDAO;

    /**
     * NotaPorModuloSupervisorDAO constructor.
     * @param $residenteSupervisoresDAO
     */
    public function __construct()
    {
        $this->model = new NotaPorModulo();
        $this->residenteSupervisoresDAO = new ResidenteSupervisoresDAO();
    }

    public function insertFaltas()
    {
        return DB::table($this->model->getTable());
    }

}