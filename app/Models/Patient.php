<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class Patient extends Authenticatable
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
        'password'
    ];
    protected $hidden = ['password'];
    public function getAuthPassword()
    {
        return $this->password;
    }

    protected $appends = ['age'];

    protected function getAgeAttribute()
    {
        if ($this->birth) {
            return Carbon::parse($this->birth)->age;
        }
        return null;
    }
    use HasFactory;

    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    //Relación uno a muchos con Exam
    public function exams()
    {
        return $this->hasMany('App\Models\Exam');
    }

    //Relación uno a muchos con patientEstudios
    public function patientEstudios()
    {
        return $this->hasMany('App\Models\PatientEstudio');
    }
}
