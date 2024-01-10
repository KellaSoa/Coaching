<?php

include __DIR__.'/tcpdf/tcpdf.php';

class Pdf extends TCPDF
{
    protected static ?Pdf $instance = null;

    public function __construct()
    {
        parent::__construct(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        self::$instance = &$this;
        add_action('wp_ajax_nopriv_generate_pdf', [$this, 'generatePdf']);
        add_action('wp_ajax_generate_pdf', [$this, 'generatePdf']);
    }

    public static function Instance(): Pdf
    {
        return self::$instance ?? self::$instance = new Pdf();
    }

    public function createPDF($typeCourse= '',string $course='', string $content='default content')
    {
        $this->SetAutoPageBreak('auto', 30);
        $this->AddPage();
        $this->SetTextColor(40, 40, 40);

        $this->SetY(30);
        $this->SetFont('freesans', 'B', 12);
        $this->Cell(0, 7, "Pastorale con le Famiglie", 0, 1, 'C', 0, '', 0, false, 'T', 'M');

        $this->SetFont('freesans', 'B', 20);
        $this->Ln(10);

        $this->writeHTML($course, true, false, true, false, 'C');
        $this->SetFont('freesans', 'B', 18);
        $this->Cell(0, 7, "Informativa del corso", 0, 1, 'C', 0, '', 0, false, 'T', 'M');

        $this->SetFont('freesans', '', 14);
        $this->Ln(10);
        $this->writeHTML($content, true, false, true, false, '');
        // Output the PDF
        $course = str_replace(" ", "", $course);
        $temp_dir = sys_get_temp_dir();

        $pdfFilePathName = 'Informativa-'.$course.'.pdf';
        //$pdfFilePath = $temp_dir .$pdfFilePathName;

        /*header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $pdfFilePathName . '"');*/
        $this->Output($pdfFilePathName, 'I');
    }

    public function generatePdf($typeCourse,$course,$htmlContent)
    {
        Pdf::Instance()->createPDF($typeCourse,$course,$htmlContent);
    }

    public function Header()
    {
        if ( $this->PageNo() == 1 ) {
            // Set font
            $this->SetTextColor(40, 40, 40);
            $image_file = get_theme_file_uri('/images/logo.png');
            $this->Image($image_file, '', 0, 40, null, 'PNG');
        }
    }

    // Page footer
    public function Footer()
    {
        // Set font
        $this->SetFont('freesans', 'I', 8);

        // Footer content
        $footer = 'info@pastoraleconlefamiglie.org<br>Piazza Porziuncola, 1 I - 06081 – Santa Maria degli Angeli (PG)<br><br>Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages();

        // Output footer content
        $this->SetY(-20);
        $this->writeHTML($footer, true, false, true, false, 'C');
    }
}
Pdf::Instance();
