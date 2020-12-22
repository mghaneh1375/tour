<!doctype html>
<html lang="fa" dir="rtl">
<head>
    @include('layouts.topHeader')

    <title>{{$selectedPic->title}}</title>

    <meta property="og:title" content="{{$selectedPic->title}}"/>
    <meta property="title" content="{{$selectedPic->title}}"/>
    <meta name="twitter:title" content="{{$selectedPic->title}}"/>
    <meta name="twitter:card" content="{{$selectedPic->description}}"/>
    <meta name="twitter:description" content="{{$selectedPic->description}}"/>
    <meta property="og:description" content="{{$selectedPic->description}}"/>
    <meta property="article:author " content="کوچیتا"/>
    <meta property="og:url" content="{{Request::url()}}"/>

    <meta property="og:image" content="{{$selectedPic->pic}}"/>
    <meta property="og:image:secure_url" content="{{$selectedPic->pic}}"/>
    <meta name="twitter:image" content="{{$selectedPic->pic}}"/>

    <link rel="stylesheet" href="{{URL::asset('css/pages/festival.css?v='.$fileVersions)}}">

    <style>
        section{
            background: #445565;
            min-height: 100vh;
            color: var(--light-gray);
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

        .mySurveyModal .contents{
            display: flex;
            justify-content: center;
            width: 100%;
            align-items: center;
        }
        .mySurveyModal .iconClose{
            color: var(--yellow);
            float: left;
            font-size: 30px;
            line-height: 10px;
            cursor: pointer;
        }

        .mySurveyModal .footerBut{
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .mySurveyModal .header{
            color: var(--yellow);
            font-size: 25px;
            margin-bottom: 10px;
        }
        .mySurveyModal .footerBut > button{
            color: white;
            background: var(--koochita-blue);
            border: none;
            padding: 5px 15px;
            border-radius: 15px;
        }
    </style>
</head>
<body>

@include('general.forAllPages')

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
            <div class="registerButton" onclick="iParticipate()">شرکت می کنم</div>
        </div>
    </div>
</header>

<section class="showFestivalPage">
    <div class="container">
        <div class="smallFont header">
            <div>
                شما وارد قسمت آرای مردمی چشنواره ایران ما شده اید. در این قسمت می توانید به محتواهای مورد علاقه خود رای دهید.
            </div>
            <div style="color: var(--yellow); margin-top: 10px;">
                توجه کنید هر کاربر تنها پنج حق رای دارد.
            </div>
        </div>

        <div class="tabSection">
            <div class="topTab">
                <div class="tab notTab">جشنواره</div>
                <div class="selectFestivalPc">
                    <div class="tab selected festival_main_photo" onclick="chooseFestival('main', 'photo')">عکس بخش اصلی</div>
                    <div class="tab festival_mobile_photo" onclick="chooseFestival('mobile', 'photo')">عکس بخش فرعی</div>
                    <div class="tab festival_main_video" onclick="chooseFestival('main', 'video')">فیلم بخش اصلی</div>
                    <div class="tab festival_mobile_video" onclick="chooseFestival('mobile', 'video')">فیلم بخش فرعی</div>
                </div>
                <div class="selectFestivalMobile">
                    <div class="downArrowIconAfter" onclick="openChooseFestivalTab()">عکس بخش اصلی</div>
                </div>
            </div>
            <div class="botTab">
                @if(auth()->check())
                    <div class="left">
                        <span id="mySurveyCount"></span> رای از 5 رای
                        <button id="mySurveyButton" style="display: none" onclick="getMySurveys()">
                            رای های من
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <div id="bodySection" class="bodySection"></div>
    </div>

    <div id="mySurveyModal" class="modalBlackBack fullCenter mySurveyModal">
        <div class="modalBody" style="background: #445565; min-width: 90%">
            <div class="iconClose" onclick="closeMyModal('mySurveyModal')"></div>
            <div class="header">رای های من</div>
            <div id="showMySurveyModalBody" class="contents"></div>
            <div class="footerBut hideOnPhone">
                <button onclick="closeMyModal('mySurveyModal')">بستن</button>
            </div>
        </div>
    </div>

    <div id="chooseFestivalMobileTab" class="modalBlackBack fullCenter chooseFestivalModalMobile">
        <div class="modalBody" style="background: #445565;">
            <div class="tab selected festivalTab festival_main_photo" onclick="chooseFestival('main', 'photo')">عکس بخش اصلی</div>
            <div class="tab festivalTab festival_mobile_photo" onclick="chooseFestival('mobile', 'photo')">عکس بخش فرعی</div>
            <div class="tab festivalTab festival_main_video" onclick="chooseFestival('main', 'video')">فیلم بخش اصلی</div>
            <div class="tab festivalTab festival_mobile_video" onclick="chooseFestival('mobile', 'video')">فیلم بخش فرعی</div>
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
                            <img class="modalUserPic"  style="height: 100%;">
                        </div>
                        <a href="#" target="_blank" class="username modalUserName"></a>
                    </div>
                    <div class="hideOnScreen showSLBInM">
                        <button class="modalLike empty-heartAfter" onclick="likeWorks(this)" code="0"></button>
                        <button class="codeButton" onclick="copyUrl(this, window.location.href)">
                            اشتراک گذاری:
                            <span class="modalCode"></span>
                        </button>
                    </div>
                </div>
                <div class="picInfo">
                    <div class="inf">
                        <div class="title">نام اثر: </div>
                        <div class="text modalTitle"></div>
                    </div>
                    <div class="inf">
                        <div class="title">محل: </div>
                        <a href="#" target="_blank" class="text modalPlace"></a>
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
    let nowShowPicIndex = 0;
    let allPics = [];
    let mySurveyCodes = [];
    let mySurveyPics = [];
    let nowFullShowCollection = [];
    let showSection = '{{$selectedPic->section}}';
    let showKind = '{{$selectedPic->kind}}';
    let showFullPicCode = '{{$selectedPic->code}}';

    openLoading();

    function nextShowPicModal(_kind){
        openPictureWithIndex(nowShowPicIndex+_kind);
    }

    function openPictureWithCode(_code, _collection){
        let pic = null;
        if(_collection == 'allPics')
            nowFullShowCollection = allPics;
        else {
            nowFullShowCollection = mySurveyPics;
            closeMyModal('mySurveyModal');
        }

        nowFullShowCollection.map((item, key) => {
            if(item.code == _code) {
                pic = item;
                nowShowPicIndex = key;
            }
        });

        if(pic != null)
            openShowPictureModal(pic);
    }

    function openPictureWithIndex(_index){
        if(nowFullShowCollection.length < 2)
            return;

        nowShowPicIndex = _index;
        if(nowShowPicIndex < 0)
            nowShowPicIndex = nowFullShowCollection.length-1;
        else if(nowShowPicIndex == nowFullShowCollection.length)
            nowShowPicIndex = 0;

        openShowPictureModal(nowFullShowCollection[nowShowPicIndex]);
    }

    function openShowPictureModal(_picture){
        let newUrl = window.location.origin + window.location.pathname + '?code='+_picture['code'];
        window.history.pushState({"html":'',"pageTitle":''},"", newUrl);

        $('#modalPicture').attr('src', '#');
        $('#modalVideo').attr('src', '#');

        if(_picture['isPic'] == 1){
            $('#modalVideo').hide();
            $('#modalPicture').show();
            $('#modalPicture').attr('src', _picture['pic']);
        }
        else{
            $('#modalVideo').show();
            $('#modalPicture').hide();
            $('#modalVideo').attr('src', _picture['video']);
        }

        $('.modalUserPic').attr('src', _picture['userPic']);
        $('.modalUserName').text(_picture['username']);
        $('.modalUserName').attr('href', _picture['userUrl']);
        $('.modalTitle').text(_picture['title']);
        $('.modalPlace').attr('href', _picture['placeUrl']);
        $('.modalPlace').text(_picture['place']);
        $('.modalLike').text(_picture['like']);
        $('.modalLike').attr('code', _picture['code']);
        $('.modalCode').text(_picture['code']+'#');
        if(_picture['description'] != null){
            $('#modalDescription').show();
            $('#modalDescription').find('.text').text(_picture['description']);
        }
        else{
            $('#modalDescription').hide();
            $('#modalDescription').find('.text').text('');
        }

        if(_picture['youLike'] == 1){
            $('.modalLike').removeClass('empty-heartAfter');
            $('.modalLike').addClass('HeartIconAfter');
        }
        else{
            $('.modalLike').removeClass('HeartIconAfter');
            $('.modalLike').addClass('empty-heartAfter');
        }


        showFullPicCode = _picture['code'];
        $('#showImgModal').removeClass('hidden');
    }

    function closeShowPictureModal(){
        showFullPicCode = 0;
        let newUrl = window.location.origin + window.location.pathname;
        window.history.pushState({"html":'',"pageTitle":''},"", newUrl);
        $('#showImgModal').addClass('hidden');
    }

    function chooseFestival(_section, _kind){
        $('.tab.selected').removeClass('selected');
        $(`.festival_${_section}_${_kind}`).addClass('selected');
        $('.selectFestivalMobile').find('.downArrowIconAfter').text($($('.tab.selected')[0]).text());
        closeMyModal('chooseFestivalMobileTab');

        allPics = [];
        showSection = _section;
        showKind = _kind;
        $('#bodySection').empty();
        getContent();
    }

    function openChooseFestivalTab(){
        openMyModal('chooseFestivalMobileTab');
    }

    function copyUrl(_elems, _link){
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(_link).select();
        document.execCommand("copy");
        $temp.remove();

        let inputText = $(_elems).text();
        $(_elems).text('لینک کپی شد');
        setTimeout(() => $(_elems).text(inputText), 2000)

    }

    function iParticipate(){
        if(!checkLogin('{{route('festival.uploadWorks')}}'))
            return;

        window.location.href = '{{route('festival.uploadWorks')}}';
    }

    function createImageBody(){
        let text = '';
        $('#bodySection').empty();
        allPics.map(item =>{
            let like = 'empty-heart';
            if(item.youLike == 1)
                like = 'HeartIcon';

            text += '<div class="userWorks">\n' +
                    '   <img src="'+item.thumbnail+'" onclick="openPictureWithCode('+item.code+', \'allPics\')" class="resizeImgClass" onload="fitThisImg(this)">\n' +
                    '   <div class="onPicture code" onclick="copyUrl(this, \''+item.url+'\')">#'+item.code+'</div>\n' +
                    '   <div class="onPicture like '+like+'" onclick="likeWorks(this)" code="'+item.code+'" ><span class="likeCount">'+item.like+'</span></div>\n' +
                    '</div>';
        });
        $('#bodySection').html(text);
    }

    function getContent(){
        openLoading();
        $.ajax({
            type: 'post',
            url: '{{route("festival.getContent")}}',
            data: {
                _token: '{{csrf_token()}}',
                mainSection: showSection,
                kind: showKind,
            },
            success: function (response) {
                closeLoading();
                response = JSON.parse(response);
                if (response.status == 'ok') {
                    mySurveyCodes = response.mySurveys;
                    allPics = response.result;
                    updateSurveys();
                    createImageBody();

                    if(showFullPicCode != 0)
                        openPictureWithCode(showFullPicCode, 'allPics');
                }
            },
            error: err => {
                closeLoading();
                console.log(err)
            }
        });
    }

    function updateSurveys(){
        $('#mySurveyCount').text(mySurveyCodes.length);
        if(mySurveyCodes.length > 0)
            $('#mySurveyButton').css('display', 'inline-block');
        else
            $('#mySurveyButton').css('display', 'none');
    }

    function likeWorks(_elems, _replace = 0){
        if(!checkLogin())
            return;

        openLoading();
        $.ajax({
            type: 'post',
            url: '{{route("festival.likeWork")}}',
            data: {
                _token: '{{csrf_token()}}',
                code: $(_elems).attr('code'),
                replace: _replace
            },
            success: function(response){
                response = JSON.parse(response);
                if(response.status == 'ok'){
                    mySurveyCodes = response.result;
                    showSuccessNotifi(`رای شما با موفقیت ثبت شد.(${5 - mySurveyCodes.length} رای باقی مانده)`, 'left', 'var(--koochita-blue)');
                    getContent();
                }
                else if(response.status == 'moreThanFive'){
                    closeLoading();
                    showSuccessNotifi('شما 5 رای خود را داده اید. می توانید در قسمت رای های من رای های خود را تغییر دهید.', 'left', 'red');
                }
                else{
                    closeLoading();
                    showSuccessNotifi('در ثبت رای شما مشکلی پیش امده لطفا دوباره تلاش نمایید', 'left', 'red');
                }
            },
            error: function(err){
                closeLoading();
                console.log(err);
            }
        })
    }

    function getMySurveys(){
        openLoading();
        $.ajax({
            type: 'post',
            url: '{{route("festival.getMySurvey")}}',
            data: {
                _token: '{{csrf_token()}}',
                section: showSection,
                kind: showKind,
            },
            success: function(response){
                closeLoading();
                response = JSON.parse(response);
                if(response.status == 'ok'){
                    openMyModal('mySurveyModal');
                    showMySurvey(response.result);
                }
            },
            error: err => console.log(err),
        });
    }

    function showMySurvey(_codes){
        let text = '';
        mySurveyPics = [];

        allPics.map(item => {
           if(_codes.indexOf(item.code) > -1)
               mySurveyPics.push(item);
        });

        mySurveyPics.map(survey => {
            let like = 'empty-heart';
            if(survey.youLike == 1)
                like = 'HeartIcon';

            text += '<div class="userWorks">\n' +
                    '   <img src="'+survey.thumbnail+'" onclick="openPictureWithCode('+survey.code+',\'mySurvey\')" class="resizeImgClass" onload="fitThisImg(this)">\n' +
                    '   <div class="onPicture code" onclick="copyUrl(this, \''+survey.url+'\')">#'+survey.code+'</div>\n' +
                    '   <div class="onPicture like '+like+'" onclick="likeWorks(this)" code="'+survey.code+'" ><span class="likeCount">'+survey.like+'</span></div>\n' +
                    '</div>';
        });

        $('#showMySurveyModalBody').html(text);
    }

    chooseFestival(showSection, showKind);
</script>

</body>
</html>