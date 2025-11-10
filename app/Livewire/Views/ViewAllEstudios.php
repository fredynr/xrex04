<?php

namespace App\Livewire\Views;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\PatientEstudio;

class ViewAllEstudios extends Component
{
    use WithPagination;
    public $search = '';
    public $showDrawerAddendum = false;
    public $showDrawerDetailsEstudio = false;
    public $estudioId;

    public function openDrawerAddendum($estudioId)
    {
        $this->showDrawerAddendum = true;
        $this->estudioId = $estudioId;
    }

    public function openDrawerDetailsEstudio($estudioId)
    {
        $this->showDrawerDetailsEstudio = true;
        $this->estudioId = $estudioId;
    }

    #[On('close-drawer-addendum')]
    public function closeDrawerAddendum()
    {
        $this->showDrawerAddendum = false;
    }

    #[On('close-drawer-details-estudio')]
    public function closeDrawerDetailsEstudio()
    {
        $this->showDrawerDetailsEstudio = false;
    }

    private function getBaseEstudiosQuery()
    {
        return PatientEstudio::with(['patient', 'listEstudio', 'exam'])
            ->whereNot('study_state', 'Reelaborado')
            ->when($this->search, function ($query) {
                $query->whereHas('patient', function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                        ->orWhere('document', 'like', "%{$this->search}%");
                });
            });
    }
    public function render()
    {
        $estudios = $this->getBaseEstudiosQuery()->paginate(10);
        return view('livewire.views.view-all-estudios', compact('estudios'));
    }
}
