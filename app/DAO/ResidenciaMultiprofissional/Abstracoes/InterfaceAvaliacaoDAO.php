<?php


namespace App\DAO\ResidenciaMultiprofissional\Abstracoes;


interface InterfaceAvaliacaoDAO
{
    public function atualizar($residenteId, $ofertaId, $avaliacao);
    public function inserir($residenteId, $ofertaId, $avaliacao, $username);
}