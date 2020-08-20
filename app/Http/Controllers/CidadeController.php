<?php
namespace App\Http\Controllers;

use App\DAO\CidadeDAO;
use Illuminate\Http\Request;

class CidadeController extends Controller
{
    public function cidadesPorEstado(Request $request, $estadoId)
    {
        $cidadeDao = new CidadeDAO();
        $cidades = $cidadeDao->getPorEstado($estadoId);
        return \response()->json($cidades);
    }
}