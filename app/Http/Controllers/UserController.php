<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;

class UserController extends Controller
{
  public function all()
  {
    try{
      $users = User::all();
      return response()->json([ 
        "data" => $users,
        "sucess" => true,
        "message" => 'Users retrieved successfully',
      ], 200);
    } catch (Exception $e) {
      return response()->json([ 
        "data" => null,
        "sucess" => false,
        "message" => $e->getMessage(),
      ], $e->getCode());
    }
  }

  public function find(Request $request)
  {
    try{
      $id = $request->get('id');
      if ($id === null) {
        throw new Exception('id query parameter must be passed', 400);
      }

      $user = User::find($request->get('id'));

      if ($user === null) {
        throw new Exception('User with id ' . $id . ' was not found', 400);
      }

      return response()->json([ 
        "data" => $user,
        "sucess" => true,
        "message" => 'User retrieved successfully',
      ], 200);
    } catch (Exception $e) {
      return response()->json([ 
        "data" => null,
        "sucess" => false,
        "message" => $e->getMessage(),
      ], $e->getCode());
    }
  }
}
