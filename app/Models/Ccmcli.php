<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ccmcli extends Model
{
	protected $table = 'ccmcli';
	public $timestamps = false;

	protected $casts = [
		'MVCAM_CR' => 'float',
		'MLIM_CR' => 'float',
		'MPORDCTO' => 'float',
		'MPORCOMI' => 'float',
		'MPORPERC' => 'float',
		'MPORVCAO' => 'float',
		'MPORVNAOH' => 'float'
	];

	protected $dates = [
		'MFCHREGIS',
		'MFCH_CR',
		'MFECUVTA',
		'MFECULCRE',
		'MFECUACT',
		'MFECALTA',
		'MFECBAJA'
	];

	protected $fillable = [
		'MCODCLI',
		'MNOMBRE',
		'MABREVI',
		'MDIRECC',
		'MLOCALID',
		'MCODPAI',
		'MCASPOS',
		'MUBIGEO',
		'MTELEF1',
		'MTELEF2',
		'MTELEX',
		'MFAX',
		'MPERSONA',
		'MCARGO',
		'MCODVEN',
		'MRUCCLTE',
		'MDOCIDEN',
		'MCODZON',
		'MCODRCLI',
		'MFCHREGIS',
		'MDIRDESP',
		'MINDCRED',
		'MMNDA_CR',
		'MVCAM_CR',
		'MLIM_CR',
		'MFCH_CR',
		'MIND_MOR',
		'MCONDPAGO',
		'MTIPOCLI',
		'MCTACTB',
		'MTIPANA',
		'MCTAANA',
		'MCALIFI',
		'MFECUVTA',
		'MFECULCRE',
		'MPORDCTO',
		'MPORCOMI',
		'MCODGRP',
		'MCORREO',
		'MINDVAR',
		'MOBSERV',
		'MCODLPRE',
		'MPATERNO',
		'MMATERNO',
		'MNOMBRE1',
		'MNOMBRE2',
		'MTPSUNAT',
		'MDPSUNAT',
		'MCODUSER',
		'MFECUACT',
		'MHORUACT',
		'MINDCOM',
		'MCERUS',
		'MAREAPER',
		'MNOMAVAL',
		'MDIRAVAL',
		'MLOCAVAL',
		'MTELAVAL',
		'MDOIAVAL',
		'MAGEPERC',
		'MAGERETE',
		'MDIRREF',
		'MCODRUV',
		'MDIAVIS',
		'MORDVIS',
		'MINDACT',
		'MINDPERC',
		'MPORPERC',
		'MFECALTA',
		'MFECBAJA',
		'MPORVCAO',
		'MPORVNAOH',
		'MCODCADI',
		'MCODSCADI',
		'MOBSERVA01'
	];
}
