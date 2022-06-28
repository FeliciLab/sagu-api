<?php

namespace App\DAO\EnsinoPesquisaExtensao;

use App\Model\EnsinoPesquisaExtensao\OfertaCurso;
use App\Model\EnsinoPesquisaExtensao\Turma;
use Illuminate\Support\Facades\DB;

class TurmaDAO
{
    public function getTurmasPorOferta($ofertaId)
    {
        $select = DB::select("SELECT * FROM acpofertaturma WHERE situacao = 'A' AND ofertacursoid = :ofertacursoid ORDER BY descricao", ['ofertacursoid' => $ofertaId]);

        $turmas = [];
        foreach ($select as $_turma) {
            $turma = new Turma();
            $turma->id = $_turma->ofertaturmaid;
            $turma->descricao = $_turma->descricao;
            $turma->minimoAlunos = $_turma->minimoalunos;
            $turma->maximoAlunos = $_turma->maximoalunos;
            $turma->dataInicial = $_turma->datainicialoferta;
            $turma->dataFinal = $_turma->datafinaloferta;
            $turma->dataInicialInscricao = $_turma->datainicialinscricao;
            $turma->dataFinalInscricao = $_turma->datafinalinscricao;
            $turma->dataInicialMatricula = $_turma->datainicialmatricula;
            $turma->dataFinalMatricula = $_turma->datafinalmatricula;
            $turma->situacao = $_turma->situacao;
            $turmas[] = $turma;
        }

        return $turmas;
    }
}