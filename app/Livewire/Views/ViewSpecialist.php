<?php

namespace App\Livewire\Views;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Traits\AuthorizesRole;
use App\Models\PatientEstudio;

class ViewSpecialist extends Component
{
    use WithPagination;
    use AuthorizesRole;
    public $search = '';
    public $showDrawerReading = false;
    public $priority = null;
    public $studyState = null;
    public $estudioId;

    public function openDrawerReading($estudioId)
    {
        $estudio = PatientEstudio::find($estudioId);
        if ($estudio->specialist_user_id != null && $estudio->specialist_user_id !== Auth::id()) {
            $this->dispatch('toast', type: 'success', message: "El estudio ha sido asignado a otro especialista.");
        } else {
            $this->estudioId = $estudioId;
            $this->showDrawerReading = true;
        }
    }

    #[on('close-drawer-reading')]
    public function closeDrawerReading()
    {
        $this->showDrawerReading = false;
        $this->reset();
    }

    public function assignMe($estudioId)
    {
        $estudio = PatientEstudio::findOrFail($estudioId);
        $estudio->specialist_user_id = Auth::id();
        $estudio->save();
        $this->dispatch('assigned-me-success');
    }

    public function showByPriority($priority)
    {
        $this->resetPage();
        $this->priority = $priority;
        $this->studyState = null;
    }

    public function showByState($studyState)
    {
        $this->resetPage();
        $this->studyState = $studyState;
        $this->priority = null;
    }

    public function render()
    {
        $this->authorizeRole(['Especialista', 'admin']);
        $estadoCounts = PatientEstudio::whereIn('study_state', ['Realizado', 'Corrección'])
            ->selectRaw('study_state, COUNT(*) as total')
            ->groupBy('study_state')
            ->pluck('total', 'study_state');

        $priorityCounts = PatientEstudio::where('study_state', 'Realizado')
            ->selectRaw('priority, COUNT(*) as total')
            ->groupBy('priority')
            ->pluck('total', 'priority');

        $totalRealizado = $estadoCounts['Realizado'] ?? 0;
        $totalCorreccion = $estadoCounts['Corrección'] ?? 0;
        $totalEstudios = $totalRealizado + $totalCorreccion;

        $estudios = PatientEstudio::with(['patient', 'exam.departurePlace', 'user'])
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->whereNull('specialist_user_id')
                        ->whereIn('study_state', ['Realizado', 'Corrección']);
                    if ($this->priority) {
                        $q->where('priority', $this->priority);
                    }

                    if ($this->studyState) {
                        $q->where('study_state', $this->studyState);
                    }

                    if ($this->search) {
                        $this->resetPage();
                        $q->whereHas(
                            'patient',
                            fn($q2) =>
                            $q2->where('name', 'like', '%' . $this->search . '%')
                                ->orWhere('document', 'like', '%' . $this->search . '%')
                        );
                    }
                })->orWhere(function ($q) {
                    $q->where('specialist_user_id', Auth::id())
                        ->whereIn('study_state', ['Realizado', 'Corrección']);
                    if ($this->priority) {
                        $q->where('priority', $this->priority);
                    }

                    if ($this->studyState) {
                        $q->where('study_state', $this->studyState);
                    }

                    if ($this->search) {
                        $this->resetPage();
                        $q->whereHas(
                            'patient',
                            fn($q2) =>
                            $q2->where('name', 'like', '%' . $this->search . '%')
                                ->orWhere('document', 'like', '%' . $this->search . '%')
                        );
                    }
                });
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('livewire.views.view-specialist', [
            'totalEstudios' => $totalEstudios,
            'totalCorrected' => $totalCorreccion,
            'countNormal' => $priorityCounts['Normal'] ?? 0,
            'countBaja' => $priorityCounts['Baja'] ?? 0,
            'countAlta' => $priorityCounts['Alta'] ?? 0,
            'estudios' => $estudios,
        ]);
    }
}
