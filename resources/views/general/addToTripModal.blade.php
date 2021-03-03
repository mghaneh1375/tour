<link rel="stylesheet" href="{{URL::asset('css/theme2/bootstrap-datepicker.css?v=1')}}">
<script async src="{{URL::asset("js/bootstrap-datepicker.js")}}"></script>

<style>

    .icon-circle-arrow-right {
        opacity: 1;
        color: black;
        font-size: 22px;
        font-style: normal;
        transform: rotate(180deg);
        display: flex;
    }

    .icon-circle-arrow-right:before{
        content: '\E041';
        font-family: Shazde_Regular2 !important;
    }


    .icon-circle-arrow-left {
        opacity: 1;
        color: black;
        font-size: 22px;
        font-style: normal;
        display: flex;
    }
    .icon-circle-arrow-left:before{
        content: '\E041';
        font-family: Shazde_Regular2 !important;
    }
</style>

<div id="addPlaceToTripPrompt" class="modalBlackBack">
    <span class="modalBody" style="width: 700px;">
        <div class="body_text">
            <div>
                <div class="find_location_modal">
                    <div class="tripHeader">لیست سفر</div>
                    <div class="ui_typeahead rtl">برای برنامه ریزی سفر، این مکان را به سفر خود اضافه کنید</div>
                    <div class="ui_typeahead rtl" id="tripsForPlace"></div>
                </div>
            </div>
        </div>
        <div class="submitOptions rtl">
            <button onclick="assignPlaceToTrip()" class="btn" style="background: var(--koochita-blue); color: white;">تایید</button>
            <input type="button" onclick="closeMyModal('addPlaceToTripPrompt')" value="بستن" class="btn btn-default">
            <p id="errorAssignPlace"></p>
        </div>
        <div class="iconClose tripCloseIcon" onclick="closeMyModal('addPlaceToTripPrompt')"></div>
    </span>
</div>

<div id="newTripModal" class="modalBlackBack fullCenter" style="z-index: 9999;">
    <div class="modalBody" style="width: 700px;">
        <div id="selectNewTripName" class="tripModalBase">
            <div class="modal-background"></div>
            <div style="width: 100%">
                <div class="iconClose tripCloseIcon" onclick="closeNewTrip()"></div>
                <div class="modal-card-head">
                    <div class="tripHeader">ایجاد سفر </div>
                </div>
                <div class="modal-card-body">
                    <div id="trip-title-input-region">
                        <div>
                            <label class="label">نام سفر</label>
                            <div class="control trip-title-control">
                                <input class="tripNameInput" id="tripName" onkeyup="checkEmptyTripInputs()" type="text" maxlength="50" placeholder="حداکثر 50 کاراکتر" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-card-foot">
                    <button id="saves-create-trip-button" onclick="nextStep()" class="btn saves-create-trip-button disabled" style="background: var(--koochita-blue); color: white">ایجاد سفر</button>
                </div>
            </div>
        </div>
        <div id="selectNewTripDate" class="tripModalBase" style="display: none;">
            <div style="width: 100%">
                <div class="iconClose tripCloseIcon" onclick="closeNewTrip()"></div>
                <div class="modal-card-head">
                    <div class="tripHeader">افزودن تاریخ به سفر</div>
                </div>
                <div class="modal-card-body rtl">
                    <div class="control add-dates-cta-text">
                        <p></p>
                    </div>
                    <div class="tripDates">
                        <div>
                            <div id="date_btn_start_edit">تاریخ شروع</div>
                            <label class="tripCalenderSection">
                                <span class="calendarIcon"></span>
                                <input id="date_input_start" class="tripDateInput" placeholder="13xx/xx/xx" required readonly type="text">
                            </label>
                        </div>
                        <div>
                            <div id="date_btn_end_edit">تاریخ اتمام</div>
                            <label class="tripCalenderSection">
                                <span class="calendarIcon"></span>
                                <input id="date_input_end" class="tripDateInput" placeholder="13xx/xx/xx" required readonly type="text">
                            </label>
                        </div>
                        <div class="clear-both"></div>
                    </div>
                </div>
                <div class="tripDateFooter">
                    <button id="add-dates-cta-cancel" onclick="backToNewTripName()" class="btn btn-success saves-create-trip-button" style="background: #d6d6d6; border: none; margin-left: 15px">بازگشت </button>
                    <button id="add-dates-cta-save" onclick="saveTrip()" class="btn saves-create-trip-button" style="background: var(--koochita-blue); color: white">ذخیره</button>
                </div>

                <div >
                    <h5 id="error" style="display: none;"></h5>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    var getPlaceTrips = '{{route('placeTrips')}}';
    var myTrips = '{{route('myTrips')}}';
    var tripName;
    var selectedPlaceId;
    var selectedKindPlaceId;
    var callBackCreateTrip = null;

    var placeTripUrl_addToTripModal = "{{route('placeTrips')}}";
    var assignPlaceToTripUrl_addToTripModal = "{{route('assignPlaceToTrip')}}";
    var addTripUrl_addToTripModal = "{{route('addTrip')}}";
</script>
