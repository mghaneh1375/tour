<!doctype html>
<html lang="fa" dir="rtl">
<head>
    @include('layouts.topHeader')
    <title> فستیوال </title>

    <link rel="stylesheet" href="{{URL::asset('css/pages/festival.css?v='.$fileVersions)}}">
    <script src="{{URL::asset('js/uploadLargFile.js')}}"></script>

    <style>
        section{
            background: #445565;
            min-height: 100vh;
        }
        header .buttons{
            margin-left: auto;
            margin-right: 10px;
            width: calc(100% - 200px);
            justify-content: space-between;
        }
        header .buttons > span{
            display: flex;
            align-items: center;
        }
    </style>

</head>
<body>
    <header>
        <div class="container">
            <div class="logos">
                <a href="{{route('main')}}">
                    <img src="{{URL::asset('images/camping/undp.svg')}}" style="height: 100%">
                    <img src="{{URL::asset('images/icons/mainLogo.png')}}" style="height: 100%">
                </a>
            </div>
            <div class="buttons smallFont">
                <span>#جشنواره ایران ما</span>
                <a href="{{route('festival.main')}}" class="votedButton" >رای می دهم</a>
            </div>
        </div>
    </header>

    <section>
        <div class="container mainSectionSubmitWork">
            <div class="IndicatorSec one">
                <div class="indicator">
                    <div class="firstBackGround twoBackGround threeBackGround circle"></div>
                    <div class="oneLine twoLine threeLine name">اطلاعات شرکت کننده</div>
                </div>
                <div class="indicator">
                    <div class="twoBackGround threeBackGround circle"></div>
                    <div class="twoLine threeLine name">آپلود محتوا</div>
                </div>
                <div class="indicator">
                    <div class="threeBackGround circle"></div>
                    <div class="threeLine name">آپلود محتوا</div>
                </div>
                <div class="lines">
                    <div class="firstLine twoBackGround threeBackGround"></div>
                    <div class="secondLine threeBackGround"></div>
                </div>
            </div>

            <div id="section_1" class="row" style="direction: ltr">
                <div class="col-md-12 inputRows">
                    <input type="text" id="firstNameIn" class="mustFull" placeholder="نام" {{$user->first_name == null ? '' : 'disabled'}} value="{{$user->first_name}}">
                </div>
                <div class="col-md-12 inputRows">
                    <input type="text" id="lastNameIn" class="mustFull" placeholder="نام خانوادگی" {{$user->last_name == null ? '' : 'disabled'}} value="{{$user->last_name}}">
                </div>
                <div class="col-md-12 inputRows">
                    <input type="text" id="emailIn" class="mustFull" placeholder="ایمیل" {{$user->email == null ? '' : 'disabled'}} value="{{$user->email}}">
                </div>
                <div class="col-md-12 inputRows">
                    <input type="text" id="phoneIn" class="mustFull" placeholder="شماره همراه" {{$user->phone == null ? '' : 'disabled'}} value="{{$user->phone}}">
                </div>
                <div class="col-sm-6 col-6 inputRows">
                    <select id="sexIn" {{ $user->sex !== null ? 'disabled' : ''}}>
                        <option value="1" {{ $user->sex == 1 ? 'selected' : ''}}>آقا</option>
                        <option value="0" {{ $user->sex == 0 ? 'selected' : ''}}>خانم</option>
                    </select>
                </div>
                <div class="col-sm-6 col-6 inputRows">
                    <input type="number" id="ageIn" class="mustFull" placeholder="سن" {{$user->age == null ? '' : 'disabled'}} value="{{$user->age}}">
                </div>
                <div class="col-md-12 inputRows optional">
                    <input type="text" id="websiteIn" placeholder="لینک وب سایت" {{$user->link == null ? '' : 'disabled'}} value="{{$user->link}}">
                </div>
                <div class="col-md-12 inputRows optional">
                    <input type="text" id="instagramIn" placeholder="صفحه اینستاگرام" {{$user->instagram == null ? '' : 'disabled'}} value="{{$user->instagram}}">
                </div>
            </div>

            <div id="section_2" style="display: none;">

                <div class="row">

                    <div class="col-sm-6 switchInputSec">
                        <div class="title">بخش اصلی جشنواره</div>
                        <div id="matchMainSection" class="switchInput" value="photo">
                            <div data-value="video" onclick="changeSwitchInputButton(this, 'festKind')">فیلم</div>
                            <div class="selected" data-value="photo" onclick="changeSwitchInputButton(this, 'festKind')">عکس</div>
                        </div>
                    </div>

                    <div class="col-sm-6 switchInputSec">
                        <div class="title">بخش فرعی جشنواره</div>
                        <div id="matchSideSection" class="switchInput" value="main">
                            <div class="selected" data-value="main" onclick="changeSwitchInputButton(this)">اصلی</div>
                            <div data-value="mobile" onclick="changeSwitchInputButton(this)">موبایل</div>
                        </div>
                    </div>
                </div>

                <label for="picFile" class="dropPictureSec">
                    <div class="icon">
                        <img src="{{URL::asset('images/festival/plus.png')}}">
                    </div>
                    <div class="text">
                        <span class="section2KindText">عکس</span>
                        خود را با دکمه کناری انتخاب نموده و یا داخل این باکس بیاندازید
                    </div>
                </label>
                <input id="picFile" accept="image/*" type="file" style="display: none;" onchange="changePic(this)">

                <div id="fileUploadSection" class="fileUploaded"></div>
            </div>

            <div id="section_3" style="display: none;">
                <div class="mainTextRule"></div>
                <div class="acceptRuleButton">
                    <input id="acceptRuleInput" type="checkbox"/>
                    <label for="acceptRuleInput">
                        با فشردن دکمه تایید نهای موافقت خود را با قوانین بالا اعلام می دارم.
                    </label>
                </div>
            </div>

            <div id="submitPageButtons" class="submitButton one">

                <div class="IndicatorSec one footerIndicator hideOnScreen">
                    <div class="indicator">
                        <div class="firstBackGround twoBackGround threeBackGround circle"></div>
                    </div>
                    <div class="indicator">
                        <div class="twoBackGround threeBackGround circle"></div>
                    </div>
                    <div class="indicator">
                        <div class="threeBackGround circle"></div>
                    </div>
                    <div class="lines">
                        <div class="firstLine twoBackGround threeBackGround"></div>
                        <div class="secondLine threeBackGround"></div>
                    </div>
                </div>

                <button class="cancel" onclick="submitHandle(-1)">بازگشت</button>
                <button class="submit" onclick="submitHandle(1)">تایید</button>
            </div>
        </div>

        <div id="submitDeletePicModal" class="modalBlackBack fullCenter submitDeletePic">
            <div class="modalBody" style="background: #445565;">
                <div class="text">
                    ایا می خواهید فایل خود را حذف کنید. توجه کنید فایل و متن های نوشته شده قابل بازیابی نیست.
                </div>
                <div class="buts">
                    <button class="btn submit" onclick="doDeleteThisImg()">بله پاک شود</button>
                    <button class="btn cancel" onclick="closeMyModal('submitDeletePicModal')">خیر</button>
                </div>
            </div>
        </div>

        <div id="changeFestivalKindModal" class="modalBlackBack fullCenter submitDeletePic">
            <div class="modalBody" style="background: #445565;">
                <div class="text">
                    شما چند فایل آپلود کرده اید. در صورت تغییر بخش جشنواره فایل ها و متن ها پاک می شوند.
                </div>
                <div class="buts">
                    <button class="btn submit" onclick="doChangeMyFestivalKind()">بله عوض شود</button>
                    <button class="btn cancel" onclick="closeMyModal('changeFestivalKindModal')">خیر</button>
                </div>
            </div>
        </div>

        <div id="videoSnapShotModal" class="modalBlackBack fullCenter videoSnapShotModal notCloseOnClick">
            <div class="modalBody" style="background: #445565;">
                <div class="text" style="color: var(--yellow); text-align: center">
                    شما برای بارگذاری ویدیو خود یک عکس باید از ویدیوی خود انتخاب کنید.
                </div>
                <div class="videoSec">
                    <video id="snapShotVideo"  controls muted ></video>
                    <div class="buts">
                        <button class="btn submit" onclick="takeSnapShot(this)" disabled>گرفتن عکس</button>
                    </div>
                </div>
                <canvas id="resultThumbnail" style="display: none;"></canvas>
            </div>
        </div>

        <div id="showImgModal" class="showFullPicModal hidden">
            <div class="iconClose" onclick="closeShowPictureModal()"></div>
            <div id="showImgModalBody" class="body">
                <div id="modalImgSection" class="imgSec">
                    <img id="modalPicture" >
                    <video id="modalVideo"  controls></video>
                    <div class="nPButtons next leftArrowIcon" onclick="nextShowPicModal(-1)"></div>
                    <div class="nPButtons prev leftArrowIcon" onclick="nextShowPicModal(1)"></div>
                </div>

                <div id="modalInfoSection" class="infoSec">
                    <div class="userInfo">
                        <div style="display: flex; align-items: center;">
                            <div class="userPic">
                                <img class="modalUserPic" src="{{$authUserInfos->pic}}" style="height: 100%;">
                            </div>
                            <a href="{{route('profile', ['username' => $authUserInfos->username])}}" target="_blank" class="username modalUserName">{{$authUserInfos->username}}</a>
                        </div>
                    </div>
                    <div class="picInfo">
                        <div class="inf">
                            <div class="title">نام اثر: </div>
                            <div class="text modalTitle"></div>
                        </div>
                        <div id="modalDescription" class="inf">
                            <div class="title">توضیحات عکس: </div>
                            <div class="text" style="font-size: 12px;"></div>
                        </div>
                    </div>

                    <div class="liShButtons">
                        <div class="likeButton empty-heartAfter modalLike" onclick="likeWorks(this)" code="0"></div>
                        <div class="shareButton" onclick="copyUrl(this, window.location.href)">
                            اشتراک گذاری:
                            <span class="modalCode"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <script>
        let limboUrl = '{{URL::asset('_images/festival/limbo/')}}';
        let lastStage = 1;
        let uploadedPicFile = [];
        let deleteImgIndex = 0;
        let cityFileIndex = 0;
        let placeFileIndex = 0;
        let searchPlaceNumber = 0;
        let changeFestivalKind = null;
        let festivalText = {
            'photo': {
                text: 'عکس',
                accepted: 'image/*'
            },
            'video': {
                text: 'فیلم',
                accepted: 'video/*'
            },
        };
        let hasQueue = false;
        var showFullPicIndex;
        let placeIcons = {
            'amaken': 'touristAttractions',
            'restaurant': 'restaurantIcon',
            'hotels': 'hotelIcon',
            'sogatSanaies': 'souvenirIcon',
            'mahaliFood': 'traditionalFood',
            'majara': 'adventureIcon',
            'boomgardies': 'boomIcon',
        };

        function changeSwitchInputButton(_elems, _kind = ''){
            if(_kind == 'festKind'){
                let uploadedFile = false;
                uploadedPicFile.map(pic => pic !== false ? uploadedFile = true : '');
                if(uploadedFile){
                    changeFestivalKind = _elems;
                    openMyModal('changeFestivalKindModal');
                    return;
                }
            }

            $(_elems).parent().find('.selected').removeClass('selected');
            $(_elems).addClass('selected');
            $(_elems).parent().attr('value', $(_elems).attr('data-value'));

            if(_kind == 'festKind'){
                let festKind = $('#matchMainSection').attr('value');
                $('.section2KindText').text(festivalText[festKind].text);
                $('#picFile').attr('accept', festivalText[festKind].accepted);
            }
        }

        function doChangeMyFestivalKind(){
            $(changeFestivalKind).parent().find('.selected').removeClass('selected');
            $(changeFestivalKind).addClass('selected');
            $(changeFestivalKind).parent().attr('value', $(changeFestivalKind).attr('data-value'));
            changeFestivalKind = null;

            for(let i = 0; i < uploadedPicFile.length; i++){
                if(uploadedPicFile[i] !== false)
                    deleteUploadedFile(i);
            }
            $('#fileUploadSection').html('');

            closeMyModal('changeFestivalKindModal');

            let festKind = $('#matchMainSection').attr('value');
            $('.section2KindText').text(festivalText[festKind].text);
            $('#picFile').attr('accept', festivalText[festKind].accepted);
        }

        function changePic(_input){
            if(_input.files && _input.files[0]) {
                var uploadedKind = $("#matchMainSection").attr('value');
                if(uploadedKind == 'photo' && _input.files[0].size > 5120000){
                    openWarning('حجم عکس شما باید از 5 مگابایت کمتر باشد');
                    return;
                }
                else if(uploadedKind == 'video' && _input.files[0].size > 512000000){
                    openWarning('حجم ویدیوی شما باید از 500 مگابایت کمتر باشد');
                    return;
                }
                uploadedPicFile.push({
                    file: _input.files[0],
                    uploadedFileName: '',
                    type: uploadedKind,
                    process: 'inQueue',
                    thumbnail: null,
                    thumbnailFileName: null,
                    title: '',
                    cityId: 0,
                    cityName: '',
                    description: '',
                    placeId: 0,
                    kindPlaceId: 0,
                    kind: '',
                });

                let nowUploaded = _input.files[0];
                let nowUploadIndex = uploadedPicFile.length-1;
                let reader = new FileReader();
                _input.value = '';

                if($("#matchMainSection").attr('value') == 'video'){
                    uploadedPicFile[nowUploadIndex].kind = 'video';
                    createUploadedFileRow('#', 'فیلم', nowUploadIndex);
                    reader.onload = e => $('#snapShotVideo').attr('src', e.target.result);
                    reader.readAsDataURL(nowUploaded);
                    openMyModal('videoSnapShotModal');

                    $("#snapShotVideo").on("loadstart", () => $("#snapShotVideo").parent().find('button').prop('disabled', false));
                }
                else {
                    reader.onload = e => {
                        uploadedPicFile[nowUploadIndex].thumbnail = e.target.result;
                        uploadedPicFile[nowUploadIndex].kind = 'photo';
                        createUploadedFileRow(e.target.result, 'عکس', nowUploadIndex);
                        uploadContentFile(nowUploadIndex);
                    };
                    reader.readAsDataURL(nowUploaded);
                }
            }
        }

        function createUploadedFileRow(mainPic, kind, _index){
            let text =  '<div id="fileRow_' + _index + '" class="fileRow">\n' +
                        '   <img src="' + mainPic + '" >\n' +
                        '   <div class="fileInputs">\n' +
                        '       <div id="fileInputRowPercent_' + _index + '" class="uploadPercent">' +
                        '           <div class="text"></div>' +
                        '           <div class="processDiv">' +
                        '               <div class="percentNum">0%</div>' +
                        '               <div class="percentBack"></div>' +
                        '           </div>' +
                        '       </div>' +
                        '       <div class="row">\n' +
                        '           <div class="col-sm-12 inputRows">\n' +
                        '               <input id="titleForFile_'+_index+'" type="text" class="mustFull" placeholder="عنوان ' + kind + '">\n' +
                        '           </div>\n' +
                        '           <div class="col-sm-6 inputRows pd-lt-0">\n' +
                        '               <input id="cityNameForFile_'+_index+'" type="text" class="mustFull" placeholder="نام شهر" onclick="openCitySearch(' + _index + ')" readonly>\n' +
                        '               <input id="cityIdForFile_'+_index+'" type="hidden" value="0" readonly>\n' +
                        '           </div>\n' +
                        '           <div class="col-sm-6 inputRows">\n' +
                        '               <input id="placeNameForFile_'+_index+'" type="text" placeholder="نام مکان (اختیاری)" onclick="openPlaceSearch(' + _index + ')" readonly>\n' +
                        '               <input id="placeIdForFile_'+_index+'" type="hidden" value="0">\n' +
                        '               <input id="kindPlaceIdForFile_'+_index+'" type="hidden" value="0">\n' +
                        '           </div>\n' +
                        '           <div class="col-sm-12 inputRows">\n' +
                        '               <textarea id="descriptionForFile_'+_index+'" type="text" placeholder="توضیح ' + kind + ' (اختیاری)"></textarea>\n' +
                        '           </div>\n' +
                        '       </div>\n' +
                        '       <div class="cornerButton iconClose" onclick="deleteImg('+_index+')"></div>\n' +
                        '   </div>\n' +
                        '</div>\n';

            $('#fileUploadSection').append(text);

            setTimeout(() => {
                resizeUploadedPictures();
                $('.mustFull').on('change', function(e){
                    if(e.target.value.trim().length == 0)
                        e.target.classList.add('emptyError');
                    else
                        e.target.classList.remove('emptyError');
                });

                $('html, body').animate({
                    scrollTop: $("#fileRow_"+_index).offset().top
                }, 1000);
            }, 500);
        }

        function openCitySearch(_index){
            cityFileIndex = _index;
            createSearchInput('searchInCities', 'نام شهر را وارد کنید.');// in globalInput.blade.php
        }
        function searchInCities(_element){
            let result = '';
            let value = _element.value;

            value = value.trim();
            if(value.length > 1){
                $.ajax({
                    type: 'post',
                    url:  "{{route('searchForCity')}}",
                    data: {
                        'key':  value,
                        'state': 1
                    },
                    success: function (response) {
                        let result = '';
                        response = JSON.parse(response);
                        response.forEach(item => {
                            if(item.isVillage == 0)
                                cityKind = 'شهر' ;
                            else
                                cityKind = 'روستا' ;

                            result += '<div onclick="setCityNameInFileInfo(this)" class="resultSearch" cityId="' + item.id + '">' +
                                    '   <p class="suggest cursor-pointer font-weight-700" style="margin: 0px">' + cityKind + ' ' + item.cityName + '</p>' +
                                    '   <div style="margin: 0px; color: gray; font-size: 10px !important; margin-right: 7px;">استان ' + item.stateName + '</div>' +
                                    '</div>';
                        });

                        if(result == ''){
                            result ='<div onclick="setCityNameInFileInfo(this)" class="resultSearch" cityId="-1">' +
                                    '   <p class="suggest cursor-pointer font-weight-700" id="suggest_1" style="margin: 0px; color: blue; font-size: 20px !important;">' +
                                    '       <span id="newCityName">' + value + '</span> را اضافه کن' +
                                    '   </p>' +
                                    '</div>';
                        }

                        setResultToGlobalSearch(result);
                    }
                });
            }
            else
                setResultToGlobalSearch('');
        }
        function setCityNameInFileInfo(_element){

            let id = $(_element).attr('cityId');
            let name;
            if(id == -1) {
                name = $("#newCityName").text();
                id = name;
            }
            else
                name = $(_element).children().first().text();

            $("#cityNameForFile_"+cityFileIndex).val(name);
            $("#cityIdForFile_"+cityFileIndex).val(id);
            cityFileIndex = 0;
            closeSearchInput();
        }

        function openPlaceSearch(_index){
            placeFileIndex = _index;
            createSearchInput('searchInPlacesInUploadPageFile', 'نام مکان را وارد کنید.');// in globalInput.blade.php
        }
        function searchInPlacesInUploadPageFile(_element){
            let result = '';
            let value = _element.value;

            value = value.trim();
            if(value.length > 1){
                searchPlaceNumber++;
                $.ajax({
                    type: 'post',
                    url:  "{{route('totalSearch')}}",
                    data: {
                        _token: '{{csrf_token()}}',
                        key:  value,
                        kindPlaceId: 0,
                        num: searchPlaceNumber
                    },
                    success: function (response) {
                        let result = '';
                        response = JSON.parse(response);
                        if(response[2] == searchPlaceNumber) {
                            response[1].forEach(item => {
                                let plIcon = placeIcons[item.mode];

                                if (item.kindPlaceId != 0) {
                                    result += '<div onclick="setPlaceNameInFileInfo(this)" class="resultSearch" kindPlaceId="'+item.kindPlaceId+'" placeName="' + item.targetName + '" placeId="' + item.id + '" cityId="'+item.cityId+'" cityName="'+item.cityName+'">' +
                                                '   <div class="icon ' + plIcon + '"></div>' +
                                                '   <p class="suggest cursor-pointer font-weight-700" style="margin: 0px">' + item.targetName + '</p>' +
                                                '   <div style="margin: 0px; color: gray; font-size: 10px !important; margin-right: 7px;">در استان '+ item.stateName +' ، شهر '+ item.cityName +'</div>' +
                                                '</div>';
                                }
                            });
                            setResultToGlobalSearch(result);
                        }

                    }
                });
            }
            else
                setResultToGlobalSearch('');
        }
        function setPlaceNameInFileInfo(_element){

            let cityId   = $(_element).attr('cityId');
            let cityName = $(_element).attr('cityName');
            let placeId  = $(_element).attr('placeId');
            let kindPlaceId = $(_element).attr('kindPlaceId');
            let placeName = $(_element).attr('placeName');

            $("#cityNameForFile_"+placeFileIndex).val(cityName);
            $("#cityIdForFile_"+placeFileIndex).val(cityId);
            $("#placeNameForFile_"+placeFileIndex).val(placeName);
            $("#placeIdForFile_"+placeFileIndex).val(placeId);
            $("#kindPlaceIdForFile_"+placeFileIndex).val(kindPlaceId);
            placeFileIndex = 0;

            closeSearchInput();
        }

        function deleteImg(_index){
            deleteImgIndex = _index;
            openMyModal('submitDeletePicModal');
        }

        function doDeleteThisImg(){
            let processSection = uploadedPicFile[deleteImgIndex].process;
            closeMyModal('submitDeletePicModal');
            if(processSection == 'inProcess'){
                $('#fileInputRowPercent_'+deleteImgIndex).addClass('cancel');
                cancelLargeUploadedFile(); // in uploadLargeFile.js
            }
            else if(processSection == 'inQueue') {
                $('#fileRow_'+deleteImgIndex).remove();
                uploadedPicFile[deleteImgIndex] = false;
            }
            else if(processSection == 'done' || processSection == 'error') {
                $('#fileInputRowPercent_'+deleteImgIndex).addClass('cancel');
                deleteUploadedFile(deleteImgIndex);
            }

            deleteImgIndex = 0;
        }

        function takeSnapShot(){
            let videoThumbnailDiv = document.getElementById('snapShotVideo');
            var canvasThumbnail = document.getElementById('resultThumbnail');
            canvasThumbnail.width = videoThumbnailDiv.videoWidth;
            canvasThumbnail.height = videoThumbnailDiv.videoHeight;
            canvasThumbnail.getContext('2d').drawImage(videoThumbnailDiv, 0, 0, canvasThumbnail.width, canvasThumbnail.height);
            $('#fileRow_'+(uploadedPicFile.length-1)).find('img').attr('src', canvasThumbnail.toDataURL());
            closeMyModal('videoSnapShotModal');
            $('#snapShotVideo').attr('src', '#');
            setTimeout(resizeUploadedPictures, 500);
            uploadedPicFile[uploadedPicFile.length-1].thumbnail = canvasThumbnail.toDataURL();
            uploadContentFile(uploadedPicFile.length-1);
        }

        function uploadContentFile(_index){
            let kind = $('#matchMainSection').attr('value');
            uploadLargeFile('{{route("festival.uploadFile")}}', uploadedPicFile[_index].file, {kind: kind}, (_percent, _fileName = '') =>{
                if(_percent == 'done') {
                    uploadedPicFile[_index].uploadedFileName = _fileName;
                    $('#fileInputRowPercent_'+_index).addClass('done');
                    $('#fileInputRowPercent_'+_index).find('.percentNum').text('100%');

                    if(uploadedPicFile[_index].thumbnail != null && uploadedPicFile[_index].kind == 'video')
                        storeThumbnail(_index);
                    else {
                        uploadedPicFile[_index].process = 'done';
                        uploadedPicFile[_index].thumbnailFileName = 'thumb_'+_fileName;
                    }
                }
                else if(_percent == 'error') {
                    $('#fileInputRowPercent_'+_index).addClass('error');
                    uploadedPicFile[_index].process = 'error';
                }
                else if(_percent == 'queue') {
                    $('#fileInputRowPercent_'+_index).addClass('inQueue');
                    uploadedPicFile[_index].process = 'inQueue';
                    if(hasQueue === false)
                        checkQueue();
                }
                else if(_percent == 'cancelUpload'){
                    $('#fileRow_'+_index).remove();
                    uploadedPicFile[_index] = false;
                    deleteImgIndex = 0;
                    if(hasQueue === false)
                        checkQueue();
                }
                else{
                    $('#fileInputRowPercent_'+_index).removeClass('inQueue');
                    $('#fileInputRowPercent_'+_index).find('.percentNum').text(_percent+'%');
                    $('#fileInputRowPercent_'+_index).find('.percentBack').css('width', _percent+'%');
                    uploadedPicFile[_index].process = 'inProcess';
                }
            });
        }

        function storeThumbnail(_index){
            let data = new FormData();
            data.append('fileName', uploadedPicFile[_index].uploadedFileName);
            data.append('thumbnail', uploadedPicFile[_index].thumbnail);
            data.append('_token', '{{csrf_token()}}');

            $.ajax({
                type: 'post',
                url: '{{route("festival.uploadFile")}}',
                data: data,
                processData: false,
                contentType: false,
                success: function(response){
                    uploadedPicFile[_index].process = 'done';
                    if(response.status == 'ok')
                        uploadedPicFile[_index].thumbnailFileName = response.fileName;
                },
                error: err => {
                    uploadedPicFile[_index].process = 'done';
                    uploadedPicFile[_index].thumbnailFileName = null;
                    console.log(err)
                }
            });
        }

        function checkQueue(){
            hasQueue = setInterval(() => {
                let hasProcess = false;
                let firstQueue = false;
                uploadedPicFile.map((file, index) => {
                    if(file !== false && file.process == 'inProcess')
                        hasProcess = true;
                    else if(file !== false && file.process == 'inQueue' && firstQueue === false)
                        firstQueue = index;
                });
                if(!hasProcess){
                    if(firstQueue !== false)
                        uploadContentFile(firstQueue);
                    else{
                        clearInterval(hasQueue);
                        hasQueue = false;
                    }
                }
            }, 1000);
        }

        function checkFirstStep(){
            let error = false;
            let inputs = [ 'firstName', 'lastName', 'email', 'phone', 'age', 'sex' ];
            inputs.map(item => {
                if($(`#${item}In`).val().trim().length == 0){
                    $(`#${item}In`).addClass('emptyError');
                    error = true;
                }
                else
                    $(`#${item}In`).removeClass('emptyError');
            });

            if(error)
                return false;
            else
                return true;
        }

        function checkSecondStep(){
            let uploadNum = 0;
            let inProcess = false;
            let lessData = false;

            uploadedPicFile.map((pic, index) => {
                if(pic !== false){
                    pic !== false && uploadNum++;
                    if(pic.process == 'inProcess' || pic.process == 'inQueue')
                        inProcess = true;

                    let title = $('#titleForFile_'+index).val();
                    let cityId = $('#cityIdForFile_'+index).val();
                    let cityName = $('#cityNameForFile_'+index).val();
                    let placeId = $('#placeIdForFile_'+index).val();
                    let kindPlaceId = $('#kindPlaceIdForFile_'+index).val();
                    let description = $('#descriptionForFile_'+index).val();

                    pic.title = title;
                    pic.cityId = cityId;
                    pic.cityName = cityName;
                    pic.description = description;
                    pic.placeId = placeId;
                    pic.kindPlaceId = kindPlaceId;

                    if(title.trim().length == 0 || cityName.trim().length == 0)
                        lessData = true;
                }
            });
            if (uploadNum > 0 && !inProcess && !lessData)
                return true;
            else if(lessData)
                alert('برای تمامی فایل ها باید عنوان و شهر را مشخص کنید');
            else if(inProcess)
                alert('بعضی از فایل ها در حال آپلود می باشند تا زمان آپلود کامل باید صبر کنید');
            else
                return false;
        }

        function submitHandle(_step){

            if(lastStage == 1 && !checkFirstStep())
                return;
            else if(lastStage == 2 && _step == 1 && !checkSecondStep())
                return;
            else if(lastStage == 3 && _step == 1){
                if($('#acceptRuleInput').prop("checked")){
                    storeDatas();
                    return;
                }
                else
                    return;
            }

            $('#section_'+lastStage).hide();
            if((_step == -1 && lastStage > 1) || (_step == 1 && lastStage < 3))
                lastStage += _step;
            $('#section_'+lastStage).show();

            if(lastStage == 1){
                $('#submitPageButtons').addClass('one');
                $('.IndicatorSec').addClass('one').removeClass('two').removeClass('three');
            }
            else if(lastStage == 2){
                $('#submitPageButtons').removeClass('one');
                $('.IndicatorSec').addClass('two').removeClass('three');
            }
            else if(lastStage == 3){
                createImageBody();
                $('#submitPageButtons').removeClass('one');
                $('.IndicatorSec').addClass('three');
            }
        }

        function storeDatas(){
            openLoading();
            let uploadData = [];
            let userData = {};
            uploadedPicFile.map(item => {
                if(item !== false){
                    uploadData = item;
                    uploadData.file = '';
                    uploadData.thumbnail = null;
                }
            });

            userData = {
                firstName: $('#firstNameIn').val(),
                lastName: $('#lastNameIn').val(),
                email: $('#emailIn').val(),
                phone: $('#phoneIn').val(),
                age: $('#ageIn').val(),
                sex: $('#sexIn').val(),
                website: $('#websiteIn').val(),
                instagram: $('#instagramIn').val(),
            };

            $.ajax({
                type: 'post',
                url: '{{route("festival.submitWorks")}}',
                data:{
                    _token: '{{csrf_token()}}',
                    data: JSON.stringify(uploadedPicFile),
                    userData: JSON.stringify(userData),
                    matchSection: $('#matchMainSection').attr('value'),
                    sideSection: $('#matchSideSection').attr('value'),
                },
                success: function(response){
                    if(response.status == 'ok')
                        window.location.href = '{{route("profile")}}#festival';
                    else if(response.status == 'nok'){
                        closeLoading();
                        var text = '<ul>';
                        response.error.map(err => text += `<li>${err}</li>`);
                        text += '</ul>';
                        openWarning(text);
                        showSuccessNotifi('در ثبت اثار مشکلی پیش امده لطفا دوباره تلاش نمایید', 'left', 'red');
                        submitHandle(-1);
                        submitHandle(-1);
                    }
                    else{
                        closeLoading();
                        showSuccessNotifi('در ثبت اثار مشکلی پیش امده لطفا دوباره تلاش نمایید', 'left', 'red');
                    }
                },
                error: function(err){
                    closeLoading();
                    showSuccessNotifi('در ثبت اثار مشکلی پیش امده لطفا دوباره تلاش نمایید', 'left', 'red');
                }
            })
        }

        function deleteUploadedFile(_index){
            $.ajax({
                type: 'post',
                url: '{{route("festival.uploadFile.delete")}}',
                data: {
                    _token: '{{csrf_token()}}',
                    fileName: uploadedPicFile[_index].uploadedFileName,
                    thumbnail: uploadedPicFile[_index].thumbnailFileName
                },
                success: function(response){
                    if(response == 'ok'){
                        $('#fileRow_'+_index).remove();
                        uploadedPicFile[_index] = false;
                    }
                },
                error: err => console.log(err)
            })
        }

        function resizeUploadedPictures(){
            let windowWidth = $(window).width();
            let imgs = $('.fileRow').find('img');
            for(let i = 0; i < imgs.length; i++){
                let item = $(imgs[i]);

                let picH = item.height();
                let picW = item.width();
                let picS = picW/picH;

                if (windowWidth > 767) {
                    let resultH = item.parent().height();
                    let resultW = item.parent().width()*0.7;
                    let rPH100W = resultH*picS;

                    if(rPH100W < resultW){
                        item.css('width', '60%');
                        item.css('height', 'auto');
                    }
                    else{
                        item.css('height', '100%');
                        item.css('width', 'auto');
                    }
                }
                else {
                    let resultH = item.parent().height()*0.7;
                    let resultW = item.parent().width();
                    let resultS = resultW/resultH;
                    let rPW100H = resultW/picS;

                    if(rPW100H < resultH){
                        item.css('height', '70%');
                        item.css('width', 'auto');
                    }
                    else{
                        item.css('width', '100%');
                        item.css('height', 'auto');
                    }
                }
            }
        }

        function fullUserInfoHandler(){
            let inputs = [ 'firstName', 'lastName', 'email', 'phone', 'age', 'sex', 'website', 'instagram'];
            let error = false;
            inputs.map(item => {
                if($(`#${item}In`).val().trim().length == 0)
                    error = true
            });

            if(!error)
                submitHandle(1);
        }
        fullUserInfoHandler();

        function createImageBody(){
            let text = '';
            $('.mainTextRule').empty();
            uploadedPicFile.map((item, index) =>{
                if(item !== false) {
                    text += '<div class="userWorks">\n' +
                            '   <img src="' + limboUrl + item.thumbnailFileName + '" onclick="openShowPictureModal(' + index + ')" class="resizeImgClass" onload="fitThisImg(this)">\n' +
                            '</div>';
                }
            });
            $('.mainTextRule').html(text);
        }

        function nextShowPicModal(_kind){
            if(uploadedPicFile.length < 2)
                return;

            var nowShowPicIndex = showFullPicIndex+_kind;
            while(1){
                if(nowShowPicIndex < 0)
                    nowShowPicIndex = uploadedPicFile.length - 1;
                else if(nowShowPicIndex >= uploadedPicFile.length)
                    nowShowPicIndex = 0;
                if(uploadedPicFile[nowShowPicIndex] !== false)
                    break;
                else
                    nowShowPicIndex +=_kind;
            }


            openShowPictureModal(nowShowPicIndex);
        }

        function openShowPictureModal(_index){
            var _picture = uploadedPicFile[_index];

            $('#modalPicture').attr('src', '#');
            $('#modalVideo').attr('src', '#');

            if(_picture.kind == 'photo'){
                $('#modalVideo').hide();
                $('#modalPicture').show();
                $('#modalPicture').attr('src', limboUrl+'/'+_picture.uploadedFileName);
            }
            else{
                $('#modalVideo').show();
                $('#modalPicture').hide();
                $('#modalVideo').attr('src', limboUrl+'/'+_picture.uploadedFileName);
            }

            $('.modalUserPic').attr('src', _picture['userPic']);
            $('.modalTitle').text(_picture.title);
            if(_picture.description != null){
                $('#modalDescription').show();
                $('#modalDescription').find('.text').text(_picture.description);
            }
            else{
                $('#modalDescription').hide();
                $('#modalDescription').find('.text').text('');
            }

            showFullPicIndex = _index;
            $('#showImgModal').removeClass('hidden');
        }

        function closeShowPictureModal(){
            showFullPicIndex = 0;
            $('#showImgModal').addClass('hidden');
        }


        $(window).on('resize', resizeUploadedPictures);

        $('.mustFull').on('change', function(e){
            if(e.target.value.trim().length == 0)
                e.target.classList.add('emptyError');
            else
                e.target.classList.remove('emptyError');
        });
    </script>

    @include('general.forAllPages')

</body>
</html>