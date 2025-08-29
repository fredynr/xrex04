<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Patient extends Model
{
    /** @use HasFactory<\Database\Factories\PatientFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'sexo',
        'document',
        'type_document',
        'direction',
        'phone',
        'birth',
        'email',
    ];
     protected $appends = ['age'];

     protected function getAgeAttribute(){
        if($this->birth){
            return Carbon::parse($this->birth)->age;
        }
        return null;
     }
    use HasFactory;

    //Relación uno a muchos con Exam
    public function exams(){
        return $this->hasMany('App\Models\Exam');
    }

    //Relación uno a muchos con patientEstudios
    public function patientEstudios(){
        return $this->hasMany('App\Models\PatientEstudio');
    }
}
