<?php

namespace App\Livewire\Drawers;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Patient;

class DrawerUpdatePatient extends Component
{
    public $patient;
    public $patientName;
    public $patientDirection;
    public $patientEmail;
    public $patientPhone;
    public $patientBirth;

    public function mount($patientId)
    {
        $this->patient = Patient::findOrFail($patientId);
        $this->patientName = $this->patient->name;
        $this->patientDirection = $this->patient->direction;
        $this->patientEmail = $this->patient->email;
        $this->patientPhone = $this->patient->phone;
        $this->patientBirth = $this->patient->birth;
    }

    public function closeDrawer()
    {
        $this->dispatch('close-drawer-update-patient');
    }

    public function updatePatient()
    {
        $validated = $this->validate([
            'patientName' => 'required|string|max:255',
            'patientDirection' => 'nullable|string|max:255',
            'patientEmail' => 'nullable|email|max:255',
            'patientPhone' => 'nullable|string|max:20',
            'patientBirth' => 'nullable|date',
        ]);
        $this->patient->update([
            'name' => $validated['patientName'],
            'direction' => $validated['patientDirection'],
            'email' => $validated['patientEmail'],
            'phone' => $validated['patientPhone'],
            'birth' => $validated['patientBirth'],
        ]);
        $this->dispatch('actualizarTablaExams');
        $this->dispatch('close-drawer-update-patient');
    }


    public function render()
    {
        return view('livewire.drawers.drawer-update-patient');
    }
}
