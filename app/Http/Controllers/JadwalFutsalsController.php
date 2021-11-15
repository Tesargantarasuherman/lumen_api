<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\JadwalFutsals;

class JadwalFutsalsController extends BaseController
{
    public function index($idFutsal,$tanggal)
    {
        $jadwal_futsal = JadwalFutsals::where('id_futsal',$idFutsal)->where('tanggal',$tanggal)->orderBy('jam', 'asc')->get();
        $data_futsal = [];
        $res_data_futsal = [];
        $jadwal_futsal_belum_di_booking = [
                "id_futsal" => "1",
                "tanggal"=> "2021-11-10",
                "jam" => "14",
                "status"=> null,
            
        ];
        for($i = 1 ;$i<=31 ;$i++){
            // foreach($jadwal_futsal as $jadwal){
                if(intval($jadwal_futsal[$i]->jam) == $i){
                    // $data_futsal['jam'] =  intval($jadwal_futsal[$i]->jam);
                    // // $data_futsal['status'] = $jadwal->status;
                    // array_push($res_data_futsal,$data_futsal);
                }

            // }
            $data_futsal['jam'] = $i;
            $data_futsal['status'] =null;
            array_push($res_data_futsal,$data_futsal);

        }
        $jadwal_futsal;
        if ($jadwal_futsal) {
            return response()->json(
                [
                    'success' => true,
                    'message' => 'tempat futsal berhasil diambil',
                    'data' => $res_data_futsal,
                ],
                201
            );
        } else {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'tempat futsal gagal diambil',
                    'data' => '',
                ],
                400
            );
        }
    }

    public function tambahJadwalFutsal(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $id_futsal = $request->input('id_futsal');
        $status = $request->input('status');
        $jam = $request->input('jam');


            $jadwal_futsal = JadwalFutsals::create([
                'tanggal' => $tanggal,
                'id_futsal' => $id_futsal,
                'status' => $status,
                'jam' => $jam,
            ]);

            if ($jadwal_futsal) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Jadwal Futsal sukses di buat',
                        'data' => $jadwal_futsal,
                    ],
                    201
                );
            } else {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Jadwal Futsal gagal di buat',
                        'data' => '',
                    ],
                    400
                );
            }
        }
}
