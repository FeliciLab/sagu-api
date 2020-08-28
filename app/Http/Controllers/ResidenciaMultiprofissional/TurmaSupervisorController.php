<?php

namespace App\Http\Controllers\ResidenciaMultiprofissional;

use App\DAO\ResidenciaMultiprofissional\TurmaDAO;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function response;


class TurmaSupervisorController extends Controller
{
    public function turmasSupervisor(Request $request, TurmaDAO $turmaDAO, $page = null)
    {
        if ($page !== null && !ctype_digit($page)) {
            return response()->json(
                [
                    'error' => true,
                    'status' => 400,
                    'message' => 'Atributo {page} não é um número inteiro'
                ],
                400
            );
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