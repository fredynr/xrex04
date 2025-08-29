<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\PatientEstudio;


class PatientEstudioController extends Controller
{
    public function pdfView($estudioId)
    {
        $desdePdf = false;
        $estudio = PatientEstudio::with(['patient', 'specialistUser', 'exam.departurePlace'])
            ->findOrFail($estudioId);
        return view('pdfView', [
            'estudio' => $estudio,
            'desdePdf' => $desdePdf
        ]);
    }

    public function downloadPdf($estudioId)
    {
        $desdePdf = true;
        $logoPath = public_path('images/logoIPS.png');
        $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));

        $estudio = PatientEstudio::with(['patient', 'specialistUser', 'exam.epsSender', 'exam.departurePlace'])
            ->find($estudioId);
        $pdf = Pdf::setOptions([
            'isHtml5ParserEnabled' => true,
        ])
            ->loadView('pdfView', compact('estudio', 'desdePdf', 'logoBase64'))
            ->setPaper('letter', 'portrait');

        return $pdf->stream('studio_' . $estudioId . '.pdf');
    }
}
