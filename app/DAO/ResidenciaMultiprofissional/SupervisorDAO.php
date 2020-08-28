<?php

namespace App\DAO\ResidenciaMultiprofissional;

use App\DAO\PersonDAO;
use App\DAO\ResidenciaMultiprofissional\TurmaDAO;
use App\Model\ResidenciaMultiprofissional\Supervisor;
use Illuminate\Support\Facades\DB;

class SupervisorDAO
{
    /**
     * @param $id
     * @return Supervisor
     */
    public function buscarSupervisor($id)
    {
        $select = DB::table('res.supervisores')
            ->where('supervisorid', $id)
            ->get();

        $supervisor = new Supervisor();
        if (count($select)) {
            $select = $select[0];
            $supervisor->setId($select->supervisorid);
            $personDao = new PersonDAO();
            $supervisor->setPerson($personDao->get($select->personid));
        }

        return $supervisor;
    }

    public function buscarTurmasDoSupervisor($supervisorId)
    {
        return (new TurmaDAO())->buscarTurmasSupervisor($supervisorId);
    }
}