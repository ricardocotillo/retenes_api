<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaPrecio extends Model
{
    /** @use HasFactory<\Database\Factories\ListaPrecioFactory> */
    use HasFactory;

    protected $casts = [
		'impneto_min' => 'float',
		'impneto_max' => 'float',
	];
}
