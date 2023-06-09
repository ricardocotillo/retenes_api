<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Ccmven;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator as Validator;

class UserController extends Controller
{
  public $successStatus = 200;
  /** 
   * login api 
   * 
   * @return \Illuminate\Http\Response 
   */
  public function login()
  {
    $user = User::where('email', request('email'))->where('password', request('password'))->first();
    if ($user) {
      $ven = Ccmven::where('MNOMBRE', $user['name'])->first();
      $success = [];
      if ($ven) {
        $success = [
          'access_token'  => $user->createToken('MyApp')->accessToken,
          'role'          => $user->role,
          'assign_client' => $user->assign_client,
          'user'          => $ven,
        ];
      } else {
        $success = [
          'access_token'  => $user->createToken('MyApp')->accessToken,
          'role'          => $user->role,
          'assign_client' => $user->assign_client,
          'user'          => Ccmven::where('id', 2)->first(),
        ];
      }
      return response()->json($success);
    } else {
      return response()->json(['error' => 'Unauthorised'], 401);
    }
  }
  /** 
   * Register api 
   * 
   * @return \Illuminate\Http\Response 
   */
  public function register(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required',
      'email' => 'required|email',
      'password' => 'required',
      'c_password' => 'required|same:password',
    ]);

    if ($validator->fails()) {
      return response()->json(['error' => $validator->errors()], 401);
    }
    $input = $request->all();
    $input['password'] = bcrypt($input['password']);
    $user = User::create($input);
    $success['token'] =  $user->createToken('MyApp')->accessToken;
    $success['name'] =  $user->name;
    return response()->json(['success' => $success], $this->successStatus);
  }
  /** 
   * details api 
   * 
   * @return \Illuminate\Http\Response 
   */
  public function details()
  {
    $user = Auth::user();
    return response()->json(['success' => $user], $this->successStatus);
  }
}
