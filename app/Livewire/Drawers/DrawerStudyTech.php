<?php

namespace App\Livewire\Drawers;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Traits\HandlesOrthancStudy;
use App\Traits\HandlesOrthancAuth;
use App\Models\PatientEstudio;
use App\Models\Exam;
use App\Models\User;

class DrawerStudyTech extends Component
{
    use WithPagination;
    use WithFileUploads;
    use HandlesOrthancStudy;
    use HandlesOrthancAuth;

    public $studyID;
    public $studyName;
    public $orthancID;
    public $examId;
    public $patientId;
    public $techDescription;
    public $priority;
    public $remision;
    public $studiesToView = [];
    public $estudiosBBDD = [];
    public $especialista;

    protected $rules = [
        'examId' => 'required',
        'priority' => 'required'
    ];


    public function mount($studyId, $examId, $patientId)
    {
        $this->orthancID = $studyId;
        $this->examId = $examId;
        $this->patientId = $patientId;

        $data = $this->StudyDataFromOrthanc($studyId);
        $this->studyName = $this->extractStudyName($data);
    }
    public function closeDrawer()
    {
        // lo escucha TablePendingsToDo
        $this->dispatch('close-drawer-study-tech');
    }

    public function store()
    {
        // dd($this->all());
        $this->validate();

        DB::beginTransaction();
        try {
            $newStudy = PatientEstudio::create([
                'tech_description' => $this->techDescription,
                'study_id_orthanc' => $this->orthancID,
                'study_state' => 'Realizado',
                'exam_id' => $this->examId,
                'patient_id' => $this->patientId,
                'user_id' => Auth::id(),
                'specialist_user_id' => $this->especialista,
                'priority' => $this->priority,
                'study_name' => $this->studyName,
                'date_realized' => now(),
            ]);
            if ($this->remision != null) {
                $extensionFile = $this->remision->getClientOriginalExtension();
                $this->studyID = $newStudy->id;
                $nameFinalFile = $this->studyID . '.' . $extensionFile;
                $routeSave = $this->remision->storeAs('remisiones', $nameFinalFile, 'public');
            }

            // hago la consulta a orthanc para ver si tiene estudios
            $document = PatientEstudio::find($newStudy->id)?->patient?->document;
            // $document = strval($newStudy->patient->document);
            $ch = curl_init();
            $array = [
                "Level" => "Study",
                "Query" => [
                    "PatientID" => $document
                ]
            ];
            $array = json_encode($array);
            curl_setopt($ch, CURLOPT_URL, 'http://localhost:8042/tools/find');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $array);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $curlResponse = curl_exec($ch);
            if (curl_errno($ch)) {
                echo curl_error($ch);
            } else {
                $curlResponse = json_decode($curlResponse);
            }
            curl_close($ch);
            $this->estudiosBBDD = $newStudy->patient->patientEstudios()->pluck('study_id_orthanc')->toArray();
            $curlResponse = is_array($curlResponse) ? $curlResponse : [];
            $diffEstudios = array_filter($curlResponse, function ($study) {
                return !in_array($study, $this->estudiosBBDD, true);
            });
            if (empty($diffEstudios)) {
                $exam = Exam::find($this->examId);
                $exam->update(['exam_state' => 'Realizado']);
                $this->dispatch('actualizarTablaExams');
            }

            $this->reset([
                'techDescription',
                'orthancID',
                'examId',
                'patientId',
                'studyName',
                'studiesToView',
                'priority',
                'remision'
            ]);
            DB::commit(); // Confirmar la transacción si todo sale bien
            
            $this->closeDrawer();
            session()->flash('message', 'El estudio fue enviado al especialista. Gracias :)');
        } catch (\Exception $e) {
            DB::rollBack(); // Revertir la transacción en caso de error
            Log::error('Error al crear paciente y examen: ' . $e->getMessage());
            session()->flash('error', 'No se pudo enviar el estudio. Por favor, inténtelo de nuevo o contacte al soporte si el problema persiste.');
        };
    }

    public function render()
    {
        $especialistas = User::where('role', 'Especialista')->get();
        return view('livewire.drawers.drawer-study-tech', [
            'especialistas' => $especialistas
        ]);
    }
}
