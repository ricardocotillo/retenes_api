<?php

namespace App\Http\Controllers\API;

use App\Models\Cabpe;
use App\Models\Detpe;
use App\Models\Ccmsedo;
use App\Models\Ccmcli;
use App\Models\Articulo;
use App\Models\Famdfa;
use App\Models\Ccmcpa;
use App\Models\CabpeModification;
use App\Mail\PedidoProcesado;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ccmtrs;

class CabpeController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = Cabpe::all();
        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $cabeceras = $request->input('cabeceras');
        $estado = $request->input('estado');
        $mcodtrsp = $request->input('transporte');
        $observaciones = $request->input('observaciones');
        $articulos = array();
        $montoTotalFinal = 0;
        $ccmsedo = Ccmsedo::orderBy('id', 'desc')->first();
        function nroped($numero)
        {
            $n = (int) $numero + 1;
            $n = (string) $n;
            while (strlen($n) < 6) {
                $n = '0' . $n;
            }
            return $n;
        }

        $cabpe = Cabpe::orderBy('id', 'desc')->first();
        $mnroped = isset($cabpe['MNROPED']) ? nroped($cabpe['MNROPED']) : '000001';

        foreach ($cabeceras as $key => $cabe) {
            if (count($cabe['pedidos']) <= 0) continue;
            $articulos[$key] = array();
            $ccmcli = Ccmcli::where('MCODCLI', '=', $cabe['MCODCLI'])->first();
            $mtopventa = 0.0;
            $mdcto = 0.0;
            foreach ($cabe['pedidos'] as $pedido) {
                if ($pedido['mcoddfa'] == 'Bono') {
                    continue;
                } else {
                    $mtopventa = $mtopventa + ($pedido['cantidad'] * round($pedido['precio'] * 1.18, 2));
                }
                if ($pedido['mcoddfa'] != 'Sin descuento' && $pedido['mcoddfa'] != 'Bono') {
                    $mdcto = $mdcto + ($pedido['cantidad'] * round($pedido['precio'] * 1.18, 2) * ($pedido['mpordfa'] / 100));
                }
            }
            $mneto = $mtopventa - $mdcto;
            $migv = $mneto - ($mneto / 1.18);
            $mvalven = $mtopventa - $migv;
            $montoTotalFinal = $mneto;
            $codven = $cabe['MCODVEN'];
            $cabecera = array(
                'MTIPODOC' => $ccmsedo['MTIPODOC'],
                'MNSERIE' => $ccmsedo['MNSERIE'],
                'MNROPED' => $mnroped,
                'MCODTPED' => '01',
                'MFECEMI' => date('Y-m-d'),
                'MPERIODO' => date('Ym'),
                'MCODCLI' => $cabe['MCODCLI'],
                'MCODCADI' => $ccmcli['MCODCADI'],
                'MCODCPA' => $request->input('MCONDPAGO'),
                'MCODVEN' => $cabe['MCODVEN'],
                'MCODZON' => $ccmcli['MCODZON'],
                'MCODMON' => '001',
                'MDOLINT' => 'S',
                'MFECENT' => date('Y-m-d'),
                'MLUGENT' => $ccmcli['MDIRDESP'],
                'MLOCALID' => $ccmcli['MLOCALID'],
                'MVALVEN' => round($mvalven, 2),
                'MDCTO' => round($mdcto, 2),
                'MIGV' => round($migv, 2),
                'MTOPVENTA' => round($mtopventa, 2),
                'MNETO' => round($mneto, 2),
                'MSALDO' => round($mneto, 2),
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
                'MNORDCLI' => $ccmcli['MUBIGEO'],
                'MAMD' => date('Ymd'),
                'MINDFACT' => 'N',
                'MCODLPRE' => '03',
                'MNOMCLI' => $ccmcli['MNOMBRE'],
                'MLUGFAC' => $ccmcli['MDIRECC'],
                'MCODSITD' => '04',
                'MFECUACT' => date('Y-m-d'),
                'MCODUSER' => '600000000000001',
                'MHORAUACT' => date('h:i:s'),
                'MPESOKG' => 0.0,
                'MATEND' => 0,
                'estado' => $cabe['descuentoExtra'] ? 'pendiente' : 'procesado',
                'MOBSERV' => $observaciones,
                'estado' => $estado,
                'MCODTRSP' => $mcodtrsp,
            );
            $cab = Cabpe::create($cabecera);
            $cab->save();
            $mitem = 1;
            foreach ($cabe['pedidos'] as $value) {
                $art = Articulo::where('MCODART', '=', $value['mcodart'])->first();
                $mprecio = round($value['precio'] * 1.18, 2);
                $mpordct1 = isset($value['mpordfa']) ? $value['mpordfa'] : 0.000;
                $mvalven = round($mprecio * $value['cantidad'], 2);
                $mdcto = round($mvalven * ($mpordct1 / 100), 2);
                $migv = round(($mvalven - $mdcto) - (($mvalven - $mdcto) / 1.18), 2);

                $mdetped = array(
                    'MTIPODOC' => 'C',
                    'MNSERIE' => $ccmsedo['MNSERIE'],
                    'MNROPED' => $mnroped,
                    'MITEM' => (string) $mitem,
                    'MCODART' => $value['mcodart'],
                    'MCANTIDAD' => (float) $value['cantidad'],
                    'MCANTPEN' => (float) $value['cantidad'],
                    'MUNIDAD' => $art['MUNIDAD'],
                    'MCODUMED' => 22,
                    'MFACTOR' => $art['MUNDENV1'],
                    'MDESCRI01' => $art['MDESCRIP'],
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
                    'MINDOBSQ' => $value['mcoddfa'] == 'Bono' ? 'D' : 'N',
                    'MCODUSER' => '600000000000001',
                    'MFECUACT' => date('Y-m-d'),
                    'MHORUACT' => date('h:i:s'),
                    'MPENFAC' => (float) $value['cantidad'],
                    'MCODDFA' => $value['mcoddfa'],
                );
                $det = new Detpe($mdetped);
                $cab->detpe()->save($det);
                $mitem = $mitem + 1;
                array_push($articulos[$key], $det);
            }
        }
        return $this->send_email($request, $ccmsedo->MNSERIE, $mnroped);
        return response()->json([], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cabpe  $cabpe
     * @return \Illuminate\Http\Response
     */
    public function show(Request $req)
    {
        // obtener los códigos de vendedores
        $cods = $req->all();
        $cabpes = Cabpe::whereIn('MCODVEN', $cods)
                ->select(
                    [
                        'id',
                        'MNSERIE',
                        'MNROPED',
                        'MFECEMI',
                        'MCODCPA',
                        'MCODVEN',
                        'MCODCLI',
                        'MTOPVENTA',
                        'MNOMCLI',
                        'MCODCADI',
                        'MCODTRSP',
                        'MOBSERV',
                        'estado',
                    ]
                )
                ->with(['detpe.famdfa', 'ccmcpa', 'ccmcli', 'ccmtrs'])
                ->orderBy('MNSERIE', 'desc')
                ->orderBy('MNROPED', 'desc')
                ->groupBy('id', 'MNROPED')
                ->paginate(50);
        return response()->json($cabpes, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cabpe  $cabpe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $cabpe_id)
    {
        //
    }

    /**
     * Actualizar MCONDPAGO.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cabpe  $cabpe
     * @return \Illuminate\Http\Response
     */
    public function update_mcodcpa(Request $request, string $mnserie, string $mnroped)
    {
        $igv = 1.18;
        $mcodcpa = $request->input('mcodcpa');
        $cabpes = Cabpe::where('MNSERIE', $mnserie)->where('MNROPED', $mnroped)->with(['ccmcpa', 'detpe', 'detpe.articulo', 'ccmcli'])->get();

        foreach($cabpes as $cabpe) {
            $cabpe->MCODCPA = $mcodcpa;
            $cabpe->save();

            foreach ($cabpe->detpe as $detpe) { 
                $detpe->MINDOBSQ = 'N';
                $detpe->MCODDFA = 'Sin descuento';
                $detpe->MDCTO = 0.0;
                $detpe->MPORDCT1 = 0.0;
                $detpe->MIGV = round($detpe->MVALVEN - ($detpe->MVALVEN / $igv), 2);
                $detpe->MPRECIO = $detpe->articulo->getCorrectPrice($cabpe->ccmcli->MCODCADI);
                $detpe->save();
            }
            $this->recalculate($cabpe);
        }

        return response()->json($cabpes, 200);
    }

    public function update_descuento_general(Request $request, int $id)
    {
        $igv = 1.18;
        $mcoddfa = $request->input('mcoddfa');
        $cabpe = Cabpe::with(['detpe', 'ccmcli', 'ccmcpa', 'ccmtrs'])->find($id);

        if ($mcoddfa == 'Sin descuento') {
            foreach ($cabpe->detpe()->notBono()->get() as $detpe)
            {
                $detpe->MCODDFA = 'Sin descuento';
                $detpe->MDCTO = 0.0;
                $detpe->MPORDCT1 = 0.0;
                $detpe->MIGV = round($detpe->MVALVEN - ($detpe->MVALVEN / $igv), 2);
                $detpe->save();
            }
        } else {
            $famdfa = Famdfa::where('MCODDFA', $mcoddfa)->first();

            foreach ($cabpe->detpe()->notBono()->get() as $detpe)
            {
                $mpordct1 = $famdfa->MPOR_DFA;
                $mvalven = round($detpe->MPRECIO * $detpe->MCANTIDAD, 2);
                $mdcto = round($mvalven * ($mpordct1 / 100), 2);
                $migv = round(($mvalven - $mdcto) - (($mvalven - $mdcto) / 1.18), 2);

                $detpe->MCODDFA = $famdfa->MCODDFA;
                $detpe->MDCTO = $mdcto;
                $detpe->MPORDCT1 = $mdcto;
                $detpe->MIGV = $migv;
                $detpe->save();
            }
        }

        $cabpe->refresh();

        $this->recalculate($cabpe);

        return response()->json($cabpe, 200);

    }

    private function recalculate(Cabpe $cabpe) {
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
    }

    /**
     * Enviar correo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cabpe  $cabpe
     * @return \Illuminate\Http\Response
     */
    public function send_email(Request $request, string $mnserie, string $mnroped) {
        $estado = $request->input('estado');
        $email = $request->input('email');
        $enviar_correo = $request->input('enviarCorreo');
        $cabpes = Cabpe::with(['detpe', 'detpe.famdfa', 'ccmtrs', 'ccmcli', 'ccmcpa'])->where('MNSERIE', $mnserie)->where('MNROPED', $mnroped)->get();
        $data = array('nombre' => $cabpes[0]->ccmcli->MNOMBRE);

        $ccmcpa = $cabpes[0]->ccmcpa;
        $ccmtrs = $cabpes[0]->ccmtrs;

        $articulos = array();

        foreach ($cabpes as $key => $cabpe) {
            if (config('app.flavor') == 'filtros') {
                $ar = $cabpe->detpe->sortBy('MCODART')->sortByDesc('famdfa.MDESCRIP')->toArray();
                info($ar);
                $emp = array_values(array_filter($ar, function($d) { return in_array($d['MCODDFA'], ['Sin descuento', 'Bono']); }));
                $des = array_values(array_filter($ar, function($d) { return !in_array($d['MCODDFA'], ['Sin descuento', 'Bono']); }));
                foreach ($emp as $k => $e) {
                    for ($i=0; $i < count($des); $i++) {
                        if ($des[$i]['MCODART'] == $e['MCODART']) {
                            array_splice($des, $i+1, 0, array($e));
                            $emp[$k] = null;
                            break;
                        }
                    }
                }
                $emp = array_values(array_filter($emp, function($d) { return !is_null($d); }));
                $ar = array_merge($des, $emp);
                $articulos[$cabpe->MCODVEN] = $ar;
            } else {
                $articulos[$cabpe->MCODVEN] = $cabpe->detpe->sortByDesc('MCODART')->toArray();
            }
        }

        $montoTotalFinal = 0;

        foreach ($cabpes as $cabpe) {
            $montoTotalFinal = $montoTotalFinal + $cabpe->MNETO;
        }

        $info = [
            'fecha' => date('d/m/Y'),
            'periodo' => date('Y/m'),   
            'mnroped' => $cabpes[0]->MNSERIE . '-' . $cabpes[0]->MNROPED,
            'ruc' => $cabpes[0]->MCODCLI,
            'cliente' => $cabpes[0]->ccmcli->MNOMBRE,
            'canal' => $cabpes[0]->ccmcli->MCODCADI,
            'direccion' => $cabpes[0]->ccmcli->MDIRECC,
            'localidad' => $cabpes[0]->ccmcli->MLOCALID,
            'email' => $cabpes[0]->ccmcli->MCORREO,
            'condicion' => $cabpes[0]->ccmcpa->MABREVI,
            'articulos' => $articulos,
            'total' => $montoTotalFinal,
            'observaciones' => $cabpes[0]->MOBSERV,
            'transporte' => $cabpes[0]->ccmtrs->MCODTRSP,
            'nametrans' => $cabpes[0]->ccmtrs->MNOMBRE,
            'flavor' => config('app.flavor'),
        ];

        $mcodven = $cabpes[0]->MCODVEN;
        $ccmcli = $cabpes[0]->ccmcli;

        $recep = config('app.flavor') == 'filtros' ? 'recep_pedidos@filtroswillybusch.com.pe' : 'pedidos01_wb@filtroswillybusch.com.pe' ;

        PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true, 'debugPng' => true, 'defaultFont' => 'sans-serif']);
        $document = PDF::loadView('attach.pedido', $info);
        $output = $document->output();

        $ped_almacen = NULL;
        if (config('app.flavor') == 'filtros') {
            PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true, 'debugPng' => true, 'defaultFont' => 'sans-serif']);
            $document1 = PDF::loadView('attach.ped_almacen', $info);
            $ped_almacen = $document1->output();
        }
        if (!config('app.debug')) {
            if ($estado == 'terminado') {
                Mail::send('emails.mail', $data, function ($message) use ($ccmcli, $output, $mcodven, $recep, $ped_almacen) {
                    $message->to($recep, trim($ccmcli->MNOMBRE))->subject('Pedido en proceso - ' . trim($mcodven));
                    $message->from($recep, 'Pedidos Willy Busch');
                    $message->attachData($output, 'pedido.pdf');
                    if (config('app.flavor') == 'filtros' && !is_null($ped_almacen)) {
                        $message->attachData($ped_almacen, 'ped_almacen.pdf');
                    }
                });
            }
            Mail::send('emails.mail', $data, function ($message) use ($ccmcli, $output, $mcodven , $request, $recep) {
                $message->to($request->user()->email, trim($ccmcli->MNOMBRE))->subject('Pedido en proceso - ' . $mcodven);
                $message->from($recep, 'Pedidos Willy Busch');
                $message->attachData($output, 'pedido.pdf');
           });

            if ($request->input('enviarCorreo') && $ccmcli->MCORREO != NULL) {
                Mail::send('emails.mail', $data, function ($message) use ($ccmcli, $output, $mcodven, $email, $recep) {
                    $message->to(trim($ccmcli->MCORREO), trim($ccmcli->MNOMBRE))->subject('Pedido en proceso - ' . trim($mcodven));
                    $message->from($recep, 'Pedidos Willy Busch');
                    $message->attachData($output, 'pedido.pdf');
                });
            }

        } else {
            Mail::send('emails.mail', $data, function ($message) use ($ccmcli, $output, $mcodven, $email, $recep) {
                $message->to('rcotillo@cotillo.tech', trim($ccmcli->MNOMBRE))->subject('Pedido en proceso - ' . trim($mcodven));
                $message->from($recep, 'Pedidos Willy Busch');
                $message->attachData($output, 'pedido.pdf');
            });
        }

        foreach ($cabpes as $cabpe) {
            $cabpe->estado = $estado;
            $cabpe->save();
        }

        return response()->json([], 200);
    }

    /**
     * Enviar correo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $mnserie
     * @param  string  $mnroped
     * @return \Illuminate\Http\Response
     */
    public function update_ccmtrs(Request $request, string $mnserie, string $mnroped) {
        $mcodtrsp = $request->input('mcodtrsp');

        $ccmtrs = Ccmtrs::where('MCODTRSP', $mcodtrsp)->first();
        $cabpes = Cabpe::with('ccmtrs')->where('MNSERIE', $mnserie)->where('MNROPED', $mnroped)->get();
        foreach ( $cabpes as $c ) {
            $c->ccmtrs();
            $c->ccmtrs()->associate($ccmtrs);
            $c->save();
        }

        return response()->json($ccmtrs, 200);
    }

    /**
     * Update MOBSERV.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $mnserie
     * @param  string  $mnroped
     * @return \Illuminate\Http\Response
     */
    public function update_mobserv(Request $request, string $mnserie, string $mnroped) {
        $mobserv = $request->input('mobserv');

        $cabpes = Cabpe::where('MNSERIE', $mnserie)->where('MNROPED', $mnroped)->get();

        foreach ($cabpes as $c) {
            $c->MOBSERV = $mobserv;
            $c->save();
        }

        return response()->json(['mobserv' => $cabpes[0]->MOBSERV], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cabpe  $cabpe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cabpe $cabpe)
    {
        //
    }

    public function modifications(int $mnserie, int $mnroped) {
        $cabpe_mod = CabpeModification::where('MNSERIE', $mnserie)->where('MNROPED', $mnroped)->get();
        $cabpe_mod->increment('modifications');
        $cabpe = Cabpe::where('MNSERIE', $mnserie)->where('MNROPED', $mnroped)->get();
        return response()->json($cabpe, 200);
    }
}
// ricardo.cotillo@gmail.com