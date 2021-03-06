<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detpe extends Model
{
	protected $table = 'detpe';
	public $timestamps = false;

	protected $casts = [
		'MCANTIDAD' => 'float',
		'MCANTPEN' => 'float',
		'MFACTOR' => 'float',
		'MIGV' => 'float',
		'MPORDCT1' => 'float',
		'MPORDCT2' => 'float',
		'MDCTOPRD' => 'float',
		'MDCTO' => 'float',
		'MPRECIO' => 'float',
		'MVALVEN' => 'float',
		'MCOSULCO' => 'float',
		'MPENFAC' => 'float',
		'MCANUND' => 'float',
		'MPESOKG' => 'float',
		'MPORDCT3' => 'float',
		'MPORDCT4' => 'float',
		'MPORDCT5' => 'float'
	];

	protected $dates = [
		'MFECUACT'
	];

	protected $fillable = [
		'MTIPODOC',
		'MNSERIE',
		'MNROPED',
		'MITEM',
		'MCODART',
		'MTDOCR',
		'MNSERIER',
		'MNROREQ',
		'MCANTIDAD',
		'MCANTPEN',
		'MUNIDAD',
		'MCODUMED',
		'MFACTOR',
		'MDESCRI01',
		'MIGV',
		'MPORDCT1',
		'MPORDCT2',
		'MDCTOPRD',
		'MDCTO',
		'MPRECIO',
		'MVALVEN',
		'MCOSULCO',
		'MCODSER',
		'MINDSER',
		'MSTATUS',
		'MINDORIG',
		'MAMD',
		'MAFE_IGV',
		'MOBSERV',
		'MINDOBSQ',
		'MITE_REL',
		'MART_REL',
		'MCODUSER',
		'MFECUACT',
		'MHORUACT',
		'MINDCOM',
		'MCODDFA',
		'MPENFAC',
		'MTDCTZ',
		'MNSCTZ',
		'MNROCTZ',
		'MITEMCTZ',
		'MCANUND',
		'MPESOKG',
		'MPORDCT3',
		'MPORDCT4',
		'MPORDCT5',
		'estado',
	];

	public function cabpe() {
		return $this->belongsTo(Cabpe::class);
	}

	public function famdfa() {
		return $this->belongsTo(Famdfa::class, 'MCODDFA', 'MCODDFA');
	}

	public function articulo() {
		return $this->belongsTo(Articulo::class, 'MCODART', 'MCODART');
	}

	public function scopeNotBono($query) {
		return $query->where('MCODDFA', '!=', 'Bono');
	}
}
