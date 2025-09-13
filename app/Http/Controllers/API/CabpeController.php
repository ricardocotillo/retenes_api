<?php

namespace App\Http\Controllers\API;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
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
use App\Models\Pedido;

class CabpeController extends Controller
{
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

  private function nroped($numero) {
    $n = (int) $numero + 1;
    $n = (string) $n;
    while (strlen($n) < 6) {
      $n = '0' . $n;
    }
    return $n;
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request) {
    $user = Auth::user();
    $cabeceras = $request->input('cabeceras');
    $estado = $request->input('estado');
    $mcodtrsp = $request->input('transporte');
    $observaciones = $request->input('observaciones');
    $values = $request->input('values', []);
    $instalments = $request->input('instalments', []);
    $articulos = array();
    $ccmsedo = Ccmsedo::orderBy('id', 'desc')->first();
    $mnroped = '';
    $pedido = Pedido::create([
      'mnserie' => $ccmsedo['MNSERIE'],
      'user_id' => $user->id,
    ]);
    
    DB::transaction(function () use ($request, $cabeceras, &$mnroped, $estado, $mcodtrsp, $observaciones, $values, $instalments, $articulos, $ccmsedo, $pedido) {
      $mnroped = str_pad((string) $pedido->id, 6, '0', STR_PAD_LEFT);
  
      foreach ($values as $value) {
        $value['mnserie'] = $pedido->mnserie;
        $value['mnroped'] = $mnroped;
        Value::create($value);
      }
  
      foreach ($instalments as $instalment) {
        $instalment['mnserie'] = $pedido->mnserie;
        $instalment['mnroped'] = $mnroped;
        Instalment::create($instalment);
      }
      foreach ($cabeceras as $key => $cabe) {
        if (count($cabe['pedidos']) <= 0) continue;
        $articulos[$key] = array();
        $ccmcli = Ccmcli::where('MCODCLI', '=', $cabe['MCODCLI'])->first();
        $mtopventa = 0.0;
        $mdcto = 0.0;
        foreach ($cabe['pedidos'] as $ca) {
          if ($ca['mcoddfa'] == 'Bono') {
            continue;
          } else {
            $mtopventa = $mtopventa + ($ca['cantidad'] * round($ca['precio'] * 1.18, 2));
          }
          if ($ca['mcoddfa'] != 'Sin descuento' && $ca['mcoddfa'] != 'Bono') {
            $mdcto = $mdcto + ($ca['cantidad'] * round($ca['precio'] * 1.18, 2) * ($ca['mpordfa'] / 100));
          }
        }
        $mneto = $mtopventa - $mdcto;
        $migv = $mneto - ($mneto / 1.18);
        $mvalven = $mtopventa - $migv;
        $cabecera = array(
          'MTIPODOC' => $ccmsedo['MTIPODOC'],
          'MNSERIE' => $pedido->mnserie,
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
          // 'estado' => $cabe['descuentoExtra'] ? 'pendiente' : 'procesado', Puede ser que ya sea irrelevante
          'MOBSERV' => $observaciones,
          'estado' => $estado,
          'MCODTRSP' => $mcodtrsp,
          'MCORREO'  => $ccmcli['MCORREO'],
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
            'MNSERIE' => $pedido->mnserie,
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
            'mcla_prod' => $value['MCLA_PROD'],
          );
  
          $det = Detpe::create($mdetped);
          $det->save();
  
          if ($value['famdfa']) {
            $famdfa1 = Famdfa::where('MCODDFA', '=', $value['famdfa']['MCODDFA'])->first();
            $det->famdfas()->attach($famdfa1->id, ['type' => 'item']);
          }
  
          if ($value['famdfas']) {
            foreach ($value['famdfas'] as $f) {
              $nf = Famdfa::where('MCODDFA', '=', $f['MCODDFA'])->first();
              $det->famdfas()->attach($nf->id, ['type' => $f['tipo'], 'mcla_prod' => $f['mcla_prod']]);
            }
          }
  
          $cab->detpe()->save($det);
          $mitem = $mitem + 1;
          array_push($articulos[$key], $det);
        }
      }
    });
    return $this->send_email($request, $pedido->mnserie, $mnroped);
  }

  public function show(Request $request, int $id) {
    $cabpe = Cabpe::with(['detpe', 'detpe.famdfas', 'ccmcpa', 'ccmcli'])->find($id);
    return response()->json($cabpe, 200);
  }

  public function historial(Request $request): \Illuminate\Http\JsonResponse
    {
        $q = $request->input('q');
        $user = Auth::user();

        // It's good practice to type hint the model if possible, e.g., $user = Auth::user(); where $user is an instance of User model
        // For Cabpe model, ensure it's imported: use App\Models\Cabpe;
        // For Builder, ensure it's imported: use Illuminate\Database\Eloquent\Builder;

        $query = Cabpe::select([
            'id', 'MNSERIE', 'MNROPED', 'MFECEMI', 'MCODCPA', 'MCODVEN', 'MCODCLI',
            'MTOPVENTA', 'MNOMCLI', 'MCODCADI', 'MCODTRSP', 'MOBSERV', 'estado',
        ])
        ->with([
            'detpe.famdfas', // Consider if all these eager-loaded relationships are always needed for this list view.
            'ccmcpa',
            'ccmcli',
            'ccmtrs',
            'instalments',
            'values',
        ]);

        if ($user->role !== 'admin') {
            $codesInput = $request->input('codes');
            
            // Ensure $codesInput is a non-empty string before processing
            if (is_string($codesInput) && trim($codesInput) !== '') {
                // Split by comma, trim each part, and filter out empty strings
                $processedCodes = array_filter(array_map('trim', explode(',', $codesInput)));
                
                if (!empty($processedCodes)) {
                    $query->whereIn('MCODVEN', $processedCodes);
                } else {
                    // If codesInput was provided but resulted in no valid codes (e.g., ",," or " , "),
                    // non-admins should see no results.
                    $query->whereRaw('0 = 1'); // Effectively means "match no records"
                }
            } else {
                // No codes string provided, or it's empty/whitespace only.
                // If non-admins must always be restricted by codes, they should see nothing.
                $query->whereRaw('0 = 1');
                // Alternative: If this is an error condition, you might return a specific error response:
                // return response()->json(['error' => 'Vendor codes are required for your role.'], 400);
            }
        }

        if ($q) { // Check if $q has a value (is not null, empty string, false, etc.)
            if (is_numeric($q)) {
                $query->where('MCODCLI', 'ilike', '%'.$q.'%');
            } else {
                $query->whereHas('ccmcli', function (\Illuminate\Database\Eloquent\Builder $subQuery) use ($q) {
                    $subQuery->where('MNOMBRE', 'ilike', '%'.$q.'%');
                });
            }
        }

        // Assuming 'id' is the primary key and uniquely identifies a row in 'cabpes'.
        // If (MNSERIE, MNROPED) can be non-unique for a given 'id', or if 'id' is not the PK,
        // or if you encounter issues with specific DB configurations (like older MySQL versions
        // without ONLY_FULL_GROUP_BY properly handled by Eloquent for this case),
        // the original groupBy('id', 'MNSERIE', 'MNROPED') might be safer or necessary.
        // However, if 'id' is PK, grouping by 'id' is sufficient as other selected
        // 'cabpes' columns are functionally dependent on 'id'.
        $cabpes = $query->orderBy('MNSERIE', 'desc')
            ->orderBy('MNROPED', 'desc')
            ->groupBy('id') // Simplified groupBy, ensure 'id' is PK for 'cabpes' table.
            ->paginate(10);

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
  public function show_by_range(Request $request, string $mcodcli, int $range)
  {
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
  public function update(Request $request, int $cabpe_id) {

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

    foreach ($cabpes as $cabpe) {
      $cabpe->MCODCPA = $mcodcpa;
      $cabpe->save();

      foreach ($cabpe->detpe as $detpe) {
        $detpe->MINDOBSQ = 'N';
        $detpe->MCODDFA = 'Sin descuento';
        $detpe->MDCTO = 0.0;
        $detpe->MPORDCT1 = 0.0;
        $detpe->MIGV = round($detpe->MVALVEN - ($detpe->MVALVEN / $igv), 2);
        $detpe->MPRECIO = $detpe->articulo->getCorrectPrice($cabpe->ccmcli->MCODCADI);
        $detpe->famdfas()->detach();
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
      foreach ($cabpe->detpe()->notBono()->get() as $detpe) {
        $detpe->MCODDFA = 'Sin descuento';
        $detpe->MDCTO = 0.0;
        $detpe->MPORDCT1 = 0.0;
        $detpe->MIGV = round($detpe->MVALVEN - ($detpe->MVALVEN / $igv), 2);
        $detpe->save();
      }
    } else {
      $famdfa = Famdfa::where('MCODDFA', $mcoddfa)->first();

      foreach ($cabpe->detpe()->notBono()->get() as $detpe) {
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

  private function recalculate(Cabpe $cabpe)
  {
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

  private function order_cabpes($cabpes) {
    $articulos = array();

    foreach ($cabpes as $cabpe) {
      $ar = $cabpe->detpe->sortBy('MCODART')->sortByDesc('famdfa.MDESCRIP')->toArray();
      $emp = array_values(array_filter($ar, function ($d) {
        return in_array($d['MCODDFA'], ['Sin descuento', 'Bono']);
      }));
      $des = array_values(array_filter($ar, function ($d) {
        return !in_array($d['MCODDFA'], ['Sin descuento', 'Bono']);
      }));
      foreach ($emp as $k => $e) {
        for ($i = 0; $i < count($des); $i++) {
          if ($des[$i]['MCODART'] == $e['MCODART']) {
            array_splice($des, $i + 1, 0, array($e));
            $emp[$k] = null;
            break;
          }
        }
      }
      $emp = array_values(array_filter($emp, function ($d) {
        return !is_null($d);
      }));
      $ar = array_merge($des, $emp);
      $articulos[$cabpe->MCODVEN] = $ar;
    }
    return $articulos;
  }

  private function sort_cabpes($cabpes) {
    $articulos = array();

    foreach ($cabpes as $cabpe) {
      $cab = $cabpe->toArray();
      $ar = $cabpe->detpe->sortBy('MCODART')->sortByDesc('famdfa.MDESCRIP')->toArray();
      $emp = array_values(array_filter($ar, function ($d) {
        return in_array($d['MCODDFA'], ['Sin descuento', 'Bono']);
      }));
      $des = array_values(array_filter($ar, function ($d) {
        return !in_array($d['MCODDFA'], ['Sin descuento', 'Bono']);
      }));
      foreach ($emp as $k => $e) {
        for ($i = 0; $i < count($des); $i++) {
          if ($des[$i]['MCODART'] == $e['MCODART']) {
            array_splice($des, $i + 1, 0, array($e));
            $emp[$k] = null;
            break;
          }
        }
      }
      $emp = array_values(array_filter($emp, function ($d) {
        return !is_null($d);
      }));
      $ar = array_merge($des, $emp);
      $cab['detpes'] = $ar;
      array_push($articulos, $cab);
    }
    return $articulos;
  }

  /**
   * @param Cabpe[] $cabpes
   */
  private function generate_txt($cabpes) {
        $cabpes = $this->sort_cabpes($cabpes);
        $txt_detpe = TxtDetpe::all();
        if (!$txt_detpe->count()) {
            return false;
        }

        $c_row = $txt_detpe->filter(function($t) {
            return $t->type == 'C';
        })->sortBy('order');

        $d_row = $txt_detpe->filter(function($t) {
            return $t->type == 'D';
        })->sortBy('order');
        
        $txt = [];
        foreach ($cabpes as $cabpe) {
            $head = ['C'];
            foreach ($c_row as $f) {
                if (isset($cabpe[$f['field']])) {
                  array_push($head, trim((string)$cabpe[$f['field']]));
                } else {
                  array_push($head, '');
                }
            }
            $head = implode('|', $head);

            $body = [];
            foreach ($cabpe['detpes'] as $detpe) {
              $row = ['D'];
              foreach ($d_row as $f) {
                if (isset($detpe[$f['field']])) {
                  array_push($row, trim((string)$detpe[$f['field']]));
                } else {
                  array_push($row, '');
                }
              }
              $row = implode('|', $row);
              array_push($body, $row);
            }
            $body = implode("\n", $body);
            
            array_push($txt, $head . "\n" . $body);
        }

        $txt = implode("\n", $txt);
        return $txt;
  }

  // download txt
  public function download_txt(Request $request, string $mnserie, string $mnroped) {
    $cabpes = Cabpe::with(['detpe', 'detpe.famdfas', 'ccmtrs', 'ccmcli', 'ccmcpa', 'values', 'instalments'])->where('MNSERIE', $mnserie)->where('MNROPED', $mnroped)->get();
    $txt = $this->generate_txt($cabpes);
    return response($txt, 200)
      ->header('Content-Type', 'text/plain')
      ->header('Content-Disposition', 'attachment; filename="pedidos.txt"');
  }

  private function get_pedido_info($cabpes) {
    $articulos = $this->order_cabpes($cabpes);
    $montoTotalFinal = 0;
    foreach ($cabpes as $cabpe) {
      $montoTotalFinal = $montoTotalFinal + $cabpe->precio_neto;
    }
    $mnroped = $cabpes[0]->MNSERIE . '-' . $cabpes[0]->MNROPED;
    $info = [
      'fecha'           => date('d/m/Y'),
      'periodo'         => date('Y/m'),
      'mnroped'         => $mnroped,
      'ruc'             => $cabpes[0]->MCODCLI,
      'cliente'         => $cabpes[0]->ccmcli->MNOMBRE,
      'canal'           => $cabpes[0]->ccmcli->MCODCADI,
      'direccion'       => $cabpes[0]->ccmcli->MDIRECC,
      'localidad'       => $cabpes[0]->ccmcli->MLOCALID,
      'email'           => $cabpes[0]->ccmcli->MCORREO,
      'condicion'       => $cabpes[0]->ccmcpa->MABREVI,
      'articulos'       => $articulos,
      'total'           => $montoTotalFinal,
      'observaciones'   => $cabpes[0]->MOBSERV,
      'transporte'      => $cabpes[0]->ccmtrs->MCODTRSP,
      'nametrans'       => $cabpes[0]->ccmtrs->MNOMBRE,
      'values'          => $cabpes[0]->values,
      'instalments'     => $cabpes[0]->instalments()->get()->split(4)->all(),
      'total_atendido'  => $cabpes->map(function ($c) {
        return $c->totalByState('atendido') + $c->totalByState('parcial');
      })->sum(),
      'total_pendiente' => $cabpes->map(function ($c) {
        return $c->totalByState('pendiente');
      })->sum(),
      'total_anulado'   => $cabpes->map(function ($c) {
        return $c->totalByState('anulado');
      })->sum(),
      'flavor'          => config('app.flavor'),
    ];
    return $info;
  }

  private function generate_pdf($cabpes, ?array $info = null, $download = false) {
    if (!$info) {
      $info = $this->get_pedido_info($cabpes);
    }
    PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true, 'debugPng' => true, 'defaultFont' => 'sans-serif']);
    $document = PDF::loadView('attach.pedido', $info);
    return $download ? $document->download('pedido.pdf') : $document->output();
  }

  private function generate_almacen_pdf($cabpes, ?array $info = null, $download = false) {
    if (!$info) {
      $info = $this->get_pedido_info($cabpes);
    }
    PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true, 'debugPng' => true, 'defaultFont' => 'sans-serif']);
    $document1 = PDF::loadView('attach.ped_almacen', $info);
    return $download ? $document1->download('ped_almacen.pdf') : $document1->output();
  }

  // download pdf
  public function download_pdf(Request $request, string $mnserie, string $mnroped) {
    $cabpes = Cabpe::with(['detpe', 'detpe.famdfas', 'ccmtrs', 'ccmcli', 'ccmcpa', 'values', 'instalments'])->where('MNSERIE', $mnserie)->where('MNROPED', $mnroped)->get();
    $pdf = $this->generate_pdf($cabpes, null, true);
    return response($pdf, 200)
      ->header('Content-Type', 'application/pdf')
      ->header('Content-Disposition', 'attachment; filename="pedido.pdf"');
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
    

    $mcodven = $cabpes[0]->MCODVEN;
    $ccmcli = $cabpes[0]->ccmcli;

    $recep = config('app.flavor') == 'filtros' ? 'pedidos01_iwb@filtroswillybusch.com.pe' : 'pedidos01_wb@willybusch.com.pe';
    $info = $this->get_pedido_info($cabpes);
    $output = $this->generate_pdf($cabpes, $info, false);

    $txt_output = $this->generate_txt($cabpes);
    $ped_almacen = NULL;
    if (config('app.flavor') == 'filtros') {
      $ped_almacen = $this->generate_almacen_pdf($cabpes, $info, false);
    }
    $file_name = 'pedido-' . $mnroped . '-' . trim($ccmcli->MCODCLI);
    if (!config('app.debug')) {
      if ($estado == 'terminado') {
        Mail::send('emails.mail', $data, function ($message) use ($ccmcli, $output, $mcodven, $recep, $ped_almacen, $txt_output, $file_name) {
          $message->to($recep, trim($ccmcli->MNOMBRE))->subject('Pedido en proceso - ' . trim($mcodven));
          $message->from($recep, 'Pedidos Willy Busch');
          $message->attachData($output, $file_name.'.pdf');
          $message->attachData($txt_output, $file_name.'.txt');
          if (config('app.flavor') == 'filtros' && !is_null($ped_almacen)) {
            $message->attachData($ped_almacen, 'ped_almacen.pdf');
          }
        });
      }
      Mail::send('emails.mail', $data, function ($message) use ($ccmcli, $output, $mcodven, $request, $recep, $file_name) {
        $message->to($request->user()->email, trim($ccmcli->MNOMBRE))->subject('Pedido en proceso - ' . $mcodven);
        $message->from($recep, 'Pedidos Willy Busch');
        $message->attachData($output, $file_name.'.pdf');
      });

      if ($request->input('enviarCorreo') && $ccmcli->MCORREO != NULL) {
        Mail::send('emails.mail', $data, function ($message) use ($ccmcli, $output, $mcodven, $recep, $file_name) {
          $message->to(trim($ccmcli->MCORREO), trim($ccmcli->MNOMBRE))->subject('Pedido en proceso - ' . trim($mcodven));
          $message->from($recep, 'Pedidos Willy Busch');
          $message->attachData($output, $file_name.'.pdf');
        });
      }
    } else {
      Mail::send('emails.mail', $data, function ($message) use ($ccmcli, $output, $mcodven, $recep, $txt_output, $file_name) {
        $message->to('rcotillo@cotillo.tech', trim($ccmcli->MNOMBRE))->subject('Pedido en proceso - ' . trim($mcodven));
        $message->from($recep, 'Pedidos Willy Busch');
        $message->attachData($output, 'pedido.pdf');
        $message->attachData($txt_output, $file_name.'.txt');
      });
    }

    /** @var Cabpe $c */
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
  public function update_ccmtrs(Request $request, string $mnserie, string $mnroped)
  {
    $mcodtrsp = $request->input('mcodtrsp');

    $ccmtrs = Ccmtrs::where('MCODTRSP', $mcodtrsp)->first();
    $cabpes = Cabpe::with('ccmtrs')->where('MNSERIE', $mnserie)->where('MNROPED', $mnroped)->get();
    /** @var Cabpe $c */
    foreach ($cabpes as $c) {
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
  public function update_mobserv(Request $request, string $mnserie, string $mnroped)
  {
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

  public function modifications(int $mnserie, int $mnroped)
  {
    $cabpe_mod = CabpeModification::where('MNSERIE', $mnserie)->where('MNROPED', $mnroped)->get();
    $cabpe_mod->increment('modifications');
    $cabpe = Cabpe::where('MNSERIE', $mnserie)->where('MNROPED', $mnroped)->get();
    return response()->json($cabpe, 200);
  }

  public function add_famdfa(Request $request, string $mnserie, string $mnroped)
  {
    $j = $request->all();
    $famdfa = $j['famdfa'];
    $mcla_prod = $j['mcla_prod'];
    $type = $j['type'];
    $detpes = Detpe::where('MNSERIE', $mnserie)->where('MNROPED', $mnroped)->get();
    foreach ($detpes as $d) {
      $d->famdfas()->attach($famdfa['id'], ['type' => $type, 'mcla_prod' => $mcla_prod]);
    }
    return response()->json($detpes, 200);
  }

  public function remove_famdfa(Request $request, int $id) {
    $j = $request->all();
    $general_types = ['general', 'retenes', 'repuestos'];
    $type = $j['type'];
    $mcla_prod = $j['mcla_prod'];
    $c = Cabpe::with([
      'detpe',
      'detpe.famdfas',
    ])->find($id);

    foreach ($c->detpe()->where('MCODDFA', '!=', 'Precio especial')->where('MCODDFA', '!=', 'Bono')->where('mcla_prod', $mcla_prod)->get() as $d) {
      if (in_array($type, $general_types)) {
        $d->famdfas()->wherePivotIn('type', $general_types)->wherePivot('mcla_prod', $mcla_prod)->detach();
      } else {
        $d->famdfas()->wherePivot('type', $type)->detach();
      }
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

  public function update_famdfa(Request $request, int $id) {
    $j = $request->all();
    $general_types = ['general', 'retenes', 'repuestos'];
    $type = $j['type'];
    $mcla_prod = $j['mcla_prod'];
    $data = $j['famdfa'];
    $famdfa = Famdfa::where('MCODDFA', $data['MCODDFA'])->first();
    $c = Cabpe::with([
      'detpe',
      'detpe.famdfas',
    ])->find($id);

    foreach ($c->detpe()->where('MCODDFA', '!=', 'Precio especial')->where('MCODDFA', '!=', 'Bono')->where('mcla_prod', $mcla_prod)->get() as $d) {
      if (in_array($type, $general_types)) {
        if ($mcla_prod) {
          $d->famdfas()->wherePivotIn('type', $general_types)->wherePivot('mcla_prod', $mcla_prod)->detach();
        } else {
          $d->famdfas()->wherePivotIn('type', $general_types)->detach();
        }
      } else {
        if ($mcla_prod) {
          $d->famdfas()->wherePivot('type', $type)->wherePivot('mcla_prod', $mcla_prod)->detach();
        } else {
          $d->famdfas()->wherePivot('type', $type)->detach();
        }
      }
      $d->famdfas()->attach($famdfa->id, ['type' => $type, 'mcla_prod' => $mcla_prod]);
    }

    $c = Cabpe::with([
      'ccmcpa',
      'ccmcli',
      'ccmtrs',
      'instalments',
      'values',
      'detpe',
      'detpe.famdfas' => function ($q) {
        $q->orderByDesc('type');
      },
    ])->find($id);
    return response()->json($c, 200);
  }

  public function update_item_state(Request $request, string $mnserie, string $mnroped): JsonResponse {
    $state = $request->input('state');
    $date = $request->input('date');
    $changed = $request->input('changed');
    $cabpes = Cabpe::where('MNSERIE', $mnserie)->where('MNROPED', $mnroped)->get();
    foreach ($cabpes as $c) {
      $c->detpe()->update([
        'item_state'      => $state,
        'fecha_despacho'  => $date,
        'status_changed'  => $changed,
      ]);
    }
    return response()->json($cabpes);
  }

  public function update_fecha_despacho(Request $request, string $mnserie, string $mnroped): JsonResponse
  {
    $fecha = $request->input('fecha');
    $cabpes = Cabpe::where('MNSERIE', $mnserie)->where('MNROPED', $mnroped)->get();
    foreach ($cabpes as $c) {
      $c->detpe()->update(['fecha_despacho' => $fecha]);
    }
    return response()->json($cabpes);
  }
}
