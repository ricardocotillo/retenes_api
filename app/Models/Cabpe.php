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
		'MVV_NAFE' => 'float'
	];

	protected $dates = [
		'MFECEMI',
		'MFECENT',
		'MFECVEN',
		'MFECCAN',
		'MFECATT',
		'MFECANU',
		'MFECLIB',
		'MFECUACT'
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
	];

	public function detpe() {
		return $this->hasMany(Detpe::class);
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
}
