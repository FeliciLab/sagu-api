<?php
namespace App\Http\Controllers\EnsinoPesquisaExtensao;

use App\DAO\EnsinoPesquisaExtensao\TurmaDAO;
use App\Http\Controllers\Controller;

class TurmaController extends Controller
{
    public function turma($ofertaId)
    {
        $turmaDAO = new TurmaDAO();
        $turmas = $turmaDAO->getTurmasPorOferta($ofertaId);
        return \response()->json($turmas);
    }
}