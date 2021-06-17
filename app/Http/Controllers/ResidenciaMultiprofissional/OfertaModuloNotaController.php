<?php

namespace App\Http\Controllers\ResidenciaMultiprofissional;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResidenciaMultiprofissional\Traits\ParameterValidateRequest;
use App\Services\ResidenciaMultiprofissional\OfertaModuloNotaService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OfertaModuloNotaController extends Controller
{
    use ParameterValidateRequest;

    private $ofertaModuloNotaService;

    public function __construct(OfertaModuloNotaService $ofertaModuloNotaService)
    {
        $this->ofertaModuloNotaService = $ofertaModuloNotaService;
    }

    public function store(Request $request, $turma, $oferta)
    {
        if ($this->invalidIntegerParameter($turma)) {
            return $this->responseNumberParameterError('turma');
        }

        if ($this->invalidIntegerParameter($oferta)) {
            return $this->responseNumberParameterError('oferta');
        }

        $notas = $request->input('notas');
        if (isset($notas) && count($notas) == 0) {
            return response()->json(
                [
                    'sucesso' => false,
                    'mensagem' => 'Notas é obrigatório'
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        $notas = $this->ofertaModuloNotaService->salvarNotas($oferta, $notas);
        if ($notas) {
            return response()->json([
                'sucesso' => true,
                'notas' => $notas
            ]);
        }

        return response()->json(
            [
                'sucesso' => false,
                'mensagem' => 'Não foi possível realizar o lançamento de notas'
            ],
            Response::HTTP_BAD_REQUEST
        );
    }
}