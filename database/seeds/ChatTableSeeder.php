<?php

use Illuminate\Database\Seeder;

class ChatTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // テーブルのクリア
            DB::table('chat')->truncate();

            // 初期データ用意（列名をキーとする連想配列）
            $chat = [
                        ['name' => '高島',],
                    ];
            // 登録
            foreach ($chat as $chats) {
                \App\Chat::create($chats);
            }
    }
}
