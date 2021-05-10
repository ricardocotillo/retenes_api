<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 20 Jun 2019 19:21:03 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ArticuloFamdfa
 * 
 * @property int $id
 * @property string $mcodart
 * @property string $mcoddfa
 *
 * @package App\Models
 */
class ArticuloFamdfa extends Model
{
	protected $table = 'articulo_famdfa';
	public $timestamps = false;

	protected $fillable = [
		'mcodart',
		'mcoddfa'
	];
}
