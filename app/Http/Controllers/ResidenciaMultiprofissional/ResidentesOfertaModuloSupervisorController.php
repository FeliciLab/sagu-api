<?php


namespace App\Http\Controllers\ResidenciaMultiprofissional;

use App\DAO\ResidenciaMultiprofissional\ResidenteSupervisoresDAO;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResidenciaMultiprofissional\Traits\PaginationValidateRequest;
use Illuminate\Http\Request;

use function response;

class ResidentesOfertaModuloSupervisorController extends Controller
{
    use PaginationValidateRequest;

    public function index(
        Request $request,
        ResidenteSupervisoresDAO $residenteSupervisoresDAO,
        $turma,
        $oferta,
        $page = null
    )
    {
        if ($this->invalidNumberParameter($page)) {
            return $this->responseNumberParameterError();
        }

        return response()->json(
            [
                'residentes' => $residenteSupervisoresDAO->buscarResidentesOfertaModuloSupervisores(
                    $request->get('usuario')->supervisorid,
                    $turma,
                    $oferta,
                    $page
                )
            ]
        );
    }
}