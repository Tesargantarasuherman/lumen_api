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
        $id_pengechat = $request->input('id_pengechat');
        $isi_chat = $request->input('isi_chat');
        $id_yangdichat = $request->input('id_yangdichat');
        $id_chat = $request->input('id_chat');

        $chat = Chat::create([
            'id_pengechat' => $id_pengechat,
            'isi_chat' => $isi_chat,
            'id_yangdichat' => $id_yangdichat,
            'id_chat' => $id_chat,
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
    public function isiChat(Request $request)
    {   
        $id_pengechat = $request->input('id_pengechat');
        $id_yangdichat = $request->input('id_yangdichat');

        $chat = Chat::Where('id_pengechat',$id_pengechat)->Where('id_pengechat',$id_yangdichat)->orderBy('created_at', 'ASC')->get();

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
