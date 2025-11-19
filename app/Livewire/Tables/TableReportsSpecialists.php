<?php

namespace App\Livewire\Tables;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\PatientEstudio;

class TableReportsSpecialists extends Component
{
    use WithPagination;
    public $startDate;
    public $endDate;
    public $user_id;
    public $selectUsers = [];
    public $role = 'Especialista';

    public function mount()
    {
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
        $this->selectUsers = User::where('role', $this->role)->get();
    }

    public function getEstudiosXx()
    {
        if (!$this->user_id) {
            session()->flash('selecciona un:' . $this->role . 'de la lista');
            return;
        }
        $this->resetPage();
    }

    public function render()
    {
        $estudios = [];
        $userName = '';
        if ($this->user_id && $this->startDate && $this->endDate) {
            $userName = User::find($this->user_id)->name;
            $estudios = PatientEstudio::with([
                'specialistUser' => function($query) {
                    $query->select('id','name');
                },
                'exam' => function($query) {
                    $query->select('id', 'eps_sender_id', 'departure_place_id', 'remision');
                }
                ])
                ->where('specialist_user_id', $this->user_id)
                ->whereBetween('date_finalized', [$this->startDate, $this->endDate])
                ->orderBy('date_finalized', 'desc')
                ->paginate(15);
        }
        return view('livewire.tables.table-reports-specialists', [
            'estudiosXx' => $estudios,
            'userName' => $userName
        ]);
    }
}
