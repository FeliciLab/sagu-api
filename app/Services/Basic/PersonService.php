<?php

namespace App\Services\Basic;

use App\DAO\CidadeDAO;
use App\DAO\LocationDAO;
use App\DAO\PersonDAO;
use App\Model\Cidade;
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
            
            if (isset($data['celular'])) {
                $person->setCelular($data['celular']);
            }             

            if (isset($data['telefoneResidencial'])) {
                $person->setTelefoneResidencial($data['telefoneResidencial']);
            } 

            if (isset($data['estadoCivil'])) {
                $person->setEstadoCivil($data['estadoCivil']);
            } 

            if (isset($data['endereco'])) {
                if (isset($data['endereco']['cep'])) {
                    $person->setCep($data['endereco']['cep']);

                    $cidadeId = LocationDAO::getCidadeIdPorCep($data['endereco']['cep']);

                    if ($cidadeId) {
                        $cidadeDAO = new CidadeDAO();
                        $cidade = $cidadeDAO->get($cidadeId);

                        $person->setCidade($cidade);
                    }
                } 
                
                if (isset($data['endereco']['logradouro'])) {
                    $person->setLogradouro($data['endereco']['logradouro']);
                } 

                if (isset($data['endereco']['numero'])) {
                    $person->setNumero($data['endereco']['numero']);
                } 

                if (isset($data['endereco']['complemento'])) {
                    $person->setComplemento($data['endereco']['complemento']);
                } 

                if (isset($data['endereco']['bairro'])) {
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