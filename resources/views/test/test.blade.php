<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>koochita test</title>
{{--    <meta name="csrf-token" content="{{ csrf_token() }}">--}}
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/bootstrap.min.css?v=1')}}' />
    <script src="{{URL::asset('js/jQuery.js')}}"></script>

    <style>
        .ms{
            background: white;
            margin: 10px;
            border-radius: 10px;
            padding: 10px;

        }
    </style>

</head>
<body>
    <div class="container">
        <div class="col-md-6">
            <div class="row">
                <div id="showMsgs" class="col-md-12" style="height: 80vh; background: lightgrey; border-radius: 10px">

                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <input type="text" class="form-control" id="msg" name="msg">
                    <button class="btn btn-success" onclick="sendMsg()">send</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function sendMsg(){
            let msg = $('#msg').val();
            $('#msg').val('');
            $.ajax({
                type: 'post',
                url: '{{route("sendBroadcastMsg")}}',
                data: {
                    _token: '{{csrf_token()}}',
                    msg: msg,
                    room: '{{$room}}',
                },
                success: function(response){
                    console.log('success')
                },
                error: function(err){
                    console.log('err')
                }
            })
        }
    </script>

    <script src="{{URL::asset('js/app.js')}}"></script>
{{--    <script src="https://js.pusher.com/6.0/pusher.min.js"></script>--}}

    <script>
        window.Echo.channel('liveComments.{{$room}}')
            .listen('CommentBroadCast', (e) => {
                console.log('listen ');

                let text = '<div class="ms">' + e.message + '</div>';
                $('#showMsgs').append(text);
            });
    </script>
</body>
</html>