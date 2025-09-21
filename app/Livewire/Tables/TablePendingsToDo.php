<?php

namespace App\Livewire\Tables;

use Livewire\Component;
use App\Traits\HandlesOrthancStudy;
use App\Traits\HandlesOrthancAuth;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use App\Models\Exam;
use App\Models\Patient;
use App\Models\PatientEstudio;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

#[On('actualizarTablaExams')]
class TablePendingsToDo extends Component
{
    use WithPagination;
    use HandlesOrthancStudy;
    use HandlesOrthancAuth;
    public $selectedPatientId;
    public $studiesToView;
    public $studyName;
    public $examId;
    public $patientId;
    public $studiesPatientBBDD;
    public $showDrawerUpdatePatient = false;
    public $selectedStudyId;
    public $showDrawerStudyTech = false;
    public string $search = '';


    public function openDrawerStudyTech($studyId)
    {
        $this->selectedStudyId = $studyId;
        $this->showDrawerStudyTech = true;
    }

    #[On('close-drawer-study-tech')]
    public function closeDrawerStudyTech()
    {
        $this->showDrawerStudyTech = false;
        $this->selectedStudyId = null;
        $this->reset();
        $this->resetPage();
    }

    public function openDrawerUpdatePatient($patientId)
    {
        $this->selectedPatientId = $patientId;
        $this->showDrawerUpdatePatient = true;
    }

    #[On('close-drawer-update-patient')]
    public function closeDrawerUpdatePatient()
    {
        $this->showDrawerUpdatePatient = false;
        $this->selectedPatientId = null;
    }


    protected $listeners = ['searchUpdatedPendings' => 'handleSearch'];
    public function handleSearch($value)
    {
        $this->search = $value;
    }

    public function getOrthancStudies(Patient $patient, $examId)
    {
        // dump($this->all());
        $this->reset();
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

        if (isset($decoded['Error'])) {
            throw new \Exception("Orthanc respondió con error: " . $decoded['Error']);
        }

        $curlResponse = $decoded;

        curl_close($ch);
        $this->selectedPatientId = $patient->id;
        $curlResponse = is_array($curlResponse) ? $curlResponse : [];
        $countStudiesBBDD = $patient->patientEstudios()->count();
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
                    $this->studyName = "El Nuevo DICOM no tiene nombre de estudio";
                }
            }
        } else {
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
                    $study->id = $studiesRaw; // O $data["ID"] si es más preciso
                    $study->description = $studyDescription;
                    $studiesCollection[] = $study;
                } else {
                    dd($data);
                    $this->studyName = $studyDescription;
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
        $exams = Exam::with(['patient', 'departurePlace'])
            ->where('exam_state', 'Solicitado')
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->whereHas('patient', function ($q) {
                        $q->where('name', 'like', "%{$this->search}%")
                            ->orWhere('document', 'like', "%{$this->search}%");
                    });
                });
            })
            ->paginate(10);

        return view('livewire.tables.table-pendings-to-do', [
            'exams' => $exams,
        ]);
    }
}
