<?php

namespace App\Model;

use App\Model\BaseModel\BaseModelSagu;
use App\Model\ResidenciaMultiprofissional\LegalPerson;

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
     * @var Especialidade
     */
    public $especialidade;

    /**
     * @var CategoriaProfissional
     */
    public $categoriaProfissional;

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

    protected $mapFieldModel = [
        'residenteid' => 'id',
        'fimprevisto' => 'fimPrevisto',
        'nucleoprofissional' => 'categoriaProfissional',
        'enfase' => 'especialidade'
    ];

    protected $camposComposicao = [
        'person' => [],
        'turma' => [],
        'categoriaProfissional' => [],
        'especialidade' => [],
        'instituicaoFormadoraPerson' => []
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
     * @return Especialidade
     */
    public function getEspecialidade()
    {
        return $this->especialidade;
    }

    /**
     * @param Especialidade $especialidade
     */
    public function setEspecialidade($especialidade)
    {
        if (is_array($especialidade)) {
            $this->especialidade = new Especialidade($especialidade);
        }

        if ($especialidade instanceof Especialidade) {
            $this->especialidade = $especialidade;
        }
    }

    /**
     * @return CategoriaProfissional
     */
    public function getCategoriaProfissional()
    {
        return $this->categoriaProfissional;
    }

    /**
     * @param CategoriaProfissional $categoriaProfissional
     */
    public function setCategoriaProfissional($categoriaProfissional)
    {
        if (is_array($categoriaProfissional)) {
            $this->categoriaProfissional = new CategoriaProfissional($categoriaProfissional);
        }

        if ($categoriaProfissional instanceof CategoriaProfissional)
            $this->categoriaProfissional = $categoriaProfissional;
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
        if ($turma instanceof Turma) {
            $this->turma = $turma;
        }

        if (is_array($turma)) {
            $this->turma = new Turma($turma);
        }
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
        if ($trabalhoDeConclusao instanceof TrabalhoDeConclusao) {
            $this->trabalhoDeConclusao = $trabalhoDeConclusao;
        }

        if (is_array($trabalhoDeConclusao)) {
            $this->trabalhoDeConclusao = new TrabalhoDeConclusao($trabalhoDeConclusao);
        }
    }

    /**
     * @param LegalPerson $instituicaoFormadoraPerson
     */
    public function setInstituicaoFormadoraPerson($instituicaoFormadoraPerson)
    {
        if (is_array($instituicaoFormadoraPerson)) {
            $this->instituicaoFormadoraPerson = new LegalPerson($instituicaoFormadoraPerson);
        }

        if ($instituicaoFormadoraPerson instanceof LegalPerson) {
            $this->instituicaoFormadoraPerson = $instituicaoFormadoraPerson;
        }
    }


}