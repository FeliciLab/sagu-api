<?php

namespace App\Http\Controllers\EnsinoPesquisaExtensao;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Services\EnsinoPesquisaExtensao\InscricaoService;
use Exception;

class IncricaoController extends Controller
{
    private $inscricaoService;

    public function __construct(
        InscricaoService $inscricaoService
    ) {
        $this->inscricaoService = $inscricaoService;
    }

    public function index(Request $request, $turmaId)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'cpf' => 'required|cpf',
        ]);

        try {

            if ($validator->fails()) {
                return response()->json(
                    [
                        'sucesso' => false,
                        'mensagem' => $validator->errors()->first()
                    ],
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }

            $inscricao = $this->inscricaoService->subscribeAndEnrollToCourse(
                $data['cpf'],
                $turmaId
            );

            if (!$inscricao) throw new Exception("Não foi possível inscrever a pessoa", 500);
        } catch (Exception $e) {
            return response()->json(
                [
                    'sucesso' => false,
                    'mensagem' => $e->getMessage()
                ],
                $e->getCode() === 500
                    ? Response::HTTP_INTERNAL_SERVER_ERROR
                    : Response::HTTP_BAD_REQUEST
            );
        }

        return response()->json(
            [
                'sucesso' => true,
                'inscricao' => $inscricao
            ],
            Response::HTTP_OK
        );
    }
}
