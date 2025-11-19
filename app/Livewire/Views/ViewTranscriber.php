<?php

namespace App\Livewire\Views;

use Livewire\Component;
use App\Traits\AuthorizesRole;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
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

    public function assignMe($estudioId)
    {
        $estudio = PatientEstudio::with(['transcriberUser'])->findOrFail($estudioId);
        if ($estudio->transcriber_user_id === null) {
            $estudio->transcriber_user_id = Auth::id();
            $estudio->save();
            $this->dispatch(
                'notification-classic',
                mensaje: 'Se te asignó un nuevo estudio para transcribir',
                tipo: 'success'
            );
        } else {
            $this->dispatch(
                'notification-classic',
                mensaje: 'Este estudio ya ha sido asignado a otro usuario',
                tipo: 'error'
            );
        }
    }


    public function render()
    {
        $this->authorizeRole(['Transcriptor', 'admin', 'Especialista']);
        $query = PatientEstudio::where('study_state', 'Audio')
            ->where(function ($query) {
                $query->whereNull('transcriber_user_id')
                    ->orWhere('transcriber_user_id', Auth::id());
            });

        $totalPendings = PatientEstudio::where('study_state', 'Audio')->count();
        $totalMonthAuth = PatientEstudio::where('transcriber_user_id', Auth::id())
            ->whereNotNull('reading')
            ->whereBetween('date_transcriber', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth()
            ])
            ->count();

        if (strlen($this->search) >= 3) {
            $query->whereHas('patient', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('document', 'like', '%' . $this->search . '%');
            });
        }
        $estudios = $query->paginate(10);

        return view('livewire.views.view-transcriber', [
            'estudios' => $estudios,
            'totalPendings' => $totalPendings,
            'totalMonthAuth' => $totalMonthAuth
        ]);
    }
}
