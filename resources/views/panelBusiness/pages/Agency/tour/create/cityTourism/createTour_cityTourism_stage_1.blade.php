@extends('panelBusiness.layout.baseLayout')

@section('head')
    <title>
        {{$tour == null ? 'ایجاد' : 'ویرایش'}}
        تور: مرحله اول
    </title>

    <link rel="stylesheet" href="{{URL::asset('css/theme2/bootstrap-datepicker.css')}}">
    <script async src="{{URL::asset("js/bootstrap-datepicker.js")}}"></script>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/shazdeDesigns/tourCreation.css?v='.$fileVersions)}}"/>

    <script src="{{URL::asset('js/jalali.js')}}"></script>

    <style>
        .otherDateSection tr{
            font-size: 11px;
        }

        .discountRow.active .disableButton{
            background: var(--koochita-yellow);
        }
        .discountRow.active .disableButton:before{
            content: 'غیر فعال کردن تخفیف';
        }
        .discountRow.notActive .discountLimitationWholesale{
            opacity: .2;
        }
        .discountRow.notActive .disableButton{
            background: var(--koochita-green);
        }
        .discountRow.notActive .disableButton:before{
            content: 'فعال کردن تخفیف';
        }

    </style>
@endsection


@section('body')

    <div class="mainBackWhiteBody">
        <div class="head">
            {{$tour == null ? 'ایجاد' : 'ویرایش'}}
            تور: مرحله اول
        </div>
        <div>
            <input type="hidden" id="tourId" name="id" value="{{$tour->id ?? 0}}">
            <input type="hidden" id="businessId" value="{{$businessIdForUrl}}">

            <div class="whiteBox">

                <div class="inboxHelpSubtitle big">
                    برای تور خود یک نام مشخص کنید.
                </div>
                <div class="inputBoxGeneralInfo inputBoxTour" style="width: 50%;">
                    <div class="inputBoxTextGeneralInfo inputBoxText">
                        <div class="importantFieldLabel">نام تور</div>
                    </div>
                    <input id="tourName" class="inputBoxInput" type="text" name="name" placeholder="نام تور خود را اینجا وارد کنید..." required>
                </div>


                <div class="inboxHelpSubtitle big" style="margin-top: 25px;">
                    شهری که در آن قرار است تور برگزار شود را مشخص کنید.
                </div>
                <div class="inboxHelpSubtitle" style="width: 100%;">
                    با وارد کردن نام شهر گزینه‌های موجود نمایش داده می‌شود تا از بین آن‌ها انتخاب نمایید. اگر نام شهر خود را نیافتید از گزینه‌ی اضافه کردن استفاده نمایید
                </div>
                <div class="inputBoxGeneralInfo inputBoxTour InlineTourInputBoxes" style="width: 50%; position: relative;">
                    <div class="inputBoxTextGeneralInfo inputBoxText">
                        <div class="importantFieldLabel">شهر برگزاری تور</div>
                    </div>
                    <input class="inputBoxInput" id="srcCity" type="text" placeholder="نام شهر را اینجا وارد کنید..." onkeyup="searchInCity(this.value)" onchange="changeCityName(this)">
                    <input id="srcCityId" type="hidden" name="src">

                    <div id="citySearchResultSec" class="searchResultBoxSection hidden">
                        <div id="citySearchLoader" class="loader fullyCenterContent">
                            <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
                        </div>
                        <div id="citySearchResult" class="hidden" style="max-height: 200px; overflow: auto;"></div>
                    </div>

                </div>

                <div class="nonGovernmentalTitleTourCreation" style="margin-top: 25px;">
                    <span>آیا تور شما به صورت خصوصی هم برگزار می‌شود؟</span>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-secondary">
                            <input type="radio" name="private" value="1" autocomplete="off">بله
                        </label>
                        <label class="btn btn-secondary active">
                            <input type="radio" name="private" value="0" autocomplete="off" checked>خیر
                        </label>
                    </div>
                    <div class="inboxHelpSubtitle" style="margin-bottom: 20px; width: 100%">تورهای خصوصی برای گروه محدودی از مخاطبان برگزار می‌شوند و مخاطبان می‌توانند تجربه‌ای خصوصی داشته باشند.</div>
                </div>
            </div>

            <div class="whiteBox onlyOnNew">
                <div class="boxTitlesTourCreation">تاریخ برگزاری تور</div>
                <div class="inboxHelpSubtitle">در این بخش تاریخ های برگزاری این تور را تعریف کنید.</div>
                <div class="row">
                    <div class="col-md-6 inputBoxTour" style="margin-left: 10px;">
                        <div class="inputBoxText">
                            <div class="importantFieldLabel">تاریخ تور</div>
                        </div>
                        <div class="select-side calendarIconTourCreation">
                            <i class="ui_icon calendar calendarIcon" ></i>
                        </div>
                        <input id="mainDate" class="observer-example inputBoxInput" type="text" placeholder="انتخاب کنید..." onchange="changeModalDate(this.value, 'main')">
                    </div>
                </div>
            </div>

            <div class="whiteBox onlyOnNew">
                <div class="boxTitlesTourCreation">
                    <span>ظرفیت تور برای تاریخ </span>
                    <span class="mainDateShow">....</span>
                </div>
                <div style="display: flex; flex-direction: column;">
                    <div id="tourCapacitySection2">
                        <div class="col-xs-4 float-right" style="margin-left: 50px;">
                            <div class="inputBoxTour">
                                <div class="inputBoxText" style="width: 140px">
                                    <div class="importantFieldLabel" style="white-space: nowrap;">حداقل ظرفیت تور</div>
                                </div>
                                <input id="minCapacity" class="inputBoxInput" type="number" placeholder="تعداد">
                            </div>
                        </div>
                        <div class="col-xs-4 float-right">
                            <div class="inputBoxTour">
                                <div class="inputBoxText" style="width: 140px">
                                    <div class="importantFieldLabel" style="white-space: nowrap;">حداکثر ظرفیت تور</div>
                                </div>
                                <input id="maxCapacity" class="inputBoxInput" type="number" placeholder="تعداد">
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="whiteBox onlyOnNew">
                <div class="boxTitlesTourCreation">
                    <span>قیمت تور برای تاریخ </span>
                    <span class="mainDateShow">....</span>
                </div>
                <div class="inboxHelpSubtitle">قیمت پایه تور خود را به تومان وارد کنید. توجه کنید شما می توانید در بخش تاریخ برگزاری تور به ازای هر تاریخ مقدار افزایش قیمت تور را مشخص کنید.</div>
                <div class="row" style="align-items: center;">
                    <div class="col-md-6">
                        <div class="inputBoxGeneralInfo inputBoxTour" style="width: 100%;">
                            <div class="inputBoxTextGeneralInfo inputBoxText">
                                <div class="importantFieldLabel" style="white-space: nowrap;">قیمت پایه تور(تومان)</div>
                            </div>
                            <input id="tourCost" class="inputBoxInput" type="text" name="cost" placeholder="قیمت پایه تور خود را اینجا وارد کنید..." onkeyup="$(this).val(numberWithCommas(this.value))">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="pd-0" style="margin-right: 25px;">
                            <span>آیا تور شما دارای بیمه می‌باشد؟</span>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-secondary">
                                    <input type="radio" name="isInsurance" value="1">
                                    بله
                                </label>
                                <label class="btn btn-secondary active">
                                    <input type="radio" name="isInsurance" value="0" checked>
                                    خیر
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="whiteBox onlyOnNew">
                <div class="fullwidthDiv">
                    <div class="boxTitlesTourCreation">
                        <span>تخفیف خرید گروهی تور برای تاریخ </span>
                        <span class="mainDateShow">....</span>
                    </div>
                    <div class="inboxHelpSubtitle">تخفیف‌های گروهی به خریداران ظرفیت‌های بالا اعمال می‌شود. شما می‌توانید با تعیین بازه‌های متفاوت تخفیف‌های متفاوتی اعمال نمایید.</div>
                    <div id="mainGroupDiscount"></div>

                    <div class="addNewDateRow">
                        <button class="btn btn-primary" onclick="createGroupDisCountCard('main')">افزدون تخفیف گروهی جدید</button>
                    </div>
                </div>
            </div>

            <div class="whiteBox">
                <div class="nonGovernmentalTitleTourCreation onlyOnNew" style="margin-top: 25px;">
                    <span>آیا این تور شما در تاریخ های دیگری نیز برگزار می شود؟</span>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-secondary">
                            <input type="radio" name="otherDays" value="1" autocomplete="off" onchange="hasOtherDate(this.value)">
                            بله
                        </label>
                        <label class="btn btn-secondary active">
                            <input type="radio" name="otherDays" value="0" autocomplete="off" checked onchange="hasOtherDate(this.value)">
                            خیر
                        </label>
                    </div>
                </div>
                <div class="boxTitlesTourCreation onlyOnEdit hidden">تاریخ های برگزاری تور</div>
                <div id="otherDateSection" class="otherDateSection hidden">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>تاریخ</th>
                                <th>قیمت</th>
                                <th>ظرفیت</th>
                                <th>تعداد تخفیف گروهی</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="otherDateTableBody"></tbody>
                    </table>
                    <div class="addNewDateRow">
                        <button class="btn btn-primary" onclick="openDateModal()">افزدون تاریخ جدید</button>
                    </div>
                </div>
            </div>


            <div class="whiteBox  hidden">
                <div class="fullwidthDiv">
                    <div class="boxTitlesTourCreation">تخفیف های لحظه اخری</div>
                    <div id="lastDayesDiscounts" style="display: flex; flex-direction: column;"></div>
                    <div class="addNewDateRow">
                        <button class="btn btn-primary" onclick="addLastDayDiscount()">افزودن تخفیف لحظه آخری</button>
                    </div>
                </div>
            </div>

            <div class="whiteBox">
                <div class="boxTitlesTourCreation">شرایط کنسلی</div>
                <div class="inboxHelpSubtitle">شرایط کنسلی تور خود را به اطلاع مسافران خود برسانید.</div>
                <div class="tourGuiderQuestions mg-tp-15">
                    <span>آیا تور شما دارای کنسلی می‌باشد؟</span>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-secondary active">
                            <input type="radio" name="isCancelAbel" value="1" onchange="changeCancelAble(this.value)" checked>بلی
                        </label>
                        <label class="btn btn-secondary">
                            <input type="radio" name="isCancelAbel" value="0" onchange="changeCancelAble(this.value)">خیر
                        </label>
                    </div>
                </div>
                <div id="cancelDiv">
                    <div class="inboxHelpSubtitle" style="width: 100%">در این صورت شرایط آن را توضیح دهید.</div>
                    <div class="inputBox cancellingSituationTourCreation height-250">
                        <textarea id="cancelDescription" class="inputBoxInput fullwidthDiv text-align-right full-height textareaInForDescription" placeholder="متن خود را وارد کنید"></textarea>
                    </div>
                </div>
            </div>

            <div class="row submitAndPrevButton">
                <button class="btn nextStepBtnTourCreation" type="button" onclick="checkInput()">ثبت اطلاعات و رفتن به گام بعدی</button>
            </div>
        </div>
    </div>

@endsection

@section('modals')
    <div id="timeRowSample" class="hidden">
        <div id="calendar_##number##" class="calendarRow">
            <div class="inputBoxTour col-md-3 relative-position float-right" style="margin-left: 10px;">
                <div class="inputBoxText">
                    <div>تاریخ تور</div>
                </div>
                <div class="select-side calendarIconTourCreation">
                    <i class="ui_icon calendar calendarIcon" ></i>
                </div>
                <input name="sDateNotSame[]" id="sDate_##number##" class="observer-example inputBoxInput" type="text" placeholder="انتخاب کنید...">
            </div>
            <div class="inputBoxTour col-md-3 relative-position float-right" style="margin-left: 10px;">
                <div class="inputBoxText">
                    <div>مقدار افزایش قیمت(تومان)</div>
                </div>
                <input name="sDateNotSameCost[]" id="sDateCost_##number##" class="inputBoxInput" type="text" onkeyup="this.value = numberWithCommas(this.value)" placeholder="مقدار افزایش قیمت به تومان را وارد کنید...">
            </div>
            <div class="inline-block mg-rt-10">
                <button type="button" id="deleteCalendar_##number##" class="wholesaleDiscountLimitationBtn deleteBtnTourCreation" onclick="deleteCalendar(##number##)">حذف تاریخ</button>
            </div>
        </div>
    </div>

    <div id="dateModal" class="modalBlackBack fullCenter notCloseOnClick dateModal" style="z-index: 9999;">
        <div class="modalBody" style="max-width: 850px; width: 95%; overflow: auto; max-height: 95%;">
            <div onclick="closeMyModalBP('dateModal')" class="iconClose closeModal"></div>
            <input type="hidden" id="tourDateId">
            <input type="hidden" id="tourDateCode">
            <div class="options" style="padding-bottom: 10px;">
                <div class="title"> ایجاد/ویرایش تاریخ برگزاری تور</div>
            </div>

            <div class="row">
                <div class="col-md-6 inputBoxTour" style="margin-left: 10px;">
                    <div class="inputBoxText">
                        <div class="importantFieldLabel">تاریخ تور</div>
                    </div>
                    <div class="select-side calendarIconTourCreation">
                        <i class="ui_icon calendar calendarIcon" ></i>
                    </div>
                    <input id="dateInModal" class="observer-example inputBoxInput" type="text" placeholder="انتخاب کنید..." onchange="changeModalDate(this.value, 'modal')">
                    <input id="dateInModalWithoutCalendar" class="inputBoxInput hidden" type="text" style="opacity: .5;" readonly>
                </div>
            </div>

            <div class="row topBorder">
                <div class="col-md-12 secTitle">
                    <span>ظرفیت تور برای تاریخ </span>
                    <span class="dateClassInModal">...</span>
                </div>
                <div class="col-md-12">
                    <div id="tourCapacitySection" class="row">
                        <div class="col-xs-4" style="margin-left: 50px;">
                            <div class="inputBoxTour">
                                <div class="inputBoxText">
                                    <div class="importantFieldLabel">حداقل ظرفیت</div>
                                </div>
                                <input class="inputBoxInput" type="number" id="minCapacityInModal" placeholder="تعداد">
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="inputBoxTour">
                                <div class="inputBoxText">
                                    <div class="importantFieldLabel">حداکثر ظرفیت</div>
                                </div>
                                <input class="inputBoxInput" type="number" id="maxCapacityInModal" placeholder="تعداد">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row topBorder">
                <div class="col-md-12 secTitle">
                    <span>قیمت تور برای تاریخ </span>
                    <span class="dateClassInModal">...</span>
                </div>
                <div class="col-md-12">
                    <div class="inboxHelpSubtitle">در این قسمت قیمت تور در این تاریخ خاص را وارد کنید.</div>
                </div>
                <div class="col-md-8">
                    <div class="inputBoxTour">
                        <div class="inputBoxText">
                            <div class="importantFieldLabel">قیمت به تومان</div>
                        </div>
                        <input id="costInModal" class="inputBoxInput" type="text" placeholder="0" onkeyup="$(this).val(numberWithCommas(this.value))">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="nonGovernmentalTitleTourCreation">
                        <span style="font-weight: normal;">آیا تور شما در این تاریخ بیمه دارد؟</span>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary">
                                <input type="radio" name="isInsuranceInModal" value="1" autocomplete="off">
                                بله
                            </label>
                            <label class="btn btn-secondary active">
                                <input type="radio" name="isInsuranceInModal" value="0" autocomplete="off" checked>
                                خیر
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row topBorder">
                <div class="col-md-12 secTitle">
                    <span>تخفیف خرید گروهی تور برای تاریخ </span>
                    <span class="dateClassInModal">...</span>
                </div>
                <div id="groupDiscountDiv" class="col-md-12"></div>
                <div class="col-md-12 fullyCenterContent">
                    <button class="btn btn-primary" onclick="createGroupDisCountCard('modal')">افزدون تخفیف گروهی جدید</button>
                </div>
            </div>

            <div class="submitOptions direction-rtl mg-tp-20" style="display: flex;">
                <button class="btn btn-default" onclick="closeMyModalBP('dateModal')" style="margin-right: 10px; margin-right: auto;">بستن</button>
                <button class="btn successBtn" onclick="submitDateModal()" style="color: white; background: green;">ثبت تاریخ</button>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        var tour = {!! json_encode($tour) !!};
        var tourType = '{{$type}}';
        var stageOneStoreUrl = "{{route('businessManagement.tour.store.stage_1')}}";
        var stageTwoUrl = "{{url('businessManagement/'.$businessIdForUrl.'/tour/create/stage_2')}}";
        var findCityWithStateUrl = '{{route("BP.ajax.searchCity")}}';
        var findPlaceWithKindPlaceIdUrl = '{{route("search.place.with.name.kindPlaceId")}}';
    </script>

    <script defer src="{{URL::asset('BusinessPanelPublic/js/tour/create/cityTourism/cityTourism_stage_1.js?v='.$fileVersions)}}"></script>
@endsection


