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
// use App\Traits\HandlesWlText;
use App\Traits\HandlesWlFiles;
use App\Models\Patient;
use App\Models\Exam;
use App\Models\PatientEstudio;
use App\Models\EpsSender;
use App\Models\ListEstudio;
use App\Models\DeparturePlace;

class DummyPatientData {
    public $document = '12345';
    public $name = 'PRUEBA EXITOSA';
    public $id = 999; 
}

class ViewGetInto extends Component
{
    // use HandlesWlText;
    use HandlesWlFiles;
    use HandlesOrthancStudy;
    use HandlesOrthancAuth;

    public function getAccessionNumberProperty()
    {
        return date('YmdHis') . rand(100, 999);
    }

    // si el accessionNumber se va proporcionar por el formulario se debe eliminar la funcion getAccessionNumberProperty() y quitar la referencia en el mount()
    public $accessionNumber;
    public $eat = 'MODALITY_AET';
    public string $patient_name = '';
    public string $patient_middle_name = '';
    public string $patient_first_surname = '';
    public string $patient_secund_lastname = '';
    public string $patient_id = ''; //ducumento
    public string $procedure = '';
    public ListEstudio $estudioList;
    public string $scheduled_date = '';
    public string $scheduled_time = '';

    public string $remision = '';
    public $eps_sender_id = '';
    public $departure_place_id = '';

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
        $this->eat = config('worklist.eat');
        $this->scheduled_date = Carbon::now()->format('Ymd');
        $this->scheduled_time = Carbon::now()->format('His');
        $this->accessionNumber = $this->getAccessionNumberProperty();
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
    // public function generateWorklist()
    // {
    //     $this->patient_id = $this->search;
    //     $this->validate([
    //         'patient_name' => 'required|string',
    //         'patient_first_surname' => 'required|string',
    //         'patient_id' => 'required|string',
    //         'procedure' => 'required',
    //         'scheduled_date' => 'required|date',
    //         'scheduled_time' => 'required',
    //         'email' => [
    //             'required',
    //             'email',
    //             Rule::unique('patients', 'email'),
    //         ],
    //     ]);
    //     try {
    //         $this->estudioList = ListEstudio::find($this->procedure);
    //         $patient = Patient::create([
    //             'name' => $this->patient_name,
    //             'middle_name' => $this->patient_middle_name,
    //             'first_surname' => $this->patient_first_surname,
    //             'secund_lastname' => $this->patient_secund_lastname,
    //             'sexo' => $this->sexo,
    //             'document' => $this->patient_id,
    //             'type_document' => $this->type_document,
    //             'direction' => $this->direction,
    //             'phone' => $this->phone,
    //             'birth' => $this->birth,
    //             'email' => $this->email,
    //             'password' => Hash::make($this->patient_id),
    //         ]);
    //         $exam = Exam::create([
    //             'remision' => $this->remision,
    //             'patient_id' => $patient->id,
    //             'eps_sender_id' => $this->eps_sender_id,
    //             'user_id' => Auth::id(),
    //             'departure_place_id' => $this->departure_place_id,
    //             'exam_state' => 'Solicitado'
    //         ]);
    //         $estudio = PatientEstudio::create([
    //             'study_name' => $this->estudioList->name,
    //             'accession_number' => $this->accessionNumber,
    //             'study_state' => 'Solicitado',
    //             'list_estudio_id' => $this->estudioList->id,
    //             'exam_id' => $exam->id,
    //             'patient_id' => $patient->id,
    //             'user_id' => Auth::id(),
    //         ]);

    //         $this->examId = $exam->id;
    //         $this->patientId = $patient->id;
    //         $givenName = trim($this->patient_name . '^' . $this->patient_middle_name, '^');
    //         $familyName = trim($this->patient_first_surname . '^' . $this->patient_secund_lastname, '^');
    //         $dicomPatientName = $familyName . '^' . $givenName;
    //         $finalDicomName = preg_replace('/(\^+)/', '^', $dicomPatientName);
    //         $finalDicomName = trim($finalDicomName, '^');


    //         $wlText = $this->generateWlText($this->eat, $patient->document, $finalDicomName, $this->scheduled_date, $this->scheduled_time, $this->estudioList->name, $this->accessionNumber);
    //         $exportPath = config('worklist.export_path');
    //         $this->generateAndMoveWorklist($patient->document, $wlText, $exportPath);
    //     } catch (\Exception $e) {
    //         Log::error("Error al guardar paciente: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
    //         session()->flash('error', 'Ocurrió un error al intentar guardar el registro. Inténtalo de nuevo.');
    //         return false;
    //     }
    // }

    // crea nuevo worklist para ser asignado a examen existente
    // public function generateWorklistOldExam($examId)
    // public function generateWorklistOldExam($examId)
    // {
    //     try {
    //         $this->estudioList = ListEstudio::find($this->procedure);
    //         if (!$this->estudioList) {
    //             throw new \Exception("No se encontró el estudio con ID: {$this->procedure}.");
    //         }
    //         $this->examId = $examId;
    //         $this->patient_name = $this->patientData->name;
    //         $this->patient_id = $this->patientData->document;
    //         $wlText = $this->generateWlText(
    //             $this->eat,
    //             $this->patient_id,
    //             $this->patient_name,
    //             $this->scheduled_date,
    //             $this->scheduled_time,
    //             $this->estudioList->name,
    //             $this->accessionNumber
    //         );
    //         $exportPath = config('worklist.export_path');
    //         $this->generateAndMoveWorklist($this->patient_id, $wlText, $exportPath);
    //         $this->showBoxOldExam = true;
    //         $estudio = PatientEstudio::create([
    //             'study_name' => $this->estudioList->name,
    //             'accession_number' => $this->accessionNumber,
    //             'study_state' => 'Solicitado',
    //             'list_estudio_id' => $this->estudioList->id,
    //             'exam_id' => $this->examId,
    //             'patient_id' => $this->patientId,
    //             'user_id' => Auth::id(),
    //         ]);
    //         $this->dispatch('toast', type: 'success', message: 'Worklist y estudio creados con éxito.');
    //     } catch (\Throwable $e) {
    //         Log::error("Error al generar Worklist: " . $e->getMessage(), ['exception' => $e]);
    //         $this->dispatch('toast', type: 'error', message: "ERROR: No se pudo generar el Worklist o el registro. " . $e->getMessage());
    //         $this->showBoxOldExam = false;
    //     }
    // }

    // crea nuevo examen, nuevo estudio nuevo worklist y lo asigna a paciente existente
    // public function generateWlOldPatient()
    // {
    //     try {
    //         $this->estudioList = ListEstudio::find($this->procedure);
    //         $this->patient_name = $this->patientData->name;
    //         $this->patient_id = $this->patientData->document;
    //         $exam = Exam::create([
    //             'remision' => $this->remision,
    //             'patient_id' => $this->patientData->id,
    //             'eps_sender_id' => $this->eps_sender_id,
    //             'user_id' => Auth::id(),
    //             'departure_place_id' => $this->departure_place_id,
    //             'exam_state' => 'Solicitado'
    //         ]);
    //         $estudio = PatientEstudio::create([
    //             'study_name' => $this->estudioList->name,
    //             'accession_number' => $this->accessionNumber,
    //             'study_state' => 'Solicitado',
    //             'list_estudio_id' => $this->estudioList->id,
    //             'exam_id' => $exam->id,
    //             'patient_id' => $this->patientId,
    //             'user_id' => Auth::id(),
    //         ]);
    //         $wlText = $this->generateWlText($this->eat, $this->patient_id, $this->patient_name, $this->scheduled_date, $this->scheduled_time, $this->estudioList->name, $this->accessionNumber);
    //         $exportPath = config('worklist.export_path');
    //         $this->generateAndMoveWorklist($this->patientData->document, $wlText, $exportPath);
    //         $this->examId = $exam->id;
    //         $this->showBoxOldPatient = true;
    //     } catch (\Exception $e) {
    //         Log::error("Error en generateWlOldPatient: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
    //         session()->flash('error', 'Ocurrió un error al intentar guardar el registro. Inténtalo de nuevo.');
    //         return false;
    //     }
    // }

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


    // nuevas funciones raw
    protected function sanitizeDicomString(string $text): string
    {
        $unwanted_array = [
            'á' => 'A', 'é' => 'E', 'í' => 'I', 'ó' => 'O', 'ú' => 'U',
            'Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U',
            'ñ' => 'N', 'Ñ' => 'N',
            ' ' => '^', // Reemplazamos espacios con ^ (opcional, pero útil para nombres)
        ];
        // Convertimos a mayúsculas y luego reemplazamos caracteres
        $text = strtoupper($text);
        return strtr($text, $unwanted_array);
    }

    public function generateWlText(string $aet, $patientID, $patientName, $scheduledDate, $scheduledTime, $procedure, string $accessionNumber): string
    {
        // Generamos UIDs únicos
        $uid = $this->generateDicomUid();
        $studyInstanceUID = $this->generateDicomUid();
        $spsId = 'SPS_' . $patientID;
        $procedureId = 'PROC_' . $patientID;

        // Sanitización estricta (aunque aquí usamos fijos, se mantiene el patrón)
        $patientNameSafe = $this->sanitizeDicomString($patientName);
        $procedureSafe = $this->sanitizeDicomString($procedure);

        // 1. Construir el Sequence Item (SQ) para asegurar el formato (0040,0100)
        $sequenceItem = 
            "(fffe,e000) na\n" .
            "(0008,0060) CS [CT]\n" .
            "(0040,0001) AE [{$aet}]\n" .
            "(0040,0002) DA [{$scheduledDate}]\n" .
            "(0040,0003) TM [{$scheduledTime}]\n" .
            "(0040,0006) PN [{$patientNameSafe}]\n" . 
            "(0040,0009) SH [{$spsId}]\n" .
            "(0040,1001) SH [{$procedureId}]\n" .
            "(0040,1002) LO [{$procedureSafe}]\n" . 
            "(0032,1060) SH [{$accessionNumber}]\n" .
            "(0040,1003) SH [Routine]\n" .
            "(fffe,e00d) na"; // Delimitador de Item

        // 2. Integrar el Sequence Item y el resto de la Worklist
        // Usamos concatenación simple en lugar de Heredoc para control total.
        $wlText = 
            "(0008,0016) UI [1.2.840.10008.5.1.4.31]\n" .
            "(0008,0018) UI [{$uid}]\n" .
            "(0010,0010) PN [{$patientNameSafe}]\n" .
            "(0010,0020) LO [{$patientID}]\n" .
            "(0008,0050) SH [{$accessionNumber}]\n" .
            "(0020,000D) UI [{$studyInstanceUID}]\n" .
            "(0008,1030) LO [{$procedureSafe}]\n" .
            "(0040,0100) SQ\n" .
            $sequenceItem . "\n" .
            "(fffe,e0dd) na"; // Delimitador de Sequence

        // CRÍTICO: Recortar cualquier espacio o salto de línea fantasma al inicio/fin
        return trim($wlText);
    }

    public function generateWorklistOldExam()
    {
        // 1. Datos Fijos de Prueba
        $patientData = new DummyPatientData();
        $patientID = $patientData->document;
        $patientName = $patientData->name;
        
        // Valores fijos
        $aet = config('worklist.eat', 'MODALITY_AET'); // Lee de config, o usa fallback fijo
        $exportPath = config('worklist.export_path');
        $scheduledDate = '20251105';
        $scheduledTime = '100000';
        $procedureName = 'EXAMEN_FIJO_CT';
        $accessionNumber = '2025110512345';

        try {
            // 2. Generar el texto del Worklist (usa los valores fijos)
            $wlText = $this->generateWlText(
                $aet, 
                $patientID,
                $patientName,
                $scheduledDate,
                $scheduledTime,
                $procedureName,
                $accessionNumber
            );
            
            // 3. Generar y guardar el archivo Worklist usando el Trait (exec()).
            $this->HandlesWlFiles($patientID, $wlText, $exportPath); 

            // Éxito:
            \Illuminate\Support\Facades\Log::info("Worklist de prueba generada con ÉXITO para Patient ID: {$patientID}");

            $this->dispatch('notification-classic', 
                mensaje: 'Worklist de prueba generada con éxito!', 
                tipo: 'success'
            );

        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error("Error CRÍTICO al generar Worklist de prueba: " . $e->getMessage());
            
            $this->dispatch('notification-classic', 
                mensaje: 'Error CRÍTICO al generar Worklist: ' . $e->getMessage(), 
                tipo: 'danger'
            );
        }
    }


    public function render()
    {
        $epsSenders = EpsSender::all();
        $listEstudios = ListEstudio::all();
        $departure_places = DeparturePlace::all();
        return view('livewire.views.view-get-into', compact('epsSenders', 'departure_places', 'listEstudios'));
    }
}
