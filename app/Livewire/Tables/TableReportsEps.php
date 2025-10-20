<?php

namespace App\Livewire\Tables;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\EpsSender;
use App\Models\PatientEstudio;
use Carbon\Carbon;

class TableReportsEps extends Component
{
    use WithPagination;
    public $startDate;
    public $endDate;
    public $eps_id;
    public $selectEps = [];

    public function mount()
    {
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
        $this->selectEps = EpsSender::all();
    }

    public function getEstudiosXx()
    {
        if (!$this->eps_id) {
            session()->flash('selecciona una EPS de la lista');
            return;
        }
        $this->resetPage();
    }


    public function render()
    {
        $endDayInclusive = Carbon::parse($this->endDate)->endOfDay();
        $startDate = $this->startDate;
        $epsId = $this->eps_id;
        $estudios = PatientEstudio::with([
            'patient',
            'specialistUser',
            'exam.epsSender' // Carga PatientEstudio -> Exam -> EpsSender
        ])
            ->whereBetween('date_finalized', [$startDate, $endDayInclusive])
            // ⚡️ FILTRO 2: Condición en la relación Exam (eps_sender_id) ⚡️
            ->whereHas('exam', function ($query) use ($epsId) {
                // Solo trae los PatientEstudio cuyo Exam coincida con el ID de la EPS
                $query->where('eps_sender_id', $epsId);
            })
            ->orderBy('date_finalized', 'desc')
            ->paginate(15);

        return view('livewire.tables.table-reports-eps', [
            'estudios' => $estudios,
        ]);
    }
}
