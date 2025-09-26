<?php

namespace App\Livewire\Views;

use Livewire\Component;
use Illuminate\Support\Facades\File;


class ViewApprove extends Component
{
    public string $patient_name = '';
    public string $patient_id = '';
    public string $procedure = '';
    public string $scheduled_date = '';
    public string $scheduled_time = '';

    public function generateDicomUid(): string
    {
        $root = '1.2.826.0.1.3680043.10.100'; // Raíz privada segura
        $timestamp = date('YmdHis'); // Fecha y hora
        $random = bin2hex(random_bytes(6)); // 12 dígitos hex aleatorios

        return "{$root}.{$timestamp}.{$random}";
    }


    public function generateWorklist()
    {
        $this->validate([
            'patient_name' => 'required|string',
            'patient_id' => 'required|string',
            'procedure' => 'required|string',
            'scheduled_date' => 'required|date',
            'scheduled_time' => 'required',
        ]);

        $uid = $this->generateDicomUid(); // UID único por estudio
        $spsId = 'SPS_' . $this->patient_id;
        $procedureId = 'PROC_' . $this->patient_id;
        $aet = 'MODALITY_AET';

        $wlText = <<<EOT
(0008,0016) UI [1.2.840.10008.5.1.4.31]
(0008,0018) UI [{$uid}]
(0010,0010) PN [{$this->patient_name}]
(0010,0020) LO [{$this->patient_id}]
(0040,0100) SQ
  (fffe,e000) na
    (0008,0060) CS [CT]
    (0040,0001) AE [{$aet}]
    (0040,0002) DA [{$this->scheduled_date}]
    (0040,0003) TM [{$this->scheduled_time}]
    (0040,0006) PN [{$this->patient_name}]
    (0040,0009) SH [{$spsId}]
    (0040,1001) SH [{$procedureId}]
    (0040,1002) LO [{$this->procedure}]
    (0040,1003) SH [Routine]
  (fffe,e00d) na
(fffe,e0dd) na
EOT;

        $txtPath = storage_path("app/worklists/{$this->patient_id}.txt");
        File::ensureDirectoryExists(dirname($txtPath));
        File::put($txtPath, $wlText);

        $wlPath = storage_path("app/worklists/{$this->patient_id}.wl");
        $dump2dcmPath = 'C:\\DCMTK\\bin\\dump2dcm.exe';

        exec("\"{$dump2dcmPath}\" {$txtPath} {$wlPath} --write-dataset", $output, $returnCode);

        if ($returnCode !== 0 || !file_exists($wlPath)) {
            throw new \Exception("dump2dcm falló o no generó el archivo .wl. Detalles:\n" . implode("\n", $output));
        }

        $orthancPath = 'C:\\OrthancWorklist\\' . basename($wlPath);
        rename($wlPath, $orthancPath);

        session()->flash('success', 'Worklist generado y enviado a Orthanc');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.views.view-approve');
    }
}
