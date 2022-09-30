<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get(
    '/',
    function () use ($app) {
        return $app->version();
    }
);


$app->post(
    'auth',
    'AutenticacaoController@auth'
);

$app->post(
    'enviarEmailDeRecuperacaoDeSenha',
    'PersonController@enviarEmailDeRecuperacaoDeSenha'
);


$app->group(
    ['middleware' => ['ApiKeyPublicAuth']],
    function () use ($app) {
        $app->post(
            'person',
            'PersonController@save'
        );

        $app->group(
            ['prefix' => 'ensino-pesquisa-extensao', 'namespace' => 'EnsinoPesquisaExtensao'],
            function () use ($app) {
                $app->get(
                    'ofertas',
                    'OfertaCursoController@ofertas'
                );
                $app->get(
                    'ofertas/{ofertaId}/turmas',
                    'TurmaController@turma'
                );
                // Inscrições
                $app->post(
                    'turma/{turmaId}/inscricao',
                    'IncricaoController@index'
                );
                // Certificados
                $app->get(
                    'turma/{turmaId}/certificados',
                    'CertificateController@generateCertificateByClass'
                );
                $app->get(
                    'turma/{turmaId}/inscricao/{inscricaoid}/certificados',
                    'CertificateController@generateCertificateByStudent'
                );

                $app->get('certificates', '');
            }
        );
    }
);

$app->group(
    ['middleware' => ['auth']],
    function () use ($app) {

        /** INICIO SERVIÇOS DO RESIDENTE */
        // consulta do residente
        $app->get(
            'consultaresidente/{personid}',
            'ConsultaResidenteController@residenciasDoResidente'
        );
        $app->get(
            'consultaresidente/ofertasderodiziodoresidente/{residenteId}',
            'ConsultaResidenteController@ofertasDeRodizioDoResidente'
        );
        $app->get(
            'consultaresidente/ultimasofertasderodiziodoresidente/{personId}',
            'ConsultaResidenteController@ultimasOfertasDeRodizioDoResidente'
        );
        $app->get(
            'consultaresidente/atualofertaderodiziodoresidente/{personId}',
            'ConsultaResidenteController@atualOfertaDeRodizioDoResidente'
        );

        // autoavaliação
        $app->post(
            'autoavaliacao',
            'AutoavaliacaoController@autoavaliar'
        );
        $app->put(
            'autoavaliacao/{id}',
            'AutoavaliacaoController@autoavaliar'
        );

        // diario de campo
        $app->get(
            'diariodecampo/{residenteId}/{ofertaDeRodizioId}',
            'DiarioDeCampoController@lista'
        );
        $app->post(
            'diariodecampo',
            'DiarioDeCampoController@salvar'
        );
        $app->put(
            'diariodecampo/{id}',
            'DiarioDeCampoController@salvar'
        );
        $app->delete(
            'diariodecampo/{diarioDeCampoId}',
            'DiarioDeCampoController@delete'
        );

        //trabalho de conclusão
        $app->get(
            'trabalhodeconclusao/modalidades',
            'TrabalhoDeConclusaoModalidadeController@lista'
        );
        $app->post(
            'trabalhodeconclusao',
            'TrabalhoDeConclusaoController@salvar'
        );
        $app->put(
            'trabalhodeconclusao/{id}',
            'TrabalhoDeConclusaoController@salvar'
        );
        $app->get(
            'penalidade/{residenteId}',
            'PenalidadeController@lista'
        );

        $app->get(
            'estado',
            'EstadoController@lista'
        );

        $app->get(
            'cidade/cidadesPorEstado/{estadoId}',
            'CidadeController@cidadesPorEstado'
        );

        $app->get(
            'pessoa/{pessoaId}',
            'PersonController@lista'
        );
        $app->put(
            'pessoa/{pessoaId}',
            'PersonController@salvar'
        );

        $app->get(
            'indicador/semanas/{ofertaDeRodizioId}',
            'IndicadorController@listaSemanas'
        );
        $app->post(
            'indicador/indicadores',
            'IndicadorController@indicadores'
        );

        $app->post(
            'indicadorresidente/indicadoresdoresidente',
            'IndicadorResidenteController@indicadoresDoResidente'
        );
        $app->post(
            'indicadorresidente/salvar',
            'IndicadorResidenteController@salvar'
        );
        /** FIM SERVIÇOS DO RESIDENTE */


        /** INICIO SERVIÇOS DO PRECEPTOR */
        $app->get(
            'consultapreceptor/ofertasderodiziodopreceptor/{preceptorId}',
            'ConsultaPreceptorController@ofertasDeRodizioDoPreceptor'
        );

        $app->get(
            'diariodecampopreceptor/{preceptorId}/{ofertaDeRodizioId}',
            'DiarioDeCampoPreceptorController@lista'
        );
        $app->post(
            'diariodecampopreceptor',
            'DiarioDeCampoPreceptorController@salvar'
        );
        $app->put(
            'diariodecampopreceptor/{id}',
            'DiarioDeCampoPreceptorController@salvar'
        );
        $app->delete(
            'diariodecampopreceptor/{diarioDeCampoPreceptorId}',
            'DiarioDeCampoPreceptorController@delete'
        );
        $app->post(
            'consultapreceptor/residentes',
            'ConsultaPreceptorController@residentesPorOfertaDeRodizio'
        );
        $app->post(
            'consultapreceptor/notasDosResidentesNaOfertaDeRodizioPorPreceptor',
            'ConsultaPreceptorController@notasDosResidentesNaOfertaDeRodizioPorPreceptor'
        );
        $app->post(
            'consultapreceptor/salvarnotas',
            'ConsultaPreceptorController@salvarNotas'
        );
        $app->post(
            'indicadorresidente/indicadoresrespondidosdoresidenteporperiododaofertaderodizio',
            'IndicadorResidenteController@indicadoresRespondidosDoResidentePorPeriodoDaOfertaDeRodizio'
        );
        $app->post(
            'indicadorresidente/salvarjustificativas',
            'IndicadorResidenteController@salvarjustificativas'
        );
        $app->post(
            'consultapreceptor/salvarfaltas',
            'ConsultaPreceptorController@salvarFaltas'
        );
        $app->post(
            'consultapreceptor/faltasDosResidentesNaOfertaDeRodizio',
            'ConsultaPreceptorController@faltasDosResidentesNaOfertaDeRodizio'
        );
        $app->get(
            'encontro/encontrosDaOfertaDeRodizio/{ofertaDeRodizioId}',
            'EncontroController@encontrosDaOfertaDeRodizio'
        );
        $app->get(
            'frequencia/situacoesDeFrequencia',
            'FrequenciaController@situacoesDeFrequencia'
        );
        $app->get(
            'encontro/frequencias/{encontroId}',
            'EncontroController@frequenciasDoEncontro'
        );
        $app->put(
            'frequencia/salvar',
            'FrequenciaController@salvarFrequencia'
        );

        //** RESIDÊNCIA MULTIPROFISSIONAL - SUPERVISOR */
        $app->group(
            ['prefix' => 'residencia-multiprofissional', 'namespace' => 'ResidenciaMultiprofissional'],
            function () use ($app) {
                $app->get(
                    'enfases',
                    'EnfaseController@index'
                );
                $app->get(
                    'nucleos-profissionais',
                    'NucleoProfissionalController@index'
                );
                $app->get(
                    'carga-horaria/tipos',
                    'TipoCargaHorariaController@consultarTipos'
                );
                $app->get(
                    'carga-horaria-complementar/tipos',
                    'TipoCargaHorariaComplementarController@index'
                );
                $app->group(
                    ['prefix' => 'supervisores'],
                    function () use ($app) {
                        $app->get(
                            '/turmas[/{page}]',
                            'TurmaSupervisorController@turmasSupervisor'
                        );
                        $app->get(
                            '/turma/{turma}/ofertas[/{page}]',
                            'OfertaModuloController@index'
                        );
                        $app->get(
                            '/turma/{turma}/oferta/{oferta}/residentes[/{residenteId}]',
                            'OfertaModuloController@residentes'
                        );
                        $app->post(
                            '/turma/{turma}/oferta/{oferta}/faltas',
                            'OfertaModuloFaltaController@store'
                        );
                        $app->post(
                            '/turma/{turma}/oferta/{oferta}/notas',
                            'OfertaModuloNotaController@store'
                        );
                        $app->post(
                            '/turma/{turma}/oferta/{oferta}/cargahoraria-complementar',
                            'CargaHorariaComplementarController@store'
                        );
                        $app->put(
                            '/turma/{turma}/oferta/{oferta}/cargahoraria-complementar/{id}',
                            'CargaHorariaComplementarController@store'
                        );
                        $app->delete(
                            '/turma/{turma}/oferta/{oferta}/cargahoraria-complementar/{id}',
                            'CargaHorariaComplementarController@delete'
                        );
                    }
                );
            }
        );
    }
);
