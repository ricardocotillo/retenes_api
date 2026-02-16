<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cabpe extends Model
{
	protected $table = 'cabpe';
	public $timestamps = false;

	protected $casts = [
		'MTOPVENTA' => 'float',
		'MVALVEN' => 'float',
		'MDCTO' => 'float',
		'MIGV' => 'float',
		'MNETO' => 'float',
		'MSALDO' => 'float',
		'MPORIGV' => 'float',
		'MPESOKG' => 'float',
		'MVV_NAFE' => 'float',
		'MFECEMI' => 'datetime',
		'MFECENT' => 'datetime',
		'MFECVEN' => 'datetime',
		'MFECCAN' => 'datetime',
		'MFECATT' => 'datetime',
		'MFECANU' => 'datetime',
		'MFECLIB' => 'datetime',
		'MFECUACT' => 'datetime'
	];


	protected $fillable = [
		'MTIPODOC',
		'MNSERIE',
		'MNROPED',
		'MCODTPED',
		'MFECEMI',
		'MPERIODO',
		'MCODCLI',
		'MCODCPA',
		'MCODVEN',
		'MCODZON',
		'MCODTIEN',
		'MCODMON',
		'MDOLINT',
		'MFECENT',
		'MLUGENT',
		'MLOCALID',
		'MDETALLE',
		'MCODEMI',
		'MEMITIDO',
		'MTOPVENTA',
		'MVALVEN',
		'MDCTO',
		'MIGV',
		'MNETO',
		'MSALDO',
		'MPORIGV',
		'MFECVEN',
		'MFECCAN',
		'MCODCRES',
		'MSTATUS',
		'MINDORIG',
		'MIND_N_I',
		'MINDAPROB',
		'MINDIMP',
		'MTIPITEM',
		'MINC_IGV',
		'MANO_E',
		'MMES_E',
		'MDIA_E',
		'MFECATT',
		'MFECANU',
		'MATEND',
		'MNORDCLI',
		'MAMD',
		'MINDFACT',
		'MCODLPRE',
		'MNOMCLI',
		'MLUGFAC',
		'MFECLIB',
		'MCODSITD',
		'MFECUACT',
		'MCODUSER',
		'MHORUACT',
		'MOBSERV',
		'MINDCOM',
		'MOBRA',
		'MPESOKG',
		'MCODDFA',
		'MDPSUNAT',
		'MDOCCLTE',
		'MCODRUV',
		'MVV_NAFE',
		'MCODCADI',
		'MCODSCADI',
		'MCTOUTIL',
		'MLIMAPROV',
		'estado',
		'MCODTRSP',
		'pedido_id',
	];

	protected $appends = [
		'modifications_left',
		'top_venta',
		'dcto',
		'neto',
		'igv',
		'valven',
		'precio_neto',
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
					// 'user_id' 		=> $user->id,
					'user_id' 		=> 1,
					'mnserie' 		=> $item->MNSERIE,
					'mnroped'		=> $item->MNROPED,
					'description' 	=> $description,
				]);
			}
		});
    }

	public function detpe() {
		return $this->hasMany(Detpe::class);
	}

	public function modifications() {
		return $this->hasOne(CabpeModification::class, 'mnroped', 'MNROPED');
	}

	public function ccmcpa() {
		return $this->belongsTo(Ccmcpa::class, 'MCODCPA', 'MCONDPAGO');
	}

	public function ccmcli() {
		return $this->belongsTo(Ccmcli::class, 'MCODCLI', 'MCODCLI');
	}

	public function ccmtrs() {
		return $this->belongsTo(Ccmtrs::class, 'MCODTRSP', 'MCODTRSP');
	}

	public function values() {
		return $this->hasMany(Value::class, 'mnroped', 'MNROPED');
	}

	public function instalments() {
		return $this->hasMany(Instalment::class, 'mnroped', 'MNROPED');
	}

	public function getTopVentaAttribute() {
		$mtopventa = 0;
        foreach ($this->detpe as $det) {
            if ($det->MCODDFA == 'Bono') {
                continue;
            } else {
                $mtopventa = $mtopventa + $det->precio;
            }
        }
        return $mtopventa;
	}

	public function getDctoAttribute() {
        $mdcto = 0;
        foreach ($this->detpe as $det) {
            if ($det->MCODDFA != 'Sin descuento' && $det->MCODDFA != 'Bono') {
                $mdcto = $mdcto + $det->descuento;
            }
        }
        return $mdcto;
	}

	public function getNetoAttribute() {
		return $this->top_venta - $this->dcto;
	}

	public function getIgvAttribute() {
		return $this->neto - ($this->neto / 1.18);
	}

	public function getValvenAttribute() {
		return $this->top_venta - $this->igv;
	}

	public function getModificationsLeftAttribute() {
		$max_mod = Setting::first()->cabpe_modifications;
		$mod = CabpeModification::firstOrCreate(
			['mnroped' => $this->MNROPED],
			['mnserie' => $this->MNSERIE],
		);
        return $max_mod - $mod->modifications;
    }

	public function totalByState(string $state) {
		if ($state == 'parcial') {
			$detpes = $this->detpe()->where('item_state', $state)->get();
			$sum = 0;
			foreach ($detpes as $detpe) {
				$partial = ($detpe->partial * $detpe->precio_neto) / $detpe->MCANTIDAD;
				$sum = $sum + $partial;
			}
			return $sum;
		}
		if ($state == 'anulado') {
			$detpes = $this->detpe()->where('item_state', 'parcial')->get();
			$sum = 0;
			foreach ($detpes as $detpe) {
				$not_attended_partial = (($detpe->MCANTIDAD - $detpe->partial) * $detpe->precio_neto) / $detpe->MCANTIDAD;
				$sum = $sum + $not_attended_partial;
			}
			return $this->detpe()->where('item_state', $state)->get()->pluck('precio_neto')->sum() + $sum;
		}
		return $this->detpe()->where('item_state', $state)->get()->pluck('precio_neto')->sum();
	}

	public function getPrecioNetoAttribute() {
		$price = $this->detpe->pluck('precio_neto');
		$price = $price->sum();
		return $price;
	}
}