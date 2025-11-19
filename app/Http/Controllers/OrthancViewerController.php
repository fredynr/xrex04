<?php

namespace App\Http\Controllers;

use App\Services\ViewerService;
use Illuminate\Support\Facades\Http;


use Illuminate\Http\Request;

class OrthancViewerController extends Controller
{

    public function redirectToViewer($studyId, ViewerService $viewerService)
    {
        if (!$studyId || strlen($studyId) < 10) {
            abort(404, 'ID de estudio inválido');
        }

        $url = $viewerService->getViewerUrl($studyId);
        return redirect()->away($url);
    }
}
