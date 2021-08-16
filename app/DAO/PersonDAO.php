<?php

namespace App\DAO;

use App\Model\Person;
use Illuminate\Support\Facades\DB;

class PersonDAO
{

    /**
     * @param $id
     * @return Person
     */
    public function get($id)
    {
        $select = DB::select('SELECT * FROM basphysicalperson WHERE personid = :personid LIMIT 1', ['personid' => $id]);

        $person = new Person();

        if (count($select)) {
            $select = $select[0];

            $person->setId($select->personid);
            $person->setName($select->name);
            $person->setUserName($select->miolousername);

            $cidadeDAO = new CidadeDAO();
            $person->setCidade($cidadeDAO->get($select->cityid));

            $person->setBairro($select->neighborhood);
            $person->setLogradouro($select->location);
            $person->setNumero($select->number);
            $person->setComplemento($select->complement);
            $person->setCep($select->zipcode);
            $person->setTelefoneResidencial($select->residentialphone);
            $person->setCelular($select->cellphone);
            $person->setEmail($select->email);
            //$person->setSenha($select->password);
        }

        return $person;
    }

    /**
     * @param Person $person
     * @return Person
     */
    public function save(Person $person)
    {
        if ($person->getId()) {
            return $this->update($person);
        }
    }

    public function update(Person $person)
    {
        DB::update('update basphysicalperson set cityid = ?, neighborhood = ?,  location = ?, number = ?, complement = ?, zipcode = ?, residentialphone = ?, cellphone = ?, email = ? where personid = ?',
            [
                $person->getCidade()->getId(),
                $person->getBairro(),
                $person->getLogradouro(),
                $person->getNumero(),
                $person->getComplemento(),
                $person->getCep(),
                $person->getTelefoneResidencial(),
                $person->getCelular(),
                $person->getEmail(),
                $person->getId()
            ]);


        DB::update('update basperson set cityid = ?, neighborhood = ?,  location = ?, number = ?, complement = ?, zipcode = ?, email = ? where personid = ?',
            [
                $person->getCidade()->getId(),
                $person->getBairro(),
                $person->getLogradouro(),
                $person->getNumero(),
                $person->getComplemento(),
                $person->getCep(),
                $person->getEmail(),
                $person->getId()
            ]);

        return $person;
    }

    public function emailJaExistePraOutraPessoa(Person $person)
    {
        $select = DB::select('SELECT * FROM basphysicalperson WHERE email = :email AND personid <> :personid LIMIT 1', ['email' => $person->getEmail(), 'personid' => $person->getId()]);

        if (count($select)) {
            return true;
        }

        return false;
    }

    public function retornaPessoaPorCep($cpf)
    {
        $select = DB::select('SELECT * FROM basphysicalperson WHERE miolousername = :miolousername LIMIT 1', ['miolousername' => $cpf]);

        if (count($select)) {
            return $this->get($select[0]->personid);
        }

        return false;
    }


    public function retornaPessoas()
    {
        return DB::select('
            SELECT DISTINCT BP.personid, BP.name, BC.ibgeid, BC.name as cidade, BS.name as estado,
                            BP.zipcode as cep, BP.location as logradouro, BP.number, BP.complement, BP.neighborhood as bairro,
                            BP.email
                FROM basphysicalperson BP INNER JOIN 
                    bascity BC ON BP.cityid = BC.cityid INNER JOIN 
                    basstate BS ON BC.stateid = BS.stateid
                    ');
    }
}