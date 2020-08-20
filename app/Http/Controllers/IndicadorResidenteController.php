<?php
namespace App\Http\Controllers;

use App\DAO\IndicadorDAO;
use App\DAO\IndicadorResidenteDAO;
use App\DAO\OfertaDeRodizioDAO;
use App\DAO\PreceptorDAO;
use App\DAO\ResidenteDAO;
use App\Model\Indicador;
use App\Model\IndicadorResidente;
use Illuminate\Http\Request;

class IndicadorResidenteController extends Controller
{
    public function indicadoresDoResidente(Request $request)
    {
        $residenteId = $request->input('residenteId');
        $semanas = explode('_', $request->input('semana'));
        $inicio = new \DateTime($semanas[0]);
        $fim = new \DateTime($semanas[1]);

        $residenteDao = new ResidenteDAO();
        $residente = $residenteDao->get($residenteId);

        $parametros = new \stdClass();
        $parametros->inicio = $inicio;
        $parametros->fim = $fim;
        $parametros->residente = $residente;


        $indicadorResidenteDao = new IndicadorResidenteDAO();
        $indicadoresResidente = $indicadorResidenteDao->retornaIndicadoresDoResidentePorSemana($parametros);

        return \response()->json($indicadoresResidente);
    }

    public function salvar(Request $request)
    {
        $residenteId = $request->input('residenteId');
        $quantidades = $request->input('quantidade');
        $semana = explode('_', $request->input('semana'));

        $inicio = $semana[0];
        $fim = $semana[1];

        foreach ($quantidades as $indicador => $quantidade) {
            $indicadorResidenteDao = new IndicadorResidenteDAO();

            $indicadorResidente = new IndicadorResidente();
            $residenteDao = new ResidenteDAO();
            $indicadorResidente->setResidente($residenteDao->get($residenteId));

            $indicadorDao = new IndicadorDAO();
            $indicadorResidente->setIndicador($indicadorDao->get($indicador));

            $indicadorResidente->setPeriodoInicio($inicio);
            $indicadorResidente->setPeriodoFim($fim);
            $indicadorResidente->setSituacao(IndicadorResidente::SITUACAO_AGUARDANDO_AVALIACAO);

            $indi = $indicadorResidenteDao->retornaIndicadorDoResidentePorSemana($indicadorResidente);
            if ($indi->getId() > 0) {
                $indi->setQuantidade($quantidade);
                $indicadorResidente = $indicadorResidenteDao->update($indi);
            } else {
                $indicadorResidente->setQuantidade($quantidade);
                $indicadorResidente = $indicadorResidenteDao->insert($indicadorResidente);
            }
        }

        return \response()->json($indicadorResidente);
    }

    public function indicadoresRespondidosDoResidentePorPeriodoDaOfertaDeRodizio(Request $request)
    {
        $residenteId = $request->input('residenteId');
        $ofertaDeRodizioId = $request->input('ofertaDeRodizioId');


        $residenteDao = new ResidenteDAO();
        $ofertaDeRodizioDao = new OfertaDeRodizioDAO();

        $ofertaDeRodizio = $ofertaDeRodizioDao->get($ofertaDeRodizioId);

        $parametros = new \stdClass();
        $parametros->residente = $residenteDao->get($residenteId);
        $parametros->inicio = $ofertaDeRodizio->getInicioObject()->format('Y-m-d');
        $parametros->fim = $ofertaDeRodizio->getFimObject()->format('Y-m-d');


        $indicadorResidenteDao = new IndicadorResidenteDAO();
        $indicadoresRespondidosDoResidenteNaOfertaDeRodizio = $indicadorResidenteDao->retornaIndicadoresRespondidosDoResidentePorPeriodoDaOfertaDeRodizio($parametros);

        return \response()->json($indicadoresRespondidosDoResidenteNaOfertaDeRodizio);
    }

    public function salvarjustificativas(Request $request)
    {
        $justificativas = $request->input('justificativas');
        $situacoes = $request->input('situacoes');
        $preceptorId = $request->input('preceptorId');

        $preceptorDao = new PreceptorDAO();
        $preceptor = $preceptorDao->get($preceptorId);

        $residenteIndicadores = array();
        foreach ($justificativas as $residenteIndicadorId => $justificativa) {
            $residenteIndicadorDao = new IndicadorResidenteDAO();
            $residenteIndicador = $residenteIndicadorDao->get($residenteIndicadorId);
            $residenteIndicador->setSituacao($situacoes[$residenteIndicadorId]);
            $residenteIndicador->setJustificativa($justificativa);
            $residenteIndicador->setPreceptor($preceptor);
            $residenteIndicadores[] = $residenteIndicadorDao->updateJustificativa($residenteIndicador);
        }

        return \response()->json($residenteIndicadores);
    }
}