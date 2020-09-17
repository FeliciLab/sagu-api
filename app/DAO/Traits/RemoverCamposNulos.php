<?php


namespace App\DAO\Traits;


use Illuminate\Support\Collection;

trait RemoverCamposNulos
{
    /**
     * @param $lista lista de objetos
     */
    public function removerCamposNulosLista($lista)
    {
        $resultado = [];
        foreach ($lista as $objeto) {
            array_push($resultado, $this->removerCamposNulosToArray($objeto));
        }
        return $resultado;
    }

    public function removerCamposNulosToArray($objeto)
    {
        $resultado = [];
        foreach ($objeto as $key => $value) {
            if (array_key_exists($key, $objeto->getCamposComposicao())) {
                $composicao = $this->removerCamposNulosToArray($value);
                if (is_array($composicao) && count($composicao) > 0) {
                    $resultado[$key] = $this->removerCamposNulosToArray($value);
                }

                continue;
            }
            if (!is_null($value)) {
                $resultado[$key] = $value;
            }
        }

        return $resultado;
    }
}