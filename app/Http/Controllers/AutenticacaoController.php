<?php
namespace App\Http\Controllers;

use App\DAO\UserDAO;
use App\Model\Person;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\JWT\JWTWrapper;

class AutenticacaoController extends Controller
{
    public function auth(Request $request)
    {
        $usuario = $request->input('usuario');
        $senha = $request->input('senha');

        $user = new User();
        $user->setLogin($usuario);
        $user->setSenha($senha);

        $dao = new UserDAO();
        $usuario = $dao->verificaSeExisteUsuario($user);

        if (count($usuario) > 0) {


            if ($usuario->getPerson()->getPerfil() == Person::PERFIL_RESIDENTE) {
                $userdata = [
                    'residenteid' => $usuario->getId(),
                    'personid'    => $usuario->getPerson()->getId(),
                    'nome'        => $usuario->getPerson()->getName(),
                    'perfil'      => $usuario->getPerson()->getPerfil()
                ];
            } else if ($usuario->getPerson()->getPerfil() == Person::PERFIL_PRECEPTOR) {
                $userdata = [
                    'preceptorid' => $usuario->getId(),
                    'personid'    => $usuario->getPerson()->getId(),
                    'nome'        => $usuario->getPerson()->getName(),
                    'perfil'      => $usuario->getPerson()->getPerfil()
                ];
            }


            $jwt = JWTWrapper::encode([
                'iss' => 'resmedica.api',
                'userdata' => $userdata
            ]);

            return \response()->json([
                'login'         => 'true',
                'access_token'  => $jwt
            ]);
        }


        return \response()->json([
            'login' => 'false',
            'message' => 'Login Inválido',
        ], 401);

    }
}