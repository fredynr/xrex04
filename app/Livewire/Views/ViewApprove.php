<?php

namespace App\Livewire\Views;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Exception;
use App\Models\PatientEstudio;


class ViewApprove extends Component
{
    use WithPagination;
    public $search = "";
    public $estudioId;
    public $singleEstudio;
    public $open = false;


    protected $rules = [
        
    ];

    public function activeEdit($estudioId)
    {
        $this->estudioId = $estudioId;
        $this->singleEstudio = PatientEstudio::find($estudioId)->reading;
        $this->open = true;
    }

    public function deactivate()
    {
        $this->estudioId = null;
        $this->singleEstudio = null;
        $this->open = false;
    }

    public function approve($estudioId)
    {
        $estudio = PatientEstudio::with(['patient'])->findOrFail($estudioId);
        $estudio->update([
            'study_state' => 'Finalizado'
        ]);
        $this->dispatch(
            'notification-classic',
            mensaje: 'El estudio, del paciente'.' ' . $estudio->patient->name .' ' . 'quedó aprobado',
            tipo: 'success'
        );
    }

    public function saveAndApprove($estudioId)
    {
        try {
            $estudio = PatientEstudio::findOrFail($estudioId);
            $estudio->update([
                'reading' => $this->singleEstudio,
                'study_state' => 'Finalizado',
            ]);
            $this->dispatch(
                'notification-classic',
                mensaje: '¡Se ha actualizado la lectura y quedó aprobada!',
                tipo: 'success'
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $this->dispatch(
                'notification-classic',
                mensaje: 'Error: El estudio con ID ' . $estudioId . ' no se pudo encontrar.',
                tipo: 'error'
            );
        } catch (Exception $e) {
            $this->dispatch(
                'notification-classic',
                mensaje: 'Ocurrió un error al procesar la solicitud. Intente de nuevo.',
                tipo: 'error'
            );
        };
    }

    public function render()
    {
        $query = PatientEstudio::with(['transcriberUser', 'specialistUser', 'patient'])
            ->where('study_state', 'Digitado')
            ->where('specialist_user_id', Auth::id());

        if (strlen($this->search) >= 3) {
            $this->resetPage();
            $query->whereHas('patient', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('document', 'like', '%' . $this->search . '%');
            });
        }

        $estudios = $query->paginate();

        return view('livewire.views.view-approve', compact('estudios'));
    }
}
