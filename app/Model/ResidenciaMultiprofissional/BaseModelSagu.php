<?php


namespace App\Model\ResidenciaMultiprofissional;


abstract class BaseModelSagu
{
    /**
     * Mapeamento de valores do banco para variáveis internas oa modelo.
     * Criado para dar melhor legibilidade ao código.
     * @var array [ 'coluna do banco' => 'variável do modelo' ]
     */
    protected $mapFieldModel = [];

    /**
     * BaseModelSagu constructor.
     */
    public function __construct($dados = null)
    {
        if (!$dados) {
            return $this;
        }

        $this->popularModelo($dados);
    }

    /**
     * @param $dbColumn string
     * @return string
     */
    public function getFieldModel($dbColumn)
    {
        if (isset($this->mapFieldModel[$dbColumn])) {
            return $this->mapFieldModel[$dbColumn];
        }

        return $dbColumn;
    }

    function popularModelo($dados)
    {
        foreach ($dados as $key => $value) {
            $localVariable = $this->getFieldModel($key);
            $this->$localVariable = $value;
        }

        return $this;
    }
}