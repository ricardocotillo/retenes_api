<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 24 Jul 2019 17:15:57 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ccmrve extends Model
{
	protected $table = 'ccmrve';
	public $timestamps = false;

	protected $fillable = [
		'MCODRVE',
		'MDESCRIP'
	];
}
