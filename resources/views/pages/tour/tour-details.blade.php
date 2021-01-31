@extends('layouts.bodyPlace')

@section('title')

    <title>تور {{$tour->name}}</title>
@stop

@section('meta')

@stop

@section('header')
    @parent
    <link rel="stylesheet" href="{{URL::asset('css/theme2/tourDetails.css?v=1')}}">
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
                            <img src="{{URL::asset('images/test/tourAjansSample.png')}}" class="resizeImgClass" alt="نام آژانس" onload="fitThisImg(this)">
                        </div>
                    </div>
                    <div class="detailRowPost">
                        از
                        <span class="boldPostal">{{$tour->src->name}}</span>
                        به
                        <span class="boldPostal">{{$tour->dest->name}}</span>
                    </div>
                    <div class="detailRowPost">
                        از
                        <span class="boldPostal">
                            <span class="sDateName">{{$tour->sDateName}}</span>
                        </span>
                        تا
                        <span class="boldPostal">
                            <span class="eDateName">{{$tour->eDateName}}</span>
                        </span>

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
                    <div class="postalLastRow"> .این تور توسط "ستاره ونک" برگذار می شود و کوچیتا هیچ گونه مسئولیتی ، درباره نحوه ی برگزاری ان ندارد</div>
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
                <div class="col-md-8 borderLight top">
                    <div class="borderBotDashed">
                        <div class="bodiesHeader">چه انتظاری داشته باشیم</div>
                        <div class="bodiesText">{{$tour->textExpectation}}</div>
                    </div>
                    <div class="borderBotDashed">
                        <div class="bodiesHeader">اطلاعات اختصاصی</div>
                        <div class="bodiesText">{{$tour->specialInformation}}</div>
                    </div>
{{--                    <div class="borderBotDashed">--}}
{{--                        <div class="bodiesHeader">پیشنهادات برای سفر بهتر</div>--}}
{{--                        <div class="bodiesText">{{$tour->opinion}}</div>--}}
{{--                    </div>--}}
                    <div class="borderBotDashed">
                        <div class="bodiesHeader">محدودیت های سفر</div>
                        <div class="bodiesText">{{$tour->tourLimit}}</div>
                    </div>
                </div>
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

                    <div style="display: flex; width: 40%">
                        <div class="picSec">
                            <img src="http://localhost/assets/userProfile/1608119658907.jpg" class="resizeImgClass" alt="tourGuidPic" onload="fitThisImg(this)">
                        </div>
                        <div class="infoSec">
                            <div class="name tourGuidName"></div>
                            <div class="tourGuidInKoochita" style="position: relative;flex-direction: column; display: flex;">
                                <div class="fullyCenterContent" style="font-size: 25px;"><div class="ui_bubble_rating bubble_10"></div></div>
                                <a href="#" class="butse" style="background: var(--koochita-red);">صفحه تور گردان</a>
                                <a href="#" class="butse" style="background: var(--koochita-blue);">ارسال پیام</a>
                            </div>
                        </div>
                    </div>

                    <div class="fullyCenterContent" style="border: dashed 1px gray; width: 20%">
                        <div class="infoSec">
                            <div class="ajasLogo" style="height: 80px">
                                <img src="https://localhost/kouchita/public/images/test/tourAjansSample.png">
                            </div>
                            <div class="name" style="font-size: 20px; margin-bottom: 0; margin-top: 11px;">آژانس ستاره ونک</div>
                            <div style="position: relative;flex-direction: column; display: flex;">
                                <div class="fullyCenterContent" style="font-size: 25px;"><div class="ui_bubble_rating bubble_10"></div></div>
                                <a href="#" class="butse" style="background: var(--koochita-red);">صفحه آژانس</a>
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; width: 40%; align-items: center;justify-content: center; direction: ltr;">
                        <div style=" text-align: center; font-size: 180px; color: var(--koochita-red); margin-right: 16px; height: 200px;">
                            <i class="fad fa-user-headset"></i>
                        </div>
                        <div style="text-align: center; font-size: 24px;">
                            <div class="backupPhones">
                                <a href="tel:021-88492744">021-88492744</a>
                                <a href="tel:021-88492744">021-88492744</a>
                                <a href="tel:021-88492744">021-88492744</a>
                            </div>
                            <div> تماس با پشتیبانی تور</div>
                            <div>کدشناسایی تور</div>
                            <div> 100-001-1200-1</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="dayInfoSection" class="row" style="direction: rtl">
            <div class="bodiesHeader">برنامه روزانه تور</div>
            <div class="dayInfoSectionRow">
                <div class="selectDaySec" style="width: 30%">
                    <div id="listOfDays" class="daysChoose">
                        @for($i = 1; $i < 11; $i++)
                            <div class="dayRow {{$i == 1 ? 'selected' : ''}}" data-day="{{$i}}" onclick="selectDay(this)">
                                <div class="dayCircle"></div>
                                <div class="dayName">روز {{$i}} :</div>
                                <div class="dayTitle">برنامه روز {{$i}}</div>
                            </div>
                        @endfor
                    </div>
                </div>

                <div class="dayDetails" style="width: 70%;">
                    <div id="fullDayDetailSection" class="minDatail">
                        <div id="detailInfSec" class="detailInfSec">
                            <div class="dayInfoRow">
                                <div class="title">
                                    <div class="iconSec trainIcon"></div>
                                    شروع تور
                                    <div class="time">13:00 - 14:43</div>
                                </div>
                                <div class="text">
                                    لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است،
                                    چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد
                                    نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای زیادی در شصت و سه درصد گذشته
                                    حال و آینده، شناخت فراوان جامعه و متخصصان را می طلبد، تا با نرم افزارها شناخت بیشتری را برای طراحان
                                    رایانه ای علی الخصوص طراحان خلاقی، و فرهنگ پیشرو در زبان فارسی ایجاد کرد، در این صورت می توان امید د
                                    اشت که تمام و دشواری موجود در ارائه راهکارها، و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز
                                    شامل حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.
                                </div>
                            </div>
                        </div>
                        <div class="dayIndicator">
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

                    <div id="showBigDays" class="BigDetail">
                        @for($i = 1; $i < 11; $i++)
                            <div id="mainDayShow_{{$i}}" class="bigDetailRow borderBotDashed">
                                <div class="title">
                                    <div class="dayCount">روز {{$i}}</div>
                                    <div class="name">برنامه روز {{$i}}</div>
                                </div>
                                <div class="text">
                                    لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است،
                                    چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد
                                    نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای زیادی در شصت و سه درصد گذشته
                                    حال و آینده، شناخت فراوان جامعه و متخصصان را می طلبد، تا با نرم افزارها شناخت بیشتری را برای طراحان
                                    رایانه ای علی الخصوص طراحان خلاقی، و فرهنگ پیشرو در زبان فارسی ایجاد کرد، در این صورت می توان امید د
                                    اشت که تمام و دشواری موجود در ارائه راهکارها، و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز
                                    شامل حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.
                                </div>
                                <div class="sideInfos">
                                    <div class="title">
                                        <div class="iconSec hotelIcon"></div>
                                        <div class="name">محل اقامت :</div>
                                    </div>
                                    <div class="content">
                                        <a href="#">هتل عباسی شیراز در فارس</a>
                                    </div>
                                </div>
                                <div class="sideInfos">
                                    <div class="title">
                                        <div class="iconSec restaurantIcon"></div>
                                        <div class="name">وعده غذایی تور :</div>
                                    </div>
                                    <div class="content">صبحانه - شام</div>
                                </div>
                                <div class="showAllDetail leftArrowIconAfter" onclick="openDayDetails({{$i}})">مشاهده جزئیات روز</div>
                            </div>
                        @endfor
                    </div>
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
        var tourInformationUrl = '{{route("tour.getInformation")}}?code='+tourCode;
        var checkCapacityUrl = '{{route("tour.reservation.checkCapacity")}}';
        var getPassengerInfoUrl = '{{route("tour.reservation.getPassengerInfo")}}';

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

    <script defer src="{{URL::asset('js/pages/tour/tourShow.js')}}"></script>

@stop
