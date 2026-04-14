<?php

namespace App\Http\Controllers\API;

use App\Models\Ccmcpa;
use App\Models\ContadoFamdfa;
use App\Models\Famdfa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CcmcpaController extends Controller
{
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $formas_pago = Ccmcpa::all();
        return response()->json($formas_pago, $this-> successStatus);
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
     * @param  \App\Models\Ccmcpa  $ccmcpa
     * @return \Illuminate\Http\Response
     */
    public function show($tipo)
    {
        $ccmcpa = Ccmcpa::where('MINDCRED', '1')->get();
        return response()->json($ccmcpa, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ccmcpa  $ccmcpa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'mcodcadi' => ['required'],
            'list' => ['required', 'array'],
        ]);

        $cambios = [];

        $contDfa = ContadoFamdfa::where('mcodcadi', $data['mcodcadi'])->first();
        if (!$contDfa) {
            return response()->json([
                'message' => 'No mapping found for mcodcadi',
                'mcodcadi' => $data['mcodcadi'],
            ], 404);
        }

        $contado = Famdfa::where('MCODDFA', $contDfa->mcoddfa)->first();
        if (!$contado) {
            return response()->json([
                'message' => 'No Famdfa record found for contado mapping',
                'mcoddfa' => $contDfa->mcoddfa,
            ], 404);
        }

        $cambios['sin'] = $contado;
        $cambios['cambios'] = [];

        foreach ($data['list'] as $key => $val) {
            if ($val != NULL) {
                $fam = Famdfa::where('MCODDFA', $val)->first();
                if (!$fam || !$contado->MDESCRIP || !$fam->MDESCRIP) {
                    continue;
                }

                $cont = Famdfa::where('MDESCRIP', substr($contado->MDESCRIP, 0, -1).'+'.$fam->MDESCRIP)->first();
                if (!$cont) {
                    continue;
                }

                $cont['antiguo'] = $val;
                array_push($cambios['cambios'], $cont);
            }
        }

        return response()->json($cambios, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ccmcpa  $ccmcpa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ccmcpa $ccmcpa)
    {
        //
    }
}
