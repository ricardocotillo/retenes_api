<?php

namespace App\Http\Controllers\API;

use App\Models\Ccmcli;
use App\Models\Ccmzon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CcmcliController extends Controller {
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $user = Auth::user();
        $q = $request->input('q', '');
        $clientes = $user->clientes();
        if ($clientes->count() <= 0) {
            $clientes = Ccmcli::whereNull('user_id');
        }
        if ($q) {
            $clientes = $clientes->where(function($query) use ($q) {
                $query->where('MCODCLI', 'ilike', '%'.$q.'%')
                      ->orWhere('MNOMBRE', 'ilike', '%'.$q.'%');
            })->cursorPaginate(15);
        } else {
            $clientes = $clientes->cursorPaginate(15);
        }
        foreach ($clientes as $cliente) {
            $ccmzon = Ccmzon::where('MCODZON', $cliente['MCODZON'])->first();
            $cliente['MCODRVE'] = isset($ccmzon['MCODRVE']) ? $ccmzon['MCODRVE'] : null;
        }
        return response()->json($clientes, $this->successStatus);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $data = $request->all();
        $ccmcli = Ccmcli::where('MCODCLI', '=', $data['MCODCLI'])->first();
        if ($ccmcli) {
            return response()->json(['error' => 'Cliente ya existe'], 400);
        }
        $ccmcli = Ccmcli::create($data);
        return response()->json($ccmcli, $this->successStatus);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ccmcli  $ccmcli
     * @return \Illuminate\Http\Response
     */
    public function show(Ccmcli $ccmcli) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ccmcli  $ccmcli
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ccmcli $ccmcli) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ccmcli  $ccmcli
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ccmcli $ccmcli) {
        //
    }
}
