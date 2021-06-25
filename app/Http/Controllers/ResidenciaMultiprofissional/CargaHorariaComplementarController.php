<?php


namespace App\Http\Controllers\ResidenciaMultiprofissional;

use App\DAO\ResidenciaMultiprofissional\CargaHorariaComplementarTipoDAO;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResidenciaMultiprofissional\Traits\ParameterValidateRequest;
use App\Services\ResidenciaMultiprofissional\CargaHoriariaComplementarService;
use App\Services\ResidenciaMultiprofissional\OfertaModuloNotaService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CargaHorariaComplementarController extends Controller
{
    use ParameterValidateRequest;

    private $cargaHorariaComplementarService;

    public function __construct(CargaHoriariaComplementarService $cargaHorariaComplementarService)
    {
        $this->cargaHorariaComplementarService = $cargaHorariaComplementarService;
    }


    public function store(Request $request, $turma, $oferta)
    {
        if ($this->invalidIntegerParameter($turma)) {
            return $this->responseNumberParameterError('turma');
        }

        if ($this->invalidIntegerParameter($oferta)) {
            return $this->responseNumberParameterError('oferta');
        }

        $cargaHoraria = $request->input('cargahoraria');
        if (isset($cargaHoraria) && count($cargaHoraria) == 0) {
            return response()->json(
                [
                    'sucesso' => false,
                    'mensagem' => 'Carga horária complementar é obrigatório'
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        $cargas = $this->cargaHorariaComplementarService->salvar($oferta, $cargaHoraria);
        if ($cargas) {
            return response()->json([
                'sucesso' => true,
                'notas' => $cargas
            ]);
        }

        return response()->json(
            [
                'sucesso' => false,
                'mensagem' => 'Não foi possível realizar o lançamento de carga horária complementar'
            ],
            Response::HTTP_BAD_REQUEST
        );
    }
}