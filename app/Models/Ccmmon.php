<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ccmmon extends Model
{
	protected $table = 'ccmmon';
	public $timestamps = false;

	protected $dates = [
		'MFECUACT'
	];

	protected $fillable = [
		'MCODMON',
		'MDESCRIP',
		'MABREVI',
		'MCODPAI',
		'MSIMBOLO',
		'MDOLINT',
		'MCODTMS',
		'MCODUSER',
		'MFECUACT',
		'MHORUACT',
		'MSNT_TDM',
		'MLCODMON'
	];
}
