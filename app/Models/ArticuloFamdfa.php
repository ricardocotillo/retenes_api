<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticuloFamdfa extends Model
{
	protected $table = 'articulo_famdfa';
	public $timestamps = false;

	protected $fillable = [
		'mcodart',
		'mcoddfa'
	];
}
