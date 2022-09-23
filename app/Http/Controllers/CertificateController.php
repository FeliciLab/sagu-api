<?php

namespace App\Http\Controllers;

use App\Services\Basic\CertificateService;

class CertificateController extends Controller
{
    public function download()
    {
        $certificate_service = new CertificateService();

        $certificate_service->generatePDF();
    }
}
