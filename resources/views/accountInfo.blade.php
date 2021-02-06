<?php $mode = "profile"; $user = Auth::user(); ?>
@extends('layouts.bodyProfile')

@section('header')

    @parent
    <link rel="stylesheet" type="text/css" media="screen, print" href="{{URL::asset('css/shazdeDesigns/account_info.css')}}"/>
    <link rel="stylesheet" type="text/css" media="screen, print" href="{{URL::asset('css/shazdeDesigns/abbreviations.css')}}"/>
@stop

@section('main')
    <div id="MAIN" class="Settings prodp13n_jfy_overflow_visible">
        <div id="BODYCON" class="col easyClear poolB adjust_padding new_meta_chevron_v2">
            <div class="wrpHeader">
            </div>
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
                                        <div class="col five">
                                            <fieldset>
                                              <label for="username">نام کاربری (این نام معرف شما برای دیگران است.)
                                                  <div id="accountInfoUserNameDiv"></div>
                                              </label>
                                                <input placeholder="نام کاربری" class="text memberData formElem" type="text" name="username" id="userName" value="{{$user->username}}" onchange="changeUserName(this.value)"/>
                                            </fieldset>
                                        </div>

                                    </div>
                                    <div class="row">

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
                                        <div class="col twelve">
                                            <fieldset>
                                                <label for="email">ایمیل</label>
                                                <div class="alt_emails" id='alt_emails'>
                                                    <div data-index="0">
                                                        <input placeholder="ایمیل" class="text memberData email primaryEmail formElem" type="email" name="email" id="email" value="{{$user->email}}" onchange="changeUserEmail(this.value)"/>
                                                    </div>
                                                    <!-- /oxEach -->
                                                </div>

                                            </fieldset>
                                        </div>
                                    </div>


                                    <div class="row">

                                        <div class="col twelve">
                                            <fieldset>
                                                <label for="phone"> تلفن تماس</label>
                                                <input id="phone" placeholder="تلفن تماس" class="text phoneData formElem" type="text" name="phone" onchange="changeUserPhoneNumber(this.value)" value="{{$user->phone}}"/><br><span class="numbersonly">در صورت اطلاع از تلفن تماس شما می‌توانیم با شما در ارتباط باشیم</span>
                                            </fieldset>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col five" style="display: flex; flex-direction: column;">
                                            <h5 class="accountInfoHelpTexts">
                                                <ul id="section1Errors"></ul>
                                            </h5>

                                            <h5 id="sendPhoneRegister" class="accountInfoHelpTexts" style="display: {{$isAcitveCode ? 'block' : 'none'}}">کد اعتبارسنجی به شماره وارد شده ارسال گردید</h5>
                                            <h5 id="remainingSendPhoneRegister" class="accountInfoHelpTexts" style="display: none;">از آخرین ارسال پیامک باید 5 دقیقه بگذرد</h5>

                                            <div class="col-xs-12 registerPhoneField" style="display: {{$isAcitveCode ? 'block' : 'none'}}">
                                                <label for="activationCode">کد اعتبارسنجی</label>
                                                <input id="activationCode" type="text">
                                            </div>

                                            <div class="col-xs-12 mg-tp-10 registerPhoneField" style="display: {{$isAcitveCode ? 'block' : 'none'}}">
                                                <span onclick="checkAuth()" class="btn btn-success">اعمال کد</span>
                                                <span onclick="resend()" id="resend" class="btn btn-primary" disabled>دریافت مجدد کد</span>
                                            </div>

                                            <div class="col-xs-12 mg-tp-10 registerPhoneField" style="display: {{$isAcitveCode ? 'block' : 'none'}}">
                                                <p><span>زمان باقی مانده برای ارسال مجدد کد</span><span>&nbsp;</span><span id="reminderTime"></span></p>
                                            </div>

                                            <div class="col-xs-12 mg-tp-10">
                                                <h5 id="errAuth"></h5>
                                            </div>


                                            <fieldset id="storeButtonSection1">
                                                <input id="savePass1Info" type="button" name="savePass1Info" class="btn btn-success" value="ذخیره" onclick="section1Store()">
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                                </form>

                                <h1 class="heading wrap" id="HEADER_DEFAULT2">
                                    درباره من
                                </h1>

                                <form method="post" action="{{route('updateProfile2')}}" class="mc-form mc-grid account_info_form">
                                    {{csrf_field()}}
                                    <div class="mainDivAccountField">
                                        <div class="row">
                                            <fieldset>
                                                <label class="subtitle personalDescription">خودتان را توصیف کنید</label>
                                                <textarea placeholder="خودتان را توصیف کنید" id="introduceYourSelfTextBox" name="introduction" requiredclass="field textBox" rows="5" cols="50" maxlength="1000">{{$user->introduction}}</textarea>
                                            </fieldset>

                                            <div class="col">
                                                <fieldset class="pd-tp-35">

                                                    <label class="fieldLabel" for="age">سن</label>
                                                    <select id="age" class="field dropdown" name="ageId">
                                                        <option class="dropdownItem" value="0">انتخاب</option>
                                                        @foreach($ages as $age)
                                                            @if($user != null && $user->ageId == $age->id)
                                                                <option class="dropdownItem" selected value="{{$age->id}}">{{$age->name}}</option>
                                                            @else
                                                                <option class="dropdownItem" value="{{$age->id}}">{{$age->name}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>

                                                </fieldset>
                                            </div>

                                            <div class="col">
                                                <fieldset class="pd-tp-35">

                                                        <label class="fieldLabel" for="gender">جنسیت</label>
                                                {{--<div class="dropdownBox">--}}
                                                        <select id="gender" class="field dropdown" name="sex">

                                                            @if($user->sex == null || $user->sex == 2)
                                                                <option class="dropdownItem" selected value="2">ترجیح میدم جواب ندهم</option>
                                                            @else
                                                                <option class="dropdownItem" value="2">ترجیح میدم جواب ندهم</option>
                                                            @endif

                                                            @if($user->sex != null && $user->sex == 0)
                                                                <option class="dropdownItem" selected value="f">زن</option>
                                                            @else
                                                                <option class="dropdownItem" value="f">زن</option>
                                                            @endif

                                                            @if($user->sex != null && $user->sex == 1)
                                                                <option class="dropdownItem" selected value="m">مرد</option>
                                                            @else
                                                                <option class="dropdownItem" value="m">مرد</option>
                                                            @endif
                                                        </select>
                                                {{--</div>--}}
                                            </fieldset>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <fieldset >
                                                    <input type="button" id="savePass2Info" class="btn btn-success" name="savePass2Info" value="ذخیره" onclick="section2Store()">
                                                </fieldset>
                                                <h5 class="accountInfoHelpTexts"></h5>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <h1 class="heading wrap" id="HEADER_DEFAULT3">
                                    رمز عبور
                                </h1>

                                <span id="ERRORS">
                                   <ul id="errors" class="errors"></ul>
                                </span>

                                <form action="{{route('changePas')}}" method="post" class="mc-form mc-grid account_info_form">
                                    {{csrf_field()}}
                                    <div class="mainDivAccountField">
                                        <div class="row">
                                            <div class="col">

                                                <fieldset>
                                                    <label>رمز عبور فعلی </label>
                                                    <input placeholder="رمز عبور فعلی" type="password" name="oldPassword" class="fauxInput"/>
                                                </fieldset>

                                                <fieldset>
                                                    <label>رمز عبور جدید </label>
                                                    <input placeholder="رمز عبور جدید" type="password" name="newPassword" class="fauxInput"/>
                                                </fieldset>

                                                <fieldset>
                                                    <label>تکرا رمز عبور جدید</label>
                                                    <input placeholder="تکرار رمز عبور جدید" type="password" name="repeatPassword" class="fauxInput"/>
                                                </fieldset>

                                                <fieldset class="pd-tp-20">
                                                    <input id="changePasswordAccountInfo" type="submit" class="btn btn-success" value="تغییر رمز عبور">
                                                </fieldset>
                                                @if($mode2 == 3)
                                                    <h5 class="accountInfoHelpTexts">{{$msg}}</h5>
                                                @endif
                                            </div>
                                        </div>
                                        <hr/>

                                        {{--<span onclick="openSpan()" class="pd-rt-12 taLnk closeAccount">حذف کامل صفحه کاربری</span>--}}
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="hideOnScreen footerOptimizer">

                    </div>
                    <div class="ui_overlay ui_modal editTags" id="deleteProfile">

                    <p>آیا از حذف کامل اطلاعات کاربری خود مطمئن هستید ؟</p>
                    <p class="font-size-10">با این کار تمام فعالیت های شما به همراه این حساب کاربری برای همیشه حذف خواهد شد.</p>
                    <br><br>
                    <div class="body_text">

                        <div class="submitOptions">
                            <button id="ensureBtnDeleteAccountAccountInfo" onclick="deleteAccount()" class="btn btn-success">مطمئنم</button>
                            <input type="submit" onclick="closeSpan()" value="لغو" class="btn btn-default">
                        </div>
                    </div>
                    <div onclick="closeSpan()" class="ui_close_x"></div>

                </div>

                    <div style="display: flex; justify-content: center; align-items: center">
                        <a href="{{route('logout')}}" class="btn btn-danger" style="color: white">خروج از حساب کاربری</a>
                    </div>
                </div>
                <div class="footerOptimizer hideOnScreen"></div>

            </div>
        </div>
        <div class="ui_backdrop dark display-none"></div>
    </div>
    <script>

        var deleteAccountDir = '{{route('deleteAccount')}}';
        var mainPage = '{{route('main')}}';
        var searchInCities = '{{route('searchInCities')}}';
        var reminderTime;

        function closeSpan(){
            $('.dark').hide();
            $('#deleteProfile').css('visibility','hidden');
        }

        function openSpan(){
            $('#deleteProfile').css('visibility','visible');
            $('.dark').show();
        }

        function deleteAccount() {
            $.ajax({
                type: 'post',
                url: deleteAccountDir,
                success: function (response) {
                    if(response == 'ok')
                        document.location.href = mainPage;
                }
            });
        }

        function openSearchFindCityFormAccountInfo(){
            createSearchInput('searchCityForAccountInfo', 'نام شهر را وارد کنید.');
        }

        function searchCityForAccountInfo(_element) {

            activeCityFilter = false;
            var value = _element.value;

            if(value.trim().length > 1){
                $.ajax({
                    type: 'post',
                    url: searchInCity,
                    data: {
                        _token: '{{csrf_token()}}',
                        'key':  value
                    },
                    success: function (response) {

                        $("#resultCity").empty();

                        if(response.length == 0)
                            return;

                        response = JSON.parse(response);

                        var newElement = "";

                        for(i = 0; i < response.length; i++) {
                            newElement += '<div onclick="setCityNameInAccountInfo(\'' + response[i].cityName + '\', \'' + response[i].id + '\')"><div class="icons location spIcons"></div>' +
                                            '<p class="suggest cursor-pointer font-weight-700" id="suggest_1" style="margin: 0px">شهر ' + response[i].cityName + '</p>' +
                                            '<p class="suggest cursor-pointer stateName" id="suggest_1">' + response[i].stateName + '</p></div>';
                        }
                        setResultToGlobalSearch(newElement);
                    }
                });
            }
            else
                clearGlobalResult();
        }

        function setCityNameInAccountInfo(_cityName, _id){
            closeSearchInput();
            $("#cityName").val(_cityName);
            $("#cityId").val(_id);
        }

        function changeUserName(_value, _callBack = ''){

            if(_value.trim().length > 3){
                $('#usernameError1').remove();

                $.ajax({
                    type: 'post',
                    url: '{{route("checkUserName")}}',
                    data: {
                        _token: '{{csrf_token()}}',
                        username: _value
                    },
                    success: function(response){
                        if(response == 'ok') {
                            $('#usernameError2').remove();
                            if (typeof _callBack == "function")
                                _callBack();
                        }
                        else if(response == 'nok1'){
                            $('#usernameError2').remove();
                            text = '<li id="usernameError2">نام کاربری تکراری می باشد</li>';
                            $('#section1Errors').append(text);
                            $('#fullPageLoader').css('display', 'none');
                        }

                    }
                })
            }
            else{
                $('#usernameError1').remove();
                text = '<li id="usernameError1">نام کاربری باید بیش از 3 حرف داشته باشد</li>';
                $('#section1Errors').append(text);
            }
        }

        function changeUserEmail(_email, _callBack = ''){
            $.ajax({
                type: 'post',
                url: '{{route("checkEmail")}}',
                data: {
                    _token: '{{csrf_token()}}',
                    email: _email
                },
                success: function (response){
                    $('#emailError').remove();

                    if(response == 'nok'){
                        text = '<li id="emailError">ایمیل وارد شده تکراری می باشد.</li>';
                        $('#section1Errors').append(text);
                        $('#fullPageLoader').css('display', 'none');
                    }
                    else {
                        if (typeof _callBack == "function")
                            _callBack();
                    }
                }
            })
        }

        function changeUserPhoneNumber(_phoneNumber, _callBack = '') {
            $.ajax({
                type: 'post',
                url: '{{route("checkPhoneNum")}}',
                data: {
                    _tokne: '{{csrf_token()}}',
                    phoneNum : _phoneNumber
                },
                success: function(response){
                    $('#phoneError').remove();

                    if(response != 'ok'){
                        text = '<li id="phoneError">شماره تماس وارد شده تکراری می باشد.</li>';
                        $('#section1Errors').append(text);
                        $('#fullPageLoader').css('display', 'none');
                    }
                    else{
                        if (typeof _callBack == "function")
                            _callBack();
                    }
                }
            })
        }

        function section1Store(){
            var firstName = $('#firstName').val();
            var lastName = $('#lastName').val();
            var userName = $('#userName').val();
            var cityId = $('#cityId').val();
            var email = $('#email').val();
            var phone = $('#phone').val();

            $('#fullPageLoader').css('display', 'flex');
            changeUserName(userName, function(){
                changeUserPhoneNumber(phone, function () {
                    changeUserEmail(email, function () {
                        if ($('#section1Errors').children().length == 0) {
                            $.ajax({
                                type: 'post',
                                url: '{{route("updateProfile1")}}',
                                data: {
                                    _token: '{{csrf_token()}}',
                                    firstName: firstName,
                                    lastName: lastName,
                                    userName: userName,
                                    cityId: cityId,
                                    email: email,
                                    phone: phone,
                                },
                                success: function (response) {
                                    response = JSON.parse(response);
                                    $('#fullPageLoader').css('display', 'none');

                                    if (response['status'] == 'ok') {
                                        alert('تغییرات با موفقیت ثبت شد');
                                        if (response['time']) {
                                            reminderTime = response['time'];
                                            $('.registerPhoneField').css('display', 'block');
                                            $('#sendPhoneRegister').css('display', 'block');
                                            decreaseTime();
                                        }

                                    }
                                    else {
                                        alert('در تغییر مشکلی پیش امده دوباره تلاش کنید.');
                                    }
                                }
                            })
                        }
                        else
                            $('#fullPageLoader').css('display', 'none');
                    });
                });
            });

        }

        function decreaseTime() {

            $("#reminderTime").text((reminderTime % 60) + " : " + Math.floor(reminderTime / 60));

            if(reminderTime > 0) {
                reminderTime--;
                setTimeout("decreaseTime()", 1000);
            }
            else {
                $("#resend").removeAttr('disabled');
            }
        }

        function checkAuth() {

            if ($("#activationCode").val() == "")
                return;

            var phone = $('#phone').val();

            $.ajax({
                type: 'post',
                url: '{{route('checkAuthCode')}}',
                data: {
                    'phoneNum': $('#phone').val(),
                    'code': $("#activationCode").val()
                },
                success: function (response) {
                    if (response == "ok")
                        document.location.href = '{{route('profile.accountInfo')}}';
                    else {
                        $("#errAuth").empty().append('کد وارد شده نامعتبر می باشد');
                    }
                }
            });
        }

        function resend() {

            $.ajax({
                type: 'post',
                url: '{{route('resendAuthCode')}}',
                data: {
                    'phoneNum':  $('#phone').val()
                },
                success: function (response) {

                    response = JSON.parse(response);

                    if(response.msg == "ok") {
                        $("#errAuth").empty().append('کد اعتبارسنجی مجددا برای شما ارسال گردید');
                        $("#resend").attr('disabled', 'disabled');
                    }
                    else {
                        $("#errAuth").empty().append('از آخرین ارسال پیامک باید 5 دقیقه بگذرد');
                    }

                    reminderTime = response.reminder;
                    decreaseTime();
                }
            });
        }

        function section2Store(){
            $('#fullPageLoader').css('display', 'flex');
            var sex = $('#gender').val();
            var introduction = $('#introduceYourSelfTextBox').val();
            var age = $('#age').val();

            $.ajax({
                type: 'post',
                url: '{{route("updateProfile2")}}',
                data:{
                    _token: '{{csrf_token()}}',
                    sex: sex,
                    ageId: age,
                    introduction: introduction
                },
                success: function(response){
                    $('#fullPageLoader').css('display', 'none');
                    if(response == 'ok'){
                        alert('تغییرات با موفقیت ثبت شد')
                    }
                },
                error: function(response){
                    $('#fullPageLoader').css('display', 'none');
                }
            })
        }

    </script>

@stop
