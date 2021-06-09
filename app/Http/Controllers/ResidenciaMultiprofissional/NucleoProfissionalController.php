<?php
namespace App\Http\Controllers\ResidenciaMultiprofissional;

use App\DAO\ResidenciaMultiprofissional\NucleoProfissionalDAO;
use App\Http\Controllers\Controller;

class NucleoProfissionalController extends Controller
{
    public function index()
    {
        $nucleoDAO = new NucleoProfissionalDAO();
        $nucleos = $nucleoDAO->getNucleos();
        return \response()->json($nucleos);
    }
}