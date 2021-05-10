<?php

namespace App\Http\Controllers\API;

use App\Models\Ccmven;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CcmvenController extends Controller
{
    public $successStatus = 200;
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
     * @param  \App\Models\Ccmven  $ccmven
     * @return \Illuminate\Http\Response
     */
    public function show($nombre)
    {
        $codigos = Ccmven::where('MNOMBRE', '=', urldecode($nombre))->get();
        return response()->json($codigos, $this->successStatus);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ccmven  $ccmven
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ccmven $ccmven)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ccmven  $ccmven
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ccmven $ccmven)
    {
        //
    }
}
