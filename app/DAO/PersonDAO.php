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
            $person->setSexo($select->sex);
            $person->setDataNascimento($select->datebirth);
            $person->setEstadoCivil($select->maritalstatusid);

            $person->setCpf(DocumentoDAO::getContent($select->personid, Person::DOCUMENTO_CPF));
            $person->setRg(DocumentoDAO::getContent($select->personid, Person::DOCUMENTO_IDENTIDADE));
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

        if ($person->getCidade()) {
            $fields .= ', cityid';
            $values .= ',?';
            $data[] = $person->getCidade()->getId();
        }

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
                $fields .= ', miolousername';
                $values .= ',?';
                $data[] = $person->getUserName();
            }

            if ($person->getSexo()) {
                $fields .= ', sex';
                $values .= ',?';
                $data[] = $person->getSexo();
            }
    
            
            if ($person->getDataNascimento()) {
                $fields .= ', datebirth';
                $values .= ',?';
                $data[] = $person->getDataNascimento();
            }

            if ($person->getCelular()) {
                $fields .= ', cellphone';
                $values .= ',?';
                $data[] = $person->getCelular();
            }

            if ($person->getTelefoneResidencial()) {
                $fields .= ', residentialphone';
                $values .= ',?';
                $data[] = $person->getTelefoneResidencial();
            }

            if ($person->getEstadoCivil()) {
                $fields .= ', maritalstatusid';
                $values .= ',?';
                $data[] = $person->getEstadoCivil();
            }
           
            $result = DB::insert("insert into basphysicalperson ($fields) values ($values)", $data);

            $lastPhysicalPersonId = $this->getLastPersonId();

            DocumentoDAO::insertDocumento($lastPhysicalPersonId, Person::DOCUMENTO_IDENTIDADE, $person->getRg());
            DocumentoDAO::insertDocumento($lastPhysicalPersonId, Person::DOCUMENTO_CPF, $person->getCpf());

            return $this->get($lastPhysicalPersonId);
        }
    }

    private function getLastPersonId()
    {
        $select = DB::select('SELECT personid FROM basphysicalperson ORDER BY personid DESC LIMIT 1');
        return $select[0]->personid;
    }
}