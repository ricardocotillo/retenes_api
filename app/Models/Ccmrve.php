<?php

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
