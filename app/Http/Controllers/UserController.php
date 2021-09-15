<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\User;

class UserController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth',['only' =>['show']]);
    }

    public function show($id)
    {
        $user = User::where('id',$id)->orWhere('provider_id',$id)->first();

        if($user){
            return response()->json([
                'success' => true,
                'message' => 'User Found',
                'data' => $user
            ],200);
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'User Not Found',
                'data' => ''
            ],404);
        }
    }
    public function cari(Request $request)
    {
        $email = $request->input('email');
        $user = User::where('email',$email)->first();

        if($user){
            return response()->json([
                'success' => true,
                'message' => 'User Found',
                'data' => $user
            ],200);
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'User Not Found',
                'data' => ''
            ],200);
        }
    }
}
