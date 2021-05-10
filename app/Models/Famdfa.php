<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 09 Jun 2019 23:02:06 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

class Famdfa extends Model
{
	protected $table = 'famdfa';
	public $timestamps = false;

	protected $casts = [
		'MPOR_DFA' => 'float',
		'MIMP_DFA' => 'float'
	];

	protected $dates = [
		'MFECREG',
		'MFECUACT'
	];

	protected $fillable = [
		'MCODDFA',
		'MDESCRIP',
		'MABREVI',
		'MFOR_DFA',
		'MPOR_DFA',
		'MIMP_DFA',
		'MDESACT',
		'MFECREG',
		'MHORREG',
		'MCODUSER',
		'MFECUACT',
		'MHORUACT'
	];
}
