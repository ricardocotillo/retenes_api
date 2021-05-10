<?php

namespace App\Http\Controllers\API;

use App\Models\Famdfa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FamdfaController extends Controller
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
     * @param  \App\Models\Famdfa  $famdfa
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Famdfa  $famdfa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Famdfa $famdfa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Famdfa  $famdfa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Famdfa $famdfa)
    {
        //
    }
}
