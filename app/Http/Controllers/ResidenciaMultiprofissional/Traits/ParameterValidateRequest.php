<?php


namespace App\Http\Controllers\ResidenciaMultiprofissional\Traits;

use function response;

trait ParameterValidateRequest
{
    public function invalidPageParameter($page)
    {
        return $page !== null && $this->invalidIntegerParameter($page);
    }

    public function invalidIntegerParameter($num)
    {
        return !ctype_digit($num);
    }

    public function invalidNumberParameter($param)
    {
        if (substr_count($param, '.') > 1) {
            return true;
        }

        return array_first(
            explode('.', $param),
            function ($item) {
                return preg_match_all('/\D/', $item);
            }
        );
    }

    public function responseNumberParameterError($field = 'page')
    {
        return response()->json(
            [
                'error' => true,
                'status' => 400,
                    'message' => "Parâmetro { $field } não é um valor número aceitável."
            ],
            400
        );
    }
}