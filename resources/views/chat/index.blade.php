<!DOCTYPE html>
<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(function() {
            $(document).ready(function() {
                // スクロールの速度
                var speed = 10; // ミリ秒
                // スムーススクロール
                var position = $('#bms_messages').get(0).scrollHeight;
                $('#bms_messages').animate({scrollTop:position}, speed, 'swing');
            });
            $('textarea').keypress(function(event){
                var keycode = (event.keyCode ? event.keyCode : event.which);
                if(keycode == '13'){
                    $('#chatform').submit();
                }
            });
        });
    </script>
    <title>chat</title>
</head>

<body>
    <!-- 自分やユーザーの情報 -->
    <div id="your_container">

        <!-- チャットの外側部分① -->
        <div id="bms_messages_container">
            <!-- ヘッダー部分② -->
            <div id="bms_chat_header">
                <!--ステータス-->
                <div id="bms_chat_user_status">
                    <!--ユーザー名-->
                    <div id="bms_chat_user_name">TalkAPI</div>
                </div>
                    <!--ステータスアイコン-->
                    <div id="bms_status_icon">
                    <a href="/chat/delete">
                    <button type="submit" name="delete"  class="resetbtn">
                        リセット
                    </button>
                    </a>
                    </div>
            </div>

            <!-- タイムライン部分③ -->
            <div id="bms_messages">

                <!--メッセージ１（左側）-->
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
                </div>
                <div class="bms_clear"></div><!-- 回り込みを解除（スタイルはcssで充てる） -->
                @endif

                <!--メッセージ２（右側）-->
                @if($chat['from_id'] == 0)
                <div class="bms_message bms_right">
                    <div class="bms_message_box">
                        <div class="bms_message_content">
                            <div class="bms_message_text">
                                    {{$chat['chats']}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bms_clear"></div><!-- 回り込みを解除（スタイルはcssで充てる） -->
                @endif
                @endforeach
            </div>

            <!-- テキストボックス、送信ボタン④ -->
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