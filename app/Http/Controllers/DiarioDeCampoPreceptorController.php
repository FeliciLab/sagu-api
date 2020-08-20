<?php
namespace App\Http\Controllers;

use App\DAO\DiarioDeCampoPreceptorDAO;
use App\DAO\OfertaDeRodizioDAO;
use App\DAO\PreceptorDAO;
use App\Model\DiarioDeCampoPreceptor;
use Illuminate\Http\Request;

class DiarioDeCampoPreceptorController extends Controller
{
    public function lista(Request $request, $preceptorId, $ofertaDeRodizioId)
    {
        $diarioDeCampoPreceptorDao = new DiarioDeCampoPreceptorDAO();
        $diarios = $diarioDeCampoPreceptorDao->diarioDeCampoPorPreceptorEOfertaDeRodizio($preceptorId, $ofertaDeRodizioId);
        return \response()->json($diarios);
    }


    public function salvar(Request $request, $id = null)
    {
        $dataInicio = $request->input('dataInicio');
        $horaInicio = $request->input('horaInicio');
        $dataFim = $request->input('dataFim');
        $horaFim = $request->input('horaFim');
        $conteudoAbordado = $request->input('conteudoAbordado');
        $ofertaDeRodizioId = $request->input('ofertaDeRodizioId');
        $preceptorId = $request->input('preceptorId');

        $ofertaDeRodizioDao = new OfertaDeRodizioDAO();
        $ofertaDeRodizio = $ofertaDeRodizioDao->get($ofertaDeRodizioId);


        $inicio = new \DateTime($dataInicio);
        $fim = new \DateTime($dataFim);

        $inicioDataEHora = new \DateTime($dataInicio . ' ' . $horaInicio);
        $fimDataEHora = new \DateTime($dataFim . ' ' . $horaFim);

        if ($inicio < $ofertaDeRodizio->getInicioObject() || $inicio > $ofertaDeRodizio->getFimObject()
        || $fim < $ofertaDeRodizio->getInicioObject() || $fim > $ofertaDeRodizio->getFimObject() ) {
            $retorno = array(
                'sucesso' => false,
                'mensagem' => 'Você está tentando cadastrar um diário fora do período da oferta de rodízio'
            );

            return \response()->json($retorno);
        }

        if ($fimDataEHora < $inicioDataEHora) {
            $retorno = array(
                'sucesso' => false,
                'mensagem' => 'A data ou hora de início não pode ser maior que a de fim'
            );

            return \response()->json($retorno);
        }

        $cargaHoraria = $inicioDataEHora->diff($fimDataEHora);

        $diarioDeCampoPreceptor = new DiarioDeCampoPreceptor();
        $diarioDeCampoPreceptor->setInicio($inicioDataEHora);
        $diarioDeCampoPreceptor->setFim($fimDataEHora);
        $diarioDeCampoPreceptor->setCargaHoraria($cargaHoraria->h);
        $diarioDeCampoPreceptor->setConteudoAbordado($conteudoAbordado);
        $diarioDeCampoPreceptor->setOfertaDeRodizio($ofertaDeRodizio);
        $diarioDeCampoPreceptor->setId($id);

        $preceptorDao = new PreceptorDAO();
        $preceptor = $preceptorDao->get($preceptorId);
        $diarioDeCampoPreceptor->setPreceptor($preceptor);

        $diarioDeCampoPreceptorDao = new DiarioDeCampoPreceptorDAO();
        $diarioDeCampoPreceptor = $diarioDeCampoPreceptorDao->save($diarioDeCampoPreceptor);

        return \response()->json($diarioDeCampoPreceptor);
    }

    public function delete(Request $request, $diarioDeCampoPreceptorId)
    {
        $diarioDeCampoPreceptorDao = new DiarioDeCampoPreceptorDAO();
        $delete = $diarioDeCampoPreceptorDao->delete($diarioDeCampoPreceptorId);
        return \response()->json($delete);
    }
}