<?php
namespace App\Http\Controllers;

use App\DAO\IndicadorDAO;
use App\DAO\OfertaDeRodizioDAO;
use App\DAO\ResidenteDAO;
use App\Model\Indicador;
use Illuminate\Http\Request;

class IndicadorController extends Controller
{
    public function listaSemanas(Request $request, $ofertaDeRodizioId = null)
    {
        $ofertaDeRodizioDao = new OfertaDeRodizioDAO();
        $ofertaDeRodizio = $ofertaDeRodizioDao->get($ofertaDeRodizioId);

        $data = $this->retornaDatasIntervaloDoResidente($ofertaDeRodizio->getInicioObject(), $ofertaDeRodizio->getFimObject());

        return \response()->json($data);
    }


    private function retornaDatasIntervaloDoResidente(\DateTime $inicio, \DateTime $fim, $tipoDeIntervalo = Indicador::PERIODICIDADE_SEMANA) {
        $hoje = date('Y-m-d');
        $inicioResidente = $inicio->format('Y-m-d');
        $datas = array();

        if ($tipoDeIntervalo == Indicador::PERIODICIDADE_SEMANA) {
            $intervalo = '+1 week';
        }

        if (!is_null($intervalo)) {

            while ($inicioResidente <= $hoje) {

                $date = new \DateTime($inicioResidente);

                $diaInicioSemanaResidente = $date->format('d');

                // se o dia iniciado for menor que 7, então deverá começar do dia 01 do mês para preencher
                if ($diaInicioSemanaResidente <= 7) {
                    $inicioSemanaResidente = $date->format('Y-m-01');
                } else {
                    $inicioSemanaResidente = $date->format('Y-m-d');
                }

                $date = new \DateTime($inicioSemanaResidente);

                $date->modify($intervalo);

                $inicioResidente  = $date->format('Y-m-d');
                $diaFimSemanaResidente = $date->format('d');
                $fimSemanaResidente = $inicioResidente;

                if ($diaInicioSemanaResidente < $diaFimSemanaResidente) {
                    if ($fimSemanaResidente <= $fim->format('Y-m-d')) {

                        $iniDate = new \DateTime($inicioSemanaResidente);
                        $fimDate = new \DateTime($fimSemanaResidente);

                        $d = new \StdClass();
                        $d->id = $iniDate->format('Y-m-d') . '_' . ($fimDate->format('Y-m-d') >= $fimDate->format('Y-m-28') ? $fimDate->format('Y-m-t') : $fimDate->format('Y-m-d'));
                        $d->valor = $iniDate->format('d/m/Y') . ' a ' . ($fimDate->format('d/m/Y') >= $fimDate->format('28/m/Y') ? $fimDate->format('t/m/Y') : $fimDate->format('d/m/Y') );
                        $datas[] = $d;

                    }
                }
            }
        }


        return $datas;
    }

    public function indicadores(Request $request)
    {
        $residenteId = $request->input('residenteId');

        $residenteDao = new ResidenteDAO();
        $residente = $residenteDao->get($residenteId);


        $parametros = new \stdClass();
        $parametros->residente = $residente;


        $indicadorDao = new IndicadorDAO();
        $indicadores = $indicadorDao->indicadoresPorEspecialidade($parametros);

        return \response()->json($indicadores);
    }

}