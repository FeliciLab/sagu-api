<?php
namespace App\Http\Controllers;

use App\DAO\EncontroDAO;
use App\DAO\FrequenciaDAO;
use App\DAO\ResidenteDAO;
use App\Model\Frequencia;
use Illuminate\Http\Request;

class FrequenciaController extends Controller
{
    public function situacoesDeFrequencia(Request $request)
    {
        $frequenciaDao = new FrequenciaDAO();
    
        return \response()->json(array('situacoesDeFrequencia' => $frequenciaDao->situacoesDeFrequencia()));
    }

    public function salvarFrequencia(Request $request)
    {
        $encontroId = $request->input('encontroId');
        $justificativas = $request->input('justificativas');
        $situacoes = $request->input('situacoes');

        $encontroDao = new EncontroDAO();
        $encontro = $encontroDao->get($encontroId);

        $frequencias = array();
        foreach ($situacoes as $residenteId => $situacao) {


            if ($situacao != Frequencia::JUSTIFICADA) {
                $justificativas[$residenteId] = null;
            }

            $frequenciaDao = new FrequenciaDAO();
            $residenteDao = new ResidenteDAO();
            $residente = $residenteDao->get($residenteId);

            $frequencia = $frequenciaDao->frequenciaPorEncontroEResidente($encontro, $residente);

            if ($frequencia != null) {
                $frequencia->setResidente($residente);
                $frequencia->setPresenca($situacao);
                $frequencia->setEncontro($encontro);
                $frequencia->setJustificativa($justificativas[$residenteId]);

                $frequencias = $frequenciaDao->update($frequencia);
            } else {
                $frequencia = new Frequencia();
                $frequencia->setResidente($residente);
                $frequencia->setPresenca($situacao);
                $frequencia->setEncontro($encontro);
                $frequencia->setJustificativa($justificativas[$residenteId]);

                $frequencias = $frequenciaDao->insert($frequencia);
            }
        }

        return \response()->json(['frequencias' => $this->toArray($frequencias)]);
    }
}