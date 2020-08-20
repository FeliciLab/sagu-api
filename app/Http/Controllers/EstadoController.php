<?php
namespace App\Http\Controllers;

use App\DAO\EstadoDAO;
use Illuminate\Http\Request;

class EstadoController extends Controller
{
    public function lista(Request $request)
    {
        $estadoDao = new EstadoDAO();
        $estados = $estadoDao->getEstados();
        return \response()->json($estados);
    }
}