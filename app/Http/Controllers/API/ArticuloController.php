<?php

namespace App\Http\Controllers\API;

use App\Models\Articulo;
use App\Models\CampoProductoAlterno;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticuloController extends Controller
{
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $q = $request->input('q', '');
        $dint = $request->input('dint', null);
        $dext = $request->input('dext', null);
        $alt = $request->input('alt', null);
        $articulos = Articulo::where('MCODART', 'ilike', '%'.$q.'%');
        if ($dint) {
            $articulos = $articulos->where('MDIM_INT1', '>=', $dint);
        }
        if ($dext) {
            $articulos = $articulos->where('MDIM_EXT1', '>=', $dext);
        }
        if ($alt) {
            $articulos = $articulos->where('MDIM_ALT1', '>=', $alt);
        }
        if ($dint || $dext || $alt) {
            $articulos = $articulos
                ->orderBy('MDIM_INT1')
                ->orderBy('MDIM_EXT1')
                ->orderBy('MDIM_ALT1');
        } else {
            $articulos = $articulos->orderBy('MCODART');
        }
        $articulos = $articulos->cursorPaginate(15);
        return response()->json($articulos, $this->successStatus);
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
     * Display a listing of the searched resource.
     *
     * @param  string  $search
     * @return \Illuminate\Http\Response
     */
    public function show(string $search)
    {
        $articulos = Articulo::where('MCODART', 'LIKE', $search.'%')->get();
        return response()->json($articulos, $this->successStatus);
    }

    /**
     * Display a listing of the searched resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function articulo(int $id)
    {
        $articulo = Articulo::find($id);
        return response()->json($articulo , $this->successStatus);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Busca articulos relacionados con el articulo con el id $id segun los campos
     * de productos alternos configurados en la tabla campos_productos_alternos.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function related(int $id)
    {
        // Buscar el artículo o lanzar una excepción si no existe
        $articulo = Articulo::findOrFail($id);
        
        // Obtener los campos configurados como productos alternos
        $camposProductosAlternos = CampoProductoAlterno::all();
        
        // Si no hay campos configurados, devolver un array vacío
        if ($camposProductosAlternos->isEmpty()) {
            return response()->json([], $this->successStatus);
        }

        // Prepare the list of fields to select
        // We always want 'id', 'MCODART', plus the fields configured in CampoProductoAlterno
        $selectFields = ['id', 'MCODART', 'MSTOCK', 'MDISENO'];
        foreach ($camposProductosAlternos as $campoProductoAlterno) {
            $selectFields[] = $campoProductoAlterno->campo;
        }
        // Ensure unique field names
        $selectFields = array_unique($selectFields);
        
        // Iniciar la consulta
        $query = Articulo::query();
        $hasConditions = false; // Flag to track if any valid OR conditions are added
        
        // Construir la consulta con condiciones OR para cada campo configurado
        $query->where(function($q) use ($camposProductosAlternos, $articulo, &$hasConditions) {
            foreach ($camposProductosAlternos as $campoProductoAlterno) {
                $campo = $campoProductoAlterno->campo;
                $valorCampo = $articulo->{$campo} ?? null; // Get the value safely

                // Check if the value is present and not null
                if (isset($articulo->{$campo}) && !is_null($valorCampo)) {
                    $useThisValue = true;
                    // Further check: if the value is numeric, ensure it's not zero
                    if (is_numeric($valorCampo) && (float)$valorCampo == 0) {
                        $useThisValue = false;
                    }

                    if ($useThisValue) {
                        $q->orWhere($campo, '=', $valorCampo);
                        $hasConditions = true;
                    }
                }
            }
        });
        
        // If no valid conditions were added (e.g., all fields in $articulo were null or numeric zero),
        // ensure the query returns no results.
        if (!$hasConditions) {
            $query->whereRaw('1 = 0'); // This condition will always be false
        }
        
        // Get the related articles paginated, selecting only specified fields
        $articulosRelacionados = $query->select($selectFields)->cursorPaginate(20);
        
        return response()->json($articulosRelacionados, $this->successStatus);
    }
}
