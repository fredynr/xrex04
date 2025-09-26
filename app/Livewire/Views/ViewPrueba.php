<?php

namespace App\Livewire\Views;

use Livewire\Component;
use App\Models\PatientEstudio;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Http;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;

function generate_dicom_uid()
{
    return '1.2.826.0.1.3680043.10.101.' . str_replace('.', '', microtime(true)) . mt_rand(1000, 9999);
}

class ViewPrueba extends Component
{
    public $search = '';
    public $startDate;
    public $endDate;
    public $totalEstudios;
    public $currentTable = "tables.table-pendings-to-read";
    protected $listeners = ["navigateTableSpecialist"];
    public function navigateTableSpecialist($table)
    {
        $this->currentTable = $table;
    }

    #[On('refresh-header')]
    public function refreshHeader()
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




    private function generateDicomUid(): string
    {
        $root = '1.2.826.0.1.3680043.10.101';
        return $root . '.' . str_replace('-', '', Uuid::uuid4());
    }

    public function sendWorklistToOrthanc()
    {
        $orthancApiUrl = 'http://localhost:8042/tools/create-dicom';
        $orthancUser = 'admin';
        $orthancPassword = 'S3gur1dad180#';

        $studyInstanceUid = $this->generateDicomUid();

        $patientData = [
            '0010,0010' => [
                'vr' => 'PN',
                'Value' => 'Doe^John', // Ahora es un string simple
            ],
            '0010,0020' => [
                'vr' => 'LO',
                'Value' => 'P0001', // Ahora es un string simple
            ],
            '0020,000D' => [
                'vr' => 'UI',
                'Value' => $studyInstanceUid, // Ahora es un string simple
            ],
        ];

        try {
            $response = Http::withBasicAuth($orthancUser, $orthancPassword)
                ->post($orthancApiUrl, $patientData);

            if ($response->successful()) {
                return response()->json([
                    'message' => 'Datos de Worklist enviados a Orthanc correctamente.',
                    'dicom_instance_id' => $response->json()['ID']
                ], 200);
            } else {
                return response()->json([
                    'error' => 'Error al enviar datos a Orthanc. Código: ' . $response->status(),
                    'response_body' => $response->body()
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error de conexión con Orthanc: ' . $e->getMessage()], 500);
        }
    }









    public function sendPatientDataToOrthanc()
    {
        $data = [
            "0010,0010" => ["vr" => "PN", "Value" => ["Perez^Juan"]],
            "0010,0020" => ["vr" => "LO", "Value" => ["12345"]],
            "0010,0030" => ["vr" => "DA", "Value" => ["19800101"]],
            "0010,0040" => ["vr" => "CS", "Value" => ["M"]],
            "0008,0050" => ["vr" => "SH", "Value" => ["RAD-00123"]],
            "0008,1030" => ["vr" => "LO", "Value" => ["Tomografía de tórax"]],
            "0040,0100" => ["vr" => "SQ", "Value" => [[
                "0040,0002" => ["vr" => "DA", "Value" => [now()->format('Ymd')]],
                "0040,0003" => ["vr" => "TM", "Value" => [now()->format('His')]]
            ]]]
        ];

        $response = Http::withBasicAuth('admin', 'S3gur1dad180#')
            ->post('http://localhost:8042/worklists', $data);

        if ($response->successful()) {
            dd("Worklist creada con éxito: " . $response->body());
        } else {
            dd("Error: " . $response->status() . " - " . $response->body());
        }
    }











    public function render()
    {
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
        $this->totalEstudios = $totalRealizado + $totalCorreccion;

        return view('livewire.views.view-prueba', [
            'totalCorrected' => $totalCorreccion,
            'countNormal' => $priorityCounts['Normal'] ?? 0,
            'countBaja' => $priorityCounts['Baja'] ?? 0,
            'countAlta' => $priorityCounts['Alta'] ?? 0,
        ]);
    }
}
