<?php


namespace App\Http\Controllers\ResidenciaMultiprofissional\Traits;

use function response;

trait ValidarFaltasRequest
{
    public function parametroInvalidoFaltas($page)
    {
        return $page !== null && !ctype_digit($page);
    }

    public function respostaParametroInvalidoFaltas()
    {
        return response()->json(
            [
                'error' => true,
                'status' => 400,
                'message' => 'Atributo {faltas} não é um número inteiro'
            ],
            400
        );
    }
}