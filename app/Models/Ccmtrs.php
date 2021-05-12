<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ccmtrs extends Model
{
	protected $table = 'ccmtrs';
	public $timestamps = false;

	protected $dates = [
		'MFCHREGIS',
		'MFECUACT'
	];

	protected $fillable = [
		'MNOMBRE',
		'MDIRECC',
		'MTELEF1',
		'MTELEF2',
		'MFAX',
		'MCODPAI',
		'MPERSONA',
		'MRUCTRSP',
		'MFCHREGIS',
		'MPLACA',
		'MCAPACI',
		'MCHOFER',
		'MCODUSER',
		'MFECUACT',
		'MHORUACT',
		'MCODCVE',
		'MCODUTR',
		'MLOCALID',
		'MINDACT'
	];
}
