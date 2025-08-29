<?php

namespace App\Livewire\Tables;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\PatientEstudio;


class TableDeliveryEstudio extends Component
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
        $estudios = PatientEstudio::with(['patient', 'exam.departurePlace', 'user'])
        ->where('study_state', 'Finalizado');
        if (strlen($this->search) >= 3) {
            $estudios->whereHas('patient', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('document', 'like', '%' . $this->search . '%');
            });
        }
        
        return view('livewire.tables.table-delivery-estudio', [
            'estudios' => $estudios->paginate(10)
        ]);
    }
}
