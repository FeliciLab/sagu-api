<?php

namespace App\DAO\EnsinoPesquisaExtensao;

use Exception;
use Illuminate\Support\Facades\DB;

class CursoDAO
{

    public function verificaInscricaoAtivaNaTurma($turmaid, $personid)
    {
        $queryInscricao = DB::select(
            "SELECT inscricao.inscricaoid FROM acpinscricao AS inscricao
            INNER JOIN acpinscricaoturmagrupo AS IT
            ON IT.inscricaoid = inscricao.inscricaoid
            WHERE inscricao.personid = $personid
            AND inscricao.situacao = 'I'
            AND IT.ofertaturmaid = $turmaid"
        );

        $queryMatricula = DB::select(
            "SELECT matricula.matriculaid FROM acpmatricula AS matricula
            INNER JOIN acpinscricaoturmagrupo AS IT
            ON IT.inscricaoturmagrupoid = matricula.inscricaoturmagrupoid
            WHERE matricula.personid = $personid
            AND matricula.situacao = 'M'
            AND IT.ofertaturmaid = $turmaid"
        );

        if ($queryInscricao || $queryMatricula) {
            throw new Exception('Pessoa possui Inscrição ou Matrícula ativa.');
        }

        return false;
    }

    public function getCursoDados($turmaId)
    {
        $cursoDados = DB::table('public.acpofertaturma')
            ->where('public.acpofertaturma.ofertaturmaid', $turmaId)
            ->where('public.acpofertaturma.situacao', 'A')
            ->whereRaw('NOW() BETWEEN public.acpofertaturma.datainicialinscricao AND public.acpofertaturma.datafinalinscricao')
            ->where('public.acpofertacurso.situacao', 'A')
            ->join(
                'public.acpofertacurso',
                'public.acpofertaturma.ofertacursoid',
                '=',
                'public.acpofertacurso.ofertacursoid'
            )
            ->join(
                'public.acpocorrenciacurso',
                'public.acpofertacurso.ocorrenciacursoid',
                '=',
                'public.acpocorrenciacurso.ocorrenciacursoid'
            )
            ->join(
                'public.acpcurso',
                'public.acpocorrenciacurso.cursoid',
                '=',
                'public.acpcurso.cursoid'
            )
            ->join(
                'public.acpperfilcurso',
                'public.acpcurso.perfilcursoid',
                '=',
                'public.acpperfilcurso.perfilcursoid'
            )
            ->select(
                'acpofertacurso.ofertacursoid',
                'acpofertacurso.ocorrenciacursoid',
                'acpofertacurso.descricao as oferta_descricao',
                'acpofertacurso.situacao as oferta_situacao',
                'acpocorrenciacurso.cursoid',
                'acpocorrenciacurso.situacao as ocorrencia_situacao',
                'acpcurso.perfilcursoid',
                'acpcurso.numeroformalvagas',
                'acpcurso.datainicio as curso_datainicio',
                'acpcurso.datafim as curso_datafim',
                'acpperfilcurso.modelodeavaliacaogeral',
                'acpperfilcurso.modelodeavaliacaoseriado',
                'acpperfilcurso.modelodeavaliacaomodulo',
                'acpperfilcurso.permiteinscricaoporgrupo',
                'acpperfilcurso.descricao as perfil_descricao',
                'acpperfilcurso.ativo as perfil_ativo',
                'acpofertaturma.ofertaturmaid',
                'acpofertaturma.codigo as turma_codigo',
                'acpofertaturma.descricao as turma_descricao',
                'acpofertaturma.datainicialoferta',
                'acpofertaturma.datafinaloferta',
                'acpofertaturma.dataencerramento',
                'acpofertaturma.datainicialaulas',
                'acpofertaturma.datafinalaulas',
                'acpofertaturma.datainicialinscricao',
                'acpofertaturma.datafinalinscricao',
                'acpofertaturma.datainicialmatricula',
                'acpofertaturma.datafinalmatricula',
                'acpofertaturma.minimoalunos',
                'acpofertaturma.maximoalunos',
                'acpofertaturma.centerid',
                'acpofertaturma.unitid',
                'acpofertaturma.habilitada',
            )
            ->first();

        if (!$cursoDados) throw new Exception("Dados do Curso insuficientes, verificar situação e período de oferta e turma");

        // Matriz Curricular pode ter 1 ou mais resultados
        $matrizCurricularDados = DB::table('public.acpmatrizcurricular')
            ->where('public.acpmatrizcurricular.cursoid', $cursoDados->cursoid)
            ->join(
                'public.acpmatrizcurriculargrupo',
                'public.acpmatrizcurricular.matrizcurricularid',
                '=',
                'public.acpmatrizcurriculargrupo.matrizcurricularid',
            )
            ->select(
                'acpmatrizcurricular.matrizcurricularid',
                'acpmatrizcurricular.componentecurricularid',
                'acpmatrizcurricular.descricao as matrizcurricular_descricao',
                'acpmatrizcurriculargrupo.matrizcurriculargrupoid',
                'acpmatrizcurriculargrupo.descricao as matrizcurriculargrupo_descricao',
            )
            ->get();

        if (!$matrizCurricularDados) throw new Exception("Dados da Matriz Curricular insuficientes");

        // Componente Curricular (ou Unidade) pode ter 1 ou mais resultados
        $componenteCurricularDados = DB::table('public.acpofertacomponentecurricular')
            ->where('public.acpofertacomponentecurricular.ofertaturmaid', $turmaId)
            ->join(
                'public.acpcomponentecurricularmatriz',
                'public.acpofertacomponentecurricular.componentecurricularmatrizid',
                '=',
                'public.acpcomponentecurricularmatriz.componentecurricularmatrizid'
            )
            ->join(
                'public.acpmatrizcurriculargrupo',
                'public.acpcomponentecurricularmatriz.matrizcurriculargrupoid',
                '=',
                'public.acpmatrizcurriculargrupo.matrizcurriculargrupoid',
            )
            ->join(
                'public.acpmatrizcurricular',
                'public.acpmatrizcurriculargrupo.matrizcurricularid',
                '=',
                'public.acpmatrizcurricular.matrizcurricularid',
            )
            ->select(
                'acpofertacomponentecurricular.ofertacomponentecurricularid',
                'acpofertacomponentecurricular.componentecurricularmatrizid',
                'acpcomponentecurricularmatriz.matrizcurriculargrupoid',
                'acpmatrizcurriculargrupo.matrizcurricularid',
                'acpmatrizcurricular.situacao',
                'acpmatrizcurricular.descricao',
            )
            ->get();

        if (!$componenteCurricularDados) throw new Exception("Dados do Componente Curricular insuficientes");

        return [
            'cursoDados' => $cursoDados,
            'matrizCurricularDados' => $matrizCurricularDados,
            'componenteCurricularDados' => $componenteCurricularDados,
        ];
    }

    // Inserts
    private function salvaInscricao($cursoDados, $personid)
    {
        $result = DB::table('public.acpinscricao')
            ->insertGetId(
                [
                    'datetime' => 'NOW()',
                    'ipaddress' => '127.0.0.1',
                    'personid' => $personid,
                    'situacao' => 'I',
                    'datasituacao' => 'NOW()',
                    'origem' => 'S',
                    'unitid' => $cursoDados->unitid,
                    'ofertacursoid' => $cursoDados->ofertacursoid,
                    'centerid' => $cursoDados->centerid
                ],
                'inscricaoid'
            );
        return $result;
    }

    private function salvaInscricaoCurso($cursoDados, $personid)
    {
        $result = DB::table('public.acpcursoinscricao')
            ->insertGetId(
                [
                    'personid' => $personid,
                    'situacao' => 'M',
                    'cursoid' => $cursoDados->cursoid
                ],
                'cursoinscricaoid'
            );

        return $result;
    }

    private function salvaInscricaoPorGrupo(
        $inscricaoId,
        $personid,
        $cursoDados,
        $matrizCurricularDados,
        $componenteCurricularDados
    ) {

        $inscricaoCompCurricularIds = array();

        foreach ($matrizCurricularDados as $matrizCurricular) {

            $inscricaoturmagrupoIdPorGrupo = DB::table('public.acpinscricaoturmagrupo')
                ->insertGetId(
                    [
                        'inscricaoid' => $inscricaoId,
                        'ofertaturmaid' => $cursoDados->ofertaturmaid,
                        'unitid' => $cursoDados->unitid,
                        'centerid' => $cursoDados->centerid,
                        'matrizcurriculargrupoid' => $matrizCurricular->matrizcurriculargrupoid
                    ],
                    'inscricaoturmagrupoid'
                );

            foreach ($componenteCurricularDados as $compCurricular) {

                if ($matrizCurricular->matrizcurriculargrupoid == $compCurricular->matrizcurriculargrupoid) {

                    $inscricaoCompCurricularIds[] = DB::table('public.acpmatricula')
                        ->insertGetId(
                            [
                                'datetime' => 'NOW()',
                                'ipaddress' => '127.0.0.1',
                                'ofertacomponentecurricularid' => $compCurricular->ofertacomponentecurricularid,
                                'personid' => $personid,
                                'situacao' => 'M',
                                'datamatricula' => 'NOW()',
                                'unitid' => $cursoDados->unitid,
                                'inscricaoturmagrupoid' => $inscricaoturmagrupoIdPorGrupo,
                                'centerid' => $cursoDados->centerid,
                            ],
                            'matriculaid'
                        );
                }
            }
        }

        return $inscricaoCompCurricularIds;
    }

    private function salvaInscricaoPorUnidade(
        $inscricaoId,
        $personid,
        $cursoDados,
        $componenteCurricularDados
    ) {

        $inscricaoCompCurricularIds = array();

        $inscricaoturmagrupoIdPorUnidade = DB::table('public.acpinscricaoturmagrupo')
            ->insertGetId(
                [
                    'inscricaoid' => $inscricaoId,
                    'ofertaturmaid' => $cursoDados->ofertaturmaid,
                    'unitid' => $cursoDados->unitid,
                    'centerid' => $cursoDados->centerid,
                ],
                'inscricaoturmagrupoid'
            );

        foreach ($componenteCurricularDados as $compCurricular) {
            $inscricaoCompCurricularIds[] = DB::table('public.acpmatricula')
                ->insertGetId(
                    [
                        'datetime' => 'NOW()',
                        'ipaddress' => '127.0.0.1',
                        'ofertacomponentecurricularid' => $compCurricular->ofertacomponentecurricularid,
                        'personid' => $personid,
                        'situacao' => 'M',
                        'datamatricula' => 'NOW()',
                        'unitid' => $cursoDados->unitid,
                        'inscricaoturmagrupoid' => $inscricaoturmagrupoIdPorUnidade,
                        'centerid' => $cursoDados->centerid,
                    ],
                    'matriculaid'
                );
        }

        return $inscricaoCompCurricularIds;
    }

    public function inscreveAluno($turmaId, $personid)
    {
        $verificaInscricaoAtivaNaTurma = $this->verificaInscricaoAtivaNaTurma(
            $turmaId,
            $personid
        );

        if ($verificaInscricaoAtivaNaTurma) {
            return $verificaInscricaoAtivaNaTurma;
        }

        DB::beginTransaction();
        try {
            $curso = $this->getCursoDados($turmaId);

            $inscricaoId = $this->salvaInscricao(
                $curso['cursoDados'],
                $personid
            );

            $cursoInscricaoId = $this->salvaInscricaoCurso(
                $curso['cursoDados'],
                $personid
            );

            $inscricaoCompCurricularIds = array();

            if ($curso['cursoDados']->permiteinscricaoporgrupo) {

                $inscricaoCompCurricularIds = $this->salvaInscricaoPorGrupo(
                    $inscricaoId,
                    $personid,
                    $curso['cursoDados'],
                    $curso['matrizCurricularDados'],
                    $curso['componenteCurricularDados']
                );
            } else {

                $inscricaoCompCurricularIds = $this->salvaInscricaoPorUnidade(
                    $inscricaoId,
                    $personid,
                    $curso['cursoDados'],
                    $curso['componenteCurricularDados']
                );
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw new Exception('Não foi possível realizar a inscrição. ' . $e->getMessage());
        }

        $result = [
            'inscricao_id' => $inscricaoId,
            'curso_inscricao_id' => $cursoInscricaoId,
            'matriculas' => $inscricaoCompCurricularIds
        ];

        return $result;
    }
}
