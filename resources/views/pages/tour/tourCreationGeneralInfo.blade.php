<?php
$kindPlaceId = 1;
$placeMode = 'state';
$state = 'تهران';
?>

        <!DOCTYPE html>
<html>
<head>
    @include('layouts.topHeader')
    @include('layouts.phonePopUp')
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/theme2/home_rebranded.css?v=4')}}"/>
    <title>صفحه اصلی</title>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/theme2/long_lived_global_legacy_2.css?v=2')}}"/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/masthead-saves.css?v=2')}}'/>
    <link rel='stylesheet' type='text/css' media='screen, print'
          href='{{URL::asset('css/theme2/hr_north_star.css?v=2')}}'/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/icons.css?v=1')}}'/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/passStyle.css?v=1')}}'/>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/shazdeDesigns/tourCreation.css?v=1')}}"/>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/shazdeDesigns/abbreviations.css?v=1')}}"/>

    <style>
        .chooseTourKind{
            background: rgb(77, 199, 188) !important;
            color: white !important;
        }
        @for($i = 0; $i < count($tourKind); $i++)
        #tourKind{{$tourKind[$i]->id}}:before{
            content: '\{{$tourKind[$i]->icon}}';
            /*font-family: shazdemosafer-tour;*/
            font-family: 'Shazde_Regular2' !important;
        }
        @endfor

        .tourLevelIcons::before{
            width: 100%;
            display: flex;
            font-weight: normal;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
        }
        .tourLevelIcons{
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            cursor: pointer;
        }
        .tourKindIcons:hover{
            background: var(--koochita-light-green);
        }
        @for($i = 0; $i < count($tourDifficult); $i++)
            #tourDifficult{{$i}}:before{
                content: '\{{$tourDifficult[$i]->icon}}';
            font-family: 'Shazde_Regular2' !important;
            }
        @endfor
    </style>
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
                    <b class="formName">اطلاعات تور</b>
                    <div class="tourCreationStepInfo">
                        <span>
                            گام
                            <span>1</span>
                            از
                            <span>6</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="tourDetailsMainForm1stStepMainDiv" class="Hotel_Review prodp13n_jfy_overflow_visible lightGreyBox">
        <form method="post" action="{{route('tour.create.stage.one.store')}}" autocomplete="off">
            {!! csrf_field() !!}
            <input type="hidden" name="kind" id="kind">
            <div class="ui_container">
                <div class="menu ui_container whiteBox">
                    <div id="tourNameInputBoxMainDiv">
                        <div class="inputBoxGeneralInfo inputBox" id="tourNameInputBox">
                            <div class="inputBoxTextGeneralInfo inputBoxText">
                                <div>
                                    نام تور
                                    <span>*</span>
                                </div>
                            </div>
                            <input class="inputBoxInput" type="text" name="name" placeholder="فارسی" value="{{isset($tour->name) ? $tour->name : ''}}" required>
                        </div>
                    </div>
                    <span class="inboxHelpSubtitle">
                        با وارد کردن نام شهر گزینه‌های موجود نمایش داده می‌شود تا از بین آن‌ها انتخاب نمایید. اگر نام شهر خود را نیافتید از گزینه‌ی اضافه کردن استفاده نمایید. توجه کنید اگر مبدأ یا مقصد شما جاذبه می‌باشد، آن را وارد نمایید.
                    </span>
                    <div class="InlineTourInputBoxesMainDiv">
                        <div class="inputBoxGeneralInfo inputBox InlineTourInputBoxes" id="tourOriginInputBox">
                            <div class="inputBoxTextGeneralInfo inputBoxText">
                                <div>
                                    مبدأ
                                    <span>*</span>
                                </div>
                            </div>
                            <input class="inputBoxInput" id="srcCity" type="text" placeholder="فارسی" readonly onclick="chooseSrcCityModal()" value="{{isset($tour->srcId) ? $tour->srcId : ''}}">
                            <input id="srcCityId" type="hidden" name="src" value="{{isset($tour->srcId) ? $tour->srcId : ''}}">
                        </div>
                    </div>
                    <div id="destDiv" class="InlineTourInputBoxesMainDiv">
                        <div class="inputBoxGeneralInfo inputBox InlineTourInputBoxes" id="tourDestinationInputBox">
                            <div class="inputBoxTextGeneralInfo inputBoxText">
                                <div>
                                    مقصد
                                    <span>*</span>
                                </div>
                            </div>
                            <input class="inputBoxInput" id="destInput" type="text" placeholder="فارسی" onkeyup="searchDest(this.value)" onfocusout="hideSearchDest()"  autocomplete="none" value="{{isset($tour->destId) ? $tour->destId : ''}}">
                            <input id="destCityId" type="hidden" name="dest" value="{{isset($tour->destId) ? $tour->destId : ''}}">
                            <div id="destinationListTourCreation" class="hidden-div">
                                <div id="addNewDestinationTourCreation">اضافه کردن فارسی</div>
                                <div id="destCitySearch"></div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <input ng-model="sort" type="checkbox" id="c01" onchange="srcDest()"/>
                        <label for="c01">
                            <span></span>
                        </label>
                        <span id="cityTourCheckBoxLabel">
                            تور من شهرگردی است و مبدأ و مقصد آن یکی است.
                        </span>
                    </div>
                </div>
            </div>

            <div class="ui_container">
                <div class="menu ui_container whiteBox">
                    <div id="tourKindChoseTitleTourCreation">
                        <span>نوع تور خود را مشخص کنید.</span>
                        <span onclick="$('#tourKindDescriptionModal').toggle()" style="cursor: pointer;">آیا نیازمند راهنمایی هستید؟</span>
                    </div>
                    <div class="tourKindIconsTourCreation">
                        @for($i = 0; $i < count($tourKind); $i++)
                            <input ng-model="sort" type="checkbox" id="c1{{$tourKind[$i]->id}}" value="{{$tourKind[$i]->id}}" onclick="chooseTourKind({{$tourKind[$i]->id}})"/>
                            <label id="{{$tourKind[$i]->name == 'محلی' ? 'mahali' : ($tourKind[$i]->name == 'شهرگردی' ? 'shahr' : '')}}"
                                   for="c1{{$tourKind[$i]->id}}"
                                   onmouseover="changeKindColorToHover({{$tourKind[$i]->id}})"
                                   onmouseleave="changeColorToLeave({{$tourKind[$i]->id}})"
                                   style="display: {{$tourKind[$i]->name == 'محلی' ? 'none': 'inline-block'}}; cursor: pointer;">
                                <div id="tourKind{{$tourKind[$i]->id}}" class="tourKindIcons"></div>
                                <div id="cityKindTourName" class="tourKindNames">{{$tourKind[$i]->name}}</div>
                            </label>
                        @endfor
                    </div>
                    <div class="inboxHelpSubtitle">انتخاب بیش از یک گزینه مجاز می‌باشد</div>
                </div>
            </div>
            <div class="ui_container">
                <div class="menu ui_container whiteBox" id="">
                    <div id="tourLevelChoseTitleTourCreation">
                        <span>درجه سختی تور خود را مشخص کنید.</span>
                        <span onclick="$('#tourDifficultDescriptionModal').toggle()" style="cursor: pointer;">آیا نیازمند راهنمایی هستید؟</span>
                    </div>
                    <div class="tourLevelIconsTourCreation">
                        @for($i = 0; $i < count($tourDifficult); $i++)
                            <input ng-model="sort" type="{{$tourDifficult[$i]->alone == 0 ? 'checkbox' : 'radio'}}" name="difficult[]" id="c3{{$i}}" value="{{$tourDifficult[$i]->id}}" onclick="chooseDifficult({{$i}}, this.value, {{$tourDifficult[$i]->alone}})"/>
                            <label for="c3{{$i}}">
                                <div id="tourDifficult{{$i}}" class="tourLevelIcons"></div>
                                <div>{{$tourDifficult[$i]->name}}</div>
                            </label>
                        @endfor

                        <script>
                            $(document).ready(function () {
                                $(".tourLevelIcons").mouseenter(function () {
                                    $(this).css("background-color", "var(--koochita-light-green)"),
                                        $(this).css("color", "white");
                                });
                                $(".tourLevelIcons").mouseleave(function () {
                                    $(this).css("background-color", "#e5e5e5"),
                                        $(this).css("color", "black");
                                });
                            });
                        </script>
                    </div>
                    <div class="inboxHelpSubtitle">انتخاب گزینه‌های
                        @foreach($tourDifficult as $item)
                            @if($item->alone == 0)
                                {{$item->name}} ,
                            @endif
                        @endforeach
                        با گزینه‌های دیگر مجاز
                        می‌باشد.
                    </div>
                </div>
            </div>
            <div class="ui_container">
                <div class="menu ui_container whiteBox" id="">
                    <div id="concentrationChoseTitleTourCreation">
                        <span>تمرکز خود را مشخص کنید.</span>
                    </div>
                    <div class="concentrationChoseTourCreation">
                        @for($i = 0; $i < count($tourFocus); $i++)
                            <div class="col-xs-2">
                                <input ng-model="sort" type="checkbox" id="c4{{$i}}" name="focus[]" value="{{$tourFocus[$i]->id}}"/>
                                <label for="c4{{$i}}">
                                    <span></span>
                                </label>
                                <span class="concentrationKindTourCreation">
                                {{$tourFocus[$i]->name}}
                            </span>
                            </div>
                        @endfor
                    </div>
                    <div class="inboxHelpSubtitle">از بین گزینه‌های فوقمواردی را که بهتر تمرکز تور شما را بیان می‌کند،
                        انتخاب نمایید.
                    </div>
                </div>
            </div>
            <div class="ui_container">
                <div class="menu ui_container whiteBox" id="">
                    <div id="tourTypeChoseTitleTourCreation">
                        <span>تیپ خود را مشخص کنید.</span>
                    </div>
                    <div class="tourTypeChoseChoseTourCreation">

                        @for($i = 0; $i < count($tourStyle); $i++)
                            <div class="col-xs-2">
                                <input ng-model="sort" type="checkbox" id="c5{{$i}}" name="style[]" value="{{$tourStyle[$i]->id}}"/>
                                <label for="c5{{$i}}">
                                    <span></span>
                                </label>
                                <span class="tourTypeChoseTourCreation">
                                    {{$tourStyle[$i]->name}}
                                </span>
                            </div>
                        @endfor
                    </div>
                    <div class="inboxHelpSubtitle">تیپ گردشگران خود را با انتخاب یک یا چند گزینه‌ی فوق، انتخاب نمایید.
                    </div>
                </div>
            </div>
            <div class="ui_container">
                <div class="menu ui_container whiteBox" id="">
                    <div id="nonGovernmentalTitleTourCreation">
                        <span>آیا تور شما به صورت خصوصی برگزار می‌شود؟</span>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary">
                                <input type="radio" name="private" value="0" id="option1" autocomplete="off">خیر
                            </label>
                            <label class="btn btn-secondary active">
                                <input type="radio" name="private" value="1" id="option2" autocomplete="off" checked>بلی
                            </label>
                        </div>
                    </div>
                    <div class="inboxHelpSubtitle">تورهای خصوصی برای گروه محدودی از مخاطبان برگزار می‌شوند و مخاطبان
                        می‌توانند تجربه‌ای خصوصی داشته باشند.
                    </div>
                    <div class="fullwidthDiv">
                        <div id="tourBestSeasonTitleTourCreation" class="halfWidthDiv">
                            تور شما در چه فصلی بهترین تجربه را در اختیار کاربران قرار می‌دهد؟
                        </div>
                        <div id="tourBestSeasonChoseTourCreation" class="halfWidthDiv">
                            <div class="col-xs-3">
                                <input ng-model="sort" type="checkbox" name="season[]" id="c66" value="بهار"/>
                                <label for="c66">
                                    <span></span>
                                </label>
                                <span class="tourTypeChoseTourCreation">
                                    بهار
                                </span>
                            </div>
                            <div class="col-xs-3">
                                <input ng-model="sort" type="checkbox" id="c67" value="تابستان" name="season[]"/>
                                <label for="c67">
                                    <span></span>
                                </label>
                                <span class="tourTypeChoseTourCreation">
                                    تابستان
                                </span>
                            </div>
                            <div class="col-xs-3">
                                <input ng-model="sort" type="checkbox" id="c68" value="پاییز" name="season[]"/>
                                <label for="c68">
                                    <span></span>
                                </label>
                                <span class="tourTypeChoseTourCreation">
                                    پاییز
                                </span>
                            </div>
                            <div class="col-xs-3">
                                <input ng-model="sort" type="checkbox" id="c69" value="زمستان" name="season[]"/>
                                <label for="c69">
                                    <span></span>
                                </label>
                                <span class="tourTypeChoseTourCreation">
                                    زمستان
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ui_container">
                <button id="goToSecondStep" class="btn nextStepBtnTourCreation" type="submit">گام بعدی</button>
            </div>
        </form>
    </div>

    <div id="chooseSrcModal" class="modalBack" style="display: none;">
        <div id="addNewDestinationBoxTourCreation">
            <div id="addNewDestinationTitleTourCreation">
                انتخاب شهر مبدا
            </div>
            <div class="inputBoxGeneralInfo inputBox InlineTourInputBoxes" id="tourOriginStateInputBox">
                <div class="inputBoxTextGeneralInfo inputBoxText">
                    <div>
                        استان
                        <span>*</span>
                    </div>
                </div>
                <select class="inputBoxInput" onchange="findCity(this.value)">
                    <option value="0">
                        استان
                    </option>
                    @for($i = 0; $i < count($states); $i++)
                        <option value="{{$states[$i]->id}}">
                            {{$states[$i]->name}}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="inputBoxGeneralInfo inputBox InlineTourInputBoxes" id="tourNewOriginInputBox" style="width: 200px; position: relative">
                <div class="inputBoxTextGeneralInfo inputBoxText">
                    <div>
                        نام شهر
                        <span>*</span>
                    </div>
                </div>
                <input id="srcCityInput" class="inputBoxInput" type="text" placeholder="فارسی" onkeyup="chooseCity(this.value, 'srcCityShow', 0)" style="min-width: 120px;">
                <div id="srcCityShow" style="position: relative; float: left; width: 100%; text-align: center;"></div>
            </div>

            <div>
                <div class="popUpButtons display-inline-block">
                    <div class="ui_container addNewDestinationBtn">
                        <button id="verifyNewDestinationTourCreation">
                            <img src="{{URL::asset('images/tourCreation/approve.png')}}">
                        </button>
                    </div>
                    <div class="ui_container addNewDestinationBtn">
                        <button id="closeNewDestinationTourCreation" onclick="$('#chooseSrcModal').toggle()">
                            <img src="{{URL::asset('images/tourCreation/close.png')}}">
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="modalAddNewDestinationBoxTourCreation" class="modalBack" style="display: none;">
        <div id="addNewDestinationBoxTourCreation">
            <div id="addNewDestinationTitleTourCreation">
                اضافه کردن مکان جدید
            </div>
            <div class="inputBoxGeneralInfo inputBox InlineTourInputBoxes" id="tourNewOriginInputBox">
                <div class="inputBoxTextGeneralInfo inputBoxText">
                    <div>
                        نام
                        <span>*</span>
                    </div>
                </div>
                <input class="inputBoxInput" type="text" placeholder="فارسی">
            </div>
            <div class="inputBoxGeneralInfo inputBox InlineTourInputBoxes" id="tourOriginStateInputBox">
                <div class="inputBoxTextGeneralInfo inputBoxText">
                    <div>
                        استان
                        <span>*</span>
                    </div>
                </div>
                <input class="inputBoxInput" type="text" placeholder="انتخاب از بین گزینه ها">
            </div>
            <div>
                <div class="btn-group btn-group-toggle display-inline-block" data-toggle="buttons">
                    <label class="btn btn-secondary">
                        <input type="radio" name="options" id="option1" autocomplete="off">جاذبه
                    </label>
                    <label class="btn btn-secondary active">
                        <input type="radio" name="options" id="option2" autocomplete="off" checked>شهر
                    </label>
                </div>
                <div class="popUpButtons display-inline-block">
                    <div class="ui_container addNewDestinationBtn">
                        <button id="verifyNewDestinationTourCreation">
                            <img src="{{URL::asset('images/tourCreation/approve.png')}}">
                        </button>
                    </div>
                    <div class="ui_container addNewDestinationBtn">
                        <button id="closeNewDestinationTourCreation" onclick="$('#modalAddNewDestinationBoxTourCreation').toggle()">
                            <img src="{{URL::asset('images/tourCreation/close.png')}}">
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="tourKindDescriptionModal" class="modalBack" style="display: none;">
        <div class="popUpsSpecificInfoTourCreation">
            <div class="fullwidthDiv pd-bt-15 border-bt-1-lightgrey">
                <div class="addPlaceGeneralInfoTitleTourCreation">
                    انواع تور
                </div>
                <span class="closePopUpBtn glyphicon glyphicon-remove" onclick="$('#tourKindDescriptionModal').toggle()" style="cursor: pointer"></span>
            </div>
            <div class="fullwidthDiv color-darkred">
                شهرگردی
            </div>
            <div class="fullwidthDiv pd-bt-15 border-bt-1-lightgrey">

            </div>
        </div>
    </div>

    <div id="tourDifficultDescriptionModal" class="modalBack" style="display: none;">
        <div class="popUpsSpecificInfoTourCreation">
            <div class="fullwidthDiv pd-bt-15 border-bt-1-lightgrey">
                <div class="addPlaceGeneralInfoTitleTourCreation">
                    انواع تور
                </div>
                <span class="closePopUpBtn glyphicon glyphicon-remove" onclick="$('#tourDifficultDescriptionModal').toggle()" style="cursor: pointer"></span>
            </div>
            <div class="fullwidthDiv color-darkred">
                آسان
            </div>
            <div class="fullwidthDiv pd-bt-15 border-bt-1-lightgrey">

            </div>
        </div>
    </div>

    @include('layouts.footer.layoutFooter')
</div>

<script src="{{URL::asset('js/tour/create/stageOne.js')}}"></script>

    <script>
        var searchForCity = '{{route("searchForCity")}}';
        var findCityWithState = '{{route("findCityWithState")}}';
        var _token = '{{csrf_token()}}';
        @for($i = 0; $i < count($tourKind); $i++)
            @if($tourKind[$i]->name == 'محلی')
                var mahali_id = '{{$tourKind[$i]->id}}';
            @elseif($tourKind[$i]->name == 'شهرگردی')
                var shahr_id = '{{$tourKind[$i]->id}}';
            @endif
        @endfor

    </script>
</body>
</html>
