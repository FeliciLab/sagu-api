<?php

namespace App\Model;

use App\Model\BaseModel\BaseModelSagu;
use Faker\Provider\DateTime;

class Turma extends BaseModelSagu
{
    public $id;
    public $codigoTurma;

    /**
     * @var $especialidade Especialidade
     */
    public $especialidade;

    /**
     * @var $categoriaProfissional CategoriaProfissional
     */
    public $categoriaProfissional;

    public $descricao;

    public $dataInicio;

    public $dataFim;

    protected $mapFieldModel = [
        'turmaid' => 'id',
        'codigoturma' => 'codigoTurma',
        'nucleoprofissional' => 'categoriaProfissional',
        'enfase' => 'especialidade'
    ];

    protected $camposComposicao = [
        'categoriaProfissional' => [],
        'especialidade' => []
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
     * @return mixed
     */
    public function getCodigoTurma()
    {
        return $this->codigoTurma;
    }

    /**
     * @param mixed $codigoTurma
     */
    public function setCodigoTurma($codigoTurma)
    {
        $this->codigoTurma = $codigoTurma;
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
        if ($especialidade instanceof Especialidade) {
            $this->especialidade = $especialidade;
        }

        if (is_array($especialidade)) {
            $this->especialidade = new Especialidade($especialidade);
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
        if ($categoriaProfissional instanceof CategoriaProfissional) {
            $this->categoriaProfissional = $categoriaProfissional;
        }

        if (is_array($categoriaProfissional)) {
            $this->categoriaProfissional = new CategoriaProfissional($categoriaProfissional);
        }
    }

    /**
     * @return mixed
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param mixed $descricao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    /**
     * @return mixed
     */
    public function getDataInicio()
    {
        return $this->dataInicio;
    }

    /**
     * @param mixed $dataInicio
     */
    public function setDataInicio($dataInicio)
    {
        $data = new \DateTime($dataInicio);
        $this->dataInicio = $data->format('d/m/Y');
    }

    /**
     * @return mixed
     */
    public function getDataFim()
    {
        return $this->dataFim;
    }

    /**
     * @param mixed $dataFim
     */
    public function setDataFim($dataFim)
    {
        $data = new \DateTime($dataFim);
        $this->dataFim = $data->format('d/m/Y');
    }
}