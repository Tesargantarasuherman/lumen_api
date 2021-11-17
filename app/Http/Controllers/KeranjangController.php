<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Keranjangs;
use App\JadwalFutsals;
use App\ItemFutsals;

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

    public function tambahKeranjang(Request $request,$user_id,$futsal_id)
    {
        $id_futsal = $futsal_id;
        $id_user = $user_id;
        $tanggal = $request->input('tanggal');
        $jam = $request->input('jam');
        $jadwal_futsal = JadwalFutsals::where('id_futsal',$futsal_id)->where('tanggal',$tanggal)->where('jam',$jam)->first();
        $harga = ItemFutsals::where('id',$futsal_id)->first();

            if($jadwal_futsal->status == ""){
                $item_futsal = Keranjangs::create([
                    'id_futsal' => $id_futsal,
                    'id_user' => $id_user,
                    'harga' => $harga->harga,
                    'tanggal' => $tanggal,
                    'jam' => $jam,
                ]); 
                JadwalFutsals::where('id_futsal',$futsal_id)->where('tanggal',$tanggal)->where('jam',$jam)->update([
                    'status' => 'booked',
                ]);
            } else {
                    return response()->json(
                        [
                            'success' => false,
                            'message' => 'Tempat Futsal Sudah di Booking',
                            'data' => $jadwal_futsal,
                        ],
                        400
                    );
            }

            if ($item_futsal) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Tempat Futsal sukses di Masukkan Ke Keranjang',
                        'data' => $jadwal_futsal,
                    ],
                    201
                );
            } else {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Tempat Futsal gagal di Masukkan Ke Keranjang',
                        'data' => '',
                    ],
                    400
                );
            }
        }
}
