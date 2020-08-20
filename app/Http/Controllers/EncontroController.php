<?php
namespace App\Http\Controllers;

use App\DAO\EncontroDAO;
use App\DAO\FrequenciaDAO;
use App\DAO\OfertaDeRodizioDAO;
use Illuminate\Http\Request;

class EncontroController extends Controller
{
    public function encontrosDaOfertaDeRodizio(Request $request, $ofertaDeRodizioId)
    {
        $encontroDao = new EncontroDAO();
        $ofertaDeRodizioDao = new OfertaDeRodizioDAO();

        $encontros = $encontroDao->retornaEncontrosDaOfertaDeRodizio($ofertaDeRodizioDao->get($ofertaDeRodizioId));
    
        return \response()->json(array('encontros' => $encontros));
    }

    public function frequenciasDoEncontro(Request $request, $encontroId)
    {
        $encontroDao = new EncontroDAO();
        $frequenciaDao = new FrequenciaDAO();

        $frequencias = $frequenciaDao->frequenciaPorEncontro($encontroDao->get($encontroId));
        return \response()->json(array('frequencias' => $frequencias));
    }
}