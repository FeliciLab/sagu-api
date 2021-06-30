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
        $notas = $request->input('notas');

        if ($this->invalidIntegerParameter($turma)) {
            return $this->responseNumberParameterError('turma');
        }

        if ($this->invalidIntegerParameter($oferta)) {
            return $this->responseNumberParameterError('oferta');
        }

        try {
            $this->validacao($oferta, $notas);

            $notas = $this->ofertaModuloNotaService->salvarNotas($oferta, $notas);
            if (!$notas) {
                throw new \Exception('Não foi possível realizar o lançamento de notas');
            }

            return response()->json([
                'sucesso' => true,
                'notas' => $notas
            ]);

        } catch (\Exception $e) {
            return response()->json(
                [
                    'sucesso' => false,
                    'mensagem' => $e->getMessage()
                ],
                Response::HTTP_BAD_REQUEST
            );
        }


    }

    private function validacao($oferta, $notas)
    {
        if (is_null($notas) || count($notas) == 0) {
            throw new \Exception('Notas é obrigatório');
        }


        foreach ($notas as $nota) {
            if (!isset($nota['residenteid']) || !isset($nota['notadeatividadedeproduto']) || !isset($nota['notadeavaliacaodedesempenho'])) {
                throw new \Exception('Campo(s) inválido(s)');
            }

            if (($nota['notadeatividadedeproduto'] < 0 || $nota['notadeatividadedeproduto'] > 10) ||  ($nota['notadeavaliacaodedesempenho'] < 0 || $nota['notadeavaliacaodedesempenho'] > 10)) {
                throw new \Exception('Nota não pode ser menor que 0 e maior que 10');
            }
        }

    }
}