<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Convenios extends Model {
    use HasFactory;

    protected $table = 'convenios';

    public $timestamps = false;

    protected $fillable = [
        'conv_nombre',
        'conv_descripcion',
        'conv_nombre_archivo',
        'conv_ruta_archivo',
        'conv_creado',
        'conv_actualizado',
        'conv_vigente',
        'conv_rut_mod',
        'conv_rol_mod'
    ];
}
