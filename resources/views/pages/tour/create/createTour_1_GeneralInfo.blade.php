@extends('pages.tour.create.layout.createTour_Layout')

@section('head')
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
    </style>

    <script src="{{URL::asset('js/jalali.js')}}"></script>
@endsection

@section('body')

    @include('pages.tour.create.layout.createTour_Header', ['createTourStep' => 1])

    <form id="form" method="post" action="{{route('tour.create.stage.one.store')}}" autocomplete="off">
        {!! csrf_field() !!}

        <input type="hidden" id="tourId" name="id" value="0">

        <div class="ui_container">
            <div class="whiteBox">
                <div id="tourNameInputBoxMainDiv">
                    <div class="inputBoxGeneralInfo inputBoxTour" id="tourNameInputBox">
                        <div class="inputBoxTextGeneralInfo inputBoxText">
                            <div>
                                نام تور
                                <span>*</span>
                            </div>
                        </div>
                        <input id="tourName" class="inputBoxInput" type="text" name="name" placeholder="فارسی" required>
                    </div>
                </div>
                <div class="inboxHelpSubtitle" style="width: 100%;">با وارد کردن نام شهر گزینه‌های موجود نمایش داده می‌شود تا از بین آن‌ها انتخاب نمایید. اگر نام شهر خود را نیافتید از گزینه‌ی اضافه کردن استفاده نمایید. توجه کنید اگر مبدأ یا مقصد شما جاذبه می‌باشد، آن را وارد نمایید.</div>
                <div class="InlineTourInputBoxesMainDiv">
                    <div class="inputBoxGeneralInfo inputBoxTour InlineTourInputBoxes" id="tourOriginInputBox">
                        <div class="inputBoxTextGeneralInfo inputBoxText">
                            <div>
                                مبدا تور
                                <span>*</span>
                            </div>
                        </div>
                        <input class="inputBoxInput" id="srcCity" type="text" placeholder="فارسی" readonly onclick="chooseSrcCityModal()" value="{{isset($tour->srcId) ? $tour->srcId : ''}}">
                        <input id="srcCityId" type="hidden" name="src" value="{{isset($tour->srcId) ? $tour->srcId : ''}}">
                    </div>
                </div>
                <div id="destDiv" class="InlineTourInputBoxesMainDiv">
                    <div class="inputBoxGeneralInfo inputBoxTour InlineTourInputBoxes tourDestinationInputBox">
                        <div class="inputBoxTextGeneralInfo inputBoxText">
                            <div>
                                مقصد تور
                                <span>*</span>
                            </div>
                        </div>
                        <input id="destInput" type="text" class="inputBoxInput" placeholder="فارسی" onclick="chooseDestModal()" readonly>
                        <input id="destPlaceId" type="hidden" name="destId">
                        <input id="destKind" type="hidden" name="destKind">
                    </div>
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
                    <div class="inputBoxTour col-xs-3 mg-rt-10 relative-position float-right" style="margin-left: 10px; margin-right: 15px;">
                        <div class="inputBoxText" style="width: 200px;">
                            <div>
                                تعداد روزهای تور
                                <span>*</span>
                            </div>
                        </div>
                        <input name="tourDay" id="tourDay" class="inputBoxInput" type="text"/>
                    </div>
                    <div class="inputBoxTour col-xs-3 relative-position float-right">
                        <div class="inputBoxText" style="width: 220px;">
                            <div>
                                تعداد شب های تور
                                <span>*</span>
                            </div>
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
                            <div class="inputBoxTour col-xs-3 relative-position float-right" style="margin-right: 60px;">
                                <div class="inputBoxText">
                                    <div>
                                        تاریخ شروع
                                        <span>*</span>
                                    </div>
                                </div>
                                <div class="select-side calendarIconTourCreation">
                                    <i class="ui_icon calendar calendarIcon"></i>
                                </div>
                                <input name="sDateNotSame[]" id="sDate_0" class="observer-example inputBoxInput" type="text">
                            </div>

                            <div class="inputBoxTour col-xs-3 mg-rt-10 relative-position float-right">
                                <div class="inputBoxText">
                                    <div>
                                        تاریخ پایان
                                        <span>*</span>
                                    </div>
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
                            <div class="inputBoxTour col-xs-3 relative-position float-right">
                                <div class="inputBoxText">
                                    <div>
                                        تاریخ شروع
                                        <span>*</span>
                                    </div>
                                </div>
                                <div class="select-side calendarIconTourCreation">
                                    <i class="ui_icon calendar calendarIcon"></i>
                                </div>
                                <input name="sDateNotSame[]" id="sDate_1" class="observer-example inputBoxInput" type="text">
                            </div>
                            <div class="inputBoxTour col-xs-3 mg-rt-10 relative-position float-right">
                                <div class="inputBoxText">
                                    <div>
                                        تاریخ پایان
                                        <span>*</span>
                                    </div>
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
                    <div class="col-xs-4 float-right">
                        <div class="inputBoxTour">
                            <div class="inputBoxText" style="width: 140px">
                                <div>
                                    حداقل ظرفیت
                                    <span>*</span>
                                </div>
                            </div>
                            <input class="inputBoxInput" type="text" name="minCapacity" id="minCapacity" placeholder="تعداد">
                        </div>
                    </div>
                    <div class="col-xs-4 float-right">
                        <div class="inputBoxTour">
                            <div class="inputBoxText" style="width: 140px">
                                <div>
                                    حداکثر ظرفیت
                                    <span>*</span>
                                </div>
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
                        <label class="btn btn-secondary active">
                            <input type="radio" name="private" value="0" id="option1" autocomplete="off" checked>خیر
                        </label>
                        <label class="btn btn-secondary">
                            <input type="radio" name="private" value="1" id="option2" autocomplete="off">بلی
                        </label>
                    </div>
                    <div class="inboxHelpSubtitle" style="margin-bottom: 20px; width: 100%">تورهای خصوصی برای گروه محدودی از مخاطبان برگزار می‌شوند و مخاطبا نمی‌توانند تجربه‌ای خصوصی داشته باشند.</div>
                </div>
            </div>

            <div class="whiteBox">
                <div class="boxTitlesTourCreation">اطلاعات مورد نیاز از مسافر</div>
                <div class="inboxHelpSubtitle">در این بخش شما می توانید تایین کنید از مسافران خود چه اطلاعاتی را نیاز دارید</div>
                <div>
                    <div style="font-weight: bold; margin-top: 10px;">برای صدور بلیت تور به چه اطلاعاتی از مسافران نیاز دارید؟</div>
                    <div>
                        <input type="checkbox" id="userInfoNeed_faName" name="userInfoNeed[]" value="faName" checked/>
                        <label for="userInfoNeed_faName" class="personInfosLabel">
                            <span></span>
                            <div>نام و نام خانوادگی فارسی</div>
                        </label>

                        <input type="checkbox" id="userInfoNeed_enName" name="userInfoNeed[]" value="enName" checked/>
                        <label for="userInfoNeed_enName" class="personInfosLabel">
                            <span></span>
                            <div>نام و نام خانوادگی انگلیسی</div>
                        </label>

                        <input type="checkbox" id="userInfoNeed_meliCode" name="userInfoNeed[]" value="meliCode" checked/>
                        <label for="userInfoNeed_meliCode" class="personInfosLabel">
                            <span></span>
                            <div>کد ملی</div>
                        </label>

                        <input type="checkbox" id="userInfoNeed_sex" name="userInfoNeed[]" value="sex" checked/>
                        <label for="userInfoNeed_sex" class="personInfosLabel">
                            <span></span>
                            <div>جنسیت</div>
                        </label>

                        <input type="checkbox" id="userInfoNeed_birthDay" name="userInfoNeed[]" value="birthDay" checked/>
                        <label for="userInfoNeed_birthDay" class="personInfosLabel">
                            <span></span>
                            <div>تاریخ تولد</div>
                        </label>

                        <input type="checkbox" id="userInfoNeed_country" name="userInfoNeed[]" value="country" checked/>
                        <label for="userInfoNeed_country" class="personInfosLabel">
                            <span></span>
                            <div>ملیت</div>
                        </label>

                        <input type="checkbox" id="userInfoNeed_passport" name="userInfoNeed[]" value="passport" checked/>
                        <label for="userInfoNeed_passport" class="personInfosLabel">
                            <span></span>
                            <div>اطلاعات پاسپورت</div>
                        </label>
                    </div>
                </div>

                <div class="nonGovernmentalTitleTourCreation" style="margin-top: 20px;">
                    <span>آیا اطلاعات تک تک مسافرین مورد نیاز است؟</span>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-secondary ">
                            <input type="radio" name="isAllUserInfo" value="0"  autocomplete="off" >خیر
                        </label>
                        <label class="btn btn-secondary active">
                            <input type="radio" name="isAllUserInfo" value="1" autocomplete="off" checked>بلی
                        </label>
                    </div>
                </div>

            </div>


            <div class="row" style="padding: 15px;">
                <button class="btn nextStepBtnTourCreation" type="button" onclick="checkInput()">گام بعدی</button>
            </div>

        </div>

    </form>

    <div id="timeRowSample" class="hidden">
        <div id="calendar_##number##" class="calendarRow">
            <div class="inputBoxTour col-xs-3 relative-position float-right">
                <div class="inputBoxText">
                    <div>
                        تاریخ شروع
                        <span>*</span>
                    </div>
                </div>
                <div class="select-side calendarIconTourCreation">
                    <i class="ui_icon calendar calendarIcon"></i>
                </div>
                <input name="sDateNotSame[]" id="sDate_##number##" class="observer-example inputBoxInput" type="text">
            </div>
            <div class="inputBoxTour col-xs-3 mg-rt-10 relative-position float-right">
                <div class="inputBoxText">
                    <div>
                        تاریخ پایان
                        <span>*</span>
                    </div>
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

    <script>
        var tour = {!! json_encode($tour) !!};
        var ajaxVar = null;
        var calendarIndex = 2;
        var timeRowSample = $('#timeRowSample').html();
        $('#timeRowSample').remove();

        var datePickerOptions = {
            numberOfMonths: 1,
            showButtonPanel: true,
            language: 'fa',
            dateFormat: "yy/mm/dd"
        };

        $(window).ready(() => {
            $('.observer-example').datepicker(datePickerOptions);

            $('.tourBasicKindsCheckbox').mouseenter(() => $(this).addClass('green-border'));
            $('.tourBasicKindsCheckbox').mouseleave(() => $(this).removeClass('green-border'));

            if(tour != null)
                fullDataInFields();
        });

        function newCalendar(){
            var text = timeRowSample.replace(new RegExp('##number##', 'g'), calendarIndex);

            if((calendarIndex-1) > 0){
                document.getElementById('deleteCalendar_' + (calendarIndex-1)).style.display = 'block';
                document.getElementById('newCalendar_' + (calendarIndex-1)).style.display = 'none';
            }

            $('#notSameTimeCalendarDiv').append(text);

            $(`#eDate_${calendarIndex}`).datepicker(datePickerOptions);
            $(`#sDate_${calendarIndex}`).datepicker(datePickerOptions);
            calendarIndex++;
        }

        function deleteCalendar(_index){
            $('#calendar_' + _index).remove();
        }

        function chooseSrcCityModal(){
            $('#addCityModal').modal('show');
        }
        function searchForCity(_element){
            var stateId = $('#selectStateForSelectCity').val();
            var value = $(_element).val().trim();
            var citySrcInput = $(_element);
            citySrcInput.next().empty();

            if(value.length > 1 && stateId != 0){
                if(ajaxVar != null)
                    ajaxVar.abort();

                ajaxVar = $.ajax({
                    type: 'GET',
                    url: `{{route("findCityWithState")}}?stateId=${stateId}&value=${value}`,
                    success: response =>{
                        if(response.status == 'ok'){
                            var text = '';
                            response.result.map(item => text += `<div class="searchHover blue" onclick="selectThisCityForSrc(this, ${item.id})">${item.name}</div>`);
                            citySrcInput.next().html(text);
                        }
                    }
                })
            }
        }
        function selectThisCityForSrc(_element, _id){
            $('#srcCity').val($(_element).text());
            $('#srcCityId').val(_id);
            $('#addCityModal').modal('hide');
            $(_element).parent().empty();

            if(document.getElementById('sameSrcDestInput').checked)
                $('#destPlaceId').val(_id);
        }

        function chooseDestModal(){
            $('#addDestinationModal').modal('show');
        }
        function searchForDestination(_element){
            var stateId = $('#selectStateForDestination').val();
            var kind = $('#selectDestinationKind').val();
            var value = $(_element).val().trim();
            var citySrcInput = $(_element);
            citySrcInput.next().empty();

            if(value.length > 1 && stateId != 0){
                if(ajaxVar != null)
                    ajaxVar.abort();

                var url = kind == 'city' ? `{{route("findCityWithState")}}?stateId=${stateId}&value=${value}` : `{{route("search.place.with.name.kindPlaceId")}}?value=${value}&kindPlaceId=6`;

                ajaxVar = $.ajax({
                    type: 'GET',
                    url,
                    success: response =>{
                        if(response.status == 'ok'){
                            var text = '';
                            response.result.map(item => text += `<div class="searchHover blue" onclick="selectThisForDest(this, ${item.id}, '${kind}')">${item.name}</div>`);
                            citySrcInput.next().html(text);
                        }
                    }
                })
            }
        }
        function selectThisForDest(_element, _id, _kind){
            $('#destInput').val($(_element).text());
            $('#destPlaceId').val(_id);
            $('#destKind').val(_kind);
            $(_element).parent().empty();
            $('#addDestinationModal').modal('hide');
        }

        function srcDest(){
            var value = document.getElementById('sameSrcDestInput').checked;
            document.getElementById('destDiv').style.display = value ? 'none' : 'inline-block';
            document.getElementById('destPlaceId').value = value ? document.getElementById('srcCityId').value : 0;
            document.getElementById('destKind').value = value ? 'city' : 'tabiatgardy';
            $('#destInput').val('');
        }

        function checkInput(){

            var sDate = '';
            var eDate = '';

            var tourName = $('#tourName').val();
            var srcCityId = $('#srcCityId').val();
            var destPlaceId = $('#destPlaceId').val();
            var tourDay = parseInt($('#tourDay').val());
            var tourNight = parseInt($('#tourNight').val());
            var minCapacity = parseInt($('#minCapacity').val());
            var maxCapacity = parseInt($('#maxCapacity').val());
            var isAllUserInfoNeed = $('input[name="isAllUserInfo"]:checked').val();

            var userInfoNeed = [];
            var userInfoNeedHtml = $('input[name="userInfoNeed[]"]:checked');
            for(var i = 0; i < userInfoNeedHtml.length; i++)
                userInfoNeed.push($(userInfoNeedHtml[i]).val());

            var anyCapacity = $('#anyCapacity').prop('checked');

            var errorText = '';

            if(tourName.trim().length < 2)
                errorText += '<li>نام تور خود را مشخص کنید.</li>';

            if(!(srcCityId >= 1))
                errorText += '<li>مبدا تور خود را مشخص کنید.</li>';

            if(!(destPlaceId >= 1))
                errorText += '<li>مقصد تور خود را مشخص کنید.</li>';

            if(!( Number.isInteger(tourDay) && tourDay >= 0))
                errorText += '<li>تعداد روزهای تور خود را مشخص کنید.</li>';

            if(!( Number.isInteger(tourNight) && tourNight >= 0))
                errorText += '<li>تعداد شب های تور خود را مشخص کنید.</li>';

            if(!anyCapacity) {
                if (!( Number.isInteger(minCapacity) && minCapacity >= 0))
                    errorText += '<li>حداقل ظرفیت تور خود را مشخص کنید.</li>';
                if (!( Number.isInteger(maxCapacity) && maxCapacity >= 0))
                    errorText += '<li>حداکثر ظرفیت تور خود را مشخص کنید.</li>';
            }

            var sRows = $('input[name="sDateNotSame[]"]');
            var eRows = $('input[name="eDateNotSame[]"]');

            for(var i = 0; i < sRows.length; i++){
                if($(sRows[i]).val().trim().length != 0 && $(eRows[i]).val().trim().length != 0){
                    eDate = $(eRows[i]).val().trim();
                    sDate = $(sRows[i]).val().trim();
                }
            }

            if(sDate.trim().length == 0 || eDate.trim().length == 0)
                errorText += '<li>تاریخ تور را مشخص کنید.</li>';


            if(userInfoNeed.length == 0)
                errorText += '<li>نمی توانید از مسافرین اطلاعاتی دریافت نکنید.</li>';


            if(errorText != ''){
                errorText = `<ul class="errorList">${errorText}</ul>`;
                openErrorAlert(errorText);
            }
            else
                $('#form').submit();
        }

        function fullDataInFields(){
            $('#tourId').val(tour.id);
            $('#tourName').val(tour.name);
            $('#srcCity').val(tour.src.name);
            $('#srcCityId').val(tour.src.id);

            $('#destInput').val(tour.dest.name);
            $('#destPlaceId').val(tour.dest.id);
            $('#destKind').val(tour.dest.kind);

            if(tour.isLocal)
                $('#sameSrcDestInput').click();

            $('#tourDay').val(tour.day);
            $('#tourNight').val(tour.night);

            $('#minCapacity').val(tour.minCapacity);
            $('#maxCapacity').val(tour.maxCapacity);
            if(tour.anyCapacity == 1)
                $('#anyCapacity').click();

            if(tour.private == 1){
                $('input[name="private"]').parent().removeClass('active');
                $('input[name="private"][value="1"]').prop('checked', true).parent().addClass('active');
            }

            for(var i = 0; i < tour.times.length-1; i++)
                newCalendar();

            for(i = 0; i < tour.times.length; i++){
                $(`#sDate_${i}`).val(tour.times[i].sDate);
                $(`#eDate_${i}`).val(tour.times[i].eDate);
            }

            $('input[name="isAllUserInfo"]').parent().removeClass('active');
            $(`input[name="isAllUserInfo"][value="${tour.allUserInfoNeed}"]`).prop('checked', true).parent().addClass('active');

            $('input[name="userInfoNeed[]"]').prop('checked', false);
            tour.userInfoNeed.map(item => $(`#userInfoNeed_${item}`).prop('checked', true));
        }

        function calculateDate(){
            var type = $('#calendarType').val();
            var count = $('#calendarCount').val();

            if(count > 0){
                $('#calendarCount').val('');
                calendarIndex = 1;
                var sDate = $('#sDate_0').val().split('/');
                var eDate = $('#eDate_0').val().split('/');

                var sGregorian = jalaliToGregorian(sDate[0], sDate[1], sDate[2]).join('/');
                var eGregorian = jalaliToGregorian(eDate[0], eDate[1], eDate[2]).join('/');

                var sFirstDay = new Date(sGregorian);
                var eFirstDay = new Date(eGregorian);

                $('.calendarRow').remove();

                for(var i = 1; i <= count; i++){
                    newCalendar();
                    var skip;
                    var sJalali = [];
                    var eJalali = [];

                    if(type == 'weekly' || type == 'twoWeek'){
                        skip = type == 'weekly' ? 1 : 2;

                        var sNext = new Date(sFirstDay.getTime() + 7 * 24 * 60 * 60 * 1000 * i * skip);
                        var eNext = new Date(eFirstDay.getTime() + 7 * 24 * 60 * 60 * 1000 * i * skip);

                        var sYear = sNext.getFullYear();
                        var eYear = eNext.getFullYear();

                        var sMonth = sNext.getMonth();
                        var eMonth = eNext.getMonth();

                        var sDay = sNext.getDate();
                        var eDay = eNext.getDate();

                        if(sMonth > 11){
                            sMonth = 0;
                            sYear++;
                        }
                        if(eMonth > 11){
                            eMonth = 0;
                            eYear++;
                        }

                        sJalali = gregorianToJalali(sYear, sMonth+1, sDay);
                        eJalali = gregorianToJalali(eYear, eMonth+1, eDay);
                    }
                    else{
                        skip = (type == 'monthly') ? 1 : 2;
                        sJalali = sDate;
                        eJalali = eDate;

                        sJalali[1] = parseInt(sJalali[1]) + (skip);
                        eJalali[1] = parseInt(eJalali[1]) + (skip);

                        if(sJalali[1] > 12){
                            sJalali[1] -= 12;
                            sJalali[0]++;
                        }
                        if(eJalali[1] > 12){
                            eJalali[1] -= 12;
                            eJalali[0]++;
                        }

                        if(parseInt(sJalali[1]) < 10)
                            sJalali[1] = '0'+parseInt(sJalali[1]);
                        if(parseInt(eJalali[1]) < 10)
                            eJalali[1] = '0'+parseInt(eJalali[1]);
                    }

                    $('#sDate_'+i).val(sJalali.join('/'));
                    $('#eDate_'+i).val(eJalali.join('/'));
                }
            }

        }
    </script>

@endsection
