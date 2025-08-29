<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientEstudio extends Model
{
    /** @use HasFactory<\Database\Factories\PatientEstudioFactory> */
    use HasFactory;
    protected $casts = [
    'date_audio' => 'datetime',
    'date_transcriber' => 'datetime'
];


    protected $fillable = [
        'study_name',
        'tech_description',
        'study_id_orthanc',
        'reading',
        'study_state',
        'priority',
        'reason_for_return',
        'exam_id',
        'patient_id',
        'user_id',
        'specialist_user_id',
        'transcriber_user_id',
        'study_parent_id',
        'date_audio',
        'date_transcriber'
    ];

    //Relación uno a uno con Exam
    public function exam(){
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    //Relacion uno a uno con Patient
    public function patient(){
        return $this->belongsTo('App\Models\Patient');
    }

    //Relación uno a uno con User
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    //Relación uno a uno specialist_user_id con user
    public function specialistUser(){
        return $this->belongsTo(User::class, 'specialist_user_id');
    }

    //Relacion uno a uno digitaizer_user_id con user
    public function digitaizerUser(){
        return $this->belongsTo(User::class, 'digitaizer_user_id');
    }

    //Relación uno a uno con eps_sender
    public function epsSender(){
        return $this->belongsTo(EpsSender::class, 'eps_sender_id');
    }

    // Relacion de autoreferencia para estudios devueltos
    // Estudio anterior (si fue devuelto)
    public function parentEstudio()
    {
        return $this->belongsTo(PatientEstudio::class, 'estudio_parent_id');
    }

    // Reestudios generados desde uno devuelto
    public function childEstudios()
    {
        return $this->hasMany(PatientEstudio::class, 'estudio_parent_id');
    }
}
