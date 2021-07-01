<?php
namespace App\Http\Controllers\ResidenciaMultiprofissional;

use App\DAO\ResidenciaMultiprofissional\EnfaseDAO;
use App\Http\Controllers\Controller;

class EnfaseController extends Controller
{
    public function index()
    {
        $enfaseDao = new EnfaseDAO();
        $enfases = $enfaseDao->getEnfases();
        return \response()->json($enfases);
    }
}