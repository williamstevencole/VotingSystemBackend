<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatoAlcalde extends Model
{
    use HasFactory;

    protected $table = 'candidato_alcaldes';
    protected $primaryKey = 'id_candidato';
    public $timestamps = false;
    protected $fillable = ['id_partido', 'id_movimiento', 'id_municipio', 'nombre', 'foto_url'];

    public function partido()
    {
        return $this->belongsTo(Partido::class, 'id_partido', 'id_partido');
    }

    public function movimiento()
    {
        return $this->belongsTo(Movimiento::class, 'id_movimiento', 'id_movimiento');
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'id_municipio', 'id_municipio');
    }

    public function votos()
    {
        return $this->hasMany(VotoAlcalde::class, 'id_candidato', 'id_candidato');
    }
}
