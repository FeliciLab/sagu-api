<?php


namespace App\Model\ResidenciaMultiprofissional;


abstract class BaseModelResidenciaMultiprofissional
{
    /**
     * BaseModelResidenciaMultiprofissional constructor.
     */
    public function __construct($dados = null)
    {
        if (!$dados) {
            return $this;
        }

        $this->popularModelo($dados);
    }

    function popularModelo($dados)
    {
        foreach ($dados as $key => $value) {
            $this->$key = $value;
        }

        return $this;
    }
}