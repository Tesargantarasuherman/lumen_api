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
       
    }

    public function tambahTim(Request $request)
    {
        {
            $nama_tim = $request->input('nama_tim');
    
            $data_tim = Tim::where('nama_tim',$nama_tim)->first();

            $this->validate($request, [
                'nama_tim' => 'required',
            ]);
    
            if($data_tim){
                return response()->json([
                    'success' => false,
                    'message' => 'Nama Turnamen sudah ada',
                    'data'    => ''
                ],200);
            }
            else{
                if($request->file('logo_tim')){
                    $file = $request->file('logo_tim');
                    $filename = time().'.'.$file->getClientOriginalExtension();

                    $file->move('uploads',$filename);
                    // save
                    $tim = Tim::create([
                        'nama_tim' => $nama_tim,
                        'logo_tim' => $filename,
                    ]);
                }

            }
    
    
            if($tim)
            {
                return response()->json([
                    'success' => true,
                    'message' => 'Nama Turnamen sukses di buat',
                    'data'    => $tim
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
}
