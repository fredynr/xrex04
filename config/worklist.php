<?php

return [
    'eat' => env('RIS_AET_EAT', 'DEFAULT_AET'), 
    'export_path' => env('RIS_WORKLIST_EXPORT_PATH', '/tmp/worklist'),
    'orthanc_path' => env('RIS_ORTHANC_WORKLIST_PATH', '/tmp/orthanc'),
    'dump2dcm_path' => env('RIS_DCMTK_DUMP2DCM_PATH', '/usr/bin/dump2dcm'),
];
