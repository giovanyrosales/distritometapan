<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VotacionRegistro extends Model
{
    use HasFactory;
    protected $table = 'votacion_registro';
    public $timestamps = false;
}
