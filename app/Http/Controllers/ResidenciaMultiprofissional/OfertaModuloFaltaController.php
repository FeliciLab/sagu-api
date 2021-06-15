<?php

namespace App\Http\Controllers\ResidenciaMultiprofissional;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResidenciaMultiprofissional\Traits\ParameterValidateRequest;
use App\Services\ResidenciaMultiprofissional\OfertaModuloFaltaService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OfertaModuloFaltaController extends Controller
{
    use ParameterValidateRequest;

    private $ofertaModuloFaltaService;

    public function __construct(OfertaModuloFaltaService $ofertaModuloFaltaService)
    {
        $this->ofertaModuloFaltaService = $ofertaModuloFaltaService;
    }

    public function store(Request $request, $turma, $oferta)
    {
        if ($this->invalidIntegerParameter($turma)) {
            return $this->responseNumberParameterError('turma');
        }

        if ($this->invalidIntegerParameter($oferta)) {
            return $this->responseNumberParameterError('oferta');
        }

        $faltas = $request->input('faltas');
        if (isset($faltas) && count($faltas) == 0) {
            return response()->json(
                [
                    'sucesso' => false,
                    'mensagem' => 'Faltas é obrigatório'
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        $faltas = $this->ofertaModuloFaltaService->salvarFaltas($oferta, $faltas);
        if ($faltas) {
            return response()->json([
                'sucesso' => true,
                'faltas' => $faltas
            ]);
        }

        return response()->json(
            [
                'sucesso' => false,
                'mensagem' => 'Não foi possível realizar o lançamento de faltas'
            ],
            Response::HTTP_BAD_REQUEST
        );
    }
}