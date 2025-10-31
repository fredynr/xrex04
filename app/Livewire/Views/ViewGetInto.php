<?php

namespace App\Livewire\Views;

use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;
use App\Traits\HandlesOrthancStudy;
use App\Traits\HandlesOrthancAuth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
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
    use HandlesOrthancStudy;
    use HandlesOrthancAuth;
    public $eat = 'MODALITY_AET';
    public string $patient_name = '';
    public string $patient_middle_name = '';
    public string $patient_first_surname = '';
    public string $patient_secund_lastname = '';
    public string $patient_id = ''; //ducumento
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
    public string $email = '';
    public string $phone = '';
    public $password = '';

    public $search = '';
    public $patients = [];
    public $patientId = null;
    public $patientData = null;

    public $examId = null;
    public $studiesToView;
    public $studiesPatientBBDD;

    public $showDrawerUpdatePatient = null;
    public $showDrawerStudyTech = false;
    public $showBoxOldExam = false;
    public $showBoxOldPatient = false;

    public function mount()
    {
        $this->scheduled_date = Carbon::now()->format('Ymd');
        $this->scheduled_time = Carbon::now()->format('His');
    }

    public function resetear()
    {
        $this->reset();
    }

    #[On('close-drawer-study-tech')]
    public function openDrawerStudyTech()
    {
        $this->showDrawerStudyTech = !$this->showDrawerStudyTech;
    }

    #[On('close-drawer-update-patient')]
    public function drawerUpdatePatient()
    {
        $this->showDrawerUpdatePatient = !$this->showDrawerUpdatePatient;
        $this->getDataPatient($this->patientData->id);
    }

    // crea nuevo paciente nuevo examen y nuevo worklist
    public function generateWorklist()
    {
        $this->patient_id = $this->search;
        $this->validate([
            'patient_name' => 'required|string',
            'patient_first_surname' => 'required|string',
            'patient_id' => 'required|string',
            'procedure' => 'required|string',
            'scheduled_date' => 'required|date',
            'scheduled_time' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('patients', 'email'),
            ],
        ]);
        try {
            $patient = Patient::create([
                'name' => $this->patient_name,
                'middle_name' => $this->patient_middle_name,
                'first_surname' => $this->patient_first_surname,
                'secund_lastname' => $this->patient_secund_lastname,
                'sexo' => $this->sexo,
                'document' => $this->patient_id,
                'type_document' => $this->type_document,
                'direction' => $this->direction,
                'phone' => $this->phone,
                'birth' => $this->birth,
                'email' => $this->email,
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

            $this->examId = $exam->id;
            $this->patientId = $patient->id;

            $givenName = trim($this->patient_name . '^' . $this->patient_middle_name, '^');
            $familyName = trim($this->patient_first_surname . '^' . $this->patient_secund_lastname, '^');
            $dicomPatientName = $familyName . '^' . $givenName;
            $finalDicomName = preg_replace('/(\^+)/', '^', $dicomPatientName);
            $finalDicomName = trim($finalDicomName, '^');
            $accessionNumber = $patient->document . date('YmdHis');

            $wlText = $this->generateWlText($this->eat, $patient->document, $finalDicomName, $this->scheduled_date, $this->scheduled_time, $this->procedure, $accessionNumber);
            $this->generateAndMoveWorklist($patient->document, $wlText);
        } catch (\Exception $e) {
            Log::error("Error al guardar paciente: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            session()->flash('error', 'Ocurrió un error al intentar guardar el registro. Inténtalo de nuevo.');
            return false;
        }
    }

    // crea nuevo worklist para ser asignado a examen existente, al escoger el estudio en la tabla
    public function generateWorklistOldExam( $examId )
    {
        $this->examId = $examId;
        $accessionNumber = $this->patientData->document . date('YmdHis');
        $this->patient_name = $this->patientData->name;
        $this->patient_id = $this->patientData->document;
        $wlText = $this->generateWlText($this->eat, $this->patient_id, $this->patient_name, $this->scheduled_date, $this->scheduled_time, $this->procedure, $accessionNumber);
        $this->generateAndMoveWorklist($this->patient_id, $wlText);
        $this->showBoxOldExam = true;
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
            $accessionNumber = $this->patientData->document . date('YmdHis');
            $wlText = $this->generateWlText($this->eat, $this->patient_id, $this->patient_name, $this->scheduled_date, $this->scheduled_time, $this->procedure, $accessionNumber);
            $this->generateAndMoveWorklist($this->patientData->document, $wlText);
            $this->examId = $exam->id;
            $this->showBoxOldPatient = true;
            
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

    public function getOrthancStudies(Patient $patient, $examId)
    {
        // dump($this->all());
        // $this->reset();
        $this->examId = $examId;
        $document = strval($patient->document);
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
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->orthancAuthHeader());
        $curlResponse = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new \Exception("Error de conexión con Orthanc: " . curl_error($ch));
        }
        $decoded = json_decode($curlResponse, true);

        Log::info('Respuesta Orthanc:', $decoded);
        $curlResponse = $decoded;
        curl_close($ch);
        // $this->selectedPatientId = $patient->id;
        $curlResponse = is_array($curlResponse) ? $curlResponse : [];

        $countStudiesBBDD = $patient->patientEstudios()->count();
        // si el conteo de los estudios del paciente en la BBDD es igual a 0 entonces es porque es la primera vez que el paciente ingresa
        // el tecnólogo tomó los estudios y se guardan en la variable $curlResponse y son iterados ara mostrarlos en la vista
        if ($countStudiesBBDD === 0) {
            foreach ($curlResponse as $res) {
                $url = "http://localhost:8042/studies/$res";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $this->orthancAuthHeader());
                $response = curl_exec($ch);
                curl_close($ch);
                $data = json_decode($response, true);

                if (isset($data["MainDicomTags"]["StudyDescription"])) {
                    $study = new \stdClass();
                    $study->id = $data["ID"];
                    $study->description = $data["MainDicomTags"]["StudyDescription"];
                    $studiesCollection[] = $study;
                    $this->studiesToView = $studiesCollection;
                } else {
                    $study = new \stdClass();
                    $study->id = $data["ID"];
                    $study->description = "El Nuevo DICOM no tiene nombre de estudio";
                    $studiesCollection[] = $study;
                    $this->studiesToView = $studiesCollection;
                }
            }
        } else {
            // si el conteo de los estudios de la BBDD es mayor a 0 entonces toca comparar los estudios de la BBDD con los de Orthanc
            // para saber cuales son nuevos y mostrarlos en la vista
            // recupera con pluck la columna study_id_orthanc de la tabla patient_estudios
            $this->studiesPatientBBDD = $patient->patientEstudios()->pluck('study_id_orthanc')->toArray();
            //devuelve los que estan en $orthanc y no están en la BBDD
            $studiesRaws = array_filter($curlResponse, function ($study) {
                return !in_array($study, $this->studiesPatientBBDD, true);
            });
            $studiesCollection = [];
            if (!is_array($curlResponse)) {
                throw new \Exception("La respuesta de Orthanc no es un array válido.");
            }
            foreach ($studiesRaws as $studiesRaw) {
                // uso el trait HandleOrthancStudy
                $data = $this->StudyDataFromOrthanc($studiesRaw);
                $studyDescription = "El DICOM no tiene el nombre del estudio";
                if (isset($data["MainDicomTags"]["StudyDescription"])) {
                    $studyDescription = $this->extractStudyName($data);
                    $study = new \stdClass();
                    $study->id = $studiesRaw;
                    $study->description = $studyDescription;
                    $studiesCollection[] = $study;
                } else {
                    dd($data);
                    // $this->studyName = $studyDescription;
                }
            }
            $this->studiesToView = $studiesCollection;
        }
        if (empty($this->studiesToView)) {
            $this->dispatch('toast', type: 'success', message: "No se encontraron estudios, revisa que el número de identificación coincida con.{$patient->document}");
        }
    }

    public function render()
    {
        $epsSenders = EpsSender::all();
        $departure_places = DeparturePlace::all();
        return view('livewire.views.view-get-into', compact('epsSenders', 'departure_places'));
    }
}
