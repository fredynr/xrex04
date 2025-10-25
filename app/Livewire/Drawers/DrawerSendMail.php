<?php

namespace App\Livewire\Drawers;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailDeliveryEstudio;
use App\Models\PatientEstudio;
use App\Models\Patient;

class DrawerSendMail extends Component
{
    public $patientEmail;
    public $patientName;
    public $estudioId;
    public $studyID;
    public $patientDocument;
    public $patientEmailUser;

    public function mount($patientEmail, $estudioId, $studyID, $patient_id)
    {
        $patient = Patient::find($patient_id);
        $this->patientEmailUser = $patient->email;
        $this->patientEmail = $patientEmail;
        $this->patientName = $patient->name;
        $this->estudioId = $estudioId;
        $this->studyID = $studyID;
        $this->patientDocument = $patient->document;
    }

    public function closeDrawer()
    {
        $this->dispatch('close-drawer-send-mail');
    }

    public function enviarMail()
    {
        $attachments = [];
        try {
            $desdePdf = true;
            $estudio = PatientEstudio::with(['patient', 'specialistUser', 'exam.departurePlace'])
                ->find($this->estudioId);
            $pdf = Pdf::loadView('pdfView', compact('estudio', 'desdePdf'))
                ->setPaper('letter', 'portrait');
            $filenamePdf = "readings/{$this->estudioId}.pdf";
            Storage::disk('public')->put($filenamePdf, $pdf->output());
            $attachments[] = storage_path("app/public/{$filenamePdf}");
            Mail::to($this->patientEmail)->send(new MailDeliveryEstudio(
                'Resultados de su examen',
                "Puedes ver los resultados de tu examen siguiendo este link <a href=\"xrex.site/login\">Ingreso</a><br>
    tu usuario es: {$this->patientEmailUser}<br>tu contraseña es: {$this->patientDocument}... Favor no responder este correo",
                $attachments
            ));
            session()->flash('success', 'El correo fue enviado con éxito.');
            $this->dispatch('close-drawer-send-mail');
        } catch (\Exception $e) {
            Log::error('Error en el proceso de envío de correo: ' . $e->getMessage());
            session()->flash('error', 'No se pudo enviar el correo. Por favor, inténtelo de nuevo o contacte al soporte si el problema persiste.');
        };
    }


    public function render()
    {
        return view('livewire.drawers.drawer-send-mail');
    }
}
