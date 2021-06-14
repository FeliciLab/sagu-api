<?php

namespace App\Services\ResidenciaMultiprofissional;

use App\DAO\ResidenciaMultiprofissional\OfertaModuloFaltaDAO;
use App\Model\ResidenciaMultiprofissional\OfertaModuloFalta;

class OfertaModuloFaltaService
{
    public function salvarFaltas($oferta, $faltas)
    {
        $faltasArray = [];
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

        return $faltasArray;
    }
}