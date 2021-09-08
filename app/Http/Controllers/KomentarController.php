<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Comentars;

class KomentarController extends BaseController
{
    public function index($id)
    {
        $komentar = Comentars::where('id_artikel', $id)->orderBy('created_at', 'desc')->get();
        $data = [];
        $res_komentar= [];

        foreach ($komentar as $komentar) {
            $data['artikel'] = $komentar->artikel->judul;
            $data['user'] = $komentar->pengguna->name;
            $data['isi'] = $komentar->isi;
            array_push($res_komentar, $data);
        }

        if ($komentar) {
            return response()->json(
                [
                    'success' => true,
                    'message' => 'komentar berhasil diambil',
                    'data' => $res_komentar,
                ],
                201
            );
        } else {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'komentar gagal diambil',
                    'data' => '',
                ],
                400
            );
        }
    }

    public function tambahKomentar(Request $request)
    {
        $id_artikel = $request->input('id_artikel');
        $id_user = $request->input('id_user');
        $isi = $request->input('isi');

        $this->validate($request, [
            'isi' => 'required',
        ]);
        $komentar = Comentars::create([
            'id_artikel' => $id_artikel,
            'id_user' => $id_user,
            'isi' => $isi,
        ]);
        if ($komentar) {
            return response()->json(
                [
                    'success' => true,
                    'message' => 'komentar sukses di buat',
                    'data' => $komentar,
                ],
                201
            );
        } else {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'komentar gagal di buat',
                    'data' => '',
                ],
                400
            );
        }
    }
}
