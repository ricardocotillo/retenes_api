<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 26 Jul 2019 00:00:20 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ccmtrs extends Model
{
	protected $table = 'CCMTRS';
	protected $primaryKey = 'MCODTRSP';
	public $incrementing = false;
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
