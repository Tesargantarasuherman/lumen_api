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
        $this->middleware('auth', ['only' => ['tambahLike']]);
    }
    public function index($id)
    {
        $like = Likes::where('id_artikel', $id)->count();
        if ($like) {
            return response()->json(
                [
                    'success' => true,
                    'message' => 'like sukses di ambil',
                    'data' => $like,
                ],
                201
            );
        } elseif ($like == null) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'like gagal di ambil',
                    'data' => 0,
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

        $data_like = Likes::where('id_artikel', $id_artikel)
            ->where('id_user', $id_user)
            ->first();
        if ($data_like) {
            $batal_like = $data_like->delete();
            if ($batal_like) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'like dibatalkan',
                        'data' => $batal_like,
                    ],
                    201
                );
            }
        } else {
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
                        'data' => null,
                    ],
                    400
                );
            }
        }
    }
    public function show($id, $id_user)
    {
        $like = Likes::where('id_artikel', $id)
            ->where('id_user', $id_user)
            ->first();
        if ($like) {
            return response()->json(
                [
                    'success' => true,
                    'message' => 'User Found',
                    'data' => $like,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'User Not Found',
                    'data' => null,
                ],
                200
            );
        }
    }
}
