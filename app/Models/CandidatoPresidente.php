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
    protected $fillable = ['id_partido', 'nombre', 'foto'];

    public function partido()
    {
        return $this->belongsTo(Partido::class, 'id_partido', 'id_partido');
    }

    public function votos()
    {
        return $this->hasMany(VotoPresidencial::class, 'id_candidato', 'id_candidato');
    }
}

