<?php

namespace App\Services\ResidenciaMultiprofissional;

use App\DAO\ResidenciaMultiprofissional\CargaHorariaComplementarDAO;
use App\Model\ResidenciaMultiprofissional\CargaHorariaComplementar;
use Illuminate\Support\Facades\DB;

class CargaHoriariaComplementarService
{
    public function salvar($ofertaId, $cargaHorariaComplementar)
    {
        DB::beginTransaction();
        $cargaHorariaArray = [];
        try {
            foreach ($cargaHorariaComplementar as $cargaComplementar) {
                $cargaHorariaComplementar = new CargaHorariaComplementar();
                $cargaHorariaComplementar->id = $cargaComplementar['id'];
                $cargaHorariaComplementar->tipoCargaHorariaComplementar = $cargaComplementar['tipoCargaHorariaComplementar'];
                $cargaHorariaComplementar->residente = $cargaComplementar['residenteId'];
                $cargaHorariaComplementar->cargaHoraria = $cargaComplementar['cargaHoraria'];
                $cargaHorariaComplementar->justificativa = $cargaComplementar['justificativa'];
                $cargaHorariaComplementar->tipoCargaHoraria = $cargaComplementar['tipoCargaHoraria'];
                $cargaHorariaComplementar->oferta = $ofertaId;


                $cargaHorariaComplementarDAO = new CargaHorariaComplementarDAO();
                $cargaHorariaComplementarLancada = $cargaHorariaComplementarDAO->get($cargaHorariaComplementar->id);
                if (!$cargaHorariaComplementarLancada->id) {
                    $cargaHorariaComplementarRetorno = $cargaHorariaComplementarDAO->insert($cargaHorariaComplementar);
                }

                $cargaHorariaArray[] = $cargaHorariaComplementarRetorno;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return $cargaHorariaArray;
    }
}