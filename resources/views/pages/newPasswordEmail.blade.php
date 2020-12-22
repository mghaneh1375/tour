<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="title" content="کوچیتا | سامانه جامع گردشگری ایران و شبکه اجتماعی گردشگران" />

    <link rel="icon" href="{{URL::asset('images/icons/KOFAV0.svg')}}" sizes="any" type="image/svg+xml">
    <link rel="apple-touch-icon-precomposed" href="{{URL::asset('images/icons/KOFAV0.svg')}}" sizes="any" type="image/svg+xml">
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/topHeaderStyles.css?v=1')}}' />
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/bootstrap.min.css?v=1')}}' />
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/loginPopUp.css?v=1')}}'/>

    <script src="{{URL::asset('js/jquery-3.4.1.min.js')}}"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <style>
        .registerLeftSection{
            width: 40%;
            background: #053a3e;
        }

        @media (max-width: 800px){
            .loginPopUpContent{
                width: 100%;
            }
            .registerRightSection{
                width: 100%;
            }
            .registerLeftSection{
                display: none;
            }
        }
    </style>

</head>
<body>

@include('general.loading')

<div id="mainLoginPopUp" class="mainLoginPupUpBack">
    <div id="registerDiv" class="loginPopUpContent" style="justify-content: space-between; flex-direction: row; padding: 15px;">
        <div class="registerRightSection">

            <div id="registerMainLogo">
                <img class="loginMainLogo" src="{{URL::asset('images/icons/KOFAV0.svg')}}">
            </div>

            <div>
                <span id="setNewPassword">
                    <div class="col-xs-12 rtl mainContentInfos">
                        <input type="hidden" name="code" id="code" value="{{$code}}">
                        <div>رمز عبور جدید خود را وارد نمایید:</div>
                        <div style="margin-top: 10px">
                            <div>
                                <div class="loginPopUpLable"> رمز عبور جدید </div>
                                <input class="loginInputTemp" type="password" id="password" name="password" required autofocus>
                            </div>
                        </div>
                        <div class="pd-tp-8">
                            <button type="button" class="loginSubBtn btn btn-info active" onclick="setNewPassword()" style="margin-top: 15px">ثبت</button>
                        </div>
                    </div>
                </span>

            </div>
        </div>

        <div class="registerLeftSection"></div>

    </div>

</div>

<script>

    function setNewPassword(){
        let pass =  $('#password').val();
        let code =  $('#code').val();

        if(pass.trim().length > 0){
            openLoading();
            $.ajax({
                type: 'post',
                url: '{{route('setNewPasswordEmail')}}',
                data: {
                    _token: '{{csrf_token()}}',
                    code: code,
                    password: pass
                },
                success: function(response){
                    if(response == 'ok') {
                        alert('رمز عبور با موفقیت تغییر یافت');
                        location.reload();
                    }
                    else{
                        closeLoading();
                        alert('در ثبت رمز عبور مشکلی پیش امده لطفا دوباره تلاش نمایید')
                    }
                },
                error: function(err){
                    closeLoading();
                    console.log(err);
                    alert('در ثبت رمز عبور مشکلی پیش امده لطفا دوباره تلاش نمایید')
                }
            });
        }
    }

</script>


</body>
</html>