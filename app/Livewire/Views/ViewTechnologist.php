<?php

namespace App\Livewire\Views;

use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use App\Traits\AuthorizesRole;
use Livewire\Component;
use App\Models\Exam;
use App\Models\PatientEstudio;

class ViewTechnologist extends Component
{
    use AuthorizesRole;
    public $totalExams;
    public $totalDevueltos;
    public $totalPendings;
    public $showDrawerStudyTech = false;

    public $search = '';


    public function actualizarTablaExams()
    {
        $this->dispatch('refresh');
    }

    public $currentTable = "tables.table-pendings-to-do";
    protected $listeners = ['navigateTableTechnologist'];
    public function navigateTableTechnologist($table)
    {
        $this->currentTable = $table;
    }

    public function searchMapTable($value, $tableTarget)
    {
        $eventMap = [
            'tables.table-pendings-to-do' => 'searchUpdatedPendings',
            'tables.table-estudios-returned' => 'searchUpdatedReturned',
        ];

        if (isset($eventMap[$tableTarget])) {
            $this->dispatch($eventMap[$tableTarget], value: $value);
            $this->dispatch('cleanURL');
        }
    }

    public function render()
    {
        $this->authorizeRole(['Tecnólogo', 'admin']);
        $this->totalExams = Exam::where('exam_state', 'Solicitado')->count();
        $this->totalDevueltos = PatientEstudio::where('study_state', 'Devuelto')->count();
        $this->totalPendings = $this->totalExams + $this->totalDevueltos;

        return view('livewire.views.view-technologist');
    }
}
