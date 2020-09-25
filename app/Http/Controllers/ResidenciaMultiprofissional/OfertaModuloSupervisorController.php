<?php


namespace App\Http\Controllers\ResidenciaMultiprofissional;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResidenciaMultiprofissional\Traits\ParameterValidateRequest;
use App\Services\OfertaModuloSurpervisorService;
use Illuminate\Http\Request;
use function response;

class OfertaModuloSupervisorController extends Controller
{
    use ParameterValidateRequest;

    public function index(
        Request $request,
        OfertaModuloSurpervisorService $ofertaModuloSurpervisorService,
        $turma,
        $page = null
    )
    {
        if ($this->invalidPageParameter($page)) {
            return $this->responseNumberParameterError();
        }

        return response()->json(
            [
                'ofertasModulos' => $ofertaModuloSurpervisorService->buscarOfertaModuloTurmaSupervisor(
                    $request->get('usuario')->supervisorid,
                    $turma,
                    $page
                )
            ]
        );
    }
}