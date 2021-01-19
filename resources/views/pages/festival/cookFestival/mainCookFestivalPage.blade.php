<!doctype html>
<html lang="fa">
<head>
    @include('layouts.topHeader')
    <title>مسابقه آشپزی با کوچیتا</title>
    <style>
        :root{
            --cook-orange: #FD7B5C;
        }
        .mainBody{
            width: 100%;
            min-height: 100vh;
            direction: rtl;
            background: #FFE0C5;
        }
        .header{
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }
        .header .koochitaImg{
            height: 45px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .koochitaTitleSidePic{
            position: fixed;
            top: 10%;
            left: 20%;
            width: 25%;
        }
        .koochitaTitleSidePic img{
            width: 100%;
        }
        .sideMainPic{
            z-index: 1;
            position: fixed;
            bottom: 0px;
            left: 0px;
            width: 56%;
            background-image: url("{{URL::asset('images/festival/cookFestival/mainCookPic.svg')}}");
            background-size: contain;
            height: 65%;
            background-repeat: no-repeat;
            background-position: bottom;
        }
        .sideMainPic img{
            width: 100%;
        }

        .commonBody{
            position: relative;
            z-index: 9;
            padding: 0px 5%;
            width: 40%;
            padding-left: 0;
        }
        .commonBody .topText{
            color: #707070;
            font-size: 24px;
            padding: 0px 0px;
            margin: 20px 0px;
        }
        .commonBody .bigText{
            font-size: 1em;
        }
        .commonBody .smallText{
            font-size: .8em;
        }
        .commonBody .loginButton{
            color: black;
            cursor: pointer;
        }
        .commonBody .inputCol{
            margin-bottom: 20px;
        }
        .commonBody .inputCol input{
            background: white;
            border: solid 1px var(--cook-orange);
            font-size: 22px;
            border-radius: 100px;
            padding: 15px 5%;
            width: 100%;
            box-shadow: 0px 3px 6px 0px rgba(0, 0, 0, 0.2);
            color: var(--cook-orange);
        }
        .commonBody .inputCol input::placeholder{
            color: #fd7b5c73;
        }

        .inputCol.hasError input{
            background: #ffd3d3;
        }
        .inputCol .smallText{
            font-size: 14px;
            color: #707070;
            padding: 10px 5%;
            padding-bottom: 0px;
        }
        .orangeButton{
            background: var(--cook-orange);
            border: none;
            color: white;
            border-radius: 100px;
            font-size: 25px;
            width: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: auto;
            padding: 10px 0px;
            box-shadow: 0px 3px 6px 0px rgba(0, 0, 0, 0.2);
            margin-top: 30px;
        }
        .orangeButton:disabled{
            opacity: .5;
            cursor: not-allowed;
        }

        .step1{
            width: 100%;
            padding-top: 5%;
            display: flex;
        }
        .step1Content > div{
            width: 80%;
        }
        .step1Content > div > img{
            width: 100%;
        }
        .step1 .registerInCook{
            color: #707070;
            text-align: center;
            justify-content: center;
            align-items: center;
            display: flex;
            flex-direction: column;
            margin-top: 40px;
        }
        .step1 .registerInCook .text{
            font-size: 25px;
        }
        .step1 .registerInCook .orangeButton{
            margin: 0;
            margin-top: 5px;
        }

        .commonBody.uploadStep{
            width: 80%;
            margin-left: auto;
            position: absolute;
            bottom: 35px;
        }
        .uploadStep .helloText{
            font-size: 25px;
            color: #707070;
            margin-bottom: 5px;
        }
        .uploadStep .inputCol input{
            font-size: 16px;
            width: 300px;
            padding: 10px 20px;
        }
        .uploadSec{
            height: 50vh;
            border-radius: 20px;
            background: #fd7b5c69;
            border: solid 2px var(--cook-orange);
            overflow: auto;
        }
        .uploadSec .uploadeShowResults{
            display: flex;
            flex-wrap: wrap;
        }
        .uploadSec.highlight{
            box-shadow: 0px 0px 8px 5px var(--cook-orange);
        }
        .uploadSec .uploadButton{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            font-weight: bold;
            color: var(--cook-orange);
            WIDTH: 120px;
            text-align: center;
            font-size: 10px;
        }
        .uploadSec .uploadButton:before{
            font-size: 50px;
        }
        .submitUploadButton.orangeButton{
            width: 300px;
            margin-left: auto;
            margin-right: 0;
        }

        .commonBody.step3{
            height: 75vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .registerBody .remaindSec{
            display: flex;
            align-items: center;
        }
        .registerBody .remaindSec .text{
            color: #707070;
            font-size: 18px;
        }
        .registerBody .remaindSec .remaindeTimer{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-right: 15px;
        }
        .registerBody .remaindSec .remaindeTimer .numberSec{
            background: white;
            padding: 5px 20px;
            border-radius: 20px;
            border: solid 1px var(--cook-orange);
            color: var(--cook-orange);
        }
        .registerBody .remaindSec .remaindeTimer .againButton{
            color: var(--cook-orange);
        }
        .registerBody .remaindSec .remaindSecButton{
            font-size: 10px;
            padding: 6px 10px;
            width: auto;
            margin: 0px 7px;
        }


        .foodSearchResult{
            padding: 2px 10px;
        }
        .foodSearchResult:hover{
            background: var(--cook-orange);
            color: white;
        }

        .step1ListContent{
            padding: 10px;
            overflow: auto;
            max-width: 450px;
            margin-right: auto;
            position: fixed;
            left: 0px;
            height: 100vh;
            top: 0px;
            background: #ce7b75ab;
        }
        .step1ListContent .title{
            text-align: center;
            font-size: 32px;
            font-weight: bold;
            color: white;
            margin: 20px 0px;
            text-shadow: 3px 5px 7px #000000;
        }
        .step1ListContent .videoCardList .videoCard{
            width: 150px;
            height: 150px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 20px;
            box-shadow: 0px 0px 10px 2px black;
            cursor: pointer;
            margin-bottom: 25px;
            position: relative;
        }
        .step1ListContent .videoCardList .videoCard.playIcon:before{
            position: absolute;
            height: 100%;
            width: 100%;
            background: #00000061;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 70px;
            transition: .3s;
        }
        .step1ListContent .videoCardList .videoCard.playIcon:hover:before{
            transform: scale(1.2);
        }
        .step1Content{
            width: 49%;
        }
        @media (max-width: 1100px) {
            .commonBody .inputCol{
                margin-bottom: 10px;
            }
            .commonBody .inputCol input{
                font-size: 18px;
                padding: 10px 5%;
            }

        }

        @media (max-width: 767px) {
            .step1{
                flex-direction: column;
                padding-right: 0px;
            }
            .step1Content{
                width: 100%;
            }
            .header{
                display: none;
            }
            .koochitaTitleSidePic{
                top: 0;
                right: 0px;
                width: 100%;
                left: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                position: relative;
            }
            .koochitaTitleSidePic img{
                max-height: 100px;
                width: auto;
                margin-top: 10px;
            }
            .commonBody{
                width: 100%;
            }
            .loginBody{
                padding: 0px 20px;
                max-width: 400px;
                margin: 0px auto;
            }

            .sideMainPic{
                width: 100%;
                z-index: 1;
                opacity: .3;
            }
            .step1Content > div{
                width: 90%;
                max-width: 250px;
                margin: 0px auto;
            }
            .step1 .registerInCook .text{
                color: #3a3a3a;
                font-weight: bold;
            }
            .commonBody.uploadStep{
                width: 100%;
                padding: 0px 30px;
                bottom: 30px;
                position: absolute;
            }
            .uploadSec{
                height: 40vh;
            }

            .step1ListContent{
                width: 100% !important;
                max-width: 100% !important;
                height: auto;
                overflow: auto;
                position: relative;
            }
            .step1ListContent .videoCardList{
                margin: 0px;
                flex-direction: row;
                display: flex;
                justify-content: center;
                min-width: 100%;
                width: 600px;
                max-width: 1000px;
                padding: 10px;
            }
            .step1ListContent .title{
                font-size: 18px;
                margin: 0;
                margin-bottom: 10px;
            }
            .step1ListContent .videoCardList .videoCard{
                margin: 0px 20px !important;
                width: 100px;
                height: 100px;
                border-radius: 10px;
            }
        }

        @media (max-width: 400px) {
            .commonBody .inputCol input{
                width: 100%;
            }

        }
    </style>

    <script defer src="{{URL::asset('js/uploadLargFile.js')}}"></script>
</head>
<body>

    @include('general.forAllPages')

    <div class="mainBody">
        <div class="header">
            <a href="{{url('/')}}" class="koochitaImg">
                <img src="{{URL::asset('images/icons/mainLogo.png')}}" alt="koochita" style="height: 100%">
            </a>
        </div>
        <div class="koochitaTitleSidePic">
            <img src="{{URL::asset('images/festival/cookFestival/cookKoochitaTitleText.svg')}}" alt="عنوان کوچیتا">
        </div>
        <div class="sideMainPic"></div>

        <div id="step1" class="commonBody step1">
            <div class="step1Content">
                <div class="topPic">
                    <img src="{{URL::asset('images/festival/cookFestival/doCook.svg')}}" alt="doCook">
                </div>
                <div class="secondPic" style="margin-right: auto">
                    <img src="{{URL::asset('images/festival/cookFestival/takePhotoVideo.svg')}}" alt="takePhoto">
                </div>
                <div class="step1ListContent hideOnScreen">
                    <div class="title"> آثار ارسالی شما</div>
                    <div class="videoCardList">
                        <div class="videoCard playIcon" onclick="showCookAlum(0)">
                            <img src="{{URL::asset('images/festival/cookFestival/sample/bor1.jpg')}}" class="resizeImgClass" onload="fitThisImg(this)">
                        </div>
                        <div class="videoCard" onclick="showCookAlum(1)">
                            <img src="{{URL::asset('images/festival/cookFestival/sample/1234.jpg')}}" class="resizeImgClass" onload="fitThisImg(this)">
                        </div>
                        <div class="videoCard playIcon" onclick="showCookAlum(2)">
                            <img src="{{URL::asset('images/festival/cookFestival/sample/vid1.jpg')}}" class="resizeImgClass" onload="fitThisImg(this)">
                        </div>
                        <div class="videoCard" onclick="showCookAlum(3)">
                            <img src="{{URL::asset('images/festival/cookFestival/sample/2332.jpg')}}" class="resizeImgClass" onload="fitThisImg(this)">
                        </div>
                    </div>
                </div>
                <div class="registerInCook">
                    <div class="text" >از اینجا برای ما بفرستید</div>
                    <button class="orangeButton" onclick="goToNextStep(2)">شرکت کنید</button>
                </div>
            </div>
            <div class="step1ListContent hideOnPhone">
                <div class="title">
                    <div>آثار ارسالی</div>
                    <div> شما</div>
                </div>
                <div class="videoCardList">
                    <div class="videoCard playIcon" onclick="showCookAlum(0)">
                        <img src="{{URL::asset('images/festival/cookFestival/sample/bor1.jpg')}}" class="resizeImgClass" onload="fitThisImg(this)">
                    </div>
                    <div class="videoCard" onclick="showCookAlum(1)">
                        <img src="{{URL::asset('images/festival/cookFestival/sample/1234.jpg')}}" class="resizeImgClass" onload="fitThisImg(this)">
                    </div>
                    <div class="videoCard playIcon" onclick="showCookAlum(2)">
                        <img src="{{URL::asset('images/festival/cookFestival/sample/vid1.jpg')}}" class="resizeImgClass" onload="fitThisImg(this)">
                    </div>
                    <div class="videoCard" onclick="showCookAlum(3)">
                        <img src="{{URL::asset('images/festival/cookFestival/sample/2332.jpg')}}" class="resizeImgClass" onload="fitThisImg(this)">
                    </div>
                </div>
            </div>
        </div>

        @if(auth()->check())
            <div class="commonBody uploadStep step2 hidden">
                <div class="helloText">
                    سلام {{auth()->user()->username}}
                </div>
                <div class="inputCol">
                    <input id="foodNameInput" type="text" placeholder="نام غذا" readonly onclick="createSearchInput('searchInFoods', 'نام غذا را وارد نمایید')">
                </div>
                <div id="uploadSec" class="uploadSec">
                    <div class="uploadeShowResults">
                        <label for="uploadedFileInput" class="uploadFileCard uploadButton plus2">
                            افزودن عکس یا فیلم
                        </label>
                    </div>
                </div>
                <input type="file" id="uploadedFileInput" data-multiple-caption="{count} files selected" multiple style="display: none" onchange="uploadPicClickHandler(this)">
                <button id="submitWorkButton" class="submitUploadButton orangeButton" onclick="submitFiles()" disabled>ارسال</button>
            </div>
        @else
            <div class="commonBody step2 loginBody hidden">
                <div class="topText">
                    <div class="bigText">پیش از شروع عضو شوید</div>
                    <div class="smallText">
                        اگر عضو هستید
                        <span class="loginButton" onclick="checkLogin(window.location.href)">وارد شوید</span>
                    </div>
                </div>
                <div class="registerBody">
{{--                    <div class="inputCol">--}}
{{--                        <input type="text" id="firstNameCInput" class="mustFill" placeholder="نام">--}}
{{--                    </div>--}}
{{--                    <div class="inputCol">--}}
{{--                        <input type="text" id="lastNameCInput" class="mustFill" placeholder="نام خانوادگی">--}}
{{--                    </div>--}}
                    <div class="inputCol">
                        <input type="text" id="userNameCInput" class="mustFill" placeholder="نام کاربری">
                        <div class="smallText">
                            دوستانتان شما را با این نام می شناسند
                        </div>
                    </div>
                    <div class="inputCol">
                        <input type="text" id="phoneCInput" class="mustFill" placeholder="شماره تلفن همراه">
                    </div>
                    <div class="inputCol">
                        <input type="password" id="passwordCInput" class="mustFill" placeholder="رمز عبور">
                    </div>
                    <button class="orangeButton" onclick="firstStepRegisterCook()">تایید</button>
                </div>
            </div>
            <div class="commonBody step3 loginBody hidden">
                <div class="topText">
                    <div class="bigText">کدی که به گوشی شما پیامک شده است را وارد کنید</div>
                </div>
                <div class="registerBody">
                    <div class="inputCol">
                        <input type="text" id="phoneCodeCInput" placeholder="کد ارسالی" onkeyup="checkCodeCount(this)">
                    </div>
                    <div class="remaindSec">
                        <div class="text">هنوز کد به شما ارسال نشده است؟</div>
                        <div class="remaindeTimer">
                            <div id="codeTimer" class="numberSec">00:00</div>
                            <div class="againButton">تا ارسال مجدد</div>
                        </div>

                        <div class="orangeButton remaindSecButton hidden" onclick="resendPhoneCode()"> ارسال مجدد کد </div>
                    </div>
                    <button id="checkCodeButton" class="orangeButton" onclick="checkPhoneCode()" style="margin-top: 100px" disabled>ثبت</button>
                </div>
            </div>
        @endif
    </div>

    <script>
        var nowStep = 'step1';
        var url = window.location;
        var alb = [
            {
                id: 0,
                sidePic: "{{URL::asset('images/festival/cookFestival/sample/bor1.jpg')}}",
                video: "{{URL::asset('images/festival/cookFestival/sample/bor1.mp4')}}",
                userPic: "{{getUserPic(0)}}",
                userName: "Koochita",
                showInfo: false,
            },
            {
                id: 1,
                sidePic: "{{URL::asset('images/festival/cookFestival/sample/1234.jpg')}}",
                mainPic: "{{URL::asset('images/festival/cookFestival/sample/1234.jpg')}}",
                userPic: "{{getUserPic(0)}}",
                userName: "Koochita",
                showInfo: false,
            },
            {
                id: 2,
                sidePic: "{{URL::asset('images/festival/cookFestival/sample/vid1.jpg')}}",
                video: "{{URL::asset('images/festival/cookFestival/sample/vid1.mp4')}}",
                userPic: "{{getUserPic(0)}}",
                userName: "Koochita",
                showInfo: false,
            },
            {
                id: 3,
                sidePic: "{{URL::asset('images/festival/cookFestival/sample/2332.jpg')}}",
                mainPic: "{{URL::asset('images/festival/cookFestival/sample/2332.jpg')}}",
                userPic: "{{getUserPic(0)}}",
                userName: "Koochita",
                showInfo: false,
            },
        ];

        function goToNextStep(_nextStep) {
            window.history.replaceState(null, null, '?page='+_nextStep);

            $(`.${nowStep}`).addClass('hidden');
            $(`.step${_nextStep}`).removeClass('hidden');
            nowStep = `step${_nextStep}`;
        }

        if(url.search.includes('?page=')){
            showStep = url.search.split('?page=')[1];
            if(showStep == 3)
                showStep = 2;
            goToNextStep(showStep);
        }

        function showCookAlum(_number){
            createPhotoModal('مسابقه آشپزی', alb, _number);
        }
    </script>

    @if(!auth()->check())
        <script>
            function firstStepRegisterCook(){

                // var firstName = $('#firstNameCInput');
                // var lastName = $('#lastNameCInput');
                var phone = $('#phoneCInput');
                var userName = $('#userNameCInput');
                var passwordInput = $('#passwordCInput');
                var errorText = '<ul><li>پر کردن تمامی فیلدها اجباری است</li>';
                var hasError = false;

                var phoneNumber = convertNumberToEn(phone.val());

                // if(firstName.val().trim().length < 2) {
                //     firstName.parent().addClass('hasError');
                //     hasError = true;
                // }
                // if(lastName.val().trim().length < 2) {
                //     lastName.parent().addClass('hasError');
                //     hasError = true;
                // }
                if(phoneNumber.trim().length != 11 || phoneNumber[0] != 0 || phoneNumber[1] != 9){
                    phone.parent().addClass('hasError');
                    errorText += '<li>شماره تلفن خود را به درست وارد نمایید</li>';
                    hasError = true;
                }
                if(userName.val().trim().length < 2){
                    userName.parent().addClass('hasError');
                    hasError = true;
                }
                if(passwordInput.val().trim().length < 2){
                    passwordInput.parent().addClass('hasError');
                    hasError = true;
                }

                if(hasError) {
                    errorText += '</ul>';
                    openErrorAlert(errorText);
                }
                else{
                    openLoading(false, () => sendActivationCode());
                }
            }

            function sendActivationCode(){
                var userName = $('#userNameCInput').val();
                var phone = $('#phoneCInput').val();
                phone = convertNumberToEn(phone);

                $('.remaindSecButton').addClass('hidden');
                $('.remaindeTimer').removeClass('hidden');

                $.ajax({
                    type: 'post',
                    url: '{{route("festival.cook.firstStepRegister")}}',
                    data: {
                        _token: '{{csrf_token()}}',
                        phone: phone,
                        username: userName
                    },
                    success: response => {
                        closeLoading();
                        if(response.status == 'ok' || response.status == 'remaining'){
                            timer(response.result);
                            goToNextStep(3);
                        }
                        else if(response.status == 'auth')
                            location.reload();
                        else if(response.status == 'error2'){
                            var nErr = '';
                            response.result.map(err => nErr += `<li>${err}</li>`);
                            openErrorAlert(`<ul>${nErr}</ul>`);
                        }
                    },
                    error: err => {
                        showSuccessNotifi('Server error', 'left', 'red');
                        closeLoading();
                    }
                });
            }

            function timer(_sTimer){
                var second = _sTimer%60;
                var min = Math.floor(_sTimer/60);

                second = second < 10 ? '0'+second : second;
                min = min < 10 ? '0'+min : min;

                $('#codeTimer').text(min+':'+second);
                _sTimer--;
                if(_sTimer > 0)
                    setTimeout(() => timer(_sTimer), 1000);
                else{
                    $('.remaindSecButton').removeClass('hidden');
                    $('.remaindeTimer').addClass('hidden');
                }
            }

            function checkPhoneCode(){
                var activationCode = $('#phoneCodeCInput').val();
                var phoneNum = $('#phoneCInput').val();
                phoneNum = convertNumberToEn(phoneNum);

                if(activationCode.trim().length > 2) {
                    openLoading(false, () => {
                        $.ajax({
                            type: 'post',
                            url: '{{route("register.checkActivationCode")}}',
                            data: {
                                _token: '{{csrf_token()}}',
                                phoneNum,
                                activationCode
                            },
                            success: response => {
                                if (response.status == "ok")
                                    completeRegisteration();
                                else{
                                    closeLoading();
                                    openErrorAlert("کد وارد شده اشتباه می باشد.");
                                }
                            },
                            error: err => {
                                closeLoading();
                            }
                        });
                    });
                }
            }

            function completeRegisteration(){
                // var firstName = $('#firstNameCInput').val();
                // var lastName = $('#lastNameCInput').val();
                var phone = $('#phoneCInput').val();
                var userName = $('#userNameCInput').val();
                var password = $('#passwordCInput').val();
                var activationCode = $('#phoneCodeCInput').val();
                phone = convertNumberToEn(phone);

                $.ajax({
                    type: 'post',
                    url: '{{route("festival.cook.fullRegister")}}',
                    data: {
                        _token: '{{csrf_token()}}',
                        // firstName,
                        // lastName,
                        phone,
                        userName,
                        password,
                        activationCode,
                    },
                    success: response => {
                        if(response.status == "ok" || response.status == "auth")
                            location.reload();
                        else if(response.status == "error2"){
                            closeLoading();
                            goToNextStep(2);

                            var nErr = '';
                            response.result.map(err => nErr += `<li>${err}</li>`);
                            openErrorAlert(`<ul>${nErr}</ul>`);
                        }
                        else if(response.status == "error3"){
                            closeLoading();
                            openErrorAlert("کد وارد شده اشتباه می باشد.");
                        }
                    },
                })
            }

            function checkCodeCount(_element){
                if($(_element).val().trim().length > 3)
                    $('#checkCodeButton').prop('disabled', false);
                else
                    $('#checkCodeButton').prop('disabled', true);
            }

            function resendPhoneCode(){
                openLoading(false, () => sendActivationCode());
            }

            $('.mustFill').on('change', e => {
                var target = $(e.target);
                if(target.val().trim().length < 2)
                    target.parent().addClass('hasError');
                else
                    target.parent().removeClass('hasError');
            })

        </script>
    @else
        <script>
            var foodName = {
                name: '',
                id: 0
            };
            var uploadPicAjax = null;
            var uploadProcess = false;
            var searchFoodAjax = false;
            var fileImages = [];
            var dropArea = document.getElementById('uploadSec');


            function preventDefaults (e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => dropArea.addEventListener(eventName, preventDefaults, false) );
            dropArea.addEventListener('dragenter', () => $('.uploadSec').addClass('highlight'), false);
            dropArea.addEventListener('dragleave', () => $('.uploadSec').removeClass('highlight'), false);
            dropArea.addEventListener('dragover', () => $('.uploadSec').addClass('highlight'), false);
            dropArea.addEventListener('drop', (e) => {
                let files = e.dataTransfer.files;
                ([...files]).forEach(createAndUploadFilePic);
            }, false);

            function uploadPicClickHandler(_input){
                if(_input.files && _input.files.length > 0){
                    for(var i = 0; i < _input.files.length; i++)
                        createAndUploadFilePic(_input.files[i]);
                }
                $(_input).val('');
            }

            function createAndUploadFilePic(_files) {

                if(_files.type.search('image') > -1) {
                    console.log('this is image', _files);

                    var reader = new FileReader();
                    reader.onload = e => {
                        var index = fileImages.push({
                            file: _files,
                            image: e.target.result,
                            thumbnailFileName: '',
                            savedFile: '',
                            uploaded: -1,
                            type: 'image',
                            code: Math.floor(Math.random() * 1000)
                        });
                        createNewImgUploadCard(index - 1);
                        uploadQueuePictures();
                    };
                    reader.readAsDataURL(_files);
                }
                else if(_files.type.search('video') > -1){
                    console.log('this is video', _files);
                    var index = fileImages.push({
                        file: _files,
                        image: '',
                        savedFile: '',
                        thumbnailFileName: '',
                        uploaded: -1,
                        type: 'video',
                        code: Math.floor(Math.random() * 1000)
                    });
                    convertVideoFileForConvert(index-1);
                }
            }

            function convertVideoFileForConvert(_index){
                var uFile = fileImages[_index];
                window.URL = window.URL || window.webkitURL;

                var video = document.createElement('video');
                video.preload = 'metadata';
                video.src = URL.createObjectURL(uFile.file);

                var fileReader = new FileReader();
                fileReader.onload = function() {
                    var blob = new Blob([fileReader.result], {type: uFile.file.type});
                    var url = URL.createObjectURL(blob);
                    var timeupdate = function() {
                        if (snapImage()) {
                            video.removeEventListener('timeupdate', timeupdate);
                            video.pause();
                        }
                    };
                    video.addEventListener('loadeddata', function() {
                        if (snapImage()) {
                            video.removeEventListener('timeupdate', timeupdate);
                        }
                    });

                    var snapImage = function() {
                        var canvas = document.createElement('canvas');
                        canvas.width = video.videoWidth;
                        canvas.height = video.videoHeight;
                        canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                        var image = canvas.toDataURL();
                        var success = image.length > 100000;

                        if (success) {
                            fileImages[_index].image = image;
                            URL.revokeObjectURL(url);
                            createNewImgUploadCard(_index);
                            uploadQueuePictures();
                        }
                        return success;
                    };
                    video.addEventListener('timeupdate', timeupdate);
                    video.preload = 'metadata';
                    video.src = url;
                    video.muted = true;
                    video.playsInline = true;
                    video.play();
                };
                fileReader.readAsArrayBuffer(uFile.file);
            }

            function createNewImgUploadCard(_index){
                var file = fileImages[_index];
                var text = `<div id="uplaodedImg_${file.code}" class="uploadFileCard">
                            <div class="img">
                                <img src="${file.image}" class="resizeImgClass" onload="fitThisImg(this)">
                            </div>
                            <div class="absoluteBackground tickIcon"></div>
                            <div class="absoluteBackground warningIcon"> اشکال در بارگذاری</div>
                            <div class="absoluteBackground process">
                                <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
                                <div class="processCounter">0%</div>
                            </div>
                            <div class="hoverInfos">
                                <div class="cancelButton closeIconWithCircle" onclick="deleteThisUploadedImage(${file.code})" >
                                     حذف فایل
                                </div>
                            </div>
                        </div>`;
                $('.uploadeShowResults').append(text);
            }

            function uploadQueuePictures(){
                if(uploadProcess == false){
                    uploadProcess = true;
                    var uploadIndex = null;
                    fileImages.map((item, index) => {
                        if(item.uploaded == -1 && uploadIndex == null)
                            uploadIndex = index;
                    });

                    if(uploadIndex != null) {
                        var uFile = fileImages[uploadIndex];
                        var uploadImgElement = $(`#uplaodedImg_${uFile.code}`);
                        uFile.uploaded = 0;
                        uploadImgElement.addClass('process');

                        uploadLargeFile('{{route("festival.cook.uploadFile")}}', uFile.file, [], (_percent, _fileName = '') => {
                            if(_percent == 'done') {
                                uploadProcess = false;
                                uFile.savedFile = _fileName;
                                if(uFile.type == 'image'){
                                    uFile.uploaded = 1;
                                    uploadImgElement.removeClass('process');
                                    uploadImgElement.addClass('done');
                                    uploadQueuePictures();
                                }
                                else
                                    storeThumbnail(uploadIndex);
                            }
                            else if(_percent == 'error') {
                                uploadProcess = false;
                                uploadImgElement.removeClass('process');
                                uploadImgElement.addClass('error');
                                uFile.uploaded = -2;
                                uploadQueuePictures();
                            }
                            else if(_percent == 'cancelUpload'){
                                uploadImgElement.remove();
                                uploadProcess = false;
                                uploadQueuePictures();
                            }
                            else
                                uploadImgElement.find('.processCounter').text(_percent + '%');
                        });
                    }
                    else
                        uploadProcess = false;
                }
            }

            function storeThumbnail(_index){
                var file = fileImages[_index];
                var data = new FormData();
                data.append('fileName', file.savedFile);
                data.append('thumbnail', file.image);
                data.append('_token', '{{csrf_token()}}');

                $.ajax({
                    type: 'post',
                    url: '{{route("festival.cook.uploadFile")}}',
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function(response){
                        if(response.status == 'ok')
                            file.thumbnailFileName = response.fileName;

                        file.uploaded = 1;
                        $(`#uplaodedImg_${file.code}`).removeClass('process');
                        $(`#uplaodedImg_${file.code}`).addClass('done');
                        uploadQueuePictures();
                    },
                    error: err =>{
                        file.uploaded = 1;
                        uploadQueuePictures();
                    }
                });
            }

            function deleteThisUploadedImage(_code){
                var index = null;
                for(var i = 0; i < fileImages.length; i++){
                    if(fileImages[i].code == _code){
                        index = i;
                        break;
                    }
                }

                if(index != null){
                    if(fileImages[index].uploaded == 0)
                        cancelLargeUploadedFile();
                    else if(fileImages[index].uploaded == -1 || fileImages[index].uploaded == -2){
                        fileImages.splice(index, 1);
                        $('#uplaodedImg_'+_code).remove();
                    }
                    else if(fileImages[index].uploaded == 1)
                        doDeletePicServer(index);
                }
            }

            function doDeletePicServer(_index){
                var file = fileImages[_index];
                $.ajax({
                    type: 'delete',
                    url: '{{route('festival.cook.deleteFile')}}',
                    data: {
                        _token: '{{csrf_token()}}',
                        fileName: file.savedFile,
                    },
                    success: response => {
                        if(response.status == 'ok'){
                            $('#uplaodedImg_'+file.code).remove();
                            fileImages.splice(index, 1);
                        }
                    },
                })
            }

            function searchInFoods(_element){
                var value = $(_element).val();
                if(value.trim().length > 2){

                    if(searchFoodAjax != false)
                        searchFoodAjax.abort();

                    searchFoodAjax = $.ajax({
                        type: 'get',
                        url: `{{route("search.place")}}?value=${value}&kindPlaceId=11`,
                        success: response =>{
                            if(response.status == 'ok'){
                                var result = response.result;
                                var text = '';

                                text += `<div onclick="chooseThisFood(this)" class="foodSearchResult" kindFood="new" foodName="${value}" style="color: blue">
                                            <p class="suggest cursor-pointer font-weight-700" style="margin: 0px">${value}</p>
                                        </div>`;

                                result.map(item => {
                                    text += `<div onclick="chooseThisFood(this)" class="foodSearchResult" kindFood="id" foodName="${item.name}" foodId="${item.id}">
                                                <p class="suggest cursor-pointer font-weight-700" style="margin: 0px">${item.name}</p>
                                            </div>`;
                                });
                                setResultToGlobalSearch(text);
                            }
                        },
                    })
                }
            }

            function chooseThisFood(_element){
                var kind = $(_element).attr('kindFood');
                foodName.name = $(_element).attr('foodName');
                if(kind == 'id')
                    foodName.id = $(_element).attr('foodId');
                else
                    foodName.id = 0;

                $('#foodNameInput').val(foodName.name);
                $('#submitWorkButton').prop('disabled', false);

                closeSearchInput();
            }

            function submitFiles(){
                if(foodName.name != ''){
                    var inUpload = false;
                    var filesName = [];
                    fileImages.map(item => {
                        if(item.uploaded == 0)
                            inUpload = true;

                        filesName.push(item.savedFile);
                    });

                    if(inUpload)
                        openWarning('فایل در حال آپلود می باشد، صبر کنید.');
                    else {
                        openLoading(false, () => {
                            $.ajax({
                                type: 'post',
                                url: '{{route("festival.cook.submitFiles")}}',
                                data:{
                                    _token: '{{csrf_token()}}',
                                    filesName: JSON.stringify(filesName),
                                    food: JSON.stringify(foodName)
                                },
                                success: response => {
                                    if(response == 'ok'){
                                        showSuccessNotifi('عکس و فیلم شما با موفقیت ثبت شد', 'left', 'var(--koochita-blue)');
                                        window.location.href = '{{route("profile")}}#festival&id=4';
                                    }
                                    else{
                                        closeLoading();
                                    }
                                },
                                error: err => showSuccessNotifi('error 500', 'left', 'red')
                            })
                        });
                    }
                }
                else
                    openWarning('برای ثبت عکس و فیلم باید غذا را انتخاب کنید');
            }

        </script>
    @endif

</body>
</html>
