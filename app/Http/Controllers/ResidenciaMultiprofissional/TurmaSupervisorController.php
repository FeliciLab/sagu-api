<?php

namespace App\Http\Controllers\ResidenciaMultiprofissional;

use App\DAO\ResidenciaMultiprofissional\TurmaDAO;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResidenciaMultiprofissional\Traits\ParameterValidateRequest;
use Illuminate\Http\Request;
use function response;


class TurmaSupervisorController extends Controller
{
    use ParameterValidateRequest;

    public function turmasSupervisor(Request $request, TurmaDAO $turmaDAO, $page = null)
    {
        if ($this->invalidPageParameter($page)) {
            return $this->responseNumberParameterError();
        }

        return response()->json(
            [
                'turmas' => $turmaDAO->buscarTurmasSupervisor(
                    $request->get('usuario')->supervisorid,
                    $page
                )
            ]
        );
    }
}