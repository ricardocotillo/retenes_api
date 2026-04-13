<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDeDescuento extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'mcla_prod',
    ];

    public function articuloFamdfas()
    {
        return $this->belongsToMany(
            ArticuloFamdfa::class,
            'articulo_famdfa_tipo_de_descuento',
            'tipo_de_descuento_id',
            'articulo_famdfa_id'
        )->withTimestamps();
    }
}
