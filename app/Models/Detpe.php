<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\LogPedido;

class Detpe extends Model {
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
		'MPORDCT5' => 'float',
		'MFECUACT' => 'datetime',
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
		'item_state',
		'status_changed',
		'mcla_prod',
	];

	protected $appends = [
		'precio',
		'precio_neto',
		'descrip',
	];

	public static function booted() {
        parent::boot();
		
		static::saving(function($item) {
			$orginal = $item->getRawOriginal();
			$changed = [];
			$user = auth()->user();
			foreach ($orginal as $key => $value) {
				if ($item->{$key} != $value) {
					array_push($changed, $key.': '.$value.' a '.$item->{$key});
				}
			}
			if (count($changed) > 0) {
				$description = implode(', ', $changed);
				LogPedido::create([
					'user_id' 		=> $user->id,
					'mnserie' 		=> $item->MNSERIE,
					'mnroped'		=> $item->MNROPED,
					'mitem'			=> $item->MITEM,
					'description' 	=> $description,
				]);
			}
		});

		static::deleting(function($item) {
			$user = auth()->user();
			LogPedido::create([
				'user_id' 		=> $user->id,
				'mnserie'		=> $item->MNSERIE,
				'mnroped'		=> $item->MNROPED,
				'mitem'			=> $item->MITEM,
				'description'	=> 'Detpe eliminado'
			]);
		});
    }

	public function cabpe()
	{
		return $this->belongsTo(Cabpe::class);
	}

	public function famdfa()
	{
		return $this->belongsTo(Famdfa::class, 'MCODDFA', 'MCODDFA');
	}

	public function articulo()
	{
		return $this->belongsTo(Articulo::class, 'MCODART', 'MCODART');
	}

	public function famdfas()
	{
		return $this->belongsToMany(Famdfa::class, 'detpe_famdfa')
			->withPivot(['type', 'detpe_id', 'famdfa_id', 'id', 'order', 'mcla_prod'])
			->orderBy('order');
	}

	public function scopeNotBono($query)
	{
		return $query->where('MCODDFA', '!=', 'Bono');
	}

	public function getPrecioAttribute()
	{
		return $this->MCODDFA != 'Bono' ? $this->MCANTIDAD * $this->MPRECIO : 0;
	}

	public function getPrecioNetoAttribute()
	{
		$famdfas = $this->famdfas;
		$price = $this->precio;
		foreach ($famdfas as $f) {
			$price -= $price * ($f->MPOR_DFA / 100);
		}
		return $price;
	}

	public function getDescripAttribute()
	{
		$display = '';
		$famdfas = $this->famdfas()->get();
		$mdescrip = $famdfas->pluck('MDESCRIP');
		$mdescrip = $mdescrip->map(function ($m, $k) {
			return str_replace('%', '', trim($m));
		});
		$mdescrip = $mdescrip->implode('+') . '%';
		return $mdescrip;
	}
}
