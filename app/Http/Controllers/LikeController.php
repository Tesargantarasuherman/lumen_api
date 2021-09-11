<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Artikel;
use App\Likes;

class LikeController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth',['only' =>['tambahLike']]);
    }
    public function index($id)
    {
        $like = Likes::where('id_artikel',$id)->count();
        if ($like) {
            return response()->json(
                [
                    'success' => true,
                    'message' => 'like sukses di ambil',
                    'data' => $like,
                ],
                201
            );
        } else {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'like gagal di ambil',
                    'data' => '',
                ],
                400
            );
        }
    }

    public function tambahLike(Request $request)
    {
        $id_user = $request->input('id_user');
        $id_artikel = $request->input('id_artikel');

        $data_like = Likes::where('id_artikel',$id_artikel)->orWhere('id_user',$id_user)->get();
        if($data_like){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'like gagal di buat',
                    'data' => '',
                ],
                400
            );
        }
        else{
            $like = Likes::create([
                'id_user' => $id_user,
                'id_artikel' => $id_artikel,
            ]);
            if ($like) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'like sukses di buat',
                        'data' => $like,
                    ],
                    201
                );
            } else {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'like gagal di buat',
                        'data' => '',
                    ],
                    400
                );
            }

        }

        
    }
}
