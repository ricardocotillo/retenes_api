<?php

namespace App\Http\Controllers\API;

use App\Models\Detpe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DetpeController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\Detpe  $detpe
     * @return \Illuminate\Http\Response
     */
    public function show($mnserie, $mnroped)
    {
        $dets = Detpe::where('MNSERIE', $mnserie)->where('MNROPED', $mnroped)->get();
        return response()->json($dets, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Detpe  $detpe
     * @return \Illuminate\Http\Response
     */
    public function edit(Detpe $detpe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Detpe  $detpe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Detpe $detpe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Detpe  $detpe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Detpe $detpe)
    {
        //
    }
}
