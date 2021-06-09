<?php

namespace App\DAO\ResidenciaMultiprofissional;

use App\Model\ResidenciaMultiprofissional\AtividadeModulo;
use Illuminate\Support\Facades\DB;

class AtividadeModuloDAO
{
    private $model;
    private $enfaseDAO;
    private $nucleoProfissionalDAO;

    public function __construct()
    {
        $this->model = new AtividadeModulo();
        $this->enfaseDAO = new EnfaseDAO();
        $this->nucleoProfissionalDAO = new NucleoProfissionalDAO();
    }

    public function get($id)
    {
        $select = DB::select('SELECT * FROM ' . $this->model->getTable() . ' WHERE unidadetematicaid = :unidadetematicaid', ['unidadetematicaid' => $id]);
        if (count($select)) {
            $atividadeModulo = new AtividadeModulo();

            $select = $select[0];

            $atividadeModulo->id = $select->unidadetematicaid;
            $atividadeModulo->periodo = $select->periodo;
            $atividadeModulo->descricao = $select->descricao;
            $atividadeModulo->sumula = $select->sumula;
            $atividadeModulo->cargaHoraria = $select->cargahoraria;

            $atividadeModulo->enfases = $this->getEnfasesAtividadeModulo($select->unidadetematicaid);
            $atividadeModulo->nucleosprofissionais = $this->getNucleosProfissionaisAtividadeModulo($select->unidadetematicaid);
        }
        return $atividadeModulo;
    }

    public function getEnfasesAtividadeModulo($id)
    {
        $select = DB::select('SELECT * FROM res.enfasedaunidadetematica WHERE unidadetematicaid = :unidadetematicaid', ['unidadetematicaid' => $id]);
        $enfases = array();

        if (count($select)) {
            foreach ($select as $enfase) {
                $enfases[] = $this->enfaseDAO->get($enfase->enfaseid);
            }
        }

        return $enfases;
    }

    public function getNucleosProfissionaisAtividadeModulo($id)
    {
        $select = DB::select('SELECT * FROM res.nucleodaunidadetematica WHERE unidadetematicaid = :unidadetematicaid', ['unidadetematicaid' => $id]);
        $nucleos = array();

        if (count($select)) {
            foreach ($select as $nucleo) {
                $nucleos[] = $this->nucleoProfissionalDAO->get($nucleo->nucleoprofissionalid);
            }
        }

        return $nucleos;
    }

}