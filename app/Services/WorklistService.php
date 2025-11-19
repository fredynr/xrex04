<?php

namespace App\Services;

use App\Models\ListEstudio;
use App\Models\PatientEstudio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WorklistService
{
    /**
     * Genera la Worklist y crea el registro de estudio en la BD.
     *
     * @param int $procedureId El ID del procedimiento (ListEstudio).
     * @param int $examId El ID del examen.
     * @param object $patientData Objeto con datos del paciente (name, document, id).
     * @param string $scheduledDate Fecha programada.
     * @param string $scheduledTime Hora programada.
     * @param string $accessionNumber Número de acceso.
     * @param callable $generateWlTextCallback Función para generar el texto del Worklist (solo texto).
     * @param callable $generateWorklistFileCallback Función que crea/guarda el archivo físico.
     * @return PatientEstudio|null Retorna la instancia del estudio creado o null en caso de error.
     */
    public function generateWorklistAndStudy(
        $procedureId,
        $examId,
        $patientData,
        $scheduledDate,
        $scheduledTime,
        $accessionNumber,
        $generateWlTextCallback,
        $generateWorklistFileCallback // Callback que solo genera el archivo
    ) {
        try {
            // Nota: Aquí deberías inyectar o resolver ListEstudio y PatientEstudio
            $estudioList = ListEstudio::find($procedureId);
            if (!$estudioList) {
                Log::error("WorklistService: No se encontró el estudio con ID: {$procedureId}.");
                return null;
            }

            // OBTENEMOS LAS VARIABLES DE CONFIGURACIÓN
            $eat = config('worklist.eat'); 
            $exportPath = config('worklist.export_path'); // Usamos la nueva variable

            // 1. Generar el texto del Worklist (usa el callback pasado por el componente)
            $wlText = $generateWlTextCallback(
                $eat, 
                $patientData->document,
                $patientData->name,
                $scheduledDate,
                $scheduledTime,
                $estudioList->name,
                $accessionNumber
            );
            
            // 2. Generar y guardar el archivo Worklist usando la ruta global.
            // El callback ahora DEBE recibir la ruta donde guardar.
            $generateWorklistFileCallback($patientData->document, $wlText, $exportPath); 

            // 3. Crear el registro en la BD
            $estudio = PatientEstudio::create([
                'study_name' => $estudioList->name,
                'accession_number' => $accessionNumber,
                'study_state' => 'Solicitado',
                'list_estudio_id' => $estudioList->id,
                'exam_id' => $examId,
                'patient_id' => $patientData->id, 
                'user_id' => Auth::id(),
            ]);

            return $estudio;

        } catch (\Throwable $e) {
            Log::error("Error en WorklistService al generar Worklist: " . $e->getMessage(), ['exception' => $e]);
            return null;
        }
    }
}