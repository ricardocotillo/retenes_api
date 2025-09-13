<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ccmdoc extends Model
{
	protected $table = 'ccmdoc';
	public $timestamps = false;

	protected $casts = [
		'MNCOPIAS' => 'float',
		'MFECUACT' => 'datetime'
	];


	protected $fillable = [
		'MTIPODOC',
		'MDESCRIP',
		'MABREVI',
		'MIND_S_R',
		'MINDDOC',
		'MDESTINO',
		'MCODSUNAT',
		'MINDAPRO',
		'MCODSID',
		'MCODSPA',
		'MCODUSER',
		'MFECUACT',
		'MHORUACT',
		'MNCOPIAS'
	];
}
