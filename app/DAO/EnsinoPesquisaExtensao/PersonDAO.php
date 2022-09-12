<?php

namespace App\DAO\EnsinoPesquisaExtensao;

use Illuminate\Support\Facades\DB;
use App\Model\EnsinoPesquisaExtensao\Person;

class PersonDAO
{

    /**
     * Deixa somente números no cpf
     *
     * @param string $cpf
     * @return string
     */
    private function limpaCPF($cpf)
    {
        $regexApenasNum = '/[^0-9]/';
        $valor = preg_replace($regexApenasNum, '', $cpf);

        return $valor;
    }

    /**
     * Busca cadastro da pessoa via cpf
     *
     * @param string $cpf
     * @return string
     */
    public function getPersonId($cpf)
    {
        $_miolousername = $this->limpaCPF($cpf);

        $result = DB::table('public.basperson')
            ->distinct()
            ->select('personid')
            ->where('public.basperson.miolousername', $_miolousername)
            ->value('personid');

        return $result;
    }

    /**
     * Retorna Pessoa Física
     *
     * @param string $personid
     * @return Person
     */
    public function getPhysicalPerson($personid)
    {
        $result = DB::table('public.basphysicalperson')
            ->select('*')
            ->where('public.basphysicalperson.personid', $personid)
            ->first();

        $person = new Person();

        $person->personid = $result->personid;
        $person->name = $result->name;
        $person->email = $result->email;
        $person->password = $result->password;
        $person->cityid = $result->cityid;
        $person->zipcode = $result->zipcode;
        $person->location = $result->location;
        $person->number = $result->number;
        $person->complement = $result->complement;
        $person->neighborhood = $result->neighborhood;
        $person->sex = $result->sex;
        $person->datebirth = $result->datebirth;
        $person->cellphone = $result->cellphone;
        $person->residentialphone = $result->residentialphone;
        $person->maritalstatusid = $result->maritalstatusid;
        $person->miolousername = $result->miolousername;
        $person->namesearch = $result->namesearch;

        return $person;
    }
}
