<?php
namespace App\Http\Controllers;

use App\DAO\UserDAO;
use App\Model\Person;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\JWT\JWTWrapper;
use App\Services\AuthService;

class AutenticacaoController extends Controller
{
    public function auth(Request $request, AuthService $authService)
    {
        $usuario = $request->input('usuario');
        $senha = $request->input('senha');
    
        $usuario = $authService->autenticaUsuario($usuario, $senha);
        if (count($usuario) == 0) {

            return \response()->json([
                'login' => 'false',
                'message' => 'Login Inválido',
            ], 401);

        }
        
        return \response()->json([
            'login'         => 'true',
            'access_token'  => $authService->getJwtAuth($usuario)
        ]);
        
    }
}