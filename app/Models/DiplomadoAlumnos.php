<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiplomadoAlumnos extends Model
{
    use HasFactory;
    protected $table = 'diplomado_alumnos';
    public $timestamps = false;

    protected $fillable = [
        'curso_id', 'certificado_id', 'fecha', 'codigo_verificacion', 'nombre', 'curso', 'certificado'
    ];
}
