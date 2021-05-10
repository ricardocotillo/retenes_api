<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 27 Jul 2019 03:33:09 +0000.
 */

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
