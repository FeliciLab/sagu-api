<?php


namespace App\Http\Controllers\ResidenciaMultiprofissional;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResidenciaMultiprofissional\Traits\ParameterValidateRequest;
use App\Services\ResidenciaMultiprofissional\CargaHoriariaComplementarService;
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


    public function store(Request $request, $turma, $oferta, $id = null)
    {
        if (!is_null($id)) {
            if ($this->invalidIntegerParameter($id)) {
                return $this->responseNumberParameterError('id');
            }
        }

        if ($this->invalidIntegerParameter($turma)) {
            return $this->responseNumberParameterError('turma');
        }

        if ($this->invalidIntegerParameter($oferta)) {
            return $this->responseNumberParameterError('oferta');
        }

        $cargaHoraria = $request->input('cargaHoraria');
        if (!isset($cargaHoraria)) {
            return response()->json(
                [
                    'sucesso' => false,
                    'mensagem' => 'Carga horária complementar é obrigatório'
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        $carga = $this->cargaHorariaComplementarService->salvar($oferta, $cargaHoraria, $id);
        if (!$carga) {
            return response()->json(
                [
                    'sucesso' => false,
                    'mensagem' => 'Não foi possível realizar o lançamento de carga horária complementar'
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        return response()->json([
            'sucesso' => true,
            'cargaHorariaComplementar' => $carga
        ], Response::HTTP_OK);
    }

    public function delete($turma, $oferta, $id)
    {
        if ($this->invalidIntegerParameter($turma)) {
            return $this->responseNumberParameterError('turma');
        }

        if ($this->invalidIntegerParameter($oferta)) {
            return $this->responseNumberParameterError('oferta');
        }

        if ($this->invalidIntegerParameter($id)) {
            return $this->responseNumberParameterError('id');
        }

        $delete = $this->cargaHorariaComplementarService->delete($id);

        if (!$delete) {
            return response()->json(
                [
                    'sucesso' => false,
                    'mensagem' => 'Não foi possível remover a carga horária complementar'
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        return response()->json([
            'sucesso' => true
        ], Response::HTTP_OK);
    }
}