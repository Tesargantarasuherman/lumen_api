<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Turnamen;

class TurnamenController extends BaseController
{
    public function index()
    {
        $turnamen = Turnamen::orderBy('nama_turnamen', 'asc')->paginate(1);
        if ($turnamen) {
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Turnamen berhasil diambil',
                    'data' => $turnamen,
                ],
                201
            );
        } else {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Turnamen gagal diambil',
                    'data' => '',
                ],
                400
            );
        }
    }
    public function tambahTurnamen(Request $request)
    {
        $nama_turnamen = $request->input('nama_turnamen');

        $data_turnamen = Turnamen::where('nama_turnamen',$nama_turnamen)->first();

        $this->validate($request, [
            'nama_turnamen' => 'required',
        ]);

        if($data_turnamen){
            return response()->json([
                'success' => false,
                'message' => 'Nama Turnamen sudah ada',
                'data'    => ''
            ],200);
        }
        else{
            $turnamen = Turnamen::create([
                'nama_turnamen' => $nama_turnamen,
            ]);
        }


        if($turnamen)
        {
            return response()->json([
                'success' => true,
                'message' => 'Nama Turnamen sukses di buat',
                'data'    => $turnamen
            ],201);
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'Nama Turnamen gagal di buat',
                'data'    => ''
            ],400);
        }
    }

}
