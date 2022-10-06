<?php

namespace App\Services\Basic;

use Carbon\Carbon;
use DateTime;
use ZipArchive;

class CertificateService
{
    public function generatePDF($info)
    {
        $initial_date = new DateTime($info["curso"]["datainicial"]);
        $final_date = new DateTime($info["curso"]["datafinal"]);
        $period = "{$initial_date->format('d/m/Y')} a {$final_date->format('d/m/Y')}";

        $zip = new ZipArchive();
        $course_name_doc = str_replace(" ", "_", $info["curso"]["curso"]);

        $zip->open("/tmp/mpdf/{$course_name_doc}.zip", ZipArchive::CREATE | ZipArchive::OVERWRITE);

        foreach ($info["estudantes"] as $student) {
            $mpdf = $this->setMPDFSettings();
            $pdf_info = $this->mountInfoPDF($student, $info, $period);
            $curriculum_matrix_info = $this->mountCurriculumMatrixInfo($info, $period);
            $student_name_doc = str_replace(" ", "_", $student->nome);

            $mpdf->SetImportUse();
            $mpdf->SetDocTemplate('/var/www/public/assets/docs/certificate/template.pdf');
            $mpdf->WriteHTML($this->PDFInfo($pdf_info));
            $mpdf->AddPage('P');
            $mpdf->WriteHTML($this->renderCurriculumMatrix($curriculum_matrix_info));

            $content = $mpdf->Output('', 'S');

            $zip->addFromString("{$student_name_doc}.pdf", $content);
        }

        $zip->close();

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename('/tmp/mpdf/' . $course_name_doc . '.zip') . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('/tmp/mpdf/' . $course_name_doc . '.zip'));
        readfile('/tmp/mpdf/' . $course_name_doc . '.zip');
        exit;
    }

    private function setMPDFSettings()
    {
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

        return $mpdf;
    }

    private function mountInfoPDF($student, $info, $period)
    {
        $today_date = Carbon::now('America/Fortaleza')->locale('pt-BR')->isoFormat('DD \d\e MMMM \d\e YYYY');

        $pdf_info = [
            'student_name' => ucwords(mb_strtolower($student->nome)),
            'course_name' => ucwords(mb_strtolower($info["curso"]["curso"])),
            'course_period' => $period,
            'course_workload' => $info["curso"]["cargahoraria_curso"],
            'today_date' => $today_date
        ];

        return $pdf_info;
    }

    private function mountCurriculumMatrixInfo($info, $period)
    {
        $curriculum_matrix_info = [
            'course_name' => $info["curso"]["curso"],
            'matrix_name' => $info["curso"]["descricao_matriz"],
            'course_period' => $period,
            'modules' => $info["modulos"],
            'course_workload' => $info["curso"]["cargahoraria_curso"]
        ];

        return $curriculum_matrix_info;
    }

    private function PDFInfo($pdf_info)
    {
        return view('certificate.info', $pdf_info);
    }

    private function renderCurriculumMatrix($curriculum_matrix_info)
    {
        return view('certificate.curriculum-matrix', $curriculum_matrix_info);
    }
}
