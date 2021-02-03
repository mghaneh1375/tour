@extends('panelBusiness.layout.baseLayout')


@section('head')
    <title>ورود به سامانه کسب و کار کوچیتا</title>

    <style>

        .mainBodySection{
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .loginWithGoogle{
            text-align: center;
            padding: 8px 0px;
            box-shadow: 0px 0px 3px 1px #00000099;
            width: 300px;
            margin: 20px auto;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            color: black;
        }
        .miniTextForRegister{
            color: var(--koochita-blue);
            font-size: 14px;
            margin-bottom: 10px;
            cursor: pointer;
        }
        .minDesc{
            font-size: 12px;
            color: #525252;
            margin-top: 5px;
        }
    </style>
@endsection

@section('body')

    <div class="mainBackWhiteBody" style="min-width: 700px;">
        <div id="mainRegisterHeader" class="head" style="text-align: center">ورود به سامانه کسب و کار کوچیتا</div>

        <a href="{{$authUrl}}" class="loginWithGoogle">
            <span class="mr-2"> ورود با گوگل</span>
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 0 48 48" class="abcRioButtonSvg">
                <g>
                    <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"></path>
                    <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"></path>
                    <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"></path>
                    <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"></path>
                    <path fill="none" d="M0 0h48v48H0z"></path>
                </g>
            </svg>
        </a>

        <div class="loginSection mt-3">
            <form action="{{route('businessPanel.doLogin')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="usernameLogin">نام کاربری و یا شماره تماس و یا ایمیل</label>
                            <input type="text" id="usernameLogin" name="username" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="passwordLogin">رمز عبور</label>
                            <input type="password" id="passwordLogin" name="password" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="miniTextForRegister" onclick="goToAnotherPage('register')">اگر عضو کوچیتا نیستید ثبت نام کنید.</div>
                    </div>
                </div>

                <div class="buttonGroupBottom center">
                    <button class="btn btn-success doLoginButton">ورود</button>
                </div>
            </form>
        </div>
        <div class="registerSection mt-3 hidden">
            <div class="row">
                <div class="col-md-12 fullyCenterContent">
                    <div class="form-group" style="width: 50%">
                        <label for="usernameRegister">نام کاربری</label>
                        <input type="text" id="usernameRegister" class="form-control">
                        <div class="minDesc">دیگر کاربران شما را با این نام خواهند شناخت</div>
                    </div>
                </div>

                <div class="col-md-12 fullyCenterContent">
                    <div class="form-group" style="width: 50%">
                        <label for="phoneRegister">شماره تماس</label>
                        <input type="text" id="phoneRegister" class="form-control" placeholder="09xxxxxxxxx">
                        <div class="minDesc">پس از زدن دکمه ثبت نام یک کد تایید به شماره وارد شده ارسال می شود</div>
                    </div>
                </div>

                <div class="col-md-12 fullyCenterContent">
                    <div class="form-group" style="width: 50%">
                        <label for="passwordRegister">رمز عبور</label>
                        <input type="password" id="passwordRegister" class="form-control">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="miniTextForRegister" onclick="goToAnotherPage('login')">اگر عضو کوچیتا هستید وارد شوید.</div>
                </div>
            </div>

            <div class="buttonGroupBottom center">
                <button class="btn btn-success doLoginButton" onclick="firstStepRegister()">ثبت نام</button>
            </div>
        </div>

        <div class="errorSection">
            <div class="error" style="color: red">
                @if(session('error') == 'blocked')
                    اکانت شما توسط مدیریت سایت بسته شده است
                @elseif(session('error') == 'wrongInput')
                    نام کاربری یا رمز عبور اشتباه است
                @endif
            </div>
        </div>
    </div>

@endsection

@section('modals')
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">تایید شماره تماس</h4>
                </div>
                <div class="modal-body">
                    <div class="desc">لطفا کد ارسال شده به شماره تماس خود را در زیر وارد نمایید</div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="verifyCode">کد تایید</label>
                                <input type="text" class="form-control" id="verifyCode">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div id="remainingTimeSection">
                            مدت زمان باقی مانده تا ارسال دوباره کد:
                            <span id="timer">00:00</span>
                            ثانیه
                        </div>
                        <div id="resendCodeSection" class="hidden">
                            <button class="btn btn-primary" onclick="resendNewCode()">ارسال دوباره کد</button>
                        </div>
                    </div>

                    <div class="row errorSectionModal"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="checkActivationCode()">ثبت</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script>
        function goToAnotherPage(_kind){
            if(_kind == 'register'){
                $('#mainRegisterHeader').text('ثبت نام در سامانه کسب و کار کوچیتا');
                $('.loginSection').addClass('hidden');
                $('.registerSection').removeClass('hidden');
            }
            else{
                $('#mainRegisterHeader').text('ورود به سامانه کسب و کار کوچیتا');
                $('.loginSection').removeClass('hidden');
                $('.registerSection').addClass('hidden');
            }
        }

        function checkInputTrue(){
            var errorText = [];
            $('.errorSection').empty();

            var username = $('#usernameRegister').val();
            var phone = $('#phoneRegister').val();
            var password = $('#passwordRegister').val();

            if(username.trim().length == 0)
                errorText.push('وارد کردن نام کاربری اجباری است');
            if(password.trim().length < 5)
                errorText.push('رمز عبور حداقل باید دارای 6 کاراکتر باشد');
            if(phone.trim().length != 11 || phone[0] != 0 || phone[1] != 9)
                errorText.push('شماره تماس خود را به درستی وارد نمایید');

            if(errorText.length != 0){
                var errorHtml = '';
                errorText.map(item => errorHtml += `<div class="error" style="color: red">${item}</div>`);
                $('.errorSection').html(errorHtml);
                return {error: true};
            }
            else
                return {error: false, username, phone, password};

        }

        function firstStepRegister(){

            var result = checkInputTrue();

            if(!result.error) {
                openLoading();
                $.ajax({
                    type: 'POST',
                    url: '{{route("businessPanel.checkRegisterInputs")}}',
                    data: {
                        _token: '{{csrf_token()}}',
                        username: result.username,
                        phone: result.phone
                    },
                    complete: closeLoading,
                    success: response => resultOfSendCode(response),
                    error: err => openErrorAlertBP('خطا در ارسال اطلاعات')
                })
            }
        }

        function resultOfSendCode(response){
            if(response.status == 'ok'){
                $('#remainingTimeSection').removeClass('hidden');
                $('#resendCodeSection').addClass('hidden');
                $('#myModal').modal({backdrop: 'static', keyboard: false});
                countDownTimer(response.result);
            }
            else if(response.status == 'error1')
                openErrorAlertBP('خطا در ارسال اطلاعات');
            else if(response.status == 'error2')
                openErrorAlertBP('شماره وارد شده اشتباه می باشد');
            else if(response.status == 'error3')
                openErrorAlertBP('شماره وارد شده قبلا در سامانه ثبت شده است');
            else if(response.status == 'error4')
                openErrorAlertBP('نام کاربری وارد شده قبلا در سامانه ثبت شده است');
            else if(response.status == 'error5')
                openErrorAlertBP('خطا');
        }

        function countDownTimer(_time){
            var min = Math.floor(_time/60);
            var second = _time%60;

            if(min < 10)
                min = '0' + min;
            if(second < 10)
                second = '0' + second;

            if(_time == 0){
                $('#remainingTimeSection').addClass('hidden');
                $('#resendCodeSection').removeClass('hidden');
            }
            else{
                $('#timer').text(`${min}:${second}`);
                setTimeout(() => countDownTimer(_time-1), 1000);
            }
        }

        function resendNewCode(){
            var phone = $('#phoneRegister').val();
            if(phone.trim().length != 11 || phone[0] != 0 || phone[1] != 9){
                openErrorAlertBP('شماره تماس خود را به درستی وارد نمایید');
                return;
            }

            openLoading();

            $.ajax({
                type: 'POST',
                url: '{{route("businessPanel.doSendVerificationPhoneCode")}}',
                data: {
                    _token: '{{csrf_token()}}',
                    phone
                },
                complete: closeLoading,
                success: response => resultOfSendCode(response),
                error: err => openErrorAlertBP('خطا در ارسال اطلاعات')
            })
        }


        function checkActivationCode(){
            var result = checkInputTrue();
            var verifyCode = $('#verifyCode').val();

            if(verifyCode.trim().length < 4){
                $('.errorSectionModal').html('<div class="error" style="color: red">کد تایید را وارد نمایید</div>');
                return;
            }

            if(!result.error) {
                openLoading();
                $.ajax({
                    type: 'POST',
                    url: '{{route("businessPanel.user.doRegister")}}',
                    data: {
                        _token: '{{csrf_token()}}',
                        verifyCode: verifyCode,
                        username: result.username,
                        password: result.password,
                        phone: result.phone
                    },
                    success: response => {
                        if(response.status == 'ok')
                            location.href = '{{route("businessPanel.mainPage")}}';
                        else{
                            closeLoading();
                            if(response.status == 'doResendCode')
                                resendNewCode();
                            else if(response.status == 'notTime')
                                resendNewCode();
                            else if(response.status == 'notSame')
                                openErrorAlertBP('در تایید وارد شده صحیح نمی باشد');
                            else
                                resultOfSendCode(response)
                        }
                    },
                    error: err => {
                        closeLoading();
                        openErrorAlertBP('خطا در ارسال اطلاعات')
                    }
                })
            }
        }

    </script>

@endsection
