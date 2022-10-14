<?php

namespace App\DAO\EnsinoPesquisaExtensao;

use Illuminate\Support\Facades\DB;

class CertificadoDAO
{

    /**
     * Pega informações referentes a OfertaCurso e OfertaTurma
     *
     * @param integer $turmaid
     * @return array
     */
    public function getOfertaCursoTurma($turmaid)
    {
        $select = DB::select(
            "SELECT
                OT.habilitada, OT.codigo, OT.ofertaturmaid, OT.ofertacursoid, OT.descricao as descricao_turma, OT.minimoalunos, OT.maximoalunos, OT.datainicialoferta, OT.datafinaloferta, OT.datainicialaulas, OT.datafinalaulas, OT.datainicialinscricao, OT.datafinalinscricao, OT.datainicialmatricula, OT.datafinalmatricula, OT.gradehorarioid, OT.situacao as situacao_turma, OT.centerid, OT.localid,

                OFC.ocorrenciacursoid, OFC.descricao as descricao_ofertacurso, OFC.situacao as situacao_ofertacurso,

                OC.situacao as situacao_ocorrenciacurso, OC.cursoid, OC.turnid
            FROM acpofertaturma OT
            INNER JOIN acpofertacurso OFC
                ON OT.ofertacursoid = OFC.ofertacursoid
            INNER JOIN acpocorrenciacurso OC
                ON OFC.ocorrenciacursoid = OC.ocorrenciacursoid
            WHERE OT.ofertaturmaid = :turmaid",
            ['turmaid' => $turmaid]
        );

        $result = [];

        if (count($select)) {

            foreach ($select[0] as $key => $value) {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    /**
     * Unifica consultas e exibe unidades didáticas do curso via turmaid
     *
     * @param integer $turmaid
     * @return array
     */
    public function getCursoMatrizCurricular($turmaid)
    {
        $ofertaCursoTurma = $this->getOfertaCursoTurma($turmaid);
        $cursoid = $ofertaCursoTurma['cursoid'];

        $select = DB::select(
            "SELECT
                C.nome AS nome_curso,
                C.datainicio, C.datafim,

                MC.descricao AS descricao_matriz,

                MCG.matrizcurriculargrupoid AS id_modulo,
                MCG.descricao AS descricao_modulo,

                CC.codigo cod_unidadedidatica,
                CC.nome AS nome_unidadedidatica,

                CCD.cargahorariapresencial,
                CCD.cargahorariaextraclasse,
                CCD.cargahoraria
            FROM acpcurso C
            INNER JOIN acpmatrizcurricular MC
                ON C.cursoid = MC.cursoid
            INNER JOIN acpmatrizcurriculargrupo MCG
                ON MC.matrizcurricularid = MCG.matrizcurricularid
            INNER JOIN acpcomponentecurricularmatriz CCM
                ON MCG.matrizcurriculargrupoid = CCM.matrizcurriculargrupoid
            INNER JOIN acpcomponentecurricular CC
                ON CCM.componentecurricularid = CC.componentecurricularid
            INNER JOIN acpcomponentecurriculardisciplina CCD
                ON CC.componentecurricularid = CCD.componentecurricularid
            WHERE C.cursoid = :cursoid
            ORDER BY MCG.ordem, CC.codigo, CC.nome",
            ['cursoid' => $cursoid]
        );

        $curso = [];
        $modulos = [];

        if (count($select)) {

            $cargaHorariaCurso = 0;

            foreach ($select as $item) {

                if (!array_key_exists($item->id_modulo, $modulos)) {

                    $modulos[$item->id_modulo] = [
                        'id_modulo' => $item->id_modulo,
                        'descricao_modulo' => $item->descricao_modulo,
                        'carga_horaria_modulo' => 0,
                        'unidadedidatica' => [],
                    ];
                }

                $modulos[$item->id_modulo]['unidadedidatica'][] = [
                    'cod_unidadedidatica' => $item->cod_unidadedidatica,
                    'nome_unidadedidatica' => $item->nome_unidadedidatica,
                    'cargahoraria_presencial' => $item->cargahorariapresencial,
                    'cargahoraria_extraclasse' => $item->cargahorariaextraclasse,
                ];

                $modulos[$item->id_modulo]['carga_horaria_modulo'] += $item->cargahoraria;

                $cargaHorariaCurso += $item->cargahoraria;
            }

            $curso = [
                'id_curso' => $cursoid,
                'curso' => $select[0]->nome_curso,
                'descricao_matriz' => $select[0]->descricao_matriz,
                'datainicial' => $ofertaCursoTurma['datainicialoferta'],
                'datafinal' => $ofertaCursoTurma['datafinaloferta'],
                'cargahoraria_curso' => $cargaHorariaCurso
            ];
        }

        return [
            'curso' => $curso,
            'modulos' => $modulos,
        ];
    }

    /**
     * Pegar a lista de alunos inscritos na turma
     *
     * @param integer $ofertaturmaid
     * @param integer $inscricaoid
     * @param string $situacaoaluno 'Aprovado' | 'Reprovado' | 'Cancelado' | 'Pendente' | 'Matriculado'
     * @return array
     */
    public function getInscricoesDaTurma(
        $ofertaturmaid,
        $inscricaoid = null,
        $situacaoaluno = 'Aprovado'
    ) {

        // sem inscricaoid
        if (is_null($inscricaoid)) {

            $select = DB::select(
                "SELECT DISTINCT
                    ITG.inscricaoid,
                    PERSON.name as nome,
                    acp_obtersituacaopedagogicadainscricao(ITG.inscricaoid) as situacaoaluno
                FROM acpinscricaoturmagrupo ITG
                LEFT JOIN acpmatricula MAT
                    ON (ITG.inscricaoturmagrupoid = MAT.inscricaoturmagrupoid)
                LEFT JOIN ONLY basperson PERSON
                    ON (MAT.personid = PERSON.personid)
                WHERE ITG.ofertaturmaid = :ofertaturmaid
                AND acp_obtersituacaopedagogicadainscricao(ITG.inscricaoid) = :situacaoaluno
                ORDER BY PERSON.name",
                [
                    'ofertaturmaid' => $ofertaturmaid,
                    'situacaoaluno' => $situacaoaluno,
                ]
            );

            return $select;
        }

        // com inscricaoid
        $select = DB::select(
            "SELECT DISTINCT
                ITG.inscricaoid,
                PERSON.name as nome,
                acp_obtersituacaopedagogicadainscricao(ITG.inscricaoid) as situacaoaluno
            FROM acpinscricaoturmagrupo ITG
            LEFT JOIN acpmatricula MAT
                ON (ITG.inscricaoturmagrupoid = MAT.inscricaoturmagrupoid)
            LEFT JOIN ONLY basperson PERSON
                ON (MAT.personid = PERSON.personid)
            WHERE ITG.ofertaturmaid = :ofertaturmaid
            AND ITG.inscricaoid = :inscricaoid
            AND acp_obtersituacaopedagogicadainscricao(ITG.inscricaoid) = :situacaoaluno
            ORDER BY PERSON.name",
            [
                'ofertaturmaid' => $ofertaturmaid,
                'inscricaoid' => $inscricaoid,
                'situacaoaluno' => $situacaoaluno,
            ]
        );

        return $select;
    }
}
