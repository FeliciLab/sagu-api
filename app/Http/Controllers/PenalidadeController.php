<?php
namespace App\Http\Controllers;

use App\DAO\PenalidadeDAO;
use Illuminate\Http\Request;

class PenalidadeController extends Controller
{
    public function lista(Request $request, $residenteId)
    {
        $penalidadeDao = new PenalidadeDAO();
        $penalidades = $penalidadeDao->getPorResidente($residenteId);
        return \response()->json($penalidades);
    }
}