<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class PDFController extends Controller
{
    public function generatePDF()
    {
        $hula = [
            // Aquí debes incluir los datos que deseas mostrar en el PDF.
            'title' => 'Ejemplo de PDF',
            'content' => 'Contenido del PDF',
        ];

        $nama = 'tes';

        $pdf = PDF::loadView('pdf.example', ['hula' => $hula, 'nama' => $nama]);
        return $pdf->download('ejemplo.pdf');
    }
}
