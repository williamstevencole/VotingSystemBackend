<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatoDiputado extends Model
{
    use HasFactory;

    protected $table = 'candidato_diputados';
    protected $primaryKey = 'id_candidato';
    public $timestamps = false;
    protected $fillable = ['id_partido', 'id_departamento', 'nombre', 'foto'];

    public function partido()
    {
        return $this->belongsTo(Partido::class, 'id_partido', 'id_partido');
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_departamento', 'id_departamento');
    }

    public function votos()
    {
        return $this->hasMany(VotoDiputado::class, 'id_candidato', 'id_candidato');
    }
}