<?php
namespace App\Http\Controllers\ResidenciaMultiprofissional;

use App\DAO\ResidenciaMultiprofissional\TurmaDAO;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class TurmaSupervisorController extends Controller
{
    public function turmasSupervisor(Request $request, TurmaDAO $turmaDAO, $page=null)
    {
        return \response()->json([
            'turmas' => $turmaDAO->buscarTurmasSupervisor(
                $request->get('usuario')->supervisorid,
                $page
            )
        ]);
    }
}