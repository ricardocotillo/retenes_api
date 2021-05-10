<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 09 Jun 2019 23:02:06 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ccmven extends Model
{
	protected $table = 'ccmven';
	public $timestamps = false;

	protected $casts = [
		'MPORCEN' => 'float'
	];

	protected $dates = [
		'MFECUACT'
	];

	protected $fillable = [
		'MCODVEN',
		'MNOMBRE',
		'MDIRECC',
		'MDOCIDEN',
		'MPORCEN',
		'MTIPVEN',
		'MCODGVE',
		'MCODJVE',
		'MFCACOMI',
		'MINDCOM',
		'MINDVEND',
		'MSITUAC',
		'MCODUSER',
		'MFECUACT',
		'MHORUACT',
		'MCLAVE'
	];
}
