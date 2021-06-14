<?php

namespace App\Http\Controllers\ResidenciaMultiprofissional;

use App\Http\Controllers\Controller;
use App\Services\ResidenciaMultiprofissional\OfertaModuloFaltaService;
use Illuminate\Http\Request;

class OfertaModuloFaltaController extends Controller
{
    private $ofertaModuloFaltaService;

    public function __construct(OfertaModuloFaltaService $ofertaModuloFaltaService)
    {
        $this->ofertaModuloFaltaService = $ofertaModuloFaltaService;
    }

    public function store(Request $request, $oferta)
    {
        $faltas = $request->input('faltas');

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
            ]
        );
    }
}