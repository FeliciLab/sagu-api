<?php

namespace App\Services\EnsinoPesquisaExtensao;

use App\DAO\EnsinoPesquisaExtensao\CursoDAO;
use App\DAO\EnsinoPesquisaExtensao\PersonDAO;
use App\DAO\EnsinoPesquisaExtensao\StudentDAO;
use App\DAO\EnsinoPesquisaExtensao\UserDAO;
use App\Model\EnsinoPesquisaExtensao\Student;
use App\Model\EnsinoPesquisaExtensao\Person;
use Exception;
use Illuminate\Support\Facades\DB;

class InscricaoService
{
  /**
   * Inscreve e Matricula um estudante via CPF na turma
   *
   * @param string $cpf
   * @param string $turmaId
   *
   * @throws Exception
   *
   * @return array
   */
  public function subscribeAndEnrollToCourse($cpf, $turmaId)
  {

    DB::beginTransaction();
    try {

      $personDAO = new PersonDAO();

      $personid = $personDAO->getPersonId($cpf);
      if (!$personid) throw new Exception("Não foi possível encontrar a pessoa pelo cpf", 500);

      $person = $personDAO->getPhysicalPerson($personid);
      if (!$person) throw new Exception("Não foi possível encontrar a Pessoa Física", 500);

      $student = new Student();

      foreach ($person as $key => $value) {
        $student->$key = $value;
      }

      // Converte a Pessoa Física em Aluno
      $studentDAO = new StudentDAO();
      $newStudent = $studentDAO->insert($student);
      if (!$newStudent) throw new Exception("Erro ao inscrever User no perfil de Estudante", 500);

      // Adiciona User pelo 'login' ao grupo de Estudantes
      $user = (new UserDAO)->addGroupUser(
        $person->miolousername,
        Person::DEFAULT_GROUP_STUDENT_ID
      );
      if (!$user) throw new Exception("Erro ao inserir User no Grupo de Estudante", 500);

      $inscricao = (new CursoDAO())->inscreveAluno(
        $turmaId,
        $newStudent
      );
      if (!$inscricao) throw new Exception("Erro ao inscrever Estudante", 500);

      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      throw $e;
    }

    return $inscricao;
  }
}
