<?php
namespace App\Http\Controllers;

use App\DAO\FaltaDoResidenteNaOfertaDeRodizioDAO;
use App\DAO\NotaDoResidenteNaOfertaDeRodizioPreceptorDAO;
use App\DAO\OfertaDeRodizioDAO;
use App\DAO\OfertaDoResidenteDAO;
use App\DAO\PreceptorDAO;
use App\DAO\ResidenteDAO;
use App\Model\NotaDoResidenteNaOfertaDeRodizioPreceptor;
use Illuminate\Http\Request;


class ConsultaPreceptorController extends Controller
{
    public function ofertasDeRodizioDoPreceptor(Request $request, $preceptorId)
    {
        $preceptorDao = new PreceptorDAO();
        $ofertasDeRodizio = $preceptorDao->retornaOfertasDeRodizioDoPreceptor($preceptorId);

        return \response()->json(['ofertasDeRodizio' => $this->toArray($ofertasDeRodizio)]);
    }

    public function residentesPorOfertaDeRodizio(Request $request)
    {
        $ofertaDeRodizioId = $request->input('ofertaDeRodizioId');

        $ofertaDeRodizioDao = new OfertaDeRodizioDAO();
        $ofertaDeRodizio = $ofertaDeRodizioDao->get($ofertaDeRodizioId);

        $ofertaDoResidenteDao = new OfertaDoResidenteDAO();
        $residentes = $ofertaDoResidenteDao->retornaResidentesPorOfertaDeRodizio($ofertaDeRodizio);

        return \response()->json(['residentes' => $this->toArray($residentes)]);
    }

    public function salvarNotas(Request $request)
    {
        $ofertaDeRodizioId = $request->input('ofertaDeRodizioId');
        $preceptorId = $request->input('preceptorId');
        $notas = $request->input('notas');

        $ofertaDeRodizioDao = new OfertaDeRodizioDAO();
        $ofertaDeRodizio = $ofertaDeRodizioDao->get($ofertaDeRodizioId);

        $preceptorDao = new PreceptorDAO();
        $preceptor = $preceptorDao->get($preceptorId);

        $notasDoResidenteNaOfertaDeRodizioPreceptor = array();

        foreach ($notas as $residenteId => $nota) {
            $notaDoResidenteNaOfertaDeRodizioPreceptor = new NotaDoResidenteNaOfertaDeRodizioPreceptor();

            $notaDoResidenteNaOfertaDeRodizioPreceptor->setPreceptor($preceptor);
            $notaDoResidenteNaOfertaDeRodizioPreceptor->setOfertaDeRodizio($ofertaDeRodizio);

            $residenteDao = new ResidenteDAO();
            $notaDoResidenteNaOfertaDeRodizioPreceptor->setResidente($residenteDao->get($residenteId));

            $notaDao = new NotaDoResidenteNaOfertaDeRodizioPreceptorDAO();
            $nota_ = $notaDao->retornaNotaPorPreceptorOfertaDeRodizioEResidente($notaDoResidenteNaOfertaDeRodizioPreceptor);

            if ($nota_->getId() > 0) {
                $nota_->setNota($nota);
                $notasDoResidenteNaOfertaDeRodizioPreceptor[] = $notaDao->update($nota_);
            } else {
                $notaDoResidenteNaOfertaDeRodizioPreceptor->setNota($nota);
                $notasDoResidenteNaOfertaDeRodizioPreceptor[] = $notaDao->insert($notaDoResidenteNaOfertaDeRodizioPreceptor);
            }

        }

        return \response()->json(['notas' => $this->toArray($notasDoResidenteNaOfertaDeRodizioPreceptor)]);
    }

    public function notasDosResidentesNaOfertaDeRodizioPorPreceptor(Request $request)
    {
        $ofertaDeRodizioId = $request->input('ofertaDeRodizioId');
        $preceptorId = $request->input('preceptorId');

        $ofertaDeRodizioDao = new OfertaDeRodizioDAO();
        $ofertaDeRodizio = $ofertaDeRodizioDao->get($ofertaDeRodizioId);

        $preceptorDao = new PreceptorDAO();
        $preceptor = $preceptorDao->get($preceptorId);

        $notaDao = new NotaDoResidenteNaOfertaDeRodizioPreceptorDAO();
        $notas = $notaDao->notasDosResidentesNaOfertaDeRodizioPorPreceptor($preceptor, $ofertaDeRodizio);

        return \response()->json(['notas' => $this->toArray($notas)]);
    }

    public function salvarFaltas(Request $request)
    {
        $ofertaDeRodizioId = $request->input('ofertaDeRodizioId');
        $faltas = $request->input('faltas');
        $observacoes = $request->input('observacoes');

        $ofertaDeRodizioDao = new OfertaDeRodizioDAO();
        $ofertaDeRodizio = $ofertaDeRodizioDao->get($ofertaDeRodizioId);

        $faltasDoResidenteNaOfertaDeRodizio = array();

        foreach ($faltas as $residenteId => $falta) {
            $faltaDoResidenteNaOfertaDeRodizioDao = new FaltaDoResidenteNaOfertaDeRodizioDAO();

            $residenteDao = new ResidenteDAO();
            $residente = $residenteDao->get($residenteId);


            if ($ofertaDeRodizio->getRodizio()->getCargaHoraria() < $falta) {
                $retorno = array(
                    'sucesso' => false,
                    'mensagem' => 'A falta informada não pode ser superior a carga horaria configurada para o rodízio - (' . $ofertaDeRodizio->getRodizio()->getCargaHoraria() . 'hrs)'
                );

                return \response()->json($retorno);
            }


            $faltaDoResidenteNaOfertaDeRodizio = $faltaDoResidenteNaOfertaDeRodizioDao->faltaDoResidenteNaOfertaDeRodizio($residente, $ofertaDeRodizio);

            $faltaDoResidenteNaOfertaDeRodizio->setFalta($falta);
            $faltaDoResidenteNaOfertaDeRodizio->setResidente($residente);
            $faltaDoResidenteNaOfertaDeRodizio->setOfertaDeRodizio($ofertaDeRodizio);
            $faltaDoResidenteNaOfertaDeRodizio->setObservacao($observacoes[$residenteId]);

            $faltasDoResidenteNaOfertaDeRodizio[] = $faltaDoResidenteNaOfertaDeRodizioDao->save($faltaDoResidenteNaOfertaDeRodizio);
        }

        return \response()->json(['faltas' => $this->toArray($faltasDoResidenteNaOfertaDeRodizio)]);
    }

    public function faltasDosResidentesNaOfertaDeRodizio(Request $request)
    {
        $ofertaDeRodizioId = $request->input('ofertaDeRodizioId');

        $ofertaDeRodizioDao = new OfertaDeRodizioDAO();
        $ofertaDeRodizio = $ofertaDeRodizioDao->get($ofertaDeRodizioId);


        $faltaDao = new FaltaDoResidenteNaOfertaDeRodizioDAO();
        $faltas = $faltaDao->faltasDosResidentesNaOfertaDeRodizio($ofertaDeRodizio);

        return \response()->json(['faltas' => $this->toArray($faltas)]);
    }

}