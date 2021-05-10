<?php

namespace App\Http\Controllers\API;

use App\Models\Ccmtrs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CcmtrsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trs = Ccmtrs::all();
        return response()->json($trs, 200);
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
     * @param  \App\Models\Ccmtrs  $ccmtrs
     * @return \Illuminate\Http\Response
     */
    public function show(Ccmtrs $ccmtrs)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ccmtrs  $ccmtrs
     * @return \Illuminate\Http\Response
     */
    public function edit(Ccmtrs $ccmtrs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ccmtrs  $ccmtrs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ccmtrs $ccmtrs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ccmtrs  $ccmtrs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ccmtrs $ccmtrs)
    {
        //
    }
}
