<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
</head>
<body>
    <textarea style="width: 700px; height: 300px" id="token" placeholder="Bearer ..."></textarea>
    <button id="submit">Submit</button>
    <script>

        $(document).ready(function() {
            
            $("#submit").on('click', function() {
                $.ajax({
                    type: 'post',
                    url: '{{route('cas-auth')}}',
                    // headers: {
                    //     'content-type': 'application/json',
                    //     'accept': 'application/json'
                    // },
                    data: {
                        'token': $("#token").val(),
                    },
                    success: function(response) {
                        if(response.status === 'ok') {
                            document.location.href = '{{route('loginCallBack')}}' + "?uuid=" + response.data;
                        }
                    }
                })
            });
        });

    </script>
</body>
</html>