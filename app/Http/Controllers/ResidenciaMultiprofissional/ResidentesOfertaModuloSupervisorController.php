<?php


namespace App\Http\Controllers\ResidenciaMultiprofissional;

use App\DAO\ResidenciaMultiprofissional\ResidenteDAO;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResidenciaMultiprofissional\Traits\ParameterValidateRequest;
use Illuminate\Http\Request;

use function response;

class ResidentesOfertaModuloSupervisorController extends Controller
{
    use ParameterValidateRequest;

    public function index(
        Request $request,
        ResidenteDAO $ResidenteDAO,
        $turma,
        $oferta,
        $page = null
    )
    {
        if ($this->invalidPageParameter($page)) {
            return $this->responseNumberParameterError();
        }

        die;

        return response()->json(
            [
                'residentes' => $ResidenteDAO->buscarResidentesOfertaModuloSupervisores(
                    $request->get('usuario')->supervisorid,
                    $turma,
                    $oferta,
                    $page
                )
            ]
        );
    }
}