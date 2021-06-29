<?php

namespace App\Http\Controllers\ResidenciaMultiprofissional;

use App\DAO\ResidenciaMultiprofissional\OfertaModuloTiposCargaHorariaDAO;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResidenciaMultiprofissional\Traits\ParameterValidateRequest;
use App\Services\ResidenciaMultiprofissional\OfertaModuloFaltaService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OfertaModuloFaltaController extends Controller
{
    use ParameterValidateRequest;

    private $ofertaModuloFaltaService;
    private $ofertaModuloTiposCargaHorariaDAO;

    public function __construct(OfertaModuloFaltaService $ofertaModuloFaltaService, OfertaModuloTiposCargaHorariaDAO $ofertaModuloTiposCargaHorariaDAO)
    {
        $this->ofertaModuloFaltaService = $ofertaModuloFaltaService;
        $this->ofertaModuloTiposCargaHorariaDAO = $ofertaModuloTiposCargaHorariaDAO;
    }

    public function store(Request $request, $turma, $oferta)
    {   $faltas = $request->input('faltas');

        if ($this->invalidIntegerParameter($turma)) {
            return $this->responseNumberParameterError('turma');
        }

        if ($this->invalidIntegerParameter($oferta)) {
            return $this->responseNumberParameterError('oferta');
        }

        if (is_null($faltas) || count($faltas) == 0) {
            return response()->json(
                [
                    'sucesso' => false,
                    'mensagem' => 'Faltas é obrigatório'
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        foreach ($faltas as $falta) {
            $cargaHorariaQueFaltou = $falta['falta'];
            $tipoCargaHorariaQueFaltou = $falta['tipo'];
            $residenteId = $falta['residenteid'];


            $cargaHorariaPorTipo = $this->ofertaModuloTiposCargaHorariaDAO->cargaHorariaPorTipo($oferta, $tipoCargaHorariaQueFaltou);

            if ($cargaHorariaQueFaltou > $cargaHorariaPorTipo['cargahoraria']) {
                return response()->json(
                    [
                        'sucesso' => false,
                        'mensagem' => "Quantidade de faltas lançada '{$cargaHorariaQueFaltou}h' é maior que carga horária definida no tipo {$falta['tipo']} - para o residente de  ID: #{$residenteId}"
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }
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