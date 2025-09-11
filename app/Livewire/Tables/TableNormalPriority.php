<?php

namespace App\Livewire\Tables;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Models\PatientEstudio;

class TableNormalPriority extends Component
{
    use WithPagination;
    public $search = '';
    public $estudioId;
    public $showDrawerReading = false;

    public function openDrawerReading($estudioId)
    {
        $this->estudioId = $estudioId;
        $this->showDrawerReading = true;
    }

    #[on('close-drawer-reading')]
    public function closeDrawerReading()
    {
        $this->showDrawerReading = false;
        $this->reset();
    }

    protected $listeners = ['searchUpdatedNormalPriority' => 'handleSearch'];
    public function handleSearch($value)
    {
        $this->search = $value;
    }

    public function render()
    {
        $estudios = PatientEstudio::with(['patient', 'exam.departurePlace', 'user'])
        ->where('study_state', 'Realizado')
        ->where('priority', 'Normal')
        ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->whereHas('patient', function ($q) {
                        $q->where('name', 'like', "%{$this->search}%")
                            ->orWhere('document', 'like', "%{$this->search}%");
                    });
                });
            })
        ->paginate();
        return view('livewire.tables.table-normal-priority', [
            'estudios' => $estudios
        ]);
    }
}
