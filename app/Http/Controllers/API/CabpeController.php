<?php

namespace App\Http\Controllers\API;

use App\Models\Cabpe;
use App\Models\Detpe;
use App\Models\Ccmsedo;
use App\Models\Ccmcli;
use App\Models\Articulo;
use App\Models\Famdfa;
use App\Models\Ccmtrs;
use App\Models\Value;
use App\Models\Instalment;
use App\Models\TxtDetpe;
use App\Models\CabpeModification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

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
        $values = $request->input('values', []);
        $instalments = $request->input('instalments', []);
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

        foreach ($values as $value) {
            $value['mnserie'] = $ccmsedo->MNSERIE;
            $value['mnroped'] = $mnroped;
            Value::create($value);
        }

        foreach ($instalments as $instalment) {
            $instalment['mnserie'] = $ccmsedo->MNSERIE;
            $instalment['mnroped'] = $mnroped;
            Instalment::create($instalment);
        }

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

                $det = Detpe::create($mdetped);
                $det->save();

                if ($value['famdfa']) {
                    $famdfa1 = Famdfa::where('MCODDFA', '=', $value['famdfa']['MCODDFA'])->first();
                    $det->famdfas()->attach($famdfa1->id, ['type' => 'item']);
                }
                
                if ($value['famdfa2']) {
                    $famdfa2 = Famdfa::where('MCODDFA', '=', $value['famdfa2']['MCODDFA'])->first();
                    $det->famdfas()->attach($famdfa2->id, ['type' => 'general']);
                }

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
    public function show(Request $request) {
        $q = $request->input('q');
        $user = Auth::user();
        $cabpes = Cabpe::select([
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
        ])
        ->with([
            'detpe.famdfas',
            'ccmcpa',
            'ccmcli',
            'ccmtrs',
            'instalments',
            'values',
        ]);
        if ($user->role != 'admin') {
            $codes = $request->input('codes');
            $codes = explode(',', $codes);
            $cabpes = $cabpes->whereIn('MCODVEN', $codes);
        }
        if ($q && is_numeric($q)) {
            $cabpes = $cabpes->where('MCODCLI', 'LIKE', '%' . $q . '%');
        }
        if ($q && !is_numeric($q)) {
            $cabpes = $cabpes->whereHas('ccmcli', function(Builder $query) use ($q) {
                $query->where('MNOMBRE', 'LIKE', '%' . $q . '%');
            });
        }
        $cabpes = $cabpes->orderBy('MNSERIE', 'desc')
            ->orderBy('MNROPED', 'desc')
            ->groupBy('id', 'MNSERIE', 'MNROPED')
            ->paginate(50);
        return response()->json($cabpes, 200);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $mcodcli
     * @param int $range
     * @return \Illuminate\Http\Response
     */
    public function show_by_range(Request $request, string $mcodcli, int $range) {
        $cabpes = Cabpe::where('MCODCLI', $mcodcli)
            ->where('MFECEMI', '>', now()->subDays($range)->endOfDay())
            ->with([
                'detpe',
                'detpe.famdfas',
                'ccmcpa',
                'ccmcli',
            ])
            ->orderBy('MNSERIE', 'desc')
            ->orderBy('MNROPED', 'desc')
            ->groupBy('id', 'MNROPED')->get();
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
    public function update_mcodcpa(Request $request, string $mnserie, string $mnroped) {
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
        $new_cabpe = [
            'MTOPVENTA' => round($cabpe->top_venta, 2),
            'MDCTO' => round($cabpe->dcto, 2),
            'MIGV' => round($cabpe->igv, 2),
            'MNETO' => round($cabpe->neto, 2),
            'MSALDO' => round($cabpe->neto, 2),
            'MVALVEN' => round($cabpe->valven, 2),
        ];

        $cabpe->fill($new_cabpe);
        $cabpe->save();
    }

    /**
     * @param Detpe[] $detpes
     */
    private function generate_txt(array $cabpes) {
        $txt_detpe = TxtDetpe::all();
        if (!$txt_detpe->count()) {
            return false;
        }
        
        $cols = $txt_detpe->implode('column', '|');
        $fields = $txt_detpe->pluck('field');
        $rows = [];
        foreach ($cabpes as $c) {
            foreach ($c as $d) {
                $row = [];
                foreach ($fields as $f) {
                    if (isset($d[$f])) array_push($row, $d[$f]);
                    else array_push($row, '');
                }
                $row = implode('|', $row);
                array_push($rows, $row);
            }
        }
        $rows = implode("\n", $rows);
        return $cols . "\n" . $rows;
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
        $cabpes = Cabpe::with(['detpe', 'detpe.famdfas', 'ccmtrs', 'ccmcli', 'ccmcpa', 'values', 'instalments'])->where('MNSERIE', $mnserie)->where('MNROPED', $mnroped)->get();
        $data = array('nombre' => $cabpes[0]->ccmcli->MNOMBRE);

        $articulos = array();

        foreach ($cabpes as $cabpe) {
            $ar = $cabpe->detpe->sortBy('MCODART')->sortByDesc('famdfa.MDESCRIP')->toArray();
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
        }

        $montoTotalFinal = 0;

        foreach ($cabpes as $cabpe) {
            $montoTotalFinal = $montoTotalFinal + $cabpe->precio_neto;
        }

        $info = [
            'fecha'         => date('d/m/Y'),
            'periodo'       => date('Y/m'),   
            'mnroped'       => $cabpes[0]->MNSERIE.'-'.$cabpes[0]->MNROPED,
            'ruc'           => $cabpes[0]->MCODCLI,
            'cliente'       => $cabpes[0]->ccmcli->MNOMBRE,
            'canal'         => $cabpes[0]->ccmcli->MCODCADI,
            'direccion'     => $cabpes[0]->ccmcli->MDIRECC,
            'localidad'     => $cabpes[0]->ccmcli->MLOCALID,
            'email'         => $cabpes[0]->ccmcli->MCORREO,
            'condicion'     => $cabpes[0]->ccmcpa->MABREVI,
            'articulos'     => $articulos,
            'total'         => $montoTotalFinal,
            'observaciones' => $cabpes[0]->MOBSERV,
            'transporte'    => $cabpes[0]->ccmtrs->MCODTRSP,
            'nametrans'     => $cabpes[0]->ccmtrs->MNOMBRE,
            'values'        => $cabpes[0] ->values,
            'instalments'   => $cabpes[0]->instalments()->get()->split(4)->all(),
            'total_atendido' => $cabpes->map(function($c) { return $c->totalByState('atendido');})->sum(),
            'total_pendiente' => $cabpes->map(function($c) { return $c->totalByState('pendiente');})->sum(),
            'total_anulado' => $cabpes->map(function($c) { return $c->totalByState('anulado');})->sum(),
            'flavor'        => config('app.flavor'),
        ];

        $mcodven = $cabpes[0]->MCODVEN;
        $ccmcli = $cabpes[0]->ccmcli;

        $recep = config('app.flavor') == 'filtros' ? 'recep_pedidos@filtroswillybusch.com.pe' : 'pedidos01_wb@filtroswillybusch.com.pe' ;

        PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true, 'debugPng' => true, 'defaultFont' => 'sans-serif']);
        $document = PDF::loadView('attach.pedido', $info);
        $output = $document->output();

        $txt_output = $this->generate_txt($articulos);
        $ped_almacen = NULL;
        if (config('app.flavor') == 'filtros') {
            PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true, 'debugPng' => true, 'defaultFont' => 'sans-serif']);
            $document1 = PDF::loadView('attach.ped_almacen', $info);
            $ped_almacen = $document1->output();
        }
        if (!config('app.debug')) {
            if ($estado == 'terminado') {
                Mail::send('emails.mail', $data, function ($message) use ($ccmcli, $output, $mcodven, $recep, $ped_almacen, $txt_output) {
                    $message->to($recep, trim($ccmcli->MNOMBRE))->subject('Pedido en proceso - ' . trim($mcodven));
                    $message->from($recep, 'Pedidos Willy Busch');
                    $message->attachData($output, 'pedido.pdf');
                    $message->attachData($txt_output, 'pedido.txt');
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
                Mail::send('emails.mail', $data, function ($message) use ($ccmcli, $output, $mcodven, $recep) {
                    $message->to(trim($ccmcli->MCORREO), trim($ccmcli->MNOMBRE))->subject('Pedido en proceso - ' . trim($mcodven));
                    $message->from($recep, 'Pedidos Willy Busch');
                    $message->attachData($output, 'pedido.pdf');
                });
            }

        } else {
            Mail::send('emails.mail', $data, function ($message) use ($ccmcli, $output, $mcodven, $recep, $txt_output) {
                $message->to('rcotillo@cotillo.tech', trim($ccmcli->MNOMBRE))->subject('Pedido en proceso - ' . trim($mcodven));
                $message->from($recep, 'Pedidos Willy Busch');
                $message->attachData($output, 'pedido.pdf');
                $message->attachData($txt_output, 'pedido.txt');
            });
        }

        foreach ($cabpes as $c) {
            $c->estado = $estado;
            $c->save();
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
    public function destroy(Cabpe $cabpe) {
        //
    }

    public function modifications(int $mnserie, int $mnroped) {
        $cabpe_mod = CabpeModification::where('MNSERIE', $mnserie)->where('MNROPED', $mnroped)->get();
        $cabpe_mod->increment('modifications');
        $cabpe = Cabpe::where('MNSERIE', $mnserie)->where('MNROPED', $mnroped)->get();
        return response()->json($cabpe, 200);
    }

    public function add_famdfa(Request $request, string $mnserie, string $mnroped) {
        $j = $request->all();
        $famdfa = $j['famdfa'];
        $type = $j['type'];
        $detpes = Detpe::where('MNSERIE', $mnserie)->where('MNROPED', $mnroped)->get();
        foreach ($detpes as $d) {
            $d->famdfas()->attach($famdfa['id'], ['type' => $type]);
        }
        return response()->json($detpes, 200);
    }

    public function remove_famdfa(Request $request, int $id) {
        $j = $request->all();
        $type = $j['type'];
        $c = Cabpe::with([
            'detpe',
            'detpe.famdfas',
        ])->find($id);
        
        foreach ($c->detpe as $d) {
            $d->famdfas()->newPivotStatement()->where('type', $type)->delete();
        }
        
        $c = Cabpe::with([
            'ccmcpa',
            'ccmcli',
            'ccmtrs',
            'instalments',
            'values',
            'detpe',
            'detpe.famdfas',
        ])->find($id);
        return response()->json($c, 200);
    }

    public function update_famdfa(Request $request, $id) {
        $j = $request->all();
        $data = $j['famdfa'];
        $famdfa = Famdfa::where('MCODDFA', $data['MCODDFA'])->first();
        $type = $j['type'];
        $c = Cabpe::with([
            'detpe',
            'detpe.famdfas',
        ])->find($id);
        foreach ($c->detpe as $d) {
            $d->famdfas()->wherePivot('type', 'general')->detach();
            $d->famdfas()->attach($famdfa->id, ['type' => 'general']);
        }
        $c = Cabpe::with([
            'ccmcpa',
            'ccmcli',
            'ccmtrs',
            'instalments',
            'values',
            'detpe',
            'detpe.famdfas' => function($q) {
                $q->orderByDesc('type');
            },
        ])->find($id);
        return response()->json($c, 200);
    }

    public function update_item_state(Request $request, string $mnserie, string $mnroped) : JsonResponse {
        $state = $request->input('state');
        $cabpes = Cabpe::where('MNSERIE', $mnserie)->where('MNROPED', $mnroped)->get();
        foreach ($cabpes as $c) {
            $c->detpe()->update(['item_state' => $state]);
        }
        return response()->json($cabpes);
    }

    public function update_fecha_despacho(Request $request, string $mnserie, string $mnroped) : JsonResponse {
        $fecha = $request->input('fecha');
        $cabpes = Cabpe::where('MNSERIE', $mnserie)->where('MNROPED', $mnroped)->get();
        foreach ($cabpes as $c) {
            $c->detpe()->update(['fecha_despacho' => $fecha]);
        }
        return response()->json($cabpes);
    }
}