<?php

namespace App\Livewire\Views;

use Livewire\Component;
use App\Traits\AuthorizesRole;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\PatientEstudio;

class ViewTranscriber extends Component
{
    use AuthorizesRole;
    use WithPagination;

    public $showDrawerTranscriber = false;
    public $estudioId;
    public $search = '';


    public function openDrawerTranscriber($estudioId)
    {
        $this->estudioId = $estudioId;
        $this->showDrawerTranscriber = true;
    }

    #[On('close-drawer-transcriber')]
    public function closeDrawerTranscriber()
    {
        $this->showDrawerTranscriber = false;
        $this->estudioId = null;
    }


    public function render()
    {
        $this->authorizeRole(['Transcriptor', 'admin']);
        $estudios = PatientEstudio::where('study_state', 'Audio');
        $totalPendings = PatientEstudio::where('study_state', 'Audio')->count();
        $totalMonthAuth = PatientEstudio::where('transcriber_user_id', Auth::id())->count();

        if (strlen($this->search) >= 3) {
            $estudios->whereHas('patient', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('document', 'like', '%' . $this->search . '%');
            });
        }
        return view('livewire.views.view-transcriber', [
            'estudios' => $estudios->paginate(10),
            'totalPendings' => $totalPendings,
            'totalMonthAuth' => $totalMonthAuth
        ]);
    }
}
