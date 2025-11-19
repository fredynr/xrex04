<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ListEstudio extends Model
{
    /** @use HasFactory<\Database\Factories\ListEstudioFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public function patientEstudios(): HasMany // Usamos HasMany importado
    {
        return $this->hasMany(PatientEstudio::class);
    }

    
}
