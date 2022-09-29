<?php

namespace App\Services\Basic;

use ZipArchive;

class CertificateService
{
    public function generatePDF()
    {
        $course = [
            "name" => "",
            "period" => "",
            "workload" => "",
            "curriculum" => [
                "name" => "",
                [
                    [
                        "module" => "",
                        "didactic_unit_code" => "",
                        "didactic_unit" => ""
                    ]
                ]
            ],
            "students" => [
                [
                    "name" => ""
                ]
            ]
        ];
        $zip = new ZipArchive();

        $zip->open("/tmp/mpdf/{$course["name"]}.zip", ZipArchive::CREATE);

        foreach ($course["students"] as $student) {
            $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];
            $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];

            $mpdf = new \Mpdf\Mpdf([
                'tempDir' => '/tmp/mpdf',
                'mode' => 'utf-8',
                'format' => [210, 297],
                'orientation' => 'L',
                'fontDir' => array_merge($fontDirs, [
                    '/var/www/public/assets/fonts/archivo',
                ]),
                'fontdata' => $fontData + [
                    'roboto' => [
                        'R' => 'Archivo-Regular.ttf'
                    ]
                ]
            ]);

            $mpdf->SetImportUse();
            $mpdf->SetDocTemplate('/var/www/public/assets/docs/certificate-template.pdf', true);
            $mpdf->WriteHTML($this->PDFInfo());

            $content = $mpdf->Output('', 'S');

            $zip->addFromString("{$student["name"]}.pdf", $content);
        }

        $zip->close();

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename('/tmp/mpdf/certificates.zip') . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('/tmp/mpdf/certificates.zip'));
        readfile('/tmp/mpdf/certificates.zip');
        exit;
    }

    private function PDFInfo()
    {
        $info = [
            'student_name' => '',
            'course_name' => '',
            'course_period' => '',
            'course_workload' => '',
            'today_date' => ''
        ];

        return view('certificate.info', $info);
    }
}
