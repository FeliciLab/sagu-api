<?php
namespace App\Http\Controllers\ResidenciaMultiprofissional;

use App\DAO\ResidenciaMultiprofissional\SupervisorDAO;
use App\Http\Controllers\Controller;
use App\Http\JWT\JWTWrapper;
use App\Services\AuthService;
use Illuminate\Http\Request;


class ConsultaSupervisorController extends Controller
{
    public function turmasSupervisor(Request $request, AuthService $authService)
    {

       // dd($request);
        $jwt = $request->get('usuario');

        $supervisorId = $jwt->supervisorid;

        $supervisorDao = new SupervisorDAO();
        $turmas = $supervisorDao->retornaTurmasSupervisor($supervisorId);

        return \response()->json([
            'turmas' => $this->toArray($turmas)
        ]);
    }
}