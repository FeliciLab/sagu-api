<?php


namespace App\Http\Controllers\ResidenciaMultiprofissional;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResidenciaMultiprofissional\Traits\ParameterValidateRequest;
use App\Services\ResidenciaMultiprofissional\OfertaModuloService;
use Illuminate\Http\Request;
use function response;

class OfertaModuloController extends Controller
{
    use ParameterValidateRequest;

    public function index(
        Request $request,
        OfertaModuloService $ofertaModuloService,
        $turma,
        $page = null
    )
    {
        if ($this->invalidPageParameter($page)) {
            return $this->responseNumberParameterError();
        }

        return response()->json(
            [
                'ofertasModulos' => $ofertaModuloService->buscarOfertaModuloTurmaSupervisor(
                    $request->get('usuario')->supervisorid,
                    $turma,
                    $page
                )
            ]
        );
    }
}