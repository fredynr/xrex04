<?php

namespace App\Livewire\Views;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\PatientEstudio;
use Livewire\WithPagination;


class ViewSpecialist extends Component
{
    use WithPagination;
    public $search = '';

    public bool $openParent = false;
    public $openChildId = null;
    public $estudioId = null;
    public $showFecha;
    public $showIdentificacion;
    public $showProcedencia;
    public $showDrawer = false;


    #[On('actualizarTabla', '$refresh')]

    #[On('close-drawer')]
    public function closeDrawer()
    {
        $this->showDrawer = false;
        $this->resetPage();
    }

    public function openDrawer($estudioId)
    {
        $this->estudioId = $estudioId;
    }

    public function render()
    {
        $studies = PatientEstudio::with(['patient', 'exam.departurePlace', 'user'])
            ->where(function ($query) {
                $query->where('study_state', 'Realizado')
                    ->orWhere('study_state', 'Corrección');
            });

        $totalStudies = PatientEstudio::where('study_state', 'Realizado')->count();
        $counts = PatientEstudio::where('study_state', 'Realizado')
            ->selectRaw('priority, COUNT(*) as total')
            ->groupBy('priority')
            ->pluck('total', 'priority');

        if (strlen($this->search) >= 3) {
            $studies->whereHas('patient', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('document', 'like', '%' . $this->search . '%');
            });
        }

        return view('livewire.views.view-specialist', [
            'studies' => $studies->paginate(10),
            'totalStudies' => $totalStudies,
            'countNormal' => $counts['Normal'] ?? 0,
            'countBaja' => $counts['Baja'] ?? 0,
            'countAlta' => $counts['Alta'] ?? 0
        ]);
    }
}
