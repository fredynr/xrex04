<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientEstudioController;
use App\Http\Controllers\OrthancViewerController;

Route::get('/viewer/{studyId}', [OrthancViewerController::class, 'redirectToViewer'])
    ->middleware('auth')
    ->name('viewer.redirect');

Route::get('/viewer/{studyId}', [OrthancViewerController::class, 'redirectToViewer'])
    ->middleware('auth')
    ->name('viewer.redirect');


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('xrex', function () {
    return view('layouts/layout-tales');
})->name('xrex');

Route::get('pdfView/{estudioId}', [PatientEstudioController::class, 'pdfView'])->name('pdfView');
Route::get('downloadPdf/{estudioId}', [PatientEstudioController::class, 'downloadPdf'])->name('downloadPdf');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__ . '/auth.php';
