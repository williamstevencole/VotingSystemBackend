<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;

    protected $table = 'movimientos';
    protected $primaryKey = 'id_movimiento';
    protected $fillable = ['id_partido', 'nombre'];

    public function partido()
    {
        return $this->belongsTo(Partido::class, 'id_partido', 'id_partido');
    }

    public function candidatosPresidente()
    {
        return $this->hasMany(CandidatoPresidente::class, 'id_movimiento', 'id_movimiento');
    }

    public function candidatosDiputado()
    {
        return $this->hasMany(CandidatoDiputado::class, 'id_movimiento', 'id_movimiento');
    }

    public function candidatosAlcalde()
    {
        return $this->hasMany(CandidatoAlcalde::class, 'id_movimiento', 'id_movimiento');
    }
}
