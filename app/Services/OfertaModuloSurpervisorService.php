<?php


namespace App\Services;


use App\DAO\ResidenciaMultiprofissional\OfertaModuloSupervisorDAO;
use App\Model\ResidenciaMultiprofissional\OfertaModulo;
use App\Serializers\OfertaModuloTurmasSupervisorSerializer;

class OfertaModuloSurpervisorService
{
    public function buscarOfertaModuloTurmaSupervisor($supervisorId, $turma, $page = null)
    {
        $ofertaModuloTurmasDAO = new OfertaModuloSupervisorDAO();
        return $ofertaModuloTurmasDAO->buscarOfertasModuloSupervisor(
            $supervisorId,
            $turma,
            $page
        );
    }
}