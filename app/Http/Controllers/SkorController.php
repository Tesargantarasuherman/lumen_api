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
            $id_turnamen = $request->input('id_turnamen');
            $waktu = $request->input('waktu');
    
            $data_pertandingan = Pertandingan::where('id',$id_pertandingan)->first();
            $tabel_top_skor = TopSkor::all();
            
            $count_tabel_top_skor = count($tabel_top_skor);
            if($count_tabel_top_skor > 0){
                $data_top_skor = TopSkor::where('id_pemain',$id_pemain)->first();
            }

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
                    if(isset($data_top_skor)){
                        TopSkor::where('id_pemain',$id_pemain)->update([
                            'jumlah_gol' => $data_top_skor['jumlah_gol'] + 1,
                       ]);
                    }
                    else{
                        $tabelSkor = TopSkor::create([
                            'id_pemain' => $id_pemain,
                            'id_tim' => $id_tim,
                            'id_turnamen' => $id_turnamen,
                            'jumlah_gol' => 1,
                        ]);
                    }

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
