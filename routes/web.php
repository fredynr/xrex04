<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientEstudioController;
use App\Http\Controllers\OrthancViewerController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('patient-dashboard', 'layouts/layout-patient')
    ->middleware('auth:patient')
    ->name('patient.dashboard');

Route::middleware(['multiguard'])->group(function () {
    Route::get('pdfView/{estudioId}', [PatientEstudioController::class, 'pdfView'])->name('pdfView');
    Route::get('downloadPdf/{estudioId}', [PatientEstudioController::class, 'downloadPdf'])->name('downloadPdf');
    Route::get('/viewer/{studyId}', [OrthancViewerController::class, 'redirectToviewer'])->name('viewer.redirect');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('xrex', 'layouts/layout-tales')->middleware('auth')->name('xrex');
});

require __DIR__ . '/auth.php';
