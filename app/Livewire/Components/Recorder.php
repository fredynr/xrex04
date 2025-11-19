<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use App\Models\PatientEstudio;

class Recorder extends Component
{
    public $estudioId;

    #[On('guardarAudio')]
    public function guardarAudio($payload)
    {
        DB::beginTransaction();
        try {
            PatientEstudio::where('id', $this->estudioId)->update([
                'study_state' => 'Audio',
                'date_audio' => now(),
                'specialist_user_id' => Auth::id()
            ]);
            // Remueve el encabezado MIME (hasta la coma)
            $base64 = preg_replace('/^data:audio\/\w+;base64,/', '', $payload);

            // Decodifica el base64 en binario
            $audio = base64_decode($base64);

            if ($audio === false) {
                logger('❌ Falló la decodificación del audio');
                return;
            }

            // Genera un nombre único
            $filename = $this->estudioId . '.webm';

            // Guarda el archivo en disco
            Storage::disk('public')->put("audios/$filename", $audio);
            $this->dispatch("actualizarTabla");
            $this->dispatch('close-drawer');
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
    public function render()
    {
        return view('livewire.components.recorder');
    }
}
