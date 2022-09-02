<?php

namespace App\Model\EnsinoPesquisaExtensao;

class Student
{
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
    private $externalcourseidhs; // nullabe
    private $cityidhs;           // nullabe
    private $institutionidhs;    // nullabe
    private $yearhs;             // nullabe
    private $isinsured;          // not null - default false
    private $passive;            // nullabe
}
