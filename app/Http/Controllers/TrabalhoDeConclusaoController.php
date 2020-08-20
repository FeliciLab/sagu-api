<?php
namespace App\Http\Controllers;

use App\DAO\ResidenteDAO;
use App\DAO\TrabalhoDeConclusaoDAO;
use App\DAO\TrabalhoDeConclusaoModalidadeDAO;
use App\Model\TrabalhoDeConclusao;
use Illuminate\Http\Request;

class TrabalhoDeConclusaoController extends Controller
{
    public function salvar(Request $request, $id = null)
    {
        $titulo = $request->input('titulo');
        $tema = $request->input('tema');
        $residenteId = $request->input('residenteId');
        $modalidadeId = $request->input('modalidadeid');

        $trabalhoDeConclusao = new TrabalhoDeConclusao();
        $trabalhoDeConclusao->setId($id);
        $trabalhoDeConclusao->setTitulo($titulo);
        $trabalhoDeConclusao->setTema($tema);

        $residenteDao = new ResidenteDAO();
        $trabalhoDeConclusao->setResidente($residenteDao->get($residenteId));

        $modalidadeDao = new TrabalhoDeConclusaoModalidadeDAO();
        $trabalhoDeConclusao->setModalidade($modalidadeDao->get($modalidadeId));

        $trabalhoDeConclusaoDao = new TrabalhoDeConclusaoDAO();
        $trabalhoDeConclusao = $trabalhoDeConclusaoDao->save($trabalhoDeConclusao);

        return \response()->json($trabalhoDeConclusao);
    }
}