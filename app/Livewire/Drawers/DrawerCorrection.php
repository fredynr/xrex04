<?php

namespace App\Livewire\Drawers;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\PatientEstudio;
use App\Models\Exam;

class DrawerCorrection extends Component
{
    public $studyName;
    public $estudioId;
    public $priority;
    public $tech_description;
    public $studyID;
    public $examId;
    public $patientId;
    public $patientName;
    public $specialistUserId;
    public $studiesToView = [];


    public function mount($estudioId, $studyID, $studyName, $examId, $patientId, $patientName, $studiesToView, $specialistUserId){
        $this->estudioId = $estudioId;
        $this->studyID = $studyID;
        $this->studyName = $studyName;
        $this->examId = $examId;
        $this->patientId = $patientId;
        $this->patientName = $patientName;
        $this->specialistUserId = $specialistUserId;
        $this->studiesToView = $studiesToView;
    }

    public function closeDrawer()
    {
        $this->dispatch('close-drawer-correction');
    }

    public function storeCorrection()
    {
        $this->validate(([
            'tech_description' => 'required',
            'priority' => 'required',
        ]));
        
        DB::beginTransaction();
        try {
            PatientEstudio::create([
                'tech_description' => $this->tech_description,
                'study_id_orthanc' => $this->studyID,
                'study_state' => 'Corrección',
                'exam_id' => $this->examId,
                'patient_id' => $this->patientId,
                'user_id' => Auth::id(),
                'specialist_user_id' => $this->specialistUserId,
                'priority' => $this->priority,
                'study_name' => $this->studyName,
                'estudio_parent_id' => $this->estudioId,
            ]);
            PatientEstudio::find($this->estudioId)->update([
                'study_state' => 'Corregido',
            ]);
            $this->studiesToView = array_filter($this->studiesToView, function ($study) {
                return $study->id !== $this->studyID;
            });
            if (empty($this->studiesToView)) {
                $exam = Exam::find($this->examId);
                $exam->exam_state = 'Realizado';
                $exam->save();
            }
            $this->reset();
            DB::commit(); // Confirmar la transacción si todo sale bien
            session()->flash('message', 'El estudio fue enviado al especialista. Gracias :)');
            $this->closeDrawer();
        } catch (\Exception $e) {
            DB::rollBack(); // Revertir la transacción en caso de error
            Log::error('Error al crear paciente y examen: ' . $e->getMessage());
            session()->flash('error', 'No se pudo enviar la corrección. Por favor, inténtelo de nuevo o contacte al soporte si el problema persiste.');
        };
    }

    public function render()
    {
        return view('livewire.drawers.drawer-correction');
    }
}
