<link rel='stylesheet' type='text/css' media='screen, print' href='{{URL::asset('css/theme2/hotelDetailsPopUp.css?v=1')}}'/>

<span id="addPlaceToTripPrompt"
      class="pop-up ui_overlay ui_modal find-location-modal-container fade_short fade_in hidden details-pop-up">
    <div class="body_text">
        <div>
            <div class="find_location_modal">
                <div class="rtl header_text">لیست سفر</div>
                <div class="ui_typeahead rtl">برای برنامه ریزی سفر، این مکان را به سفر خود اضافه کنید</div>
                <div class="ui_typeahead rtl" id="tripsForPlace"></div>
            </div>
        </div>
    </div>
    <div class="submitOptions rtl">
        <button onclick="assignPlaceToTrip()" class="btn btn-success">تایید</button>
        <input type="submit" onclick="hideElement('addPlaceToTripPrompt')" value="خیر" class="btn btn-default">
        <p id="errorAssignPlace"></p>
    </div>
    <div class="ui_close_x" onclick="hideElement('addPlaceToTripPrompt')"></div>
</span>

<div class="ui_backdrop dark" id="hotelDetailsPopUpDarkMode"></div>

<span id="rules" class="ui_overlay ui_modal editTags hidden">
    <div class="header_text">قبل از ارسال سوال و یا جواب به موارد زیر توجه کنید.</div>
    <div class="body_text">
        <ul>
            <li>سوال شما باید کاملا مرتبط به این مکان باشد و همچنین جواب شما می بایست کاملا مرتبط به سوال باشد.</li>
            <li>لینک، اطلاعات تماس و تبلیغات به طور کامل ممنوع می باشد.</li>
            <li>نام بردن از اشخاص حقیقی یا اطلاعات تماس آن ممنوع می باشد.</li>
            <li>اگر سوال شما در خصوص جزئیات یک مکان است شاید بهتر باشد با روابط عمومی آن مجموعه از طریق اطلاعات تماس، ارتباط برقرار کنید.</li>
        </ul>
    </div>
    <div onclick="$('#rules').addClass('hidden')" class="ui_close_x"></div>
</span>

<script>
    function writeFileName(val) {
        $("#fileName").empty().append(val);
    }
</script>

<span class='ui_overlay ui_popover arrow_right img_popUp hidden' id="lastSpanHotelDetailsPopUp"></span>

<script>
    {{--var getPlaceTrips = '{{route('placeTrips')}}';--}}
    {{--var assignPlaceToTripDir = '{{route('assignPlaceToTrip')}}';--}}
    {{--var hasLoginPopUp = {{auth()->check() ? 1 : 0}};--}}

    {{--var selectedPlaceId;--}}
    {{--var selectedKindPlaceId;--}}
    {{--function saveToTripPopUp(placeId, kindPlaceId) {--}}
    {{--    if (!hasLoginPopUp) {--}}
    {{--        showLoginPrompt(hotelDetailsInSaveToTripMode);--}}
    {{--        return;--}}
    {{--    }--}}
    {{--    selectedPlaceId = placeId;--}}
    {{--    selectedKindPlaceId = kindPlaceId;--}}

    {{--    $.ajax({--}}
    {{--        type: 'post',--}}
    {{--        url: '{{route('placeTrips')}}',--}}
    {{--        data: {--}}
    {{--            'placeId': placeId,--}}
    {{--            'kindPlaceId': kindPlaceId--}}
    {{--        },--}}
    {{--        success: function (response) {--}}
    {{--            selectedTrips = [];--}}
    {{--            $('.dark').show();--}}
    {{--            response = JSON.parse(response);--}}
    {{--            console.log(response)--}}

    {{--            var newElement = "<center class='row'>";--}}
    {{--            for (i = 0; i < response.length; i++) {--}}
    {{--                newElement += "<div class='addPlaceBoxes cursor-pointer' onclick='addToSelectedTrips(\"" + response[i].id + "\")'>";--}}
    {{--                if (response[i].select == "1") {--}}
    {{--                    newElement += "<div id='trip_" + response[i].id + "' onclick='' class='trip-images ui_columns is-gapless is-multiline is-mobile tripResponse'>";--}}
    {{--                    selectedTrips[selectedTrips.length] = response[i].id;--}}
    {{--                }--}}
    {{--                else--}}
    {{--                    newElement += "<div id='trip_" + response[i].id + "' onclick='' class='trip-images ui_columns is-gapless is-multiline is-mobile tripResponse'>";--}}
    {{--                if (response[i].placeCount > 0) {--}}
    {{--                    tmp = 'url("' + response[i].pic1 + '")';--}}
    {{--                    newElement += "<div class='trip-image ui_column is-6 bg-size-100-100' style='background: " + tmp + " repeat 0 0; background-size: 100% 100%'></div>";--}}
    {{--                }--}}
    {{--                else--}}
    {{--                    newElement += "<div class='trip-image trip-image-empty ui_column is-6 bg-color-grey'></div>";--}}
    {{--                if (response[i].placeCount > 1) {--}}
    {{--                    tmp = 'url("' + response[i].pic2 + '")';--}}
    {{--                    newElement += "<div class='trip-image ui_column is-6 bg-size-100-100' style='background: " + tmp + " repeat 0 0; background-size: 100% 100%'></div>";--}}
    {{--                }--}}
    {{--                else--}}
    {{--                    newElement += "<div class='trip-image trip-image-empty ui_column is-6 bg-color-grey'></div>";--}}
    {{--                if (response[i].placeCount > 1) {--}}
    {{--                    tmp = 'url("' + response[i].pic3 + '")';--}}
    {{--                    newElement += "<div class='trip-image ui_column is-6 bg-size-100-100' style='background: " + tmp + " repeat 0 0; background-size: 100% 100%'></div>";--}}
    {{--                }--}}
    {{--                else--}}
    {{--                    newElement += "<div class='trip-image trip-image-empty ui_column is-6 bg-color-grey'></div>";--}}
    {{--                if (response[i].placeCount > 1) {--}}
    {{--                    tmp = 'url("' + response[i].pic4 + '")';--}}
    {{--                    newElement += "<div class='trip-image ui_column is-6 bg-size-100-100' style='background: " + tmp + " repeat 0 0; background-size: 100% 100%'></div>";--}}
    {{--                }--}}
    {{--                else--}}
    {{--                    newElement += "<div class='trip-image trip-image-empty ui_column is-6 bg-color-grey'></div>";--}}
    {{--                newElement += "</div><div class='create-trip-text font-size-12em'>" + response[i].name + "</div>";--}}
    {{--                newElement += "</div>";--}}
    {{--            }--}}
    {{--            newElement += "<div class='addPlaceBoxes'>";--}}
    {{--            newElement += "<a onclick='showPopUp()' class='single-tile is-create-trip'>";--}}
    {{--            newElement += "<div class='tile-content text-align-center font-size-20Imp'>";--}}
    {{--            newElement += "<span class='ui_icon plus'></span>";--}}
    {{--            newElement += "<div class='create-trip-text'>ایجاد سفر</div>";--}}
    {{--            newElement += "</div></a></div>";--}}
    {{--            newElement += "</div>";--}}
    {{--            $("#tripsForPlace").empty().append(newElement);--}}
    {{--            showElement('addPlaceToTripPrompt');--}}
    {{--        }--}}
    {{--    });--}}
    {{--}--}}

    {{--function addToSelectedTrips(id) {--}}
    {{--    allow = true;--}}
    {{--    for (i = 0; i < selectedTrips.length; i++) {--}}
    {{--        if (selectedTrips[i] == id) {--}}
    {{--            allow = false;--}}
    {{--            $("#trip_" + id).css('border', '2px solid #a0a0a0');--}}
    {{--            selectedTrips.splice(i, 1);--}}
    {{--            break;--}}
    {{--        }--}}
    {{--    }--}}
    {{--    if (allow) {--}}
    {{--        $("#trip_" + id).css('border', '2px solid var(--koochita-light-green)');--}}
    {{--        selectedTrips[selectedTrips.length] = id;--}}
    {{--    }--}}
    {{--}--}}

    {{--function assignPlaceToTrip() {--}}
    {{--    if (selectedPlaceId != -1) {--}}
    {{--        var checkedValuesTrips = selectedTrips;--}}
    {{--        if (checkedValuesTrips == null || checkedValuesTrips.length == 0)--}}
    {{--            checkedValuesTrips = "empty";--}}
    {{--        $.ajax({--}}
    {{--            type: 'post',--}}
    {{--            url: assignPlaceToTripDir,--}}
    {{--            data: {--}}
    {{--                'checkedValuesTrips': checkedValuesTrips,--}}
    {{--                'placeId': selectedPlaceId,--}}
    {{--                'kindPlaceId': selectedKindPlaceId--}}
    {{--            },--}}
    {{--            success: function (response) {--}}
    {{--                if (response == "ok")--}}
    {{--                    alert('با موفقیت ثبت شد.')--}}
    {{--                else {--}}
    {{--                    err = "<p>به جز سفر های زیر که اجازه ی افزودن مکان به آنها را نداشتید بقیه به درستی اضافه شدند</p>";response = JSON.parse(response);--}}
    {{--                    for (i = 0; i < response.length; i++)--}}
    {{--                        err += "<p>" + response[i] + "</p>";--}}
    {{--                    $("#errorAssignPlace").append(err);--}}
    {{--                }--}}
    {{--            }--}}
    {{--        });--}}
    {{--    }--}}
    {{--}--}}
</script>