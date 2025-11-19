<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    /** @use HasFactory<\Database\Factories\ExamFactory> */
    use HasFactory;

    protected $fillable = [
        'remision',
        'patient_id',
        'eps_sender_id',
        'user_id',
        'departure_place_id',
        'study_qty',
        'exam_state'
    ];

    //Relación  con Patient
    public function patient(){
        return $this->belongsTo('App\Models\Patient');
        // return $this->belongsTo(Patient::class, 'patient_id');
    }

    //Relación uno a muchos con PatientEstudio
    public function patientEstudios(){
        return $this->hasMany('App\Models\PatientEstudio');
    }

    //Relación uno a uno con EpsSender
    public function epsSender(){
        return $this->belongsTo('App\Models\EpsSender');
    }

    //Relación con DeparturePlace
    public function departurePlace(){
        return $this->belongsTo(DeparturePlace::class, 'departure_place_id');
    }
}
