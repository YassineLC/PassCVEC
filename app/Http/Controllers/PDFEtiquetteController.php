<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class PDFEtiquetteController extends Controller
{
    public function generatePDF() {
        $data = ['title' => 'Hello World'];
        $pdf = PDF::loadView('pdf.etiquette', $data);
        return $pdf->download('etiquette.pdf');
    }
}
