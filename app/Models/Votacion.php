<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Votacion extends Model
{
    use HasFactory;
    protected $table = 'votacion';
    public $timestamps = false;


    protected $fillable = [
        'posicion', 'nombre', 'descripcion', 'activo'
    ];

    public function votos()
    {
        return $this->hasMany(VotacionRegistro::class, 'id_votacion');
    }
}
