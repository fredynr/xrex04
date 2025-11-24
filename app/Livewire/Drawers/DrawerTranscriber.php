<?php

namespace App\Livewire\Drawers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\URL;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\PatientEstudio;

class DrawerTranscriber extends Component
{
    public $transcription;
    public PatientEstudio $estudio;
    public $pdfDataUrl = null;

    protected $rules = [
        'transcription' => 'required'
    ];


    public function closeDrawer()
    {
        $this->dispatch('close-drawer-transcriber');
    }
    public function store()
    {
        $this->validate();
        $transcriptionUpdate =$this->estudio->update([
            'date_transcriber' => now(),
            'reading' => $this->transcription,
            'study_state' => 'Digitado',
            'transcriber_user_id' => Auth::id()
        ]);
        if($transcriptionUpdate){
            $this->dispatch('toast', type: 'success', message: "La transcripcion fue todo un éxito 👍 Gracias!!!");
        }else{
            $this->dispatch('toast', type: 'success', message: "No se pudo guardar la transcripción. intenta de nuevo o cominicate con soporte");
        }
        $this->closeDrawer();
    }

    public function redirectPdf()
    {
        $html = view('pdfPreview', [
            'reading' => $this->transcription,
            'estudio' => $this->estudio
        ])->render();
        $pdf = PDF::loadHtml($html)->setPaper('a4', 'portrait');
        $pdfBinary = $pdf->output();
        $this->pdfDataUrl = 'data:application/pdf;base64,' . base64_encode($pdfBinary);
    }

    public function render()
    {
        return view('livewire.drawers.drawer-transcriber');
    }
}
