<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Klasemen;
use App\Tim;
use App\Turnamen;

class TimController extends BaseController
{
    public function index($id)
    {
        $data_tim = Tim::where('id_user', $id)->first();

        if ($data_tim) {
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Tim Berhasil Dipanggil',
                    'data' => $data_tim,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Nama Tim Tidak Ada',
                    'data' => '',
                ],
                200
            );
        }    }

    public function tambahTim(Request $request)
    {
        $nama_tim = $request->input('nama_tim');
        $id_user = $request->input('id_user');
        
        $data_tim = Tim::where('nama_tim', $nama_tim)->first();

        $this->validate($request, [
            'nama_tim' => 'required',
            'logo_tim' => 'required',
        ]);

        if ($data_tim) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Nama Tim sudah ada',
                    'data' => '',
                ],
                200
            );
        } else {
            if ($request->hasFile('logo_tim')) {
                $file = $request->file('logo_tim');
                $filename = time() . '.' . $file->getClientOriginalExtension();

                $file->move('uploads', $filename);
                // save
                $tim = Tim::create([
                    'nama_tim' => $nama_tim,
                    'id_user' => $id_user,
                    'logo_tim' => $file !== null ? $filename : 'default.jpg',
                ]);
            }
        }

        if ($tim) {
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Nama Tim sukses di buat',
                    'data' => $tim,
                ],
                201
            );
        } else {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Nama Tim gagal di buat',
                    'data' => '',
                ],
                400
            );
        }
    }
}
