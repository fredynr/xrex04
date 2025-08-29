<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

use App\Models\Patient;

class DrawerUpdatePatient extends Component
{
    /**
     * Create a new component instance.
     */
    public $patient;
    // public $patientName;
    public $patientDirection;
    public $patientEmail;
    public $patientPhone;
    public $patientBirth;

    public function __construct($patientId)
    {
        $this->patient = Patient::findOrFail($patientId);
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.drawer-update-patient');
    }
}
