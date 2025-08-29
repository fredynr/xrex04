<?php

namespace App\Livewire\Drawers;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailDeliveryEstudio;
use App\Models\PatientEstudio;
use App\Models\Instance;

class DrawerSendMail extends Component
{
    public $patientEmail;
    public $patientName;
    public $estudioId;
    public $studyID;

    public function mount($patientEmail, $patientName, $estudioId, $studyID)
    {
        $this->patientEmail = $patientEmail;
        $this->patientName = $patientName;
        $this->estudioId = $estudioId;
        $this->studyID = $studyID;
    }

    public function closeDrawer()
    {
        $this->dispatch('close-drawer-send-mail');
    }

    public function enviarMail()
    {
        $instances = Instance::where('patient_estudio_id', $this->estudioId)->get();
        $attachments = [];
        if ($instances->count() === 0) {
            $response = Http::get("http://localhost:8042/studies/{$this->studyID}/instances");
            $instances = $response->json();
            foreach ($instances as $instance) {
                DB::beginTransaction();
                try {
                    $desdePdf = true;
                    $estudio = PatientEstudio::with(['patient', 'specialistUser', 'exam.departurePlace'])
                        ->find($this->estudioId);
                        $pdf = Pdf::loadView('pdfView', compact('estudio', 'desdePdf'))
                        ->setPaper('letter', 'portrait');
                        $filenamePdf = "readings/{$this->estudioId}.pdf";
                    Storage::disk('public')->put($filenamePdf, $pdf->output());
                    $previewUrl = "http://localhost:8042/instances/{$instance['ID']}/preview";
                    $imageResponse = Http::get($previewUrl);
                    if ($imageResponse->successful()) {
                        $imageContent = $imageResponse->body();
                        $filenameImage = "{$instance['ID']}.jpg";
                        $relativePathImage = "dicom-jpg/{$filenameImage}";
                        Storage::disk('public')->put($relativePathImage, $imageContent);
                        $attachments[] = storage_path("app/public/{$relativePathImage}"); //jpg
                        $attachments[] = storage_path("app/public/{$filenamePdf}"); //pdf
                        Instance::create([
                            'patient_estudio_id' => $this->estudioId,
                            'instance_uid' => $instance['ID'],
                            'image_path' => $relativePathImage,
                        ]);
                        DB::commit();
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('Error al guardar el la BBDD: ' . $e->getMessage());
                    session()->flash('error', 'No se pudo enviar el correo. Por favor, inténtelo de nuevo o contacte al soporte si el problema persiste.');
                };
            }
        } else {
            foreach ($instances as $instance) {
                if ($instance->image_path) {
                    $fullPath = storage_path("app/public/dicom-jpg/{$instance->image_path}");
                    if (file_exists($fullPath)) {
                        $attachments[] = $fullPath;
                    }
                }
            }
            $attachments[] = storage_path("app/public/readings/{$this->estudioId}.pdf");
        }

        Mail::to($this->patientEmail)->send(new MailDeliveryEstudio(
            'Resultados de su examen',
            'Adjunto se envían resultados del examen. Favor no responder este correo',
            $attachments
        ));
        $this->dispatch('close-drawer-send-mail');
    }


    public function render()
    {
        return view('livewire.drawers.drawer-send-mail');
    }
}
