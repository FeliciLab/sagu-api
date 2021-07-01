<?php

namespace App\Services\ResidenciaMultiprofissional;

use App\DAO\ResidenciaMultiprofissional\OfertaModuloDAO;
use App\DAO\ResidenciaMultiprofissional\OfertaModuloNotaDAO;
use App\Model\ResidenciaMultiprofissional\OfertaModuloNota;
use Illuminate\Support\Facades\DB;

class OfertaModuloNotaService
{
    public function salvarNotas($ofertaId, $notas)
    {
        DB::beginTransaction();
        $notasArray = [];
        try {
            foreach ($notas as $nota) {
                $ofertaModuloDAO = new OfertaModuloDAO();
                $ofertaModulo = $ofertaModuloDAO->get($ofertaId);

                $ofertaModuloNota = new OfertaModuloNota();
                $ofertaModuloNota->ofertaId = $ofertaId;
                $ofertaModuloNota->residenteId = $nota['residenteid'];
                $ofertaModuloNota->semestre = $ofertaModulo->semestre;
                $ofertaModuloNota->notaDeAtividadeDeProduto = $nota['notadeatividadedeproduto'];
                $ofertaModuloNota->notaDeAvaliacaoDeDesempenho = $nota['notadeavaliacaodedesempenho'];

                $ofertaModuloNotaDAO = new OfertaModuloNotaDAO();
                $notaLancada = $ofertaModuloNotaDAO->get($ofertaModuloNota->residenteId, $ofertaModuloNota->ofertaId);
                if (!$notaLancada->id) {
                    $ofertaModuloNotaRetorno = $ofertaModuloNotaDAO->insert($ofertaModuloNota);
                } else {
                    $ofertaModuloNota->id = $notaLancada->id;
                    $ofertaModuloNotaRetorno = $ofertaModuloNotaDAO->update($ofertaModuloNota);
                }

                $notasArray[] = $ofertaModuloNotaRetorno;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return $notasArray;
    }
}