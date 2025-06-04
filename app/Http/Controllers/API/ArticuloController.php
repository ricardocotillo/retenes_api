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
        // Nota: El modelo se llama CampoProductoAlterno pero la tabla es campo_producto_alterno
        $camposProductosAlternos = CampoProductoAlterno::all();
        
        // Si no hay campos configurados, devolver un array vacío
        if ($camposProductosAlternos->isEmpty()) {
            return response()->json([], $this->successStatus);
        }

        // Prepare the list of fields to select
        // We always want 'id', plus the fields configured in CampoProductoAlterno
        $selectFields = ['id', 'MCODART'];
        foreach ($camposProductosAlternos as $campoProductoAlterno) {
            $selectFields[] = $campoProductoAlterno->campo;
        }
        // Ensure unique field names, especially if 'id' could be one of the 'campo' values
        $selectFields = array_unique($selectFields);
        
        // Iniciar la consulta
        $query = Articulo::query();
        
        // Construir la consulta con condiciones OR para cada campo configurado
        // Esto permite encontrar artículos que coincidan con al menos uno de los campos
        $query->where(function($q) use ($camposProductosAlternos, $articulo) {
            foreach ($camposProductosAlternos as $campoProductoAlterno) {
                $campo = $campoProductoAlterno->campo;
                
                // Verificar que el artículo tenga el campo y que no sea nulo
                if (isset($articulo->{$campo}) && !is_null($articulo->{$campo})) {
                    $q->orWhere($campo, $articulo->{$campo});
                }
            }
        });
        
        // Excluir el artículo actual de los resultados
        $query = $query->where('id', '!=', $id);
        
        // Get the related articles paginated, selecting only specified fields
        $articulosRelacionados = $query->select($selectFields)->paginate(20);
        
        return response()->json($articulosRelacionados, $this->successStatus);
    }
}
