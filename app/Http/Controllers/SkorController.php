<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Klasemen;
use App\Tim;
use App\Turnamen;
use App\Pertandingan;
use App\PapanSkor;
use App\AnggotaTim;
use App\TopSkor;

class SkorController extends BaseController
{
    public function topSkor($id)
    {
       
    }

    public function update(Request $request)
    {
        {
            $id_pemain = $request->input('id_pemain');
            $id_tim = $request->input('id_tim');
            $id_pertandingan = $request->input('id_pertandingan');
            $waktu = $request->input('waktu');
    
            // $data_tim = Tim::where('nama_tim',$nama_tim)->first();
            $data_pertandingan = Pertandingan::where('id',$id_pertandingan)->first();

            $this->validate($request, [
                'id_tim' => 'required',
            ]);
    
            if(!$data_pertandingan){
                return response()->json([
                    'success' => false,
                    'message' => 'Pertandingan tidak ada',
                    'data'    => ''
                ],200);
            }
            else{
                    // save
                    $tim = PapanSkor::create([
                        'id_pemain' => $id_pemain,
                        'id_tim' => $id_tim,
                        'id_pertandingan' => $id_pertandingan,
                        'waktu' => $waktu,
                    ]);

                    $data = Pertandingan::where('klub_home',$id_tim)->where('id',$id_pertandingan)->first();
                    $away = Pertandingan::where('klub_away',$id_tim)->where('id',$id_pertandingan)->first();

                    if($data){
                        Pertandingan::where('klub_home',$id_tim)->where('id',$id_pertandingan)->update([
                            'skor_home' => $data['skor_home'] + 1,
                       ]);
                       return response()->json([
                        'success' => true,
                        'message' => 'Skor Home',
                        'data'    => ''
                    ],200);
                    }
                    else{
                        $data_away = Pertandingan::where('klub_away',$id_tim)->where('id',$id_pertandingan)->update([
                            'skor_away' => $away['skor_away'] + 1,
                       ]);;
                       return response()->json([
                        'success' => true,
                        'message' => 'Skor Away',
                        'data'    => ''
                    ],200);
                    }

            }
        }
    }
}
