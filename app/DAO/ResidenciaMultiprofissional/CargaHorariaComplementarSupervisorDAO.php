<?php


namespace App\DAO\ResidenciaMultiprofissional;


use App\DAO\ResidenciaMultiprofissional\Abstracoes\InterfaceAvaliacaoDAO;
use App\Model\ResidenciaMultiprofissional\CargaHorariaComplementar;

class CargaHorariaComplementarSupervisorDAO implements InterfaceAvaliacaoDAO
{
    private $model;

    public function __construct()
    {
        $this->model = new CargaHorariaComplementar();
    }

    public function atualizar($referenciesIds, $avaliacao)
    {
        return \DB::table($this->model->getTable())
            ->where('residenteid', $referenciesIds['residenteId'])
            ->where('ofertadeunidadetematicaid', $referenciesIds['ofertaId'])
            ->update(['cargahoraria' => $avaliacao]);
    }

    public function inserir($referenciesIds, $avaliacao, $username)
    {
        return \DB::table($this->model->getTable())
            ->insert(
                [
                    'username' => $username,
                    'residenteid' => $referenciesIds['residenteId'],
                    'ofertadeunidadetematicaid' => $referenciesIds['ofertaId'],
                    'tipodecargahorariacomplementarid' => $referenciesIds['tipoCargaHorariaId'],
                    'tipocargahoraria' => 'P',
                    'cargahoraria' => $avaliacao,
                ]
            );
    }
}
