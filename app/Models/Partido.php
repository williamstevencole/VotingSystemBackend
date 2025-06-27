<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partido extends Model
{
    use HasFactory;

    protected $table = 'partidos';
    protected $primaryKey = 'id_partido';
    public $timestamps = false;
    protected $fillable = ['nombre'];

    public function movimientos()
    {
        return $this->hasMany(Movimiento::class, 'id_partido', 'id_partido');
    }

    public function candidatosPresidente()
    {
        return $this->hasMany(CandidatoPresidente::class, 'id_partido', 'id_partido');
    }

    public function candidatosDiputado()
    {
        return $this->hasMany(CandidatoDiputado::class, 'id_partido', 'id_partido');
    }

    public function candidatosAlcalde()
    {
        return $this->hasMany(CandidatoAlcalde::class, 'id_partido', 'id_partido');
    }
}
