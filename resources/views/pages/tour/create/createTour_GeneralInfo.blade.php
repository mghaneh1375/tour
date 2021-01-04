@extends('pages.tour.create.createTourLayout')

@section('head')
    <style>
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
    </style>
@endsection

@section('body')
    <form id="form" method="post" action="{{route('tour.create.stage.one.store')}}" autocomplete="off">
        {!! csrf_field() !!}

        <div class="ui_container">
            <div class="menu ui_container whiteBox">
                <div id="tourNameInputBoxMainDiv">
                    <div class="inputBoxGeneralInfo inputBoxTour" id="tourNameInputBox">
                        <div class="inputBoxTextGeneralInfo inputBoxText">
                            <div>
                                نام تور
                                <span>*</span>
                            </div>
                        </div>
                        <input id="tourName" class="inputBoxInput" type="text" name="name" placeholder="فارسی" value="{{isset($tour->name) ? $tour->name : ''}}" required>
                    </div>
                </div>
                <span class="inboxHelpSubtitle">
                            با وارد کردن نام شهر گزینه‌های موجود نمایش داده می‌شود تا از بین آن‌ها انتخاب نمایید. اگر نام شهر خود را نیافتید از گزینه‌ی اضافه کردن استفاده نمایید. توجه کنید اگر مبدأ یا مقصد شما جاذبه می‌باشد، آن را وارد نمایید.
                        </span>
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
                    <input type="checkbox" id="sameSrcDestIput" onchange="srcDest()"/>
                    <label for="sameSrcDestIput">
                        <span></span>
                    </label>
                    <span id="cityTourCheckBoxLabel">تور من شهرگردی است و مبدأ و مقصد آن یکی است.</span>
                </div>
            </div>

            <div class="menu ui_container whiteBox">
                <div class="boxTitlesTourCreation">
                    <span>روزهای تور</span>
                </div>
                <div class="inboxHelpSubtitle">تعداد روز و شب های تور خود را مشخص کنید.</div>
                <div class="row" style="display: flex; width: 100%">
                    <div class="inputBoxTour col-xs-3 mg-rt-10 relative-position float-right" style="margin-left: 10px; margin-right: 15px;">
                        <div class="inputBoxText" style="width: 200px;">
                            <div>
                                تعداد روزهای تور
                                <span>*</span>
                            </div>
                        </div>
                        <input name="tourDay" id="tourDay" class="inputBoxInput" type="number" min="0"/>
                    </div>
                    <div class="inputBoxTour col-xs-3 relative-position float-right">
                        <div class="inputBoxText" style="width: 220px;">
                            <div>
                                تعداد شب های تور
                                <span>*</span>
                            </div>
                        </div>
                        <input name="tourNight" id="tourNight" class="inputBoxInput" type="number" min="0" />
                    </div>
                </div>
            </div>

            <div class="menu ui_container whiteBox">
                <div class="boxTitlesTourCreation">نوع برگزاری</div>
                <div class="inboxHelpSubtitle">کدام یک از موارد زیر در مورد تور شما صادق است؟</div>

                <input id="c53" type="radio" name="tourTimeKind" value="notSameTime" onchange="changeTime(this.value)"/>
                <label for="c53" class="tourBasicKindsCheckbox">
                    <div>تور ما با برنامه‌ی زمانی نامنظم بیش از یک‌بار برگزار می‌گردد.</div>
                    <span class="tourBasicKindsCheckboxSpan mg-tp-5imp"></span>
                </label>

                <input id="c52" type="radio" name="tourTimeKind" value="sameTime" onchange="changeTime(this.value)"/>
                <label for="c52" class="tourBasicKindsCheckbox">
                    <div>تور ما با برنامه زمانی یکسان و منظم بیش از یکبار برگزار می‌گردد.</div>
                    <span class="tourBasicKindsCheckboxSpan mg-tp-5imp"></span>
                </label>

                <input id="c51" type="radio" name="tourTimeKind" value="oneTime" onchange="changeTime(this.value)" checked/>
                <label for="c51" class="tourBasicKindsCheckbox pd-40-30">
                    <div>تور ما فقط برای یکبار برگزار می‌گردد.</div>
                    <span class="tourBasicKindsCheckboxSpan"></span>
                </label>

                <div class="inboxHelpSubtitleBlue mg-tp-20">نیاز به راهنمایی دارید؟</div>


                <div class="boxTitlesTourCreation" style="margin-top: 20px; border-top: solid 1px lightgray; padding-top: 10px;">زمان برگزاری</div>
                {{--one time--}}
                <div id="oneTime">
                    <div class="inboxHelpSubtitle">تاریخ شروع و پایان تور خود را وارد نمایید. توجه کنید که ما این امکان را برای شما فراهم آوردیم تا با تعریف یکباره‌ی تور بتوانید بارهم از آن کپی گرفته و سریعتر تور خود را تعریف نمایید.</div>
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
                        <input name="eDate" id="eDate" class="observer-example inputBoxInput" readonly/>
                    </div>
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
                        <input name="sDate" id="sDate" class="observer-example inputBoxInput" type="text">
                    </div>
                </div>

                {{--same time--}}
                <div id="sameTime" style="display: none;">
                    <div class="inboxHelpSubtitle">روز شروع تور در هفته و مدت آن ثابت فرض می‌گردد و شما تنها می‌بایست دوره‌ی تکرار را برای تور مشخص کنید.</div>
                    <div class="inputBoxTour float-right col-xs-3">
                        <div class="inputBoxText">
                            <div>
                                دوره‌ی تکرار
                                <span>*</span>
                            </div>
                        </div>
                        <div class="select-side">
                            <i class="glyphicon glyphicon-triangle-bottom"></i>
                        </div>
                        <select class="inputBoxInput styled-select" name="priod" id="priod">
                            <option value="0">هفتگی</option>
                            <option value="1">هر دو هفته</option>
                            <option value="2">ماهیانه</option>
                            <option value="3">هر دو ماه یکبار</option>
                            <option value="4">هر فصل</option>
                        </select>
                    </div>
                </div>

                {{--not same time--}}
                <div id="notSameTime" style="display: none;">
                    <div class="inboxHelpSubtitle">
                        تاریخ شروع و پایان تور خود را وارد نمایید. توجه کنید که ما این امکان را برای شما فراهم آوردیم تا با تعریف یکباره‌ی تور بتوانید بارهم از آن کپی گرفته و سریعتر تور خود را تعریف نمایید.
                    </div>

                    <div id="notSameTimeCalendarDiv" style="display: flex; flex-direction: column">

                        <div id="calendar_1">
                            <div class="tourNthOccurrence">1</div>

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

            <div class="menu ui_container whiteBox">
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
                            <input class="inputBoxInput" type="number" name="minCapacity" id="minCapacity" placeholder="تعداد" min="0">
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
                            <input class="inputBoxInput" type="number" name="maxCapacity" id="maxCapacity" placeholder="تعداد" min="0">
                        </div>
                    </div>
                    <div class="fullwidthDiv">
                        <input type="checkbox" name="anyCapacity" id="anyCapacity" value="1"/>
                        <label for="anyCapacity"><span></span></label>
                        <span id="tourCapacityCheckbox">با هر ظرفیتی تور برگزار می شود.</span>
                    </div>
                </div>

                <div id="nonGovernmentalTitleTourCreation">
                    <span>آیا تور شما به صورت خصوصی برگزار می‌شود؟</span>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-secondary active">
                            <input type="radio" name="private" value="0" id="option1" autocomplete="off" onchange="changeTourKind('common')" checked>خیر
                        </label>
                        <label class="btn btn-secondary">
                            <input type="radio" name="private" value="1" id="option2" autocomplete="off" onchange="changeTourKind('private')">بلی
                        </label>
                    </div>
                    <div class="inboxHelpSubtitle" style="margin-bottom: 20px;">تورهای خصوصی برای گروه محدودی از مخاطبان برگزار می‌شوند و مخاطبا نمی‌توانند تجربه‌ای خصوصی داشته باشند.</div>
                </div>
            </div>

            <div class="row" style="padding: 15px;">
                <button class="btn nextStepBtnTourCreation" type="button" onclick="checkInput()">گام بعدی</button>
            </div>

        </div>

    </form>

    <div id="timeRowSample" class="hidden">
        <div id="calendar_##number##"><div class="tourNthOccurrence">##number##</div>
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
        });

        function changeTourKind(_kind){

            if(_kind == 'private'){
                $('#privateTour').removeClass('hidden');
                $('#commonTour').addClass('hidden');
            }
            else{
                $('#privateTour').addClass('hidden');
                $('#commonTour').removeClass('hidden');
            }
        }

        function changeTime(_value){
            tourKind = _value;
            if(_value == 'notSameTime'){
                $('#oneTime').hide();
                $('#sameTime').hide();
                $('#notSameTime').show();
            }
            else{
                $('#oneTime').show();
                $('#notSameTime').hide();
                if(_value == 'sameTime')
                    $('#sameTime').show();
                else
                    $('#sameTime').hide();
            }
        }

        function newCalendar(){
            var text = timeRowSample.replace(new RegExp('##number##', 'g'), calendarIndex);

            document.getElementById('deleteCalendar_' + (calendarIndex-1)).style.display = 'block';
            document.getElementById('newCalendar_' + (calendarIndex-1)).style.display = 'none';

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
            var value = document.getElementById('sameSrcDestIput').checked;
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
            var tourDay = $('#tourDay').val();
            var tourNight = $('#tourNight').val();
            var minCapacity = $('#minCapacity').val();
            var maxCapacity = $('#maxCapacity').val();
            var tourTimeKind = $('input[name="tourTimeKind"]:checked').val();

            var anyCapacity = $('#anyCapacity').prop('checked');

            var error = false;
            var errorText = '';

            if(tourName.trim().length < 2){
                errorText += '<li>نام تور خود را مشخص کنید.</li>';
                error = true;
            }

            if(!(srcCityId > 1)){
                errorText += '<li>مبدا تور خود را مشخص کنید.</li>';
                error = true;
            }

            if(!(destPlaceId > 1)){
                errorText += '<li>مقصد تور خود را مشخص کنید.</li>';
                error = true;
            }

            if(!(tourDay > 0)){
                errorText += '<li>تعداد روزهای تور خود را مشخص کنید.</li>';
                error = true;
            }

            if(!(tourNight > 0)){
                errorText += '<li>تعداد روزهای تور خود را مشخص کنید.</li>';
                error = true;
            }

            if(!anyCapacity) {
                if (!(minCapacity > 0)) {
                    errorText += '<li>حداقل ظرفیت تور خود را مشخص کنید.</li>';
                    error = true;
                }
                if (!(maxCapacity > 0)) {
                    errorText += '<li>حداکثر ظرفیت تور خود را مشخص کنید.</li>';
                    error = true;
                }
            }

            if(tourTimeKind == 'notSameTime'){
                var sRows = $('input[name="sDateNotSame[]"]');
                var eRows = $('input[name="eDateNotSame[]"]');

                for(var i = 0; i < sRows.length; i++){
                    if($(sRows[i]).val().trim().length != 0)
                        sDate = $(sRows[i]).val().trim();
                    if($(eRows[i]).val().trim().length != 0)
                        eDate = $(eRows[i]).val().trim();
                }
            }
            else{
                sDate = $('#sDate').val();
                eDate = $('#eDate').val();
            }

            if(sDate.trim().length == 0 || eDate.trim().length == 0){
                errorText += '<li>تاریخ تور را مشخص کنید.</li>';
                error = true;
            }

            if(error){
                errorText = `<ul class="errorList">${errorText}</ul>`;
                openErrorAlert(errorText);
            }
            else
                $('#form').submit();
        }
    </script>

@endsection
