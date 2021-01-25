<!doctype html>
<html lang="{{app()->getLocale()}}">
<head>
    @include('layouts.topHeader')

    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta property="og:locale" content="fa_IR" />
    {{--<meta property="og:locale:alternate" content="fa_IR" />--}}
    <meta property="og:type" content="website" />
    <title> {{__('کوچیتا، سامانه جامع گردشگری ایران')}} </title>
    <meta name="title" content="کوچیتا | سامانه جامع گردشگری ایران و شبکه اجتماعی گردشگران" />
    <meta name='description' content='کوچیتا، سامانه جامع گردشگری ایران و شبکه اجتماعی گردشگران. اطلاعات اماکن و جاذبه ها، هتل ها، بوم گردی، ماجراجویی، آموزش سفر، فروشگاه صنایع‌دستی ، پادکست سفر' />
    <meta name='keywords' content='کوچیتا، هتل، تور ، سفر ارزان، سفر در ایران، بلیط، تریپ، نقد و بررسی، سفرنامه، کمپینگ، ایران گردی، آموزش سفر، مجله گردشگری، مسافرت، مسافرت داخلی, ارزانترین قیمت هتل ، مقایسه قیمت ، بهترین رستوران‌ها ، بلیط ارزان ، تقویم تعطیلات' />
    <meta property="og:image" content="{{URL::asset('images/mainPics/noPicSite.jpg')}}"/>
    <meta property="og:image:secure_url" content="{{URL::asset('images/mainPics/noPicSite.jpg')}}"/>
    <meta property="og:image:width" content="550"/>
    <meta property="og:image:height" content="367"/>
    <meta name="twitter:image" content="{{URL::asset('images/mainPics/noPicSite.jpg')}}"/>

    <link rel="stylesheet" href="{{URL::asset('css/pages/landingPage.css?v=1')}}">
    @if(app()->getLocale() == 'en')
        <link rel="stylesheet" href="{{URL::asset('css/pages/ltr/landingPage.css?v=2')}}">
    @endif
</head>
<body style="background: black; overflow-x: hidden">

@include('general.loading')

    <div class="topPic">
        <img class="mainPic" src="{{URL::asset('images/camping/' . app()->getLocale() . '/Layer 5.jpg')}}">
        <div class="sidePics">
            <div class="sidePics1">
                <div class="topSidePic1">
                    <img src="{{URL::asset('images/camping/' . app()->getLocale() . '/www.koochita.com.png')}}" style="width: 100%">
                </div>
                <div class="bottomSidePic1">
                    <img class="travelUsImg" src="{{URL::asset('images/camping/' . app()->getLocale() . '/Layer 14.png')}}">
                    <button class="btn btn-primary topStartButton" onclick="startFunc()">
                        @if(app()->getLocale() == 'fa')
                            همین حالا
                                <span class="startChar">
                                شروع
                            </span>
                            کنید
                        @elseif(app()->getLocale() == 'en')
                            <span class="startChar">
                                Start
                            </span>
                            now
                        @endif
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="otherPics">
        <div class="otherPicCommon">
            <img src="{{URL::asset('images/camping/' . app()->getLocale() . '/side1.jpg')}}" class="otherPicImg">
        </div>
        <div class="otherPicCommon">
            <img src="{{URL::asset('images/camping/' . app()->getLocale() . '/Layer 16.jpg')}}" class="otherPicImg">
        </div>
        <div class="otherPicCommon">
            <img src="{{URL::asset('images/camping/' . app()->getLocale() . '/Layer 17.jpg')}}" class="otherPicImg">
        </div>
    </div>

    <div id="loginPopUp" class="loginPopUp">
        <div class="loginDiv">
            <div class="topIconDiv">
                <img src="{{URL::asset('images/icons/mainLogo.png')}}" style="width: 195px">
                <div class="closeButton" onclick="closeLogin()"></div>
            </div>
            <hr style="margin: 0px">

            <div id="loginSection" class="loginInputDiv" style="display: none">
                <div class="loginText">
                    @lang('ورود به کوچیتا')
                </div>

                <div class="form-group">
                    <label for="username">@lang('نام کاربری')</label>
                    <input type="text" class="form-control" id="username" style="height: 40px">
                </div>
                <div class="form-group">
                    <label for="password">@lang('رمز عبور')</label>
                    <input type="password" class="form-control" id="password" style="height: 40px">
                </div>
                <p id="loginErr" style="color: red;"></p>

                <div class="loginButtonsMainDiv" onclick="login()">
                    @lang('ورود')
                </div>
                <div class="registerNow" onclick="registerStart()">
                    @lang('همین حالا ثبت نام کنید')
                </div>
            </div>

            <div id="phoneSection" class="loginInputDiv" style="display: block">
                <div class="loginText">
                    @lang('ثبت نام در کوچیتا')
                </div>

                <div class="form-group">
                    <label for="phone">@lang('شماره تماس')</label>
                    <input type="text" class="form-control" id="phone" style="height: 40px" placeholder="09xxxxxxxx">
                </div>
                <p id="phoneError" style="color: red"></p>

                <div class="loginButtonsMainDiv" style="background: var(--koochita-green)" onclick="phoneRegister()">
                    @lang('ثبت')
                </div>

                <div class="registerNow" onclick="loginPage()">
                    @lang('ورود به کوچیتا')
                </div>
            </div>

            <div id="phoneRegister" class="loginInputDiv" style="display: none;">
                <div class="header_text font-size-14Imp">@lang('لطفا کد اعتبار سنجی را وارد نمایید:')</div>
                <div>
                    <div>
                        <label style="text-align: center; width: 100%">
                            <div style="font-size: 13px; margin: 10px 0px;">@lang('این کد به گوشی شما ارسال گردیده است.')</div>

                            <div> @lang('کد اعتبار سنجی') </div>
                            <input class="loginInputTemp" type="text" maxlength="40" id="activationCode" required autofocus>
                            <p id="reminderTimePane">
                                <span style="font-size: 12px;">@lang('زمان باقی مانده برای ارسال مجدد کد اعتبار سنجی شما :')</span>
                                <span id="reminderTime"></span>
                            </p>
                            <button onclick="resendActivationCode()" disabled id="resendActivationCode"
                                    class="btn btn-success" style="margin-top: 15px"> @lang('ارسال مجدد کد اعتبار سنجی') </button>
                        </label>
                    </div>
                </div>
                <div class="pd-tp-8">
                    <p id="loginErrActivationCode" style="color: red"></p>

                    <div class="loginButtonsMainDiv" style="background: var(--koochita-green)" onclick="showLoginPassword()">
                        @lang('ثبت')
                    </div>
                </div>
            </div>

            <div id="registerSection" class="loginInputDiv" style="font-size: 15px; display: none">
                <div class="loginText">
                    @lang('ثبت نام در کوچیتا')
                </div>
                <div class="registerInputs">
                    <div class="form-group">
                        <label for="firstName">@lang('نام')</label>
                        <input type="text" class="form-control" id="firstName" style="height: 40px">
                    </div>
                    <div class="form-group">
                        <label for="lastName">@lang('نام خانوادگی')</label>
                        <input type="text" class="form-control" id="lastName" style="height: 40px">
                    </div>
                    <div class="form-group">
                        <label for="usernameInput">@lang('نام کاربری')</label>
                        <input type="text" class="form-control" id="usernameInput" style="height: 40px">
                    </div>
                    <div class="form-group">
                        <label for="passInput">@lang('کلمه عبور')</label>
                        <input type="password" class="form-control" id="passInput" style="height: 40px">
                    </div>
                    <div class="form-group">
                        <label for="rePassInput">@lang('تکرار کلمه عبور')</label>
                        <input type="password" class="form-control" id="rePassInput" style="height: 40px">
                    </div>

                    <div class="form-group">
                        <script async src='https://www.google.com/recaptcha/api.js'></script>

                        <input id='checked' onchange='checkedCheckBox()' type='checkbox' value='-1'>
                        <label class='labelForCheckBox' for='checked'>
                            <span></span>&nbsp;
                        </label>
                        <span>
                            @if(app()->getLocale() == 'fa')
                                شرایط استفاده و
                                <a target="_blank" href="{{route('policies')}}" style="color: blue;">قوانین سایت</a>
                                را مطالعه کرده و با آن موافقم.
                            @elseif(app()->getLocale() == 'en')
                                I read the terms of use and the
                                <a target="_blank" href="{{route('policies')}}" style="color: blue;">rules of the site</a>
                                and agree with it
                            @endif
                        </span>
                        <div>
                            <div class="g-recaptcha" data-sitekey="6LfiELsUAAAAAO3Pk-c6cKm1HhvifWx9S8nUtxTb"></div>
                        </div>
                    </div>
                    <p id="loginErrUserName" style="color: red"></p>
                    <button id="submitAndFinishBtn" class="loginButtonsMainDiv" style="background: var(--koochita-green)" onclick="checkRecaptcha()" disabled>
                        @lang('ثبت نام')
                    </button>
                </div>
            </div>


        </div>
    </div>

</body>

<script>
    var hasLogin = {{auth()->check() ? 1 : 0}};
    let phoneNum;

    function closeLogin(){
        $('#loginPopUp').hide();
        $('#phoneSection').hide();
        $('#phoneRegister').hide();
        $('#registerSection').hide();

        $('#loginSection').show();
    }

    function startFunc(){
        if(hasLogin)
            location.href = '{{route("addPlaceByUser.index")}}';
        else
            $('#loginPopUp').css('display', 'flex');
    }

    function registerStart(){
        $('#loginSection').hide();
        $('#phoneSection').show();
    }

    function loginPage() {
        $('#loginSection').show();
        $('#phoneSection').hide();
    }

    function toggleBottom(){
        $('#topSidePic2Content').slideToggle(500);
        $('#arrowImg').toggleClass('arrowImgTop')
    }

    function checkRecaptcha() {
        openLoading();

        $.ajax({
            type: 'post',
            url: '{{route('checkReCaptcha')}}',
            data: {
                captcha: grecaptcha.getResponse()
            },
            success: function (response) {
                closeLoading();
                if (response == "ok") {
                    if ($("#usernameInput").val().trim().length > 0)
                        checkUserName2();
                    else
                        $("#loginErrUserName").text('@lang('پر کردن تمام فیلدها اجباری است')');
                }
                else
                    $("#loginErrUserName").text('@lang('لطفا ربات نبودن خود را ثابت کنید')');
            },
            error: function(err){
                console.log(err);
                closeLoading();
                $("#loginErrUserName").text('@lang('در فرایند ثبت نام مشکلی پیش آمده لطفا دوباره تلاش کنید')');
            }
        });
    }

    function checkedCheckBox() {

        if ($("#checked").is(":checked")) {
            $("#submitAndFinishBtn").removeAttr('disabled');
        }
        else {
            $("#submitAndFinishBtn").attr('disabled', 'disabled');
        }
    }

    function checkUserName2() {
        let username = $('#usernameInput').val();
        let pass = $('#passInput').val();
        let rePassInput = $('#rePassInput').val();
        let firstName = $('#firstName').val();
        let lastName = $('#lastName').val();

        if(username.trim().length > 0 && pass.trim().length > 0 && rePassInput.trim().length > 0 && firstName.trim().length > 0 && lastName.trim().length > 0){

            if(pass == rePassInput){
                openLoading();

                $.ajax({
                    type: 'post',
                    url: '{{route('checkUserName')}}',
                    data: {
                        'username': username,
                    },
                    success: function (response) {
                        closeLoading();
                        if (response == "ok") {
                            openLoading();

                            $.ajax({
                                type: 'post',
                                url: '{{route('registerWithPhone')}}',
                                data: {
                                    'username': username,
                                    'password': pass,
                                    'phone': phoneNum,
                                    'firsName': firstName,
                                    'lastName': lastName,
                                },
                                success: function (response) {
                                    if (response == "ok")
                                        window.location.href = '{{route("addPlaceByUser.index")}}';
                                    else
                                        closeLoading();
                                },
                                error: function(err){
                                    console.log('registerWithPhone');
                                    console.log(err);
                                    closeLoading();
                                    $("#loginErrUserName").text('@lang('در فرایند ثبت نام مشکلی پیش آمده لطفا دوباره تلاش کنید')');
                                }
                            });
                        }
                        else if (response == "nok1")
                            $("#loginErrUserName").text('@lang('نام کاربری وارد شده در سامانه موجود است')');
                    },
                    error: function(err){
                        console.log('checkUserName');
                        console.log(err);
                        closeLoading();
                        $("#loginErrUserName").text('@lang('در فرایند ثبت نام مشکلی پیش آمده لطفا دوباره تلاش کنید')');
                    }
                });
            }
            else
                $("#loginErrUserName").text('@lang('کلمه عبور و تکرار ان یکسان نیست')');
        }
        else
            $("#loginErrUserName").text('@lang('پر کردن تمام فیلدها اجباری است')');

    }

    function login() {
        let username = $('#username').val();
        let password = $('#password').val();
        if (username.trim().length > 0 && password.trim().length > 0) {
            $.ajax({
                type: 'post',
                url: '{{route('login2')}}',
                data: {
                    'username': username,
                    'password': password
                },
                success: function (response) {
                    if (response == "ok")
                        location.href = '{{route("addPlaceByUser.index")}}';
                    else if (response == "nok2")
                        $("#loginErr").empty().append('@lang('حساب کاربری شما غیر فعال شده است')');
                    else
                        $("#loginErr").empty().append('@lang('نام کاربری و یا رمز عبور اشتباه وارد شده است')');
                },
                error: function (xhr, status, error) {
                    if (xhr.responseText == "Too Many Attempts.")
                        $("#loginErr").empty().append('تعداد درخواست های شما بیش از حد مجاز است. لطفا تا 5 دقیقه دیگر تلاش نفرمایید');
                }
            });
        }
    }

    function resendActivationCode() {

        $.ajax({
            type: 'post',
            url: '{{route('resendActivationCode')}}',
            data: {
                'phoneNum': phoneNum,
            },
            success: function (response) {

                response = JSON.parse(response);

                reminderTime = response.reminder;

                if (response.status == "ok") {
                    if (reminderTime > 0) {
                        $("#reminderTimePane").removeClass('hidden');
                        $("#resendActivationCode").attr('disabled', 'disabled');
                        setTimeout("decreaseTime()", 1000);
                    }
                    else {
                        $("#reminderTimePane").addClass('hidden');
                        $("#resendActivationCode").removeAttr('disabled');
                    }
                }
                else {
                    $("#reminderTimePane").removeClass('hidden');
                    $("#resendActivationCode").attr('disabled', 'disabled');
                    setTimeout("decreaseTime()", 1000);
                }
            }
        })
    }

    function showLoginPassword() {
        if ($("#activationCode").val().trim().length > 0)
            checkActivationCode();
    }

    function checkActivationCode() {
        openLoading();

        $.ajax({
            type: 'post',
            url: '{{route('register.checkActivationCode')}}',
            data: {
                'phoneNum': phoneNum,
                'activationCode': $("#activationCode").val()
            },
            success: function (response) {
                closeLoading();
                if (response.status == "ok") {
                    $('#phoneRegister').hide();
                    $('#registerSection').show();
                }
                else
                    $("#loginErrActivationCode").text('@lang('کد وارد شده معتبر نمی باشد')');
            },
            error: function(err){
                closeLoading();
                $("#loginErrActivationCode").text('@lang('در فرایند ثبت نام مشکلی پیش آمده لطفا دوباره تلاش کنید')');
            }
        });

    }

    function phoneRegister(){
        if ($("#phone").val().trim().length == 11)
            checkPhoneNum();
        else
            $('#phoneError').text('@lang('شماره تماس خود را به درستی وارد کنید.')');
    }

    function checkPhoneNum() {
        openLoading();
        $.ajax({
            type: 'post',
            url: '{{route('checkPhoneNum')}}',
            data: {
                'phoneNum': $("#phone").val()
            },
            success: function (response) {
                closeLoading();
                response = JSON.parse(response);

                if (response.status == "ok") {
                    $('#phoneSection').hide();
                    $('#phoneRegister').show();

                    phoneNum = $("#phone").val();

                    reminderTime = response.reminder;
                    if (reminderTime > 0) {
                        $("#reminderTimePane").removeClass('hidden');
                        $("#resendActivationCode").attr('disabled', 'disabled');
                        setTimeout("decreaseTime()", 1000);
                    }
                    else {
                        $("#reminderTimePane").addClass('hidden');
                        $("#resendActivationCode").removeAttr('disabled');
                    }
                    $("#activationCode").val("");
                    $(".pop-up").addClass('hidden');
                    $('#Send_AND_EnterCode-loginPopUp').removeClass('hidden');
                    $(".dark").show();
                }
                else if (response.status == "nok")
                    $("#phoneError").text('@lang('شماره شما پیش از این در سامانه ثبت گردیده است.')');
                else if (response.status == "nok3")
                    $("#phoneError").text('@lang('اشکالی در ارسال پیام رخ داده است')');
                else
                    $("#loginErrPhonePass1").empty().append('@lang('کد اعتبار سنجی برای شما ارسال شده است. برای ارسال مجدد کد باید 5 دقیقه منتظر بمانید')');
            },
            error: function (err){
                closeLoading();
                console.log('checkPhoneNum');
                console.log(err);
                $("#phoneError").text('@lang('در فرایند ثبت نام مشکلی پیش آمده لطفا دوباره تلاش کنید.')');
            }
        });

    }

    function decreaseTime() {

        $("#reminderTime").text((reminderTime % 60) + " : " + Math.floor(reminderTime / 60));

        if (reminderTime > 0) {
            reminderTime--;
            setTimeout("decreaseTime()", 1000);
        }
        else {
            $("#reminderTimePane").addClass('hidden');
            $("#resendActivationCode").removeAttr('disabled');
        }
    }

</script>

</html>
