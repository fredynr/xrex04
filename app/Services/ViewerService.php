<?php
namespace App\Services;

class ViewerService
{
    public function getViewerUrl(string $studyId): string
    {
        $type = config('viewer.type');
        $baseUrl = config('viewer.base_url');

        switch ($type) {
            case 'osimis':
                return "{$baseUrl}?study={$studyId}";
            case 'ohif':
                return "{$baseUrl}?StudyInstanceUID={$studyId}";
            case 'weasis':
                return "{$baseUrl}?weasis={$studyId}";
            default:
                throw new \Exception("Visor DICOM no soportado: {$type}");
        }
    }
}