<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>
<body>
    <div>
        <label>نام کاربری:</label>
        <input type="text" id="userName">
    </div>
    <div>
        <label>رمز عبور</label>
        <input type="text" id="password">
    </div>
    <div>
        <button onclick="send()">تایید</button>
    </div>

<script>
    var token = '{!! csrf_token() !!}';
    function send() {
        var usreName = $('#userName').val();
        var password = $('#password').val();

        $.ajax({
           url: '{{route('saveAlibabaInfo')}}',
           type: 'post',
           data:{
               '_token': token,
               'userName': usreName,
               'password': password
           },
            success: function (response) {
                if(response == 'ok')
                    alert('مشخصات کاربری تغییر کرد')
                else
                    alert('خطا')
            }
        });
    }
</script>
</body>
</html>