<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 24 Jul 2019 17:15:23 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ccmzon extends Eloquent
{
	protected $table = 'ccmzon';
	public $timestamps = false;

	protected $fillable = [
		'MCODZON',
		'MCODRVE'
	];
}
