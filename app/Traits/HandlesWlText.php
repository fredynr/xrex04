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

    public function generateWlText(string $aet, $patientID, $patientName, $scheduledDate, $scheduledTime, $procedure)
    {
        $uid = $this->generateDicomUid();
        $spsId = 'SPS_' . $patientID;
        $procedureId = 'PROC_' . $patientID;
        $wlText = <<<EOT
(0008,0016) UI [1.2.840.10008.5.1.4.31]
(0008,0018) UI [{$uid}]
(0010,0010) PN [{$patientName}]
(0010,0020) LO [{$patientID}]
(0040,0100) SQ
(fffe,e000) na
(0008,0060) CS [CT]
(0040,0001) AE [{$aet}]
(0040,0002) DA [{$scheduledDate}]
(0040,0003) TM [{$scheduledTime}]
(0040,0006) PN [{$patientName}]
(0040,0009) SH [{$spsId}]
(0040,1001) SH [{$procedureId}]
(0040,1002) LO [{$procedure}]
(0040,1003) SH [Routine]
(fffe,e00d) na
(fffe,e0dd) na
EOT;
return $wlText;
    }
}
