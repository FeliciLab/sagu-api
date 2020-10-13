<?php


namespace App\Http\Controllers\ResidenciaMultiprofissional;


use App\DAO\ResidenciaMultiprofissional\TiposCargasHorariasDAO;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TipoCargaHorariaController extends Controller
{
    /**
     * @param Request $request
     * @param TiposCargasHorariasDAO $tiposCargasHorariasDAO
     * @return \Illuminate\Http\JsonResponse
     */
    public function consultarTipos(Request $request, TiposCargasHorariasDAO $tiposCargasHorariasDAO)
    {
        return response()->json($tiposCargasHorariasDAO->consultarTudo());
    }
}