<?php
namespace App\Http\Controllers;

use App\DAO\AutoavaliacaoDAO;
use App\DAO\OfertaDeRodizioDAO;
use App\DAO\ResidenteDAO;
use App\Model\Autoavaliacao;
use Illuminate\Http\Request;

class AutoavaliacaoController extends Controller
{
    public function autoavaliar(Request $request, $id = null)
    {
        $nota = $request->input('nota');
        $autoavaliacaoDesc = $request->input('autoavaliacao');
        $residenteId = $request->input('residenteId');
        $ofertaDeRodizioId = $request->input('ofertaDeRodizioId');

        $autoavaliacao = new Autoavaliacao();
        $autoavaliacao->setId($id);
        $autoavaliacao->setNota($nota);
        $autoavaliacao->setAvaliacao($autoavaliacaoDesc);

        $residenteDao = new ResidenteDAO();
        $residente = $residenteDao->get($residenteId);
        $autoavaliacao->setResidente($residente);

        $ofertaDeRodizioDao = new OfertaDeRodizioDAO();
        $ofertaDeRodizio = $ofertaDeRodizioDao->get($ofertaDeRodizioId);
        $autoavaliacao->setOfertaDeRodizio($ofertaDeRodizio);

        $autoAvaliacaoDao = new AutoavaliacaoDAO();

        $auto = $autoAvaliacaoDao->save($autoavaliacao);

        return \response()->json($auto);
    }
}