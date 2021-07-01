<?php


namespace App\Http\Controllers\ResidenciaMultiprofissional;

use App\DAO\ResidenciaMultiprofissional\OfertaModuloDAO;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResidenciaMultiprofissional\Traits\ParameterValidateRequest;
use App\Services\ResidenciaMultiprofissional\OfertaModuloService;
use App\DAO\ResidenciaMultiprofissional\ResidenteDAO;
use Illuminate\Http\Request;
use function response;

class OfertaModuloController extends Controller
{
    use ParameterValidateRequest;

    public function index(
        Request $request,
        $turma,
        $page = null
    )
    {
        if ($this->invalidPageParameter($page)) {
            return $this->responseNumberParameterError();
        }

        $ofertaModuloTurmasDAO = new OfertaModuloDAO();

        return response()->json(
            [
                'ofertasModulos' => $ofertaModuloTurmasDAO->buscarOfertasModuloSupervisor(
                    $request->get('usuario')->supervisorid,
                    $turma,
                    $page
                )
            ]
        );
    }

    public function residentes(
        Request $request,
        ResidenteDAO $ResidenteDAO,
        $turma,
        $oferta,
        $residenteId = null
    )
    {
        if ($this->invalidPageParameter($residenteId)) {
            return $this->responseNumberParameterError('residenteId');
        }

        return response()->json(
            [
                'residentes' => $ResidenteDAO->buscarResidentesOfertaModuloSupervisores(
                    $request->get('usuario')->supervisorid,
                    $turma,
                    $oferta,
                    $residenteId
                )
            ]
        );
    }
}