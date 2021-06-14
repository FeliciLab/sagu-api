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

    public function store(Request $request, $turma, $oferta)
    {
        try {
            $faltas = $request->input('faltas');
            $ok = $this->ofertaModuloFaltaService->salvarFaltas($oferta, $faltas);
            return response()->json([
                'sucesso' => true,
                'faltas' => $ok
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'sucesso' => false,
                    'message' => $e->getMessage()
                ]
            );
        }

    }
}