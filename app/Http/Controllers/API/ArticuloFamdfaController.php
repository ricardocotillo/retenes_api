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
        ->where(function($query) {
            $query->where('impneto_min', '!=', null)
            ->orWhere('impneto_max', '!=', null);
        })
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
        $mcla_prod = $data['mcla_prod'];
        $discount_by_mcodcli = $this->has_restricted_item_discount($mcodcli);
        $query = ArticuloFamdfa::with('famdfa')
            ->where('impneto_min', null)
            ->where('impneto_max', null)
            ->where(function ($query) use ($mcodart) {
                $query->where('mcodart', $mcodart)
                    ->orWhere('mcodart', '')
                    ->orWhereNull('mcodart');
            })
            ->where('mcla_prod', $mcla_prod);

        if ($discount_by_mcodcli) {
            $query->where('restrict', true);
        }

        $artdfas = $query->get();

        return response()->json($artdfas, 200);
    }
    
    public function descuento_general(Request $request, string $mcodven) {
        $impneto = $request->input('impneto');
        $mcodcadi = $request->input('mcodcadi');
        $mcondpago = $request->input('mcondpago');
        $mcodcli = $request->input('mcodcli');
        $mincred = $request->input('mincred');
        $artdfas = null;
        
        // $has_item_discount = $this->has_restricted_item_discount($mcodcli);
        // if ($has_item_discount) {
        //     return response()->json([], 200);
        // }

        if ($mcodven == 'all') {
            $type = $mcodven;
        } else {
            $type = $mcodven[strlen($mcodven) - 1];
            $type = is_numeric($type) ? null : $type;
        }

        $discount_by_mcodcli = $this->has_restricted_general_discount($mcodcli);

        if ($discount_by_mcodcli) {
            $artdfas = ArticuloFamdfa::where(function($q) use ($mcodcadi) {
                $q->where('MCODCADI', $mcodcadi)->orWhere('MCODCADI', NULL);
            })
            ->where('MCONDPAGO', $mcondpago)
            ->where('impneto_min', '<=', $impneto)
            ->where('tipo', $type)
            ->where('MCODCLI', $mcodcli)
            ->where('mincred', $mincred)
            ->where('restrict', true)
            ->get();
        } else {
            $artdfas = ArticuloFamdfa::where(function($q) use ($mcodcadi) {
                $q->where('MCODCADI', $mcodcadi)->orWhere('MCODCADI', NULL);
            })
            ->where('MCONDPAGO', $mcondpago)
            ->where('impneto_min', '<=', $impneto)
            ->where('tipo', $type)
            ->where(function($q) use ($mcodcli) {
                $q->where('MCODCLI', $mcodcli)->orWhere('MCODCLI', NULL);
            })
            ->where('mincred', $mincred)
            ->get();
        }

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
