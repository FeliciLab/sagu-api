<?php


namespace App\Services\ResidenciaMultiprofissional;


use App\DAO\ResidenciaMultiprofissional\OfertaModuloDAO;
use App\Model\ResidenciaMultiprofissional\OfertaModulo;
use App\Serializers\OfertaModuloTurmasSupervisorSerializer;

class OfertaModuloService
{
    public function buscarOfertaModuloTurmaSupervisor($supervisorId, $turma, $page = null)
    {
        $ofertaModuloTurmasDAO = new OfertaModuloDAO();
        return $ofertaModuloTurmasDAO->buscarOfertasModuloSupervisor(
            $supervisorId,
            $turma,
            $page
        );
    }
}