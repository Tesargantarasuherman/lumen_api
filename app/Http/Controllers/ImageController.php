<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Tim;

class ImageController extends BaseController
{
   function logoTim($imageName)
    {
        $imagePath = ('uploads').'/'.$imageName ;

        if(file_exists($imagePath)){
            $file = file_get_contents($imagePath);
            return response($file, 200);
        }
        else{
            return response()->json([
                'success' => false,
                'message' => $imagePath,
            ],401);
        }
    }
}
