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
		'mcla_prod',
		'type',
	];

	public function famdfa()
	{
		return $this->belongsTo(Famdfa::class, 'mcoddfa', 'MCODDFA');
	}
}
