<?php

namespace App\DAO\EnsinoPesquisaExtensao;

use App\Model\EnsinoPesquisaExtensao\OfertaCurso;
use App\Model\EnsinoPesquisaExtensao\Turma;
use Illuminate\Support\Facades\DB;

class TurmaDAO
{
    public function getTurmasPorOferta($ofertaId)
    {
        $select = DB::select("SELECT * FROM acpofertaturma WHERE situacao = 'A' AND ofertacursoid = :ofertacursoid AND NOW() BETWEEN datainicialinscricao AND datafinalinscricao ORDER BY descricao", 
            [
                'ofertacursoid' => $ofertaId
            ]
        );

        $turmas = [];
        foreach ($select as $_turma) {
            $turma = new Turma();
            $turma->id = $_turma->ofertaturmaid;
            $turma->descricao = $_turma->descricao;
            $turma->dataInicialInscricao = $_turma->datainicialinscricao;
            $turma->dataFinalInscricao = $_turma->datafinalinscricao;
            $turmas[] = $turma;
        }

        return $turmas;
    }
}