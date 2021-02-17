<?php $mode = "profile"; $user = Auth::user(); ?>
@extends('layouts.bodyProfile')

@section('header')

    @parent
    <link rel="stylesheet" type="text/css" media="screen, print" href="{{URL::asset('css/shazdeDesigns/account_info.css')}}"/>
    <link rel="stylesheet" type="text/css" media="screen, print" href="{{URL::asset('css/shazdeDesigns/abbreviations.css')}}"/>


    <style>
        .addNewReviewButtonMobileFooter{
            display: none;sa
        }
    </style>
    <title>تنظیمات اطلاعات کاربری</title>
@stop

@section('main')
    <div id="MAIN" class="Settings prodp13n_jfy_overflow_visible">
        <div id="BODYCON" class="col easyClear poolB adjust_padding new_meta_chevron_v2">
            <div class="wrpHeader"></div>

            <div id="main_content" class="accountInfoMainDiv">
                <h1 class="heading wrap" id="HEADER_DEFAULT"> اطلاعات کاربری </h1>
                @if($mode2 == 0)
                    <script>
                        showSuccessNotifi('{{$msg}}');
                    </script>
                @endif

                <div id="modules_content">
                    <div id="ACCOUNT_INFO">
                        <div class="modules-membercenter-account-info">
                            <div class="settings_account_info">

                                <form  class="mc-form mc-grid account_info_form">
                                    <div class="mainDivAccountField">
                                        <div class="row">
                                            <div class="col five">
                                                <fieldset>
                                                    <label for="firstName"> نام</label>
                                                    <input class="text memberData formElem " type="text" name="firstName" id="firstName" placeholder="نام" value="{{$user->first_name}}"/>
                                                </fieldset>
                                            </div>
                                            <div class="col five">
                                                <fieldset>
                                                    <label for="lastName">نام خانوادگی</label>
                                                    <input class="text memberData formElem " type="text" name="lastName" id="lastName" placeholder="نام خانوادگی" value="{{$user->last_name}}"/>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <fieldset>
                                                    <label for="ageAccountInfoInput" class="fieldLabel">سن</label>
                                                    <input type="number" class="text memberData formElem" id="ageAccountInfoInput" min="0" value="{{$user->age}}">
                                                </fieldset>
                                            </div>
                                            <div class="col-md-6" style="padding: 0px">
                                                <fieldset>
                                                    <label for="genderAccountInfoInput" class="fieldLabel">جنسیت</label>
                                                    <select id="genderAccountInfoInput" class="text memberData formElem" name="sex">
                                                        <option class="dropdownItem" value="2" {{$user->sex == 2 || $user->sex == null ? 'selected' : ''}}>ترجیح میدم جواب ندهم</option>
                                                        <option class="dropdownItem" value="1" {{$user->sex == 1 ? 'selected' : ''}}>مرد</option>
                                                        <option class="dropdownItem" value="0" {{$user->sex == 0 ? 'selected' : ''}}>زن</option>
                                                    </select>
                                                </fieldset>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col twelve">
                                                <fieldset>
                                                    <label for="cityName">شهر محل سکونت</label>
                                                    <input autocomplete="off" class="text memberData formElem" name="cityName" type="text" maxlength="40" id="cityName" value="{{$user->cityName}}" onclick="openSearchFindCityFormAccountInfo()" readonly>
                                                    <input type="hidden" name="cityId" id="cityId" value="{{$user->cityId}}">
                                                </fieldset>
                                                <div class="hidden" id="result"></div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <fieldset>
                                                    <label class="subtitle personalDescription">خودتان را توصیف کنید</label>
                                                    <textarea placeholder="خودتان را توصیف کنید" id="introduceYourSelfTextBox" requiredclass="field textBox" rows="5" cols="50" maxlength="1000" style="width: 100%">{{$user->introduction}}</textarea>
                                                </fieldset>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <fieldset id="storeButtonSection1">
                                                <input id="savePass1Info" type="button" name="savePass1Info" class="btn btn-success" value="ذخیره" onclick="updateGeneralInfo()">
                                            </fieldset>
                                        </div>
                                    </div>
                                </form>

                                <hr>
                                <div class="mc-form mc-grid account_info_form">
                                    <div class="mainDivAccountField">
                                        <div class="row">
                                            <div class="col five">
                                                <fieldset>
                                                    <label for="username">نام کاربری (این نام معرف شما برای دیگران است.)
                                                        <div id="accountInfoUserNameDiv"></div>
                                                    </label>
                                                    <input placeholder="نام کاربری" class="text memberData formElem" type="text" id="userNameFieldInput" value="{{$user->username}}">
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div id="usernameError" class="col five"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col five">
                                                <button class="btn" style="background: var(--koochita-light-green);color: white;" onclick="changeUserName()">ویرایش نام کاربری</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div class="mc-form mc-grid account_info_form">
                                    <div class="mainDivAccountField">

                                        <div id="phoneEnterRow">
                                            <div class="row">
                                                <div class="col twelve">
                                                    <fieldset>
                                                        <label for="phoneAccountInfoInput"> تلفن تماس</label>
                                                        <input id="phoneAccountInfoInput" placeholder="تلفن تماس" class="text phoneData formElem" type="text" value="{{$user->phone}}"/>
                                                        <br>
                                                        <span class="numbersonly">در صورت اطلاع از تلفن تماس شما می‌توانیم با شما در ارتباط باشیم</span>
                                                    </fieldset>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col five">
                                                    <button id="editPhoneButton" class="btn" style="background: var(--koochita-light-green);color: white;" onclick="changeUserPhoneNumber()">ویرایش شماره تماس</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="phoneVerificationCode" class="hidden">
                                            <div class="row">
                                                <div class="col five" style="display: flex; flex-direction: column;">
                                                    <h5 class="accountInfoHelpTexts" style="display: {{$isAcitveCode ? 'block' : 'none'}}">کد اعتبارسنجی به شماره وارد شده ارسال گردید</h5>

                                                    <div class="col-xs-12 registerPhoneField">
                                                        <label for="activationCode">
                                                            <span>کد اعتبارسنجی</span>
                                                            <span id="sendPhoneNumber"></span>
                                                        </label>
                                                        <input id="activationCode" type="text" class="form-control">
                                                    </div>

                                                    <div class="col-xs-12 mg-tp-10 registerPhoneField">
                                                        <button type="button" class="btn btn-success" onclick="checkPhoneVerifyCode()">اعمال کد</button>
                                                        <button type="button" id="resendPhoneCodeButton" class="btn btn-primary" onclick="changeUserPhoneNumber()" disabled>
                                                            <span>دریافت مجدد کد:</span>
                                                            <span id="remainderTimeForPhoneVerify">00:00</span>
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div id="phoneError" class="col five"></div>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div class="mc-form mc-grid account_info_form">
                                    <div class="mainDivAccountField">
                                        <div class="row">
                                            <div class="col five">
                                                <fieldset>
                                                    <label for="email">ایمیل</label>
                                                    <input placeholder="ایمیل" class="text memberData email primaryEmail formElem" type="email" id="emailAccountInfoInput" value="{{$user->email}}"/>
                                                </fieldset>
                                            </div>
                                            <div class="col five">
                                                <fieldset>
                                                    <label for="instagramAccountInfoInput">اینستاگرام</label>
                                                    <input placeholder="اینستاگرام" class="text memberData formElem" type="text" id="instagramAccountInfoInput" value="{{$user->instagram}}"/>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div id="socialError"  class="col-md-12"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col five">
                                                <button class="btn" style="background: var(--koochita-light-green);color: white;" onclick="doEditSocialInfo()">ثبت</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h1 class="heading wrap" id="HEADER_DEFAULT3"> رمز عبور</h1>

                                <div style="color: red; font-size: 18px;">
                                    @if(session('passStatus') === 'ok')
                                        <script>
                                            showSuccessNotifi('رمز عبور شما با موفقیت تغییر یافت', 'left', 'var(--koochita-blue)');
                                        </script>
                                    @elseif(session('passStatus'))
                                        <script>
                                            showSuccessNotifi('خطا', 'left', 'red');
                                        </script>
                                        @if(session('passStatus') === 'error')
                                            <div>خطا در تغییر رمز عبور</div>
                                        @elseif(session('passStatus') === 'min6')
                                            <div>رمز عبور حداقل باید 6 کاراکتر باشد</div>
                                        @elseif(session('passStatus') === 'notSame')
                                            <div>رمز عبور و تکرار ان یکی نیست</div>
                                        @endif
                                    @endif
                                </div>
                                <form action="{{route('profile.accountInfo.editPassword')}}" method="post" class="mc-form mc-grid account_info_form">
                                    {{csrf_field()}}

                                    <div class="mainDivAccountField">
                                        <div class="row">
                                            <div class="col">
                                                <fieldset>
                                                    <label>رمز عبور جدید </label>
                                                    <input placeholder="رمز عبور جدید" type="password" name="password" class="fauxInput"/>
                                                </fieldset>
                                                <fieldset>
                                                    <label>تکرا رمز عبور جدید</label>
                                                    <input placeholder="تکرار رمز عبور جدید" type="password" name="repPassword" class="fauxInput"/>
                                                </fieldset>

                                                <fieldset class="pd-tp-20">
                                                    <input id="changePasswordAccountInfo" type="submit" class="btn btn-success" value="تغییر رمز عبور">
                                                </fieldset>
                                            </div>
                                        </div>
                                        <hr/>

                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; justify-content: center; align-items: center">
                        <a href="{{route('logout')}}" class="btn btn-danger" style="color: white">خروج از حساب کاربری</a>
                    </div>

                </div>

            </div>
        </div>
        <div class="ui_backdrop dark display-none"></div>
    </div>
    <script>
        {{--var deleteAccountDir = '{{route('deleteAccount')}}';--}}
        var mainPage = '{{route('main')}}';
        var searchInCities = '{{route('searchInCities')}}';
        var searchForCityAccountInfoUrl = '{{route("searchForCity")}}';
        var editUsernameAccountInfoUrl = '{{route("profile.accountInfo.editUsername")}}';
        var checkPhoneAccountInfoUrl = '{{route("checkPhoneNum")}}';
        var editPhoneNumberAccountInfoUrl = '{{route("profile.accountInfo.editPhoneNumber")}}';
        var editGeneralInfoAccountInfoUrl = '{{route("profile.accountInfo.editGeneralInfo")}}';
        var editSocialInfoAccountInfoUrl = '{{route("profile.accountInfo.editSocialInfo")}}';
    </script>

    <script src="{{URL::asset('js/pages/profile/accountInfo.js')}}"></script>

@stop
