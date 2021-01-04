@extends('pages.tour.create.createTourLayout')

@section('head')
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

    <div class="ui_container">
        <div class="menu ui_container whiteBox">
            @for($i = 0; $i < $tour->day; $i++)
                <div class="dateRow">
                    <div class="headerSec" onclick="openDatePlanRow(this)">
                        <div class="title">برنامه روز {{$i + 1}}</div>
                        <div class="sumInfos"></div>
                        <div class="downArrowIcon"></div>
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
                                    برنامه روز :
                                    <button type="button" class="plus" onclick="addEventTo({{$i}})"></button>
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
                                <textarea id="dateDescription_{{$i}}" class="form-control" rows="5" placeholder="شما می توانید خلاصه ای از روز خود را انیجا یادداشت کنید..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>

        <div class="row" style="padding: 15px;">
            <button class="btn nextStepBtnTourCreation" type="button" onclick="checkInput()">گام بعدی</button>
        </div>
    </div>

    <div id="addNewEventModal" class="modalBlackBack fullCenter notCloseOnClick eventModal" style="z-index: 9999;">
        <div class="modalBody" style="width: 600px;">

            <input type="hidden" id="newEventTo">

            <div onclick="closeMyModal('addNewEventModal')" class="iconClose closeModal"></div>

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
                <button class="btn btn-default" onclick="closeMyModal('addNewEventModal')">بستن</button>
            </div>
        </div>
    </div>

    <div id="editEventModal" class="modalBlackBack fullCenter notCloseOnClick eventModal" style="z-index: 9999;">
        <div class="modalBody" style="width: 600px;">

            <input type="hidden" id="editDay">
            <input type="hidden" id="editIndex">

            <div onclick="closeMyModal('editEventModal')" class="iconClose closeModal"></div>

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
                <button class="btn btn-default" onclick="closeMyModal('editEventModal')" style="margin-right: 10px;">بستن</button>
                <button class="btn btn-default" onclick="deleteThisEvent()" style="color: white; background: red; margin-right: auto;">حذف برنامه</button>
            </div>
        </div>
    </div>

    <div id="addHotelModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body" style="direction: rtl">
                    <div class="fullwidthDiv">
                        <div class="addPlaceGeneralInfoTitleTourCreation">هتل مورد نظر خود را اضافه کنید</div>
                        <button type="button" class="closee" data-dismiss="modal" style="border: none; background: none; float: left">&times;</button>
                    </div>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="placeNameAddingPlaceInputDiv inputBoxTour col-xs-12 relative-position">
                                <div class="inputBoxText">
                                    <div> نام هتل</div>
                                </div>
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
            <div class="cancelPlace iconClose" data-index="##index##" onclick="deleteThisPlace(this)"></div>
            <div class="imgSec">
                <img src="##pic##" class="resizeImgClass" onload="fitThisImg(this)">
            </div>
            <div>
                <div class="name">##name##</div>
                <div class="text">##stateAndCity##</div>
            </div>
        </div>
    </div>

    <script>
        var dateCount = {{$tour->day}};

        var openedDateEvent = 0;
        var searchEventPlaceKind = null;
        var planDate = [];
        var eventType = {!! $tourScheduleKinds !!};

        var searchResults = [];
        var ajaxProcess = null;
        var placeCardSample = $('#choosePlaceSample').html();
        $('#choosePlaceSample').remove();

        var clockOptions = {
            placement: 'left',
            donetext: 'تایید',
            autoclose: true,
        };

        for(var i = 0; i < dateCount; i++)
            planDate[i] = {
                hotelId: 0,
                description: '',
                events: []
            };


        $(window).ready(() => {
            $('.clockP').clockpicker(clockOptions);

            var text = '';
            eventType.map(item => text += `<div class="eventItem" onclick="chooseThisItem(this, ${item.code})">
                                            <div class="text">${item.name}</div>
                                            <div class="icon"></div>
                                        </div>`);
            $('#eventTitles').html(text);
        });

        function openDatePlanRow(_element){
            $('.dateRow').find('.bodySec').removeClass('open');
            $(_element).next().toggleClass('open');
        }

        function addEventTo(_day){
            $('#newEventTo').val(_day);

            $('#descriptionOfNewEvent').val('');
            $('#optBody').find('input').val('');

            $('.eventItem').removeClass('select');
            $('.optbodies').addClass('hidden');
            $('.choosedPlace').empty();
            $('.clockP').val('');

            openedDateEvent = _day;
            openMyModal('addNewEventModal');
        }

        function chooseThisItem(_element, _kind){
            $('.eventItem').removeClass('select');
            $(_element).addClass('select');

            $('.optbodies').addClass('hidden');
            $('#optBod'+_kind).removeClass('hidden');

            eventType.map((ev, index) => {
                if(ev.code == _kind)
                    searchEventPlaceKind = index;
            });
        }

        function searchForPlaces(_element, _kindPlaceId){
            _element = $(_element);
            var value = _element.val();
            _element.next().empty();
            if(value.trim().length > 1){
                searchResults = [];
                if(ajaxProcess != null)
                    ajaxProcess.abort();

                ajaxProcess = $.ajax({
                    type: 'GET',
                    url: '{{route("search.place.with.name.kindPlaceId")}}?kindPlaceId='+_kindPlaceId+'&value='+value,
                    success: response => {
                        if(response.status == 'ok'){
                            var text = '';
                            searchResults = response.result;
                            searchResults.map((item, index) => {
                                item.stateAndCity = (item.state && item.city) ? `استان ${item.state.name} شهر ${item.city.name}` : '';
                                text += `<div class="res" data-index="${index}" onclick="chooseThisPlaceForDate(this, ${_kindPlaceId})">${item.name}</div>`
                            });
                            _element.next().html(text);
                        }
                    }
                })
            }
        }
        function chooseThisPlaceForDate(_element, _kind){
            _element = $(_element);

            var index = _element.attr('data-index');
            createPlaceCardForSelect(searchResults[index], _element.parent().parent().parent().find('.choosedPlace'));

            _element.parent().prev().val('');
            _element.parent().empty();
        }
        function createPlaceCardForSelect(_place, _resultSec){
            var text = placeCardSample;
            var fn = Object.keys(_place);
            for(var x of fn)
                text = text.replace(new RegExp(`##${x}##`, 'g'), _place[x]);

            text = text.replace(new RegExp(`##dateIndex##`, 'g'), openedDateEvent);

            _resultSec.append(text);
        }
        function deleteThisPlace(_element){
            $(_element).parent().remove();
        }

        function doAddEvent(){
            var startTime = $('#startTimeEvent').val();
            var endTime = $('#endTimeEvent').val();
            var code = eventType[searchEventPlaceKind].code;
            var errorText = '';
            var error = false;

            if(startTime.trim().length != 5 || endTime.trim().length != 5){
                alert('پر کردن زمان برنامه اجباری است');
                return;
            }

            if(startTime.trim() >= endTime.trim()){
                alert('زمان شروع باید قبل از زمان پایان باشد.');
                return;
            }

            planDate[openedDateEvent].events.map(item =>{
                if((item.sTime < endTime && item.eTime > endTime) ||
                    (item.sTime < startTime && item.eTime > startTime) ||
                    (item.sTime > startTime && item.eTime < endTime)){
                    alert('زمان این برنامه با برنامه های دیگر روز مغایرت دارد...');
                    error = true;
                }
            });

            if(error)
                return;

            var datas = {
                eventIndex: searchEventPlaceKind,
                eventCode: eventType[searchEventPlaceKind].code,
                sTime: startTime,
                eTime: endTime,
                moreData: '',
                description: $('#descriptionOfNewEvent').val(),
            };

            if(code == 1 || code == 4 || code == 5 || code == 6){
                datas.moreData = $(`#opt${code}Name`).val();
            }
            else if(code == 3 || code == 7){
                var ids = [];
                var placesSec = $('#optBod'+code).find('.placeCar');
                for(var i = 0; i < placesSec.length; i++){
                    ids.push({
                        id: $($(placesSec[i])[0]).attr('data-placeId'),
                        kindPlaceId: $($(placesSec[i])[0]).attr('data-kindPlaceId'),
                        pic: $($(placesSec[i])[0]).find('img').attr('src'),
                        name: $($(placesSec[i])[0]).find('.name').text(),
                        stateAndCity: $($(placesSec[i])[0]).find('.text').text(),
                    });
                }
                datas.moreData = ids;
            }

            planDate[openedDateEvent].events.push(datas);

            searchEventPlaceKind = null;
            addNewEventToDayCalendar();
            closeMyModal('addNewEventModal');
        }

        function editThisDetail(_day, _index){
            openedDateEvent = _day;
            var editData = planDate[_day].events[_index];
            var event = eventType[editData.eventIndex];

            $('#editDay').val(_day);
            $('#editIndex').val(_index);

            $('#editEventTitle').text(event.name);
            $('#startTimeEventEdit').val(editData.sTime);
            $('#endTimeEventEdit').val(editData.eTime);
            $('#editBody').empty().html($('#optBod'+event.code).html());

            $('#descriptionOfEditEvent').val(editData.description);
            if(event.code == 1 || event.code == 4 || event.code == 5 || event.code == 6)
                $('#editBody').find('input').val(editData.moreData);
            else if(event.code == 3 || event.code == 7){
                $('#editBody').find('.choosedPlace').empty();
                editData.moreData.map(item => createPlaceCardForSelect(item, $('#editBody').find('.choosedPlace')));
            }
            openMyModal('editEventModal');
        }
        function doEditEvent(){
            var day = $('#editDay').val();
            var index = $('#editIndex').val();

            var startTime = $('#startTimeEventEdit').val();
            var endTime = $('#endTimeEventEdit').val();

            var event = planDate[day].events[index];
            var code = eventType[event.eventIndex].code;
            var error = false;

            if(startTime.trim().length != 5 || endTime.trim().length != 5){
                alert('پر کردن زمان برنامه اجباری است');
                return;
            }

            if(startTime.trim() >= endTime.trim()){
                alert('زمان شروع باید قبل از زمان پایان باشد.');
                return;
            }

            planDate[openedDateEvent].events.map((item , index) =>{
                if(index != index) {
                    if ((item.sTime < endTime && item.eTime > endTime) ||
                        (item.sTime < startTime && item.eTime > startTime) ||
                        (item.sTime > startTime && item.eTime < endTime)) {
                        alert('زمان این برنامه با برنامه های دیگر روز مغایرت دارد...');
                        error = true;
                    }
                }
            });

            if(error)
                return;

            event.description = $('#descriptionOfEditEvent').val();

            if(code == 1 || code == 4 || code == 5 || code == 6)
                event.moreData = $('#editBody').find('input').val();
            else if(code == 3 || code == 7){
                var ids = [];
                var placesSec = $('#editBody').find('.placeCar');
                for(var i = 0; i < placesSec.length; i++){
                    ids.push({
                        id: $($(placesSec[i])[0]).attr('data-placeId'),
                        kindPlaceId: $($(placesSec[i])[0]).attr('data-kindPlaceId'),
                        pic: $($(placesSec[i])[0]).find('img').attr('src'),
                        name: $($(placesSec[i])[0]).find('.name').text(),
                        stateAndCity: $($(placesSec[i])[0]).find('.text').text(),
                    });
                }
                event.moreData = ids;
            }

            event.sTime = startTime;
            event.eTime = endTime;
            planDate[day].events[index] = event;

            addNewEventToDayCalendar();
            closeMyModal('editEventModal');
        }

        function deleteThisEvent(){
            var day = $('#editDay').val();
            var index = $('#editIndex').val();
            $(`#detailPlan_${day}_${index}`).remove();
            planDate[day].events.splice(index, 1);
            closeMyModal('editEventModal');
        }
        function addNewEventToDayCalendar(){
            var allDay = 24 * 60;
            var text = '';
            planDate[openedDateEvent].events.map((item, index) => {
                var sTime = item.sTime.split(':');
                var eTime = item.eTime.split(':');

                var sMinutes = parseInt(sTime[0])*60 + parseInt(sTime[1]);
                var eMinutes = parseInt(eTime[0])*60 + parseInt(eTime[1]);

                var width = ((eMinutes - sMinutes)/allDay) * 100;
                var startPos = (sMinutes/allDay) * 100;
                var event = eventType[item.eventIndex];

                text += `<div id="detailPlan_${openedDateEvent}_${index}" class="detail" style="width: ${width}%; right: ${startPos}%; background: ${event.color}" onclick="editThisDetail(${openedDateEvent}, ${index})">${event.name}</div>`;
            });
            $('#planRow_'+openedDateEvent).html(text);

            openedDateEvent = 0;
        }

        function chooseHotel(_day){
            $('#dayForHotelModal').val(_day);
            $('#inputSearchHotel').val('');
            $('#addHotelModal').modal('show');
        }
        function searchForHotel(_element){
            var value = $(_element).val();
            if(ajaxProcess != null)
                ajaxProcess.abort();

            if(value.trim().length > 1){
                ajaxProcess = $.ajax({
                    type: 'GET',
                    url: '{{route("search.place.with.name.kindPlaceId")}}?value='+value+'&kindPlaceId=4',
                    success: response => {
                        if(response.status == 'ok') {
                            var text = '';
                            searchResults = response.result;
                            searchResults.map((item, key) => text += `<div class="searchHover blue" data-index="${key}" onclick="chooseThisHotel(this)" >${item.name} در ${item.state.name} , ${item.city.name}</div>`);
                            $(_element).next().html(text);
                        }
                    }
                });
            }
        }
        function chooseThisHotel(_element){
            var index = $(_element).attr('data-index');
            var day = $('#dayForHotelModal').val();
            $(_element).parent().empty();
            $('#inputSearchHotel').val('');

            planDate[day].hotelId = searchResults[index].id;

            $('#answerForSubmitLastHotel_'+day).addClass('hidden');
            $('#hotelImgForDay_'+day).attr('src', searchResults[index].pic);
            $('#hotelNameForDay_'+day).text(searchResults[index].name);
            $('#hotelCityForDay_'+day).text(`استان ${searchResults[index].state.name} شهر ${searchResults[index].city.name}`);
            $('#hotelAddressForDay_'+day).text(searchResults[index].address);

            for(var i = parseInt(day)+1; i < dateCount; i++){
                if(planDate[i].hotelId == 0) {
                    $('#hotelImgForDay_'+i).attr('src', searchResults[index].pic);
                    $('#hotelNameForDay_'+i).text(searchResults[index].name);
                    $('#hotelCityForDay_'+i).text(`استان ${searchResults[index].state.name} شهر ${searchResults[index].city.name}`);
                    $('#hotelAddressForDay_'+i).text(searchResults[index].address);

                    $('#answerForSubmitLastHotel_' + i).removeClass('hidden');
                    $('#lastHotelId_' + i).val(planDate[day].hotelId);
                }
                else
                    break;
            }

            $('#addHotelModal').modal('hide');
        }
        function submitThisHotel(_day){
            var hotelId = $('#lastHotelId_'+_day).val();
            $('#answerForSubmitLastHotel_'+_day).addClass('hidden');
            planDate[_day].hotelId = parseInt(hotelId);
        }

        function checkInput(){
            var error = false;
            var errorText = '';

            if(error){

            }
            else{
                planDate.map((item, index) => {
                    item.description = $('#dateDescription_'+index).val();
                });

                submitSchedule();
            }
        }

        function submitSchedule(){
            openLoading();

            $.ajax({
                type: 'POST',
                url: "{{route('tour.create.stage.two.store')}}",
                data: {
                    _token: '{{csrf_token()}}',
                    tourId: '{{$tour->id}}',
                    planDate: JSON.stringify(planDate),
                },
                success: response =>{
                    if(response.status == 'ok')
                        location.href = '{{route("tour.create.stage.three", ['id' => $tour->id])}}';
                }
            })
        }

    </script>

@endsection
