<?php

namespace App\Livewire\Views;

use Livewire\Component;
use App\Traits\AuthorizesRole;
use App\Models\PatientEstudio;
use Livewire\Attributes\On;

class ViewSpecialist extends Component
{
    use AuthorizesRole;
    public $search = '';
    public $currentTable = "tables.table-pendings-to-read";
    protected $listeners = ["navigateTableSpecialist"];
    public function navigateTableSpecialist($table)
    {
        $this->currentTable = $table;
    }

    #[On('reset-header')]
    public function resetHeader()
    {
        $this->reset();
    }

    public function searchMapTable($value, $tableTarget)
    {
        $eventMap = [
            'tables.table-pendings-to-read' => 'searchUpdatedPendingsRead',
            'tables.table-high-priority' => 'searchUpdatedHighPriority',
            'tables.table-normal-priority' => 'searchUpdatedNormalPriority',
            'tables.table-low-priority' => 'searchUpdatedLowPriority',
            'tables.table-corrected' => 'searchUpdatedCorrected',
        ];

        if (isset($eventMap[$tableTarget])) {
            $this->dispatch($eventMap[$tableTarget], value: $value);
            $this->dispatch('cleanURL');
        }
    }

    public function render()
    {
        $this->authorizeRole(['Especialista', 'admin']);
        // Agrupamos por estado
        $estadoCounts = PatientEstudio::whereIn('study_state', ['Realizado', 'Corrección'])
            ->selectRaw('study_state, COUNT(*) as total')
            ->groupBy('study_state')
            ->pluck('total', 'study_state');

        // Agrupamos por prioridad solo para los realizados
        $priorityCounts = PatientEstudio::where('study_state', 'Realizado')
            ->selectRaw('priority, COUNT(*) as total')
            ->groupBy('priority')
            ->pluck('total', 'priority');
        $totalRealizado = $estadoCounts['Realizado'] ?? 0;
        $totalCorreccion = $estadoCounts['Corrección'] ?? 0;
        $totalEstudios = $totalRealizado + $totalCorreccion;

        return view('livewire.views.view-specialist', [
            'totalEstudios' => $totalEstudios,
            'totalCorrected' => $totalCorreccion,
            'countNormal' => $priorityCounts['Normal'] ?? 0,
            'countBaja' => $priorityCounts['Baja'] ?? 0,
            'countAlta' => $priorityCounts['Alta'] ?? 0,
        ]);
    }
}
