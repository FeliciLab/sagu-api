<?php


namespace App\Serializers;


class OfertaModuloTurmasSupervisorSerializer
{
    public function serializarArrayJsonOfertaTurma($dados)
    {
        $dadosSerializados = [];
        foreach($dados as $row) {
            foreach ($row as $key => $value) {
                if (strpos($key, 'turma.') !== false || strpos($key, 'modulo.') !== false) {
                    list($model, $field)  =  explode('.', $key);
                    $dadosSerializados[$model][$field] = $value;
                    continue;
                }

                $dadosSerializados[$key] = $value;
            }
        }

        return $dadosSerializados;
    }
}