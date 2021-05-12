<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContadoFamdfa extends Model
{
	protected $table = 'contado_famdfa';
	public $timestamps = false;

	protected $fillable = [
		'mcoddfa'
	];
}
