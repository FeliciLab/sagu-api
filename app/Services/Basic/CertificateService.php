<?php

namespace App\Services\Basic;

use ZipArchive;

class CertificateService
{
    public function generatePDF($info)
    {
        // dump(mb_strtolower($info["curso"]["curso"]));
        // die;
        // $course = [
        //     "name" => "",
        //     "period" => "",
        //     "workload" => "",
        //     "curriculum" => [
        //         "name" => "",
        //         [
        //             [
        //                 "module" => "",
        //                 "didactic_unit_code" => "",
        //                 "didactic_unit" => ""
        //             ]
        //         ]
        //     ],
        //     "students" => [
        //         [
        //             "name" => ""
        //         ]
        //     ]
        // ];
        $zip = new ZipArchive();
        $course_name = str_replace(" ", "_", $info["curso"]["curso"]);

        $zip->open("/tmp/mpdf/test.zip", ZipArchive::CREATE);

        foreach ($info["estudantes"] as $student) {
            // dump(ucwords(strtolower($student->nome)));
            // die;
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
                    '/var/www/public/assets/fonts/open-sans'
                ]),
                'fontdata' => $fontData + [
                    'archivo' => [
                        'R' => 'Archivo-Regular.ttf'
                    ],
                    'open-sans' => [
                        'R' => 'OpenSans-Regular.ttf'
                    ]
                ]
            ]);

            $mpdf->SetImportUse();
            $mpdf->SetDocTemplate('/var/www/public/assets/docs/certificate/template.pdf');
            $mpdf->WriteHTML($this->PDFInfo());
            $mpdf->AddPage('P');
            $mpdf->WriteHTML($this->renderCurriculumMatrix());

            $content = $mpdf->Output('', 'S');
            // $mpdf->Output();

            $student_name = str_replace(" ", "_", $student->nome);
            $zip->addFromString("{$student_name}.pdf", $content);
        }

        $zip->close();

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename('/tmp/mpdf/test.zip') . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('/tmp/mpdf/test.zip'));
        readfile('/tmp/mpdf/test.zip');
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

    private function renderCurriculumMatrix()
    {
        return view('certificate.curriculum-matrix');
    }
}
