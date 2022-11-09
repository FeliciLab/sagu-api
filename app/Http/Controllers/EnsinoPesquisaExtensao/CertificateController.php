<?php

namespace App\Http\Controllers\EnsinoPesquisaExtensao;

use App\DAO\EnsinoPesquisaExtensao\CertificadoDAO;
use App\Http\Controllers\Controller;
use App\Services\EnsinoPesquisaExtensao\CertificateService;

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

        return $this->certificate_service->generatePDF($info);
    }

    public function generateCertificateByClass($turmaId)
    {
        $info = $this->generateCertificate($turmaId);

        return $this->certificate_service->generatePDF($info);
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
            'oferta' => $cursoMatrizCurricular['oferta'],
            'estudantes' => $estudantes
        ];
    }
}
