<?php

namespace App\DAO\EnsinoPesquisaExtensao;

use Exception;
use Illuminate\Support\Facades\DB;

class UserDAO
{
    /**
     * Encontra o User (Login)
     *
     * @param string $login é o cpf nas regras atuais
     * @return object
     */
    public function getUser($login)
    {
        $mioloUser = DB::table('public.miolo_user')
            ->select('iduser', 'login')
            ->where('miolo_user.login', $login)
            ->first();

        return $mioloUser;
    }

    /**
     * Adiciona User ao Grupo solicitado
     *
     * @param string $login
     * @param string $idgroup
     * @return boolean
     */
    public function addGroupUser($login, $idgroup)
    {
        $unitEspId = 1;

        $user = $this->getUser($login);

        if (!$user) {
            throw new Exception("Login não existente na base de dados", 500);
        }

        $userBelongsToGroup = DB::table('public.miolo_groupuser')
            ->select('*')
            ->where('miolo_groupuser.iduser', $user->iduser)
            ->where('miolo_groupuser.idgroup', $idgroup)
            ->exists();

        // Se já pertencer ao grupo, retorna true, evitando novo insert
        if ($userBelongsToGroup) {
            return $userBelongsToGroup;
        }

        try {
            $result = DB::table('public.miolo_groupuser')
                ->insert([
                    'iduser' => $user->iduser,
                    'idgroup' => $idgroup,
                    'unitid' => $unitEspId
                ]);
        } catch (Exception $e) {
            throw $e;
        }

        return $result;
    }
}
