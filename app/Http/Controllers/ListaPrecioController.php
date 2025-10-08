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

        $listas = ListaPrecio::where('mcodcli', $mcodcli)
            ->where('mindcred', $mindcred)
            ->where('mcondpago', $mcondpago)
            ->where('impneto_min', '<=', $impneto)
            ->where('impneto_max', '>=', $impneto)
            ->where('mcodcli', $mcodcli)
            ->where('mcodzon', $mcodzon)
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
