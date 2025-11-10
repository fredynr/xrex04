<?php

namespace App\Livewire\Drawers;

use Livewire\Component;
use App\Models\PatientEstudio;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DrawerAddendum extends Component
{
    public $addendum;
    public PatientEstudio $estudio;

    public function mount(PatientEstudio $estudio)
    {
        $this->estudio = $estudio;
    }

    public function closeDrawerAddendum()
    {
        $this->reset();
        $this->dispatch('close-drawer-addendum');
        $this->skipRender();
    }

    public function insertAddendum()
    {
        $currentReading = $this->estudio->reading ?? '';
        $separator = "\n\n--- ADENDA [" . Carbon::now()->format('Y-m-d H:i') . "] - Por Doctor: " . Auth::user()->name . " ---\n";
        $newReading = $currentReading . $separator . $this->addendum;
        $this->estudio->update([
            'reading' => $newReading,
        ]);
        $this->closeDrawerAddendum();
    }

    public function render()
    {
        return view('livewire.drawers.drawer-addendum');
    }
}
