<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Pertandingan;
use App\Klasemen;
use App\Turnamen;
use App\PapanSkor;

class PertandinganController extends BaseController
{
    public function index($id)
    {
        $pertandingan = Pertandingan::where('id_turnamen', $id)
            ->where('status', 0)->orWhere('status', 1)
            ->orderBy('waktu_pertandingan', 'asc')
            ->get();
        $data = [];
        $data_pertandingan = [];
        // $pertandingan = [];
        // $res_pertandingan = [];
        // $turna = [];
        // $turnamens = Turnamen::all();

        // foreach ($turnamens as $tur) {
        //     $pert = Pertandingan::where('id_turnamen', $tur->id)->get();

        //     foreach ($pert as $per) {
        //             $data['klub_turnamen'] = $per->turnamen->nama_turnamen;
        //             $data['klub_home'] = $per->klubHome->nama_klub;
        //             $data['klub_away'] = $per->klubAway->nama_klub;
        //             $data['skor_home'] = $per->skor_home;
        //             $data['skor_away'] = $per->skor_away;
        //             $data['waktu_pertandingan'] = $per->waktu_pertandingan;
        //             array_push($data_pertandingan, $data);
        //     }

        // }



        // array_push($res_pertandingan, $data_pertandingan);

        foreach($pertandingan as $per){
            $data['klub_turnamen'] = $per->turnamen->nama_turnamen;
            $data['klub_home'] = $per->klubHome->nama_tim;
            $data['logo_home'] = $per->klubHome->logo_tim;
            $data['klub_away'] = $per->klubAway->nama_tim;
            $data['logo_away'] = $per->klubAway->logo_tim;
            $data['skor_home'] = $per->skor_home;
            $data['skor_away'] = $per->skor_away;
            $data['waktu_pertandingan'] = $per->waktu_pertandingan;
            $data['tanggal_pertandingan'] = $per->tanggal_pertandingan;
            $data['lokasi_pertandingan'] = $per->lokasi_pertandingan;

            array_push($data_pertandingan, $data);
        }

        if ($data_pertandingan) {
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Pertandingan berhasil diambil',
                    'data' => $data_pertandingan,
                ],
                201
            );
        } else {
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Pertandingan gagal diambil',
                    'data' => null,
                ],
                200
            );
        }
    }
    public function hasilPertandingan($id)
    {
        $pertandingan = Pertandingan::where('id', $id)
            ->where('status', 2)
            ->orderBy('waktu_pertandingan', 'asc')
            ->get();
        $skor = PapanSkor::where('id_pertandingan', $id)
            ->get();

        $data = [];
        $data_pertandingan = [];
        $pencetak_gol_home =[];
        $res_pencetak_gol_home =[];
        $pencetak_gol_away =[];
        $res_pencetak_gol_away =[];

        foreach ($pertandingan as $per) {
            $data['klub_turnamen'] = $per->turnamen->nama_turnamen;
            $data['klub_home'] = $per->klubHome->nama_tim;
            $data['logo_home'] = $per->klubHome->logo_tim;
            $data['klub_away'] = $per->klubAway->nama_tim;
            $data['logo_away'] = $per->klubAway->logo_tim;
            $data['skor_home'] = $per->skor_home;
            $data['skor_away'] = $per->skor_away;
            $data['waktu_pertandingan'] = $per->waktu_pertandingan;
            $data['tanggal_pertandingan'] = $per->tanggal_pertandingan;
            $data['lokasi_pertandingan'] = $per->lokasi_pertandingan;

            foreach($skor as $skor){
                if($skor->pemain->id_tim == $per->klubHome->id){
                    $pencetak_gol_home['nama'] =  $skor->pemain->nama_pemain;
                    $pencetak_gol_home['id'] =  $skor->pemain->id_tim;
                    array_push($res_pencetak_gol_home, $pencetak_gol_home);
                }else{
                    $pencetak_gol_away['nama'] =  $skor->pemain->nama_pemain;
                    $pencetak_gol_away['id'] =  $skor->pemain->id_tim;
                    array_push($res_pencetak_gol_away, $pencetak_gol_away);
                }
            }

            array_push($data_pertandingan, $data);
        }
        if ($data_pertandingan) {
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Hasil Pertandingan berhasil diambil',
                    'data' => [
                     'data' =>  $data_pertandingan,
                     'pencetak gol_home' =>$res_pencetak_gol_home,
                     'pencetak gol_away' =>$res_pencetak_gol_away,
                    ]
                ],
                201
            );
        } else {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Hasil Pertandingan gagal diambil',
                    'data' => '',
                ],
                400
            );
        }
    }
    public function tambahPertandingan(Request $request)
    {
        $klub_home = $request->input('klub_home');
        $klub_away = $request->input('klub_away');

        $data_home_klub = Klasemen::where('id', $klub_home)->first();
        $data_away_klub = Klasemen::where('id', $klub_away)->first();
        if (!$data_home_klub || !$data_away_klub) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'id tidak ada',
                    'data' => '',
                ],
                400
            );
        } else {
            if ($klub_home == $klub_away) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'id tidak home dan away boleh sama',
                        'data' => '',
                    ],
                    400
                );
            }
            if (
                $data_home_klub['id_turnamen'] == $data_away_klub['id_turnamen']
            ) {
                $waktu_pertandingan = $request->input('waktu_pertandingan');
                $tanggal_pertandingan = $request->input('tanggal_pertandingan');
                $lokasi_pertandingan = $request->input('lokasi_pertandingan');

                $this->validate($request, [
                    'klub_home' => 'required',
                    'klub_away' => 'required',
                    'waktu_pertandingan' => 'required',
                    'tanggal_pertandingan' => 'required',
                    'lokasi_pertandingan' => 'required',
                ]);
                $pertandingan = Pertandingan::create([
                    'klub_home' => $klub_home,
                    'klub_away' => $klub_away,
                    'waktu_pertandingan' => $waktu_pertandingan,
                    'tanggal_pertandingan' => $tanggal_pertandingan,
                    'lokasi_pertandingan' => $lokasi_pertandingan,
                    'id_turnamen' => $data_home_klub['id_turnamen'],
                ]);

                if ($pertandingan) {
                    return response()->json(
                        [
                            'success' => true,
                            'message' => 'Pertandingan sukses di buat',
                            'data' => $pertandingan,
                        ],
                        201
                    );
                } else {
                    return response()->json(
                        [
                            'success' => false,
                            'message' => 'Pertandingan gagal di buat',
                            'data' => '',
                        ],
                        400
                    );
                }
            } else {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'id tidak dalam turnamen yang sama',
                        'data' => '',
                    ],
                    400
                );
            }
        }
    }

    public function updatePertandingan(Request $request, $id)
    {
        $data_pertandingan = Pertandingan::where('id', $id)->first();

        $skor_home = $data_pertandingan['skor_home'];
        $skor_away = $data_pertandingan['skor_away'];

        // cek skor
        if ($data_pertandingan['status'] != 2) {
            // ambil data klasemen
            $data_home_klub = Klasemen::where(
                'id',
                $data_pertandingan['klub_home']
            )->first();
            $data_away_klub = Klasemen::where(
                'id',
                $data_pertandingan['klub_away']
            )->first();


            // tim kandang menang
            if ($skor_home > $skor_away) {
                $home_klub = Klasemen::where(
                    'id',
                    $data_pertandingan['klub_home']
                )->update([
                    'poin' => $data_home_klub['poin'] + 3,
                    'main' => $data_home_klub['main'] + 1,
                    'menang' => $data_home_klub['menang'] + 1,
                    'gol_kemasukan' => $data_home_klub['gol_kemasukan'] + $skor_away,
                    'gol_memasukan' => $data_home_klub['gol_memasukan'] + $skor_home,
                ]);
                $away_klub = Klasemen::where(
                    'id',
                    $data_pertandingan['klub_away']
                )->update([
                    'kalah' => $data_away_klub['kalah'] + 1,
                    'main' => $data_away_klub['main'] + 1,
                    'gol_kemasukan' => $data_away_klub['gol_kemasukan'] + $skor_home,
                    'gol_memasukan' => $data_away_klub['gol_memasukan'] + $skor_away,
                ]);
            }
            // tim tamu menang
            elseif ($skor_home < $skor_away) {
                $away_klub = Klasemen::where(
                    'id',
                    $data_pertandingan['klub_away']
                )->update([
                    'poin' => $data_away_klub['poin'] + 3,
                    'main' => $data_away_klub['main'] + 1,
                    'menang' => $data_away_klub['menang'] + 1,
                    'gol_kemasukan' => $data_away_klub['gol_kemasukan'] + $skor_home,
                    'gol_memasukan' => $data_away_klub['gol_memasukan'] + $skor_away,
                ]);

                $home_klub = Klasemen::where(
                    'id',
                    $data_pertandingan['klub_home']
                )->update([
                    'kalah' => $data_home_klub['kalah'] + 1,
                    'main' => $data_home_klub['main'] + 1,
                    'gol_kemasukan' => $data_home_klub['gol_kemasukan'] + $skor_away,
                    'gol_memasukan' => $data_home_klub['gol_memasukan'] + $skor_home,
                ]);
            }
            // imbang
            elseif ($skor_home == $skor_away) {
                $away_klub = Klasemen::where(
                    'id',
                    $data_pertandingan['klub_away']
                )->update([
                    'poin' => $data_away_klub['poin'] + 1,
                    'main' => $data_away_klub['main'] + 1,
                    'imbang' => $data_away_klub['imbang'] + 1,
                    'gol_kemasukan' => $data_away_klub['gol_kemasukan'] + $skor_home,
                    'gol_memasukan' => $data_away_klub['gol_memasukan'] + $skor_away,
                ]);

                $home_klub = Klasemen::where(
                    'id',
                    $data_pertandingan['klub_home']
                )->update([
                    'poin' => $data_home_klub['poin'] + 1,
                    'main' => $data_home_klub['main'] + 1,
                    'imbang' => $data_home_klub['imbang'] + 1,
                    'gol_kemasukan' => $data_home_klub['gol_kemasukan'] + $skor_away,
                    'gol_memasukan' => $data_home_klub['gol_memasukan'] + $skor_home,
                ]);
            }

            // end update point
        } else {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Pertandingan telah selesai',
                    'data' => $data_pertandingan,
                ],
                201
            );
        }

        // end cek skor

        // end update klasemen
        $pertandingan = Pertandingan::whereId($id)->update([
            'skor_home' => $skor_home,
            'skor_away' => $skor_away,
            'status' => 2,
        ]);

        if ($pertandingan) {
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Pertandingan sukses di buat',
                    'data' => $pertandingan,
                ],
                201
            );
        } else {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Pertandingan gagal di buat',
                    'data' => '',
                ],
                400
            );
        }
    }
}
