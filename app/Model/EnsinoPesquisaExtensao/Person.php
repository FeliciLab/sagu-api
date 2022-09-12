<?php

namespace App\Model\EnsinoPesquisaExtensao;

class Person
{
    const DEFAULT_GROUP_STUDENT_ID = 4;

    public $personid;
    public $name;
    public $email;
    public $password;
    public $cityid;
    public $zipcode;
    public $location;
    public $number;
    public $complement;
    public $neighborhood;
    public $sex;
    public $datebirth;
    public $cellphone;
    public $residentialphone;
    public $maritalstatusid;
    public $miolousername;
    public $namesearch;

    private $perfil;

    public function getPerfil()
    {
        return $this->perfil;
    }

    public function setPerfil($perfilId)
    {
        $this->perfil = $perfilId;
    }
}
