<?php

namespace App\DAO;

use App\Model\Autoavaliacao;
use Illuminate\Support\Facades\DB;

class AutoavaliacaoDAO
{

    public function get($id)
    {
        $select = DB::select('
            SELECT * FROM 
            med.ofertadeunidadetematicaautoavaliacao 
            WHERE avaliacaoid = :avaliacaoid', ['avaliacaoid' => $id]);
        $autoAvaliacao = new Autoavaliacao();

        if (count($select)) {
            $select = $select[0];

            $autoAvaliacao->setId($select->avaliacaoid);
            $autoAvaliacao->setNota($select->nota);
            $autoAvaliacao->setAvaliacao($select->avaliacao);
        }

        return $autoAvaliacao;
    }

    /**
     * @param $residenteId
     * @param $ofertaDeRodizioId
     * @return Autoavaliacao
     */
    public function getAutoavaliacao($residenteId, $ofertaDeRodizioId)
    {
        $select = DB::select('
            SELECT avaliacaoid FROM 
            med.ofertadeunidadetematicaautoavaliacao 
            WHERE ofertadeunidadetematicaid = :ofertadeunidadetematicaid 
                AND residenteid = :residenteid', ['ofertadeunidadetematicaid' => $ofertaDeRodizioId, 'residenteid' => $residenteId]);
        $autoAvaliacao = new Autoavaliacao();

        if (count($select)) {
            $select = $select[0];

            $autoAvaliacao = $this->get($select->avaliacaoid);
        }

        return $autoAvaliacao;
    }

    public function save(Autoavaliacao $autoavaliacao)
    {
        if (!$autoavaliacao->getId()) {
            return $this->insert($autoavaliacao);
        } else {
            return $this->update($autoavaliacao);
        }


        
        return $autoavaliacao;
    }

    public function insert(Autoavaliacao $autoavaliacao)
    {
        $result = DB::insert('insert into med.ofertadeunidadetematicaautoavaliacao  (residenteid, ofertadeunidadetematicaid, nota, avaliacao) values (?, ?, ?, ?)',
            [
                $autoavaliacao->getResidente()->getId(),
                $autoavaliacao->getOfertaDeRodizio()->getId(),
                $autoavaliacao->getNota(),
                $autoavaliacao->getAvaliacao()
            ]);

        if ( $result )  {
            $rowId = DB::connection()->getPdo()->lastInsertId();
            return $this->get($rowId);
        }
    }

    public function update(Autoavaliacao $autoavaliacao)
    {
        DB::update('update med.ofertadeunidadetematicaautoavaliacao  set nota = ?, avaliacao = ? where avaliacaoid = ?',
        [
            $autoavaliacao->getNota(),
            $autoavaliacao->getAvaliacao(),
            $autoavaliacao->getId()
        ]);

        return $this->get($autoavaliacao->getId());
    }
}