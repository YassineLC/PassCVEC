<?php

namespace App\Http\Controllers;

use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;

class LabelController extends Controller
{
    public function viewPdf() {
        $data = [
            'etiquettes' => [
                ['name' => 'John Doe', 'address' => '123 Main St', 'city' => 'Anytown'],
                ['name' => 'Jane Smith', 'address' => '456 Elm St', 'city' => 'Othertown']
            ]
        ];

        $pdf = LaravelMpdf::loadView('pdf.etiquettes', $data);

        return $pdf->stream('labels.pdf');
    }
}
