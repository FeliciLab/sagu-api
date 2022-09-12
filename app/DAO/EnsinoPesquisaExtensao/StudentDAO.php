<?php

namespace App\DAO\EnsinoPesquisaExtensao;

use App\Model\EnsinoPesquisaExtensao\Student;
use Exception;
use Illuminate\Support\Facades\DB;

class StudentDAO
{
    /**
     * Busca Pessoa Física Estudante
     *
     * @param string $personid
     * @return \stdClass|object|null
     */
    public function findByPersonId($personid)
    {
        $result = DB::table('public.basphysicalpersonstudent')
            ->select('personid')
            ->where('public.basphysicalpersonstudent.personid', $personid)
            ->first();

        return $result;
    }

    /**
     * Adiciona o perfil de Pessoa Física Estudante
     *
     * @param Student $student
     *
     * @throws Exception
     *
     * @return string
     */
    public function insert(Student $student)
    {
        $studentExists = $this->findByPersonId($student->personid);

        if ($studentExists) {
            // A tabela basphysicalpersonstudent não gera um novo id,
            // herda o mesmo personid da tabela basperson
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

            if (!$insertStudent) throw new Exception("Não foi possível inserir Estudante", 500);

            $result = $student->personid;

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw new Exception('Erro: ' . $e->getMessage(), 500);
        }

        return $result;
    }
}
