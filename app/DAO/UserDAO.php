<?php

namespace App\DAO;

use App\Model\Person;
use App\Model\Preceptor;
use App\Model\ResidenciaMultiprofissional\Supervisor;
use App\Model\Residente;
use App\Model\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UserDAO
{

    /**
     * @param $login
     * @return User
     */
    public function get($login)
    {
        $select = DB::select('SELECT * FROM miolo_user WHERE login = :login LIMIT 1', ['login' => $login]);

        $user = new User();

        if (count($select)) {
            $select = $select[0];

            $user->setIdUser($select->iduser);
            $user->setLogin($select->login);
            $user->setSenha($select->m_password);
        }

        return $user;
    }

    public function buscarUsuarioSupervisor($usuario, $senha)
    {
        $query = new Collection(
            DB::table('public.miolo_user')
            ->select(
                'public.basphysicalperson.personid as person.personid',
                'public.basphysicalperson.name as person.name',
                'res.supervisores.supervisorid as supervisorid'
            )
            ->join('public.basphysicalperson', 'public.miolo_user.login', 'public.basphysicalperson.miolousername')
            ->join('res.supervisores', 'public.basphysicalperson.personid', 'res.supervisores.personid')
            ->where('public.miolo_user.login', $usuario)
            ->where('public.miolo_user.m_password', $senha)
            ->limit(1)
            ->get()
            ->first()
        );

        if ($query->isEmpty()) {
            return false;
        }

        $query = $query->toArray();
        $query['person.perfil'] = Person::PERFIL_RESIDENCIA_MULTIPROFISSIONAL_SUPERVISOR;
        return new Supervisor($query);
    }

    public function verificaSeExisteUsuario(User $user)
    {
        $userMiolo = DB::table('public.miolo_user')
            ->join('public.basphysicalperson', 'public.miolo_user.login', 'public.basphysicalperson.miolousername')
            ->join('med.residente', 'public.basphysicalperson.personid', 'med.residente.personid')
            ->where('public.miolo_user.login', '=', $user->getLogin())
            ->where('public.miolo_user.m_password', '=', $user->getSenha())
            ->limit(1)
            ->get();


        if (count($userMiolo) > 0) {
            $user = $userMiolo[0];

            $person = new Person();
            $person->setId($user->personid);
            $person->setName($user->name);
            $person->setPerfil(Person::PERFIL_RESIDENTE);

            $residente = new Residente();
            $residente->setId($user->residenteid);
            $residente->setPerson($person);

            return $residente;
        }


        $userMiolo = DB::table('public.miolo_user')
            ->join('public.basphysicalperson', 'public.miolo_user.login', 'public.basphysicalperson.miolousername')
            ->join('med.preceptoria', 'public.basphysicalperson.personid', 'med.preceptoria.personid')
            ->where('public.miolo_user.login', '=', $user->getLogin())
            ->where('public.miolo_user.m_password', '=', $user->getSenha())
            ->limit(1)
            ->get();

        if (count($userMiolo) > 0) {
            $user = $userMiolo[0];

            $person = new Person();
            $person->setId($user->personid);
            $person->setName($user->name);
            $person->setPerfil(Person::PERFIL_PRECEPTOR);

            $preceptor = new Preceptor();
            $preceptor->setId($user->preceptorid);
            $preceptor->setPerson($person);

            return $preceptor;
        }


        $userMiolo = $this->buscarUsuarioSupervisor($user->getLogin(), $user->getSenha());
        if ($userMiolo) {
            return $userMiolo;
        }


        return array();
    }

    public function update(User $user)
    {
        DB::update(
            'update miolo_user set m_password = MD5(?), confirm_hash = MD5(?) where login = ?',
            [
                $user->getSenha(),
                $user->getSenha(),
                $user->getLogin()
            ]
        );

        return $user;
    }

}