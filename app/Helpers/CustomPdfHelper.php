<?php

namespace App\Helpers;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use TCPDF;

class CustomPdfHelper
{
    
    public static function createPdf($title,$html='',$footer=true,$download=false)
    {
        // dd($title,$html);
        $output_type = $download ? 'D' : 'I'; // D for download, I for inline display

        $pdf = new CustomPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('shisiradhikari.com.np');
        $pdf->SetTitle($title);
        $pdf->setPrintHeader(true);
        $pdf->setPrintFooter($footer);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('FreeSans', '', 12);
        $pdf->AddPage();
        $pdf->writeHTML($html);

        return $pdf->Output($title.'.pdf', $output_type); //show only in browser   
        // return $pdf->Output($title.'.pdf', 'D');  //force download
    }
    
}

class CustomPDF extends TCPDF
{

    public function __construct($orientation = 'P', $unit = 'mm', $format = 'A4', $unicode = true, $encoding = 'UTF-8', $diskcache = false)
    {
        parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache);
    }

    public function Header()
    {
        $watermarkImage = url('images/watermark.webp');
        // $watermarkImage = './images/watermark.webp';

        $this->SetAlpha(0.2);
        $this->Image($watermarkImage, $this->getPageWidth() / 4, $this->getPageHeight() / 4, $this->getPageWidth() / 2, '', '', '', '', false, 300, '', false, false, 0);
        $this->SetAlpha(1);
    }

    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('FreeSans', 'B', 8);
        // Page number
        $html = '
        <table width="100%" style="background-color: antiquewhite; vertical-align:middle;">
            <tr style="vertical-align: middle;font-weight:bold; font-size:16px;">
                <td style="width:30%; color:#00a2ff; text-align:center;">'.$this->getAliasNumPage().' | PAGE </td>
                <td style="width:70%;"> <span style="color: #f74444;"> E. Health Network </span><span style="color: #017dc5">(shisiradhikari.com.np)</span> </td>
            </tr>
        </table>';
        $this->writeHTML($html);
    }

}