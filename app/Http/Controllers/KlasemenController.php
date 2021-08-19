<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Klasemen;
use App\Turnamen;

class KlasemenController extends BaseController
{
    public function index($id)
    {
        $klasemen = Klasemen::where('id_turnamen', $id)
            ->orderBy('nama_klub', 'asc')
            ->orderBy('poin', 'desc')
            ->get();

            // foreach($klasemen->tunamen as $tur){
            //     $no++;
            //     $data['id_turnamen'] = $tur->nama_turnamen;
            //     array_push($data_klasemen, $data);

            // }
        $turnamen = Turnamen::where('id', $id)->first();
        $data = [];
        $data_klasemen = [];
        
        $no = 0;
        foreach ($klasemen as $kls) {
            $no++;
            $data['id_klub'] = $kls->id;
            $data['nama_turnamen'] = $kls->turnamen->nama_turnamen;
            $data['no'] = $no;
            $data['nama_klub'] = $kls->nama_klub;
            $data['poin'] = $kls->poin;
            $data['main'] = $kls->main;
            $data['menang'] = $kls->menang;
            $data['kalah'] = $kls->kalah;
            $data['imbang'] = $kls->imbang;
            array_push($data_klasemen, $data);
        }

        if ($data_klasemen) {
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Klasemen berhasil diambil',
                    'data' => [
                        'klasisfikasi_turnamen' => $turnamen->nama_turnamen,
                        'klasemen' => $data_klasemen,
                    ],
                ],
                201
            );
        } else {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Klasemen gagal diambil',
                    'data' => '',
                ],
                400
            );
        }
    }

    public function tambahKlub(Request $request)
    {
        $nama_klub = $request->input('nama_klub');
        $id_turnamen = $request->input('id_turnamen');

        $data_turnamen = Turnamen::where('id', $id_turnamen)->first();

        $data_klasemen = Klasemen::where('nama_klub', $nama_klub)
            ->where('id_turnamen', $id_turnamen)
            ->first();

        $this->validate($request, [
            'nama_klub' => 'required',
            'id_turnamen' => 'required',
        ]);

        if (!$data_turnamen) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Turnamen tidak ada',
                    'data' => '',
                ],
                400
            );
        }
        else{
            if ($data_klasemen) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Nama Klub sudah ada',
                        'data' => '',
                    ],
                    200
                );
            } else {
                $klasemen = Klasemen::create([
                    'nama_klub' => $nama_klub,
                    'id_turnamen' => $id_turnamen,
                ]);
            }

            if ($klasemen) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Nama Klub sukses di buat',
                        'data' => $klasemen,
                    ],
                    201
                );
            } else {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Nama Klub gagal di buat',
                        'data' => '',
                    ],
                    400
                );
            }
        }
    }
}
