<?php

namespace App\Services\ResidenciaMultiprofissional;

use App\DAO\ResidenciaMultiprofissional\OfertaModuloFaltaDAO;
use App\Model\BaseModel\BaseModelSagu;
use App\Model\ResidenciaMultiprofissional\OfertaModuloFalta;
use Illuminate\Support\Facades\DB;

class OfertaModuloFaltaService
{
    public function salvarFaltas($oferta, $faltas)
    {
        DB::beginTransaction();
        $faltasArray = [];
        try {
            foreach ($faltas as $falta) {
                $ofertaModuloFalta = new OfertaModuloFalta();
                $ofertaModuloFalta->ofertaId = $oferta;
                $ofertaModuloFalta->residenteId = $falta['residenteid'];
                $ofertaModuloFalta->tipo = $falta['tipo'];
                $ofertaModuloFalta->observacao = $falta['observacao'];
                $ofertaModuloFalta->falta = $falta['falta'];

                $ofertaModuloFaltaDAO = new OfertaModuloFaltaDAO();

                $faltaLancada = $ofertaModuloFaltaDAO->get($ofertaModuloFalta->residenteId, $ofertaModuloFalta->ofertaId, $ofertaModuloFalta->tipo);
                if (!$faltaLancada->id) {
                    $ofertaModuloFaltaRetorno = $ofertaModuloFaltaDAO->insert($ofertaModuloFalta);
                } else {
                    $ofertaModuloFalta->id = $faltaLancada->id;
                    $ofertaModuloFaltaRetorno = $ofertaModuloFaltaDAO->update($ofertaModuloFalta);
                }

                $faltasArray[] = $ofertaModuloFaltaRetorno;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return $faltasArray;
    }
}