<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Klasemen;

class KlasemenController extends BaseController
{


    public function tambahTim(Request $request)
    {
        $nama_klub = $request->input('nama_klub');
    }
}
