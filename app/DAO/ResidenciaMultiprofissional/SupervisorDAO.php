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
    public function buscar($id)
    {
        return new Supervisor(
            DB::table('res.supervisores as supervisores')
                ->distinct()
                ->join('public.basperson as person', 'person.personid', 'supervisores.personid')
                ->where('supervisores.supervisorid', '1')
                ->get()
                ->first()
        );
    }

    public function buscarTurmasDoSupervisor($supervisorId)
    {
        return (new TurmaDAO())->buscarTurmasSupervisor($supervisorId);
    }
}