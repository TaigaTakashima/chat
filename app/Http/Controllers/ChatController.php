<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Chat;

use GuzzleHttp\Client;
use Carbon\Carbon;


class ChatController extends Controller
{
    public function index(){
        // DBよりChatテーブルの値を全て取得
        $chats = Chat::all();

        // 取得した値をビュー「chat/index」に渡す
        return view('chat/index', compact('chats'));


    }
    public function store(Request $request)
    {
        //
        $url = "https://api.a3rt.recruit-tech.co.jp/talk/v1/smalltalk";
        $method = "POST";
        $apiKey = 'DZZguc3SP1scbDPtiuHk0ditTEnh1FKM';
        $msg = $request->message;
        \DB::table('chat')->insert([
            'from_id' => 0,
            'chats' => $msg,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        //接続
        $client = new Client();

        $response = $client->request($method, $url, ['form_params' => ['apikey' => $apiKey,'query' => $msg]]);
        $posts = $response->getBody();
        $posts = json_decode($posts, true);

        \DB::table('chat')->insert([
            'from_id' => 1,
            'chats' => $posts['results']['0']['reply'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        return redirect('/chat');

    }
    public function deleteall(){
        \DB::table('chat')->delete();

        return redirect('/chat');

    }
}
