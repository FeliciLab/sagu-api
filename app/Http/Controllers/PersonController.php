<?php
namespace App\Http\Controllers;

use App\DAO\CidadeDAO;
use App\DAO\PersonDAO;
use App\DAO\UserDAO;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Services\Basic\PersonService;
use Illuminate\Support\Facades\Validator;


class PersonController extends Controller
{
    public function lista(Request $request, $pessoaId)
    {
        $personDao = new PersonDAO();
        $pessoa = $personDao->get($pessoaId);
        return \response()->json($pessoa);
    }

    public function salvar(Request $request, $pessoaId = null)
    {
        $senha = $request->input('senha');
        $cidade = $request->input('cidade');
        $bairro = $request->input('bairro');
        $logradouro = $request->input('logradouro');
        $numero = $request->input('numero');
        $complemento = $request->input('complemento');
        $cep = $request->input('cep');
        $foneresidencial = $request->input('foneresidencial');
        $celular = $request->input('celular');
        $email = $request->input('email');

        $personDao = new PersonDAO();
        $pessoa = $personDao->get($pessoaId);

        $cidadeDao = new CidadeDAO();
        $cidade = $cidadeDao->get($cidade);
        $pessoa->setCidade($cidade);

        $pessoa->setSenha(md5($senha));
        $pessoa->setBairro($bairro);
        $pessoa->setLogradouro($logradouro);
        $pessoa->setNumero($numero);
        $pessoa->setComplemento($complemento);
        $pessoa->setCep($cep);
        $pessoa->setTelefoneResidencial($foneresidencial);
        $pessoa->setCelular($celular);
        $pessoa->setEmail($email);
        $pessoa->setId($pessoaId);

        if ($personDao->emailJaExistePraOutraPessoa($pessoa)) {
            $retorno = array(
                'sucesso' => false,
                'mensagem' => 'E-mail já existe cadastrado em nossa base de dados.'
            );

            return \response()->json($retorno);
        }

        $personDao->save($pessoa);

        $userDao = new UserDAO();
        $user = $userDao->get($pessoa->getUserName());
        $user->setSenha($senha, false);
        $user = $userDao->update($user);

        return \response()->json($user);
    }

    public function enviarEmailDeRecuperacaoDeSenha(Request $request)
    {
        $cpf = $request->input('cpf');

        $personDao = new PersonDAO();
        $person = $personDao->retornaPessoaPorCep($cpf);

        if ($person) {

            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->SMTPDebug = 0;                                // Enable verbose debug output
                $mail->SMTPAuth = true;
                $mail->isSMTP();
                $mail->CharSet = 'UTF-8';


                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );

                $mail->Host = env('MAIL_HOST');
                $mail->Username = env('MAIL_USERNAME');
                $mail->Password = env('MAIL_PASSWORD');
                $mail->SMTPSecure = 'tls';
                $mail->Port = env('MAIL_PORT');
                $mail->setFrom(env('MAIL_FROM_ADDRESS'), 'Escola de Saúde Pública do Ceará');
                $mail->addAddress($person->getEmail(), $person->getName());

                //Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'ESP Residência - Recuperação de senha';
                $mail->Body    = '
                                    Acesse o link a seguir para recuperar sua senha <a href="http://academico.esp.ce.gov.br/miolo20/html/index.php?module=admin&action=forgottenPassword">(clique aqui para continuar)</a>.<br>
                                    <p>Para dúvidas e sugestões entre em contato com a Secretaria Escolar da Escola de Saúde Pública do Ceará - ESP/CE.</p>
                                    ';

                $mail->send();

                $retorno = array(
                    'sucesso' => true,
                    'email' => $person->getEmail()
                );
            } catch (Exception $e) {
                $retorno = array(
                    'sucesso' => false,
                    'messagem'=> $mail->ErrorInfo
                );
            }
        } else {
            $retorno = array(
                'sucesso' => false
            );
        }

        return \response()->json($retorno);
    }

    public function save(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'nome' => 'required|min:3',
            'email' => 'required|email:rfc|unique:basphysicalperson',
            'cpf' => 'required|size:14|formato_cpf|cpf|unique:basdocument,content',
            'rg' => 'required|unique:basdocument,content',
            'sexo' => 'alpha|size:1',
            'dataNascimento' => 'date_format:Y-m-d',
            'endereco.cep' => 'size:8'
        ]);

        if ($validator->fails()) {
            return \response()->json([
                'error' => $validator->errors()->all()
            ], \Illuminate\Http\Response::HTTP_BAD_REQUEST);
        }

        $personService = new PersonService();
        $result = $personService->save($data);

        if (!$result) {
            return \response()->json([
                'error' => 'Não foi possível cadastrar a pessoa.'
            ], \Illuminate\Http\Response::HTTP_BAD_REQUEST);
        }

        return \response()->json($result);
        
    }
}