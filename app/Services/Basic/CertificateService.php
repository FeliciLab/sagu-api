<?php

namespace App\Services\Basic;

use ZipArchive;

class CertificateService
{
    public function generatePDF()
    {
        $alunos = [
            'aluno1',
            'aluno2'
        ];

        $zip = new ZipArchive();
        
        $zip->open("/tmp/mpdf/certificates.zip", ZipArchive::CREATE);
        
        foreach ($alunos as $aluno) {
            $mpdf = new \Mpdf\Mpdf(['tempDir' => '/tmp/mpdf']);
            $html = "<h1>Hello {$aluno}!</h1>";

            $mpdf->WriteHTML(utf8_encode($html));

            $content = $mpdf->Output('', 'S');

            $zip->addFromString("{$aluno}.pdf", $content);
        }

        $zip->close();

        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: utf-8");
        header("Content-disposition: attachment; filename=\"" . basename('/tmp/mpdf/certificates.zip') . "\"");
        readfile('/tmp/mpdf/certificates.zip');
    }
}
