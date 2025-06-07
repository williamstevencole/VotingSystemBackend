<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $table = 'personas';
    protected $primaryKey = 'id_persona';
    public $timestamps = false;
    protected $fillable = ['nombre', 'no_identidad', 'id_municipio'];

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'id_municipio', 'id_municipio');
    }

    public function votosPresidenciales()
    {
        return $this->hasMany(VotoPresidencial::class, 'id_persona', 'id_persona');
    }

    public function votosDiputados()
    {
        return $this->hasMany(VotoDiputado::class, 'id_persona', 'id_persona');
    }

    public function votosAlcaldes()
    {
        return $this->hasMany(VotoAlcalde::class, 'id_persona', 'id_persona');
    }
}
