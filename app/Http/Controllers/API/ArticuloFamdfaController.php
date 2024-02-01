<?php

namespace App\Http\Controllers\API;

use App\Models\ArticuloFamdfa;
use App\Models\Famdfa;
use App\Models\Ccmcli;
use App\Models\Ccmzon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticuloFamdfaController extends Controller {
    private function has_restricted_item_discount($mcodcli) {
        return ArticuloFamdfa::where('MCODCLI', $mcodcli)
        ->where('restrict', true)
        ->where([
            ['impneto_min', '=', null],
            ['impneto_max', '=', null],
        ])->count();
    }
    private function has_restricted_general_discount($mcodcli) {
        return ArticuloFamdfa::where('MCODCLI', $mcodcli)
        ->where('restrict', true)
        ->where('impneto_min', '!=', null)
        ->orWhere('impneto_max', '!=', null)
        ->count();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $data = $request->all();
        $mcodart = $data['mcodart'];
        $mcodcli = $data['mcodcli'];
        $has_general_discount = $this->has_restricted_general_discount($mcodcli);
        $artdfas = null;
        if ($has_general_discount) {
            return response()->json([], 200);
        }

        $artdfas = ArticuloFamdfa::where([
            ['impneto_min', '=', NULL],
            ['impneto_max', '=', NULL],
            ['mcodart', '=', $mcodart]
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
        
        $has_item_discount = $this->has_restricted_item_discount($mcodcli);
        if ($has_item_discount) {
            return response()->json([], 200);
        }

        if ($mcodven == 'all') {
            $type = $mcodven;
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
