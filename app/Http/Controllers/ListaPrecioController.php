<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreListaPrecioRequest;
use App\Http\Requests\UpdateListaPrecioRequest;
use App\Models\ListaPrecio;

class ListaPrecioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $request = request()->all();
        $mcodcli = $request['mcodcli'];
        $mindcred = $request['mindcred'];
        $mcondpago = $request['mcondpago'];
        $impneto = $request['impneto'];
        $mcodcli = $request['mcodcli'];
        $mcodzon = $request['mcodzon'];

        $listas = ListaPrecio::query()
            ->where(function ($query) use ($mcodcli) {
                $query->where('mcodcli', $mcodcli)->orWhereNull('mcodcli');
            })
            ->where(function ($query) use ($mindcred) {
                $query->where('mindcred', $mindcred)->orWhereNull('mindcred');
            })
            ->where(function ($query) use ($mcondpago) {
                $query->where('mcondpago', $mcondpago)->orWhereNull('mcondpago');
            })
            ->where(function ($query) use ($impneto) {
                $query->where('impneto_min', '<=', $impneto)->orWhereNull('impneto_min');
            })
            ->where(function ($query) use ($impneto) {
                $query->where('impneto_max', '>=', $impneto)->orWhereNull('impneto_max');
            })
            ->where(function ($query) use ($mcodzon) {
                $query->where('mcodzon', $mcodzon)->orWhereNull('mcodzon');
            })
            ->get();

        return response()->json($listas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreListaPrecioRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ListaPrecio $listaPrecio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateListaPrecioRequest $request, ListaPrecio $listaPrecio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ListaPrecio $listaPrecio)
    {
        //
    }
}
