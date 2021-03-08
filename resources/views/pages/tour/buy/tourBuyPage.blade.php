<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    @include('layouts.topHeader')
    <title>اطلاعات مسافرین تور</title>

    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/buyHotel2.css?v='.$fileVersions)}}'/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/hotelPas1.css?v='.$fileVersions)}}'/>
    <link rel="stylesheet" href="{{URL::asset('css/theme2/tourDetails.css?v='.$fileVersions)}}">

    <link rel="stylesheet" href="{{URL::asset('packages/persianDatePicker/css/persian-datepicker.css')}}">
    <script src="{{URL::asset('packages/persianDatePicker/js/persian-date.min.js')}}"></script>
    <script src="{{URL::asset('packages/persianDatePicker/js/persian-datepicker.min.js')}}"></script>

</head>

<body>
@include('general.forAllPages')

@include('layouts.header1')
    <div class="container" style="direction: rtl; text-align: right;">
        <div id="stickyHeader">
            <div class="container stickyOnTop">
                <div class="col-xs-3 timeRemaining">
                    <div>زمان باقی مانده</div>
                    <div id="timer" class="timer">00:00</div>
                </div>
                <div class="col-xs-9 summeryCostSec">
                    <div class="summery">
                        <div>خرید تور {{$tour->name}}</div>
                        <div>
                            <div>مجموع قابل پرداخت</div>
                            <div class="topPayAbleCost">
                                <span class="cost mainCost totalPayAbleCost costWithoutDiscount"></span>
                                <span class="discounted costWithDiscount"></span>
                            </div>
                        </div>
                    </div>
                    <div class="seeDetailBut downArrowIconAfter"> مشاهده جزئیات</div>
                    <div id="priceDetailsSection" class="detailsCostSec">
                        <div class="editButton" onclick="openEditPassengerCounts()">ویرایش</div>
                        <div class="header">جزئیات قیمتی تور</div>
                        <div>
                            <div class="title">امکانات اضافی</div>
                            <div class="bodyT">
                                @foreach($features as $item)
                                    <div class="bodyR feat">
                                        <div>{{$item->name}}</div>
                                        <div id="featureCount_{{$item->id}}">{{$item->count}} عدد</div>
                                        <div class="cost boldF">{{$item->showCost}}</div>
                                        <div id="featureTotalCost_{{$item->id}}" class="cost boldF">{{$item->totalCostShow}}</div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="totalRow">
                                <div class="boldF">هزینه امکانات اضافی</div>
                                <div class="cost featTotCost"></div>
                            </div>
                        </div>
                        <div>
                            <div class="bodyT">
                                @foreach($passengerInfos as $item)
                                    <div class="bodyR">
                                        <div class="mainCost">{{$item->text}}</div>
                                        <div id="passengerCount_{{$item->id}}" class="mainCost"></div>
                                        <div class="cost mainCost bold">{{$item->payAbleCostShow}}</div>
                                        <div id="passengerTotalCost_{{$item->id}}" class="cost mainCost bold"></div>
                                    </div>
                                @endforeach

                                @if($dailyDiscount != 0)
                                    <div class="bodyR discountRow">
                                        <div>تخفیف روزهای پایانی</div>
                                        <div>{{$dailyDiscount}}%</div>
                                        <div></div>
                                        <div>{{$dailyDiscount}}% به ازای هر نفر</div>
                                    </div>
                                @endif
                                    <div id="priceDiscountSec"></div>
                            </div>
                            <div class="totalRow">
                                <div class="boldF">مجموع قابل پرداخت</div>
                                <div class="cost featTotCost totalPayAbleCost costWithDiscount"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="stickyHeight"></div>
        </div>

        <div class="full-width">
            <div class="float-right"> شما در حال ثبت اطلاعات مسافرین تور {{$tour->name}} می باشید</div>
            <div class="text-align-left">
                <a href="{{route('tour.reservation.cancel').'?code='.$userReservation->code}}" cforeignlass="color-5-12-147Imp"> بازگشت به صفحه اطلاعات تور >> </a>
            </div>
        </div>

        <div class="inlineBorder"></div>
        <form id="reserve_form" method="post" action="#">
            <input type="hidden" name="tourTimeCode" value="{{$tour->timeCode}}">
            <input type="hidden" name="userReservationCode" value="{{$userReservation->code}}">
            <div class="full-width mg-bt-3per">
                <div> اطلاعاتی که در این صفحه وارد می کنید به سایت پذیرنده منتقل می شود تا خرید شما آسان تر از قبل گردد</div>
                <div class="textTitle"> اطلاعات تماس</div>
                <div class="font-size-08em"> این اطلاعات به عنوان اطلاعات تماس شما در کوچیتا ثبت می شود</div>
                <div class="width-60per height-120">
                    <div class="inputBox width-30per float-right">
                        <div class="inputBoxText">
                            <div class="redStar">تلفن همراه</div>
                        </div>
                        <input class="inputBoxInput mustBeFull" id="phoneNumForTicket" type="text" placeholder="0912xxxxxxx" name="phone"
                            value="{{auth()->check() ? auth()->user()->phone: ''}}">
                    </div>
                    <div class="width-40per float-left">
                        <div class="inputBox width-85per">
                            <div class="inputBoxText">
                                <div class="redStar">ایمیل</div>
                            </div>
                            <input class="inputBoxInput mustBeFull"
                                   id="emailForTicket"
                                   type="email"
                                   placeholder="example@domain.com"
                                   name="email"
                                   value="{{auth()->check() ? auth()->user()->email: ''}}">
                        </div>
                        <div class="check-box__item mg-tp-5 labelEditCreate">
                            <label for="importantInformation"> اطلاعات مهم را با این آدرس به من اطلاع دهید </label>
                            <input type="checkbox" id="importantInformation" name="importantInformation" value="1" class="display-inline-blockImp">
                        </div>
                        <div class="check-box__item labelEditCreate">
                            <label for="interestNews"> اخبار مربوط به علایق من را با این آدرس برای من بفرستید </label>
                            <input type="checkbox" id="interestNews" name="otherOffer" value="1" class="display-inline-blockImp">
                        </div>
                    </div>
                </div>
            </div>

            <div class="inlineBorder"></div>

            <div id="getInfoUserSection">
                <div id="passenger_##index##" class="passengerRowsInputs inlineBorder">
                    <div>
                        <div class="display-inline-block">
                            <div class="textTitle">مسافر ##passengerNum## </div>
                            ##mainPassenger##
                        </div>
                        <div class="float-left position-relative">
                            @if(auth()->check())
                                <button onclick="openLastPassengersInfo('##index##')" class="btn afterBuyBtn bg-color-green" type="button"> مسافرین سابق </button>
                                <div class="class_passengerOldPane item hidden" id="oldPassengerPane_##index##">
                                    <p>مسافرین سابق</p>
                                    <div data-index="##index##" class="result lastPassengersInfos"></div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="full-width">
                        @if(array_search('faName', $tour->userInfoNeed) !== false)
                            <div>
                                <div class="inputBox width-21per">
                                    <div class="inputBoxText">
                                        <div class="redStar"> نام </div>
                                    </div>
                                    <input class="inputBoxInput mustBeFull" id="nameFa_##index##" name="nameFa[]" type="text" placeholder="فارسی">
                                </div>
                                <div class="inputBox width-25per mg-rt-10per">
                                    <div class="inputBoxText">
                                        <div class="redStar">نام خانوادگی</div>
                                    </div>
                                    <input class="inputBoxInput mustBeFull" type="text" name="familyFa[]" id="familyFa_##index##" placeholder="فارسی">
                                </div>
                            </div>
                        @endif

                        @if(array_search('enName', $tour->userInfoNeed) !== false)
                            <div>
                                <div class="inputBox width-21per">
                                    <div class="inputBoxText">
                                        <div class="redStar">نام</div>
                                    </div>
                                    <input class="inputBoxInput mustBeFull" name="nameEn[]" id="nameEn_##index##" type="text" placeholder="لاتین">
                                </div>

                                <div class="inputBox width-25per mg-rt-10per">
                                    <div class="inputBoxText">
                                        <div class="redStar">نام خانوادگی</div>
                                    </div>
                                    <input class="inputBoxInput mustBeFull" type="text" placeholder="لاتین" name="familyEn[]" id="familyEn_##index##">
                                </div>
                            </div>
                        @endif
                        <div>
                            @if(array_search('birthDay', $tour->userInfoNeed) !== false)
                                <div class="inputBox width-21per">
                                    <div class="inputBoxText">
                                        <div class="redStar">تاریخ تولد</div>
                                    </div>
                                    <input class="inputBoxInput mustBeFull datePickerBox" type="text" placeholder="13**/**/**" name="birthDay[]" id="birthDay##index##" readonly>
                                </div>
                            @endif
                            @if(array_search('meliCode', $tour->userInfoNeed) !== false)
                                <div id="meliCodeSec_##index##" class="display-inline">
                                    <div class="inputBox width-25per mg-rt-10per">
                                        <div class="inputBoxText">
                                            <div class="redStar">کد ملی</div>
                                        </div>
                                        <input name="NID[]" id="NID_##index##" data-index="##index##" class="inputBoxInput nidInputs mustBeFull width-50per" type="text" placeholder="000000000">
                                    </div>
                                </div>
                            @endif
                            @if(array_search('sex', $tour->userInfoNeed) !== false)
                                <div class="inputBox width-13per mg-rt-10per">
                                    <div class="inputBoxText width-50per">
                                        <div class="redStar">جنسیت</div>
                                    </div>
                                    <select name="sex[]" id="sex_##index##" class="inputBoxSelect width-30per mg-0-9" required>
                                        <option value="1">مرد</option>
                                        <option value="0">زن</option>
                                    </select>
                                </div>
                            @endif
                        </div>
                        @if(array_search('passport', $tour->userInfoNeed) !== false)
                            <div class="check-box__item mg-tp-5 labelEditCreate">
                                <label for="foreign_##index##"> تبعه خارجی هستم </label>
                                <input onclick="changeForeignRow('##index##')" id="foreign_##index##" name="foreign_##index##" value="1" type="checkbox" class="display-inline-blockImp">
                            </div>
                            <div id="foreignRow_##index##" class="row hidden">
                                <div class="col-xs-4">
                                    <div id="searchDivForScroll_##index##" class="inputBox searchDivForScroll">
                                        <div class="inputBoxText">
                                            <div class="redStar">محل صدور</div>
                                        </div>
                                        <input name="countryCode[]" id="countryCode_##index##" class="inputBoxInput mustBeFull" type="text" placeholder="Iran" onkeyup="searchCountryCode(##index##)">
                                        <input name="countryCodeId[]" id="countryCodeId_##index##" class="inputBoxInput mustBeFull" type="hidden">

                                        <div id="resultCountry_##index##" class="data_holder"></div>
                                    </div>
                                </div>

                                <div class="col-xs-4">
                                    <div class="inputBox">
                                        <div class="inputBoxText">
                                            <div class="redStar"> تاریخ انقضا</div>
                                        </div>
                                        <input class="inputBoxInput mustBeFull datePickerEnBox" type="text" placeholder="13**/**/**" name="passportExpire[]" id="passportExpire##index##" readonly>
                                    </div>
                                </div>

                                <div class="col-xs-4">
                                    <div class="inputBox">
                                        <div class="inputBoxText">
                                            <div class="redStar">شماره پاسپورت</div>
                                        </div>
                                        <input name="passport[]" id="passport_##index##" class="inputBoxInput mustBeFull width-50per" type="text" placeholder="000000000">
                                    </div>
                                </div>

                            </div>
                        @endif
                    </div>
                    @if(Auth::check())
                        <div id="saveInformation_div_##index##" class="check-box__item mg-tp-5 labelEditCreate">
                            <label for="saveInformation_##index##">
                                این اطلاعات در قسمت مسافر ها ذخیره شود. در صورت ذخیره اطلاعات در هنگام
                                خرید بلیط دیگر نیاز به وارد کردن اطلاعات این مسافر نمی باشد و تنها با وارد کردن نام می توان
                                اطلاعات را به طور کامل وارد نمود
                            </label>
                            <input type="checkbox" id="saveInformation_##index##" name="saveInformation_##index##" value="1" class="display-inline-blockImp">
                        </div>
                    @endif
                </div>
            </div>

            <div class="questions_div">
                <div class="questions helpUsText">
                    <div> اگر درخواست یا ملاحظه ی دیگری دارید حتما بنویسید تا ما با میزبان شما درمیان بگذاریم</div>
                    <div class="mg-tp-5">
                        <textarea class="requestArea" id="userDescription" name="userDescription" rows="4" placeholder="درخواست خود را وارد کنید"></textarea>
                    </div>
                </div>
            </div>

            @include('pages.tour.buy.tourBuy_discount')

        </form>

        <div class="mg-tp-20 mg-bt-20 ">
            <div class="display-inline-block"> با انتخاب دکمه تأیید و پرداخت شما به صفحه پرداخت فروشنده خدمت متصل می شوید و تنها کافی است مبلغ بلیط را تأیید و پرداخت نمایید </div>
            <div class="color-5-12-147" id="msgErr"></div>
            <div class="text-align-left">
                <button onclick="checkInputs()" class="btn afterBuyBtn bg-color-green" type="button"> تأیید و پرداخت </button>
            </div>
{{--            <div class="text-align-left">--}}
{{--                <button class="btn afterBuyBtn color-5-12-147" type="button"> انصراف </button>--}}
{{--            </div>--}}
        </div>

    </div>

    <div id="editPassengerCountModal" class="modalBlackBack fullCenter buyModal">
        <div class="modalBody">
            <div class="closeButtonModal iconClose" onclick="closeMyModal('editPassengerCountModal')"></div>
            <div class="header"> ویرایش مسافران </div>
            <div class="row priceSection">
                <div id="tourPriceOptions" class="col-xs-5">
                    <div class="full-width inline-block">
                        <span class="inline-block" style="font-weight: bold;">امکانات اضافه</span>
                        <span class="inline-block"></span>
                        <div class="full-width inline-block additionalFeaturesForBuy">
                            @foreach($features as $index => $item)
                                <div class="full-width inline-block buyFeatureRow">
                                    <span>{{$item->name}}</span>
                                    <span class="cost" style="margin-right: 10px">{{number_format($item->cost)}}</span>
                                    <input id="featureInput_{{$item->id}}" data-cost="{{$item->cost}}" type="number" class="form-control featuresInputCount" placeholder="تعداد" value="{{$item->count}}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div id="tourPricePerMan" class="col-xs-7">
                    <div id="pricesInBuyButton">
                        @foreach($passengerInfos as $index => $item)
                            <div class="full-width inline-block priceRow">
                                <span>{{$item->text}}</span>
                                <span style="display: flex; align-items: center; direction: ltr">
                                    <span style="margin-right: 10px; width: 80px;">{{$item->payAbleCostShow}}</span>
                                    X
                                    <span class="passCount">
                                        <span class="addButton" onclick="addPassenger({{$item->id}}, -1)">-</span>
                                        <span id="passengerCountEdit_{{$item->id}}" style="margin: 0px 10px; width: 15px; text-align: center;">{{$item->count}}</span>
                                        <span class="addButton" onclick="addPassenger({{$item->id}}, 1)">+</span>
                                    </span>
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-md-12 fullyCenterContent editButtonRow">
                    <button class="tourListPurchaseBtn" onclick="doEditPassengerCount()">ویرایش</button>
                </div>
            </div>
        </div>
    </div>

@include('layouts.footer.layoutFooter')


<script>
    var searchInCountryUrl = "{{route('ajax.searchInCounty')}}";
    var updateReservationUrl = '{{route('tour.reservation.editPassengerCounts')}}';
    var getMyInfoUrl = '{{route('getMyInfoForPassenger')}}';
    var getLastPassengers = '{{route("getLastPassengers")}}';
    var checkDiscountCodeUrl = '{{route("tour.reservation.checkDiscountCode")}}';
    var submitPassengersInfoUrl = '{{route("tour.reservation.submitReservation")}}';

    var tourAllNeeded = '{{$tour->allUserInfoNeed}}';
    var remainingTime = '{{$timeRemaining}}';
    var reservationCode = '{{$userReservation->code}}';

    var features = {!! json_encode($features) !!};
    var groupDiscount = {!! json_encode($groupDiscount) !!};
    var passengerInfos = {!! json_encode($passengerInfos) !!};

    var mainPassengerSampleButton = `<div class="mainPassengerDiv">مسافر اصلی</div>
                                    @if(auth()->check())
                                    <button onclick="getMyInfo()" class="btn afterBuyBtn bg-color-green" type="button"> من هستم</button>
                                    <div class="autoFillInputs"> اطلاعات موجود از پروفایل شما پر می گردد </div>
                                    @endif`;
</script>

<script src="{{URL::asset('js/pages/tour/tourGetInfos.js?v='.$fileVersions)}}"></script>

</body>
</html>
