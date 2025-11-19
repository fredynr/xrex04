<?php

namespace App\Traits;

trait HandlesOrthancStudy
{
    public function StudyDataFromOrthanc($studyId)
    {
        $url = "http://localhost:8042/studies/$studyId";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->orthancAuthHeader());

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    public function extractStudyName($data)
    {
        return $data["MainDicomTags"]["StudyDescription"] ?? "El DICOM no tiene el nombre del estudio";
    }
}