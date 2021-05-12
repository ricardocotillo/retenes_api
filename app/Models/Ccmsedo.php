<?php

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
