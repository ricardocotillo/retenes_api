<?php

namespace App\Http\Controllers\API;

use App\Models\Ccmcli;
use App\Models\Ccmzon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CcmcliController extends Controller
{
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Ccmcli::all();
        foreach ($clientes as $cliente) {
            $ccmzon = Ccmzon::where('MCODZON', $cliente['MCODZON'])->first();
            $cliente['MCODRVE'] = $ccmzon['MCODRVE'];
        }
        return response()->json($clientes, $this-> successStatus);
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
     * @param  \App\Models\Ccmcli  $ccmcli
     * @return \Illuminate\Http\Response
     */
    public function show(Ccmcli $ccmcli)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ccmcli  $ccmcli
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ccmcli $ccmcli)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ccmcli  $ccmcli
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ccmcli $ccmcli)
    {
        //
    }
}
