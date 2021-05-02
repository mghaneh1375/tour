@extends('panelBusiness.layout.baseLayout')

@section('head')
    <title>مرحله دوم</title>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/clockpicker.css?v=1')}}"/>
    <script src= {{URL::asset("js/clockpicker.js") }}></script>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/shazdeDesigns/tourCreation.css?v='.$fileVersions)}}"/>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('BusinessPanelPublic/css/tour/cityTourism.css?v='.$fileVersions)}}"/>
@endsection


@section('body')

    <div class="mainBackWhiteBody">
        <div class="head">قدم دوم: برنامه تور</div>
        <div>
            <div class="whiteBox">
                <div class="inboxHelpSubtitle">در این بخش شما می توانید برنامه تور خود را با جزئیات وارد کنید تا مسافران از برنامه تور مطلع شوند.</div>
                <div class="inboxHelpSubtitle big">
                    <span style="color: var(--koochita-green)">مکان های دیدنی</span>
                    را که در تور خود می برید مشخص کنید.
                </div>
                <div class="inboxHelpSubtitle">در این بخش شما می توانید تمامی مکان های دیدنی ، زیارتی ، مراکز خرید و ... را که قرار است در برنامه تور خود داشته باشید را مشخص کنید.</div>
                <div class="eventRows">
                    <div id="amakenEvents" style="display: flex; flex-wrap: wrap;"></div>
                    <div class="newEventBox" onclick="createNewAmakenEvent()">
                        <div id="newAmakenButtonText" class="text">برای ثبت محل بازدید جدید کلیک کنید</div>
                        <div class="icon">+</div>
                    </div>
                </div>
            </div>

            <div class="whiteBox">
                <div class="inboxHelpSubtitle big">
                    <span style="color: var(--koochita-blue)">وعده های غذایی</span>
                    تور خود را مشخص کنید.</div>
                <div class="inboxHelpSubtitle">در این بخش شما می توانید تمامی وعده های غذایی از جمله رستوران و میان وعده های تور خود را مشخص کنید.</div>
                <div class="eventRows">
                    <div id="mealsEvents" style="display: flex; flex-wrap: wrap;"></div>
                    <div class="newEventBox" onclick="createNewMealEvent()">
                        <div class="text">برای ثبت وعده غذایی جدید کلیک کنید</div>
                        <div class="icon">+</div>
                    </div>
                </div>
            </div>

            <div class="whiteBox">
                <div class="inboxHelpSubtitle big">
                    <span style="color: var(--koochita-red)">برنامه های ویژه</span>
                     تور خود را مشخص کنید.
                </div>
                <div class="inboxHelpSubtitle">اگر در تور خود برنامه آموزشی ، تفریحی یا ویژه ای دارید مشخص کنید.</div>
                <div class="eventRows">
                    <div id="SEvents" style="display: flex; flex-wrap: wrap;"></div>
                    <div class="newEventBox" onclick="createNewSEvent()">
                        <div class="text">برای ثبت وعده غذایی جدید کلیک کنید</div>
                        <div class="icon">+</div>
                    </div>
                </div>
            </div>


            <div class="row fullyCenterContent" style="padding: 15px;">
                <button class="btn nextStepBtnTourCreation" type="button" onclick="submitSchedule()">گام بعدی</button>
                <button class="btn nextStepBtnTourCreation goToPrevStep" type="button" onclick="goToPrevStep()">بازگشت به مرحله قبل</button>
            </div>
        </div>
    </div>
@endsection

@section('modals')
{{--    add new amaken event modal--}}
    <div id="addAmakenEventModal" class="modalBlackBack fullCenter notCloseOnClick eventModal" style="z-index: 9999;">
        <div class="modalBody" style="width: 600px;">
            <div onclick="closeMyModalBP('addAmakenEventModal')" class="iconClose closeModal"></div>

            <div class="options">
                <div class="title"> ثبت یک محل دیدنی جدید </div>
            </div>

            <div class="optBody">
                <div class="form-group" style="position: relative;">
                    <label for="newAmakenName">نام محل</label>
                    <input type="text" id="newAmakenName" data-id="0" data-name="" data-img="" class="form-control" onkeyup="searchForAmakenForNewPlace(this.value)">

                    <div id="amakenSearchResultSec" class="searchResultBoxSection hidden" style="width: 100%;">
                        <div class="loader fullyCenterContent">
                            <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
                        </div>
                        <div class="resContent hidden" style="max-height: 200px; overflow: auto;"></div>
                    </div>
                </div>
            </div>

            <div class="timeSec" style="display: block;">
                <div class="title">زمان بازدید</div>
                <div class="inboxHelpSubtitle">
                    ساعت تقریبی شروع و پایان
                    <span id="newAmakenNameTitle">...</span>
                    را دارد کنید.
                </div>
                <div class="inp">
                    <div class="clockTitle">
                        <div class="name">ساعت شروع</div>
                        <input type="text" id="startTimeNewAmaken" class="form-control clockP" placeholder="کلیک کنید..." readonly>
                    </div>
                    <div class="clockTitle">
                        <div class="name">ساعت پایان</div>
                        <input type="text" id="endTimeNewAmaken" class="form-control clockP" placeholder="کلیک کنید..." readonly>
                    </div>
                </div>
            </div>

            <div class="timeSec" style="display: block;">
                <div class="title">توضیح خاص برنامه</div>
                <div class="inboxHelpSubtitle">اگر بازدید از این مکان محدودیت و یا وسیله ی خاصی می خواهد توضیح دهید.</div>
                <textarea id="descriptionForAmaken" class="form-control" rows="3" placeholder="مطلب خود را اینجا بنویسید..."></textarea>
            </div>

            <div class="submitOptions direction-rtl mg-tp-20" style="display: flex;">
                <button class="btn btn-default" onclick="closeMyModalBP('addAmakenEventModal')" style="margin-right: 10px; margin-right: auto;">بستن</button>
                <button class="btn successBtn" onclick="submitNewAmaken()" style="color: white; background: green;">ثبت برنامه</button>
            </div>
        </div>
    </div>

{{--    edit new amaken event modal--}}
    <div id="editAmakenEventModal" class="modalBlackBack fullCenter notCloseOnClick eventModal" style="z-index: 9999;">
        <div class="modalBody" style="width: 600px;">
            <div onclick="closeMyModalBP('editAmakenEventModal')" class="iconClose closeModal"></div>

            <input type="hidden" id="editAmakenCode">

            <div class="options">
                <div class="title"> ویرایش محل دیدنی </div>
            </div>

            <div class="optBody">
                <div class="form-group" style="position: relative;">
                    <label for="editAmakenName">نام محل</label>
                    <input type="text" id="editAmakenName" class="form-control" readonly>
                </div>
            </div>

            <div class="timeSec" style="display: block;">
                <div class="title">زمان بازدید</div>
                <div class="inboxHelpSubtitle">
                    ساعت تقریبی شروع و پایان
                    <span id="editAmakenNameTitle"></span>
                    را دارد کنید.
                </div>
                <div class="inp">
                    <div class="clockTitle">
                        <div class="name">ساعت شروع</div>
                        <input type="text" id="startTimeEditAmaken" class="form-control clockP" placeholder="کلیک کنید..." readonly>
                    </div>
                    <div class="clockTitle">
                        <div class="name">ساعت پایان</div>
                        <input type="text" id="endTimeEditAmaken" class="form-control clockP" placeholder="کلیک کنید..." readonly>
                    </div>
                </div>
            </div>

            <div class="timeSec" style="display: block;">
                <div class="title">توضیح خاص برنامه</div>
                <div class="inboxHelpSubtitle">اگر بازدید از این مکان محدودیت و یا وسیله ی خاصی می خواهد توضیح دهید.</div>
                <textarea id="descriptionForEditAmaken" class="form-control" rows="3" placeholder="مطلب خود را اینجا بنویسید..."></textarea>
            </div>

            <div class="submitOptions direction-rtl mg-tp-20" style="display: flex;">
                <button class="btn btn-default" onclick="closeMyModalBP('editAmakenEventModal')" style="margin-right: 10px; margin-right: auto;">بستن</button>
                <button class="btn successBtn" onclick="submitEditAmaken()" style="color: white; background: green;">ثبت برنامه</button>
            </div>
        </div>
    </div>


{{--    add new Meal event modal--}}
    <div id="addMealEventModal" class="modalBlackBack fullCenter notCloseOnClick eventModal" style="z-index: 9999;">
        <div class="modalBody" style="width: 600px;">
            <div onclick="closeMyModalBP('addMealEventModal')" class="iconClose closeModal"></div>

            <div class="options">
                <div class="title"> ثبت وعده غذایی </div>
            </div>

            <div class="optBody">
                <div>
                    <div>نوع وعده را مشخص کنید</div>
                    <div class="chooseButSection">
                        <div class="chooseBut" data-name="mealKind" data-value="main" onclick="changeMealKind('main')">وعده اصلی</div>
                        <div class="chooseBut" data-name="mealKind" data-value="snack" onclick="changeMealKind('snack')">میان وعده</div>
                    </div>
                </div>
                <div style="margin-top: 10px;">
                    <div>آیا این وعده در دستوران داده می شود و یا در یک مکان خاص؟</div>
                    <div class="chooseButSection">
                        <div class="chooseBut" data-name="mealWhere" data-value="restaurant" onclick="changeMealWhere('restaurant')">در رستوران</div>
                        <div class="chooseBut" data-name="mealWhere" data-value="amaken" onclick="changeMealWhere('amaken')">محل خاص</div>
                    </div>
                </div>

                <div id="restaurantNameSection" class="form-group hidden" style="position: relative;margin-top: 10px;">
                    <label id="forMealInAmaken" for="newRestaurantName"> نام محل برای وعده غذایی را وارد کنید</label>
                    <label id="forMealInRestaurant" for="newRestaurantName"> نام رستوران برای وعده غذایی را وارد کنید</label>
                    <input type="text" id="newRestaurantName" data-id="0" data-name="" data-img="" class="form-control" onkeyup="searchForRestaurantForNewPlace(this.value)">

                    <div id="mealSearchResultSec" class="searchResultBoxSection hidden" style="width: 100%;">
                        <div class="loader fullyCenterContent">
                            <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
                        </div>
                        <div class="resContent hidden" style="max-height: 200px; overflow: auto;"></div>
                    </div>
                </div>
            </div>

            <div class="timeSec" style="display: block;">
                <div class="title">زمان وعده غذایی</div>
                <div class="inboxHelpSubtitle">ساعتی که وعده غذایی را می دهید وارد کنید.</div>
                <div class="inp">
                    <div class="clockTitle">
                        <input type="text" id="mealTime" class="form-control clockP" placeholder="کلیک کنید..." readonly>
                    </div>
                </div>
            </div>

            <div class="submitOptions direction-rtl mg-tp-20" style="display: flex;">
                <button class="btn btn-default" onclick="closeMyModalBP('addMealEventModal')" style="margin-right: 10px; margin-right: auto;">بستن</button>
                <button class="btn successBtn" onclick="submitNewMeal()" style="color: white; background: green;">ثبت برنامه</button>
            </div>
        </div>
    </div>

{{--    edit Meal event modal--}}
    <div id="editMealEventModal" class="modalBlackBack fullCenter notCloseOnClick eventModal" style="z-index: 9999;">
        <div class="modalBody" style="width: 600px;">
            <div onclick="closeMyModalBP('editMealEventModal')" class="iconClose closeModal"></div>
            <input type="hidden" id="editMealCode">
            <div class="options">
                <div class="title"> ویرایش برنامه وعده غذایی </div>
            </div>

            <div class="optBody">
                <div>
                    <div>نوع وعده را مشخص کنید</div>
                    <div class="chooseButSection">
                        <div class="chooseBut disabled" id="mainMealKindEdit">وعده اصلی</div>
                        <div class="chooseBut disabled" id="snackMealKindEdit">میان وعده</div>
                    </div>
                </div>
                <div style="margin-top: 10px;">
                    <div>آیا این وعده در دستوران داده می شود و یا در یک مکان خاص؟</div>
                    <div class="chooseButSection">
                        <div class="chooseBut disabled" id="restaurantMealWhere">در رستوران</div>
                        <div class="chooseBut disabled" id="amakenMealWhere">محل خاص</div>
                    </div>
                </div>

                <div id="restaurantNameSection" class="form-group" style="position: relative;margin-top: 10px;">
                    <label for="mealPlaceName">محل ارائه وعده غذایی</label>
                    <input type="text" id="mealPlaceName" class="form-control" readonly>
                </div>
            </div>

            <div class="timeSec" style="display: block;">
                <div class="title">زمان وعده غذایی</div>
                <div class="inboxHelpSubtitle">ساعتی که وعده غذایی را می دهید وارد کنید.</div>
                <div class="inp">
                    <div class="clockTitle">
                        <input type="text" id="mealTimeEdit" class="form-control clockP" placeholder="کلیک کنید..." readonly>
                    </div>
                </div>
            </div>

            <div class="submitOptions direction-rtl mg-tp-20" style="display: flex;">
                <button class="btn btn-default" onclick="closeMyModalBP('editMealEventModal')" style="margin-right: 10px; margin-right: auto;">بستن</button>
                <button class="btn successBtn" onclick="editNewMeal()" style="color: white; background: green;">ثبت برنامه</button>
            </div>
        </div>
    </div>


{{--    add new special event modal--}}
    <div id="specialEventModal" class="modalBlackBack fullCenter notCloseOnClick eventModal" style="z-index: 9999;">
        <div class="modalBody" style="width: 600px;">
            <div onclick="closeMyModalBP('specialEventModal')" class="iconClose closeModal"></div>

            <div class="options">
                <div class="title"> ثبت برنامه ویژه </div>
            </div>

            <div class="optBody">
                <div class="form-group">
                    <label for="specialEventName">عنوان برنامه ویژه را مشخص کنید.</label>
                    <input id="specialEventName" type="text" class="form-control">
                </div>
                <div>
                    <div class="nonGovernmentalTitleTourCreation">
                        <span>آیا برنامه ویژه در ساعت مشخصی است؟</span>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary">
                                <input type="radio" name="sEventHasTime" value="1" autocomplete="off" onchange="specialEventHasTime(this.value)">
                                بله
                            </label>
                            <label class="btn btn-secondary active">
                                <input type="radio" name="sEventHasTime" value="0" autocomplete="off" onchange="specialEventHasTime(this.value)" checked>
                                خیر
                            </label>
                        </div>
                    </div>

                    <div id="sEventTimeSectionNew" class="timeSec hidden" style="margin-top: 0px;">
                        <div>
                            <div class="title">زمان برنامه ویژه</div>
                            <div class="inp">
                                <div class="clockTitle">
                                    <div class="name">ساعت شروع</div>
                                    <input type="text" id="sTimeSEvent" class="form-control clockP" placeholder="کلیک کنید..." readonly>
                                </div>
                                <div class="clockTitle">
                                    <div class="name">ساعت پایان</div>
                                    <input type="text" id="eTimeSEvent" class="form-control clockP" placeholder="کلیک کنید..." readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="timeSec" style="display: block;">
                    <div class="title">توضیح خاص برنامه</div>
                    <div class="inboxHelpSubtitle">اگر برنامه شما دارای توضیحات خاصی هست، آن را وارد کنید.</div>
                    <textarea id="descriptionForSEvent" class="form-control" rows="3" placeholder="اگر مطلبی برای این برنامه دارید بنویسید..."></textarea>
                </div>
            </div>

            <div class="submitOptions direction-rtl mg-tp-20" style="display: flex;">
                <button class="btn btn-default" onclick="closeMyModalBP('specialEventModal')" style="margin-right: 10px; margin-right: auto;">بستن</button>
                <button class="btn successBtn" onclick="submitNewSEvent()" style="color: white; background: green;">ثبت برنامه</button>
            </div>
        </div>
    </div>

{{--    edit special event modal--}}
    <div id="editSpecialEventModal" class="modalBlackBack fullCenter notCloseOnClick eventModal" style="z-index: 9999;">
        <div class="modalBody" style="width: 600px;">
            <div onclick="closeMyModalBP('editSpecialEventModal')" class="iconClose closeModal"></div>
            <input type="hidden" id="sEventCode">

            <div class="options">
                <div class="title"> ویرایش برنامه ویژه </div>
            </div>

            <div class="optBody">
                <div class="form-group">
                    <label for="editSpecialEventName">عنوان برنامه ویژه</label>
                    <input id="editSpecialEventName" type="text" class="form-control">
                </div>
                <div>
                    <div class="nonGovernmentalTitleTourCreation">
                        <span>آیا برنامه ویژه در ساعت مشخصی است؟</span>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary">
                                <input type="radio" name="sEditEventHasTime" value="1" autocomplete="off" onchange="specialEventHasTime(this.value, 'Edit')">
                                بله
                            </label>
                            <label class="btn btn-secondary active">
                                <input type="radio" name="sEditEventHasTime" value="0" autocomplete="off" onchange="specialEventHasTime(this.value, 'Edit')" checked>
                                خیر
                            </label>
                        </div>
                    </div>

                    <div id="sEventTimeSectionEdit" class="timeSec hidden" style="margin-top: 0px;">
                        <div>
                            <div class="title">زمان برنامه ویژه</div>
                            <div class="inp">
                                <div class="clockTitle">
                                    <div class="name">ساعت شروع</div>
                                    <input type="text" id="sTimeSEventEdit" class="form-control clockP" placeholder="کلیک کنید..." readonly>
                                </div>
                                <div class="clockTitle">
                                    <div class="name">ساعت پایان</div>
                                    <input type="text" id="eTimeSEventEdit" class="form-control clockP" placeholder="کلیک کنید..." readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="timeSec" style="display: block;">
                    <div class="title">توضیح خاص برنامه</div>
                    <div class="inboxHelpSubtitle">اگر برنامه شما دارای توضیحات خاصی هست، آن را وارد کنید.</div>
                    <textarea id="descriptionForSEventEdit" class="form-control" rows="3" placeholder="اگر مطلبی برای این برنامه دارید بنویسید..."></textarea>
                </div>
            </div>

            <div class="submitOptions direction-rtl mg-tp-20" style="display: flex;">
                <button class="btn btn-default" onclick="closeMyModalBP('editSpecialEventModal')" style="margin-right: 10px; margin-right: auto;">بستن</button>
                <button class="btn successBtn" onclick="editSEvent()" style="color: white; background: green;">ثبت برنامه</button>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var tour = {!! json_encode($tour) !!};
        var dateCount = {{$tour->day}};
        var defaultPicture = "{{\URL::asset('images/mainPics/noPicSite.jpg')}}";
        var prevStageUrl = "{{route('businessManagement.tour.create.stage_1', ['business' => $businessIdForUrl ,'tourId' => $tour->id])}}";
        var nextStageUrl = "{{route('businessManagement.tour.create.stage_3', ['business' => $businessIdForUrl ,'tourId' => $tour->id])}}";
        var stageTwoStoreUrl = "{{route('businessManagement.tour.store.stage_2')}}";
        var searchPlaceWithNameKinPlaceIdUrl = '{{route("BP.ajax.searchInPlace")}}';
        var eventType = {!! $tourScheduleKinds !!};

    </script>
    <script src="{{URL::asset('BusinessPanelPublic/js/tour/create/cityTourism/cityTourism_stage_2.js')}}"></script>
@endsection
