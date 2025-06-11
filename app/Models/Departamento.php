<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Municipio;

class Departamento extends Model
{
    use HasFactory;

    protected $table = 'departamentos';
    protected $primaryKey = 'id_departamento';
    public $timestamps = false;
    protected $fillable = ['nombre'];

    public function municipios()
    {
        return $this->hasMany(Municipio::class, 'id_departamento', 'id_departamento');
    }

    public function candidatosDiputado()
    {
        return $this->hasMany(CandidatoDiputado::class, 'id_departamento', 'id_departamento');
    }

    public function votosPresidenciales()
    {
        return $this->hasMany(VotoPresidencial::class, 'id_departamento', 'id_departamento');
    }

    public function votosDiputados()
    {
        return $this->hasMany(VotoDiputado::class, 'id_departamento', 'id_departamento');
    }
}
