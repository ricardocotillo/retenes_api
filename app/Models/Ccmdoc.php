<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 09 Jun 2019 23:02:06 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ccmdoc extends Model
{
	protected $table = 'ccmdoc';
	public $timestamps = false;

	protected $casts = [
		'MNCOPIAS' => 'float'
	];

	protected $dates = [
		'MFECUACT'
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
