<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Klasemen;

class KlasemenController extends BaseController
{   
    public function index()
    {
        $klasemen = Klasemen::orderBy('poin','desc')->get();

        if($klasemen)
        {
            return response()->json([
                'success' => true,
                'message' => 'Klasemen berhasil diambil',
                'data'    => $klasemen
            ],201);
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'Klasemen gagal diambil',
                'data'    => ''
            ],400);
        }
    }

    public function tambahKlub(Request $request)
    {
        $nama_klub = $request->input('nama_klub');

        $data_klasemen = Klasemen::where('nama_klub',$nama_klub)->first();

        $this->validate($request, [
            'nama_klub' => 'required',
        ]);

        if($data_klasemen){
            return response()->json([
                'success' => false,
                'message' => 'Nama Klub sudah ada',
                'data'    => ''
            ],200);
        }
        else{
            $klasemen = Klasemen::create([
                'nama_klub' => $nama_klub,
            ]);
        }


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
