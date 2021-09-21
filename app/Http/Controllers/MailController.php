<?php

namespace App\Http\Controllers;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
class MailController  extends BaseController
{
public function mail() {
  Mail::send('hallo',function ($mes){
      $mes->to('gantarasuherman@gmail.com','Tesar');
      $mes->to('dafatr');
  });
}
}