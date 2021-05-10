<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 09 Jun 2019 23:02:06 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ccmsedo extends Model
{
	protected $table = 'ccmsedo';
	public $timestamps = false;

	protected $casts = [
		'MNUMDOC' => 'float',
		'MNLINEAS' => 'float'
	];

	protected $fillable = [
		'MTIPODOC',
		'MNSERIE',
		'MINDAUT',
		'MNUMDOC',
		'MNLINEAS',
		'MCODCOLA',
		'MTIPFOR',
		'MOFI_INT'
	];
}
