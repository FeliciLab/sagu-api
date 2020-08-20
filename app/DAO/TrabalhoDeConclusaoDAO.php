<?php

namespace App\DAO;

use App\Model\TrabalhoDeConclusao;
use Illuminate\Support\Facades\DB;

class TrabalhoDeConclusaoDAO
{

    /**
     * @param $id
     * @return TrabalhoDeConclusao
     */
    public function get($id)
    {
        $select = DB::select('SELECT * FROM med.trabalhodeconclusao WHERE trabalhodeconclusaoid = :trabalhodeconclusaoid', ['trabalhodeconclusaoid' => $id]);

        $trabalhoDeConclusao = new TrabalhoDeConclusao();

        if (count($select)) {
            $select = $select[0];

            $trabalhoDeConclusao->setId($select->trabalhodeconclusaoid);
            $trabalhoDeConclusao->setTitulo($select->titulo);
            $trabalhoDeConclusao->setTema($select->tema);

            $modalidadeDao = new TrabalhoDeConclusaoModalidadeDAO();
            $trabalhoDeConclusao->setModalidade($modalidadeDao->get($select->modalidadeid));

            $trabalhoDeConclusao->setNota($select->nota);

            $trabalhoDeConclusao->setApto($trabalhoDeConclusao->getSituacao($select->apto));

            $personDao = new PersonDAO();
            $trabalhoDeConclusao->setOrientador($personDao->get($select->orientadorid));
        }

        return $trabalhoDeConclusao;
    }

    public function getPorResidente($residenteId)
    {
        $select = DB::select('SELECT * FROM med.trabalhodeconclusao WHERE residenteid = :residenteid', ['residenteid' => $residenteId]);

        $trabalhoDeConclusao = new TrabalhoDeConclusao();

        if (count($select)) {
            $select = $select[0];

            $trabalhoDeConclusao = $this->get($select->trabalhodeconclusaoid);
        }

        return $trabalhoDeConclusao;
    }

    public function save(TrabalhoDeConclusao $trabalhoDeConclusao)
    {
        if (!$trabalhoDeConclusao->getId()) {
            return $this->insert($trabalhoDeConclusao);
        } else {
            return $this->update($trabalhoDeConclusao);
        }



        return $trabalhoDeConclusao;
    }

    public function insert(TrabalhoDeConclusao $trabalhoDeConclusao)
    {
        $result = DB::insert('insert into med.trabalhodeconclusao  (residenteid, titulo, tema, modalidadeid) values (?, ?, ?, ?)',
            [
                $trabalhoDeConclusao->getResidente()->getId(),
                $trabalhoDeConclusao->getTitulo(),
                $trabalhoDeConclusao->getTema(),
                $trabalhoDeConclusao->getModalidade()->getId()
            ]);

        if ( $result )  {
            $rowId = DB::connection()->getPdo()->lastInsertId();
            return $this->get($rowId);
        }
    }

    public function update(TrabalhoDeConclusao $trabalhoDeConclusao)
    {
        DB::update('update med.trabalhodeconclusao set residenteid = ?, titulo = ?, tema = ?, modalidadeid = ? where trabalhodeconclusaoid = ?',
            [
                $trabalhoDeConclusao->getResidente()->getId(),
                $trabalhoDeConclusao->getTitulo(),
                $trabalhoDeConclusao->getTema(),
                $trabalhoDeConclusao->getModalidade()->getId(),
                $trabalhoDeConclusao->getId()
            ]);

        return $trabalhoDeConclusao;
    }
}