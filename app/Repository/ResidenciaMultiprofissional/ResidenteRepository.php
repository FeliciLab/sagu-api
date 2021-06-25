<?php


namespace App\Repository\ResidenciaMultiprofissional;


use App\DAO\ResidenciaMultiprofissional\CargaHorariaComplementarDAO;
use App\DAO\ResidenciaMultiprofissional\OfertaModuloFaltaDAO;
use App\DAO\ResidenciaMultiprofissional\OfertaModuloTiposCargaHorariaDAO;

class ResidenteRepository
{
    private $ofertaModuloFaltaDAO;
    private $cargaHorariaComplementarDAO;
    private $ofertaModuloTiposCargaHorariaDAO;

    public function __construct()
    {
        $this->ofertaModuloFaltaDAO = new OfertaModuloFaltaDAO();
        $this->cargaHorariaComplementarDAO = new CargaHorariaComplementarDAO();
        $this->ofertaModuloTiposCargaHorariaDAO = new OfertaModuloTiposCargaHorariaDAO();
    }

    public function getCargaHorariaPendente($residenteId, $ofertaId)
    {
        $cargaHorariaMinimaParaAprovacao = $this->ofertaModuloTiposCargaHorariaDAO->tipoDeCargaHorariaMinimaParaAprovacao($ofertaId);

        $cargaHorariaPendente = [];
        $faltas = $this->ofertaModuloFaltaDAO->getFaltasDoResidenteNaOferta($residenteId, $ofertaId);
        foreach ($faltas as $falta) {
            $cargaHorariaComplementarDoResidentePorTipo = $this->cargaHorariaComplementarDAO->getCargaHorariaComplementarDoResidenteNaOfertaPorTipo($falta->residenteId, $falta->ofertaId, $falta->tipo);
            $cargaHorariaDaOfertaPorTipo = $this->ofertaModuloTiposCargaHorariaDAO->cargaHorariaPorTipo($ofertaId, $falta->tipo);

            $cargaHorariaPresente = ($cargaHorariaDaOfertaPorTipo['cargahoraria'] - ($falta->falta - $cargaHorariaComplementarDoResidentePorTipo));

            $cargaHorariaPendenteA['tipo'] = $falta->tipo;
            $cargaHorariaPendenteA['cargaHorariaPendente'] = ($cargaHorariaMinimaParaAprovacao[$falta->tipo] - $cargaHorariaPresente) <= 0 ? 0 : ($cargaHorariaMinimaParaAprovacao[$falta->tipo] - $cargaHorariaPresente);


            $cargaHorariaPendente[] = $cargaHorariaPendenteA;
        }

        return $cargaHorariaPendente;
    }
}