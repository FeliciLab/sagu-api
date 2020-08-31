<?php


namespace App\Http\Controllers\ResidenciaMultiprofissional;

use App\DAO\ResidenciaMultiprofissional\OfertaModuloSupervisorDAO;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResidenciaMultiprofissional\Traits\PaginationValidateRequest;
use Illuminate\Http\Request;
use function response;

class OfertaModuloSupervisorController extends Controller
{
    use PaginationValidateRequest;

    public function index(
        Request $request,
        OfertaModuloSupervisorDAO $ofertaModuloSupervisorDAO,
        $turma,
        $page = null
    )
    {
        if ($this->invalidePageParameter($page)) {
            return $this->responsePaginationError();
        }

        return response()->json(
            [
                'ofertasModulos' => $ofertaModuloSupervisorDAO->buscarOfertasModuloSupervisor(
                    $request->get('usuario')->supervisorid,
                    $turma,
                    $page
                )
            ]
        );
    }
}