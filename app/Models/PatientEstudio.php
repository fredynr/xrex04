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


    protected $guarded = [];

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

    // Relación uno a uno con ListEstudio
    public function listEstudio(){
        return $this->belongsTo(ListEstudio::class, 'list_estudio_id');
    }

    //Relación uno a uno specialist_user_id con user
    public function specialistUser(){
        return $this->belongsTo(User::class, 'specialist_user_id');
    }

    //Relacion uno a uno transcriberUser con user
    public function transcriberUser(){
        return $this->belongsTo(User::class, 'transcriber_user_id');
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
