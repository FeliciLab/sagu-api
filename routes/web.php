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

$app->get('/', function () use ($app) {
    return $app->version();
});


$app->post('auth', [
    'uses' => 'AutenticacaoController@auth'
]);

$app->post('enviarEmailDeRecuperacaoDeSenha', [
    'uses' => 'PersonController@enviarEmailDeRecuperacaoDeSenha'
]);

$app->group(['middleware' => ['auth']], function () use ($app) {

    /** INICIO SERVIÇOS DO RESIDENTE */
    // consulta do residente
    $app->get('consultaresidente/{personid}', 'ConsultaResidenteController@residenciasDoResidente');
    $app->get('consultaresidente/ofertasderodiziodoresidente/{residenteId}', 'ConsultaResidenteController@ofertasDeRodizioDoResidente');
    $app->get('consultaresidente/ultimasofertasderodiziodoresidente/{personId}', 'ConsultaResidenteController@ultimasOfertasDeRodizioDoResidente');
    $app->get('consultaresidente/atualofertaderodiziodoresidente/{personId}', 'ConsultaResidenteController@atualOfertaDeRodizioDoResidente');

    // autoavaliação
    $app->post('autoavaliacao', ['uses' => 'AutoavaliacaoController@autoavaliar']);
    $app->put('autoavaliacao/{id}', ['uses' => 'AutoavaliacaoController@autoavaliar']);

    // diario de campo
    $app->get('diariodecampo/{residenteId}/{ofertaDeRodizioId}', 'DiarioDeCampoController@lista');
    $app->post('diariodecampo', ['uses' => 'DiarioDeCampoController@salvar']);
    $app->put('diariodecampo/{id}', ['uses' => 'DiarioDeCampoController@salvar']);
    $app->delete('diariodecampo/{diarioDeCampoId}', ['uses' => 'DiarioDeCampoController@delete']);

    //trabalho de conclusão
    $app->get('trabalhodeconclusao/modalidades', 'TrabalhoDeConclusaoModalidadeController@lista');
    $app->post('trabalhodeconclusao', ['uses' => 'TrabalhoDeConclusaoController@salvar']);
    $app->put('trabalhodeconclusao/{id}', ['uses' => 'TrabalhoDeConclusaoController@salvar']);

    $app->get('penalidade/{residenteId}', 'PenalidadeController@lista');

    $app->get('estado', 'EstadoController@lista');

    $app->get('cidade/cidadesPorEstado/{estadoId}', 'CidadeController@cidadesPorEstado');

    $app->get('pessoa/{pessoaId}', 'PersonController@lista');
    $app->put('pessoa/{pessoaId}', 'PersonController@salvar');

    $app->get('indicador/semanas/{ofertaDeRodizioId}', 'IndicadorController@listaSemanas');
    $app->post('indicador/indicadores', 'IndicadorController@indicadores');

    $app->post('indicadorresidente/indicadoresdoresidente', 'IndicadorResidenteController@indicadoresDoResidente');
    $app->post('indicadorresidente/salvar', 'IndicadorResidenteController@salvar');
    /** FIM SERVIÇOS DO RESIDENTE */


    /** INICIO SERVIÇOS DO PRECEPTOR */
    $app->get('consultapreceptor/ofertasderodiziodopreceptor/{preceptorId}', 'ConsultaPreceptorController@ofertasDeRodizioDoPreceptor');

    $app->get('diariodecampopreceptor/{preceptorId}/{ofertaDeRodizioId}', 'DiarioDeCampoPreceptorController@lista');
    $app->post('diariodecampopreceptor', ['uses' => 'DiarioDeCampoPreceptorController@salvar']);
    $app->put('diariodecampopreceptor/{id}', ['uses' => 'DiarioDeCampoPreceptorController@salvar']);
    $app->delete('diariodecampopreceptor/{diarioDeCampoPreceptorId}', ['uses' => 'DiarioDeCampoPreceptorController@delete']);

    $app->post('consultapreceptor/residentes', ['uses' => 'ConsultaPreceptorController@residentesPorOfertaDeRodizio']);
    $app->post('consultapreceptor/notasDosResidentesNaOfertaDeRodizioPorPreceptor', ['uses' => 'ConsultaPreceptorController@notasDosResidentesNaOfertaDeRodizioPorPreceptor']);
    $app->post('consultapreceptor/salvarnotas', ['uses' => 'ConsultaPreceptorController@salvarNotas']);
    $app->post('indicadorresidente/indicadoresrespondidosdoresidenteporperiododaofertaderodizio', ['uses' => 'IndicadorResidenteController@indicadoresRespondidosDoResidentePorPeriodoDaOfertaDeRodizio']);
    $app->post('indicadorresidente/salvarjustificativas', ['uses' => 'IndicadorResidenteController@salvarjustificativas']);
    $app->post('consultapreceptor/salvarfaltas', ['uses' => 'ConsultaPreceptorController@salvarFaltas']);
    $app->post('consultapreceptor/faltasDosResidentesNaOfertaDeRodizio', ['uses' => 'ConsultaPreceptorController@faltasDosResidentesNaOfertaDeRodizio']);
    $app->get('encontro/encontrosDaOfertaDeRodizio/{ofertaDeRodizioId}', 'EncontroController@encontrosDaOfertaDeRodizio');
    $app->get('frequencia/situacoesDeFrequencia', 'FrequenciaController@situacoesDeFrequencia');
    $app->get('encontro/frequencias/{encontroId}', 'EncontroController@frequenciasDoEncontro');
    $app->put('frequencia/salvar', ['uses' => 'FrequenciaController@salvarFrequencia']);

    //** RESIDÊNCIA MULTIPROFISSIONAL - SUPERVISOR */
    $app->group(['prefix' => 'residencia-multiprofissional'], function () use ($app) {
        $app->get('/supervisor-turmas', 'ResidenciaMultiprofissional\ConsultaSupervisorController@turmasSupervisor');
    });
});
