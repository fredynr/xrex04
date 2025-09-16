<?php

namespace App\Livewire\Tables;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\PatientEstudio;

class TableHighPriority extends Component
{
    use WithPagination;
    public $search = '';
    public $estudioId;
    public $showDrawerReading = false;

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

    protected $listeners = ['searchUpdatedHighPriority' => 'handleSearch'];
    public function handleSearch($value)
    {
        $this->search = $value;
    }
    public function render()
    {
        $estudios = PatientEstudio::with(['patient', 'exam.departurePlace', 'user'])
            ->where(function ($query) {
                $query->whereNull('specialist_user_id')
                    ->where(function ($subQuery) {
                        $subQuery->where('study_state', 'Realizado')
                            ->orWhere('study_state', 'Corrección');
                    })
                    ->where('priority', 'Alta');
                if ($this->search) {
                    $query->whereHas('patient', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('document', 'like', '%' . $this->search . '%');
                    });
                }
            })
            ->orWhere(function ($query) {
                $query->where('specialist_user_id', Auth::id())
                    ->where(function ($subQuery) {
                        $subQuery->where('study_state', 'Realizado')
                            ->orWhere('study_state', 'Corrección');
                    })
                    ->where('priority', 'Alta');
                if ($this->search) {
                    $query->whereHas('patient', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('document', 'like', '%' . $this->search . '%');
                    });
                }
            })
            ->paginate(10);
        return view('livewire.tables.table-high-priority', [
            'estudios' => $estudios
        ]);
    }
}
