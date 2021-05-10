<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 09 Jun 2019 23:02:06 +0000.
 */

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
