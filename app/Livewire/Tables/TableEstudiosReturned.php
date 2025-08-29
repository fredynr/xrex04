<?php

namespace App\Livewire\Tables;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Traits\HandlesOrthancStudy;
use Livewire\WithPagination;
use App\models\PatientEstudio;
use App\Models\Patient;

class TableEstudiosReturned extends Component
{
    use HandlesOrthancStudy;
    use WithPagination;
    public $selectedPatientId;
    public $studyID;
    public string $search = '';
    public $showDrawer = false;

    public $studyName;
    public $studiesToView = [];
    public $studiesPatientBBDD;
    public $showDrawerInfoReturned = false;
    public $showDrawerCorrection = false;

    public function openDrawerInfoReturned($studyID)
    {
        $this->studyID = $studyID;
        $this->showDrawerInfoReturned = true;
    }

    #[On('close-drawer-info-returned')]
    public function closeDrawerInfoReturned()
    {
        $this->reset('studyID');
        $this->resetPage();
        $this->showDrawerCorrection = false;
    }

    public function openDrawerCorrection($studyID)
    {
        $this->studyID = $studyID;
        $this->showDrawerCorrection = true;
    }

    #[On('close-drawer-correction')]
    public function closeDrawerCorrection()
    {
        $this->reset('studyID');
        $this->showDrawerInfoReturned = false;
    }


    protected $listeners = ['searchUpdatedReturned' => 'handleSearch'];
    public function handleSearch($value)
    {
        $this->search = $value;
    }

        public function getOrthancStudies(Patient $patient)
    {
        // dump($this->all());
        // dd($patient->document);
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
        $curlResponse = curl_exec($ch);
        if (curl_errno($ch)) {
            echo curl_error($ch);
        } else {
            $curlResponse = json_decode($curlResponse);
        }
        curl_close($ch);
        $this->selectedPatientId = $patient->id;
        $countStudiesBBDD = $patient->patientEstudios()->count();
        if ($countStudiesBBDD === 0) {
            // $this->studiesToView = $curlResponse;
            foreach($curlResponse as $res){
                $url = "http://localhost:8042/studies/$res";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);
                $data = json_decode($response, true);
                if (isset($data["MainDicomTags"]["StudyDescription"])){
                    $study = new \stdClass();
                    $study->id = $data["ID"];
                    $study->description = $data["MainDicomTags"]["StudyDescription"];
                    $studiesCollection[] = $study;
                    $this->studiesToView = $studiesCollection;
                }else{
                    $this->studyName = "El Nuevo DICOM no tiene nombre de estudio";
                }
            }
        } else {
            $this->studiesPatientBBDD = $patient->patientEstudios()->pluck('study_id_orthanc')->toArray();
            $studiesRaws = array_filter($curlResponse, function ($study) {
                return !in_array($study, $this->studiesPatientBBDD, true);
            });
            $studiesCollection = [];
            foreach ($studiesRaws as $studiesRaw) {
                $url = "http://localhost:8042/studies/$studiesRaw";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);
                $data = json_decode($response, true);
                if (isset($data["MainDicomTags"]["StudyDescription"])) {
                    $study = new \stdClass();
                    $study->id = $data["ID"];
                    $study->description = $data["MainDicomTags"]["StudyDescription"];
                    $studiesCollection[] = $study;
                } else {
                    $this->studyName = "El DICOM no tiene el nombre del estudio";
                }
            }
            $this->studiesToView = $studiesCollection;
            if (empty($this->studiesToView)) {
                $this->dispatch('toast', type: 'success', message: "No se encontraron estudios, revisa que el número de identificación coincida con.{$patient->document}");
            }
        }
    }

    public function render()
    {
        $estudiosReturned = PatientEstudio::with(['patient', 'exam.departurePlace', 'user', 'specialistUser'])
        ->where('study_state', 'Devuelto')
        ->when($this->search, function ($query) {
            $query->whereHas('patient', function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('document', 'like', "%{$this->search}%");
            });
        })
        ->paginate(10);

    return view('livewire.tables.table-estudios-returned', [
        'estudiosReturned' => $estudiosReturned
    ]);

}
}
