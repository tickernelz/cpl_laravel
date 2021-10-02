<?php

namespace App\Models;

use Codedge\Fpdf\Fpdf\Fpdf;

class PDFModel extends Fpdf
{
    function Header()
    {
        $this->Image(asset('media/photos/UPR.jpg'),10, 10, 25, 25);
        $this->SetFont('Times','B',11.5);
        $this->Ln(5);
        $this->MultiCell(290, 4, "KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI ", 0, 'C');
        $this->MultiCell(290, 4, "UNIVERSITAS PALANGKA RAYA", 0, 'C');
        $this->MultiCell(290, 4, "FAKULTAS TEKNIK", 0, 'C');
        $this->Ln(1);
        $this->SetFont('Arial','',8);
        $this->MultiCell(290, 3, "Alamat : Kampus UPR Tunjung Nyaho Jalan Yos Sudarso Kotak Pos 2/PLKUP Palangka Raya 73112 Kalimantan Tengah - INDONESIA", 0, 'C');
        $this->MultiCell(290, 3, "Telepon/Fax: +62 536-3226487 ; laman: www.upr.ac.id E-Mail: fakultas_teknik@eng.upr.ac.id", 0, 'C');
        $this->Line(10, 38, 285, 38);
    }
}
