<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

trait HandlesWlFiles
{
    protected function generateAndMoveWorklist(int $patientId, string $wlText)
    {
        $timestamp = Carbon::now()->format('YmdHisu');
        $fileName = "{$patientId}_{$timestamp}";
        $txtPath = storage_path("app/worklists/$fileName.txt");
        $wlPath = storage_path("app/worklists/$fileName.wl");
        File::ensureDirectoryExists(dirname($txtPath));
        File::put($txtPath, $wlText);

        $dump2dcmPath = 'C:\\DCMTK\\bin\\dump2dcm.exe';

        exec("\"{$dump2dcmPath}\" {$txtPath} {$wlPath} --write-dataset", $output, $returnCode);

        if ($returnCode !== 0 || !file_exists($wlPath)) {
            Log::error("dump2dcm falló para Patient ID: $fileName", [
                'Output' => $output,
                'ReturnCode' => $returnCode,
            ]);
            throw new \Exception("dump2dcm falló o no generó el archivo .wl. Detalles:\n" . implode("\n", $output));
        }

        $orthancPath = 'C:\\OrthancWorklist\\' . basename($wlPath);
        rename($wlPath, $orthancPath);

        session()->flash('success', 'Worklist generado y enviado a Orthanc con exito');
        $this->reset();
    }
}
