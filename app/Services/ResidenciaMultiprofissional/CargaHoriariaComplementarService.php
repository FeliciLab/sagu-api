<?php

namespace App\Services\ResidenciaMultiprofissional;

use App\DAO\ResidenciaMultiprofissional\CargaHorariaComplementarDAO;
use App\Model\ResidenciaMultiprofissional\CargaHorariaComplementar;
use Illuminate\Support\Facades\DB;

class CargaHoriariaComplementarService
{
    public function salvar($ofertaId, $cargaHorariaComplementarParams)
    {
        DB::beginTransaction();
        $cargaHorariaArray = [];
        try {
            $cargaHorariaComplementar = new CargaHorariaComplementar();
            $cargaHorariaComplementar->id = isset($cargaHorariaComplementarParams['id']) && $cargaHorariaComplementarParams['id'] > 0 ? $cargaHorariaComplementarParams['id'] : null;
            $cargaHorariaComplementar->tipoCargaHorariaComplementar = $cargaHorariaComplementarParams['tipoCargaHorariaComplementar'];
            $cargaHorariaComplementar->residente = $cargaHorariaComplementarParams['residenteId'];
            $cargaHorariaComplementar->cargaHoraria = $cargaHorariaComplementarParams['cargaHoraria'];
            $cargaHorariaComplementar->justificativa = $cargaHorariaComplementarParams['justificativa'];
            $cargaHorariaComplementar->tipoCargaHoraria = $cargaHorariaComplementarParams['tipoCargaHoraria'];
            $cargaHorariaComplementar->oferta = $ofertaId;


            $cargaHorariaComplementarDAO = new CargaHorariaComplementarDAO();
            $cargaHorariaComplementarLancada = $cargaHorariaComplementarDAO->get($cargaHorariaComplementar->id);
            if (!$cargaHorariaComplementarLancada->id) {
                $cargaHorariaComplementarRetorno = $cargaHorariaComplementarDAO->insert($cargaHorariaComplementar);
            }

            $cargaHorariaArray[] = $cargaHorariaComplementarRetorno;

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return $cargaHorariaArray;
    }
}