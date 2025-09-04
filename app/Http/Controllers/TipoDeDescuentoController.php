<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTipoDeDescuentoRequest;
use App\Http\Requests\UpdateTipoDeDescuentoRequest;
use App\Models\TipoDeDescuento;

class TipoDeDescuentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTipoDeDescuentoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTipoDeDescuentoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TipoDeDescuento  $tipoDeDescuento
     * @return \Illuminate\Http\Response
     */
    public function show(TipoDeDescuento $tipoDeDescuento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTipoDeDescuentoRequest  $request
     * @param  \App\Models\TipoDeDescuento  $tipoDeDescuento
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTipoDeDescuentoRequest $request, TipoDeDescuento $tipoDeDescuento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TipoDeDescuento  $tipoDeDescuento
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoDeDescuento $tipoDeDescuento)
    {
        //
    }
}
