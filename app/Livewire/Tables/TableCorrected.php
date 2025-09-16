<?php

namespace App\Livewire\Tables;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use App\Models\PatientEstudio;

class TableCorrected extends Component
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

    protected $listeners = ['searchUpdatedCorrected' => 'handleSearch'];
    public function handleSearch($value)
    {
        $this->search = $value;
    }

    public function render()
    {
        $estudios = PatientEstudio::with(['patient', 'exam.departurePlace', 'user'])
            ->where('study_state', 'Corrección')
            ->where('specialist_user_id', Auth::id())
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->whereHas('patient', function ($q) {
                        $q->where('name', 'like', "%{$this->search}%")
                            ->orWhere('document', 'like', "%{$this->search}%");
                    });
                });
            })
            ->paginate();
        return view('livewire.tables.table-corrected', [
            'estudios' => $estudios
        ]);
    }
}
