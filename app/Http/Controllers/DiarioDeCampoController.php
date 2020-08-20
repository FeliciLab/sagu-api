<?php
namespace App\Http\Controllers;

use App\DAO\DiarioDeCampoDAO;
use App\DAO\OfertaDeRodizioDAO;
use App\DAO\ResidenteDAO;
use App\Model\DiarioDeCampo;
use Illuminate\Http\Request;

class DiarioDeCampoController extends Controller
{
    public function lista(Request $request, $residenteId, $ofertaDeRodizioId)
    {
        $diarioDeCampoDao = new DiarioDeCampoDAO();
        $diarios = $diarioDeCampoDao->diarioDeCampoPorResidenteEOfertaDeRodizio($residenteId, $ofertaDeRodizioId);
        return \response()->json($diarios);
    }


    public function salvar(Request $request, $id = null)
    {
        $dataInicio = $request->input('dataInicio');
        $horaInicio = $request->input('horaInicio');
        $dataFim = $request->input('dataFim');
        $horaFim = $request->input('horaFim');
        $ministrante = $request->input('ministrante');
        $conteudoAbordado = $request->input('conteudoAbordado');
        $ofertaDeRodizioId = $request->input('ofertaDeRodizioId');
        $residenteId = $request->input('residenteId');

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

        $diarioDeCampo = new DiarioDeCampo();
        $diarioDeCampo->setInicio($inicioDataEHora);
        $diarioDeCampo->setFim($fimDataEHora);
        $diarioDeCampo->setCargaHoraria($cargaHoraria->h);
        $diarioDeCampo->setConteudoAbordado($conteudoAbordado);
        $diarioDeCampo->setMinistrante($ministrante);
        $diarioDeCampo->setOfertaDeRodizio($ofertaDeRodizio);
        $diarioDeCampo->setId($id);

        $residenteDao = new ResidenteDAO();
        $residente = $residenteDao->get($residenteId);
        $diarioDeCampo->setResidente($residente);

        $diarioDeCampoDao = new DiarioDeCampoDAO();
        $diarioDeCampo = $diarioDeCampoDao->save($diarioDeCampo);

        return \response()->json($diarioDeCampo);
    }

    public function delete(Request $request, $diarioDeCampoId)
    {
        $diarioDeCampoDao = new DiarioDeCampoDAO();
        $delete = $diarioDeCampoDao->delete($diarioDeCampoId);
        return \response()->json($delete);
    }
}