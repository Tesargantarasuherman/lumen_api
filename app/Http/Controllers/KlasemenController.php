<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Klasemen;

class KlasemenController extends BaseController
{


    public function tambahKlub(Request $request)
    {
        $nama_klub = $request->input('nama_klub');
        $request->validate([
            'nama_klub' => 'required',
        ]);
        $klasemen = Klasemen::create([
            'nama_klub' => $nama_klub,
        ]);

        if($klasemen)
        {
            return response()->json([
                'success' => true,
                'message' => 'Nama Klub sukses di buat',
                'data'    => $klasemen
            ],201);
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'Nama Klub gagal di buat',
                'data'    => ''
            ],400);
        }
    }
}
