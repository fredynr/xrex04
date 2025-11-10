<?php

namespace App\Livewire\Drawers;

use Livewire\Component;
use App\Models\PatientEstudio;
use Livewire\Attributes\On;

class DrawerDetailsEstudio extends Component
{
    public PatientEstudio $estudio;

    public function mount( PatientEstudio $estudio )
    {
        $this->estudio = $estudio;
    }

    public function closeDrawerAddendum()
    {
        $this->reset();
        $this->dispatch('close-drawer-details-estudio');
        $this->skipRender();
    }


    public function render()
    {
        return view('livewire.drawers.drawer-details-estudio');
    }
}
