<!DOCTYPE html>
<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(function() {
            //チャット入出力時に最下部にスクロール
            $(document).ready(function() {
                var speed = 10; //スクロールの速度 (ミリ秒)
                var position = $('#bms_messages').get(0).scrollHeight;//チャット表示部分の高さ取得
                $('#bms_messages').animate({scrollTop:position}, speed, 'swing');
            });
            //テキストエリアでEnter押下時に入力内容をsubmit
            $('textarea').keypress(function(event){
                var keycode = (event.keyCode ? event.keyCode : event.which);//押されたkeyを確認
                //keycode = 13 = Enterの場合にsubmit
                if(keycode == '13'){
                    $('#chatform').submit();
                }
            });
        });
    </script>
    <title>TalkAPIChat</title>
</head>

<body>
    <div id="your_container">
        <!-- チャットの外側部分 -->
        <div id="bms_messages_container">
            <!-- ヘッダー部分 -->
            <div id="bms_chat_header">
                <!--ステータス-->
                <div id="bms_chat_user_status">
                    <!--ユーザー名-->
                    <div id="bms_chat_user_name">TalkAPI Chat</div>
                </div>
                    <!--リセットボタン-->
                    <div id="bms_status_icon">
                    <a href="/chat/delete">
                    <button type="submit" name="delete"  class="resetbtn">
                        リセット
                    </button>
                    </a>
                    </div>
            </div>
            <!-- タイムライン部分 -->
            <div id="bms_messages">
                <!--メッセージ１（左側）TalkAPI-->
                @foreach($chats as $chat)
                @if($chat['from_id'] == 1)
                <div class="bms_message bms_left">
                    <div class="bms_message_box">
                        <div class="bms_message_content">
                            <div class="bms_message_text">
                                    {{$chat['chats']}}
                            </div>
                        </div>
                    </div>
                    <div class="send_time">{{ $chat['created_at']->format('n月d日H:i') }}</div>
                </div>
                <div class="bms_clear"></div><!-- 回り込みを解除（スタイルはcssで充てる） -->
                @endif
                <!--メッセージ２（右側）自分-->
                @if($chat['from_id'] == 0)
                <div class="bms_message bms_right">
                    <div class="bms_message_box">
                        <div class="bms_message_content">
                            <div class="bms_message_text">
                                    {{$chat['chats']}}
                            </div>
                        </div>
                    </div>
                    <div class="send_time st_right">{{ $chat['created_at']->format('n月d日H:i') }}</div>
                </div>
                <div class="bms_clear"></div><!-- 回り込みを解除（スタイルはcssで充てる） -->
                @endif
                @endforeach
            </div>
            <!-- テキストボックス、送信ボタン -->
            <div id="bms_send">
                <form action="{{url('/chat')}}" method="POST"id="chatform">
                    {{ csrf_field() }}
                    <textarea rows="5" name="message" id="bms_send_message" class="msg" required></textarea>
                    <button type="submit" name="add" id="bms_send_btn" class="btn">
                        送信
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>