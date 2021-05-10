<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 09 Jun 2019 23:02:06 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ccmcpa extends Model
{
	protected $table = 'ccmcpa';
	public $timestamps = false;

	protected $casts = [
		'MNCUOTAS' => 'float',
		'MDIAS' => 'float'
	];

	protected $dates = [
		'MFECUACT'
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
