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
    public function isiChat($id,$id_user)
    {   
        $chat = Chat::Where('id_chat',$id)->get();
        $aktif = [];
        $isi_chat_aktif = [];
        // $isi_chat_tidak_aktif = [];
        foreach($chat as $chat){
            if($chat->id_pengechat == $id_user ){
                $aktif['isi_chat'] = $chat->isi_chat;
                $aktif['aktif'] = true;
                $aktif['waktu'] = $chat->created_at;
                array_push($isi_chat_aktif,$aktif);
            }
            else{
                $aktif['isi_chat'] = $chat->isi_chat;
                $aktif['aktif'] = false;
                $aktif['waktu'] = $chat->created_at;
                array_push($isi_chat_aktif,$aktif);
            }
        }
        if($chat)
        {
            return response()->json([
                'success' => true,
                'message' => 'Chat berhasil ambil',
                'data' => $isi_chat_aktif
                // 'data'    =>[
                //     'aktif'=>$isi_chat_aktif,
                //     'tidak_aktif'=>$isi_chat_tidak_aktif,
                //     ] 

            ],201);
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'Chat gagal ambil',
                'data'    => ''
            ],400);
        }
    }

}
