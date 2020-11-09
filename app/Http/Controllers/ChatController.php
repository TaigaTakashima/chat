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
        $url = "https://api.a3rt.recruit-tech.co.jp/talk/v1/smalltalk";//APIURL
        $method = "POST";
        $apiKey = 'DZZguc3SP1scbDPtiuHk0ditTEnh1FKM';//APIkey
        $msg = $request->message;//入力内容を取得
        //メッセージが未入力の場合リダイレクト
        if($msg == "" || ctype_space($msg)){
            return redirect('/chat');
        }
        //入力したチャット内容をインサート
        \DB::table('chat')->insert([
            'from_id' => 0,
            'chats' => $msg,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        //API接続
        $client = new Client();
        $response = $client->request($method, $url, ['form_params' => ['apikey' => $apiKey,'query' => $msg]]);
        $posts = $response->getBody();
        $posts = json_decode($posts, true);
        //チャット内容インサート
        \DB::table('chat')->insert([
            'from_id' => 1,
            'chats' => $posts['results']['0']['reply'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        //chatにリダイレクト
        return redirect('/chat');
    }

    public function deleteall(){
        //チャット内容リセット
        \DB::table('chat')->delete();
        //idのオートインクリメントをリセット
        $sql = "ALTER TABLE chat AUTO_INCREMENT = 1";
        \DB::unprepared($sql);
        //リダイレクト
        return redirect('/chat');
    }
}
