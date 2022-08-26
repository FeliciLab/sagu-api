<?php

namespace App\Http\Controllers\EnsinoPesquisaExtensao;

use App\DAO\EnsinoPesquisaExtensao\PersonDAO;
use App\DAO\EnsinoPesquisaExtensao\CursoDAO;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IncricaoController extends Controller
{
    public function index(Request $request, $turmaId)
    {

        $data = $request->all();

        $validator = Validator::make($data, [
            'cpf_aluno' => 'required|cpf',
        ]);

        try {

            if ($validator->fails()) {
                return response()->json(
                    [
                        'sucesso' => false,
                        'mensagem' => $validator->errors()->first()
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            $personid = (new PersonDAO())->getPersonId($data['cpf_aluno']);

            $inscricao = (new CursoDAO())->inscreveAluno($turmaId, $personid);

            if (!$inscricao) {
                return response()->json(
                    [
                        'sucesso' => false,
                        'mensagem' => 'Não foi possível inscrever a pessoa.'
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }
        } catch (\Exception $e) {
            return response()->json(
                [
                    'sucesso' => false,
                    'mensagem' => $e->getMessage()
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        return response()->json(
            [
                'sucesso' => true,
                'inscricao_id' => $inscricao['inscricao_id']
            ],
            Response::HTTP_OK
        );
    }
}
