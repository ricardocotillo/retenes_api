<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLogPedidoRequest;
use App\Http\Requests\UpdateLogPedidoRequest;
use App\Models\LogPedido;

class LogPedidoController extends Controller
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
     * @param  \App\Http\Requests\StoreLogPedidoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLogPedidoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LogPedido  $logPedido
     * @return \Illuminate\Http\Response
     */
    public function show(LogPedido $logPedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLogPedidoRequest  $request
     * @param  \App\Models\LogPedido  $logPedido
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLogPedidoRequest $request, LogPedido $logPedido)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LogPedido  $logPedido
     * @return \Illuminate\Http\Response
     */
    public function destroy(LogPedido $logPedido)
    {
        //
    }
}
