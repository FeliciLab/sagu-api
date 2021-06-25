<?php

namespace App\Services\ResidenciaMultiprofissional;

use App\DAO\ResidenciaMultiprofissional\CargaHorariaComplementarDAO;
use App\Model\ResidenciaMultiprofissional\CargaHorariaComplementar;
use Illuminate\Support\Facades\DB;

class CargaHoriariaComplementarService
{
    public function salvar($ofertaId, $cargaHorariaComplementarParams, $id = null)
    {
        DB::beginTransaction();
        $cargaHorariaComplementarRetorno = null;
        try {
            $cargaHorariaComplementar = new CargaHorariaComplementar();
            $cargaHorariaComplementar->id = $id;
            $cargaHorariaComplementar->tipoCargaHorariaComplementar = $cargaHorariaComplementarParams['tipoCargaHorariaComplementar'];
            $cargaHorariaComplementar->residente = $cargaHorariaComplementarParams['residenteId'];
            $cargaHorariaComplementar->cargaHoraria = $cargaHorariaComplementarParams['cargaHoraria'];
            $cargaHorariaComplementar->justificativa = $cargaHorariaComplementarParams['justificativa'];
            $cargaHorariaComplementar->tipoCargaHoraria = $cargaHorariaComplementarParams['tipoCargaHoraria'];
            $cargaHorariaComplementar->oferta = $ofertaId;

            $cargaHorariaComplementarDAO = new CargaHorariaComplementarDAO();
            $cargaHorariaComplementarLancada = $cargaHorariaComplementarDAO->get($cargaHorariaComplementar->id);

            if (is_null($cargaHorariaComplementarLancada->id)) {
                $cargaHorariaComplementarRetorno = $cargaHorariaComplementarDAO->insert($cargaHorariaComplementar);
            } else {
                $cargaHorariaComplementarRetorno = $cargaHorariaComplementarDAO->update($cargaHorariaComplementar);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return $cargaHorariaComplementarRetorno;
    }

    public function delete($id)
    {
        $ok = false;
        DB::beginTransaction();
        try {
            $cargaHorariaComplementarDAO = new CargaHorariaComplementarDAO();
            $cargaHorariaComplementar = $cargaHorariaComplementarDAO->get($id);
            if (!isset($cargaHorariaComplementar)) {
                return $ok;
            }

            $ok = $cargaHorariaComplementarDAO->delete($cargaHorariaComplementar);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return $ok;
    }
}