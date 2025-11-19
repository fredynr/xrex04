<?php

namespace App\Livewire\Patient;

use App\Models\Patient;
use Livewire\Component;
use App\Models\PatientEstudio;
use Illuminate\Support\Facades\Auth;


class Dashboard extends Component
{
    public $patient;

    public function mount()
    {
        $this->patient = Auth::guard('patient')->user();
    }

    public function render()
    {
        $estudios = PatientEstudio::where('patient_id', Auth::id())->get();
        return view('livewire.patient.dashboard', [
            'estudios' => $estudios
        ]);
    }
}
