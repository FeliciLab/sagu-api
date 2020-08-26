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
    public function get($id)
    {
        $select = DB::select('SELECT * FROM res.supervisores WHERE supervisorid = :supervisorid', ['supervisorid' => $id]);

        $supervisor = new Supervisor();

        if (count($select)) {
            $select = $select[0];

            $supervisor->setId($select->supervisorid);


            $personDao = new PersonDAO();
            $supervisor->setPerson($personDao->get($select->personid));
        }

        return $supervisor;
    }

    public function retornaTurmasSupervisor($supervisorId)
    {
        $supervisor = $this->get($supervisorId);

        $turmaDao = new TurmaDAO();
        $turmasSupervisor = $turmaDao->retornaTurmasSupervisor($supervisor);

        return $turmasSupervisor == null ? [] : $turmasSupervisor;
    }
}