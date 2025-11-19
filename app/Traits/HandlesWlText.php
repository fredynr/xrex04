<?php

namespace App\Traits;

trait HandlesWlText
{
    protected function generateDicomUid(): string
    {
        $root = '1.2.826.0.1.3680043.10.100'; // Raíz privada segura
        $timestamp = date('YmdHis'); // Fecha y hora
        $random = bin2hex(random_bytes(6)); // 12 dígitos hex aleatorios
        return "{$root}.{$timestamp}.{$random}";
    }

    public function generateWlText(string $aet, $patientID, $patientName, $scheduledDate, $scheduledTime, $procedure, string $accessionNumber)
    {
        $uid = $this->generateDicomUid();
        $studyInstanceUID = $this->generateDicomUid();
        $spsId = 'SPS_' . $patientID;
        $procedureId = 'PROC_' . $patientID;

        $patientNameSafe = $this->sanitizeDicomString($patientName);
        $procedureSafe = $this->sanitizeDicomString($procedure);

        $sequenceItem = 
        "(fffe,e000) na\n" .
        "(0008,0060) CS [CT]\n" .
        "(0040,0001) AE [{$aet}]\n" .
        "(0040,0002) DA [{$scheduledDate}]\n" .
        "(0040,0003) TM [{$scheduledTime}]\n" .
        "(0040,0006) PN [{$patientNameSafe}]\n" . // Usamos el nombre saneado
        "(0040,0009) SH [{$spsId}]\n" .
        "(0040,1001) SH [{$procedureId}]\n" .
        "(0040,1002) LO [{$procedureSafe}]\n" . // Usamos el procedimiento saneado
        "(0032,1060) SH [{$accessionNumber}]\n" .
        "(0040,1003) SH [Routine]\n" .
        "(fffe,e00d) na"; // Delimitador de Item

        $wlText = <<<EOT
(0008,0016) UI [1.2.840.10008.5.1.4.31]
(0008,0018) UI [{$uid}]
(0010,0010) PN [{$patientNameSafe}]
(0010,0020) LO [{$patientID}]
(0008,0050) SH [{$accessionNumber}]
(0020,000D) UI [{$studyInstanceUID}]
(0008,1030) LO [{$procedureSafe}]
(0040,0100) SQ
{$sequenceItem}
(fffe,e0dd) na
EOT;
    return trim($wlText);
}

    protected function sanitizeDicomString(string $string): string
{
    // 1. Mapa manual de caracteres problemáticos a sus equivalentes ASCII.
    $map = [
        'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
        'Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U',
        'ñ' => 'n', 'Ñ' => 'N',
        'ü' => 'u', 'Ü' => 'U',
        'ç' => 'c', 'Ç' => 'C',
    ];

    // Convertir a minúsculas y luego aplicar el mapa para asegurar todas las coincidencias.
    $string = strtr($string, $map);

    // 2. Eliminar caracteres que todavía puedan ser problemáticos.
    // Solo permitimos letras, números, espacios y los DICOM delimiters (=, ^, -).
    $string = preg_replace('/[^a-zA-Z0-9\s\-\=\^\.]/', '', $string);
    
    // 3. Reemplazar múltiples espacios con uno solo y eliminar espacios al inicio/fin.
    return trim(preg_replace('/\s+/', ' ', $string));
}
}






