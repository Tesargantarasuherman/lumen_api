<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\ItemFutsals;

class ItemFutsalsController extends BaseController
{
    public function index()
    {
        $tempat_futsal = ItemFutsals::orderBy('created_at', 'asc')->get();

        if ($tempat_futsal) {
            return response()->json(
                [
                    'success' => true,
                    'message' => 'tempat futsal berhasil diambil',
                    'data' => $tempat_futsal,
                ],
                201
            );
        } else {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'tempat futsal gagal diambil',
                    'data' => '',
                ],
                400
            );
        }
    }

    public function tambahTempatFutsal(Request $request)
    {
        $nama = $request->input('nama');
        $harga = $request->input('harga');
        $lokasi = $request->input('lokasi');
        $foto = $request->input('foto');


            $item_futsal = ItemFutsals::create([
                'nama' => $nama,
                'harga' => $harga,
                'lokasi' => $lokasi,
                'foto' => $foto,
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
