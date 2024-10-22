<?php

namespace App\Http\Controllers\API;

use App\Models\Articulo;
use App\Models\Detpe;
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
    public function index()
    {
        $articulos = Articulo::cursorPaginate(15);
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
}
