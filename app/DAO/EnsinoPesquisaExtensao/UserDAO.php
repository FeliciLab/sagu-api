<?php

namespace App\DAO\EnsinoPesquisaExtensao;

use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

class UserDAO
{
    public function getUser($login)
    {
        $mioloUser = DB::table('public.miolo_user')
            ->select('iduser', 'login')
            ->where('miolo_user.login', $login)
            ->first();

        return $mioloUser;
    }

    public function addGroupUser($login, $idgroup)
    {
        $unitEspId = 1;

        $user = $this->getUser($login);

        if (!$user) {
            throw new Exception("Login não existente na base de dados");
        }

        $userBelongsToGroup = DB::table('public.miolo_groupuser')
            ->select('*')
            ->where('miolo_groupuser.iduser', $user->iduser)
            ->where('miolo_groupuser.idgroup', $idgroup)
            ->exists();

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
        } catch (Throwable $e) {
            throw $e;
        }

        return $result;
    }
}
