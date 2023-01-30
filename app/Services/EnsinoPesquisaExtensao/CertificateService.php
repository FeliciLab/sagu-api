<?php

namespace App\Services\EnsinoPesquisaExtensao;

use Carbon\Carbon;
use DateTime;
use ZipArchive;

class CertificateService
{
    public function generatePDF($info)
    {
        $zip = new ZipArchive();
        $initial_date = new DateTime($info["curso"]["datainicial"]);
        $final_date = new DateTime($info["curso"]["datafinal"]);

        $period = "{$initial_date->format('d/m/Y')} a {$final_date->format('d/m/Y')}";
        $curriculum_matrix_info = $this->mountCurriculumMatrixInfo($info, $period);
        $charToFilter = array(';', '+', ',', '\\', '/', ' ');

        $course_name = $this->limitString($info["curso"]["curso"], 60);
        $class_name = $this->limitString($info['oferta']['descricao_turma'], 40);

        $course_name_doc = str_replace(
            $charToFilter,
            '_',
            $course_name . '(' . $class_name . ')'
        );

        $zip->open("/tmp/mpdf/{$course_name_doc}.zip", ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $zip->addEmptyDir($course_name_doc);

        foreach ($info["estudantes"] as $student) {
            $mpdf = $this->setMPDFSettings();
            $pdf_info = $this->mountInfoPDF($student, $info, $period);

            $student_cpf = trim($student->cpf);
            $student_name = trim($student->nome);

            $student_name_doc = empty($student_cpf)
                ? str_replace($charToFilter, '_', $student_name)
                : str_replace($charToFilter, '_', $student_name . '(' . $student_cpf . ')');

            $mpdf->SetImportUse();
            $mpdf->SetDocTemplate('assets/docs/certificate/template.pdf');
            $mpdf->WriteHTML($this->PDFInfo($pdf_info));
            $mpdf->AddPage('P');
            $mpdf->WriteHTML($this->renderCurriculumMatrix($curriculum_matrix_info));
            $mpdf->SetHTMLFooter('<p class="footer-text">Matriz Curricular validada pela Secretaria Acadêmica (Secac) da ESP/CE</p>');

            $content = $mpdf->Output('', 'S');

            $zip->addFromString("{$course_name_doc}/{$student_name_doc}.pdf", $content);
        }

        $zip->close();

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename('/tmp/mpdf/' . $course_name_doc . '.zip') . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        readfile('/tmp/mpdf/' . $course_name_doc . '.zip');

        exit;
    }

    private function limitString($string, $length)
    {
        $start = 0;
        $maxLength = $length + strlen('...');

        if (strlen(trim($string)) > $maxLength) {
            return mb_substr(trim($string), $start, $length) . '...';
        }

        return mb_substr(trim($string), $start, $length);
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
            'margin_top' => 10,
            'fontDir' => array_merge($fontDirs, [
                'assets/fonts/archivo'
            ]),
            'fontdata' => $fontData + [
                'archivo' => [
                    'R' => 'Archivo-Regular.ttf'
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
