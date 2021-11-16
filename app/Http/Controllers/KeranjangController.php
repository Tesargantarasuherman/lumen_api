<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Keranjangs;

class KeranjangController extends BaseController
{
    public function index()
    {
        $keranjangs = Keranjangs::orderBy('created_at', 'asc')->get();

        if ($keranjangs) {
            return response()->json(
                [
                    'success' => true,
                    'message' => 'keranjang berhasil diambil',
                    'data' => $keranjangs,
                ],
                201
            );
        } else {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'keranjang gagal diambil',
                    'data' => '',
                ],
                400
            );
        }
    }

    public function tambahTempatFutsal(Request $request)
    {
        $id_futsal = $request->input('id_futsal');
        $id_user = $request->input('id_user');
        $tanggal = $request->input('tanggal');
        $jam = $request->input('jam');


            $item_futsal = Keranjangs::create([
                'id_futsal' => $id_futsal,
                'id_user' => $id_user,
                'tanggal' => $tanggal,
                'jam' => $jam,
            ]);

            if ($item_futsal) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Tempat Futsal sukses di buat',
                        'data' => $item_futsal,
                    ],
                    201
                );
            } else {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Tempat Futsal gagal di buat',
                        'data' => '',
                    ],
                    400
                );
            }
        }
}
