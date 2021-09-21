<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Chat;

class ChatController extends BaseController
{
    public function tambahChat(Request $request)
    {   
        $id_pengechat = $request->input('email_pengechat');
        $isi_chat = $request->input('isi_chat');
        $id_yangdichat = $request->input('email_yangdichat');

        $chat = Chat::create([
            'id_pengechat' => $id_pengechat,
            'isi_chat' => $isi_chat,
            'id_yangdichat' => $id_yangdichat,
        ]);

        if($chat)
        {
            return response()->json([
                'success' => true,
                'message' => 'Chat berhasil dikirim',
                'data'    => $chat
            ],201);
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'Chat gagal dikirim',
                'data'    => ''
            ],400);
        }
    }

}
