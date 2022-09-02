<?php

namespace App\DAO\EnsinoPesquisaExtensao;

use App\Model\EnsinoPesquisaExtensao\Student;
use Exception;
use Illuminate\Support\Facades\DB;

class StudentDAO
{

    public function findByPersonId($personid)
    {
        $result = DB::table('public.basphysicalpersonstudent')
            ->select('personid')
            ->where('public.basphysicalpersonstudent.personid', $personid)
            ->first();

        return $result;
    }

    public function insert(Student $student)
    {
        $studentExists = $this->findByPersonId($student->personid);

        if ($studentExists) {
            return $student->personid;
        }

        DB::beginTransaction();
        try {
            $insertStudent = DB::table('public.basphysicalpersonstudent')
                ->insert([
                    'personid' => $student->personid,
                    'name' => $student->name,
                    'email' => $student->email,
                    'password' => $student->password,
                    'cityid' => $student->cityid,
                    'zipcode' => $student->zipcode,
                    'location' => $student->location,
                    'number' => $student->number,
                    'complement' => $student->complement,
                    'neighborhood' => $student->neighborhood,
                    'sex' => $student->sex,
                    'datebirth' => $student->datebirth,
                    'cellphone' => $student->cellphone,
                    'residentialphone' => $student->residentialphone,
                    'maritalstatusid' => $student->maritalstatusid,
                    'miolousername' => $student->miolousername,
                    'namesearch' => $student->namesearch
                ]);
            if (!$insertStudent) throw new Exception("Não foi possível inserir Estudante");

            $result = $student->personid;

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception('Erro: ' . $e->getMessage());
        }

        return $result;
    }
}
