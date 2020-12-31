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

<body>

<div>
    @include('general.forAllPages')
    @include('layouts.placeHeader')

    @include('pages.tour.create.tourCreateHeader', ['createTourStep' => 3, 'createTourHeader' => 'اطلاعات مالی'])

    <div id="tourDetailsMainForm3rdtStepMainDiv" class="Hotel_Review prodp13n_jfy_overflow_visible lightGreyBox">
        <form id="form" method="post" action="{{route('tour.create.stage.three.store')}}">

            {!! csrf_field() !!}
            <input type="hidden" name="tourId" value="{{$tour->id}}">
            <input type="hidden" name="hotelList" id="hotelList">
            <input type="hidden" name="featureList" id="featureList">

            <div class="ui_container">
                <div class="menu ui_container whiteBox">
                    <div class="boxTitlesTourCreation">
                        قیمت پایه
                    </div>
                    <div class="inboxHelpSubtitle">
                        قیمت پایه‌ی تور قیمتی است که فارغ از هرگونه امکانات اضافه بدست آمده است و کمترین قیمتی است که کاربران می‌توانند تور را با آن خریداری نمایند. اگر برخی امکانات و یا کیفیت اقامتگاه تور، قیمت تور را تغییر می‌دهد، آن‌ها را در قسمت‌های بعدی وارد نمایید.
                    </div>
                    <div class="tourBasicPriceTourCreation col-xs-6">
                        <div class="inputBoxTour col-xs-10" id="minCostDiv">
                            <div class="inputBoxText">
                                <div>
                                    قیمت پایه
                                    <span>*</span>
                                </div>
                            </div>
                            <input class="inputBoxInput" id="minCost" name="minCost" type="text" placeholder="ریال" onkeyup="$(this).val(numberWithCommas(this.value))">
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
                        <div class="inputBoxTour col-xs-10" >
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

                        <div class="addTourPlacesBtnDivTourCreation pd-0 col-xs-4" onclick="cleanHotelSearch()">
                            <div class="addTourPlacesBtnCreation circleBase type2">
                                <img src="{{URL::asset("images/tourCreation/add.png")}}">
                                <div>اضافه کنید</div>
                            </div>
                        </div>
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
                    <div id="featuresDiv"></div>

                    <button type="button"  class="tourMoreFacilityDetailsBtn verifyBtnTourCreation" onclick="createFeatureRow()">
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
                        <div class="inputBoxTour col-xs-3 float-right">
                            <div class="inputBoxText">
                                <div>
                                    نوع تور
                                    <span>*</span>
                                </div>
                            </div>
                            <input class="inputBoxInput" type="text" value="خصوصی">
                        </div>
                        <div class="col-xs-4 float-right">
                            <div id="maxCapacityDiv" class="inputBoxTour col-xs-12">
                                <div class="inputBoxText">
                                    <div>
                                        حداکثر تعداد افراد
                                        <span>*</span>
                                    </div>
                                </div>
                                <input class="inputBoxInput" id="maxCapacity" name="maxCapacity" type="number" placeholder="تعداد">
                            </div>
                            <div id="minCapacityDiv" class="inputBoxTour col-xs-12">
                                <div class="inputBoxText">
                                    <div>
                                        حداقل تعداد افراد
                                        <span>*</span>
                                    </div>
                                </div>
                                <input class="inputBoxInput" id="minCapacity" name="minCapacity" type="number" placeholder="تعداد">
                            </div>
                        </div>
                        <div id="maxGroupCapacityDiv" class="inputBoxTour col-xs-5 float-right">
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
                        <div class="inputBoxTour col-xs-3 float-right">
                            <div class="inputBoxText">
                                <div>
                                    نوع تور
                                    <span>*</span>
                                </div>
                            </div>
                            <input class="inputBoxInput" type="text" value="گروهی" readonly>
                        </div>

                        <div class="col-xs-4 float-right">
                            <div  id="minCapacityDiv" class="inputBoxTour col-xs-12">
                                <div class="inputBoxText" style="width: 140px">
                                    <div>
                                        حداقل ظرفیت
                                        <span>*</span>
                                    </div>
                                </div>
                                <input class="inputBoxInput" type="number" name="minCapacity" id="minCapacity" placeholder="تعداد">
                            </div>
                        </div>
                        <div class="col-xs-4 float-right">
                            <div id="maxCapacityDiv" class="inputBoxTour col-xs-12">
                                <div class="inputBoxText" style="width: 140px">
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
                    <div id="groupDiscountDiv"></div>

                    <div class="fullwidthDiv specialDiscountBoxes">
                        <div class="boxTitlesTourCreation">
                            <span>تخفیف ویژه‌ی کودکان</span>
                        </div>
                        <div class="inboxHelpSubtitle">تخفیف ویژه برای کودکان و نوجوانان (زیر 12 سال) از این قسمت تعریف می‌گردد.</div>
                        <div class="inputBoxTour col-xs-3 float-right">
                            <div class="inputBoxText" style="width: 155px">
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
                        <div class="inputBoxTour col-xs-3 mg-rt-10 float-right">
                            <div class="inputBoxText" style="width: 140px">
                                <div>
                                    درصد تخفیف
                                    <span>*</span>
                                </div>
                            </div>
                            <input class="inputBoxInput" id="disCountReason" name="disCountReason" type="text" placeholder="تعداد">
                        </div>
                        <div class="inputBoxTour col-xs-3 mg-rt-10 float-right">
                            <div class="inputBoxText">
                                <div>
                                    زمان پایان
                                    <span>*</span>
                                </div>
                            </div>
                            <input type="text" class="inputBoxInput" id="backDate" name="eDate" placeholder="تعداد" readonly>
                        </div>
                        <div class="inputBoxTour col-xs-3 mg-rt-10 float-right">
                            <div class="inputBoxText">
                                <div>
                                    زمان شروع
                                    <span>*</span>
                                </div>
                            </div>
                            <input type="text" class="inputBoxInput" id="goDate" name="sDate" placeholder="تعداد" readonly>
                        </div>
{{--                        @include('layouts.calendar')--}}
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
                        <div class="row">
                            <div class="inputBoxTour col-xs-12 relative-position" id="placeNameAddingPlaceInputDiv">
                                <div class="inputBoxText">
                                    <div> نام هتل</div>
                                </div>
                                <input id="inputSearchHotel" class="inputBoxInput text-align-right" type="text" placeholder="انتخاب کنید" onkeyup="searchForHotel(this)">
                                <div class="searchResult"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="text-align: center">
                    <button id="goToForthStep" class="btn nextStepBtnTourCreation" data-dismiss="modal">تأیید</button>
                </div>

            </div>
        </div>
    </div>

    <div id="hotelCardSample" style="display: none">
        <div id="mainShowHotel_##index##" data-index="##index##" data-id="##id##" class="tourOccupationDetailsTourCreation mg-tp-15 col-xs-12 hotelCard">
            <div style="direction: rtl; display: flex;">
                <div class="col-xs-2">
                    <img src="##pic##" style="width: 100%;" class="resizeImgClass" onload="fitThisImg(this)">
                </div>
                <div class="col-xs-2 pd-0 mg-tp-20">
                    <div class="fullwidthDiv font-size-18" style="font-weight: bold;">##name##</div>
                    <span class="tourOccupationGrade font-size-10">##stateAndCity##</span>
                </div>
                <div class="inputBoxTour col-xs-3 mg-30-10">
                    <div class="inputBoxText">
                        <div>نوع اتاق</div>
                    </div>
                    <input type="text" id="roomKind_##index##" class="inputBoxInput styled-select" placeholder="مدل اتاق">
                </div>
                <div class="mg-tp-20 mg-rt-10 col-xs-2 pd-0">
                    <div class="inputBoxTour full-width">
                        <div class="inputBoxText">
                            <div>قیمت</div>
                        </div>
                        <input class="inputBoxInput" type="text" id="roomCost_##index##" placeholder="ریال" onkeyup="$(this).val(numberWithCommas(this.value))">
                    </div>
                    <div class="inboxHelpSubtitle">قیمت اقامتگاه</div>
                </div>
                <div class="mg-tp-20 mg-rt-10 col-xs-2 pd-0">
                    <div class="inputBoxTour full-width">
                        <div class="inputBoxText">
                            <div>پک</div>
                        </div>
                        <select class="inputBoxInput" id="roomPack_##index##">
                            <option value="a">a</option>
                            <option value="b">b</option>
                            <option value="c">c</option>
                            <option value="d">d</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="hotelCardButtons">
                <button type="button" class="tourOccupationDetailsBtn copyBtnTourCreation" onclick="copyHotelCard(##index##)">
                    <img src="{{URL::asset("images/tourCreation/copy.png")}}">
                </button>
                <button type="button" class="tourOccupationDetailsBtn deleteBtnTourCreation" onclick="deleteHotelCard(##index##)">
                    <img src="{{URL::asset("images/tourCreation/delete.png")}}">
                </button>
            </div>
        </div>
    </div>
    <div id="featureRowSample" style="display: none">
        <div id="features_##index##" data-index="##index##" class="row featuresRow">
            <div class="inputBoxTour float-right col-xs-2" >
                <input id="featureName_##index##" class="inputBoxInput moreFacilityInputs" type="text" placeholder="نام">
            </div>
            <div class="inputBoxTour float-right col-xs-3 mg-rt-10" >
                <input id="featureDesc_##index##" class="inputBoxInput moreFacilityInputs" type="text" placeholder="توضیحات" maxlength="250">
            </div>
            <div class="inputBoxTour float-right col-xs-2 mg-rt-10" >
                <div class="select-side">
                    <i class="glyphicon glyphicon-triangle-bottom"></i>
                </div>
                <select id="featureGroup_##index##"  class="inputBoxInput moreFacilityInputs styled-select">
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
            <div class="inputBoxTour float-right col-xs-3 mg-rt-10 relative-position" >
                <input id="featureCost_##index##" class="inputBoxInput moreFacilityInputs" type="text" placeholder="ریال" onkeyup="$(this).val(numberWithCommas(this.value))">
                <div class="inboxHelpSubtitle" id="subtitleMoreFacility">میزان افزایش قیمت را وارد نمایید.</div>
            </div>
            <div class="col-xs-2" style="text-align: left; position: relative">
                <button type="button" class="tourMoreFacilityDetailsBtn deleteBtnTourCreation" style="position: relative; bottom: 0px; left: 0px; top: 0px" onclick="deleteFeatureRow(##index##)">
                    <img src="{{URL::asset("images/tourCreation/delete.png")}}">
                </button>
            </div>
        </div>
    </div>
    <div id="discountSample" style="display: none">
        <div id="groupDiscount_##index##" data-inde="##index##" class="col-xs-12 pd-0 discountrow">
            <div class="inputBox discountLimitationWholesale float-right">
                <div class="inputBoxText">
                    <div>
                        بازه‌ی تخفیف<span>*</span>
                    </div>
                </div>
                <input class="inputBoxInput startDisCountNumber" name="disCountFrom[]" id="disCountFrom_##index##" type="number" placeholder="از" onkeyup="checkDiscount(##index##, this.value, 0)" onchange="checkAllDiscount()">
                <div class="inputBoxText">
                    <div>الی</div>
                </div>
                <input class="inputBoxInput endDisCountNumber" name="disCountTo[]" id="disCountTo_##index##" type="number" placeholder="تا" onkeyup="checkDiscount(##index##, this.value, 1)" onchange="checkAllDiscount()">
                <div class="inputBoxText">
                    <div>
                        درصد تخفیف<span>*</span>
                    </div>
                </div>
                <input class="inputBoxInput no-border-imp" name="disCountCap[]" id="disCountCap_##index##'" type="text" placeholder="عدد">
            </div>
            <div class="inline-block mg-tp-12 mg-rt-10">
                <button type="button" class="wholesaleDiscountLimitationBtn verifyBtnTourCreation confirmDisCountButton" onclick="createDisCountCard()">
                    <img src="{{URL::asset("images/tourCreation/approve.png")}}">
                </button>
                <button type="button" class="wholesaleDiscountLimitationBtn deleteBtnTourCreation deleteDisCountButton hidden" onclick="deleteDisCountCard(##index##)">
                    <img src="{{URL::asset("images/tourCreation/delete.png")}}">
                </button>
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

    var city;
    var chooseState;
    var roomKind = [];
    var roomCost = [];
    var roomPack = [];
    var featuersIndex = 1;

    var disCountIndex = 1;
    var disCountFrom = [0];
    var disCountTo = [0];
    var discountError = false;

    @if($tour->private)
        $('#maxGroupCapacity').keyup(function(e){
            document.getElementById('maxGroupCapacityDiv').classList.remove('errorClass');
        });
    @endif

    function checkInputs(){

        error = false;
        var error_text = '';

        var hotelError = false;
        var index;
        var roomKind;
        var roomPrice;
        var hotels = [];
        var hotelRows = $('.hotelCard');
        for(var i = 0; i < hotelRows.length; i++){
            index = $(hotelRows[i]).attr('data-index');
            roomPrice = $(`#roomCost_${index}`);
            if(roomPrice.val().trim().length == 0){
                hotelError = true;
                roomPrice.addClass('errorClass');
            }
            else
                roomPrice.removeClass('errorClass');

            roomKind = $(`#roomKind_${index}`);
            if(roomKind.val().trim().length == 0){
                hotelError = true;
                roomKind.addClass('errorClass');
            }
            else
                roomKind.removeClass('errorClass');

            roomPrice1 = roomPrice.val().replace(new RegExp(',', 'g'), '');
            hotels.push({
                id: $(hotelRows[i]).attr('data-id'),
                kind: roomKind.val(),
                cost: roomPrice1,
                pack: $(`#roomPack_${index}`).val(),
            })
        }
        $('#hotelList').val(JSON.stringify(hotels));
        if(hotelError){
            error = true;
            error_text += '<li>اطلاعات هتل ها ناقص است.</li>';
        }

        var featureList = [];
        var featureError = false;
        var featureRows = $('.featuresRow');
        for(var i = 0; i < featureRows.length; i++){
            index = $(featureRows[i]).attr('data-index');
            var name = $(`#featureName_${index}`).val();
            if(name.trim().length > 1){
                var cost = $(`#featureCost_${index}`).val().trim().length == 0 ? '0' : $(`#featureCost_${index}`).val().trim();
                cost = cost.replace(new RegExp(',', 'g'), '');
                featureList.push({
                    name: name.trim(),
                    description: $(`#featureDesc_${index}`).val().trim(),
                    group: $(`#featureGroup_${index}`).val().trim(),
                    cost: cost,
                })
            }
        }
        $('#featureList').val(JSON.stringify(featureList));

        if(featureError){
            error = true;
            error_text += '<li>اطلاعات امکانات اضافه ناقص است.</li>';
        }


        var minCost = document.getElementById('minCost').value;
        var maxCapacity = document.getElementById('maxCapacity').value;
        var minCapacity = document.getElementById('minCapacity').value;

        if(minCost.trim().length == 0){
            error = true;
            error_text += '<li>لطفا قیمت پایه تور را مشخص کنید.</li>';
            document.getElementById('minCostDiv').classList.add('errorClass');
        }
        else
            document.getElementById('minCostDiv').classList.remove('errorClass');

        if(maxCapacity.trim().length == 0){
            error = true;
            error_text += '<li>لطفا حداکثر ظرفیت تور را مشخص کنید.</li>';
            document.getElementById('maxCapacityDiv').classList.add('errorClass');
        }
        else
            document.getElementById('maxCapacityDiv').classList.remove('errorClass');

        if(minCapacity.trim().length == 0){
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
            if(maxGroupCapacity.trim().length == 0){
                error = true;
                error_text += '<li>لطفا حداقل ظرفیت تور را مشخص کنید.</li>';
                document.getElementById('maxGroupCapacityDiv').classList.add('errorClass');
            }
            else
                document.getElementById('maxGroupCapacityDiv').classList.remove('errorClass');
        @endif

        if(error){
            var text =  '<div class="alert alert-danger alert-dismissible">\n' +
                        '            <button type="button" class="close" data-dismiss="alert" style="float: left">&times;</button>\n' +
                        '            <ul id="errorList">\n' + error_text +
                        '            </ul>\n' +
                        '        </div>';
            $('#errorDiv').css('display', 'block').html(text);

            setTimeout(() => document.getElementById('errorDiv').style.display = 'none', 5000);
        }
        else{
            document.getElementById('errorDiv').style.display = 'none';
            $('#form').submit();
        }
    }

</script>

<script>
    var datePickerOptions = {
        numberOfMonths: 1,
        showButtonPanel: true,
        dateFormat: "yy/mm/dd"
    };
    var searchInAjax = null;
    var featuresCount = 0;
    var disCountNumber = 0;
    var chooseHotelsIds = [];
    var chooseHotels = [];
    var hotels;
    var hotelPlaceCard = $('#hotelCardSample').html();
    var featureRowCard = $('#featureRowSample').html();
    var disCountCard = $('#discountSample').html();
    $('#hotelCardSample').remove();
    $('#featureRowSample').remove();
    $('#discountSample').remove();

    var isHotelFunc = _value => document.getElementById('isHotelDiv').style.display = _value == 1 ? 'block' : 'none';

    function searchForHotel(_element){
        var value = $(_element).val();
        if(searchInAjax != null)
            searchInAjax.abort();

        if(value.trim().length > 1){
            searchInAjax = $.ajax({
                type: 'GET',
                url: '{{route("search.place.with.name.kindPlaceId")}}?value='+value+'&kindPlaceId=4',
                success: response => {
                    if(response.status == 'ok') {
                        var text = '';
                        hotels = response.result;
                        hotels.map((item, key) => text += `<div class="searchHover blue" data-index="${key}" onclick="chooseThisHotel(this)" >${item.name} در ${item.state.name} , ${item.city.name}</div>`);
                        $(_element).next().html(text);
                    }
                }
            });
        }
    }
    function chooseThisHotel(_element){
        var index = $(_element).attr('data-index');
        $(_element).parent().empty();
        $('#inputSearchHotel').val('');
        if(chooseHotelsIds.indexOf(hotels[index].id) == -1) {
            var newIndex = chooseHotels.push(hotels[index]);
            chooseHotelsIds.push(hotels[index].id);
            createHotelCard(newIndex-1);
        }
    }
    function createHotelCard(_index){
        var text = hotelPlaceCard;
        var fn = Object.keys(chooseHotels[_index]);
        for(var x of fn)
            text = text.replace(new RegExp(`##${x}##`, "g"), chooseHotels[_index][x]);
        text = text.replace(new RegExp(`##stateAndCity##`, "g"), `استان ${chooseHotels[_index].state.name} ، شهر ${chooseHotels[_index].city.name}`);
        text = text.replace(new RegExp(`##index##`, "g"), _index);

        $('#hotelMainList').append(text)
    }
    function copyHotelCard(_index){
        var index = chooseHotels.push(chooseHotels[_index]);
        chooseHotelsIds.push(chooseHotelsIds[_index]);
        createHotelCard(index-1);
    }
    function deleteHotelCard(_index){
        chooseHotels.splice(_index, 1);
        chooseHotelsIds.splice(_index, 1);
        $('#mainShowHotel_'+_index).remove();
    }
    function cleanHotelSearch(){
        $('#addHotelModal').modal('show');
        $('#inputSearchHotel').val('').next().empty();
    }

    function createFeatureRow(){
        var text = featureRowCard;
        text = text.replace(new RegExp('##index##', 'g'), featuresCount);
        $('#featuresDiv').append(text);
        featuresCount++;
    }
    function deleteFeatureRow(_index){
        if($('.featuresRow').length > 1)
            $('#features_'+_index).remove();
    }

    function createDisCountCard(){
        $('.deleteDisCountButton').removeClass('hidden');
        $('.confirmDisCountButton').addClass('hidden');

        var text = disCountCard;
        text = text.replace(new RegExp('##index##', 'g'), disCountNumber);
        $('#groupDiscountDiv').append(text);
        disCountNumber++;

        if(disCountNumber > 1)
            checkAllDiscount();
    }
    function deleteDisCountCard(_index){
        if($('.discountrow').length > 1)
            $('#groupDiscount_'+_index).remove();
    }

    $(window).ready(() => {
        createFeatureRow();
        createDisCountCard();

        $("#goDate").datepicker(datePickerOptions);
        $("#backDate").datepicker(datePickerOptions);
    });

</script>

</body>
</html>
