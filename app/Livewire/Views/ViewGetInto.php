<?php

namespace App\Livewire\Views;

use Livewire\Component;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Traits\HandlesWlText;
use App\Traits\HandlesWlFiles;
use App\Models\Patient;
use App\Models\Exam;
use App\Models\EpsSender;
use App\Models\DeparturePlace;

class ViewGetInto extends Component
{
    use HandlesWlText;
    use HandlesWlFiles;
    public $eat = 'MODALITY_AET';
    public string $patient_name = '';
    public string $patient_id = '';
    public string $procedure = '';
    public string $scheduled_date = '';
    public string $scheduled_time = '';

    public string $remision = '';
    public $eps_sender_id;
    public $departure_place_id;

    public string $sexo = '';
    public string $type_document = '';
    public string $direction = '';
    public $birth;
    public string $role = '';
    public string $email = '';
    public string $phone = '';
    public $password = '';

    public $search = '';
    public $patients = [];
    public $patientId = null;
    public $patientData = null;

    public $showDrawerUpdatePatient = null;

    #[On('close-drawer-update-patient')]
    public function drawerUpdatePatient()
    {
        $this->showDrawerUpdatePatient = !$this->showDrawerUpdatePatient;
        $this->getDataPatient($this->patientData->id);
    }



    public function mount()
    {
        $this->scheduled_date = Carbon::now()->format('Y-m-d');
        $this->scheduled_time = Carbon::now()->format('H:i');
    }

    // crea nuevo paciente nuevo examen y nuevo worklist
    public function generateWorklist()
    {
        $this->patient_id = $this->search;
        $this->validate([
            'patient_name' => 'required|string',
            'patient_id' => 'required|string',
            'procedure' => 'required|string',
            'scheduled_date' => 'required|date',
            'scheduled_time' => 'required',
        ]);
        try {
            $patient = Patient::create([
                'name' => $this->patient_name,
                'sexo' => $this->sexo,
                'document' => $this->patient_id,
                'type_document' => $this->type_document,
                'direction' => $this->direction,
                'phone' => $this->phone,
                'birth' => $this->birth,
                'email' => $this->email,
                'role' => 'Paciente',
                'password' => Hash::make($this->patient_id),
            ]);
            $exam = Exam::create([
                'remision' => $this->remision,
                'patient_id' => $patient->id,
                'eps_sender_id' => $this->eps_sender_id,
                'user_id' => Auth::id(),
                'departure_place_id' => $this->departure_place_id,
                'exam_state' => 'Solicitado'
            ]);

            $wlText = $this->generateWlText($this->eat, $patient->document, $patient->name, $this->scheduled_date, $this->scheduled_time, $this->procedure);
            $this->generateAndMoveWorklist($patient->document, $wlText);
        } catch (\Exception $e) {
            Log::error("Error al guardar paciente: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            session()->flash('error', 'Ocurrió un error al intentar guardar el registro. Inténtalo de nuevo.');
            return false;
        }
    }

    // crea nuevo worklist y lo asigna a examen existente
    public function generateWorklistOldExam()
    {
        $this->patient_name = $this->patientData->name;
        $this->patient_id = $this->patientData->document;
        $wlText = $this->generateWlText($this->eat, $this->patient_id, $this->patient_name, $this->scheduled_date, $this->scheduled_time, $this->procedure);
        $this->generateAndMoveWorklist($this->patient_id, $wlText);
    }

    // crea nuevo examen y nuevo worklist y lo asigna a paciente existente
    public function generateWlOldPatient()
    {
        try {
            $this->patient_name = $this->patientData->name;
            $this->patient_id = $this->patientData->document;
            $exam = Exam::create([
                'remision' => $this->remision,
                'patient_id' => $this->patientData->id,
                'eps_sender_id' => $this->eps_sender_id,
                'user_id' => Auth::id(),
                'departure_place_id' => $this->departure_place_id,
                'exam_state' => 'Solicitado'
            ]);
            $wlText = $this->generateWlText($this->eat, $this->patient_id, $this->patient_name, $this->scheduled_date, $this->scheduled_time, $this->procedure);
            $this->generateAndMoveWorklist($this->patientData->document, $wlText);
        } catch (\Exception $e) {
            Log::error("Error en generateWlOldPatient: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            session()->flash('error', 'Ocurrió un error al intentar guardar el registro. Inténtalo de nuevo.');
            return false;
        }
    }

    public function updatedSearch()
    {
        $this->patientData = null;
        $this->patientId = null;
        $this->patients = [];
        if (strlen($this->search) >= 3) {
            $this->patients = Patient::where('document', 'like', '%' . $this->search . '%')
                ->limit(10)
                ->get();
        }
    }

    public function selectPatient($id)
    {
        $this->patients = [];
        $this->patientId = $id;
        $this->getDataPatient($id);
    }


    public function getDataPatient($patientId)
    {
        // Lógica para obtener y usar la data del paciente
        $patient = Patient::with('exams')->find($patientId);

        if ($patient) {
            $this->patientData = $patient;
        } else {
            $this->patientData = "No se encontró el paciente con ID: {$patientId}";
        }
    }


    public function render()
    {
        $epsSenders = EpsSender::all();
        $departure_places = DeparturePlace::all();
        return view('livewire.views.view-get-into', compact('epsSenders', 'departure_places'));
    }
}
