<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcesoVotacion extends Model
{
    protected $table = 'proceso_votacion';
    protected $primaryKey = 'id_proceso';
    public $timestamps = true;
    protected $fillable = ['etapa','modificado_por'];

    // Define the relationship with the Usuario model (optional)
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'modificado_por', 'id_usuario');
    }
}
