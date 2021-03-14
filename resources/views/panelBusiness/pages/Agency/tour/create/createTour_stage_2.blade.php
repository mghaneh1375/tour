@extends('panelBusiness.layout.baseLayout')

@section('head')
    <title>مرحله دوم</title>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/clockpicker.css?v=1')}}"/>
    <script src= {{URL::asset("js/clockpicker.js") }}></script>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/shazdeDesigns/tourCreation.css?v='.$fileVersions)}}"/>

    <style>

        .chooseLastDay{
            position: absolute;
            background: #0000006b;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .chooseLastDay .confirm{
            background: green;
            color: white;
            border: none;
            border-radius: 30px;
            padding: 5px 10px;
            margin: 7px;
            font-size: 12px;
        }
        .chooseLastDay .change{
            background: red;
            color: white;
            border: none;
            border-radius: 30px;
            padding: 5px 10px;
            margin: 7px;
            font-size: 12px;
        }
    </style>

@endsection


@section('body')

    <div class="mainBackWhiteBody">
        <div class="head">ایجاد تور: قدم دوم</div>
        <div>
            <div class="whiteBox">
                @for($i = 0; $i < $tour->day; $i++)
                    <div class="dateRow">
                        <div class="headerSec" onclick="openDatePlanRow(this)">
                            <div class="title">برنامه روز {{$i + 1}}</div>
                            <div class="sumInfos"></div>
                            <i class="icon fa-regular fa-angle-down"></i>
                        </div>
                        <div class="bodySec {{$i == 0 ? 'open' : ''}}">
                            <div style="width: 100%; height: 100%;">
                                <div class="hotelSec">
                                    <div class="title">
                                        اقامتگاه روز :
                                        <button type="button" class="addNewHotel" onclick="chooseHotel({{$i}})">انتخاب اقامتگاه</button>
                                    </div>
                                    <div class="hotelInfo">
                                        <div id="answerForSubmitLastHotel_{{$i}}" class="chooseLastDay hidden">
                                            <input type="hidden" id="lastHotelId_{{$i}}" >
                                            <input type="hidden" id="lastHotelKindPlaceId_{{$i}}" >
                                            <button type="button" class="confirm" onclick="submitThisHotel({{$i}})">تایید اقامتگاه</button>
                                            <button type="button" class="change" onclick="chooseHotel({{$i}})">تغییر اقامتگاه</button>
                                        </div>
                                        <div class="hotelPic">
                                            <img id="hotelImgForDay_{{$i}}" class="resizeImgClass" onload="fitThisImg(this)">
                                        </div>
                                        <div>
                                            <div id="hotelNameForDay_{{$i}}" class="name"></div>
                                            <div id="hotelCityForDay_{{$i}}" class="normText"></div>
                                            <div id="hotelAddressForDay_{{$i}}" class="normText"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="planSec">
                                    <div class="title" style="display: flex; align-items: center;">
                                        <span>برنامه روز :</span>
                                        <button type="button" class="iconsPlus" onclick="addEventTo({{$i}})">
                                            <i class="fa-solid fa-circle-plus"></i>
                                        </button>
                                    </div>
                                    <div class="bod">
                                        <div class="mainRule"></div>
                                        <div class="sections">
                                            <div id="planRow_{{$i}}" class="planDetSec"></div>
                                            @for($j = 0; $j < 24; $j++)
                                                <div class="lineSec">
                                                    <div class="line"></div>
                                                    {{$j < 10 ? '0'.$j : $j}}:00
                                                </div>
                                                <div class="sec"></div>
                                            @endfor
                                            <div class="lineSec">
                                                <div class="line"></div>
                                                23:59
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="summerySec">
                                    <div class="title">خلاصه برنامه روز:</div>
                                    <textarea id="dateDescription_{{$i}}" class="form-control" rows="5" placeholder="شما می توانید خلاصه ای از روز خود را اینجا یادداشت کنید..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

            <div class="row fullyCenterContent" style="padding: 15px;">
                <button class="btn nextStepBtnTourCreation" type="button" onclick="checkInput()">گام بعدی</button>
                <button class="btn nextStepBtnTourCreation goToPrevStep" type="button" onclick="goToPrevStep()">بازگشت به مرحله قبل</button>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <div id="addNewEventModal" class="modalBlackBack fullCenter notCloseOnClick eventModal" style="z-index: 9999;">
        <div class="modalBody" style="width: 600px;">

            <input type="hidden" id="newEventTo">

            <div onclick="closeMyModalBP('addNewEventModal')" class="iconClose closeModal"></div>

            <div class="options">
                <div class="title">برنامه</div>
                <div id="eventTitles" class="bod"></div>
            </div>

            <div id="optBody" class="optBody">
                <div id="optBod1" class="optbodies hidden">
                    <input type="text" id="opt1Name" class="form-control" placeholder="نوع وسیله نقلیه...">
                </div>
                <div id="optBod2" class="optbodies hidden"></div>
                <div id="optBod3" class="optbodies hidden">
                    <div class="searchBox">
                        <input type="text" id="opt3Name" class="form-control" placeholder="نام محل بازدید..." onkeyup="searchForPlaces(this, 0)">
                        <div class="searchResult"></div>
                    </div>
                    <div class="choosedPlace"></div>
                </div>
                <div id="optBod4" class="optbodies hidden">
                    <input type="text" id="opt4Name" class="form-control" placeholder="نام محل برای خرید...">
                </div>
                <div id="optBod5" class="optbodies hidden">
                    <input type="text" id="opt5Name" class="form-control" placeholder="نام محل زیارتی...">
                </div>
                <div id="optBod6" class="optbodies hidden">
                    <input type="text" id="opt6Name" class="form-control" placeholder="برنامه ویژه...">
                </div>
                <div id="optBod7" class="optbodies hidden">
                    <div class="searchBox">
                        <input type="text" id="opt7Name" class="form-control" placeholder="نام رستوران..." onkeyup="searchForPlaces(this, 3)">
                        <div class="searchResult"></div>
                    </div>
                    <div class="choosedPlace"></div>
                </div>
            </div>

            <div class="timeSec">
                <div class="title">زمان برنامه</div>
                <div class="inp">
                    <div class="clockTitle">
                        <div class="name">ساعت شروع</div>
                        <input type="text" id="startTimeEvent" class="form-control clockP">
                    </div>
                    <div class="clockTitle">
                        <div class="name">ساعت پایان</div>
                        <input type="text" id="endTimeEvent" class="form-control clockP">
                    </div>
                </div>
            </div>

            <div class="timeSec">
                <div class="title">توضیح برنامه</div>
                <textarea id="descriptionOfNewEvent" class="form-control" rows="3" placeholder="اگر مطلبی برای این برنامه دارید بنویسید..."></textarea>
            </div>

            <div class="submitOptions direction-rtl mg-tp-20">
                <button class="btn successBtn" onclick="doAddEvent()" style="color: white; background: green;">افزودن به برنامه روز</button>
                <button class="btn btn-default" onclick="closeMyModalBP('addNewEventModal')">بستن</button>
            </div>
        </div>
    </div>

    <div id="editEventModal" class="modalBlackBack fullCenter notCloseOnClick eventModal" style="z-index: 9999;">
        <div class="modalBody" style="width: 600px;">

            <input type="hidden" id="editDay">
            <input type="hidden" id="editIndex">

            <div onclick="closeMyModalBP('editEventModal')" class="iconClose closeModal"></div>

            <div class="options">
                <div class="title">
                    برنامه
                    <span id="editEventTitle"></span>
                </div>
            </div>

            <div id="editBody" class="optBody"></div>

            <div class="timeSec">
                <div class="title">زمان برنامه</div>
                <div class="inp">
                    <div class="clockTitle">
                        <div class="name">ساعت شروع</div>
                        <input type="text" id="startTimeEventEdit" class="form-control clockP">
                    </div>
                    <div class="clockTitle">
                        <div class="name">ساعت پایان</div>
                        <input type="text" id="endTimeEventEdit" class="form-control clockP">
                    </div>
                </div>
            </div>

            <div class="timeSec">
                <div class="title">توضیح برنامه</div>
                <textarea id="descriptionOfEditEvent" class="form-control" rows="3" placeholder="اگر مطلبی برای این برنامه دارید بنویسید..."></textarea>
            </div>

            <div class="submitOptions direction-rtl mg-tp-20" style="display: flex;">
                <button class="btn successBtn" onclick="doEditEvent()" style="color: white; background: green;">ویرایش برنامه</button>
                <button class="btn btn-default" onclick="closeMyModalBP('editEventModal')" style="margin-right: 10px;">بستن</button>
                <button class="btn btn-default" onclick="deleteThisEvent()" style="color: white; background: red; margin-right: auto;">حذف برنامه</button>
            </div>
        </div>
    </div>

    <div id="addHotelModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body" style="direction: rtl">
                    <div class="fullwidthDiv">
                        <div class="addPlaceGeneralInfoTitleTourCreation">هتل و یا بوم گردی مورد نظر خود را اضافه کنید</div>
                        <button type="button" class="closee" data-dismiss="modal" style="border: none; background: none; float: left">&times;</button>
                    </div>
                    <div class="container-fluid">
                        <div class="row">

                        </div>
                        <div class="row">
                            <div class="inputBoxTour col-xs-3 relative-position mainClassificationOfPlaceInputDiv" style="float: right">
                                <div class="inputBoxText" style="min-width: 75px;">نوع اقامتگاه</div>
                                <div class="select-side">
                                    <i class="glyphicon glyphicon-triangle-bottom"></i>
                                </div>
                                <select id="hotelKind" class="inputBoxInput styled-select text-align-right">
                                    <option value="4">هتل</option>
                                    <option value="12">بوم گردی</option>
                                </select>
                            </div>
                            <div class="placeNameAddingPlaceInputDiv inputBoxTour col-xs-8 relative-position">
                                <div class="inputBoxText"> نام اقامتگاه</div>
                                <input type="hidden" id="dayForHotelModal">
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

    <div id="choosePlaceSample" class="hidden">
        <div class="placeCar" data-placeId="##id##" data-kindPlaceId="##kindPlaceId##">
            <div class="cancelPlace" data-index="##index##" onclick="deleteThisPlace(this)">
                <i class="fa-light fa-circle-xmark"></i>
            </div>
            <div class="imgSec">
                <img src="##pic##" class="resizeImgClass" onload="fitThisImg(this)">
            </div>
            <div>
                <div class="name">##name##</div>
                <div class="text">##stateAndCity##</div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var tour = {!! json_encode($tour) !!};
        var dateCount = {{$tour->day}};
        var prevStageUrl = "{{route('businessManagement.tour.create.stage_1', ['business' => $businessIdForUrl ,'tourId' => $tour->id])}}";
        var nextStageUrl = "{{route('businessManagement.tour.create.stage_3', ['business' => $businessIdForUrl ,'tourId' => $tour->id])}}";
        var stageTwoStoreUrl = "{{route('businessManagement.tour.store.stage_2')}}";
        var searchPlaceWithNameKinPlaceIdUrl = '{{route("search.place.with.name.kindPlaceId")}}';
        var eventType = {!! $tourScheduleKinds !!};

        var sideMenuAdditional = {
            title: 'ویرایش تور',
            sub: [
                {
                    title: 'اطلاعات اولیه',
                    icon: '<i class="fa-duotone fa-info"></i>',
                    url: "{{route('businessManagement.tour.create.stage_1', ['business' => $businessIdForUrl ,'tourId' => $tour->id])}}",
                },
                {
                    title: 'برنامه سفر',
                    icon: '<i class="fa-duotone fa-calendar-pen"></i>',
                    url: "{{route('businessManagement.tour.create.stage_2', ['business' => $businessIdForUrl ,'tourId' => $tour->id])}}",
                    selected: 1
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
    </script>

    <script src="{{URL::asset('BusinessPanelPublic/js/tour/tourCreate_stage_2.js?v='.$fileVersions)}}"></script>
@endsection
