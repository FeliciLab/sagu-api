<?php
namespace App\Http\Controllers;

use App\DAO\TrabalhoDeConclusaoModalidadeDAO;
use Illuminate\Http\Request;

class TrabalhoDeConclusaoModalidadeController extends Controller
{
    public function lista(Request $request)
    {
        $trabalhoDeConclusaoDao = new TrabalhoDeConclusaoModalidadeDAO();
        $modalidades = $trabalhoDeConclusaoDao->retornaModalidades();
        return \response()->json($modalidades);
    }
}