<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VotoPresidencial extends Model
{
    use HasFactory;

    protected $table = 'voto_presidencial';
    protected $primaryKey = 'id_voto';
    public $timestamps = false;
    protected $fillable = ['id_persona', 'id_candidato', 'id_departamento', 'tiempo'];
    protected $casts = [
        'id_candidato' => 'integer',
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona', 'id_persona');
    }

    public function candidato()
    {
        return $this->belongsTo(CandidatoPresidente::class, 'id_candidato', 'id_candidato');
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_departamento', 'id_departamento');
    }
}
