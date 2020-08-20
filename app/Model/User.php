<?php

namespace App\Model;

class User
{
    private $idUser;
    private $login;
    private $senha;

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param mixed $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * @param mixed $senha
     */
    public function setSenha($senha, $preparaMd5 = true)
    {
        if ($preparaMd5) {
            $this->senha = $this->prepareUserPassword($senha);
        } else {
            $this->senha = $senha;
        }

    }


    private function prepareUserPassword($senha)
    {
        return md5($senha);
    }
}