<?php
namespace App\Http\Controllers;

use App\DAO\ResidenteDAO;
use Illuminate\Http\Request;


class ConsultaResidenteController extends Controller
{
    public function residenciasDoResidente(Request $request, $personid)
    {
        $dao = new ResidenteDAO();
        $residencias = $dao->retornaResidenciasDaPessoa($personid);

        return \response()->json(['residencias' => $this->toArray($residencias)]);
    }

    public function ofertasDeRodizioDoResidente(Request $request, $residenteId)
    {
        $dao = new ResidenteDAO();
        $ofertasDeRodizio = $dao->retornaOfertasDeRodizioDoResidente($residenteId);

        return \response()->json(['ofertasDeRodizio' => $this->toArray($ofertasDeRodizio)]);
    }


    public function ultimasOfertasDeRodizioDoResidente(Request $request, $personId)
    {

        $residenteDao = new ResidenteDAO();
        $residente = $residenteDao->retornaUltimaResidenciaDaPessoa($personId);

        $params = new \stdClass();
        $params->residenteId = $residente->getId();
        $params->dataAtual = new \DateTime('now');

        $ofertasDeRodizio = $residenteDao->retornaUltimasOfertasDeRodizioDoResidente($params);

        return \response()->json(['ofertasDeRodizio' => $this->toArray($ofertasDeRodizio)]);
    }

    public function atualOfertaDeRodizioDoResidente(Request $request, $personId)
    {

        $residenteDao = new ResidenteDAO();
        $residente = $residenteDao->retornaUltimaResidenciaDaPessoa($personId);

        $params = new \stdClass();
        $params->residenteId = $residente->getId();
        $params->dataAtual = new \DateTime('now');

        $ofertaDeRodizio = $residenteDao->retornaatualOfertaDeRodizioDoResidente($params);

        return \response()->json(['ofertaDeRodizio' => $this->toArray($ofertaDeRodizio)]);
    }
}