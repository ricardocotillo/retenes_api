<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Value;
use Illuminate\Http\Request;

class ValueController extends Controller
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
  public function store(Request $request)
  {
      //
  }

  /**
   * Store newly created resources in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function bulk_store(Request $request) {
    $data = $request->all();
    Value::insert($data);
    return response()->json($data, 200);
  }

  /**
   * Remove specified resources from storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int $mnserie
   * @param  int $mnroped
   * @return \Illuminate\Http\Response
   */
  public function bulk_delete(Request $request, int $mnserie, int $mnroped) {
    Value::where('mnserie', $mnserie)->where('mnroped', $mnroped)->delete();
    return Response::make(null, 200);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Value  $value
   * @return \Illuminate\Http\Response
   */
  public function show(Value $value)
  {
      //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Value  $value
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Value $value)
  {
      //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Value  $value
   * @return \Illuminate\Http\Response
   */
  public function destroy(Value $value)
  {
      //
  }
}
