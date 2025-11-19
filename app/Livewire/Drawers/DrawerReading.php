<?php

namespace App\Livewire\Drawers;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\PatientEstudio;
use App\Models\Template;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;


class DrawerReading extends Component
{
    public $studyFinder;
    public $reasonForReturn;
    public $estudioId;
    public $templates;
    public $reading;
    public $oldEstudios;
    public bool $openParent = false;
    public $openChildId = null;

    public function mount($estudioId)
    {
        $this->estudioId = $estudioId;
    }

    protected $rules = [
        'reading' => 'required'
    ];
    
    public function closeDrawer()
    {
        $this->dispatch('close-drawer-reading');
        $this->reading = null;
        $this->dispatch('resetRecognition');
    }

    public function toggleParent()
    {
        $this->openParent = !$this->openParent;
    }

    public function toggleChild($templateId)
    {
        if ($this->openChildId === $templateId) {
            $this->openChildId = null;
        } else {
            $this->openChildId = $templateId;
        }
    }

    public function putTemplate($templateContent)
    {
        $clean = str_replace(["\r\n", "\r", "\n"], '', $templateContent);
        $this->reading = str_replace('<br />', "\n", $clean);
        $this->toggleParent();
    }

    protected $formReturnToTech = [
        'reasonForReturn' => 'required'
    ];

    public function returnToTech()
    {
        $study = PatientEstudio::find($this->estudioId);
        if ($study) {
            $date = Carbon::now()->format('Y-m-d H:i:s');
            $study->reason_for_return = $study->reason_for_return . "\n{$date}: {$this->reasonForReturn}";
            $study->study_state = "Devuelto";
            $study->specialist_user_id = Auth::id();
            $study->save();
            $this->closeDrawer();
        }
        $this->skipRender();
    }

    public function updatePatientEstudio()
    {
        $this->validate();
        PatientEstudio::where('id', $this->estudioId)->update([
            'reading' => $this->reading,
            'study_state' => 'Finalizado',
            'specialist_user_id' => Auth::id()
        ]);
        $this->skipRender();
        $this->closeDrawer();
    }

    public function render()
    {
        $this->studyFinder = PatientEstudio::find($this->estudioId);
        $this->templates = Template::where('user_id', Auth::id())->get();
        $this->oldEstudios = PatientEstudio::with('patient')
            ->with('specialistUser')
            ->where('patient_id', $this->studyFinder->patient_id)
            ->get();
        return view('livewire.drawers.drawer-reading');
    }
}
