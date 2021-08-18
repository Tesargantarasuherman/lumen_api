<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Pertandingan;
use App\Klasemen;

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

    public function updatePertandingan(Request $request,$id)
    {
        $data_pertandingan = Pertandingan::where('id',$id)->first();

        $skor_home = $request->input('skor_home');
        $skor_away = $request->input('skor_away');
        $this->validate($request, [
            'skor_home' => 'required',
            'skor_away' => 'required',
        ]);


        // cek skor
        if($data_pertandingan['status'] != 1 ){
            $data_home_klub = Klasemen::where('id',$data_pertandingan['klub_home'])->first();
            $data_away_klub = Klasemen::where('id',$data_pertandingan['klub_away'])->first();

            // update point
            if($skor_home > $skor_away){

                $home_klub = Klasemen::where('id',$data_pertandingan['klub_home'])->update([
                    'poin'     => $data_home_klub['poin'] + 3,
                    'main'     => $data_home_klub['main'] + 1,
                    'menang'     => $data_home_klub['menang'] + 1,
                ]);
                $away_klub = Klasemen::where('id',$data_pertandingan['klub_away'])->update([
                    'kalah'     => $data_away_klub['kalah'] + 1,
                    'main'     => $data_away_klub['main'] + 1,
                ]);
            }
            else if($skor_home < $skor_away){
    
                $away_klub = Klasemen::where('id',$data_pertandingan['klub_away'])->update([
                    'poin'     => $data_away_klub['poin'] + 3,
                    'main'     => $data_away_klub['main'] + 1,
                    'menang'     => $data_away_klub['menang'] + 1,
                ]);

                $home_klub = Klasemen::where('id',$data_pertandingan['klub_home'])->update([
                    'kalah'     => $data_home_klub['kalah'] + 1,
                    'main'     => $data_home_klub['main'] + 1,
                ]);
            }
            else{
                $away_klub = Klasemen::where('id',$data_pertandingan['klub_away'])->update([
                    'poin'     => $data_away_klub['poin'] + 1,
                    'main'     => $data_away_klub['main'] + 1,
                ]);

                $home_klub = Klasemen::where('id',$data_pertandingan['klub_home'])->update([
                    'poin'     => $data_home_klub['poin'] + 1,
                    'main'     => $data_away_klub['main'] + 1,
                ]);

            }
            // end update point           
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'Pertandingan telah selesai',
                'data'    => $data_pertandingan
            ],201);
        }

        // end cek skor


        // end update klasemen
        $pertandingan = Pertandingan::whereId($id)->update([
            'skor_home'     => $skor_home,
            'skor_away'   => $skor_away,
            'status'   => 1,
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
