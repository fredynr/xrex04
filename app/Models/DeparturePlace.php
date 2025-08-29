<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeparturePlace extends Model
{
    /** @use HasFactory<\Database\Factories\DeparturePlaceFactory> */
    use HasFactory;

    //Relación uno a muchos con Exam
    public function exams()
    {
        return $this->hasMany(Exam::class, 'departure_place_id');
    }
}
