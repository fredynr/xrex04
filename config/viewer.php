<?php
return [
    'type' => env('DICOM_VIEWER', 'osimis'),
    'base_url' => env('VIEWER_BASE_URL', 'http://localhost:8042/osimis-viewer/app/index.html'),
];