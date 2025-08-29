<?php

namespace App\Livewire\Drawers;

use Livewire\Component;
use App\Models\PatientEstudio;

class DrawerInfoReturned extends Component
{
    public $patientEstudio;
    public $estudioName;
    public $estudioId;

    public function mount($estudioId)
    {
        $this->patientEstudio = PatientEstudio::with(['patient', 'exam.departurePlace', 'user', 'specialistUser'])
            ->where('id', $estudioId)
            ->first();
        $this->estudioName = $this->patientEstudio->study_name;
    }

    public function closeDrawer()
    {
        $this->dispatch('close-drawer-info-returned');
    }


    public function render()
    {
        return view('livewire.drawers.drawer-info-returned');
    }
}
