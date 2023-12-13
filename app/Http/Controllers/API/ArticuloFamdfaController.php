<?php

namespace App\Http\Controllers\API;

use App\Models\ArticuloFamdfa;
use App\Models\Famdfa;
use App\Models\Ccmcli;
use App\Models\Ccmzon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticuloFamdfaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {   
        $artdfas = ArticuloFamdfa::where([
            ['impneto_min', '=', NULL],
            ['impneto_max', '=', NULL],
            ['mcodart', '=', $req['mcodart']]
        ])->orWhere([
            ['impneto_min', '=', NULL],
            ['impneto_max', '=', NULL],
            ['mcodart', '=', '']
        ])->orWhere([
            ['impneto_min', '=', NULL],
            ['impneto_max', '=', NULL],
            ['mcodart', '=', NULL]
        ])->get();
        foreach ($artdfas as $ndfa) {
            $dfa = Famdfa::where('MCODDFA', $ndfa['mcoddfa'])->first();
            $ndfa['descuento'] = $dfa;
        }
        return response()->json($artdfas, 200);
    }
    
    public function descuento_general(Request $request, string $mcodven) {
        $impneto = $request->input('impneto');
        $mcodcadi = $request->input('mcodcadi');
        $mcondpago = $request->input('mcondpago');
        $mcodcli = $request->input('mcodcli');
        $artdfas = null;

        if ($mcodven == 'all') {
            $type = $mcodven;
            $artdfas = ArticuloFamdfa::where('tipo', $type)->get();
        } else {
            $type = $mcodven[strlen($mcodven) - 1];
            $type = is_numeric($type) ? null : $type;
        }
        $artdfas = ArticuloFamdfa::where(function($q) use ($mcodcadi) {
            $q->where('MCODCADI', $mcodcadi)->orWhere('MCODCADI', NULL);
        })
        ->where('MCONDPAGO', $mcondpago)
        ->where('impneto_min', '<=', $impneto)
        ->where('tipo', $type)
        ->where(function($q) use ($mcodcli) {
            $q->where('MCODCLI', $mcodcli)->orWhere('MCODCLI', NULL);
        })->get();

        foreach ($artdfas as $ndfa) {
            $dfa = Famdfa::where('MCODDFA', $ndfa['mcoddfa'])->first();
            $ndfa['descuento'] = $dfa;
        }
        return response()->json($artdfas, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ArticuloFamdfa  $articuloFamdfa
     * @return \Illuminate\Http\Response
     */
    public function show(ArticuloFamdfa $articuloFamdfa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ArticuloFamdfa  $articuloFamdfa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ArticuloFamdfa $articuloFamdfa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ArticuloFamdfa  $articuloFamdfa
     * @return \Illuminate\Http\Response
     */
    public function destroy(ArticuloFamdfa $articuloFamdfa)
    {
        //
    }
}
