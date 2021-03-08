<!doctype html>
<html lang="fa">
<head>
    @include('layouts.topHeader')
    <title>صفحه اصلی تور</title>
    <link rel="stylesheet" href="{{URL::asset('css/pages/tours/mainPageTour.css?v='.$fileVersions)}}">

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

                    <div class="findTourSection" style="display: none;">
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
                            <div id="cityTour_searchPanel" class="body searchPanelBodies">
                                <div class="inputRow">
                                    <div class="icon changeableIconColor locationIcon"></div>
                                    <div class="inputSec">
                                        <input type="text" placeholder="نام شهر مورد نظر را وارد کنید...">
                                    </div>
                                </div>
                                <div class="inputRow">
                                    <div class="icon changeableIconColor calendarIcon"></div>
                                    <div class="inputSec">
                                        <input type="text" placeholder="تاریخ">
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
                    <div class="item cityTour_sideItem sideItem sunIcon" onclick="showTourTypeShow('cityTour')"></div>
                    <div class="item iranTour_sideItem sideItem moonIcon" onclick="showTourTypeShow('iranTour')"></div>
                </div>
            </div>
        </div>
    </div>

</div>

@include('layouts.footer.layoutFooter')

<script>
    var itoPic = '{{URL::asset("images/test/itoLogo.png")}}';
    var getMainPageToursUrl = '{{route("tour.getMainPageTours")}}';
    var isShowFullSearchPanel = true;
    var nowTourTypeShow;
    var tourTypeMenu = [
        {
            id: 'cityTour',
            backPic: '{{URL::asset("images/test/tehran.jpg")}}',
            color: '#522d2d',
            picText: {
                top: 'ماجراجویی در',
                main: 'شهرهای متنوع',
                bottom: 'ایران من'
            },
            isGet: false,
            tours: [],
            destinations: []
        },
        {
            id: 'iranTour',
            backPic: '{{URL::asset("images/test/tourMainPic.jpg")}}',
            color: '#0d6650',
            picText: {
                top: 'شناخت',
                main: 'جاذبه های دیدنی',
                bottom: 'ایران من'
            },
            isGet: false,
            tours: [],
            destinations: []
        }
    ];

    function doSearchFromPanel(){
        if(isShowFullSearchPanel){

        }
        else{
            showSearchPanel();
        }
    }

    $(window).ready(() => {
        updatePageElementsSizes();
        showTourTypeShow('cityTour');
    }).on('resize', () => {
        updatePageElementsSizes();
    });
</script>

<script src="{{URL::asset('js/pages/tour/tourMainPage.js?v='.$fileVersions)}}"></script>
</body>

</html>
