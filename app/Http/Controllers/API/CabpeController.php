<?php

namespace App\Http\Controllers\API;

use App\Models\Cabpe;
use App\Models\Detpe;
use App\Models\Ccmsedo;
use App\Models\Ccmcli;
use App\Models\Articulo;
use App\Models\Famdfa;
use App\Models\Ccmcpa;
use App\Mail\PedidoProcesado;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ccmtrs; //JEANS CUBA 11-12-2020

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
                'MOBSERV' => '',
                'estado' => $estado,
                'MCODTRSP' => $mcodtrsp,
            );
            $cab = Cabpe::create($cabecera);
            $cab->save();
            $mitem = 1;
            foreach ($cabe['pedidos'] as $value) {
                $art = Articulo::where('MCODART', '=', $value['mcodart'])->first();

                $mdescrip = $value['mpordfa'] != null ? Famdfa::where('MCODDFA', '=', $value['mcoddfa'])->select('MDESCRIP')->first()['MDESCRIP'] : null;

                $mprecio = round($value['precio'] * 1.18, 2);
                $mpordct1 = $value['mpordfa'] != null ? $value['mpordfa'] : 0.000;
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
                $articulos[$key] = collect($articulos[$key])->sortBy('MCODART')->reverse()->toArray();
            }
        }

        return $this->send_email($request, $ccmsedo->MNSERIE, $mnroped);
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
                        'estado',
                    ]
                )
                ->with(['detpe', 'ccmcpa', 'ccmcli'])
                ->orderBy('MNSERIE', 'desc')
                ->orderBy('MNROPED', 'desc')
                ->groupBy('id', 'MNROPED')
                ->paginate(15);
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
        $cabpes = Cabpe::where('MNSERIE', $mnserie)->where('MNROPED', $mnroped)->with(['ccmcpa', 'detpe'])->get();

        foreach($cabpes as $cabpe) {
            $cabpe->MCODCPA = $mcodcpa;
            $cabpe->save();

            foreach ($cabpe->detpe as $detpe) { 
                $detpe->MINDOBSQ = 'N';
                $detpe->MCODDFA = 'Sin descuento';
                $detpe->MDCTO = 0.0;
                $detpe->MPORDCT1 = 0.0;
                $detpe->MIGV = round($detpe->MVALVEN - ($detpe->MVALVEN / $igv), 2);
                $detpe->save();
            }
        }

        return response()->json($cabpes, 200);
    }

    /**
     * Enviar correo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cabpe  $cabpe
     * @return \Illuminate\Http\Response
     */
    public function send_email(Request $request, string $mnserie, string $mnroped) {
        $email = $request->input('email');
        $cabpes = Cabpe::with(['detpe', 'detpe.famdfa'])->where('MNSERIE', $mnserie)->where('MNROPED', $mnroped)->get();
        $data = array('nombre' => $cabpes[0]->ccmcli->MNOMBRE);

        $ccmcpa = $cabpes[0]->ccmcpa;
        $ccmtrs = $cabpes[0]->ccmtrs;

        $articulos = array();

        foreach ($cabpes as $cabpe) {
            $articulos[$cabpe->MCODVEN] = array();
            foreach ($cabpe->detpe as $key => $detpe) {
                array_push($articulos[$cabpe->MCODVEN], $detpe);
                $articulos[$cabpe->MCODVEN] = collect($articulos[$cabpe->MCODVEN])->sortBy('MCODART')->reverse()->toArray();
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
            'observaciones' => '',
            'transporte' => $cabpes[0]->ccmtrs->MCODTRSP,
            'nametrans' => $cabpes[0]->ccmtrs->MNOMBRE,
        ];

        $mcodven = $cabpes[0]->MCODVEN;
        $ccmcli = $cabpes[0]->ccmcli;

        PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true, 'debugPng' => true, 'defaultFont' => 'sans-serif']);
        $document = PDF::loadView('attach.pedido', $info);
        $output = $document->output();
        if (config('app.debug') == false) {
            Mail::send('emails.mail', $data, function ($message) use ($ccmcli, $output, $mcodven) {
                $message->to('pedidos01_wb@filtroswillybusch.com.pe', $ccmcli->MNOMBRE)->subject('Pedido en proceso - ' . $mcodven);
                $message->from('pedidos01_wb@filtroswillybusch.com.pe', 'Pedidos Willy Busch');
                $message->attachData($output, 'pedido.pdf');
            });
            
            Mail::send('emails.mail', $data, function ($message) use ($ccmcli, $output, $mcodven, $email) {
                $message->to($ccmcli->MCORREO, $ccmcli->MNOMBRE)->subject('Pedido en proceso - ' . $mcodven);
                $message->from('pedidos01_wb@filtroswillybusch.com.pe', 'Pedidos Willy Busch');
                $message->attachData($output, 'pedido.pdf');
            });
        } else {
            Mail::send('emails.mail', $data, function ($message) use ($ccmcli, $output) {
                $message->to('dacharte@willybusch.com.pe', $ccmcli->MNOMBRE)->subject('Pedido en proceso');
                $message->from('pedidos01_wb@filtroswillybusch.com.pe', 'Pedidos Willy Busch');
                $message->attachData($output, 'pedido.pdf');
            });
        }

        foreach ($cabpes as $cabpe) {
            $cabpe->estado = 'terminado';
            $cabpe->save();
        }

        return response()->json([], 200);
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
}
// ricardo.cotillo@gmail.com