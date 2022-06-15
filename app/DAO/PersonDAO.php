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

    public function insert(Person $person)
    {
        $fields = 'name, email';
        $values = '?,?';
        $data = [ 
            $person->getName(),
            $person->getEmail()
        ];

        if ($person->getCep()) {
            $fields .= ', zipcode';
            $values .= ',?';
            $data[] = $person->getCep();
        }

        if ($person->getLogradouro()) {
            $fields .= ', location';
            $values .= ',?';
            $data[] = $person->getLogradouro();
        }

        if ($person->getNumero()) {
            $fields .= ', number';
            $values .= ',?';
            $data[] = $person->getNumero();
        }

        if ($person->getComplemento()) {
            $fields .= ', complement';
            $values .= ',?';
            $data[] = $person->getComplemento();
        }

        if ($person->getBairro()) {
            $fields .= ', neighborhood';
            $values .= ',?';
            $data[] = $person->getBairro();
        }

        $result = DB::insert("insert into basperson ($fields) values ($values)", $data);

        if ($result) {
            $lastPersonId = DB::connection()->getPdo()->lastInsertId();

            if ($lastPersonId) {
                $fields .= ', personid';
                $values .= ',?';
                $data[] = $lastPersonId;
            }

            if ($person->getSexo()) {
                $fields .= ', sex';
                $values .= ',?';
                $data[] = $person->getSexo();
            }
    
            
            if ($person->getDatebirth()) {
                $fields .= ', datebirth';
                $values .= ',?';
                $data[] = $person->getDatebirth();
            }
           
            $result = DB::insert("insert into basphysicalperson ($fields) values ($values)", $data);

            $lastPhysicalPersonId = DB::connection()->getPdo()->lastInsertId();
            return $this->get($lastPhysicalPersonId);
        }
    }
}