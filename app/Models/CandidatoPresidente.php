<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatoPresidente extends Model
{
    use HasFactory;

    protected $table = 'candidato_presidentes';
    protected $primaryKey = 'id_candidato';
    public $timestamps = false;
    protected $fillable = ['id_partido', 'id_movimiento', 'nombre', 'foto_url'];

    public function partido()
    {
        return $this->belongsTo(Partido::class, 'id_partido', 'id_partido');
    }

    public function movimiento()
    {
        return $this->belongsTo(Movimiento::class, 'id_movimiento', 'id_movimiento');
    }

    public function votos()
    {
        return $this->hasMany(VotoPresidencial::class, 'id_candidato', 'id_candidato');
    }
}

