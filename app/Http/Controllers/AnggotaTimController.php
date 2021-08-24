<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Klasemen;
use App\AnggotaTim;
use App\Turnamen;

class AnggotaTimController extends BaseController
{
    public function index($id)
    {
       
    }

    public function tambahAnggotaTim(Request $request)
    {
        {
            $id_tim = $request->input('id_tim');
            $nama_pemain = $request->input('nama_pemain');
            $no_punggung = $request->input('no_punggung');
            $posisi = $request->input('posisi');
            $status = $request->input('status');
    
            $data_tim = AnggotaTim::where('nama_pemain',$nama_pemain)->first();

            $this->validate($request, [
                'nama_pemain' => 'required',
            ]);
    
            if($data_tim){
                return response()->json([
                    'success' => false,
                    'message' => 'Anggota Tim sudah ada',
                    'data'    => ''
                ],200);
            }
            else{
                    // save
                    $anggota_tim = AnggotaTim::create([
                        'nama_pemain' => $nama_pemain,
                        'id_tim' => $id_tim,
                        'no_punggung' => $no_punggung,
                        'posisi' => $posisi,
                        'status' => $status,
                    ]);

            }
    
    
            if($anggota_tim)
            {
                return response()->json([
                    'success' => true,
                    'message' => 'Anggota Tim sukses ditambahkan',
                    'data'    => $anggota_tim
                ],201);
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Anggota Tim gagal ditambahkan',
                    'data'    => ''
                ],400);
            }
        }
    }
}
