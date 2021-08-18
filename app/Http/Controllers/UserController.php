<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\User;

class UserController extends BaseController
{
    public function __construct()
    {
        $this->middleware('aut',['only' =>['show']]);
    }

    public function show(Request $request)
    {

    }
}
