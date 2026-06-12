<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEstadoRequest;
use App\Http\Requests\UpdateEstadoRequest;
use App\Models\Estado;

class EstadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Estado::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEstadoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Estado $estado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEstadoRequest $request, Estado $estado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estado $estado)
    {
        //
    }
}
