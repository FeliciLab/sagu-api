<?php 

namespace App\Services;

use App\DAO\UserDAO;
use App\Http\JWT\JWTWrapper;
use App\Model\Person;
use App\Model\User;

class AuthService 
{
    public function autenticaUsuario($usuario, $senha)
    {
        $user = new User();
        $user->setLogin($usuario);
        $user->setSenha($senha);

        $dao = new UserDAO();
        $usuario = $dao->verificaSeExisteUsuario($user);

        return $usuario;
    }

    public function getUserData($usuario)
    {
        if ($usuario->getPerson()->getPerfil() == Person::PERFIL_RESIDENTE) {
            return [
                'residenteid' => $usuario->getId(),
                'personid'    => $usuario->getPerson()->getId(),
                'nome'        => $usuario->getPerson()->getName(),
                'perfil'      => $usuario->getPerson()->getPerfil()
            ];
        } 
        
        if ($usuario->getPerson()->getPerfil() == Person::PERFIL_PRECEPTOR) {
            return [
                'preceptorid' => $usuario->getId(),
                'personid'    => $usuario->getPerson()->getId(),
                'nome'        => $usuario->getPerson()->getName(),
                'perfil'      => $usuario->getPerson()->getPerfil()
            ];
        }

        if ($usuario->getPerson()->getPerfil() == Person::PERFIL_RESIDENCIA_MULTIPROFISSIONAL_SUPERVISOR) {
            return [
                'supervisorid' => $usuario->getId(),
                'personid'    => $usuario->getPerson()->getId(),
                'nome'        => $usuario->getPerson()->getName(),
                'perfil'      => $usuario->getPerson()->getPerfil()
            ];
        }
    }

    public function getJwtAuth($usuario)
    {
        return JWTWrapper::encode([
            'iss' => 'resmedica.api',
            'userdata' => $this->getUserData($usuario)
        ]);
    }
}