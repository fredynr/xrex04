<?php

namespace App\Livewire\Tables;

use Livewire\Component;
use App\Traits\HandlesOrthancStudy;
use App\Traits\HandlesOrthancAuth;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Http;
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
    public $estudioId;
    public $patientId;
    public $studiesPatientBBDD;
    public $showDrawerUpdatePatient = false;
    public $selectedStudyId;
    public $showDrawerStudyTech = false;
    public string $search = '';
    public $estudioInOrthanc = false;

    public $accessionNumber;
    public $studyIdOrthanc;
    public $estudiosConOrthanc = [];
    private $orthancUrl = 'http://localhost:8042';


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


    // public function getOrthancStudies(Patient $patient, $estudioId)
    // {
    //     $this->reset();
    //     $this->estudioId = $estudioId;
    //     $document = strval($patient->document);
    //     $ch = curl_init();
    //     $array = [
    //         "Level" => "Study",
    //         "Query" => [
    //             "PatientID" => $document
    //         ]
    //     ];
    //     $array = json_encode($array);
    //     curl_setopt($ch, CURLOPT_URL, 'http://localhost:8042/tools/find');
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $array);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, $this->orthancAuthHeader());
    //     $curlResponse = curl_exec($ch);
    //     if (curl_errno($ch)) {
    //         throw new \Exception("Error de conexión con Orthanc: " . curl_error($ch));
    //     }
    //     $decoded = json_decode($curlResponse, true);

    //     Log::info('Respuesta Orthanc:', $decoded);
    //     $curlResponse = $decoded;
    //     curl_close($ch);
    //     $this->selectedPatientId = $patient->id;
    //     $curlResponse = is_array($curlResponse) ? $curlResponse : [];

    //     $countStudiesBBDD = $patient->patientEstudios()->count();
    //     // si el conteo de los estudios del paciente en la BBDD es igual a 0 entonces es porque es la primera vez que el paciente ingresa
    //     // el tecnólogo tomó los estudios y se guardan en la variable $curlResponse y son iterados ara mostrarlos en la vista
    //     if ($countStudiesBBDD === 0) {
    //         foreach ($curlResponse as $res) {
    //             $url = "http://localhost:8042/studies/$res";
    //             $ch = curl_init();
    //             curl_setopt($ch, CURLOPT_URL, $url);
    //             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //             curl_setopt($ch, CURLOPT_HTTPHEADER, $this->orthancAuthHeader());
    //             $response = curl_exec($ch);
    //             curl_close($ch);
    //             $data = json_decode($response, true);

    //             if (isset($data["MainDicomTags"]["StudyDescription"])) {
    //                 $study = new \stdClass();
    //                 $study->id = $data["ID"];
    //                 $study->description = $data["MainDicomTags"]["StudyDescription"];
    //                 $studiesCollection[] = $study;
    //                 $this->studiesToView = $studiesCollection;
    //             } else {
    //                 $study = new \stdClass();
    //                 $study->id = $data["ID"];
    //                 $study->description = "El Nuevo DICOM no tiene nombre de estudio";
    //                 $studiesCollection[] = $study;
    //                 $this->studiesToView = $studiesCollection;
    //             }
    //         }
    //     } else {
    //         // si el conteo de los estudios de la BBDD es mayor a 0 entonces toca comparar los estudios de la BBDD con los de Orthanc
    //         // para saber cuales son nuevos y mostrarlos en la vista
    //         // recupera con pluck la columna study_id_orthanc de la tabla patient_estudios
    //         $this->studiesPatientBBDD = $patient->patientEstudios()->pluck('study_id_orthanc')->toArray();
    //         //devuelve los que estan en $orthanc y no están en la BBDD
    //         $studiesRaws = array_filter($curlResponse, function ($study) {
    //             return !in_array($study, $this->studiesPatientBBDD, true);
    //         });
    //         $studiesCollection = [];
    //         if (!is_array($curlResponse)) {
    //             throw new \Exception("La respuesta de Orthanc no es un array válido.");
    //         }
    //         foreach ($studiesRaws as $studiesRaw) {
    //             // uso el trait HandleOrthancStudy
    //             $data = $this->StudyDataFromOrthanc($studiesRaw);
    //             $studyDescription = "El DICOM no tiene el nombre del estudio";
    //             if (isset($data["MainDicomTags"]["StudyDescription"])) {
    //                 $studyDescription = $this->extractStudyName($data);
    //                 $study = new \stdClass();
    //                 $study->id = $studiesRaw;
    //                 $study->description = $studyDescription;
    //                 $studiesCollection[] = $study;
    //             } else {
    //                 // dd($data);
    //                 $this->studyName = $studyDescription;
    //             }
    //         }
    //         $this->studiesToView = $studiesCollection;
    //     }
    //     if (empty($this->studiesToView)) {
    //         $this->dispatch('toast', type: 'success', message: "No se encontraron estudios, revisa que el número de identificación coincida con.{$patient->document}");
    //     }
    // }


    private function getBaseEstudiosQuery()
    {
        return PatientEstudio::with(['patient', 'listEstudio', 'exam'])
            ->where('study_state', 'Solicitado')
            ->when($this->search, function ($query) {
                $query->whereHas('patient', function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                        ->orWhere('document', 'like', "%{$this->search}%");
                });
            });
    }

    // public function verificarTodosOrthanc()
    // {
    //     $estudios = $this->getBaseEstudiosQuery()->get();
    //     $idsEncontrados = [];

    //     foreach ($estudios as $estudio) {
    //         $existe = $this->consultarOrthanc($estudio->accession_number);
    //         if ($existe) {
    //             $idsEncontrados[] = $estudio->id;
    //         }
    //     }
    //     $this->estudiosConOrthanc = $idsEncontrados;
    //     $this->dispatch('toast', type: 'success', message: 'Consulta de estudios finalizada.');
    // }

    // private function consultarOrthanc($accessionNumber)
    // {
    //     if (empty($accessionNumber)) {
    //         return false;
    //     }

    //     $payload = [
    //         "Level" => "Study",
    //         "Query" => ["AccessionNumber" => $accessionNumber],
    //         "DicomWeb" => false
    //     ];
    //     try {
    //         $response = Http::post("{$this->orthancUrl}/tools/find", $payload);
    //         // Si el estado no es 2xx, lanza una excepción que es capturada por el catch de abajo
    //         $response->throw();

    //         return !empty($response->json()); // Devuelve true si el array no está vacío

    //     } catch (\Throwable $e) {
    //         // Manejo discreto de errores de conexión/API para no detener el bucle
    //         return false;
    //     }
    // }

    public function getSingleEstudio($accessionNumber)
    {
        $this->reset();
        if (empty($accessionNumber) || $accessionNumber === 'N/A') {
            $this->dispatch(
                'notification-classic',
                mensaje: 'No tiene AccessionNumber',
                tipo: 'success'
            );
            return;
        }
        $this->accessionNumber = $accessionNumber;

        $payload = [
            "Level" => "Study",
            "Query" => [
                "AccessionNumber" => $accessionNumber
            ],
            "DicomWeb" => false
        ];
        try {
            $response = Http::post("{$this->orthancUrl}/tools/find", $payload);
            // Verificar si la petición fue exitosa (código 200)
            $response->throw();
            // Orthanc devuelve un array JSON
            $resultados = $response->json();
            if (!empty($resultados)) {
                $this->studyIdOrthanc = $resultados[0];
                $this->estudioInOrthanc = true;
                $this->dispatch(
                    'notification-classic',
                    mensaje: 'Estudio encontrado, ahora puedes enviarlo',
                    tipo: 'success'
                );
            } else {
                $this->dispatch(
                    'notification-classic',
                    mensaje: 'No se encontrón ningun estudio revisa que ya lo hayas tomado',
                    tipo: 'danger'
                );
            }
        } catch (\Exception $e) {
            // Manejo de errores de conexión o API (ej: Orthanc no responde)
            $this->dispatch(
                'notification-classic',
                mensaje: 'Estudio encontrado',
                tipo: 'success'
            );
            $this->estudioInOrthanc = false;
        }
    }

    public function render()
    {
        $estudios = $this->getBaseEstudiosQuery()->paginate(10);

        return view('livewire.tables.table-pendings-to-do', [
            'estudios' => $estudios,
        ]);
    }
}
