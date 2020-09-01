<?php

namespace App\DAO;

use App\Model\Turma;
use Illuminate\Support\Facades\DB;

class TurmaDAO
{

    /**
     * @param $id
     * @return Turma
     */
    public function get($id)
    {
        $select = DB::table('med.turma')
            ->where('turmaid', $id);

        $turma = new Turma();

        if (count($select)) {
            $select = $select[0];

            $turma->setId($select->turmaid);
            $turma->setCodigoTurma($select->codigoturma);

            $especialidade = new EspecialidadeDAO();
            $turma->setEspecialidade($especialidade->get($select->enfaseid));

            $categoriaProfissional = new CategoriaProfissionalDAO();
            $turma->setCategoriaProfissional($categoriaProfissional->get($select->nucleoprofissionalid));

            $turma->setDescricao($select->descricao);
            $turma->setDataInicio($select->datainicio);
            $turma->setDataFim($select->datafim);
        }

        return $turma;
    }
}