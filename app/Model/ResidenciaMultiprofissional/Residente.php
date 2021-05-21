<?php

namespace App\Model\ResidenciaMultiprofissional;

use App\Model\BaseModel\BaseModelSagu;
use App\Model\ResidenciaMultiprofissional\LegalPerson;
use App\Model\Person;
use App\Model\ResidenciaMultiprofissional\Enfase;
use App\Model\ResidenciaMultiprofissional\NucleoProfissional;

class Residente extends BaseModelSagu
{
    protected $schema = 'res';
    protected $table = 'residente';

    public $id;
    public $inicio;
    public $fimPrevisto;
    public $ofertasDeRodizio;

    /**
     * @var Person
     */
    public $person;

    /**
     * @var Enfase
     */
    public $enfase;

    /**
     * @var NucleoProfissional
     */
    public $nucleoProfissional;

    /**
     * @var Turma
     */
    public $turma;

    /**
     * @var TrabalhoDeConclusao
     */
    public $trabalhoDeConclusao;

    /**
     * @var LegalPerson
     */
    public $instituicaoFormadoraPerson;

    /**
     * @var LegalPerson
     */
    public $instituicaoExecutoraPerson;


    protected $mapFieldModel = [
        'residenteid' => 'id',
        'fimprevisto' => 'fimPrevisto',
    ];

    protected $camposComposicao = [
        'person' => [],
        'turma' => [],
        'enfase' => [],
        'nucleoProfissional' => [],
        'instituicaoFormadoraPerson' => [],
        'instituicaoExecutoraPerson' => []
    ];

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return Person
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * @param Person $person
     */
    public function setPerson($person)
    {
        if (is_array($person)) {
            $this->person = new Person($person);
        }

        if ($person instanceof Person) {
            $this->person = $person;
        }
    }

    /**
     * @return Enfase
     */
    public function getEnfase()
    {
        return $this->enfase;
    }

    /**
     * @param Enfase $enfase
     */
    public function setEnfase($enfase)
    {
        $this->setModeloComposto(Enfase::class, 'enfase', $enfase);
    }

    /**
     * @return NucleoProfissional
     */
    public function getNucleoProfissional()
    {
        return $this->NucleoProfissional;
    }

    /**
     * @param NucleoProfissional $nucleoProfissional
     */
    public function setNucleoProfissional($nucleoProfissional)
    {
        $this->setModeloComposto(NucleoProfissional::class, 'nucleoProfissional', $nucleoProfissional);
    }

    /**
     * @return mixed
     */
    public function getInicio()
    {
        return $this->inicio;
    }

    /**
     * @param mixed $inicio
     */
    public function setInicio($inicio)
    {
        $this->inicio = $inicio;
    }

    /**
     * @return mixed
     */
    public function getFimPrevisto()
    {
        return $this->fimPrevisto;
    }

    /**
     * @param mixed $fimPrevisto
     */
    public function setFimPrevisto($fimPrevisto)
    {
        $this->fimPrevisto = $fimPrevisto;
    }

    /**
     * @return Turma
     */
    public function getTurma()
    {
        return $this->turma;
    }

    /**
     * @param Turma $turma
     */
    public function setTurma($turma)
    {
        $this->setModeloComposto(Turma::class, 'turma', $turma);
    }

    /**
     * @return mixed
     */
    public function getOfertasDeRodizio()
    {
        return $this->ofertasDeRodizio;
    }

    /**
     * @param mixed $ofertasDeRodizio
     */
    public function setOfertasDeRodizio($ofertasDeRodizio)
    {
        $this->ofertasDeRodizio = $ofertasDeRodizio;
    }

    /**
     * @return TrabalhoDeConclusao
     */
    public function getTrabalhoDeConclusao()
    {
        return $this->trabalhoDeConclusao;
    }

    /**
     * @param TrabalhoDeConclusao $trabalhoDeConclusao
     */
    public function setTrabalhoDeConclusao($trabalhoDeConclusao)
    {
        $this->setModeloComposto(TrabalhoDeConclusao::class, 'trabalhoDeConclusao', $trabalhoDeConclusao);
    }

    /**
     * @param LegalPerson $instituicaoFormadoraPerson
     */
    public function setInstituicaoFormadoraPerson($instituicaoFormadoraPerson)
    {
        $this->setModeloComposto(LegalPerson::class, 'instituicaoFormadoraPerson', $instituicaoFormadoraPerson);
    }

    /**
     * @param LegalPerson $instituicaoExecutoraPerson
     */
    public function setInstituicaoExecutoraPerson($instituicaoExecutoraPerson)
    {
        $this->setModeloComposto(LegalPerson::class, 'instituicaoExecutoraPerson', $instituicaoExecutoraPerson);
    }
}