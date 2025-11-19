<?php

namespace App\Livewire\Views;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\PatientEstudio;

class ViewDeliveryEstudio extends Component
{
    use WithPagination;
    public $search = '';
    public $showDrawerSendMail = true;
    public $estudioId;

    public function openDrawerSendMail($estudioId)
    {
        $this->showDrawerSendMail = true;
        $this->estudioId = $estudioId;
    }

    #[On('close-drawer-send-mail')]
    public function closeDrawerSendMail()
    {
        $this->showDrawerSendMail = false;
    }

    public function render()
    {
        $estudiosQuery = PatientEstudio::with([
            'patient',
            'exam.departurePlace',
            'user'
        ])->where('study_state', 'Finalizado');

        if (strlen(trim($this->search)) >= 3) {
            $estudiosQuery->whereHas('patient', function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('document', 'like', '%' . $this->search . '%');
                });
            });
        }

        $estudios = $estudiosQuery->paginate(10);

        return view('livewire.views.view-delivery-estudio', compact('estudios'));
    }
}
