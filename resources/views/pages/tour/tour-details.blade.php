@extends('layouts.bodyPlace')

@section('title')

    <title>تور {{$tour->name}}</title>
@stop

@section('meta')

@stop

@section('header')
    @parent
    <link rel="stylesheet" href="{{URL::asset('css/theme2/tourDetails.css?v='.$fileVersions)}}">
    <link rel="stylesheet" href="{{URL::asset('packages/leaflet/leaflet.css')}}">

    <link rel="stylesheet" href="{{URL::asset('packages/fontAwesome6/css/all.min.css')}}">
    <script src="{{URL::asset('packages/fontAwesome6/js/all.min.js')}}"></script>

    <style>
        body{
            background: white;
        }
        .changeWidth {
            @if(session('goDate'))
                   width: 14% !important;
            @endif
        }

        .poiTile {
            float: left;
        }
        .secondRowSection{
            background-image: url('{{URL::asset('images/mainPics/carftpaper.jpg')}}');
        }
        .tourGuidAjansSection .tourGuidSection {
            background-image: url("{{URL::asset('images/mainPics/carftpaper.jpg')}}");
        }
        .buyButton{
            background-image: url("{{URL::asset('images/tourCreation/nutTambrButton.svg')}}");
        }
        .hasInsurance:before{
            background-image: url("{{URL::asset('images/tourCreation/tambrBorder.svg')}}");
        }
        .transportSection .transportsSec .mapButTransportMain{
            background-image: url("{{URL::asset('images/tourCreation/tambrBorder.svg')}}");
        }
        .checkListPaper .topPaper{
            background-image: url("{{URL::asset('images/tourCreation/topPaper.svg')}}");
        }
        .notTransport{
            font-size: 17px;
            margin-bottom: 20px;
            margin-right: 10px;
            color: red;
        }
        .schedulePlaceSection {
            display: flex;
            flex-wrap: wrap;
        }
        .schedulePlaceSection .placeCardInShowTour{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: 16px;
            text-align: center;
            color: black;
            font-size: 12px;
        }
        .schedulePlaceSection .placeCardInShowTour .picSection{
            border: solid 1px lightgray;
            border-radius: 5px;
            padding: 3px;
        }
        .schedulePlaceSection .placeCardInShowTour .picSection .backPic{
            width: 150px;
            height: 100px;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            border-radius: 5px;
        }
        .schedulePlaceSection .placeCardInShowTour .content{
            margin-top: 5px;
        }
        .schedulePlaceSection .placeCardInShowTour .content .boldText{
            font-size: 1em;
            font-weight: bold;
        }
        .schedulePlaceSection .placeCardInShowTour .content .smallText{
            color: gray;
            font-size: .8em;
        }
    </style>
@stop

@section('main')

    <div class="ppr_rup ppr_priv_hr_atf_north_star_nostalgic">

        <div class="container secondRowSection">
            <div class="container postalCardBorder" style="width: 100%; padding: 0;">
                <div class="bestPriceRezerved postalInfoSection col-xs-7">
                    <div class="postalFirstRow">
                        <div class="tourName">{{$tour->name}}</div>
                        <div class="ajansPic">
                            <img src="{{$tour->agencyLogo}}" alt="{{$tour->agencyName}}" style="max-width: 100%; max-height: 100%;">
                        </div>
                    </div>
                    @if($tour->type != 'cityTourism')
                        <div class="detailRowPost">
                            از
                            <span class="boldPostal">{{$tour->src->name}}</span>
                            به
                            <span class="boldPostal">{{$tour->dest->name}}</span>
                        </div>
                    @endif
                    <div class="detailRowPost">
                        @if($tour->sDateName === $tour->eDateName)
                            <span class="boldPostal">
                                <span class="sDateName">{{$tour->sDateName}}</span>
                            </span>
                        @else
                            از
                            <span class="boldPostal">
                                <span class="sDateName">{{$tour->sDateName}}</span>
                            </span>
                            تا
                            <span class="boldPostal">
                                <span class="eDateName">{{$tour->eDateName}}</span>
                            </span>
                        @endif
                    </div>

                    <div class="detailRowPost">
                        قیمت :
                        <span class="boldPostal showCostSection">
                            <div class="mainCostShow"></div>
                            <div class="costWithDiscount"></div>
                        </span>

                        <div class="moreBottomBorder"></div>
                        <div class="buyBut" onclick="selectBuyButton()">خرید</div>
                    </div>
                    <div class="bottomTourHeaderCard">
                        <div id="discountButton" class="buyButton hidden">
                            <div class="text">10% تخفیف</div>
                        </div>
                        @if($tour->isInsurance == 1)
                            <div class="hasInsurance"> بیمه دارد</div>
                        @endif
                    </div>
                    <div class="postalLastRow"> .این تور توسط "{{$tour->agencyName}}" برگذار می شود و کوچیتا هیچ گونه مسئولیتی ، درباره نحوه ی برگزاری آن ندارد</div>
                </div>
                <div class="mainSliderSection col-xs-5">
                    <div class="posRelWH100">
                        <div {{isset($tour->pics) && count($tour->pics) > 0 ? "onclick=showPhotoAlbum('allPic')" : ''}} style="width: 100%; height: 100%;">
                            <div id="mainSlider" class="swiper-container">
                                <div class="swiper-wrapper">
                                    @foreach($tour->pics as $pic)
                                        <div class="swiper-slide" style="overflow: hidden">
                                            <img class="eachPicOfSlider resizeImgClass" src="{{$pic->pic}}" alt="{{$tour->name}}" onload="fitThisImg(this)">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="left-nav left-nav-header swiper-button-next mainSliderNavBut"></div>
                        <div class="right-nav right-nav-header swiper-button-prev mainSliderNavBut"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container" style="display: flex; flex-direction: column; padding: 0px">

        <div class="rowChooseDate" style="direction: rtl;">
            <div class="bodiesHeader" style="text-align: center;font-size: 25px;">تاریخ های دیگری که این تور برگزار می شود</div>
            <table class="moreFeature table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>از تاریخ</th>
                        <th>تا تاریخ</th>
                        <th>ظرفیت</th>
                    </tr>
                </thead>
                <tbody id="tourTimesTable"></tbody>
            </table>
        </div>

        <div class="lightCraftBackground">
            <div class="stickyTopEnvelop">
                <div class="headerForEnvelop"> اطلاعات کامل تور </div>
            </div>

            <div class="row mainInfosSection">
                <div class="col-md-12 transportSection">
                    <div class="bodiesHeader">حمل نقل تور</div>
                    <div class="body" style="display: flex; justify-content: space-between;">
                        <div class="transportsSec">
                            <div class="title">رفت</div>
                            <div class="mapButTransportMain" onclick="showTransportInMap('start')">نقشه</div>
                            <div class="sMainTransportKind transportWithBottomDashed" style="font-size: 20px"></div>
                            <div class="transportWithBottomDashed">
                                <span style="font-weight: bold;">ساعت حرکت :</span>
                                <span class="sMainTransportTime"></span>
                            </div>
                            <div class="transportWithBottomDashed">
                                <span style="font-weight: bold;">محل سوار شدن :</span>
                                <span class="sMainTransportAddress"></span>
                            </div>
                            <div class="transportWithBottomDashed" style="font-size: 14px;">
                                <span style="font-weight: bold">توضیحات تکمیلی:</span>
                                <span class="sMainTransportDescription"></span>
                            </div>
                        </div>
                        <div class="transportsSec">
                            <div class="title">برگشت</div>
                            <div class="mapButTransportMain" onclick="showTransportInMap('end')">نقشه</div>
                            <div class="eMainTransportKind transportWithBottomDashed" style="font-size: 20px"></div>
                            <div class="transportWithBottomDashed">
                                <span style="font-weight: bold;">ساعت برگشت :</span>
                                <span class="eMainTransportTime"></span>
                            </div>
                            <div class="transportWithBottomDashed">
                                <span style="font-weight: bold;">محل پیاده شدن :</span>
                                <span class="sMainTransportAddress"></span>
                            </div>
                            <div class="transportWithBottomDashed" style="font-size: 14px;">
                                <span style="font-weight: bold">توضیحات تکمیلی:</span>
                                <span class="eMainTransportDescription"></span>
                            </div>
                        </div>
                        <div class="notTransport hidden"> حمل و نقل این تور برعهده خود مسافر می باشد </div>
                    </div>
                </div>
{{--                <div class="col-md-8 borderLight top">--}}
{{--                    <div class="borderBotDashed">--}}
{{--                        <div class="bodiesHeader">چه انتظاری داشته باشیم</div>--}}
{{--                        <div class="bodiesText">{{$tour->textExpectation}}</div>--}}
{{--                    </div>--}}
{{--                    <div class="borderBotDashed">--}}
{{--                        <div class="bodiesHeader">اطلاعات اختصاصی</div>--}}
{{--                        <div class="bodiesText">{{$tour->specialInformation}}</div>--}}
{{--                    </div>--}}
{{--                    <div class="borderBotDashed">--}}
{{--                        <div class="bodiesHeader">محدودیت های سفر</div>--}}
{{--                        <div class="bodiesText">{{$tour->tourLimit}}</div>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="col-md-4 borderLight top left" style="padding: 0px">
                    <div id="propertySection" class="propertySection"></div>
                </div>
            </div>
        </div>

        <div id="moreFeatureDivSec" style="direction: rtl; margin-top: 25px;">
            <div class="bodiesHeader">امکانات اضافه</div>
            <table class="moreFeature table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>عنوان</th>
                        <th>قیمت</th>
                        <th>توضیحات</th>
                    </tr>
                </thead>
                <tbody class="additionalFeatures"></tbody>
            </table>
        </div>

        <div class="equipmentSection">
            <div id="mustEquDivSec" class="checkListPaper">
                <div class="topPaper"></div>
                <div class="title">
                    <div class="text" style="color: #b41b17">لوازم ضروری</div>
                </div>
                <div id="mustEquipments" class="body"></div>
            </div>

            <div id="suggEquDivSec" class="checkListPaper">
                <div class="topPaper"></div>

                <div class="title">
                    <div class="text" style="color: #131457">لوازم پیشنهادی</div>
                </div>
                <div id="suggestEquipments" class="body"></div>
            </div>
        </div>

        <div class="row tourGuidAjansSection">

            <div class="col-md-12 fullyCenterContent" style="flex-direction: column;">
                <div class="tourGuidSection">
                    <div class="circleButtons top"></div>
                    <div class="circleButtons bottom"></div>

                    @if($tour->guid->has)
                        <div class="tourGuidInfo">
                            <div class="picSec">
                                <img src="{{$tour->guid->pic}}" class="resizeImgClass" alt="tourGuidPic" onload="fitThisImg(this)">
                            </div>
                            <div class="infoSec">
                                <div class="name tourGuidName showOneLineText">{{$tour->guid->name}}</div>
                                <div class="tourGuidInKoochita">
                                    @if($tour->guid->koochita)
                                        <div class="fullyCenterContent" style="font-size: 25px;">
                                            <div class="ui_bubble_rating bubble_10"></div>
                                        </div>
                                        <a href="{{route('profile', ['username' => $tour->guid->name])}}" target="_blank" class="butse" style="background: var(--koochita-red);">صفحه تور گردان</a>
                                        <div class="butse" style="background: var(--koochita-blue); cursor: pointer;" onclick="goToMsgPageGuid('{{$tour->guid->name}}')">ارسال پیام</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="fullyCenterContent ajansInfoSection">
                        <div class="infoSec">
                            <div class="ajasLogo">
                                <img src="{{$tour->agencyLogo}}">
                            </div>
                            <div class="name">{{$tour->agencyName}}</div>
                            <div class="rateAndPage">
                                <div class="fullyCenterContent" style="font-size: 25px;"><div class="ui_bubble_rating bubble_10"></div></div>
                                <a href="#" class="butse" style="background: var(--koochita-red);">صفحه آژانس</a>
                            </div>
                        </div>
                    </div>

                    <div class="fullyCenterContent backupAgency">
                        <div class="iconDiv">
                            <i class="fad fa-user-headset"></i>
                        </div>
                        <div class="phones">
                            <div class="backupPhones">
                                @foreach($tour->backupPhone as $phone)
                                <a href="tel:{{$phone}}">{{$phone}}</a>
                                @endforeach
                            </div>
                            <div> تماس با پشتیبانی تور</div>
                            <div>کدشناسایی تور</div>
                            <div>{{$tour->codeNumber}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="dayInfoSection" class="row" style="direction: rtl">
            <div class="bodiesHeader">برنامه روزانه تور</div>
            <div class="dayInfoSectionRow">
                <div class="selectDaySec" style="width: 30%">
                    <div id="listOfDays" class="daysChoose"></div>
                </div>

                <div class="dayDetails" style="width: 70%;">
                    <div id="fullDayDetailSection" class="minDatail">
                        <div id="detailInfSec" class="detailInfSec"></div>
                        <div class="dayIndicator" style="display: none;">
                            <div class="indiMainLineSection">
                                <div class="mainLine"></div>
                                <div class="linesSec">
                                    @for($i = 0; $i < 24; $i++)
                                        <div class="hourSec">
                                            <div class="text">{{$i < 10 ? '0'.$i : $i}}:{{$i != 23 ? '00' : '59'}}</div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            <div id="dayEventIdicator" class="indiDatas"></div>
                        </div>
                    </div>

                    <div id="showBigDays" class="BigDetail"></div>
                </div>
            </div>
        </div>
    </div>

    <div id="mapModal" class="modalBlackBack fullCenter mapModal">
        <div class="modalBody">
            <div class="closeButtonModal iconClose" onclick="closeMyModal('mapModal')"></div>
            <div id="mapSection" style="width: 100%; height: 100%"></div>
        </div>
    </div>

    <div id="buyModal" class="modalBlackBack fullCenter buyModal">
        <div class="modalBody">
            <div class="closeButtonModal iconClose" onclick="closeMyModal('buyModal')"></div>
            <div class="header">
                خرید تور
                <span class="tourName"></span>
            </div>
            <div>از <span class="sDateName"></span> تا <span class="eDateName"></span></div>
            <div>برای خرید تور شما باید تعداد نفرات خود را مشخص کنید، سپس اطلاعات فردی هر مسافر را وارد نمایید</div>
            <div class="row priceSection">
                <div id="tourPriceOptions" class="col-xs-5">
                    <div class="full-width inline-block">
                        <span class="inline-block" style="font-weight: bold;">هزینه امکانات اضافه</span>
                        <span class="inline-block"></span>
                        <div class="full-width inline-block additionalFeaturesForBuy"></div>
                    </div>

                    <div class="full-width inline-block">
                        <div class="totalFeaturesCost" style="font-size: 14px;">
                            <div class="title">جمع کل امکانات اضافه</div>
                            <div class="cost featureTotalCost">0</div>
                        </div>
                    </div>
                </div>

                <div id="tourPricePerMan" class="col-xs-7">
                    <div id="pricesInBuyButton"></div>
                    <div class="full-width inline-block">
                        <span>هزینه امکانات اضافه</span>
                        <span class="featureTotalCost">0</span>
                    </div>
                    <div class="full-width inline-block">
                        <div class="totalFeaturesCost" style="margin-top: 10px;">
                            <div class="title">جمع کل هزینه ها</div>
                            <div class="cost passengerTotalCost">0</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 fullyCenterContent">
                    <button class="tourListPurchaseBtn" onclick="reserveTour()">خرید</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{URL::asset('packages/leaflet/leaflet.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('packages/leaflet/leaflet-wms-header.js')}}"></script>

    <script>
        var tourPrices;
        var passengerCount = [];
        var features = [];
        var dayEvents = [];
        var tourCode = '{{$tour->code}}';
        var tourTimeCode = '{{$tour->timeCode}}';
        var tourInformationUrl = `{{route("tour.getInformation")}}?code=${tourCode}`;
        var checkCapacityUrl = '{{route("tour.reservation.checkCapacity")}}';
        var getPassengerInfoUrl = '{{route("tour.reservation.getPassengerInfo")}}';
        var messengerTourGuidPage = '{{route("profile.message.page")}}';

        var mainSlideSwiper = new Swiper('#mainSlider', {
            spaceBetween: 0,
            centeredSlides: true,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            navigation: {
                prevEl: '.swiper-button-next',
                nextEl: '.swiper-button-prev',
            },
        });
    </script>

    <script defer src="{{URL::asset('js/pages/tour/tourShow.js?v='.$fileVersions)}}"></script>

@stop
