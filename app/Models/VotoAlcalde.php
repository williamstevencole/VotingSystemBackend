<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VotoAlcalde extends Model
{
    use HasFactory;

    protected $table = 'voto_alcalde';
    protected $primaryKey = 'id_voto';
    public $timestamps = false;
    protected $fillable = ['id_persona', 'id_candidato', 'id_municipio', 'tiempo'];
    protected $casts = [
        'id_candidato' => 'integer',
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona', 'id_persona');
    }

    public function candidato()
    {
        return $this->belongsTo(CandidatoAlcalde::class, 'id_candidato', 'id_candidato');
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'id_municipio', 'id_municipio');
    }
}
