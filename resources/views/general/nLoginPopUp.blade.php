<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

if (Auth::check())
    return Redirect::to(route('main'));

require_once(__DIR__ . '/../../../app/Http/Controllers/glogin/libraries/Google/autoload.php');

//Insert your cient ID and secret
//You can get it from : https://console.developers.google.com/
$client_id = config('app.GOOGLE_CLIENT_ID');
$client_secret = config('app.GOOGLE_CLIENT_SECRET');
$redirect_uri = route('loginWithGoogle');
$redirect_uri = str_replace('http://', 'https://', $redirect_uri);

$client = new \Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope("email");
$client->addScope("profile");

$service = new \Google_Service_Oauth2($client);
$authUrl = $client->createAuthUrl();

$url = $_SERVER['REQUEST_URI'];
$authUrl = str_replace('state', 'state='.$url, $authUrl);
?>

@if(\App::getLocale() == 'en')
    <link rel="stylesheet" href="{{URL::asset('css/ltr/loginPopUpLtr.css?v=2')}}">
@endif

<style>
    .comButLogin {
        color: white;
    }

    .comButLogin:hover {
        color: white;
    }
</style>

{{--loginPopUp--}}
<form id="second_login" method="post" action="{{route('checkLogin')}}">
    {!! csrf_field() !!}
    <input id="form_userName" name="username" type="hidden">
    <input id="form_pass" name="password" type="hidden">
    <input id="redirectUrl" name="redirectUrl" type="hidden">
</form>

<div id="mainLoginPopUp" class="mainLoginPupUpBack hidden">

    <div id="loginPopUp" class="loginPopUpContent">
        <div class="loginHeader row">
            <div class="iconFamily iconClose loginCloseIcon" onclick="closeLoginPopup()"></div>
            <img alt="کوچیتا، سامانه جامع گردشگری ایران" class="loginMainLogo" src="{{URL::asset('images/icons/KOFAV0.svg')}}">
        </div>

        <div class="loginTextHeader row">
            <div class="text">{{__('در کوچیتا ثبت نام کنید')}}</div>
            <a href="{{$authUrl}}" id="googleUrlRedirector" class="googleA">
                <div class="g-signin2">
                    <div style="height:36px;" class="abcRioButton abcRioButtonLightBlue">
                        <div class="abcRioButtonContentWrapper" style="display: flex; box-shadow: 0 2px 4px 0 rgba(0,0,0,.25); direction: ltr; cursor: pointer">
                            <div class="abcRioButtonIcon" style="padding:8px">
                                <div style="width:18px;height:18px;" class="abcRioButtonSvgImageWithFallback abcRioButtonIconImage abcRioButtonIconImage18">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="18px"
                                         height="18px" viewBox="0 0 48 48" class="abcRioButtonSvg">
                                        <g>
                                            <path fill="#EA4335"
                                                  d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"></path>
                                            <path
                                                    fill="#4285F4"
                                                    d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"></path>
                                            <path
                                                    fill="#FBBC05"
                                                    d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"></path>
                                            <path
                                                    fill="#34A853"
                                                    d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"></path>
                                            <path
                                                    fill="none" d="M0 0h48v48H0z"></path>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                            <span class="abcRioButtonContents">
                                <span id="not_signed_inyx5syaq6qblq">{{__('با گوگل وارد شوید')}}</span>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="registerFSection">
            <div class="row">
                <div class="col-md-6 loginInputDiv">
                    <input type="text" id="emailPhone_register" class="loginInput" placeholder="{{__('تلفن همراه یا ایمیل')}}">
                </div>
                <div class="col-md-6 loginInputDiv">
                    <input type="password" id="password_register" class="loginInput" placeholder="{{__('رمز عبور')}}">
                </div>
            </div>
            <div class="row pcMarginTop10">
                <div class="col-sm-6 loginInputDiv nameRegisterDiv">
                    <input type="text" id="username_register" class="loginInput" placeholder="{{__('نام کاربری')}}">
                    <div class="bottomLoginText">
                        {{__('دوستانتان در سایت شما را با این نام خواهند شناخت.')}}
                    </div>
                </div>
                <div class="col-sm-6 loginInputDiv buttonRegisterDiv">
                    <button class="loginRegisterButton" onclick="firstRegisterStep()">{{__('ثبت نام')}}</button>
                    <div class="registerErr" style="color: red;"></div>
                </div>
            </div>
        </div>

        <div class="loginFSection">
            <div class="headerTextF">{{__('اگر در کوچیتا عضو هستید:')}}
            </div>
            <div class="row">
                <div class="col-sm-5 loginInputDiv">
                    <input type="text" id="username_main" class="loginInput" placeholder="{{__('تلفن همراه ، ایمیل یا نام کاربری')}}">
                </div>
                <div class="col-sm-5 loginInputDiv">
                    <input type="password" id="password_main" class="loginInput" placeholder="{{__('رمز عبور')}}">
                    <div class="bottomLoginText forgetPassBut"
                         onclick="openRegisterSection('ForgetPassword');">
                        {{__('رمز عبور خود را فراموش کردید؟')}}
                    </div>
                </div>
                <div class="col-sm-2 loginInputDiv" style="margin-top: 0px">
                    <button class="loginRegisterButton" style="background: var(--koochita-blue); width: 90px;"
                            onclick="login($('#username_main').val(), $('#password_main').val())">{{__('ورود')}}</button>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 loginErr" style="color: red"></div>
            </div>
        </div>
    </div>

    <div id="registerDiv" class="loginPopUpContent hidden" style="justify-content: space-between; flex-direction: row; padding: 15px;">
        <div class="iconFamily iconClose closeLoginPopup" onclick="closeLoginPopup()"></div>

        <div class="registerRightSection">

            <div id="registerMainLogo">
                <img alt="کوچیتا" class="loginMainLogo" src="{{URL::asset('images/icons/KOFAV0.svg')}}">
            </div>

            <div>
                <span id="EnterEmail-loginPopUp" onkeyup="if(event.keyCode == 13) emailRegister()" class="hidden">
                    <div class="mainContentInfos">
                        <div class="header_text font-size-14Imp">{{__('عضو شوید:')}}</div>
                        <div>
                            <div class="loginPopUpLable">{{__('آدرس ایمیل خود را وارد کنید')}}</div>
                            <input type="email" id="emailRegisterInput" class="loginInputTemp" style="width: 100%"
                                   maxlength="40" required autofocus>
                        </div>
                        <div class="pd-tp-8">
                            <p id="loginErrEmail"></p>
                            <div style="display: flex;">
                                <button type="button" onclick="emailRegister()" class="loginSubBtn btn btn-info active" style="margin-left: 10px">{{__('ثبت')}}</button>
                                <button type="button" onclick="Return('EnterEmail-loginPopUp')"
                                        class="loginReturnBtn btn btn-default">{{__('بازگشت')}}</button>
                            </div>
                        </div>
                    </div>
                </span>

                <span id="sendVerifiedPhoneCodeSection" class="hidden"
                      onkeyup="if(event.keyCode == 13) registerWithPhone()">
                    <div class="col-xs-12 rtl mainContentInfos">
                        <div>{{__('لطفا کد اعتبار سنجی را وارد نمایید:')}}</div>
                        <div style="margin-top: 10px">
                            <span class="header_text font-size-12Imp">{{__('این کد به گوشی شما ارسال گردیده است.')}}</span>
                            <div>
                                <div class="loginPopUpLable"> {{__('کد اعتبار سنجی')}} </div>
                                <input class="loginInputTemp" type="text" maxlength="40" id="activationCode" required
                                       autofocus>
                                <p id="loginErrActivationCode" class="loginErrActivationCode"></p>
                            </div>
                            <div id="reminderTimePane" class="reminderTimeDiv"
                                 style="font-size: 13px; margin-bottom: 0px">
                                <span>{{__('زمان باقی مانده برای ارسال مجدد کد اعتبار سنجی شما :')}}</span>
                                <span id="reminderTime" class="reminderTime"></span>
                            </div>
                            <button onclick="resendActivationCode('register', this)" id="resendActivationCode"
                                    class="btn comButLogin resendActivationCode hidden"> {{__('ارسال مجدد کد اعتبار سنجی')}} </button>
                        </div>
                        <hr>
                        <div>
{{--                            <span style="font-size: 12px">{{__('در صورتی که دوستانتان شما را معرفی کرده اند، کد معرف خود را در کادر زیر وارد کنید.')}}</span>--}}
{{--                            <div class="loginRowsPopup loginRowsPopupInline">--}}
{{--                                <span class="loginInputLabel">{{__('کد معرف')}}</span>--}}
{{--                                <input type="text" id="invitationCode" class="loginInputTemp" maxlength="6">--}}
{{--                            </div>--}}
                        </div>
                        <div style="display: flex; margin: 10px 0px;">
                            <input id='checked2' onchange='checkedCheckBox(this)' type='checkbox' value='-1'
                                   style="margin-left: 5px;">
                            <label class='labelForCheckBox' for='checked2'>
                                <span></span>&nbsp;
                            </label>
                            <div style="margin-right: 5px"> {{__('شرایط استفاده و')}}
                                <a target="_blank" href="{{route('policies')}}"
                                   style="color: blue;">{{__('قوانین سایت')}}</a>
                                {{__('را مطالعه کرده و با آن موافقم.')}}
                            </div>
                        </div>
                        <div class="phoneRegisterErr" style="color: red;"></div>
                        <div class="pd-tp-8">
                            <button type="button" onclick="registerWithPhone()"
                                    class="loginSubBtn btn btn-info active submitAndFinishBtn"
                                    disabled>{{__('ثبت نام')}}</button>
                            <button type="button" onclick="Return('sendVerifiedPhoneCodeSection')"
                                    class="loginReturnBtn btn btn-default">{{__('بازگشت')}}</button>
                        </div>
                    </div>
                </span>

                {{--Enter Username in login PopUp--}}
                <span id="EnterUsername-loginPopUp" class="hidden">
                    <div class="col-xs-12 rtl mainContentInfos">
                        <div class="header_text font-size-14Imp font-weight-700">{{__('قدم آخر!')}}</div>
                            <div>
                                <span style="font-size: 12px">{{__('در صورتی که دوستانتان شما را معرفی کرده اند، کد معرف خود را در کادر زیر وارد کنید.')}}</span>
{{--                                <div class="loginRowsPopup loginRowsPopupInline" style="margin-top: 5px">--}}
{{--                                    <span class="loginInputLabel">{{__('کد معرف')}}</span>--}}
{{--                                    <input type="text" id="invitationCode" class="loginInputTemp" maxlength="6">--}}
{{--                                </div>--}}
                            </div>
                            <div style="display: flex; margin: 10px 0px;">
                                <input id='checked1' onchange='checkedCheckBox(this)' type='checkbox' value='-1'
                                       style="margin-left: 5px;">
                                <label class='labelForCheckBox' for='checked1'>
                                    <span></span>&nbsp;
                                </label>
                                <div style="margin-right: 5px"> {{__('شرایط استفاده و')}}
                                    <a target="_blank" href="{{route('policies')}}"
                                       style="color: blue;">{{__('قوانین سایت')}}</a>
                                    {{__('را مطالعه کرده و با آن موافقم.')}}
                                </div>
                            </div>
                            <div>
                                <script defer src='https://www.google.com/recaptcha/api.js?hl=fa'></script>
                                <div class="g-recaptcha" data-sitekey="6LfiELsUAAAAAO3Pk-c6cKm1HhvifWx9S8nUtxTb"></div>
                            </div>
                            <button type="button" onclick="checkRecaptcha()"
                                    class="loginSubBtn btn btn-info active submitAndFinishBtn"
                                    disabled>{{__('ثبت')}}</button>
                            <p id="loginErrUserName"></p>
                    </div>
                </span>

                {{--Forget Password in login PopUp--}}
                <span id="ForgetPassword" class="hidden">
                    <div class="col-xs-12 mainContentInfos">
                        <div style="margin-bottom: 10px">{{__('برای بازیابی رمزعبور تان از کدام طریق اقدام میکنید:')}}</div>
                        <div>
                            <button class="btn showDetailsBtn" onclick="showForgatenPassInput('Email_ForgetPass')">
                                <div class="emailLogo"></div>
                                <span class="float-right">{{__('ایمیل')}}</span>
                            </button>
                            <button class="btn showDetailsBtn" onclick="showForgatenPassInput('Phone_ForgetPass')">
                                <div class="phoneLogo"></div>
                                <span class="float-right">{{__('تلفن همراه')}}</span>
                            </button>
                        </div>
                        <div class="pd-tp-8">
                            <button type="button" onclick="Return('ForgetPassword')"
                                    class="returnBtnForgetPass btn btn-default">{{__('بازگشت')}}</button>
                            <p id="loginErr"></p>
                        </div>
                    </div>
                </span>

                {{--Enter Email for ForgetPass in login PopUp--}}
                <span id="Email_ForgetPass" class="hidden">
                    <div class="col-xs-12 rtl mainContentInfos">
                        <div>
                            <span class="pd-tp-8"> {{__('ایمیل')}} </span>
                            <input class="loginInputTemp" type="email" id="forget_email" maxlength="40" required
                                   autofocus>
                        </div>
                        <div id="reminderTimeEmailForgetPassDiv" class="reminderTimeDiv hidden"
                             style="font-size: 13px; margin-bottom: 0px">
                            <span>{{__('زمان باقی مانده برای ارسال مجدد لینک بازیابی رمز عبور :')}}</span>
                            <span id="reminderTimeEmailForgetPass" class="reminderTime"></span>
                        </div>
                        <button onclick="retrievePasByEmail()" id="resendForgetPassEmailButton"
                                class="btn comButLogin resendActivationCode"
                                style="margin-top: 15px;"> {{__('ارسال لینک بازیابی')}} </button>
                        <div class="pd-tp-8">
                            <button type="button" onclick="Return('Email_ForgetPass')"
                                    class="loginReturnBtn btn btn-default">{{__('بازگشت')}}</button>
                            <p id="loginErrResetPasByEmail"></p>
                        </div>
                    </div>
                </span>

                {{--Enter Phone for ForgetPass in login PopUp--}}
                <span id="Phone_ForgetPass" class="hidden">
                    <div class="col-xs-12 mainContentInfos">
                        <div>
                            <span class="pd-tp-8"> {{__('شماره موبایل خود را وارد نمایید')}} </span>
                            <input class="loginInputTemp" placeholder="09xxxxxxxxx" type="tel" id="phoneForgetPass" maxlength="12" required autofocus>
                            <p id="loginErrResetPasByPhone" style="color: red"></p>
                            <div class="pd-tp-8">
                                <button type="button" onclick="sendForgetPassPhone()" class="loginSubBtn btn btn-info active">{{__('ثبت')}}</button>
                                <button type="button"
{{--                                        onclick="Return('ForgetPassword')"--}}
                                        onclick="Return('Phone_ForgetPass')"
                                        class="loginReturnBtn btn btn-default">{{__('بازگشت')}}</button>
                            </div>
                        </div>
                    </div>
                </span>

                <span id="PhoneCodePasswordForget" class="hidden">
                    <div class="col-xs-12 rtl mainContentInfos">
                        <div>{{__('لطفا کد اعتبار سنجی را وارد نمایید:')}}</div>
                        <div style="margin-top: 10px">
                            <span class="header_text font-size-12Imp">{{__('این کد به گوشی شما ارسال گردیده است.')}}</span>
                            <div>
                                <div class="loginPopUpLable"> {{__('کد اعتبار سنجی')}} </div>
                                <input class="loginInputTemp" type="text" maxlength="40" id="activationCodeForgetPass"
                                       required autofocus>
                                <p id="loginErrActivationCodeForgetPass" class="loginErrActivationCode"
                                   style="color: #963019"></p>
                            </div>
                            <div id="reminderTimePaneForgetPass" class="reminderTimeDiv"
                                 style="font-size: 13px; margin-bottom: 0px">
                                <span>  {{__('زمان باقی مانده برای ارسال مجدد کد اعتبار سنجی شما :')}}</span>
                                <span id="reminderTimeForgetPass" class="reminderTime"></span>
                            </div>
                            <button onclick="resendActivationCode('forget', this)" id="resendActivationCodeForgetPass"
                                    class="btn comButLogin resendActivationCode hidden"> {{__('ارسال مجدد کد اعتبار سنجی')}} </button>
                        </div>
                        <div class="pd-tp-8">
                            <button type="button" onclick="checkValidateForgetPass()"
                                    class="loginSubBtn btn btn-info active">{{__('ثبت')}}</button>
                            <button type="button" onclick="Return('PhoneCodePasswordForget')"
                                    class="loginReturnBtn btn btn-default">{{__('بازگشت')}}</button>
                        </div>
                    </div>
                </span>

                <span id="setNewPassword" class="hidden">
                    <div class="col-xs-12 rtl mainContentInfos">
                        <div>{{__('رمز عبور جدید خود را وارد نمایید:')}}</div>
                        <div style="margin-top: 10px">
                            <div>
                                <div class="loginPopUpLable"> {{__('رمز عبور جدید')}} </div>
                                <input class="loginInputTemp" type="password" id="newPassword" required autofocus>
                            </div>
                        </div>
                        <div class="pd-tp-8">
                            <button type="button" onclick="submitNewPassword()" class="loginSubBtn btn btn-info active">{{__('ثبت')}}</button>
                        </div>
                    </div>
                </span>

            </div>
        </div>

        <div class="registerLeftSection">
            <img alt="کوچیتا، سامانه جامع گردشگری ایران" data-src="{{URL::asset('images/mainPics/bck.webp')}}" class="lazyload resizeImgClass" style="width: 100%;" onload="fitThisImg(this)">
        </div>

    </div>
</div>

<script>
    var csrfToken = '{{csrf_token()}}';
    var login2URl = '{{route('login2')}}';
    var mainLoginDir = '{{route('login2')}}';
    var checkEmailDir = '{{route('checkEmail')}}';
    var checkReCaptcha = '{{route('checkReCaptcha')}}';
    var checkUserNameDir = '{{route('checkUserName')}}';
    var checkReCaptchaDir = '{{route('checkReCaptcha')}}';
    var checkPhoneLoginUrl = '{{route('checkPhoneNum')}}';
    var registerAndLogin = '{{route('registerAndLogin')}}';
    var checkRegisterDataUrl = '{{route('checkRegisterData')}}';
    var retrievePasByPhoneDir = '{{route('retrievePasByPhone')}}';
    var retrievePasByEmailDir = '{{route('retrievePasByEmail')}}';
    var retrievePasByPhoneUrl = '{{route('retrievePasByPhone')}}';
    var retrievePasByEmailUrl = '{{route('retrievePasByEmail')}}';
    var resendActivationCode = '{{route('resendActivationCode')}}';
    var userSetNewPasswordUrl = '{{route('user.setNewPassword')}}';
    var registercheckActivationCode = '{{route('register.checkActivationCode')}}';
    var resendActivationCodeForgetDir = '{{route('resendActivationCodeForget')}}';
</script>

<script src="{{URL::asset('js/pages/login.js')}}"></script>
