<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

trait HandlesWlFiles 
{
    // Función que genera un UID DICOM
    protected function generateDicomUid()
    {
        // Se utiliza un prefijo fijo y un timestamp microsegundo para unicidad
        return '1.2.826.0.1.3680043.10.100.' . Carbon::now()->format('YmdHisu') . '.' . bin2hex(random_bytes(5));
    }

    /**
     * Genera la Worklist física y la mueve a Orthanc.
     *
     * @param int $patient_id ID del paciente para el nombre del archivo.
     * @param string $wlText Contenido del Worklist en formato dump.
     * @param string $exportPath Directorio temporal para la generación (ej: C:\worklist_temp).
     * @throws \Exception Si dump2dcm falla o el archivo no se puede mover.
     */
    protected function HandlesWlFiles(int $patient_id, string $wlText, string $exportPath)
    {
        // Rutas de DCMTK y Orthanc leídas de la configuración
        $dump2dcmPath = config('worklist.dump2dcm_path');
        $orthancBasePath = rtrim(config('worklist.orthanc_path'), DIRECTORY_SEPARATOR);

        $timestamp = Carbon::now()->format('YmdHisu');
        $fileName = "{$patient_id}_{$timestamp}";

        // Rutas temporales
        $tempTxtPath = $exportPath . DIRECTORY_SEPARATOR . $fileName . '.txt';
        $wlPath = $exportPath . DIRECTORY_SEPARATOR . $fileName . '.wl';

        // 1. REFUERZO DE LA VERIFICACIÓN DEL DIRECTORIO (Fix de Windows)
        if (!File::isDirectory($exportPath)) {
            Log::warning("Directorio de exportación no encontrado por Laravel: Intentando crear '{$exportPath}'");
            // Intentar crear la carpeta de forma recursiva y con permisos 0755
            if (!File::makeDirectory($exportPath, 0755, true)) { 
                throw new \Exception("Error: El directorio de exportación no existe y NO SE PUDO CREAR en: {$exportPath}. Verifique permisos de disco.");
            }
        }
        
        // 1.5. *CRÍTICO para Windows/DCMTK*: Forzar siempre Unix line endings (\n)
        $wlText = str_replace(["\r\n", "\r"], "\n", $wlText);

        // 2. Escribimos el archivo TXT temporal
        if (!File::put($tempTxtPath, $wlText)) {
            Log::error("No se pudo escribir el archivo temporal TXT en: {$tempTxtPath}");
            throw new \Exception("Error al generar archivo temporal TXT.");
        }

        // 3. Ejecutar el comando DCMTK para convertir de TXT a DICOM Worklist (.wl)
        // $command = "\"{$dump2dcmPath}\" +w \"{$tempTxtPath}\" \"{$wlPath}\"";
        $command = "$dump2dcmPath $tempTxtPath $wlPath";

        exec($command, $output, $returnCode);

        if ($returnCode !== 0 || !File::exists($wlPath)) {
            Log::error("dump2dcm falló para Patient ID: {$patient_id}", [
                'Output' => $output,
                'ReturnCode' => $returnCode,
                'Command' => $command,
            ]);
            // Limpiamos el archivo de texto antes de lanzar la excepción
            File::delete($tempTxtPath); 
            throw new \Exception("dump2dcm falló (Code: {$returnCode}). Detalles:\n" . implode("\n", $output));
        }

        // 4. Mover el archivo al destino final de Orthanc
        $orthancFileName = basename($wlPath);
        $orthancFinalPath = $orthancBasePath . DIRECTORY_SEPARATOR . $orthancFileName;

        // Usamos File::move() para robustez
        if (!File::move($wlPath, $orthancFinalPath)) {
            Log::error("No se pudo mover el archivo Worklist a la ruta de Orthanc: {$orthancFinalPath}");
            File::delete($wlPath); // Limpiar el .wl que se generó si falla el movimiento
            throw new \Exception("Error al mover el archivo Worklist a destino final.");
        }
        // 5. Limpiar el archivo temporal de texto
        File::delete($tempTxtPath);
    }
}