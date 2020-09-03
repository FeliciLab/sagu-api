<?php


namespace App\Http\Controllers\ResidenciaMultiprofissional\Traits;

use function response;

trait PaginationValidateRequest
{
    public function invalidePageParameter($page)
    {
        return $page !== null && !ctype_digit($page);
    }

    public function responsePaginationError()
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