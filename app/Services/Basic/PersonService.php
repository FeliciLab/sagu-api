<?php

namespace App\Services\Basic;

use App\DAO\PersonDAO;
use App\Model\Person;
use Exception;

class PersonService
{
    public function save($data)
    {
        try {
            $person = new Person();
            $person->setName($data['nome']);
            $person->setEmail($data['email']);
            $person->setSexo($data['sexo']);
            $person->setDataNascimento($data['dataNascimento']);
            $person->setCpf($data['cpf']);
            $person->setUserName(str_replace(['.', '-'], ['', ''], $data['cpf']));
            $person->setRg($data['rg']);
            $person->setCelular($data['celular']);
            $person->setTelefoneResidencial($data['telefoneResidencial']);

            if ($data['endereco']) {
                if ($data['endereco']['cep']) {
                    $person->setCep($data['endereco']['cep']);
                } 
                
                if ($data['endereco']['logradouro']) {
                    $person->setLogradouro($data['endereco']['logradouro']);
                } 

                if ($data['endereco']['numero']) {
                    $person->setNumero($data['endereco']['numero']);
                } 

                if ($data['endereco']['complemento']) {
                    $person->setComplemento($data['endereco']['complemento']);
                } 

                if ($data['endereco']['bairro']) {
                    $person->setBairro($data['endereco']['bairro']);
                } 
            }

            $personDAO = new PersonDAO();
            return $personDAO->insert($person);   
        } catch (Exception $e) {
            return [
                'error' => [
                    'message' => $e->getMessage()
                ]
            ];
        } 
    }
}