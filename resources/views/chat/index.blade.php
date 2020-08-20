<!DOCTYPE html>
<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(function() {
            $("#btn").click(function() {
                console.log($('#msg').val());
                // $.ajax({
                //     url: "./componenrs/comment",
                //     dataType: "html",
                //     type: 'POST',
                //     headers: {
                //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //     },
                //     success: data => {
                //         // 成功時の処理
                //         console.log("通信成功");
                //         //console.log(data);
                //     },
                //     error: () => {
                //         // エラー時の処理
                //         console.log("通信失敗");
                //         //console.log(data);

                //     }
                // })
            });

        });
    </script>
</head>

<body>
    @include('components.comment')
    <form action="{{url('/chat')}}" method="POST">
    {{ csrf_field() }}
    <textarea rows="5" name="message" id="msg"></textarea>
    <button type="submit" name="add" id="btn">
        送信
    </button>
    </form>
</body>

</html>