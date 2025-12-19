<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RifaGanadores extends Model
{
    use HasFactory;
    protected $table = 'rifa_ganadores';
    public $timestamps = false;
}
