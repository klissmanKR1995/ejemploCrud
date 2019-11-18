<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade as PDF;

use Maatwebsite\Excel\Facade\Excel;

use App\distritos;


class distritopdfController extends Controller
{
    public function exportPdf()
    {
    	$distritos = distritos::get();

    	$pdf =  PDF::loadView('pdf.distritos', compact('distritos'));

    	return $pdf->download('consulta-distritos.pdf');
    }

    public function exportExcel()
    {
    	return Excel::download(new DistritosExport, 'reporteDistritos.xlsx' );
    }
}
