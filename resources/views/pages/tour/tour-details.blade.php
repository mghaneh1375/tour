@extends('layouts.bodyPlace')

@section('title')

    <title>تور {{$tour->name}}</title>
@stop

@section('meta')

@stop

@section('header')
    @parent
    <link rel="stylesheet" href="{{URL::asset('css/theme2/tourDetails.css?v=1')}}">

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
            background-position: center;
            background-size: cover;
            padding: 20px;
        }
        .postalInfoSection .detailRowPost .buyBut{
            border: solid 2px rgba(156,57,36, 1);
            position: absolute;
            top: 115%;
            display: flex;
            padding: 0px 30px;
            font-weight: bold;
            background: rgba(156, 57, 36, 0.75);
            cursor: pointer;
            left: 0px;
            z-index: 1;
        }

        .stickyTopEnvelop{
{{--            background-image: url('{{URL::asset("images/mainPics/lightCraft.jpg")}}');--}}
            /*background-position: center;*/
            /*background-size: cover;*/
            padding-bottom: 15px;
        }
        .headerForEnvelop{
            font-family: Shin !important;
            height: 70px !important;
            text-align: center;
            box-shadow: 0px 3px 3px #000000;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0px 0px 100px 100px;
            border: solid 1px black;
            border-top: none;
            border-bottom: none;
            padding: 15px;
            color: black;
            color: #b41b17;
            margin: 0px 5px;
            font-weight: bold;
            font-size: 70px;
        }

        .mainIntroductionSection{
            padding: 0px 30px;
        }

        .mainInfosSection{
{{--            background-image: url("{{URL::asset('images/mainPics/lightCraft.jpg')}}");--}}
/*            background-position: center;*/
            /*border-top: solid 2px var(--koochita-red);*/
            /*border-bottom: solid 2px var(--koochita-red);*/

            direction: rtl;
            width: 100%;
            margin: 0;
            margin-top: 20px;
        }

        .lightCraftBackground{
            {{--background-image: url("{{URL::asset('images/mainPics/lightCraft.jpg')}}");--}}
            /*background-position: center;*/
            /*background-size: cover;*/
            box-shadow: 0px 10px 10px 3px #000000a6;
            border: dashed 4px black;
        }


        .transportWithBottomDashed{
            border-bottom: dashed 1px black;
            margin: 15px 0px;
        }

        .transportSection{

        }
        .transportSection .title{
            font-weight: bold;
            font-size: 15px;
            /*color: var(--koochita-red);*/
            color: black;
        }
        .transportSection .transportsSec{
            border: solid 2px rgba(156,57,36, 1);
            width: 49%;
            margin-bottom: 15px;
            padding: 10px;
            position: relative;
            border-color: black;
        }
        .transportSection .transportsSec .mapButTransportMain{
            background-image: url("{{URL::asset('images/tourCreation/tambrBorder.svg')}}");
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 50px;
            background-size: cover;
            height: 40px;
            position: absolute;
            left: 5px;
            top: 4px;
            font-weight: bold;
        }


        .equipmentSection{
            margin: 25px 0px;
            display: flex;
            justify-content: space-between;
        }
        .equipmentSection .checkListPaper{
            width: 50%;
            margin: 10px;
            border: solid 1px #999999;
            box-shadow: 2px 11px 9px 0px #42424238;
            padding: 0px 15px;
            position: relative;
            border-top: none;
        }
        .equipmentSection .checkListPaper .title{
            font-size: 23px;
            text-align: center;
            font-weight: bold;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            margin: 10px 15px;
            height: 45px;
            margin-top: 35px;
        }
        .equipmentSection .checkListPaper .title .text{
            background: white;
            z-index: 9;
            padding: 0px 10px;
            font-family: Shin !important;
            font-size: 50px;
            line-height: 10px;
        }
        .equipmentSection .checkListPaper .title:before{
            content: '';
            width: 100%;
            height: 2px;
            position: absolute;
            background: #1314578c;
        }
        .equipmentSection .checkListPaper .body{
            direction: rtl;
        }
        .equipmentSection .checkListPaper .body .checkRow{
            direction: rtl;
            height: 33px;
            padding-bottom: 6px;
            display: inline-flex;
            width: 49%;
        }
        .equipmentSection .checkListPaper .body .checkRow .tichSquer{
            width: 20px;
            height: 20px;
            border-radius: 4px;
            border: solid 1px lightgray;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            font-size: 16px;
        }
        .equipmentSection .checkListPaper .body .checkRow .text{
            border-bottom: solid 1px #3c3fff33;
            margin-bottom: 10px;
            width: 100%;
            margin-right: 5px;
            padding-right: 5px;
        }

        .checkListPaper .topPaper{
            background-image: url("{{URL::asset('images/tourCreation/topPaper.svg')}}");
            height: 39px;
            position: absolute;
            top: 0px;
            right: 0px;
            width: 100%;
            z-index: 20;
        }

        .moreFeature{
            direction: rtl;
            border: 2px solid #ddd;
        }
        .moreFeature th, .moreFeature td{
            direction: rtl;
            text-align: right;
        }
        .moreFeature .description{
            font-size: 13px;
        }

        .otherDateChoose{
            cursor: pointer;
            transition: .3s;
        }
        .otherDateChoose.selectdd{
            background: var(--koochita-light-green) !important;
        }
        .otherDateChoose:hover{
            background: var(--koochita-light-green) !important;
        }


        .buyButton{
            background-image: url("{{URL::asset('images/tourCreation/nutTambrButton.svg')}}");
            height: 140px;
            cursor: pointer;
            width: 300px;
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            position: absolute;
            bottom: 16px;
            left: 76px;
        }
        .buyButton .text{
            width: 84px;
            height: 84px;
            text-align: center;
            font-weight: bold;
            color: #bb465d;
            transform: rotate(-16deg);
            font-size: 28px;
            line-height: 26px;
            margin-top: 15px;
        }

        .hasInsurance{
            position: absolute;
            right: 25px;
            width: 48px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            font-size: 49px;
            font-family: 'Shin' !important;
            line-height: 37px;
            color: var(--koochita-green);
            top: 15px;
        }
        .hasInsurance:before{
            content: '';
            background-image: url("{{URL::asset('images/tourCreation/tambrBorder.svg')}}");
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            transform: rotate(90deg);
            width: 100px;
            height: 200px;
            position: absolute;
        }


        .tourGuidAjansSection{
            direction: rtl;
            margin: 40px 0px;
        }
        .tourGuidAjansSection .tourGuidSection{
            background-image: url("{{URL::asset('images/mainPics/carftpaper.jpg')}}");
            display: flex;
            border: solid 1px gray;
            padding: 10px;
            position: relative;
            width: 100%;
        }
        .tourGuidAjansSection .tourGuidSection .picSec{
            display: flex;
            width: 200px;
            height: 200px;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }
        .tourGuidAjansSection .tourGuidSection .infoSec{
            margin: 0px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .tourGuidAjansSection .tourGuidSection .infoSec .name{
            font-size: 25px;
            color: #b41b17;
            margin-bottom: 13px;
        }
        .tourGuidAjansSection .tourGuidSection .button{
            transform: rotate(-90deg);
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            left: -35px;
            top: 37px;
            border-bottom: dashed 1px gray;
            padding: 7px 5px;
            cursor: pointer;
        }
        .tourGuidAjansSection .tourGuidSection .circleButtons{
            position: absolute;
            background: white;
            width: 20px;
            height: 20px;
            left: -10px;
            border: solid 1px gray;
            border-radius: 50%;
            border-top: none;
            border-bottom: none;
            border-left: none;
            transform: rotate(45deg);
        }
        .tourGuidAjansSection .tourGuidSection .circleButtons:before{
            content: '';
            width: 21px;
            height: 10px;
            position: absolute;
            background: white;
            top: -12px;
            transform: rotate(-45deg);
            left: 8px;
        }
        .tourGuidAjansSection .tourGuidSection .circleButtons:after{
            content: '';
            width: 21px;
            height: 10px;
            position: absolute;
            background: white;
            left: 0px;
            transform: rotate(45deg);
            top: 14px;
        }
        .tourGuidAjansSection .tourGuidSection .circleButtons.top{
            top: -10px;
        }
        .tourGuidAjansSection .tourGuidSection .circleButtons.bottom{
            bottom: -10px;
            transform: rotate(-45deg);
        }

        .tourGuidSection .butse{
            margin-top: 15px;
            padding: 3px 6px;
            border: solid 1px;
            font-size: 20px;
            text-align: center;
            color: white;
        }

        .closeButtonModal{
            position: absolute;
            left: 5px;
            top: 0px;
            font-size: 34px;
            color: var(--koochita-red);
            cursor: pointer;
        }

        .additionalBackDark{
            position: fixed;
            top: 0px;
            right: 0px;
            width: 100%;
            height: 100%;
            z-index: 1;
            background: #000000ad;
        }
        .buyModal{
            z-index: 999;
        }
        .buyModal .modalBody{
            max-width: 1000px;
        }
        .buyModal .modalBody .buyFeatureRow{
            display: flex;
            border-top: solid 1px lightgray;
            margin-bottom: 10px;
            padding: 5px 0px;
            align-items: center;
        }
        .buyModal .priceSection{
            margin-top: 15px;
            padding-top: 15px;
            border-top: solid 1px lightgray;
        }
        .buyModal .passengerInput{
            display: flex;
            align-items: center;
            position: relative;
        }
        .buyModal .passengerInput .text{
            font-weight: normal;
            font-size: 14px;
            margin-right: 10px;
            width: 100%;
        }
        .buyModal .passengerInput .popup{
            position: absolute;
            background: white;
            top: 100%;
            z-index: 9;
            padding: 13px;
            width: 100%;
            border: solid 2px gray;
            border-radius: 10px;
        }
        .buyModal .passengerInput .popup > div{

        }
        .buyModal .passengerInput .popup > div label{
            font-size: 13px;
        }
        .buyModal .totalFeaturesCost{
            display: flex;
            justify-content: space-around;
            font-weight: bold;
            font-size: 22px;
            margin-top: 20px;
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
                    <div class="detailRowPost ">
                        شروع قیمت از :
                        <span class="boldPostal">{{$tour->cost}}</span>
                        <div class="moreBottomBorder"></div>
                        <div class="buyBut" onclick="selectBuyButton()">خرید</div>
                    </div>
                    <div style="display: flex; height: 145px; position: relative;">
                        <div class="buyButton">
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

        @if($tour->timeKind > 0)
            <div class="rowChooseDate" style="direction: rtl;">
                <div class="bodiesHeader" style="text-align: center;font-size: 25px;">تاریخ های دیگری که این تور برگزار می شود</div>
                <table class="moreFeature table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>از تاریخ</th>
                            <th>تا تاریخ</th>
                        </tr>
                    </thead>
                    <tbody id="tourTimesTable"></tbody>
                </table>
            </div>
        @endif

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
                            <div class="mapButTransportMain">نقشه</div>
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
                            <div class="mapButTransportMain">نقشه</div>
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

        <div style="direction: rtl; margin-top: 25px;">
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
            <div class="checkListPaper">
                <div class="topPaper"></div>
                <div class="title">
                    <div class="text" style="color: #b41b17">لوازم ضروری</div>
                </div>
                <div id="mustEquipments" class="body"></div>
            </div>

            <div class="checkListPaper">
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
                            <div class="name">علیرضا قربانی</div>
                            <div style="position: relative;flex-direction: column; display: flex;">
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
                            <div>021-88492744</div>
                            <div>09122474393</div>
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


        <div class="hr_btf_wrap" style="position: relative;">
            <div id="introduction" class="ppr_rup ppr_priv_location_detail_overview">
                <div class="block_wrap" data-tab="TABS_OVERVIEW">
                    <div style="margin: 15px 0 !important;">
                        <div id="showMore" onclick="showMore()" style="float: left; cursor: pointer;color:var(--koochita-light-green); font-size: 13px;" class="hidden">بیشتر</div>
                        <div class="overviewContent" id="introductionText" style="direction: rtl; font-size: 14px; max-height: 21px; overflow: hidden;"></div>
                    </div>
                    <div class="overviewContent">
                        <div class="ui_columns is-multiline is-mobile reviewsAndDetails" style="direction: ltr;">
                            <div class="ui_column is-8 details">
                                <div id="tourMoreOptionsMainDiv" class="full-width inline-block">
                                    <div class="block_header" style="border: none; padding: 0 0 7px 0; margin: 0 ">
                                        <h4 class="block_title" style="padding-bottom: 10px; font-size: 18px">امکانات اضافه</h4>
                                    </div>
                                    <table class="tourMoreOptionsDetails full-width ">
                                        <tr>
                                            <th></th>
                                            <th>نام مکان</th>
                                            <th>توضیحات</th>
                                            <th>افزایش قیمت</th>
                                        </tr>
                                    </table>

                                </div>
                                <div id="tourPriceMainDiv" class="full-width inline-block">
                                    <div id="fastReserveDiv" class="col-xs-7">
                                        <div class="inline-block col-xs-2">
                                            <button id="fastReserveTour4" class="fastReserveTour">رزرو آنی</button>
                                            <button id="reserveByPhoneBtn" class="fastReserveTour">تلفنی</button>
                                        </div>
                                        <div class="inline-block col-xs-10">
                                            بلیط شما به صورت آنلاین صادر می گردد.<br>
                                            برای شما کد پیگیری صادر شده و پس از تأیید برگزارکننده پرداخت و صدور بلیط انجام میگردد.
                                        </div>
                                    </div>
                                    <div id="businessApproachDiv" class="col-xs-5">
                                        <span class="full-width inline-block">
                                            اگر شرکت هستید از راهکارهای تجاری ما استفاده کنید.
                                        </span>
                                        <b class="full-width inline-block">
                                            راهکار تجاری
                                        </b>
                                    </div>
                                </div>
                            </div>
                            <div class="ui_column  is-4" style="border-left: 2px solid #e5e5e5;">
                                <div class="tourExpDetails">

                                    <div class="tourDetailsTitles col-xs-6">
                                        <span>درجه سختی</span>
                                        <span>
                                            <span></span>
                                            ساده
                                        </span>
                                    </div>
                                    <div class="tourDetailsTitles col-xs-6">
                                        <span>نوع تور</span>
                                        <span>
                                            <span></span>
                                            شهرگردی
                                        </span>
                                    </div>
                                    <div class="tourDetailsTitles col-xs-12">
                                        <span>علایق تور</span>
                                        <span class="tourStyleOneRow"></span>
                                    </div>
                                    <div class="tourDetailsTitles col-xs-12">
                                        <span>تیپ تور</span>
                                        <span class="tourKindOneRow"></span>
                                    </div>
                                    <div class="tourDetailsTitles col-xs-6">
                                        <span>نوع تور</span>
                                        <span class="tourIsPrivate"></span>
                                    </div>
                                    <div class="tourDetailsTitles col-xs-6">
                                        <span>رفت و آمد محلی</span>
                                        <span class="tourSideTransportOneRow"></span>
                                    </div>
                                    <div class="tourDetailsTitles col-xs-6">
                                        <span>پذیرایی</span>
                                        <span>صبحانه - نهار</span>
                                    </div>
                                    <div class="tourDetailsTitles col-xs-6">
                                        <span>زبان تور</span>
                                        <span class="tourLanguageOneRow"></span>
                                    </div>
                                    <div class="tourDetailsTitles col-xs-6">
                                        <span>نوع بیمه</span>
                                        <span class="tourInsurance"></span>
                                    </div>
                                </div>
                                <div class="prw_rup prw_common_atf_header_bl tourAgencyDetailsMainDiv">
                                    <div class="tourAgencyExp inline-block full-width">
                                        <div class="tourAgencyLogo circleBase type2"></div>
                                        <div class="tourAgencyName">
                                            <div class="full-width">آژانس ستاره طلایی</div>
                                            {{--<div class="full-width">ستاره</div>--}}
                                            <div class="prw_rup prw_common_bubble_rating overallBubbleRating full-width" style="float: right;">
                                                        <span class="ui_bubble_rating bubble_50" style="font-size:16px;"
                                                              property="ratingValue" content="5" alt='5 of 5 bubbles'></span>
                                            </div>
                                            <div>
                                                <div>0 نقد</div>
                                                <div>امتیاز</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="blEntry address" style="white-space: normal;">
                                        <span class="ui_icon map-pin"></span>
                                        <span class="street-address"> </span>
                                        <span style="font-size: 12px;">
                                                    {{--{{$place->address}}--}}
                                                </span>
                                    </div>
                                    {{--@if(!empty($place->phone))--}}
                                    <div class="blEntry phone">
                                        <span class="ui_icon phone" ></span>
                                        <span style="font-size: 12px;">
                                                        {{--{{$place->phone}}--}}
                                                    </span>
                                    </div>
                                    {{--@endif--}}
                                    {{--@if(!empty($place->site))--}}
                                    <div class="blEntry website">
                                        <span class="ui_icon laptop"></span>
                                        <?php
                                        //if (strpos($place->site, 'http') === false)
                                        //  $place->site = 'http://' . $place->site;
                                        ?>
                                        <a target="_blank">
                                            {{--href="{{$place->site}}" {{($config->externalSiteNoFollow) ? 'rel="nofollow"' : ''}}>--}}
                                            <span style="font-size: 12px;">
                                                            {{--{{$place->site}}--}}
                                                        </span>
                                        </a>
                                    </div>
                                    {{--@endif--}}
                                </div>
                                <center class="prw_rup prw_common_atf_header_bl tourAgencyContactDetailsMainDiv">
                                    <b class="tourAgencyPhoneNum inline-block">+982188536124</b>
                                    <div id="tourAgencyContactLogo" class="circleBase type2"></div>
                                    <div class="phoneNumSub inline-block">شماره تماس پشتیبانی تور</div>
                                    <div id="tourAgencyIdCode">
                                        <span>شناسایی تور:</span>
                                        <span>100-001-1200-01</span>
                                    </div>
                                </center>
                                <div class="prw_rup prw_common_atf_header_bl tourGuiderDetailsMainDiv">
                                    <b class="tourGuiderDivTitle inline-block ">تور گردان شما</b>
                                    <div class="tourGuiderExp inline-block full-width">
                                        <div id="tourGuiderPic" class="circleBase type2"></div>
                                        <div id="tourGuiderName">
                                            <div class="full-width">محسن خلیل زاده</div>
                                            {{--<div class="full-width">ستاره</div>--}}
                                            <div class="prw_rup prw_common_bubble_rating overallBubbleRating full-width" style="float: right;">
                                                        <span class="ui_bubble_rating bubble_50" style="font-size:16px;"
                                                              property="ratingValue" content="5" alt='5 of 5 bubbles'></span>
                                            </div>
                                            <div>
                                                <div>0 نقد</div>
                                                <div>امتیاز</div>
                                            </div>
                                        </div>
                                    </div>
                                    {{--@if(!empty($place->phone))--}}
                                    <div class="blEntry phone">
                                        <span class="ui_icon phone" ></span>
                                        <span style="font-size: 12px;">
                                                        {{--{{$place->phone}}--}}
                                                    </span>
                                    </div>
                                    {{--@endif--}}
                                    {{--@if(!empty($place->site))--}}
                                    <div class="blEntry website">
                                        <span class="ui_icon laptop"></span>
                                        <?php
                                        //if (strpos($place->site, 'http') === false)
                                        //  $place->site = 'http://' . $place->site;
                                        ?>
                                        <a target="_blank">
                                            {{--href="{{$place->site}}" {{($config->externalSiteNoFollow) ? 'rel="nofollow"' : ''}}>--}}
                                            <span style="font-size: 12px;">
                                                            {{--{{$place->site}}--}}
                                                        </span>
                                        </a>
                                    </div>
                                    <button class="tourGuiderPageAccess">مشاهده صفحه</button>
                                    <button class="tourGuiderSendMsg">ارسال پیام</button>
                                    {{--@endif--}}
                                </div>
                                <div class="prw_rup prw_common_atf_header_bl tourPlacesDetailsMainDiv">
                                    <b class="tourPlacesDivTitle inline-block ">شهرهایی که می‌بینید</b>
                                    <center class="tourPlacesDivs col-xs-6 inline-block">
                                        <center class="inline-block full-width">
                                            <div class="tourPlacesPic circleBase type2"></div>
                                        </center>
                                        <div class="tourPlacesName">
                                            <b class="full-width">قنات دو طبقه مون</b>
                                            {{--<div class="full-width">ستاره</div>--}}
                                            <div class="prw_rup prw_common_bubble_rating overallBubbleRating full-width" style="float: right;">
                                                        <span class="ui_bubble_rating bubble_50" style="font-size:16px;"
                                                              property="ratingValue" content="5" alt='5 of 5 bubbles'></span>
                                                <span>2 نقد</span>
                                            </div>
                                            <div class="inline-block">
                                                استان: اصفهان
                                            </div>
                                        </div>
                                    </center>
                                    <center class="tourPlacesDivs col-xs-6 inline-block">
                                        <center class="inline-block full-width">
                                            <div class="tourPlacesPic circleBase type2"></div>
                                        </center>
                                        <div class="tourPlacesName">
                                            <b class="full-width">قنات دو طبقه مون</b>
                                            {{--<div class="full-width">ستاره</div>--}}
                                            <div class="prw_rup prw_common_bubble_rating overallBubbleRating full-width" style="float: right;">
                                                        <span class="ui_bubble_rating bubble_50" style="font-size:16px;"
                                                              property="ratingValue" content="5" alt='5 of 5 bubbles'></span>
                                                <span>2 نقد</span>
                                            </div>
                                            <div class="inline-block">
                                                استان: اصفهان
                                            </div>
                                        </div>
                                    </center>
                                    <div class="moreInfoTourDetails">بیشتر</div>
                                </div>
                                <hr class="inline-block tourDetailsBoxDivider">
                                <div class="prw_rup prw_common_atf_header_bl tourPlacesDetailsMainDiv">
                                    <b class="tourPlacesDivTitle inline-block ">جاذبه‌هایی که می‌بینید</b>
                                    <center class="tourPlacesDivs col-xs-6 inline-block">
                                        <center class="inline-block full-width">
                                            <div class="tourPlacesPic circleBase type2"></div>
                                        </center>
                                        <div class="tourPlacesName">
                                            <b class="full-width">قنات دو طبقه مون</b>
                                            {{--<div class="full-width">ستاره</div>--}}
                                            <div class="prw_rup prw_common_bubble_rating overallBubbleRating full-width" style="float: right;">
                                                        <span class="ui_bubble_rating bubble_50" style="font-size:16px;"
                                                              property="ratingValue" content="5" alt='5 of 5 bubbles'></span>
                                                <span>2 نقد</span>
                                            </div>
                                            <div class="inline-block">
                                                استان: اصفهان
                                            </div>
                                        </div>
                                    </center>
                                    <center class="tourPlacesDivs col-xs-6 inline-block">
                                        <center class="inline-block full-width">
                                            <div class="tourPlacesPic circleBase type2"></div>
                                        </center>
                                        <div class="tourPlacesName">
                                            <b class="full-width">قنات دو طبقه مون</b>
                                            {{--<div class="full-width">ستاره</div>--}}
                                            <div class="prw_rup prw_common_bubble_rating overallBubbleRating full-width" style="float: right;">
                                                        <span class="ui_bubble_rating bubble_50" style="font-size:16px;"
                                                              property="ratingValue" content="5" alt='5 of 5 bubbles'></span>
                                                <span>2 نقد</span>
                                            </div>
                                            <div class="inline-block">
                                                استان: اصفهان
                                            </div>
                                        </div>
                                    </center>
                                    <div class="moreInfoTourDetails">بیشتر</div>
                                </div>
                            </div>
                            <div class="ui_column  is-12 tourDailySchedule" style="">
                                <div class="block_header tourBlockHeaders" style="border: none; padding: 0 0 7px 0; margin: 0 ">
                                    <h3 class="block_title inline-block full-width" style="padding-bottom: 5px; font-size: 18px">برنامه روزانه تور </h3>
                                    <span>برنامه روزانه تور طبق اعلام برگزارکننده ارائه گردیده است. توجه داشته باشید که ممکن است زمان‌ها و ترتیب رویدادها دستخوش تغییر شود.</span>
                                </div>
                                <div class="fastReserveTour" id="tourStartDateDiv">
                                    روز اول
                                    <span id="tourStartDate">1397/02/23</span>
                                </div>
                                <div class="tourDailyScheduleGuideMainDiv" style="position: relative">
                                    <div class="tourDailyScheduleGuideBoxes">
                                        <div class="text">اقامت</div>
                                        <div class="tourScheduleGuideColor circleBase type2" style="background: red"></div>
                                    </div>
                                    <div class="tourDailyScheduleGuideBoxes">
                                        <div class="text">رویداد</div>
                                        <div class="tourScheduleGuideColor circleBase type2" style="background: var(--koochita-light-green)"></div>
                                    </div>
                                    <div class="tourDailyScheduleGuideBoxes">
                                        <div class="text">غذا</div>
                                        <div class="tourScheduleGuideColor circleBase type2" style="background: var(--koochita-dark-green)"></div>
                                    </div>
                                    <div class="tourDailyScheduleGuideBoxes">
                                        <div class="text">جاذبه</div>
                                        <div class="tourScheduleGuideColor circleBase type2" style="background: var(--koochita-red)"></div>
                                    </div>
                                    <div class="tourDailyScheduleGuideBoxes">
                                        <div class="text">شهر</div>
                                        <div class="tourScheduleGuideColor circleBase type2" style="background: var(--koochita-blue)"></div>
                                    </div>
                                    <div class="tourDailyScheduleGuideBoxes">
                                        <div class="text">رفت و آمد</div>
                                        <div class="tourScheduleGuideColor circleBase type2" style="background: var(--koochita-green)"></div>
                                    </div>
                                </div>

                                <div class="dayScheduleSec">
                                    <div style="display: flex">
                                        <div class="circleSection top">
                                            <div class="circle firstCircle" style="background: red"></div>
                                            <div class="circle middleCircle" style="background: gray"></div>
                                        </div>
                                        <div class="circleSection bottom">
                                            <div class="circle firstCircle" style="background: blue"></div>
                                            <div class="circle middleCircle" style="background: yellow"></div>
                                        </div>
                                        <div class="circleSection top">
                                            <div class="circle firstCircle" style="background: peru"></div>
                                            <div class="circle middleCircle" style="background: red"></div>
                                        </div>
                                        <div class="circleSection bottom">
                                            <div class="circle firstCircle"></div>
                                            <div class="circle middleCircle"></div>
                                        </div>
                                        <div class="circleSection top">
                                            <div class="circle firstCircle"></div>
                                            <div class="circle middleCircle"></div>
                                        </div>
                                        <div class="circleSection bottom">
                                            <div class="circle firstCircle"></div>
                                            <div class="circle middleCircle"></div>
                                        </div>
                                        <div class="circleSection top">
                                            <div class="circle firstCircle"></div>
                                            <div class="circle middleCircle"></div>
                                        </div>
                                        <div class="circleSection bottom">
                                            <div class="circle firstCircle"></div>
                                            <div class="circle middleCircle"></div>
                                        </div>
                                        <div class="circleSection top">
                                            <div class="circle firstCircle"></div>
                                            <div class="circle middleCircle"></div>
                                        </div>
                                        <div class="circleSection bottom">
                                            <div class="circle firstCircle"></div>
                                            <div class="circle middleCircle"></div>
                                        </div>
                                        <div class="circleSection top">
                                            <div class="circle firstCircle"></div>
                                            <div class="circle middleCircle"></div>
                                        </div>
                                        <div class="circleSection bottom">
                                            <div class="circle firstCircle"></div>
                                            <div class="circle middleCircle"></div>
                                            <div class="circle lastCircle"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="mapModal" class="modalBlackBack fullCenter">
        <div class="modalBody">

        </div>
    </div>

    <style>
        .buyModal .header{
            font-size: 24px;
            border-bottom: solid 1px lightgray;
            margin-bottom: 10px;
            padding-bottom: 10px;
            font-weight: bold;
        }
    </style>


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
                <div id="tourPriceOptions" class="col-xs-7">
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

                <div id="tourPricePerMan" class="col-xs-5">
                    <div class="full-width inline-block">
                        <b>تعداد مسافرین را انتخاب کنید.</b>
                        <div>
                            <div class="roomBox">
                                <div class="shTIcon passengerIcon passengerInput">
                                    <div class="text" onclick="openSelectPassengerCount()">
                                        <span>
                                            <span class="adultCount">0</span>
                                            بزرگسال
                                        </span>
                                        -
                                        <span>
                                            <span class="childCount">0</span>
                                            بچه
                                        </span>
                                    </div>
                                    <div class="additionalBackDark hidden" onclick="closePassengerCount()"></div>
                                    <div class="popup hidden">
                                        <div>
                                            <label for="adultPassenger">تعداد نفرات بزرگسال (بالای 8 سال)</label>
                                            <input type="number" id="adultPassenger" min="0" class="form-control" onchange="changePassengerCount(this, 'adult')">
                                        </div>
                                        <div>
                                            <label for="childPassenger">تعداد نفرات کودک (زیر 8 سال)</label>
                                            <input type="number" id="childPassenger" min="0" class="form-control" onchange="changePassengerCount(this, 'child')">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="full-width inline-block">
                        <span>بزرگسال</span>
                        <span>
                            <span class="mainCost" style="margin-right: 10px"></span>
                            X
                            <span class="adultCount" style="margin-left: 10px;">0</span>
                        </span>
                    </div>
                    <div class="full-width inline-block">
                        <span>کودک
                            <span class="smallRed-10 hidden"> <span class="discountForChild"></span> درصد تخفیف ویژه کودکان </span>
                        </span>
                        <span>
                            <span class="childCost" style="margin-right: 10px"></span>
                            X
                            <span class="childCount" style="margin-left: 10px;">0</span>
                        </span>
                    </div>
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

    <script>
        var tourTimes = [];
        var tourCode = '{{$tour->code}}';
        var tourTimeCode = '{{$tour->timeCode}}';
        var tourInformationUrl = '{{route("tour.getInformation")}}?code='+tourCode;
        var dayEvents = [];

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

        function openDayDetails(_day){
            $('#dayEventIdicator').html(dayEvents[(_day-1)].indicatorHtml);
            $('#detailInfSec').html(dayEvents[(_day-1)].detailHtml);
            $('#fullDayDetailSection').addClass('showMinDetail');
            $('#showBigDays').addClass('hidden');
        }

        function selectDay(_element){

            $('html, body').animate({
                scrollTop: $('#dayInfoSection').offset().top
            }, 500);
            $('#fullDayDetailSection').removeClass('showMinDetail');
            $('#showBigDays').removeClass('hidden');

            var day = $(_element).attr('data-day');

            $(_element).parent().find('.selected').removeClass('selected');
            $(_element).addClass('selected');

            $('#showBigDays').find('.selected').removeClass('selected');
            $('#mainDayShow_'+day).addClass('selected');


            $('#showBigDays').animate({
                scrollTop: $('#showBigDays').scrollTop() + $('#mainDayShow_' + day).position().top
            }, 1000);
            $('#showBigDays').scrollTop();
        }

        function chooseOtherDates(_element, _index){
            $(_element).parent().find('.selectdd').removeClass('selectdd');
            $(_element).addClass('selectdd');

            $('.sDateName').text(tourTimes[_index].sDateName);
            $('.eDateName').text(tourTimes[_index].eDateName);

            tourTimeCode = tourTimes[_index].code;
        }

        function selectBuyButton(){
            openMyModal('buyModal');
        }

        function openSelectPassengerCount(){
            $('#tourPricePerMan').find('.additionalBackDark').removeClass('hidden');
            $('#tourPricePerMan').find('.popup').removeClass('hidden');
        }
        function closePassengerCount(){
            $('#tourPricePerMan').find('.additionalBackDark').addClass('hidden');
            $('#tourPricePerMan').find('.popup').addClass('hidden');
        }


        function reserveTour(){
            openLoading();

            var featureCount = [];
            var elements = $('.featuresInputCount');
            for(var i = 0; i < elements.length; i++){
                index = $(elements[i]).attr('data-index');
                count = $(elements[i]).val();
                featureCount.push({
                    id: features[index].id,
                    count: count
                });
            }


            $.ajax({
                type: 'POST',
                url: '{{route("tour.reservation.firstReserve")}}',
                data: {
                    _token: '{{csrf_token()}}',
                    tourCode: tourCode,
                    tourTimeCode: tourTimeCode,
                    adultCount: buyAdultCount,
                    childCount: buyChildCount,
                    featureCount: featureCount
                },
                complete: closeLoading,
                success: response => {

                },
                error: err =>{

                }
            });
        }

    </script>

    <script defer src="{{URL::asset('js/pages/tourShow.js')}}"></script>

@stop
