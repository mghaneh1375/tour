@extends('panelBusiness.layout.baseLayout')

@section('head')
    <title>ویرایش تور: مرحله سوم</title>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/clockpicker.css?v=1')}}"/>
    <script src= {{URL::asset("js/clockpicker.js") }}></script>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/shazdeDesigns/tourCreation.css?v='.$fileVersions)}}"/>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('BusinessPanelPublic/css/tour/cityTourism.css?v='.$fileVersions)}}"/>

    <link rel="stylesheet" href="{{URL::asset('packages/leaflet/leaflet.css')}}">

    <style>
        .leaflet-div-icon{
            background: none;
            display: flex;
            justify-content: center;
            align-items: center;
            border: none;
        }
        .moveManIcon{
            width: 20px;
            height: 20px;
            background: red;
            border-radius: 50%;
            border: solid 2px black;
            animation: infinite glowMoveMarker 2s;
        }

        @keyframes glowMoveMarker {
            0%{
                background: red;
            }
            50%{
                background: white;
            }
            100%{
                background: red;
            }
        }
    </style>

@endsection


@section('body')

    <div class="mainBackWhiteBody plane_section">
        <div class="head">ویرایش تور: مرحله سوم</div>

        <div class="whiteBox">
            <div class="inboxHelpSubtitle">در این بخش شما می توانید برنامه تور خود را با جزئیات وارد کنید تا مسافران از برنامه تور مطلع شوند.</div>
            <div class="row planSection">
                <div class="col-md-6" style="height: 100%; overflow: auto; padding-right: 0;">
                    <div class="planStepSection">
                        <div class="addNewEventBox" onclick="openNewEventModal()">
                            <div id="addNewEventText" class="text">ثبت اولین برنامه تور</div>
                            <div class="plusChar">+</div>
                        </div>
                        <div id="eventBoxSection" class="placeBoxesSection">
                            <div class="emptyPlan">
                                <i class="fa-regular fa-arrow-up"></i>
                                <div>شما هنوز هیچ برنامه ای ثبت نکرده اید. با استفاده از دکمه بالا می توانید برنامه ی خود را ایجاد کنید.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6" style="height: 100%; padding: 0px">
                    <div id="mapDiv" class="mapSection"></div>
                </div>
            </div>
        </div>

        <div class="row submitAndPrevButton">
            <button class="btn nextStepBtnTourCreation" type="button" onclick="submitSchedule()">ثبت اطلاعات و رفتن به گام بعدی</button>
            <button class="btn nextStepBtnTourCreation goToPrevStep" type="button" onclick="goToPrevStep()" style="margin-right: auto">بازگشت به مرحله قبل</button>
        </div>
    </div>
@endsection

@section('modals')

    <div id="addNewEventModal" class="modalBlackBack fullCenter notCloseOnClick eventModal" style="z-index: 9999;">
        <div class="modalBody" style="width: 600px;">
            <div onclick="closeMyModalBP('addNewEventModal')" class="iconClose closeModal"></div>
            <input type="hidden" id="eventId" value="0">
            <input type="hidden" id="eventCode" value="0">

            <div class="options">
                <div id="newEventModalTitle" class="title"> ثبت برنامه جدید </div>
            </div>

            <div class="optBody">
                <div>
                    <div>نوع برنامه را مشخص کنید</div>
                    <div class="chooseButSection">
                        <label class="chooseBut">
                            <span>بازدید</span>
                            <input type="radio" name="eventType" value="place" onchange="changeEventType(this)">
                        </label>
                        <label class="chooseBut">
                            <span>وعده غذایی</span>
                            <input type="radio" name="eventType" value="meal" onchange="changeEventType(this)">
                        </label>
                        <label class="chooseBut">
                            <span>برنامه خاص</span>
                            <input type="radio" name="eventType" value="special" onchange="changeEventType(this)">
                        </label>
                    </div>
                </div>

                <div id="place_eventInputs" class="eventInputSection hidden">
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

                    <div class="timeSec" style="display: block;">
                        <div class="title">زمان بازدید</div>
                        <div class="inboxHelpSubtitle">
                            ساعت تقریبی شروع و پایان بازدید از
                            <span id="newAmakenNameTitle">...</span>
                            را وارد کنید.
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

                </div>

                <div id="meal_eventInputs" class="eventInputSection hidden">

                    <div class="nonGovernmentalTitleTourCreation">
                        <span>آیا این وعده غذایی در رستوران داده می شود؟</span>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary">
                                <input type="radio" name="inRestaurant" value="1" autocomplete="off" onchange="mealInRestaurant(this.value)">
                                بله
                            </label>
                            <label class="btn btn-secondary active">
                                <input type="radio" name="inRestaurant" value="0" autocomplete="off" onchange="mealInRestaurant(this.value)" checked>
                                خیر
                            </label>
                        </div>
                    </div>

                    <div id="mealInRestaurantSection" class="hidden" style="margin-top: 10px;">
                        <div class="form-group" style="position: relative;">
                            <label for="newRestaurantName">نام رستوران</label>
                            <input type="text" id="newRestaurantName" data-id="0" data-name="" data-img="" data-kindPlaceId="0" class="form-control" onkeyup="searchForRestaurantForNewPlace(this.value)">

                            <div id="mealSearchResultSec" class="searchResultBoxSection hidden" style="width: 100%;">
                                <div class="loader fullyCenterContent">
                                    <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
                                </div>
                                <div class="resContent hidden" style="max-height: 200px; overflow: auto;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="timeSec" style="display: block;">
                        <div class="title">زمان پذیرایی</div>
                        <div class="inboxHelpSubtitle">ساعت پذیرایی را مشخص کنید.</div>
                        <div class="inp">
                            <div class="clockTitle">
                                <div class="name">از ساعت</div>
                                <input type="text" id="startTimeNewMeal" class="form-control clockP" placeholder="کلیک کنید..." readonly>
                            </div>
                            <div class="clockTitle">
                                <div class="name">تا ساعت</div>
                                <input type="text" id="endTimeNewMeal" class="form-control clockP" placeholder="کلیک کنید..." readonly>
                            </div>
                        </div>
                    </div>

                </div>

                <div id="special_eventInputs" class="eventInputSection hidden">
                    <input type="hidden" id="latForSpecial" value="0">
                    <input type="hidden" id="lngForSpecial" value="0">

                    <div class="form-group">
                        <label for="nameForSpecial">عنوان برنامه</label>
                        <input id="nameForSpecial" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="descriptionForSpecial">توضیح برنامه</label>
                        <textarea id="descriptionForSpecial" class="form-control" rows="5"></textarea>
                    </div>

                    <div class="timeSec ligthBRT" style="display: block;">
                        <div class="title">زمان برنامه ویژه</div>
                        <div class="inboxHelpSubtitle">ساعت برنامه ویژه را مشخص کنید.</div>
                        <div class="inp">
                            <div class="clockTitle">
                                <div class="name">از ساعت</div>
                                <input type="text" id="startTimeNewSpecial" class="form-control clockP" placeholder="کلیک کنید..." readonly>
                            </div>
                            <div class="clockTitle">
                                <div class="name">تا ساعت</div>
                                <input type="text" id="endTimeNewSpecial" class="form-control clockP" placeholder="کلیک کنید..." readonly>
                            </div>
                        </div>
                    </div>

                    <div class="nonGovernmentalTitleTourCreation ligthBRT" style="margin-top: 10px; padding-top: 20px;">
                        <span>آیا این برنامه در محل خاصی هست؟</span>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary">
                                <input type="radio" name="specialHasLocation" value="1" autocomplete="off" onchange="specialInMap(this.value)">
                                بله
                            </label>
                            <label class="btn btn-secondary active">
                                <input type="radio" name="specialHasLocation" value="0" autocomplete="off" onchange="specialInMap(this.value)" checked>
                                خیر
                            </label>
                        </div>
                    </div>

                    <div id="specialMapSection" class="hidden" style="display: flex; align-items: center; margin-top: 20px;">
                        <p style="margin: 0 0 0 10px;">محل برنامه را بر روی نقشه مشخص کنید.</p>
                        <button class="btn btn-primary" onclick="openMapForSpecial()">نقشه</button>
                        <span id="specialMapMarkerStatus" class="isSetMapMarker false">محل نامشخص</span>
                    </div>

                </div>

                <div class="eventSectionPartSec">
                    <div class="title">این برنامه را در جایگاه زیر قرار بده.</div>
                    <div class="selectBox">
                        <select id="eventPosition"></select>
                    </div>
                </div>

            </div>

            <div class="submitOptions direction-rtl mg-tp-20" style="display: flex;">
                <button class="btn btn-default" onclick="closeMyModalBP('addNewEventModal')" style="margin-right: auto;">بستن</button>
                <button id="submitEventButton" class="btn successBtn" onclick="submitNewEvent()" style="color: white; background: green;">ثبت برنامه</button>
            </div>
        </div>
    </div>

    <div id="mapModal" class="modalBlackBack fullCenter notCloseOnClick " style="z-index: 9999;">
        <div class="modalBody" style="width: 100%; max-width: 1000px;">
            <div onclick="closeMyModalBP('mapModal')" class="iconClose closeModal"></div>

            <div id="mapForSpecialEvent" class="mapForSpecialEvent"></div>

            <div class="submitOptions direction-rtl mg-tp-20" style="display: flex;">
                <button class="btn btn-default" onclick="closeMyModalBP('mapModal')" style="margin-right: auto;">بستن</button>
                <button id="submitEventButton" class="btn successBtn" onclick="submitNewLocationOnMap()" style="color: white; background: green;">ثبت محل</button>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script defer type="text/javascript" src="{{URL::asset('packages/leaflet/leaflet-src.js')}}"></script>
    <script defer type="text/javascript" src="{{URL::asset('packages/leaflet/leaflet-wms-header.js')}}"></script>

    <script defer type="text/javascript" src="{{URL::asset('packages/leaflet/motion/leaflet.motion.js')}}"></script>


    <script>
        var tour = {!! json_encode($tour) !!};
        var backEvent = {!! json_encode($events) !!};
        var mappIrToken = '{{config('app.MappIrToken')}}';
        var dateCount = {{$tour->day}};
        var defaultPicture = "{{\URL::asset('images/mainPics/noPicSite.jpg')}}";
        var prevStageUrl = "{{route('businessManagement.tour.create.stage_2', ['business' => $businessIdForUrl ,'tourId' => $tour->id])}}";
        var nextStageUrl = "{{route('businessManagement.tour.create.stage_4', ['business' => $businessIdForUrl ,'tourId' => $tour->id])}}";
        var stageStoreUrl = "{{route('businessManagement.tour.store.stage_3')}}";
        var searchPlaceWithNameKinPlaceIdUrl = '{{route("BP.ajax.searchInPlace")}}';
        var getPlaceInfoForPlanUrl = '{{route("tour.getPlaceInfoForPlan")}}';

        var moveIconGif = '{{URL::asset("images/tour/bicycle.gif")}}';
    </script>
    <script src="{{URL::asset('BusinessPanelPublic/js/tour/create/cityTourism/cityTourism_stage_3.js')}}"></script>
@endsection
