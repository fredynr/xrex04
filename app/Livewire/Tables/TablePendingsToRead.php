<?php

namespace App\Livewire\Tables;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use App\Models\PatientEstudio;

class TablePendingsToRead extends Component
{
    use WithPagination;
    public $estudioId;
    public $showDrawerReading = false;
    public string $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    #[On('resetPagination')]
    public function resetPagination()
    {
        $this->resetPage();
    }


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
        $this->resetPage();
    }

    protected $listeners = ['searchUpdatedPendingsRead' => 'handleSearch'];
    public function handleSearch($value)
    {
        $this->search = $value;
    }


    public function render()
    {
        $estudios = PatientEstudio::with(['patient', 'exam.departurePlace', 'user'])
            ->where(function ($query) {
                // Condición principal: Estudios sin asignar
                $query->whereNull('specialist_user_id')
                    ->where(function ($subQuery) {
                        $subQuery->where('study_state', 'Realizado')
                            ->orWhere('study_state', 'Corrección');
                    });
                // Aplica la búsqueda SOLO si hay un término de búsqueda
                if ($this->search) {
                    $query->whereHas('patient', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('document', 'like', '%' . $this->search . '%');
                    });
                }
            })
            ->orWhere(function ($query) {
                // Condición principal: Estudios asignados al usuario
                $query->where('specialist_user_id', Auth::id())
                    ->where(function ($subQuery) {
                        $subQuery->where('study_state', 'Realizado')
                            ->orWhere('study_state', 'Corrección');
                    });
                // Aplica la búsqueda SOLO si hay un término de búsqueda
                if ($this->search) {
                    $query->whereHas('patient', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('document', 'like', '%' . $this->search . '%');
                    });
                }
            })
            ->paginate(10);

        return view('livewire.tables.table-pendings-to-read', [
            "estudios" => $estudios,
        ]);
    }
}
