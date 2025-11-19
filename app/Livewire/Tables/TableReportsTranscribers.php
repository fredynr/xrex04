<?php

namespace App\Livewire\Tables;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\PatientEstudio;

class TableReportsTranscribers extends Component
{
    use WithPagination;
    public $startDate;
    public $endDate;
    public $transcriber_id;
    public $transcribers = [];

    public function mount()
    {
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
        $this->transcribers = User::where('role', 'Transcriptor')->get();
    }

    public function getEstudiosXx()
    {
        if (!$this->transcriber_id) {
            session()->flash('error', 'Selecciona un transcriptor');
            return;
        }
        $this->resetPage();
    }

    public function render()
    {
        $estudios = [];
        $transcriberName = '';
        if ($this->transcriber_id && $this->startDate && $this->endDate) {
            $transcriberName = User::find($this->transcriber_id)->name;
            $estudios = PatientEstudio::with([
                'specialistUser' => function($query) {
                    $query->select('id','name');
                }
                ])
                ->where('transcriber_user_id', $this->transcriber_id)
                ->whereBetween('date_transcriber', [$this->startDate, $this->endDate])
                ->orderBy('date_transcriber', 'desc')
                ->paginate(15);
        }

        return view('livewire.tables.table-reports-transcribers', [
            'estudiosXx' => $estudios,
            'transcriberName' => $transcriberName
        ]);
    }
}
