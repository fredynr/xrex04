<?php

namespace App\Livewire\Drawers;

use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Models\Patient;

class DrawerUpdatePatient extends Component
{
    public $patient;
    public $patientName;
    public $patientMiddlename;
    public $patientSurname;
    public $patientLastname;
    public $patientDirection;
    public $patientEmail;
    public $patientPhone;
    public $patientBirth;

    public function mount($patientId)
    {
        $this->patient = Patient::findOrFail($patientId);

        $this->patientName = $this->patient->name;
        $this->patientMiddlename = $this->patient->middle_name;
        $this->patientSurname = $this->patient->first_surname;
        $this->patientLastname = $this->patient->secund_lastname;
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
            'patientSurname' => 'required|string|max:255',
            'patientDirection' => 'nullable|string|max:255',
            // 'patientEmail' => 'nullable|email|max:255',
            'patientPhone' => 'nullable|string|max:20',
            'patientBirth' => 'nullable|date',
            'patientEmail' => [
                'required',
                'email',
                Rule::unique('patients', 'email')->ignore($this->patient->id),
            ],
        ]);
        $this->patient->update([
            'name' => $validated['patientName'],
            'middle_name' => $this->patientMiddlename,
            'first_surname' => $validated['patientSurname'],
            'secund_lastname' => $this->patientLastname,
            'direction' => $validated['patientDirection'],
            'email' => $validated['patientEmail'],
            'phone' => $validated['patientPhone'],
            'birth' => $validated['patientBirth'],
        ]);
        $this->dispatch('actualizarTablaExams');
        $this->dispatch('close-drawer-update-patient');
        $this->dispatch(
            'notification-classic',
            mensaje: 'Los datos del paciente:<b> '.' '.$this->patientName.' '.'</b>han sido actualizados',
            tipo: 'success'
        );
    }


    public function render()
    {
        return view('livewire.drawers.drawer-update-patient');
    }
}
