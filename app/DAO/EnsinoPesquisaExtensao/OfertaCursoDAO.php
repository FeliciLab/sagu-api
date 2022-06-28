<?php

namespace App\DAO\EnsinoPesquisaExtensao;

use App\Model\EnsinoPesquisaExtensao\OfertaCurso;
use Illuminate\Support\Facades\DB;

class OfertaCursoDAO
{
    public function getOfertasAtivas()
    {
        $select = DB::select("SELECT ofertacursoid, descricao, situacao FROM acpofertacurso WHERE situacao = 'A'");

        $ofertas = [];
        foreach ($select as $oferta) {
            $ofertaCurso = new OfertaCurso();
            $ofertaCurso->id = $oferta->ofertacursoid;
            $ofertaCurso->descricao = $oferta->descricao;
            $ofertaCurso->situacao = $oferta->situacao;
            $ofertas[] = $ofertaCurso;
        }

        return $ofertas;
    }
}