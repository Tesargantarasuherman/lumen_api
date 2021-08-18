<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Pertandingan;

class PertandinganController extends BaseController
{


    public function tambahPertandingan(Request $request)
    {
        $klub_home = $request->input('klub_home');
        $klub_away = $request->input('klub_away');
        $waktu_pertandingan = $request->input('waktu_pertandingan');
        $this->validate($request, [
            'klub_home' => 'required',
            'klub_away' => 'required',
            'waktu_pertandingan' => 'required',
        ]);
        $pertandingan = Pertandingan::create([
            'klub_home' => $klub_home,
            'klub_away' => $klub_away,
            'waktu_pertandingan' => $waktu_pertandingan,
        ]);

        if($pertandingan)
        {
            return response()->json([
                'success' => true,
                'message' => 'Pertandingan sukses di buat',
                'data'    => $pertandingan
            ],201);
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'Pertandingan gagal di buat',
                'data'    => ''
            ],400);
        }
    }

    public function updatePertandingan($id)
    {
        $klub_home = $request->input('klub_home');
        $klub_away = $request->input('klub_away');
        $waktu_pertandingan = $request->input('waktu_pertandingan');
        $this->validate($request, [
            'klub_home' => 'required',
            'klub_away' => 'required',
            'waktu_pertandingan' => 'required',
        ]);
        $pertandingan = Pertandingan::create([
            'klub_home' => $klub_home,
            'klub_away' => $klub_away,
            'waktu_pertandingan' => $waktu_pertandingan,
        ]);

        if($pertandingan)
        {
            return response()->json([
                'success' => true,
                'message' => 'Pertandingan sukses di buat',
                'data'    => $pertandingan
            ],201);
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'Pertandingan gagal di buat',
                'data'    => ''
            ],400);
        }
    }
}
