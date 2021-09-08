<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Artikel;

class ArtikelController extends BaseController
{
    public function index()
    {
        $artikel = Artikel::orderBy('created_at', 'asc')->get();

        if ($artikel) {
            return response()->json(
                [
                    'success' => true,
                    'message' => 'artikel berhasil diambil',
                    'data' => $artikel,
                ],
                201
            );
        } else {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'artikel gagal diambil',
                    'data' => '',
                ],
                400
            );
        }
    }

    public function tambahArtikel(Request $request)
    {
            $id_penulis = $request->input('id_penulis');
            $judul = $request->input('judul');
            $deskripsi = $request->input('deskripsi');
            $id_kategori = $request->input('id_kategori');
    
            $data_artikel = Artikel::where('judul',$judul)->first();

            $this->validate($request, [
                'id_penulis' => 'required',
            ]);
    
            if($data_artikel){
                return response()->json([
                    'success' => false,
                    'message' => 'Artikel sudah ada',
                    'data'    => ''
                ],200);
            }
            else{
                    $artikel = Artikel::create([
                        'id_penulis' => $id_penulis,
                        'judul' => $judul,
                        'deskripsi' => $deskripsi,
                        'id_kategori' => $id_kategori,
                    ]);

            }
    
    
            if($artikel)
            {
                return response()->json([
                    'success' => true,
                    'message' => 'Artikel sukses di buat',
                    'data'    => $artikel
                ],201);
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Artikel gagal di buat',
                    'data'    => ''
                ],400);
            }
    }
    public function detailArtikel($id)
    {
        $data_artikel = Artikel::where('id',$id)->get();
        $data = [];
        $res_artikel= [];

        foreach ($data_artikel as $artikel) {
            $data['judul'] = $artikel->judul;
            $data['deskripsi'] = $artikel->deskripsi;
            $data['tanggal'] = $artikel->created_at;
            array_push($res_artikel, $data);
        }

        if($data_artikel)
        {
            return response()->json([
                'success' => true,
                'message' => 'Artikel sukses di panggil',
                'data'    => [
                    'data'=>$res_artikel
                ]
            ],201);
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'Artikel gagal di panggil',
                'data'    => ''
            ],400);
        }
    }
}
