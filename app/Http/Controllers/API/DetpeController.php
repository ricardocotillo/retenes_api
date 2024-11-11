<?php

namespace App\Http\Controllers\API;

use App\Models\Cabpe;
use App\Models\Detpe;
use App\Models\Articulo;
use App\Models\Famdfa;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
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
    public function store(Request $request, string $mnserie, string $mnroped) {
        $igv = 1.18;

        $pedido = $request->all();

        $articulo = Articulo::firstWhere('MCODART', $pedido['mcodart']);
        $famdfa = Famdfa::firstWhere('MCODDFA', $pedido['mcoddfa']);

        $mprecio = $pedido['precio'] * $igv;
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
            'estado' => 1,
            'item_state' => 'espera',
            'status_changed' => false,
        );

        $detpe = new Detpe($detped_data);

        $cabpe = Cabpe::where('MNROPED', $mnroped)->where('MNSERIE', $mnserie)->where('MCODVEN', $pedido['mcodven'])->first();

        if (!$cabpe) {
            $prev_cabpe = Cabpe::where('MNROPED', $mnroped)->where('MNSERIE', $mnserie)->first();

            $cabpe = Cabpe::create(array(
                'MTIPODOC' => 'C',
                'MNSERIE' => $mnserie,
                'MNROPED' => $mnroped,
                'MCODTPED' => '01',
                'MFECEMI' => date('Y-m-d'),
                'MPERIODO' => date('Ym'),
                'MCODCLI' => $pedido['mcodcli'],
                'MCODCADI' => $prev_cabpe->MCODCADI,
                'MCODCPA' => $prev_cabpe->MCODCPA,
                'MCODVEN' => $pedido['mcodven'],
                'MCODZON' => $prev_cabpe->MCODZON,
                'MCODMON' => '001',
                'MDOLINT' => 'S',
                'MFECENT' => date('Y-m-d'),
                'MLUGENT' => $prev_cabpe->MLUGENT,
                'MLOCALID' => $prev_cabpe->MLOCALID,
                'MVALVEN' => 0,
                'MDCTO' => 0,
                'MIGV' => 0,
                'MTOPVENTA' => 0,
                'MNETO' => 0,
                'MSALDO' => 0,
                'MPORIGV' => 18.00,
                'MINDORIG' => 1,
                'MIND_N_I' => 1,
                'MINDAPROB' => 'S',
                'MINDIMP' => 'N',
                'MINC_IGV' => 'S',
                'MANO_E' => date('Y'),
                'MMES_E' => date('m'),
                'MDIA_E' => date('d'),
                'MTEND' => 0,
                'MNORDCLI' => $prev_cabpe->MNORCLI,
                'MAMD' => date('Ymd'),
                'MINDFACT' => 'N',
                'MCODLPRE' => '03',
                'MNOMCLI' => $prev_cabpe->MNOMCLI,
                'MLUGFAC' => $prev_cabpe->MLUGFAC,
                'MCODSITD' => '04',
                'MFECUACT' => date('Y-m-d'),
                'MCODUSER' => '600000000000001',
                'MHORAUACT' => date('h:i:s'),
                'MPESOKG' => 0.0,
                'MATEND' => 0,
                'estado' => $prev_cabpe->estado,
                'MOBSERV' => $prev_cabpe->MOBSERV,
                'MCODTRSP' => $prev_cabpe->MCODTRSP,
                'MCORREO'  => $prev_cabpe->MCORREO,
              ));
            $cabpe->save();
        }
        
        $cabpe->detpe()->save($detpe);
        if ($pedido['mcoddfa'] && !in_array(trim($pedido['mcoddfa']), ['Sin descuento', 'Bono', 'Precio especial'])) {
            $famdfa = Famdfa::where('MCODDFA', $pedido['mcoddfa'])->first();
            $detpe->famdfas()->attach($famdfa->id, ['type' => 'item']);
        }

        $mtopventa = 0;
        $mdcto = 0;
        foreach ($cabpe->detpe as $det) {
            if ($det->MCODDFA == 'Bono') {
                continue;
            } else {
                $mtopventa = $mtopventa + ($det->MCANTIDAD * $det->MPRECIO);
            }
            if ($det->MCODDFA != 'Sin descuento' && $det->MCODDFA != 'Bono' && $det->MCODDFA != 'Precio especial') {
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
    public function update(Request $request, int $detpe_id) {
        $igv = 1.18;

        $new_detpe = $request->all();
        $famdfa = Famdfa::firstWhere('MCODDFA', $new_detpe['MCODDFA']);

        $detpe = Detpe::find($detpe_id);

        $mprecio = $new_detpe['MPRECIO'];
        $mpordct1 = !is_null($famdfa) ? $famdfa['MPOR_DFA'] : 0.000;
        $mvalven = round($mprecio * $new_detpe['MCANTIDAD'], 2);
        $mdcto = round($mvalven * ($mpordct1 / 100), 2);
        $migv = round(($mvalven - $mdcto) - (($mvalven - $mdcto) / $igv), 2);

        $new_detpe['MPRECIO'] = $mprecio;
        $new_detpe['MPORDCT1'] = $mpordct1;
        $new_detpe['MVALVEN'] = $mvalven;
        $new_detpe['MDCTO'] = $mdcto;
        $new_detpe['MIGV'] = $migv;
        $new_detpe['MINDOBSQ'] = $new_detpe['MCODDFA'] == 'Bono' ? 'D' : 'N';
        $new_detpe['estado'] = 1;

        $detpe->fill($new_detpe);
        if (isset($new_detpe['famdfas'])) {
            $detpe->famdfas()->detach();
            foreach ($new_detpe['famdfas'] as $f) {
                $type = $f['pivot'] != null ? $f['pivot']['type'] : $f['tipo'];
                $detpe->famdfas()->attach($f['id'], ['type' => $type]);
            }
        }
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
            if ($det->MCODDFA != 'Sin descuento' && $det->MCODDFA != 'Bono' && $det->MCODDFA != 'Precio especial') {
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

    public function update_fecha_despacho(Request $request, int $detpe_id) : JsonResponse {
        $d = Detpe::find($detpe_id);
        $data = $request->all();
        $d->fecha_despacho = $data['fecha'];
        $d->save();
        return response()->json($d);
    }

    public function update_item_state(Request $request, int $detpe_id) : JsonResponse {
        $d = Detpe::find($detpe_id);
        $data = $request->all();
        $d->item_state = $data['state'];
        $d->fecha_despacho = isset($data['date']) ? $data['date'] : null;
        $d->partial = $data['partial'];
        $d->status_changed = true;
        $d->save();
        return response()->json($d);
    }
    
    public function update_partial(Request $request, $detpe_id) : JsonResponse {
        $d = Detpe::find($detpe_id);
        $partial = $request->input('partial');
        $d->partial = $partial;
        $d->save();
        return response()->json($d);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Detpe  $detpe
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $detpe_id) {
        $detpe = Detpe::find($detpe_id);

        $detpe->delete();
        $cabpe = $detpe->cabpe;
        $cabpe = $cabpe->fresh();
        $detpe_count = $cabpe->detpe()->count();

        if (!$detpe_count) {
            $cabpe->delete();
            return response()->json(null, 200);
        }

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
