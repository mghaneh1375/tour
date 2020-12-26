<?php $placeMode = "ticket";
$state = "تهران";
$kindPlaceId = 10; ?>
        <!DOCTYPE html>
<html>
<head>
    @include('layouts.topHeader')
    @include('layouts.phonePopUp')
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/theme2/home_rebranded.css?v=4')}}"/>
    <title>گام چهارم ایجاد تور</title>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/theme2/long_lived_global_legacy_2.css?v=2')}}"/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/masthead-saves.css?v=2')}}'/>
    <link rel='stylesheet' type='text/css' media='screen, print'
          href='{{URL::asset('css/theme2/hr_north_star.css?v=2')}}'/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/icons.css?v=1')}}'/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/passStyle.css?v=1')}}'/>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/shazdeDesigns/tourCreation.css?v=1')}}"/>

    <script src="{{URL::asset('js/jalali.js')}}"></script>

</head>

<body id="BODY_BLOCK_JQUERY_REFLOW"
      class=" r_map_position_ul_fake ltr domn_en_US lang_en long_prices globalNav2011_reset rebrand_2017 css_commerce_buttons flat_buttons sitewide xo_pin_user_review_to_top track_back">

<div id="PAGE" class="filterSearch redesign_2015 non_hotels_like desktop scopedSearch">
    @include('layouts.placeHeader')
    <div class="ppr_rup ppr_priv_hr_atf_north_star_nostalgic">

        <div class="atf_header_wrapper">
            <div class="atf_header ui_container is-mobile full_width">

                <div class="ppr_rup ppr_priv_location_detail_header relative-position">
                    <h1 id="HEADING" property="name">
                        <b class="tourCreationMainTitle">شما در حال ایجاد یک تور جدید هستید</b>
                    </h1>
                    <div class="tourAgencyLogo circleBase type2"></div>
                    <b class="tourAgencyName">آژانس ستاره طلایی</b>
                </div>
            </div>
        </div>

        <div class="atf_meta_and_photos_wrapper">
            <div class="atf_meta_and_photos ui_container is-mobile easyClear">
                <div class="prw_rup darkGreyBox tourDetailsMainFormHeading">
                    <b class="formName">اطلاعات مالی</b>
                    <div class="tourCreationStepInfo">
                        <span>
                            گام
                            <span>3</span>
                            از
                            <span>6</span>
                        </span>
                        <span>
                            آخرین ویرایش
                            <span>
                                {{$tour->lastUpdate}}
                            </span>
                            <span>
                                {{$tour->lastUpdateTime}}
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="tourDetailsMainForm3rdtStepMainDiv" class="Hotel_Review prodp13n_jfy_overflow_visible lightGreyBox">
        <form id="form" method="post" action="{{route('tour.create.stage.three.store')}}">

            {!! csrf_field() !!}
            <input type="hidden" name="tourId" value="{{$tour->id}}">
            <input type="hidden" name="hotelList" id="hotelList">
            <input type="hidden" name="roomCosts" id="roomCosts">
            <input type="hidden" name="roomKinds" id="roomKinds">
            <input type="hidden" name="roomPacks" id="roomPacks">

            <div class="ui_container">
                <div class="menu ui_container whiteBox">
                    <div class="boxTitlesTourCreation">
                        قیمت پایه
                    </div>
                    <div class="inboxHelpSubtitle">
                        قیمت پایه‌ی تور قیمتی است که فارغ از هرگونه امکانات اضافه بدست آمده است و کمترین قیمتی است که کاربران می‌توانند تور را با آن خریداری نمایند. اگر برخی امکانات و یا کیفیت اقامتگاه تور، قیمت تور را تغییر می‌دهد، آن‌ها را در قسمت‌های بعدی وارد نمایید.
                    </div>
                    <div class="tourBasicPriceTourCreation col-xs-6">
                        <div class="inputBox col-xs-10" id="minCostDiv">
                            <div class="inputBoxText">
                                <div>
                                    قیمت پایه
                                    <span>*</span>
                                </div>
                            </div>
                            <input class="inputBoxInput" id="minCost" name="minCost" type="number" placeholder="ریال">
                        </div>
                        <div id="tourInsuranceConfirmation" class="col-xs-10 pd-0">
                            <span>آیا تور شما دارای بیمه می‌باشد؟</span>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-secondary">
                                    <input type="radio" name="isInsurance" id="isInsurance" value="0">خیر
                                </label>
                                <label class="btn btn-secondary active">
                                    <input type="radio" name="isInsurance" id="isInsurance" value="1" checked>بلی
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="tourTicketKindTourCreation col-xs-6">
                        <div class="inputBox col-xs-10" id="">
                            <div class="inputBoxText">
                                <div>
                                    نوع بلیط
                                    <span>*</span>
                                </div>
                            </div>
                            <div class="select-side">
                                <i class="glyphicon glyphicon-triangle-bottom"></i>
                            </div>
                            <select class="inputBoxInput styled-select" id="ticketKind" name="ticketKind">
                                <option value="fast">
                                    بلیط با امکان رزرو سریع
                                </option>
                                <option value="call">
                                    بلیط نیازمند تماس با ارایه دهنده
                                </option>
                            </select>
                        </div>
                        <div class="col-xs-10 pd-0">
                            <span class="inboxHelpSubtitleBlue">نیاز به راهنمایی دارید؟</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ui_container">
                <div class="menu ui_container whiteBox">
                    <div class="boxTitlesTourCreation">
                        اقامتگاه‌ها
                    </div>
                    <div class="inboxHelpSubtitle">
                        نحوه‌ی اسکان مسافران را در طول تور تعیین نمایید. اگر چند نوع اقامتگاه مدنظر دارید، همگی را وارد نموده و میزان تغییرات قیمت را با توجه به انتخاب آن‌ها ذکر کنید.
                    </div>

                    <div>
                        <span>آیا تور شما امکانات اسکان دارد؟</span>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary">
                                <input type="radio" name="isHotel" id="isHotel" value="0" onchange="isHotelFunc(this.value)">خیر
                            </label>
                            <label class="btn btn-secondary active">
                                <input type="radio" name="isHotel" id="isHotel" value="1" onchange="isHotelFunc(this.value)" checked>بلی
                            </label>

                        </div>
                    </div>

                    <div id="isHotelDiv">
                        <div id="hotelMainList"></div>

                        <center class="addTourPlacesBtnDivTourCreation pd-0 col-xs-4"   data-toggle="modal" data-target="#addHotelModal" onclick="cleanHotelSearch()">
                            <div class="addTourPlacesBtnCreation circleBase type2">
                                <img src="{{URL::asset("images/tourCreation/add.png")}}">
                                <div>اضافه کنید</div>
                            </div>
                        </center>
                    </div>

                </div>
            </div>
            <div class="ui_container">
                <div class="menu ui_container whiteBox">
                    <div class="boxTitlesTourCreation">
                        <span>امکانات اضافه</span>
                    </div>
                    <div class="inboxHelpSubtitle">
                        سایر امکاناتی که شما در تور با دریافت هزینه‌ی اضافه ارئه می‌دهید را وارد نمایید.
                    </div>
                    <div id="featuresDiv">

                        <div class="row featuresRow" id="features_0">
                            <div class="inputBox float-right col-xs-2" id="">
                                <input id="featureName_0" name="featureName[]" class="inputBoxInput moreFacilityInputs" type="text" placeholder="نام">
                            </div>
                            <div class="inputBox float-right col-xs-3 mg-rt-10" id="">
                                <input id="featureDesc_0" name="featureDesc[]" class="inputBoxInput moreFacilityInputs" type="text" placeholder="توضیحات" maxlength="250">
                            </div>
                            <div class="inputBox float-right col-xs-2 mg-rt-10" id="">
                                <div class="select-side">
                                    <i class="glyphicon glyphicon-triangle-bottom"></i>
                                </div>
                                <select id="featureGroup_0" name="featureGroup[]"  class="inputBoxInput moreFacilityInputs styled-select">
                                    <option value="0">هم‌گروهی</option>
                                    <option value="a">a</option>
                                    <option value="b">b</option>
                                    <option value="c">c</option>
                                    <option value="d">d</option>
                                    <option value="e">e</option>
                                    <option value="f">f</option>
                                    <option value="g">g</option>
                                    <option value="h">h</option>
                                    <option value="i">i</option>
                                    <option value="j">j</option>
                                </select>
                            </div>
                            <div class="inputBox float-right col-xs-3 mg-rt-10 relative-position" id="">
                                <input id="featureCost_0" name="featureCost[]" class="inputBoxInput moreFacilityInputs" type="number" placeholder="ریال">
                                <div class="inboxHelpSubtitle" id="subtitleMoreFacility">
                                    میزان افزایش قیمت را وارد نمایید.
                                </div>
                            </div>
                            <div class="col-xs-2" style="text-align: left; position: relative">
                                <button class="tourMoreFacilityDetailsBtn deleteBtnTourCreation" style="position: relative; bottom: 0px; left: 0px; top: 0px" onclick="deleteFeature(0)">
                                    <img src="{{URL::asset("images/tourCreation/delete.png")}}">
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="button"  class="tourMoreFacilityDetailsBtn verifyBtnTourCreation" onclick="newFeature()">
                        <img src="{{URL::asset("images/tourCreation/approve.png")}}">
                    </button>

                    <div class="inboxHelpSubtitle">
                        امکاناتی را که امکان انتخاب همزمان آن‌ها موجود نمی‌باشد، در هم‌گروهی‌های یکسان قرار دهید.
                    </div>
                </div>
            </div>

            @if($tour->private)
                <div class="ui_container">
                    <div class="menu ui_container whiteBox tourCapacityNGOTours">
                        <div class="boxTitlesTourCreation">
                            <span>ظرفیت</span>
                        </div>
                        <div class="inputBox col-xs-3 float-right">
                            <div class="inputBoxText">
                                <div>
                                    نوع تور
                                    <span>*</span>
                                </div>
                            </div>
                            <input class="inputBoxInput" type="text" value="خصوصی">
                        </div>
                        <div class="col-xs-4 float-right">
                            <div id="maxCapacityDiv" class="inputBox col-xs-12">
                                <div class="inputBoxText">
                                    <div>
                                        حداکثر تعداد افراد
                                        <span>*</span>
                                    </div>
                                </div>
                                <input class="inputBoxInput" id="maxCapacity" name="maxCapacity" type="number" placeholder="تعداد">
                            </div>
                            <div id="minCapacityDiv" class="inputBox col-xs-12">
                                <div class="inputBoxText">
                                    <div>
                                        حداقل تعداد افراد
                                        <span>*</span>
                                    </div>
                                </div>
                                <input class="inputBoxInput" id="minCapacity" name="minCapacity" type="number" placeholder="تعداد">
                            </div>
                        </div>
                        <div id="maxGroupCapacityDiv" class="inputBox col-xs-5 float-right">
                            <div class="inputBoxText">
                                <div>
                                    حداکثر تعداد گروه‌های همزمان
                                    <span>*</span>
                                </div>
                            </div>
                            <input class="inputBoxInput" type="number" id="maxGroupCapacity" name="maxGroupCapacity" placeholder="تعداد">
                        </div>
                    </div>
                </div>
            @else
                <div class="ui_container">
                    <div class="menu ui_container whiteBox">
                        <div class="boxTitlesTourCreation">
                            <span>ظرفیت</span>
                        </div>
                        <div class="inputBox col-xs-3 float-right">
                            <div class="inputBoxText">
                                <div>
                                    نوع تور
                                    <span>*</span>
                                </div>
                            </div>
                            <input class="inputBoxInput" type="text" value="گروهی" readonly>
                        </div>

                        <div class="col-xs-4 float-right">
                            <div  id="minCapacityDiv" class="inputBox col-xs-12">
                                <div class="inputBoxText">
                                    <div>
                                        حداقل ظرفیت
                                        <span>*</span>
                                    </div>
                                </div>
                                <input class="inputBoxInput" type="number" name="minCapacity" id="minCapacity" placeholder="تعداد">
                            </div>
                        </div>
                        <div class="col-xs-4 float-right">
                            <div id="maxCapacityDiv" class="inputBox col-xs-12">
                                <div class="inputBoxText">
                                    <div>
                                        حداکثر ظرفیت
                                        <span>*</span>
                                    </div>
                                </div>
                                <input class="inputBoxInput" type="number" name="maxCapacity" id="maxCapacity" placeholder="تعداد">
                            </div>
                        </div>

                        <div class="fullwidthDiv">
                            <input type="checkbox" name="anyCapacity" id="anyCapacity" value="1"/>
                            <label for="anyCapacity">
                                <span></span>
                            </label>
                            <span id="tourCapacityCheckbox">
                            با هر ظرفیتی تور برگزار می شود.
                        </span>
                        </div>
                    </div>
                </div>
            @endif
            <div class="ui_container">
                <div class="menu ui_container whiteBox">
                    <div class="boxTitlesTourCreation">
                        <span>تخفیف خرید گروهی</span>
                    </div>
                    <div class="inboxHelpSubtitle">
                        تخفیف‌های گروهی به خریداران ظرفیت‌های بالا اعمال می‌شود. شما می‌توانید با تعیین بازه‌های متفاوت تخفیف‌های متفاوتی اعمال نمایید.
                    </div>
                    <div id="groupDiscountDiv">

                        <div id="groupDiscount_0" class="col-xs-12 pd-0">
                            <div class="inputBox discountLimitationWholesale float-right">
                                <div class="inputBoxText">
                                    <div>
                                        بازه‌ی تخفیف
                                        <span>*</span>
                                    </div>
                                </div>
                                <input class="inputBoxInput" name="disCountFrom[]" id="disCountFrom_0" type="number" placeholder="از" onkeyup="checkDiscount(0, this.value, 0)" onchange="checkAllDiscount()">
                                <div class="inputBoxText">
                                    <div>
                                        الی
                                    </div>
                                </div>
                                <input class="inputBoxInput" name="disCountTo[]" id="disCountTo_0" type="number" placeholder="تا"  onkeyup="checkDiscount(0, this.value, 1)" onchange="checkAllDiscount()">
                                <div class="inputBoxText">
                                    <div>
                                        درصد تخفیف
                                        <span>*</span>
                                    </div>
                                </div>
                                <input class="inputBoxInput no-border-imp" name="disCountCap[]" id="disCountCap_0" type="text" placeholder="عدد">
                            </div>
                            <div class="inline-block mg-tp-12 mg-rt-10">
                                <button type="button" id="submitDisCount_0" class="wholesaleDiscountLimitationBtn verifyBtnTourCreation" onclick="addNewDisCount(0)">
                                    <img src="{{URL::asset("images/tourCreation/approve.png")}}">
                                </button>
                                <button id="deleteDisCount_0" type="button" class="wholesaleDiscountLimitationBtn deleteBtnTourCreation" onclick="deleteDisCount(0)"  style="display: none;">
                                    <img src="{{URL::asset("images/tourCreation/delete.png")}}">
                                </button>
                            </div>
                        </div>

                    </div>
                    <div class="fullwidthDiv specialDiscountBoxes">
                        <div class="boxTitlesTourCreation">
                            <span>تخفیف ویژه‌ی کودکان</span>
                        </div>
                        <div class="inboxHelpSubtitle">
                            تخفیف ویژه برای کودکان و نوجوانان (زیر 12 سال) از این قسمت تعریف می‌گردد.
                        </div>
                        <div class="inputBox col-xs-3 float-right">
                            <div class="inputBoxText">
                                <div>
                                    درصد تخفیف
                                    <span>*</span>
                                </div>
                            </div>
                            <input class="inputBoxInput" id="babyDisCount" name="babyDisCount" type="text" placeholder="تعداد">
                        </div>
                    </div>
                    <div class="fullwidthDiv specialDiscountBoxes" style="position: relative">
                        <div class="boxTitlesTourCreation">
                            <span>تخفیف‌های مناسبتی و کد تخفیف</span>
                        </div>
                        <div class="inboxHelpSubtitle">
                            در صورت تعریف سیستم تخفیف زیر ، ما از زمان اعلامی شما به صورت خودکار تخفیف خرید در روزهای پایانی را اعمال می‌نماییم.
                        </div>
                        <div class="inputBox col-xs-3 mg-rt-10 float-right">
                            <div class="inputBoxText">
                                <div>
                                    درصد تخفیف
                                    <span>*</span>
                                </div>
                            </div>
                            <input class="inputBoxInput" id="disCountReason" name="disCountReason" type="text" placeholder="تعداد">
                        </div>
                        <div class="inputBox col-xs-3 mg-rt-10 float-right">
                            <div class="inputBoxText">
                                <div>
                                    زمان پایان
                                    <span>*</span>
                                </div>
                            </div>
                            <input class="inputBoxInput" id="backDate" name="eDate" type="text" placeholder="تعداد" onclick="changeTwoCalendar(2); nowCalendar() ">
                        </div>
                        <div class="inputBox col-xs-3 mg-rt-10 float-right">
                            <div class="inputBoxText">
                                <div>
                                    زمان شروع
                                    <span>*</span>
                                </div>
                            </div>
                            <input class="inputBoxInput" id="goDate" name="sDate" type="text" placeholder="تعداد" onclick="changeTwoCalendar(2); nowCalendar()">
                        </div>

                        @include('layouts.calendar')

                    </div>

                    <div class="boxTitlesTourCreation">
                        <span>تخفیف‌های مناسبتی و کد تخفیف</span>
                    </div>
                    <div class="inboxHelpSubtitle">
                        در پنل کاربری قادر به تعریف تخفیف‌های مناسبتی خواهید بود. همچنین می‌توانید به تعداد مورد نیاز کد تخفیف با شرایط متفاوت ایجاد و به کاربران خاص خود هدیه دهید.
                    </div>
                </div>
            </div>
            <div class="ui_container">
                <button type="button" id="goToFifthStep" class="btn nextStepBtnTourCreation" onclick="checkInputs()">گام بعدی</button>
            </div>
        </form>
    </div>

    <div class="modal fade" id="addHotelModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-body" style="direction: rtl">
                    <div class="fullwidthDiv">
                        <div class="addPlaceGeneralInfoTitleTourCreation">
                            هتل مورد نظر خود را اضافه کنید
                        </div>
                        <button type="button" class="closee" data-dismiss="modal" style="border: none; background: none; float: left">&times;</button>
                    </div>

                    <div class="container-fluid">
                        <div class="row" style="display: flex; justify-content: space-between">
                            <div class="inputBox col-xs-5 relative-position" id="mainClassificationOfPlaceInputDiv" style="float: right">
                                <div class="inputBoxText">
                                    <div>
                                        استان
                                        <span>*</span>
                                    </div>
                                </div>
                                <div class="select-side">
                                    <i class="glyphicon glyphicon-triangle-bottom"></i>
                                </div>
                                <select class="inputBoxInput styled-select text-align-right" onchange="findCity(this.value, 'hotel')">
                                    <option id="hotelChooseOption">انتخاب کنید</option>
                                    @foreach($ostan as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="inputBox col-xs-5 relative-position" id="mainClassificationOfPlaceInputDiv" style="float: left">
                                <div class="inputBoxText">
                                    <div>
                                        شهر
                                        <span>*</span>
                                    </div>
                                </div>
                                <div class="select-side">
                                    <i class="glyphicon glyphicon-triangle-bottom"></i>
                                </div>
                                <select id="hotelCity" class="inputBoxInput styled-select text-align-right" onchange="findHotel(this.value)"></select>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid">
                        <div class="row">
                            <div class="inputBox col-xs-12 relative-position" id="placeNameAddingPlaceInputDiv">
                                <div class="inputBoxText">
                                    <div>
                                        نام هتل
                                        <span>*</span>
                                    </div>
                                </div>
                                <input id="inputSearchHotel" class="inputBoxInput text-align-right" type="text" placeholder="انتخاب کنید" onkeyup="showHotelList(this.value)">
                                <div class="searchResult">
                                    <ul id="hotelResult"></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="hotelChoose"></div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer" style="text-align: center">
                    <button id="goToForthStep" class="btn nextStepBtnTourCreation" data-dismiss="modal">تأیید</button>
                </div>

            </div>
        </div>
    </div>

    <div class="errorDiv" id="errorDiv"></div>

    @include('layouts.footer.layoutFooter')
</div>


<script src="{{URL::asset('js/tour/create/stageThree.js')}}"></script>

<script>
    var checkOpen = false;
    var error = false;

    var allState = {!! $ostan !!};

    var _token = '{{csrf_token()}}';
    var homeRoute = '{{route("home")}}';
    var findCityURL = '{{route("findCityWithState")}}';
    var findHotelURL = '{{route("search.hotel.with.city")}}';

    var copyPic = '{{URL::asset("images/tourCreation/copy.png")}}';
    var deletePic = '{{URL::asset("images/tourCreation/delete.png")}}';
    var approvePic = '{{URL::asset("images/tourCreation/approve.png")}}';
    var closePic  = '{{URL::asset("images/tourCreation/close.png")}}';

    var city;
    var hotelsList;
    var hotelInSearch = [];
    var chooseState;
    var hotelChoose = [];
    var hotelChooseList = [];
    var hotelCity;
    var roomKind = [];
    var roomCost = [];
    var roomPack = [];
    var featuersIndex = 1;

    var disCountIndex = 1;
    var disCountFrom = [0];
    var disCountTo = [0];
    var discountError = false;

    function findCity(_value, _dest){
        var section;

        for(i = 0; i < allState.length; i++){
            if(allState[i].id == _value){
                chooseState = allState[i];
                break;
            }
        }

        if(_dest == 'hotel') {
            document.getElementById('hotelChooseOption').style.display = 'none';
            section = 'hotelCity';
        }

        $.ajax({
            type: 'post',
            url: findCityURL,
            data: {
                '_token' : _token,
                'stateId': _value
            },
            success: function(response){
                city = JSON.parse(response);
                var text = '';
                for(i = 0; i < city.length; i++)
                    text += '<option value="' + city[i].id + '"> ' + city[i].name + ' </option>';

                document.getElementById(section).innerHTML = text;

            }
        })
    }

    @if($tour->private)
        $('#maxGroupCapacity').keyup(function(e){
            document.getElementById('maxGroupCapacityDiv').classList.remove('errorClass');
        });
    @endif

    function checkInputs(){

        error = false;
        var error_text = '';

        var minCost = document.getElementById('minCost').value;
        var maxCapacity = document.getElementById('maxCapacity').value;
        var minCapacity = document.getElementById('minCapacity').value;

        if(minCost == '' || minCost == null){
            error = true;
            error_text += '<li>لطفا قیمت پایه تور را مشخص کنید.</li>';
            document.getElementById('minCostDiv').classList.add('errorClass');
        }
        else
            document.getElementById('minCostDiv').classList.remove('errorClass');

        if(maxCapacity == '' || maxCapacity == null){
            error = true;
            error_text += '<li>لطفا حداکثر ظرفیت تور را مشخص کنید.</li>';
            document.getElementById('maxCapacityDiv').classList.add('errorClass');
        }
        else
            document.getElementById('maxCapacityDiv').classList.remove('errorClass');

        if(minCapacity == '' || minCapacity == null){
            error = true;
            error_text += '<li>لطفا حداقل ظرفیت تور را مشخص کنید.</li>';
            document.getElementById('minCapacityDiv').classList.add('errorClass');
        }
        else
            document.getElementById('minCapacityDiv').classList.remove('errorClass');

        if(discountError){
            error = true;
            error_text += '<li>لطفا تخفیف گروهی را با دقت مشخص کنید.</li>';
        }

        @if($tour->private)
            var maxGroupCapacity = document.getElementById('maxGroupCapacity').value;
            if(maxGroupCapacity == '' || maxGroupCapacity == null){
                error = true;
                error_text += '<li>لطفا حداقل ظرفیت تور را مشخص کنید.</li>';
                document.getElementById('maxGroupCapacityDiv').classList.add('errorClass');
            }
            else
                document.getElementById('maxGroupCapacityDiv').classList.remove('errorClass');
        @endif

        if(error){
            var text = '<div class="alert alert-danger alert-dismissible">\n' +
                '            <button type="button" class="close" data-dismiss="alert" style="float: left">&times;</button>\n' +
                '            <ul id="errorList">\n' + error_text +
                '            </ul>\n' +
                '        </div>';
            document.getElementById('errorDiv').style.display = 'block';
            document.getElementById('errorDiv').innerHTML = text;

            setTimeout(function(){
                document.getElementById('errorDiv').style.display = 'none';
            }, 5000);
        }
        else{
            document.getElementById('errorDiv').style.display = 'none';

            document.getElementById('roomKinds').value = JSON.stringify(roomKind);
            document.getElementById('roomCosts').value = JSON.stringify(roomCost);
            document.getElementById('roomPacks').value = JSON.stringify(roomPack);
            $('#form').submit();
        }
    }

</script>

</body>
</html>
