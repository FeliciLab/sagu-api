<?php

namespace App\Services\Basic;

use App\DAO\PersonDAO;
use App\Model\Person;

class PersonService
{
    public function save($data)
    {
        if (is_array($data)) {
            foreach ($data['persons'] as $_person) {

                $person = new Person();
                $person->setName($_person['nome']);
                $person->setEmail($_person['email']);
                $person->setSexo($_person['sexo']);
                $person->setDatebirth($_person['DataNascimento']);
                $person->setCpf($_person['cpf']);
                $person->setRg($_person['rg']);

            

                if ($_person['endereco']) {
                    if ($_person['endereco']['cep']) {
                        $person->setCep($_person['endereco']['cep']);
                    } 
                    
                    if ($_person['endereco']['logradouro']) {
                        $person->setLogradouro($_person['endereco']['logradouro']);
                    } 

                    if ($_person['endereco']['numero']) {
                        $person->setNumero($_person['endereco']['numero']);
                    } 

                    if ($_person['endereco']['complemento']) {
                        $person->setComplemento($_person['endereco']['complemento']);
                    } 

                    if ($_person['endereco']['bairro']) {
                        $person->setBairro($_person['endereco']['bairro']);
                    } 
                }

                $personDAO = new PersonDAO();
                $personDAO->insert($person);
            }
        }
    }
}