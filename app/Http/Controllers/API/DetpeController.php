<?php

namespace App\Http\Controllers\API;

use App\Models\Cabpe;
use App\Models\Detpe;
use App\Models\Articulo;
use App\Models\Famdfa;
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, string $mnserie, string $mnroped)
    {
        $igv = 1.18;

        $pedido = $request->all();

        $articulo = Articulo::firstWhere('MCODART', $pedido['mcodart']);
        $famdfa = Famdfa::firstWhere('MCODDFA', $pedido['mcoddfa']);

        $mprecio = $pedido['precio'];
        $mpordct1 = $famdfa ? $famdfa['MPOR_DFA'] : 0.000;
        $mvalven = round($mprecio * $pedido['cantidad'], 2);
        $mdcto = round($mvalven * ($mpordct1 / 100), 2);
        $migv = round(($mvalven - $mdcto) - (($mvalven - $mdcto) / $igv), 2);

        $last_detpe = Detpe::where('MNSERIE', $mnserie)->where('MNROPED', $mnroped)->orderBy('MITEM', 'desc')->first();
        $mitem = (int) $last_detpe->MITEM + 1;
        $detped_data = array(
            'MTIPODOC' => 'C',
            'MNSERIE' => $mnserie,
            'MNROPED' => $mnroped,
            'MITEM' => (string) $mitem,
            'MCODART' => $pedido['mcodart'],
            'MCANTIDAD' => $pedido['cantidad'],
            'MCANTPEN' => $pedido['cantidad'],
            'MUNIDAD' => $pedido['munidad'],
            'MCODUMED' => 22,
            'MFACTOR' => $articulo->MUNDENV1,
            'MDESCRI01' => $articulo->MDESCRIP,
            'MPORDCT1' => $mpordct1,
            'MPORDCT2' => 0.0,
            'MDCTOPRD' => $mdcto,
            'MDCTO' => $mdcto,
            'MPRECIO' => $mprecio,
            'MVALVEN' => $mvalven,
            'MIGV' => $migv,
            'MCOSULCO' => 0.00,
            'MINDORIG' => 1,
            'MAMD' => date('Ymd'),
            'MAFE_IGV' => 'S',
            'MINDOBSQ' => $pedido['mcoddfa'] == 'Bono' ? 'D' : 'N',
            'MCODUSER' => '600000000000001',
            'MFECUACT' => date('Y-m-d'),
            'MHORUACT' => date('h:i:s'),
            'MPENFAC' => $pedido['cantidad'],
            'MCODDFA' => $pedido['mcoddfa'],
        );

        $detpe = new Detpe($detped_data);

        $cabpe = Cabpe::where('MNROPED', $mnroped)->where('MNSERIE', $mnserie)->where('MCODVEN', $pedido['mcodven'])->first();

        $cabpe->detpe()->save($detpe);

        $mtopventa = 0;
        $mdcto = 0;
        foreach ($cabpe->detpe as $det) {
            if ($det->MCODDFA == 'Bono') {
                continue;
            } else {
                $mtopventa = $mtopventa + ($det->MCANTIDAD * $det->MPRECIO);
            }
            if ($det->MCODDFA != 'Sin descuento' && $det->MCODDFA != 'Bono') {
                $mdcto = $mdcto + ($det->MCANTIDAD * $det->MPRECIO * ($det->famdfa->MPOR_DFA / 100));
            }
        }
        $mneto = $mtopventa - $mdcto;
        $migv =  $mneto - ($mneto / 1.18);
        $mvalven = $mtopventa - $migv;

        $new_cabpe = [
            'MTOPVENTA' => round($mtopventa, 2),
            'MDCTO' => round($mdcto, 2),
            'MIGV' => round($migv, 2),
            'MNETO' => round($mneto, 2),
            'MSALDO' => round($mneto, 2),
            'MVALVEN' => round($mvalven, 2),
        ];

        $cabpe->fill($new_cabpe);
        $cabpe->save();

        return response()->json($detpe, 200);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Detpe  $detpe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $detpe_id)
    {
        $igv = 1.18;

        $new_detpe = $request->all();
        $famdfa = Famdfa::firstWhere('MCODDFA', $new_detpe['MCODDFA']);

        $mprecio = $new_detpe['MPRECIO'];
        $mpordct1 = $famdfa ? $famdfa['MPOR_DFA'] : 0.000;
        $mvalven = round($mprecio * $new_detpe['MCANTIDAD'], 2);
        $mdcto = round($mvalven * ($mpordct1 / 100), 2);
        $migv = round(($mvalven - $mdcto) - (($mvalven - $mdcto) / $igv), 2);

        $new_detpe['MPORDCT1'] = $mpordct1;
        $new_detpe['MVALVEN'] = $mvalven;
        $new_detpe['MDCTO'] = $mdcto;
        $new_detpe['MIGV'] = $migv;
        $new_detpe['MINDOBSQ'] = $new_detpe['MCODDFA'] == 'Bono' ? 'D' : 'N';
        $new_detpe['estado'] = 'modificado';


        $detpe = Detpe::find($detpe_id);
        $detpe->fill($new_detpe);
        $detpe->save();


        $cabpe = $detpe->cabpe;

        $mtopventa = 0;
        $mdcto = 0;
        foreach ($cabpe->detpe as $det) {
            if ($det->MCODDFA == 'Bono') {
                continue;
            } else {
                $mtopventa = $mtopventa + ($det->MCANTIDAD * $det->MPRECIO);
            }
            if ($det->MCODDFA != 'Sin descuento' && $det->MCODDFA != 'Bono') {
                $mdcto = $mdcto + ($det->MCANTIDAD * $det->MPRECIO * ($det->famdfa->MPOR_DFA / 100));
            }
        }
        $mneto = $mtopventa - $mdcto;
        $migv =  $mneto - ($mneto / 1.18);
        $mvalven = $mtopventa - $migv;

        $new_cabpe = [
            'MTOPVENTA' => round($mtopventa, 2),
            'MDCTO' => round($mdcto, 2),
            'MIGV' => round($migv, 2),
            'MNETO' => round($mneto, 2),
            'MSALDO' => round($mneto, 2),
            'MVALVEN' => round($mvalven, 2),
        ];

        $cabpe->fill($new_cabpe);
        $cabpe->save();

        return response()->json($detpe, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Detpe  $detpe
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $detpe_id)
    {
        $detpe = Detpe::find($detpe_id);
        $cabpe = $detpe->cabpe;

        $detpe->delete();

        $mtopventa = 0;
        $mdcto = 0;
        foreach ($cabpe->detpe as $det) {
            if ($det->MCODDFA == 'Bono') {
                continue;
            } else {
                $mtopventa = $mtopventa + ($det->MCANTIDAD * $det->MPRECIO);
            }
            if ($det->MCODDFA != 'Sin descuento' && $det->MCODDFA != 'Bono') {
                $mdcto = $mdcto + ($det->MCANTIDAD * $det->MPRECIO * ($det->famdfa->MPOR_DFA / 100));
            }
        }
        $mneto = $mtopventa - $mdcto;
        $migv =  $mneto - ($mneto / 1.18);
        $mvalven = $mtopventa - $migv;

        $new_cabpe = [
            'MTOPVENTA' => round($mtopventa, 2),
            'MDCTO' => round($mdcto, 2),
            'MIGV' => round($migv, 2),
            'MNETO' => round($mneto, 2),
            'MSALDO' => round($mneto, 2),
            'MVALVEN' => round($mvalven, 2),
        ];

        $cabpe->fill($new_cabpe);
        $cabpe->save();

        return response()->json(null, 200);

    }
}
