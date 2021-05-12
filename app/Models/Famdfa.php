<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
