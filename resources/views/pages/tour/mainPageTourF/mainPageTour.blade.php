<!doctype html>
<html lang="fa">
<head>
    @include('layouts.topHeader')
    <title>صفحه اصلی تور</title>

    <style>

        .mainSectionTourMainPage .backgroundColorChanges, .changeableIconColor{
            transition: .3s;
        }

        .backgroundPicTour{
            transition: opacity .5s;
        }
        .backgroundPicTour.addOpacity0ToPic{
            opacity: 0;
        }

        .adminSetting{
            display: none !important;
        }
        .mainSectionTourMainPage{
            width: 100%;
            height: calc(100vh - 55px);
            position: relative;
            display: flex;
        }
        .mainSectionTourMainPage .mainSec{
            display: flex;
            width: 100%;
            height: 100%;
        }
        .mainSectionTourMainPage .mainBackgroundPic{
            position: absolute;
            z-index: -1;
            width: 100%;
            height: 100%;
        }
        .mainSectionTourMainPage .mainBackgroundPic .backGroundColor{
            position: absolute;
            z-index: -1;
            width: 100%;
            height: 100%;
            background: #ffffff7a;
        }
        .mainSectionTourMainPage .mainBackgroundPic .backGroundImg{
            position: absolute;
            z-index: -2;
            width: 100%;
            height: 100%;
            filter: blur(10px);
            overflow: hidden;
            display: flex;
            justify-content: flex-end;
            align-items: flex-end;
        }
        .mainSectionTourMainPage .sideMenuSection{
            width: 100px;
            padding: 10px;
        }
        .mainSectionTourMainPage .sideMenuSection .sideMenuBody{
            text-align: center;
            width: 100%;
            height: 100%;
            border-radius: 10px 40px 40px 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px 0px;
            color: white;
        }
        .mainSectionTourMainPage .sideMenuSection .topTitle{
            margin-bottom: 13%;
            font-size: 38px;
            height: 100px;
            width: 100%;
        }
        .mainSectionTourMainPage .sideMenuSection .topTitle > div{
            font-family: 'Shin' !important;
            height: 20px
        ;
        }
        .mainSectionTourMainPage .sideMenuSection .sideMenuTabs{
            height: calc(100% - 100px);
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding-bottom: 100px;
            font-size: 30px;
        }
        .mainSectionTourMainPage .sideMenuSection .sideMenuTabs .item{
            margin-bottom: 35px;
            cursor: pointer;
            opacity: .4;
            width: 45px;
            height: 45px;
            border-radius: 13px;
            transition: .3s;
        }
        .mainSectionTourMainPage .sideMenuSection .sideMenuTabs .item.select{
            opacity: 1;
            background: white;
        }


        .mainSectionTourMainPage .bodySection{
            height: 100%;
            width: calc(100% - 100px);
            padding: 10px;
            display: flex;
        }
        .mainSectionTourMainPage .bodySection > div {
            width: 50%;
            height: 100%;
            padding: 10px;
        }
        .mainSectionTourMainPage .bodySection .imageSection{
            border-radius: 20px;
            position: relative;
            overflow: hidden;
        }
        .mainSectionTourMainPage .bodySection .imageSection .backImg{
            width: 100%;
            height: 100%;
            display: flex;
            overflow: hidden;
            align-items: flex-end;
            border-radius: 40px;
            z-index: -1;
            position: relative;
        }
        .mainSectionTourMainPage .bodySection .imageSection .backImg > img{
            position: absolute;
            left: -20px;
            bottom: -20px;
        }


        .mainSectionTourMainPage .bodySection .listAndDateSection .searchSection{
            display: flex;
            align-items: center;
            border-bottom: solid 1px #0000006b;
            padding: 10px 0px;
        }
        .mainSectionTourMainPage .bodySection .listAndDateSection .searchSection .inputSec{
            width: calc(100% - 25px);
        }
        .mainSectionTourMainPage .bodySection .listAndDateSection .searchSection .inputSec input{
            background: none;
            border: none;
            width: 100%;
            text-align: right;
            direction: rtl;
        }
        .mainSectionTourMainPage .bodySection .listAndDateSection .searchSection .searchButtonSec{
            width: 25px;
            height: 25px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 25px;
        }

        .mainSectionTourMainPage .findTourSection{
            margin-top: 50px;
            background: white;
            border-radius: 20px;
            display: flex;
        }
        .mainSectionTourMainPage .findTourSection .searchButton{
            display: flex;
            justify-content: center;
            align-items: center;
            width: 50px;
            border-radius: 20px;
            color: white;
            font-size: 27px;
            cursor: pointer;
            box-shadow: 5px 0px 5px 0px #ababab;
        }
        .mainSectionTourMainPage .findTourSection .findTourBody{
            padding: 10px;
            width: calc(100% - 50px);
            direction: rtl;
        }
        .mainSectionTourMainPage .findTourSection .findTourBody .title{
            text-align: right;
            font-size: 20px;
            font-weight: bold;
        }
        .mainSectionTourMainPage .findTourSection .findTourBody .body{
            margin-top: 0px;
            overflow: hidden;
            max-height: 0px;
            transition: .3s;
        }
        .mainSectionTourMainPage .findTourSection .findTourBody .body.show{
            margin-top: 10px;
            max-height: 300px;
        }
        .mainSectionTourMainPage .findTourSection .findTourBody .body .inputRow{
            display: flex;
            margin: 5px 0px;
            padding: 5px 0px;
            align-items: center;
            border-bottom: solid 1px #d3d3d3ad;
        }
        .mainSectionTourMainPage .findTourSection .findTourBody .body .inputRow:last-of-type{
            border: none;
        }
        .mainSectionTourMainPage .findTourSection .findTourBody .body .inputRow .icon{
            font-size: 26px;
            background: #0076a333;
            color: var(--koochita-blue);
            width: 40px;
            height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            margin-left: 10px;
        }
        .mainSectionTourMainPage .findTourSection .findTourBody .body .inputRow .inputSec{
            width: calc(100% - 50px);
        }
        .mainSectionTourMainPage .findTourSection .findTourBody .body .inputRow .inputSec > input{
            border: none;
            padding: 10px;
            padding-right: 0px;
            width: 100%;
        }

        .mainSectionTourMainPage .imageSection .contentSec{
            position: absolute;
            top: 0px;
            right: 0px;
            width: 100%;
            height: 100%;
            padding: 20px;
            direction: rtl;
            text-align: right;
            display: flex;
            justify-content: center;
            flex-direction: column;
            font-size: 20px;
        }
        .mainSectionTourMainPage .imageSection .contentSec .textSection{

        }
        .mainSectionTourMainPage .imageSection .contentSec .textSection .normalText{
            color: white;
            font-size: 1em;
        }
        .mainSectionTourMainPage .imageSection .contentSec .textSection .bigBoldText{
            color: white;
            font-size: 3em;
            font-weight: bold;
        }
        .mainSectionTourMainPage .imageSection .contentSec .bottomSection{
            position: absolute;
            bottom: 20px;
            left: 5%;
            max-width: 90%;
            display: flex;
        }
        .mainSectionTourMainPage .imageSection .contentSec .bottomSection .title{
            display: flex;
            justify-content: center;
            color: white;
            padding-left: 10px;
            font-size: 20px;
            flex-direction: column;
        }
        .mainSectionTourMainPage .imageSection .contentSec .bottomSection .title .normalText{
            font-size: .8em;
        }
        .mainSectionTourMainPage .imageSection .contentSec .bottomSection .title .boldText{
            font-size: 1.5em;
            font-weight: bold;
        }
        .mainSectionTourMainPage .imageSection .contentSec .bottomSection .destResult{
            display: flex;
            overflow-x: auto;
            border-radius: 20px;
        }
        .mainSectionTourMainPage .imageSection .contentSec .bottomSection .destinationsSection{
            background: #ffffffad;
            border-radius: 20px;
            overflow: hidden;
            display: flex;
            align-items: center;
        }
        .mainSectionTourMainPage .imageSection .contentSec .bottomSection .destinationsSection .destinationCard{
            width: 120px;
            height: 120px;
            padding: 10px;
        }
        .mainSectionTourMainPage .imageSection .contentSec .bottomSection .destinationsSection .destinationCard .destImg{
            width: 100%;
            height: 100%;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 20px;
        }
        .mainSectionTourMainPage .imageSection .contentSec .bottomSection .destinationsSection .destinationCard .destImg > img{
            transition: .3s;
        }
        .mainSectionTourMainPage .imageSection .contentSec .bottomSection .destinationsSection .destinationCard:hover .destImg > img{
            transform: scale(1.1);
        }
        .mainSectionTourMainPage .imageSection .contentSec .bottomSection .destinationsSection .navSec{
            padding-left: 10px;
            font-size: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .mainSectionTourMainPage .imageSection .contentSec .bottomSection .destinationsSection .navSec > div{
            font-weight: bold;
            cursor: pointer;
            width: 25px;
        }
        .mainSectionTourMainPage .imageSection .contentSec .bottomSection .destinationsSection .navSec .nextButton{
            transform: rotate(180deg);
        }
        .mainSectionTourMainPage .imageSection .contentSec .bottomSection .destinationsSection .navSec .prevButton{

        }


        .mainSectionTourMainPage .listSection{
            direction: rtl;
            height: 360px;
            overflow: hidden;
            padding-top: 30px;
        }
        .mainSectionTourMainPage .listSection .title{
            margin-bottom: 15px;
            font-size: 25px;
            font-weight: bold;
            color: white;
            height: 35px;
        }
        .mainSectionTourMainPage .listSection .list{
            height: calc(100% - 50px);
            overflow: auto;
        }
        .mainSectionTourMainPage .listSection .list .tourSmallCard{
            display: flex;
            margin: 10px;
            padding: 10px;
            border-radius: 20px;
            background: #ffffff87;
            cursor: pointer;
            color: black;
        }
        .mainSectionTourMainPage .listSection .list .tourSmallCard:hover .imgSec > img{
            transform: scale(1.1);
        }
        .mainSectionTourMainPage .listSection .list .tourSmallCard .imgSec{
            width: 100px;
            height: 100px;
            overflow: hidden;
            border-radius: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .mainSectionTourMainPage .listSection .list .tourSmallCard .imgSec > img{
            transition: .3s;
        }
        .mainSectionTourMainPage .listSection .list .tourSmallCard .contentSec{
            padding-right: 15px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            font-size: 20px;
            width: calc(100% - 100px);
        }
        .mainSectionTourMainPage .listSection .list .tourSmallCard .contentSec .smallText{
            font-size: .6em;
        }
        .mainSectionTourMainPage .listSection .list .tourSmallCard .contentSec .bigBoldText{
            font-size: 1em;
            font-weight: bold;
        }
    </style>
</head>

<body>
@include('general.forAllPages')

@include('layouts.header1')

<div class="mainSectionTourMainPage">

    <div class="mainBackgroundPic">
        <div class="backGroundColor"></div>
        <div class="backGroundImg">
            <img id="mainBackgroundPicWithBlur" src="{{URL::asset('images/test/backPic2.jpg')}}" class="resizeImgClass backgroundPicTour" alt="tourMainPage" onload="fitThisImg(this); showBackgroundPic(); updatePageElementsSizes();">
        </div>
    </div>

    <div class="mainSec">

        <div class="bodySection">
            <div class="imageSection">
                <div class="backImg">
                    <img id="sideBackgroundPicWithBlur" src="{{URL::asset('images/test/backPic2.jpg')}}" class="backgroundPicTour" alt="tourMainPage">
                </div>
                <div class="contentSec">
                    <div class="textSection">
                        <div id="topTourKindText" class="normalText">ماجراجویی در</div>
                        <div id="mainTourKindText" class="bigBoldText">جاده های بینهایت</div>
                        <div id="bottomTourKindText" class="normalText">ایران زمین</div>
                    </div>
                    <div class="bottomSection">
                        <div class="title">
                            <div class="normalText">مقاصد</div>
                            <div class="boldText">پیشنهادی</div>
                            <div class="normalText">کوچیتا</div>
                        </div>
                        <div class="destinationsSection">
                            <div id="destinationResult" class="destResult"></div>

                            <div class="navSec">
                                <div class="nextButton leftArrowIcon"></div>
                                <div class="prevButton leftArrowIcon"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="listAndDateSection">
                <div id="listSearchTopSection">
                    <div class="searchSection">
                        <div class="searchButtonSec searchIcon"></div>
                        <div class="inputSec">
                            <input type="text" placeholder="نام مقصد و یا تور را وارد کنید...">
                        </div>
                    </div>

                    <div class="findTourSection">
                        <div class="searchButton backgroundColorChanges searchIcon" onclick="doSearchFromPanel()"></div>

                        <div class="findTourBody">
                            <div class="title">تور خودت رو پیدا کن</div>
                            <div id="iranTour_searchPanel" class="body searchPanelBodies show">
                                <div class="inputRow">
                                    <div class="icon changeableIconColor locationIcon"></div>
                                    <div class="inputSec">
                                        <input type="text" placeholder="نام مقصد خود را وارد کنید...">
                                    </div>
                                </div>
                                <div class="inputRow">
                                    <div class="icon changeableIconColor calendarIcon"></div>
                                    <div class="inputSec">
                                        <input type="text" placeholder="تاریخ رفت">
                                    </div>
                                </div>
                                <div class="inputRow">
                                    <div class="icon changeableIconColor twoManIcon"></div>
                                    <div class="inputSec">
                                        <input type="text" placeholder="تعداد نفرات را وارد کنید...">
                                    </div>
                                </div>
                            </div>
                            <div id="road_searchPanel" class="body searchPanelBodies">
                                <div class="inputRow">
                                    <div class="icon changeableIconColor locationIcon"></div>
                                    <div class="inputSec">
                                        <input type="text" placeholder="نام مقصد خود را وارد کنید...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="listSection" class="listSection">
                    <div class="title">تور های پیشنهادی کوچیتا</div>
                    <div id="listResult" class="list"></div>
                </div>
            </div>
        </div>

        <div class="sideMenuSection">
            <div class="sideMenuBody backgroundColorChanges">
                <div class="topTitle">
                    <div>تور</div>
                    <div>خوب</div>
                </div>
                <div class="sideMenuTabs">
                    <div class="item road_sideItem sideItem sunIcon" onclick="showTourTypeShow('road')"></div>
                    <div class="item iranTour_sideItem sideItem moonIcon" onclick="showTourTypeShow('iranTour')"></div>
                </div>
            </div>
        </div>
    </div>

</div>

@include('layouts.footer.layoutFooter')

<script>
    var isShowFullSearchPanel = true;
    var nowTourTypeShow = 'road';
    var tourTypeMenu = [
        {
            id: 'road',
            backPic: '{{URL::asset("images/test/roadPic.jpg")}}',
            color: '#522d2d',
            picText: {
                top: 'ماجراجویی در',
                main: 'جاده های بی انتهای',
                bottom: 'ایران من'
            }
        },
        {
            id: 'iranTour',
            backPic: '{{URL::asset("images/test/tourMainPic.jpg")}}',
            color: '#0d6650',
            picText: {
                top: 'شناخت',
                main: 'جاذبه های دیدنی',
                bottom: 'ایران من'
            }
        }
    ];

    var tourSample = [
        {
            url: '#',
            pic: 'https://static.koochita.com/_images/majara/1914659/f-1.jpg',
            categoryName: 'ایران گردی',
            name: 'گشت و گذار در شیراز',
            dayCount: 1,
            nightCount: 1,
            cost: '2.000.000',
        }
    ];

    var destinationSample = [
        {
            url: '#',
            pic: 'https://static.koochita.com/_images/majara/1914659/f-1.jpg'
        },
        {
            url: '#',
            pic: 'https://static.koochita.com/_images/majara/3240714/f-1.jpg'
        },
        {
            url: '#',
            pic: 'https://static.koochita.com/_images/majara/8883015/f-1.jpg'
        },
        {
            url: '#',
            pic: 'https://static.koochita.com/_images/majara/sangtarashan/f-1.jpg'
        },
    ];


    function updatePageElementsSizes(){
        var mainPic = document.getElementById('mainBackgroundPicWithBlur');
        var sidePic = document.getElementById('sideBackgroundPicWithBlur');

        sidePic.style.width = mainPic.offsetWidth + 'px';
        sidePic.style.height = mainPic.offsetHeight + 'px';


        setTimeout(() => {
            var searchSectionHeight = document.getElementById('listSearchTopSection').offsetHeight;
            document.getElementById('listSection').style.height = `calc(100% - ${searchSectionHeight}px)`;
        }, 400);
    }

    function showTourTypeShow(_show){
        for(var i = 0; i < tourTypeMenu.length; i++) {
            if(tourTypeMenu[i].id === _show){
                nowTourTypeShow = tourTypeMenu[i];
                break;
            }
        }


        var backgroundColor = nowTourTypeShow.color;

        getTourSuggestions();

        hideBackgroundPic(nowTourTypeShow.backPic);

        [...document.querySelectorAll('.searchPanelBodies')].map(item => item.classList.remove("show"));

        [...document.querySelectorAll('.sideItem')].map(item => {
            item.classList.remove('select');
            item.style.color = 'white';

            if(item.classList.contains(`${nowTourTypeShow.id}_sideItem`)){
                item.classList.add('select');
                item.style.color = backgroundColor;
            }
        });

        [...document.querySelectorAll('.backgroundColorChanges')].map(item => item.style.background = backgroundColor);
        [...document.querySelectorAll('.changeableIconColor')].map(item => {
            item.style.background = backgroundColor + '33';
            item.style.color = backgroundColor;
        });

        setTimeout(() => {

            document.getElementById('topTourKindText').innerText = nowTourTypeShow.picText['top'];
            document.getElementById('mainTourKindText').innerText = nowTourTypeShow.picText['main'];
            document.getElementById('bottomTourKindText').innerText = nowTourTypeShow.picText['bottom'];

            document.getElementById(`${nowTourTypeShow.id}_searchPanel`).classList.add('show');

            updatePageElementsSizes();
        }, 500);
    }

    function hideBackgroundPic(_pic){
        [...document.querySelectorAll('.backgroundPicTour')].map(item => {
            item.classList.add('addOpacity0ToPic');
            setTimeout(() => item.src = _pic, 500);
        });
    }

    function showBackgroundPic(){
        [...document.querySelectorAll('.backgroundPicTour')].map(item => {
            item.classList.remove('addOpacity0ToPic');
        });
    }

    function doSearchFromPanel(){
        if(isShowFullSearchPanel){

        }
        else{
            showSearchPanel();
        }
    }

    function showSearchPanel(){
        document.getElementById(`${nowTourTypeShow.id}_searchPanel`).classList.add('show');
        setTimeout(() => isShowFullSearchPanel = true, 400);
        updatePageElementsSizes();
    }
    function hideSearchPanel(){
        [...document.querySelectorAll('.searchPanelBodies')].map(item => item.classList.remove("show"));
        setTimeout(() => isShowFullSearchPanel = false, 400);
        updatePageElementsSizes();
    }

    function getTourSuggestions(){
        createTourSuggestionPlaceHolderCard(2);
        createDestinationCardsPlaceHolder(4);

        setTimeout(() => {
            createTourSuggestionCards(tourSample);
            createDestinationCards(destinationSample);
        }, 2000);
    }

    function createTourSuggestionPlaceHolderCard(_count){
        var html = '';
        for(var i = 0; i < _count; i++)
            html += `<div class="tourSmallCard">
                            <div class="imgSec placeHolderAnime"></div>
                            <div class="contentSec">
                                <div class="smallText placeHolderAnime resultLineAnim"></div>
                                <div class="bigBoldText placeHolderAnime resultLineAnim"></div>
                                <div class="smallText placeHolderAnime resultLineAnim"></div>
                                <div class="smallText placeHolderAnime resultLineAnim"></div>
                            </div>
                        </div>`;

        document.getElementById('listResult').innerHTML = html;
    }

    function createTourSuggestionCards(_result){
        var htmlCard = '';
        _result.map(item => {
            htmlCard += `<a href="${item.url}" class="tourSmallCard">
                            <div class="imgSec">
                                <img src="${item.pic}" class="resizeImgClass" alt="tourName" onload="fitThisImg(this)">
                            </div>
                            <div class="contentSec">
                                <div class="smallText">${item.categoryName}</div>
                                <div class="bigBoldText">${item.name}</div>
                                <div class="smallText">${item.dayCount} روز / ${item.nightCount} شب</div>
                                <div class="smallText">شروع قیمت از ${item.cost} تومان</div>
                            </div>
                        </a>`;
        });

        document.getElementById('listResult').innerHTML = htmlCard;
    }

    function createDestinationCardsPlaceHolder(_count){
        var html = '';
        for(var i = 0; i < _count; i++){
            html += `<div class="destinationCard">
                        <div class="destImg placeHolderAnime"></div>
                    </div>`;
        }
        document.getElementById('destinationResult').innerHTML = html;
    }
    function createDestinationCards(_result){
        var html = '';
        _result.map(item => {
            html += `<a href="${item.url}" class="destinationCard">
                        <div class="destImg">
                            <img src="${item.pic}" class="resizeImgClass" alt="cityName" onload="fitThisImg(this)">
                        </div>
                    </a>`;
        });

        document.getElementById('destinationResult').innerHTML = html;
    }

    document.getElementById('listResult').onscroll = e => {
        if(e.target.scrollTop > 0 && isShowFullSearchPanel)
            hideSearchPanel();
        else if(!isShowFullSearchPanel)
            showSearchPanel();
    };

    $(window).ready(() => {
        updatePageElementsSizes();
        showTourTypeShow('road');
    }).on('resize', () => {
        updatePageElementsSizes();
    });
</script>

</body>

</html>
