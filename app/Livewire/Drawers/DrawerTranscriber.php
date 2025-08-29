<?php

namespace App\Livewire\Drawers;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\PatientEstudio;

class DrawerTranscriber extends Component
{
    public $transcription;
    public PatientEstudio $estudio;

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
    public function render()
    {
        return view('livewire.drawers.drawer-transcriber');
    }
}
