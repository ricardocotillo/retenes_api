<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ccmzon extends Model
{
	protected $table = 'ccmzon';
	public $timestamps = false;

	protected $fillable = [
		'MCODZON',
		'MCODRVE'
	];
}
