<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instance extends Model
{
    /** @use HasFactory<\Database\Factories\InstanceFactory> */
    use HasFactory;
    
    protected $fillable = [
        'patient_estudio_id',
        'instance_uid',
        'image_path',
        'pdf_path',
    ];
}
