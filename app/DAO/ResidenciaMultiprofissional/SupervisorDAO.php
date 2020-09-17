<?php

namespace App\DAO\ResidenciaMultiprofissional;

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
        return new Supervisor(
            DB::table('res.supervisores as supervisores')
                ->join('public.basperson as person', 'person.personid', 'supervisores.supervisorid')
                ->where('supervisores.supervisorid', $id)
                ->get()
                ->first()
                ->toArray()
        );
    }

    public function buscarTurmasDoSupervisor($supervisorId)
    {
        return (new TurmaDAO())->buscarTurmasSupervisor($supervisorId);
    }
}