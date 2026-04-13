<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticuloFamdfa extends Model
{
	protected $table = 'articulo_famdfa';
	public $timestamps = false;

	protected $fillable = [
		'mcodart',
		'mcoddfa',
		'type',
	];

	public function famdfa()
	{
		return $this->belongsTo(Famdfa::class, 'mcoddfa', 'MCODDFA');
	}

    public function tiposDeDescuento()
    {
        return $this->belongsToMany(
            TipoDeDescuento::class,
            'articulo_famdfa_tipo_de_descuento',
            'articulo_famdfa_id',
            'tipo_de_descuento_id'
        )->withTimestamps();
    }
}
