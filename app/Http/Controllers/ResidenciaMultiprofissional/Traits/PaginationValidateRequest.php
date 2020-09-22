<?php


namespace App\Http\Controllers\ResidenciaMultiprofissional\Traits;

use function response;

trait PaginationValidateRequest
{
    public function invalidNumberParameter($page)
    {
        return $page !== null && !ctype_digit($page);
    }

    public function responseNumberParameterError()
    {
        return response()->json(
            [
                'error' => true,
                'status' => 400,
                'message' => 'Atributo {page} não é um número inteiro'
            ],
            400
        );
    }
}