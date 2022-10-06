<?php

namespace App\Http\Controllers\EnsinoPesquisaExtensao;

use App\Http\Controllers\Controller;
use App\Services\Basic\CertificateService;
use App\DAO\EnsinoPesquisaExtensao\CertificadoDAO;

class CertificateController extends Controller
{
    private $certificate_service;

    function __construct()
    {
        $this->certificate_service = new CertificateService();
    }

    public function generateCertificateByStudent($turmaId, $incricaoid)
    {
        $info = $this->generateCertificate($turmaId, $incricaoid);

        $this->certificate_service->generatePDF($info);
    }

    public function generateCertificateByClass($turmaId)
    {
        $info = $this->generateCertificate($turmaId);

        $this->certificate_service->generatePDF($info);
    }

    private function generateCertificate($turmaId, $incricaoid = null)
    {
        $certificadoDao = new CertificadoDAO();
        $estudantes = $certificadoDao->getInscricoesDaTurma($turmaId, $incricaoid);
        $cursoMatrizCurricular = $certificadoDao->getCursoMatrizCurricular(
            $turmaId
        );

        return [
            'curso' => $cursoMatrizCurricular['curso'],
            'modulos' => $cursoMatrizCurricular['modulos'],
            'estudantes' => $estudantes
        ];
    }
}
