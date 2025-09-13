<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ccmcpa extends Model
{
	protected $table = 'ccmcpa';
	public $timestamps = false;

	protected $casts = [
		'MNCUOTAS' => 'float',
		'MDIAS' => 'float',
		'MFECUACT' => 'datetime'
	];


	protected $fillable = [
		'MCONDPAGO',
		'MDESCRIP',
		'MABREVI',
		'MINDCRED',
		'MNCUOTAS',
		'MDIAS',
		'MTIPCRE',
		'MMF',
		'MCAN_AUT',
		'MCODUSER',
		'MFECUACT',
		'MHORUACT'
	];
}
