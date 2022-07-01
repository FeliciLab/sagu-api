<?php

namespace App\Services\Basic;

use Illuminate\Support\Facades\DB;
use App\DAO\CidadeDAO;
use App\DAO\LocationDAO;
use App\DAO\PersonDAO;
use App\DAO\UserDAO;
use App\Model\Person;
use App\Model\User;
use Exception;

class PersonService
{
    public function save($data)
    {
        DB::beginTransaction();
        try {
            $person = new Person();
            $person->setName($data['nome']);
            $person->setEmail($data['email']);
            $person->setCpf($data['cpf']);
            $person->setUserName(str_replace(['.', '-'], ['', ''], $data['cpf']));
            $person->setRg($data['rg']);

            if (isset($data['sexo'])) {
                $person->setSexo($data['sexo']);
            }

            if (isset($data['dataNascimento'])) {
                $person->setDataNascimento($data['dataNascimento']);
            }
            
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
            $_person = $personDAO->insert($person);   

            $user = new User();
            $user->setName($person->getName());
            $user->setLogin($person->getUserName());
            $user->setSenha($person->getUserName());

            $userDAO = new UserDAO();
            $userDAO->insert($user);

            DB::commit();
            return $_person;

        } catch (Exception $e) {
            DB::rollback();
            return false;
        } 
    }
}