<?php

namespace App\DAO\EnsinoPesquisaExtensao;

use Illuminate\Support\Facades\DB;

class PersonDAO
{

    private function limpaCPF($cpf)
    {
        $regexApenasNum = '/[^0-9]/';
        $valor = preg_replace($regexApenasNum, '', $cpf);

        return $valor;
    }

    /**
     * @param $cpf_aluno
     * @return personid
     */
    public function getPersonId($cpf_aluno)
    {
        $_miolousername = $this->limpaCPF($cpf_aluno);

        $result = DB::table('public.basperson')
            ->distinct()
            ->select('personid')
            ->where('public.basperson.miolousername', $_miolousername)
            ->first();

        return $result->personid;
    }
}
