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
    {
        $faltas = $request->input('faltas');

        if ($this->invalidIntegerParameter($turma)) {
            return $this->responseNumberParameterError('turma');
        }

        if ($this->invalidIntegerParameter($oferta)) {
            return $this->responseNumberParameterError('oferta');
        }

        try {
            $this->validadao($oferta, $faltas);

            $faltas = $this->ofertaModuloFaltaService->salvarFaltas($oferta, $faltas);
            if (!$faltas) {
                throw new \Exception('Não foi possível realizar o lançamento de faltas');
            }

            return response()->json([
                'sucesso' => true,
                'faltas' => $faltas
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

    private function validadao($oferta, $faltas)
    {
        if (is_null($faltas) || count($faltas) == 0) {
            throw new \Exception('Faltas é obrigatório');
        }

        foreach ($faltas as $falta) {
            if (!isset($falta['falta']) || !isset($falta['tipo']) || !isset($falta['residenteid'])) {
                throw new \Exception('Campo(s) inválido(s)');
            }

            if ($falta['falta'] <= 0) {
                throw new \Exception('Falta não pode ser menor ou igual a 0');
            }

            $cargaHorariaQueFaltou = $falta['falta'];
            $tipoCargaHorariaQueFaltou = $falta['tipo'];
            $residenteId = $falta['residenteid'];

            $cargaHorariaPorTipo = $this->ofertaModuloTiposCargaHorariaDAO->cargaHorariaPorTipo($oferta, $tipoCargaHorariaQueFaltou);

            if ($cargaHorariaQueFaltou > $cargaHorariaPorTipo['cargahoraria']) {
                throw new \Exception("Quantidade de faltas lançada '{$cargaHorariaQueFaltou}h' é maior que carga horária definida no tipo {$falta['tipo']} - para o residente de  ID: #{$residenteId}");
            }
        }
    }
}