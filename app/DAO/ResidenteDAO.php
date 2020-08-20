<?php

namespace App\DAO;

use App\Model\Residente;
use Illuminate\Support\Facades\DB;

class ResidenteDAO
{
    /**
     * @param $id
     * @return Residente
     */
    public function get($id)
    {
        $select = DB::select('SELECT * FROM med.residente WHERE residenteid = :residenteid', ['residenteid' => $id]);

        $residente = new Residente();

        if (count($select)) {
            $select = $select[0];

            $residente->setId($select->residenteid);

            $personDao = new PersonDAO();
            $residente->setPerson($personDao->get($select->personid));

            $especialidadeDao = new EspecialidadeDAO();
            $residente->setEspecialidade($especialidadeDao->get($select->enfaseid));

            $categoriaProfissionalDao = new CategoriaProfissionalDAO();
            $residente->setCategoriaProfissional($categoriaProfissionalDao->get($select->nucleoprofissionalid));

            $residente->setInicio($select->inicio);
            $residente->setFimPrevisto($select->fimprevisto);

            $turmaDao = new TurmaDAO();
            $residente->setTurma($turmaDao->get($select->turmaid));

            $trabalhoDeConclusaoDao = new TrabalhoDeConclusaoDAO();
            $residente->setTrabalhoDeConclusao($trabalhoDeConclusaoDao->getPorResidente($select->residenteid));
        }

        return $residente;
    }

    public function retornaResidenciasDaPessoa($id)
    {
        $select = DB::select('SELECT * FROM med.residente WHERE personid = :personid', ['personid' => $id]);

        $residencias = array();

        foreach ($select as $residencia) {
            $residencias[] = $this->get($residencia->residenteid);
        }

        return $residencias;
    }

    public function retornaOfertasDeRodizioDoResidente($id)
    {
        $residente = $this->get($id);

        $ofertaDoResidenteDao = new OfertaDoResidenteDAO();
        return $ofertaDoResidenteDao->retornaOfertasDeRodizioDoResidente($residente);
    }

    public function retornaUltimasOfertasDeRodizioDoResidente($params)
    {
        $residente = $this->get($params->residenteId);

        $ofertaDoResidenteDao = new OfertaDoResidenteDAO();
        return $ofertaDoResidenteDao->retornaUltimasOfertasDeRodizioDoResidente($residente, $params->dataAtual);
    }

    public function retornaAtualOfertaDeRodizioDoResidente($params)
    {
        $residente = $this->get($params->residenteId);

        $ofertaDoResidenteDao = new OfertaDoResidenteDAO();
        return $ofertaDoResidenteDao->retornaAtualOfertaDeRodizioDoResidente($residente, $params->dataAtual);
    }

    public function retornaUltimaResidenciaDaPessoa($id)
    {
        $select = DB::select('SELECT * FROM med.residente WHERE personid = :personid ORDER BY fimprevisto LIMIT 1', ['personid' => $id]);

        $residencias = array();

        foreach ($select as $residencia) {
            $residencias[] = $this->get($residencia->residenteid);
        }

        return $residencias[0];
    }


}