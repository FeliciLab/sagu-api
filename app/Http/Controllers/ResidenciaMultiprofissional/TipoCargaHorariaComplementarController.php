<?php


namespace App\Http\Controllers\ResidenciaMultiprofissional;

use App\DAO\ResidenciaMultiprofissional\CargaHorariaComplementarTipoDAO;
use App\Http\Controllers\Controller;

class TipoCargaHorariaComplementarController extends Controller
{
    public function index()
    {
        return response()->json(
            (new CargaHorariaComplementarTipoDAO())->retornaTodos()
        );
    }
}