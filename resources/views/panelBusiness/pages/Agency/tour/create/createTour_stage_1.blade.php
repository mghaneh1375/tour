@extends('panelBusiness.layout.baseLayout')

@section('head')
    <title>مرحله اول</title>

    <link rel="stylesheet" href="{{URL::asset('css/theme2/bootstrap-datepicker.css')}}">
    <script async src="{{URL::asset("js/bootstrap-datepicker.js")}}"></script>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/shazdeDesigns/tourCreation.css?v='.$fileVersions)}}"/>

    <style>
        .personInfosLabel{
            display: inline-flex;
            align-items: center;
            margin: 7px 20px;
            font-size: 14px;
        }
        .transportInfoSec{
            display: flex !important;
            align-items: center;
            flex-wrap: wrap;
            direction: rtl;
            float: unset;
        }
        .transportInfoSec > div{
            width: 100%;
            display: flex;
            align-items: center;
        }

        .dayActionButton{
            margin: 0px 10px;
            padding: 4px 10px;
            background: var(--koochita-blue);
            color: white;
            border-radius: 7px;
            cursor: pointer;
            box-shadow: 1px 1px 4px 2px #bbbbbb;
        }

        .icon-circle-arrow-right{
            width: 10px;
            height: 10px;
            display: flex;
            border-right: solid 2px black;
            border-top: solid 2px black;
            transform: rotate(45deg);
        }
        .icon-circle-arrow-left{
            width: 10px;
            height: 10px;
            display: flex;
            border-left: solid 2px black;
            border-bottom: solid 2px black;
            transform: rotate(45deg);
        }

    </style>

    <script src="{{URL::asset('js/jalali.js')}}"></script>
@endsection


@section('body')

    <div class="mainBackWhiteBody">
        <div class="head">
            {{$tour == null ? 'ایجاد' : 'ویرایش'}}
            تور: قدم اول
        </div>
        <div>
            <input type="hidden" id="tourId" name="id" value="{{$tour->id ?? 0}}">
            <input type="hidden" id="businessId" value="{{$businessIdForUrl}}">

            <div class="whiteBox">
                <div class="inputBoxGeneralInfo inputBoxTour" style="width: 100%;">
                    <div class="inputBoxTextGeneralInfo inputBoxText">
                        <div class="importantFieldLabel">نام تور</div>
                    </div>
                    <input id="tourName" class="inputBoxInput" type="text" name="name" placeholder="فارسی" required>
                </div>

                <div class="InlineTourInputBoxesMainDiv">
                    <div class="inputBoxGeneralInfo inputBoxTour InlineTourInputBoxes" id="tourOriginInputBox">
                        <div class="inputBoxTextGeneralInfo inputBoxText">
                            <div class="importantFieldLabel">مبدا تور</div>
                        </div>
                        <input class="inputBoxInput" id="srcCity" type="text" placeholder="فارسی" readonly onclick="chooseSrcCityModal()" value="{{isset($tour->srcId) ? $tour->srcId : ''}}">
                        <input id="srcCityId" type="hidden" name="src" value="{{isset($tour->srcId) ? $tour->srcId : ''}}">
                    </div>
                </div>
                <div id="destDiv" class="InlineTourInputBoxesMainDiv">
                    <div class="inputBoxGeneralInfo inputBoxTour InlineTourInputBoxes tourDestinationInputBox">
                        <div class="inputBoxTextGeneralInfo inputBoxText">
                            <div class="importantFieldLabel">مقصد تور</div>
                        </div>
                        <input id="destInput" type="text" class="inputBoxInput" placeholder="فارسی" onclick="chooseDestModal()" readonly>
                        <input id="destPlaceId" type="hidden" name="destId">
                        <input id="destKind" type="hidden" name="destKind">
                    </div>
                </div>
                <div class="inboxHelpSubtitle" style="width: 100%;">
                    با وارد کردن نام شهر گزینه‌های موجود نمایش داده می‌شود تا از بین آن‌ها انتخاب نمایید. اگر نام شهر خود را نیافتید از گزینه‌ی اضافه کردن استفاده نمایید. توجه کنید اگر مبدأ یا مقصد شما جاذبه می‌باشد، آن را وارد نمایید.
                </div>
                <div>
                    <input type="checkbox" id="sameSrcDestInput" name="sameSrcDestInput" onchange="srcDest()" value="1"/>
                    <label for="sameSrcDestInput">
                        <span></span>
                        تور من شهرگردی است و مبدأ و مقصد آن یکی است.
                    </label>
                </div>
            </div>

            <div class="whiteBox">
                <div class="boxTitlesTourCreation">روزهای تور</div>
                <div class="inboxHelpSubtitle">تعداد روز و شب های تور خود را مشخص کنید.</div>

                <div class="row" style="display: flex; width: 100%">
                    <div class="inputBoxTour col-xs-3 mg-rt-10 relative-position float-right" style="margin-right: 10px; margin-left: 15px;">
                        <div class="inputBoxText" style="width: 200px;">
                            <div class="importantFieldLabel">تعداد روزهای تور</div>
                        </div>
                        <input name="tourDay" id="tourDay" class="inputBoxInput" type="text"/>
                    </div>
                    <div class="inputBoxTour col-xs-3 relative-position float-right">
                        <div class="inputBoxText" style="width: 220px;">
                            <div class="importantFieldLabel">تعداد شب های تور</div>
                        </div>
                        <input name="tourNight" id="tourNight" class="inputBoxInput" type="text"/>
                    </div>
                </div>
            </div>

            <div class="whiteBox">

                <div class="boxTitlesTourCreation" style="margin-top: 20px; padding-top: 10px;">زمان برگزاری</div>
                <div>
                    <div class="inboxHelpSubtitle">تاریخ شروع و پایان تور خود را وارد نمایید. توجه کنید که ما این امکان را برای شما فراهم آوردیم تا بتوانید برای تور خود تاریخ های متفاوتی را تعریف کنید.</div>
                    <div id="notSameTimeCalendarDiv" style="display: flex; flex-direction: column">
                        <div>
                            <div class="inputBoxTour col-xs-3 relative-position float-right" style="margin-left: 60px;">
                                <div class="inputBoxText">
                                    <div class="importantFieldLabel">تاریخ شروع</div>
                                </div>
                                <div class="select-side calendarIconTourCreation">
                                    <i class="ui_icon calendar calendarIcon"></i>
                                </div>
                                <input name="sDateNotSame[]" id="sDate_0" class="observer-example inputBoxInput" type="text">
                            </div>

                            <div class="inputBoxTour col-xs-3 mg-rt-10 relative-position float-right">
                                <div class="inputBoxText">
                                    <div class="importantFieldLabel">تاریخ پایان</div>
                                </div>
                                <div class="select-side calendarIconTourCreation">
                                    <i class="ui_icon calendar calendarIcon"></i>
                                </div>
                                <input name="eDateNotSame[]" id="eDate_0" class="observer-example inputBoxInput" readonly/>
                            </div>
                        </div>

                        <div>
                            <div class="inboxHelpSubtitle">اگر تور شما در بازه های مشابه برگزار می شود، شما می توانید از ابزار زیر به راحتی تاریخ ها را انتخاب کنید.</div>
                            <div style="display: flex; align-items: center; margin: 10px 0px;">
                                تور من به صورت
                                <div class="inputBoxGeneralInfo inputBoxTour" style="width: 100px; margin: 0px 10px;">
                                    <select id="calendarType" class="inputBoxInput">
                                        <option value="weekly">هفتگی</option>
                                        <option value="twoWeek">دو هفته</option>
                                        <option value="monthly">ماهانه</option>
                                        <option value="twoMonth">دو ماه</option>
                                    </select>
                                </div>
                                به تعداد
                                <div class="inputBoxGeneralInfo inputBoxTour" style="width: 100px; margin: 0px 10px;">
                                    <input class="inputBoxInput" id="calendarCount" type="number" placeholder="تعداد">
                                </div>
                                برگزار می شود
                                <div class="dayActionButton" onclick="calculateDate()">اعمال</div>
                            </div>
                        </div>

                        <div class="inboxHelpSubtitle">تاریخ های دیگر تور</div>

                        <div id="calendar_1" class="calendarRow">
                            <div class="inputBoxTour col-xs-3 relative-position float-right" style="margin-left: 60px;">
                                <div class="inputBoxText">
                                    <div class="importantFieldLabel">تاریخ شروع</div>
                                </div>
                                <div class="select-side calendarIconTourCreation">
                                    <i class="ui_icon calendar calendarIcon"></i>
                                </div>
                                <input name="sDateNotSame[]" id="sDate_1" class="observer-example inputBoxInput" type="text">
                            </div>
                            <div class="inputBoxTour col-xs-3 mg-rt-10 relative-position float-right">
                                <div class="inputBoxText">
                                    <div class="importantFieldLabel">تاریخ پایان</div>
                                </div>
                                <div class="select-side calendarIconTourCreation">
                                    <i class="ui_icon calendar calendarIcon"></i>
                                </div>
                                <input name="eDateNotSame[]" id="eDate_1" class="observer-example inputBoxInput"/>
                            </div>

                            <div class="inline-block mg-tp-12 mg-rt-10">
                                <button type="button" id="newCalendar_1" class="wholesaleDiscountLimitationBtn verifyBtnTourCreation" onclick="newCalendar()">
                                    <img src="{{URL::asset('images/tourCreation/approve.png')}}">
                                </button>
                                <button type="button" id="deleteCalendar_1" class="wholesaleDiscountLimitationBtn deleteBtnTourCreation" onclick="deleteCalendar(1)" style="display: none;">
                                    <img src="{{URL::asset('images/tourCreation/delete.png')}}">
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="whiteBox">
                <div class="boxTitlesTourCreation">ظرفیت</div>
                <div>
                    <div class="col-xs-4 float-right" style="margin-left: 50px;">
                        <div class="inputBoxTour">
                            <div class="inputBoxText" style="width: 140px">
                                <div class="importantFieldLabel">حداقل ظرفیت</div>
                            </div>
                            <input class="inputBoxInput" type="text" name="minCapacity" id="minCapacity" placeholder="تعداد">
                        </div>
                    </div>
                    <div class="col-xs-4 float-right">
                        <div class="inputBoxTour">
                            <div class="inputBoxText" style="width: 140px">
                                <div class="importantFieldLabel">حداکثر ظرفیت</div>
                            </div>
                            <input class="inputBoxInput" type="text" name="maxCapacity" id="maxCapacity" placeholder="تعداد">
                        </div>
                    </div>
                    <div class="fullwidthDiv">
                        <input type="checkbox" name="anyCapacity" id="anyCapacity" value="1"/>
                        <label for="anyCapacity"><span></span></label>
                        <span id="tourCapacityCheckbox">با هر ظرفیتی تور برگزار می شود.</span>
                    </div>
                </div>

                <div class="nonGovernmentalTitleTourCreation">
                    <span>آیا تور شما به صورت خصوصی برگزار می‌شود؟</span>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-secondary">
                            <input type="radio" name="private" value="1" id="option2" autocomplete="off">بله
                        </label>
                        <label class="btn btn-secondary active">
                            <input type="radio" name="private" value="0" id="option1" autocomplete="off" checked>خیر
                        </label>
                    </div>
                    <div class="inboxHelpSubtitle" style="margin-bottom: 20px; width: 100%">تورهای خصوصی برای گروه محدودی از مخاطبان برگزار می‌شوند و مخاطبا نمی‌توانند تجربه‌ای خصوصی داشته باشند.</div>
                </div>
            </div>

            <div class="whiteBox">
                <div class="boxTitlesTourCreation">اطلاعات اضافی مورد نیاز از مسافر</div>
                <div class="inboxHelpSubtitle">در این بخش شما می توانید تعیین کنید از مسافران خود چه اطلاعاتی علاوه بر [نام و نام خانوادگی ، تاریخ تولد و جنسیت] را نیاز دارید</div>
                <div>
                    <div style="font-weight: bold; margin-top: 10px;">برای صدور بلیت تور به چه اطلاعاتی اضافی از مسافران نیاز دارید؟</div>
                    <div>
                        <input type="checkbox" id="userInfoNeed_faName" name="userInfoNeed[]" value="faName" checked/>
                        <label for="userInfoNeed_faName" class="personInfosLabel" style="display: none">
                            <span></span>
                            <div>نام و نام خانوادگی فارسی</div>
                        </label>
                        <input type="checkbox" id="userInfoNeed_sex" name="userInfoNeed[]" value="sex" checked/>
                        <label for="userInfoNeed_sex" class="personInfosLabel" style="display: none">
                            <span></span>
                            <div>جنسیت</div>
                        </label>
                        <input type="checkbox" id="userInfoNeed_birthDay" name="userInfoNeed[]" value="birthDay" checked/>
                        <label for="userInfoNeed_birthDay" class="personInfosLabel" style="display: none">
                            <span></span>
                            <div>تاریخ تولد</div>
                        </label>

                        <input type="checkbox" id="userInfoNeed_meliCode" name="userInfoNeed[]" value="meliCode" checked/>
                        <label for="userInfoNeed_meliCode" class="personInfosLabel">
                            <span></span>
                            <div>کد ملی</div>
                        </label>

                        <input type="checkbox" id="userInfoNeed_enName" name="userInfoNeed[]" value="enName"/>
                        <label for="userInfoNeed_enName" class="personInfosLabel">
                            <span></span>
                            <div>نام و نام خانوادگی انگلیسی</div>
                        </label>

                        <input type="checkbox" id="userInfoNeed_country" name="userInfoNeed[]" value="country"/>
                        <label for="userInfoNeed_country" class="personInfosLabel">
                            <span></span>
                            <div>ملیت</div>
                        </label>

                        <input type="checkbox" id="userInfoNeed_passport" name="userInfoNeed[]" value="passport"/>
                        <label for="userInfoNeed_passport" class="personInfosLabel">
                            <span></span>
                            <div>اطلاعات پاسپورت</div>
                        </label>

                    </div>
                </div>

                <div class="nonGovernmentalTitleTourCreation" style="margin-top: 20px;">
                    <span>آیا اطلاعات تک تک مسافرین مورد نیاز است؟</span>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-secondary active">
                            <input type="radio" name="isAllUserInfo" value="1" autocomplete="off" checked>
                            بله
                        </label>
                        <label class="btn btn-secondary ">
                            <input type="radio" name="isAllUserInfo" value="0"  autocomplete="off" >
                            خیر
                        </label>
                    </div>
                </div>
            </div>


            <div class="row" style="padding: 15px;">
                <button class="btn nextStepBtnTourCreation" type="button" onclick="checkInput()">گام بعدی</button>
            </div>
        </div>
    </div>

@endsection

@section('modals')
    <div id="timeRowSample" class="hidden">
        <div id="calendar_##number##" class="calendarRow">
            <div class="inputBoxTour col-xs-3 relative-position float-right" style="margin-left: 60px;">
                <div class="inputBoxText">
                    <div class="importantFieldLabel">تاریخ شروع</div>
                </div>
                <div class="select-side calendarIconTourCreation">
                    <i class="ui_icon calendar calendarIcon"></i>
                </div>
                <input name="sDateNotSame[]" id="sDate_##number##" class="observer-example inputBoxInput" type="text">
            </div>
            <div class="inputBoxTour col-xs-3 mg-rt-10 relative-position float-right">
                <div class="inputBoxText">
                    <div class="importantFieldLabel">تاریخ پایان</div>
                </div>
                <div class="select-side calendarIconTourCreation">
                    <i class="ui_icon calendar calendarIcon"></i>
                </div>
                <input name="eDateNotSame[]" id="eDate_##number##" class="observer-example inputBoxInput"/>
            </div>
            <div class="inline-block mg-tp-12 mg-rt-10">
                <button type="button" id="newCalendar_##number##" class="wholesaleDiscountLimitationBtn verifyBtnTourCreation" onclick="newCalendar()">
                    <img src="{{URL::asset('images/tourCreation/approve.png')}}">
                </button>
                <button type="button" id="deleteCalendar_##number##" class="wholesaleDiscountLimitationBtn deleteBtnTourCreation" onclick="deleteCalendar(##number##)" style="display: none;">
                    <img src="{{URL::asset('images/tourCreation/delete.png')}}">
                </button>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addCityModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body" style="direction: rtl">
                    <div class="fullwidthDiv">
                        <div class="addPlaceGeneralInfoTitleTourCreation">
                            شهر مورد نظر خود را اضافه کنید
                        </div>
                        <button type="button" class="closee" data-dismiss="modal" style="border: none; background: none; float: left">&times;</button>
                    </div>

                    <div class="row" style="display: flex; justify-content: space-between">
                        <div class="inputBoxTour col-xs-5 relative-position mainClassificationOfPlaceInputDiv">
                            <div class="inputBoxText" style="min-width: 60px;">
                                <div>
                                    استان
                                    <span>*</span>
                                </div>
                            </div>
                            <div class="select-side">
                                <i class="glyphicon glyphicon-triangle-bottom"></i>
                            </div>
                            <select id="selectStateForSelectCity" class="inputBoxInput styled-select text-align-right" type="text">
                                <option value="0">انتخاب کنید</option>
                                @foreach($states as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="inputBoxTour col-xs-5 relative-position placeNameAddingPlaceInputDiv">
                            <div class="inputBoxText" style="min-width: 60px;">
                                <div>
                                    نام شهر
                                    <span>*</span>
                                </div>
                            </div>
                            <input id="inputSearchCity" class="inputBoxInput text-align-right" type="text" placeholder="انتخاب کنید" onkeyup="searchForCity(this)" />
                            <div class="searchResult"></div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer" style="text-align: center">
                    <button id="goToForthStep" class="btn nextStepBtnTourCreation" data-dismiss="modal">تأیید</button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="addDestinationModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body" style="direction: rtl">
                    <div class="fullwidthDiv">
                        <div class="addPlaceGeneralInfoTitleTourCreation">مقصد نظر خود را انتخاب کنید</div>
                        <button type="button" class="closee" data-dismiss="modal" style="border: none; background: none; float: left">&times;</button>
                    </div>

                    <div class="row" style="display: flex; justify-content: space-between">
                        <div class="col-xs-4">
                            <div class="inputBoxTour relative-position mainClassificationOfPlaceInputDiv" style="width: 100%">
                                <div class="inputBoxText" style="min-width: 60px;">
                                    <div>
                                        استان
                                        <span>*</span>
                                    </div>
                                </div>
                                <div class="select-side">
                                    <i class="glyphicon glyphicon-triangle-bottom"></i>
                                </div>
                                <select id="selectStateForDestination" class="inputBoxInput styled-select text-align-right" type="text">
                                    <option value="0">انتخاب کنید</option>
                                    @foreach($states as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="inputBoxTour col-xs-3 relative-position mainClassificationOfPlaceInputDiv" style="width: 100%">
                                <div class="inputBoxText" style="min-width: 75px;">
                                    <div>
                                        نوع مقصد
                                        <span>*</span>
                                    </div>
                                </div>
                                <div class="select-side">
                                    <i class="glyphicon glyphicon-triangle-bottom"></i>
                                </div>
                                <select id="selectDestinationKind" class="inputBoxInput styled-select text-align-right" type="text">
                                    <option value="city">شهر</option>
                                    <option value="tabiatgardy">طبیعت گردی</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="inputBoxTour  relative-position placeNameAddingPlaceInputDiv" style="width: 100%">
                                <div class="inputBoxText" style="min-width: 60px;">
                                    <div>
                                        نام شهر
                                        <span>*</span>
                                    </div>
                                </div>
                                <input id="inputSearchDestination" class="inputBoxInput text-align-right" type="text" onkeyup="searchForDestination(this)" />
                                <div class="searchResult"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer" style="text-align: center">
                    <button id="goToForthStep" class="btn nextStepBtnTourCreation" data-dismiss="modal">تأیید</button>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var tourType = '{{$type}}';
        var stageOneStoreUrl = "{{route('businessManagement.tour.store.stage_1')}}";
        var stageTwoUrl = "{{url('businessManagement/'.$businessIdForUrl.'/tour/create/stage_2')}}";
        var findCityWithStateUrl = '{{route("findCityWithState")}}';
        var findPlaceWithKindPlaceIdUrl = '{{route("search.place.with.name.kindPlaceId")}}';
        var tour = {!! json_encode($tour) !!};

        @if(isset($tour))
            if(tour) {
                var sideMenuAdditional = {
                    title: 'ویرایش تور',
                    sub: [
                        {
                            title: 'اطلاعات اولیه',
                            icon: '<i class="fa-duotone fa-info"></i>',
                            url: "{{route('businessManagement.tour.create.stage_1', ['business' => $businessIdForUrl ,'tourId' => $tour->id])}}",
                            selected: 1
                        },
                        {
                            title: 'برنامه سفر',
                            icon: '<i class="fa-duotone fa-calendar-pen"></i>',
                            url: "{{route('businessManagement.tour.create.stage_2', ['business' => $businessIdForUrl ,'tourId' => $tour->id])}}",
                        },
                        {
                            title: 'اطلاعات برگزاری',
                            icon: '<i class="fa-duotone fa-plane-tail"></i>',
                            url: "{{route('businessManagement.tour.create.stage_3', ['business' => $businessIdForUrl ,'tourId' => $tour->id])}}",
                        },
                        {
                            title: 'اطلاعات مالی',
                            icon: '<i class="fa-duotone fa-sack-dollar"></i>',
                            url: "{{route('businessManagement.tour.create.stage_4', ['business' => $businessIdForUrl ,'tourId' => $tour->id])}}",
                        },
                        {
                            title: 'اطلاعات اضافی',
                            icon: '<i class="fa-duotone fa-clipboard-list-check"></i>',
                            url: "{{route('businessManagement.tour.create.stage_5', ['business' => $businessIdForUrl ,'tourId' => $tour->id])}}",
                        },
                    ]
                };
                createNewMenuSideBar(sideMenuAdditional);
            }
        @endif
    </script>

    <script defer src="{{URL::asset('BusinessPanelPublic/js/tour/create/tourCreate_stage_1.js?v='.$fileVersions)}}"></script>
@endsection


