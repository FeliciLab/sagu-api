<?php


namespace App\DAO\ResidenciaMultiprofissional\Abstracoes;


interface InterfaceAvaliacaoDAO
{
    public function atualizar($referenciesIds, $avaliacao);

    public function inserir($referenciesIds, $avaliacao, $username);
}