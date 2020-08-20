<?php

namespace App\DAO;

use App\Model\Penalidade;
use Illuminate\Support\Facades\DB;

class PenalidadeDAO
{

    /**
     * @param $id
     * @return Penalidade
     */
    public function get($id)
    {
        $select = DB::select('SELECT * FROM med.penalidade WHERE penalidadeid = :penalidadeid', ['penalidadeid' => $id]);

        $penalidade = new Penalidade();

        if (count($select)) {
            $select = $select[0];

            $penalidade->setId($select->penalidadeid);

            $tipoDao = new PenalidadeTipoDAO();
            $penalidade->setTipo($tipoDao->get($select->tipodepenalidadeid));

            $data = new \DateTime($select->data);
            $penalidade->setData($data);

            $hora = new \DateTime($select->hora);
            $penalidade->setHora($hora);

            $penalidade->setObservacao($select->observacoes);
        }

        return $penalidade;
    }

    public function getPorResidente($residenteId)
    {
        $select = DB::select('SELECT * FROM med.penalidade WHERE residenteid = :residenteid', ['residenteid' => $residenteId]);

        $penalidades = array();
        foreach ($select as $penalidade) {
            $penalidades[] = $this->get($penalidade->penalidadeid);
        }

        return $penalidades;

    }
}