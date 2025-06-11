<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    use HasFactory;

    protected $table = 'municipios';
    protected $primaryKey = 'id_municipio';
    public $timestamps = false;
    protected $fillable = ['id_departamento', 'nombre'];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_departamento', 'id_departamento');
    }

    public function personas()
    {
        return $this->hasMany(Persona::class, 'id_municipio', 'id_municipio');
    }

    public function candidatosAlcalde()
    {
        return $this->hasMany(CandidatoAlcalde::class, 'id_municipio', 'id_municipio');
    }

    public function votosAlcaldes()
    {
        return $this->hasMany(VotoAlcalde::class, 'id_municipio', 'id_municipio');
    }
}
