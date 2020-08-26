<?php
namespace App\Http\Controllers\ResidenciaMultiprofissional;

use App\DAO\ResidenciaMultiprofissional\SupervisorDAO;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class ConsultaSupervisorController extends Controller
{
    public function turmasSupervisor(Request $request, $supervisorId)
    {
        $supervisorDao = new SupervisorDAO();
        $turmas = $supervisorDao->retornaTurmasSupervisor($supervisorId);

        return \response()->json([
            'turmas' => $this->toArray($turmas)
        ]);
    }
}