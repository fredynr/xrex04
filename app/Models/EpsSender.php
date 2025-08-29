<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EpsSender extends Model
{
    /** @use HasFactory<\Database\Factories\EpsSenderFactory> */
    use HasFactory;

    public function patientEstudios(){
        return $this->hasMany('App\Models\PatientEstudio');
    }
}
