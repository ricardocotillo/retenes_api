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
    private function has_restricted_item_discount($mcodcli)
    {
        return ArticuloFamdfa::where('MCODCLI', $mcodcli)
            ->where('restrict', true)
            ->where([
                ['impneto_min', '=', null],
                ['impneto_max', '=', null],
            ])->exists();
    }

    private function has_restricted_general_discount($mcodcli)
    {
        return ArticuloFamdfa::where('MCODCLI', $mcodcli)
            ->where('restrict', true)
            ->where(function ($query) {
                $query->where('impneto_min', '!=', null)
                    ->orWhere('impneto_max', '!=', null);
            })
            ->exists();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $mcodart = $data['mcodart'];
        $mcodcli = $data['mcodcli'];
        // $mcla_prod = $data['mcla_prod'];
        $discount_by_mcodcli = $this->has_restricted_item_discount($mcodcli);
        $query = ArticuloFamdfa::with(['famdfa', 'tiposDeDescuento'])
            ->where('impneto_min', null)
            ->where('impneto_max', null)
            ->where(function ($query) use ($mcodart) {
                $query->where('mcodart', $mcodart)
                    ->orWhere('mcodart', '')
                    ->orWhereNull('mcodart');
            });

        if ($discount_by_mcodcli) {
            $query->where('restrict', true);
        }

        $artdfas = $query->get();

        return response()->json($artdfas, 200);
    }

    /**
     * Get general discounts based on various criteria.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function descuento_general(Request $request, string $code) {
        $request->validate([
            'impneto' => 'nullable|numeric',
            'mcodcli' => 'required|string',
            'mindcred' => 'nullable|string',
        ]);

        $impneto = $request->input('impneto', 0);
        $mcodcadi = $request->input('mcodcadi');
        $mcondpago = $request->input('mcondpago');
        $mcodcli = $request->input('mcodcli');
        $mindcred = $request->input('mindcred');
        $mcla_prods = $request->input('mcla_prods');
        $mcla_prods_arr = $mcla_prods ? array_filter(array_map('trim', explode(',', $mcla_prods))) : [];
        $mcodzon = $request->input('mcodzon');
        $mcodven = $request->input('mcodven');

        if ($code == 'all') {
            $type = $code;
        } else {
            $type = $code[strlen($code) - 1];
            $type = is_numeric($type) ? null : $type;
        }

        $discount_by_mcodcli = $this->has_restricted_general_discount($mcodcli);

        $query = ArticuloFamdfa::with(['famdfa', 'tiposDeDescuento'])
            ->where(function ($q) use ($mcodcadi) {
                $q->where('MCODCADI', $mcodcadi)->orWhereNull('MCODCADI');
            })
            ->where(function ($q) use ($mcondpago) {
                $q->where('MCONDPAGO', $mcondpago)->orWhereNull('MCONDPAGO');
            })
            ->where('impneto_min', '<=', $impneto)
            ->where('tipo', $type)
            ->where('mindcred', $mindcred)
            // mcodzon or null
            ->where(function ($q) use ($mcodzon) {
                $q->where('MCODZON', $mcodzon)->orWhereNull('MCODZON');
            })
            ->where(function ($q) use ($mcodven) {
                $q->where('MCODVEN', $mcodven)->orWhereNull('MCODVEN');
            });

        if (!empty($mcla_prods_arr)) {
            $query = $query->whereHas('tiposDeDescuento', function ($q) use ($mcla_prods_arr) {
                $q->whereIn('mcla_prod', $mcla_prods_arr);
            }, '=', count($mcla_prods_arr));
        }

        if ($discount_by_mcodcli) {
            $query = $query->where('MCODCLI', $mcodcli)->where('restrict', true);
        } else {
            $query = $query->where(function ($q) use ($mcodcli) {
                $q->where('MCODCLI', $mcodcli)->orWhereNull('MCODCLI');
            });
        }

        $artdfas = $query->get();

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
