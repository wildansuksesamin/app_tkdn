<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once APPPATH . '/third_party/tcpdf/tcpdf.php';

class Pdf_without_footer extends TCPDF
{

    function __construct()
    {
        parent::__construct();
    }

    public function Header()
    {
        // get the current page break margin
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        // set background image
        $img_file = K_PATH_IMAGES . 'kop_surat_tanpa_footer.jpg';
        $this->Image($img_file, 0, 0, 210, 300, '', '', '', false, 300, '', false, false, 0);
        // restore auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $this->setPageMark();
    }

    public function setCustomFooterText($customFooterText)
    {
        $this->customFooterText = $customFooterText;
    }

    public function Footer()
    {
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', '', 10);
        // Page number
        $this->Cell(0, 10, $this->customFooterText, 0, false, 'L', 0, '', 0, false, 'T', 'M');
    }
}
