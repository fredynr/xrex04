<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\PatientEstudio;
use App\Models\User;

class ReportesController extends Controller
{
    public function index()
    {
        $inicioMes = Carbon::now()->startOfMonth()->toDateString();
        $finMes = Carbon::now()->endOfMonth()->toDateString();

        $estudios_filtrados =  PatientEstudio::query()

            // selectRaw es una funcion de Eloquent que permite inyectar directamente coódigo SQL puro en la clausula SELECT de la consulta,
            // lo cual es útil para usar funciones de MySql como DATE() y COUNT() y fecha_corta es solo un alias que se le asigna a la columna date_transcriber
            // DATE() quita la hora para que solo quede la fecha
            ->selectRaw('DATE(date_transcriber) as fecha_corta, count(*) as cantidad')
            ->whereHas('user', function ($query) {
                $query->where('role', 'Transcriptor');
            })
            ->whereBetween('date_transcriber', [$inicioMes, $finMes])
            ->groupBy('fecha_corta')
            ->orderBy('fecha_corta')
            ->get();
        $total_estudios_transcritos = $estudios_filtrados->sum('cantidad');
        $data = [
            'labels' => $estudios_filtrados->pluck('fecha_corta')->toArray(),
            'valores' => $estudios_filtrados->pluck('cantidad')->toArray(),
            'total_estudios' => $total_estudios_transcritos,
        ];

        // por eps

        $estudios_eps = PatientEstudio::query()
            ->whereBetween('date_finalized', [$inicioMes, $finMes])
            ->join('exams', 'patient_estudios.exam_id', '=', 'exams.id')
            ->join('eps_senders', 'exams.eps_sender_id', '=', 'eps_senders.id')
            ->select('eps_senders.name')
            ->selectRaw('count(patient_estudios.id) as cantidad')
            ->groupBy('eps_senders.name')
            ->get();
        $total_estudios_eps = $estudios_eps->sum('cantidad');
        $dataEps = [
            'labels' => $estudios_eps->pluck('name')->toArray(),
            'valores' => $estudios_eps->pluck('cantidad')->toArray(),
            'total_estudios' => $total_estudios_eps,
        ];


        $estudiosXspecialist = User::query()
            ->where('role', 'Especialista')
            ->withCount([
                'patientEstudios as cantidad_estudios' => function ($query) use ($inicioMes, $finMes) {
                    $query->whereBetween('date_finalized', [$inicioMes, $finMes]);
                }
            ])
            ->whereHas('patientEstudios', function ($query) use ($inicioMes, $finMes) {
                $query->whereBetween('date_finalized', [$inicioMes, $finMes]);
            })
            ->orderByDesc('cantidad_estudios')
            ->get();

            $estudiosXtranscriptor = User::query()
            ->where('role', 'Transcriptor')
            ->withCount([
                'transcriberEstudios as cantidad_estudios' => function ($query) use ($inicioMes, $finMes) {
                    $query->whereBetween('date_transcriber', [$inicioMes, $finMes]);
                }
            ])
            ->whereHas('transcriberEstudios',function ($query) use ($inicioMes, $finMes){
                $query->whereBetween('date_transcriber', [$inicioMes, $finMes]);
            })
            ->orderByDesc('cantidad_estudios')
            ->get();

        return view('reportes', compact('data', 'dataEps', 'estudiosXspecialist', 'estudiosXtranscriptor'));
    }
}
