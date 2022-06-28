<?php
namespace App\Http\Controllers\EnsinoPesquisaExtensao;

use App\DAO\EnsinoPesquisaExtensao\OfertaCursoDAO;
use App\Http\Controllers\Controller;

class OfertaCursoController extends Controller
{
    public function ofertas()
    {
        $ofertaCursoDAO = new OfertaCursoDAO();
        $ofertas = $ofertaCursoDAO->getOfertasAtivas();
        return \response()->json($ofertas);
    }
}