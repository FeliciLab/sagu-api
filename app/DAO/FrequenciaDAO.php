<?php

namespace App\DAO;

use App\Model\Encontro;
use App\Model\Frequencia;
use App\Model\Residente;
use Illuminate\Support\Facades\DB;

class FrequenciaDAO
{
    public function frequenciaPorEncontro(Encontro $encontro)
    {
        $select = DB::select('SELECT * FROM med.frequencia WHERE encontroid = :encontroid', ['encontroid' => $encontro->getId()]);

        $frequencias = array();
        foreach ($select as $freq) {

            $residenteDao = new ResidenteDAO();

            $frequencia = new Frequencia();
            $frequencia->setResidente($residenteDao->get($freq->residenteid));
            $frequencia->setJustificativa($freq->justificativa);
            $frequencia->setPresenca($freq->presenca);
            $frequencias[] = $frequencia;
        }

        return $frequencias;
    }

    public function frequenciaPorEncontroEResidente(Encontro $encontro, Residente $residente)
    {
        $select = DB::select('SELECT * FROM med.frequencia WHERE encontroid = :encontroid AND residenteid = :residenteid', ['encontroid' => $encontro->getId(), 'residenteid' => $residente->getId()]);

        if (count($select)) {
            $residenteDao = new ResidenteDAO();
            $frequencia = new Frequencia();
            $frequencia->setResidente($residenteDao->get($select[0]->residenteid));
            $frequencia->setJustificativa($select[0]->justificativa);
            $frequencia->setPresenca($select[0]->presenca);

            return $frequencia;
        }

        return null;
    }

    public function situacoesDeFrequencia()
    {
        return array(

            array(
                'id' => Frequencia::AUSENTE,
                'descricao' => 'Ausente'
            ),
            array(
                'id' => Frequencia::PRESENTE,
                'descricao' => 'Presente'
            ),
            array(
                'id' => Frequencia::JUSTIFICADA,
                'descricao' => 'Justificada')
        );
    }

    public function update(Frequencia $frequencia)
    {
        DB::update('update med.frequencia set presenca = ?, justificativa = ? where encontroid = ? AND residenteid = ?',
            [
                $frequencia->getPresenca(),
                $frequencia->getJustificativa(),
                $frequencia->getEncontro()->getId(),
                $frequencia->getResidente()->getId()
            ]);

        return $frequencia;
    }

    public function insert(Frequencia $frequencia)
    {
        $result = DB::insert('insert into med.frequencia  (encontroid, residenteid, presenca, justificativa) values (?, ?, ?, ?)',
            [
                $frequencia->getEncontro()->getId(),
                $frequencia->getResidente()->getId(),
                $frequencia->getPresenca(),
                $frequencia->getJustificativa()
            ]);

        if ( $result )  {
            return $this->frequenciaPorEncontroEResidente($frequencia->getEncontro(), $frequencia->getResidente());
        }
    }
}