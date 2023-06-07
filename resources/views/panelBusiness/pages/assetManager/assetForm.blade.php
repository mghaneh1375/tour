@extends('panelBusiness.layout.baseLayout')

@section('head')
    <script async src="{{ URL::asset('js/bootstrap-datepicker.js') }}"></script>
    <script src={{ URL::asset('js/clockpicker.js') }}></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-element-bundle.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/clockpicker.css?v=2') }}" />
    <link rel="stylesheet" href="{{ URL::asset('css/theme2/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/shazdeDesigns/tourCreation.css?v=11') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/form.css?v=' . $fileVersions) }}" />
    <link rel="stylesheet" href="{{ URL::asset('css/pages/localShops/mainLocalShops.css?v=' . $fileVersions) }}">
    <link rel="stylesheet" href="{{ URL::asset('css/pages/business.css?v=' . $fileVersions) }}">
    <link rel="stylesheet" href="{{ URL::asset('BusinessPanelPublic/css/createBusinessPage.css?v=' . $fileVersions) }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/common.css?v=' . $fileVersions) }}" />
    <style>
        .mainBodySection {
            top: unset;
        }

        input[type="checkbox"],
        input[type="radio"] {
            display: unset !important;
        }

        .btn-group>label {
            padding: 10px 8px;
        }
    </style>
@endsection

@section('body')

    <div class="mainBackWhiteBody">
        <div class="whiteBox">
            <div id="formMake"></div>
            <div id="boxMake"></div>
            <div class="row fullyCenterContent rowReverse SpaceBetween" style="padding: 15px;">
                <button class="btn nextStepBtnTourCreation" type="button" onclick="nextStep()">گام بعدی</button>
                <button class="btn nextStepBtnTourCreation goToPrevStep" type="button" onclick="prevStep()">بازگشت به
                    مرحله قبل</button>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <div class="modal fade" id="addCityModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body" style="direction: rtl">
                    <div class="fullwidthDiv">
                        <div class="addPlaceGeneralInfoTitleTourCreation">
                            شهر مورد نظر خود را اضافه کنید
                        </div>
                        <button type="button" class="closee" data-dismiss="modal"
                            style="border: none; background: none; float: left">&times;</button>
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
                            <select id="selectStateForSelectCity" class="inputBoxInput styled-select text-align-right"
                                type="text">
                                <option value="0">انتخاب کنید</option>
                                @foreach ($states as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
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
                            <input id="inputSearchCity" class="inputBoxInput text-align-right" type="text"
                                placeholder="انتخاب کنید" onkeyup="searchForCity(this)" />
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
@endsection

@section('script')

    <script>
        var datePickerOptions = {
            numberOfMonths: 1,
            showButtonPanel: true,
            language: "fa",
            dateFormat: "yy/mm/dd",
        };
        var clockOptions = {
            placement: "bottom",
            donetext: "تایید",
            autoclose: true,
        };
        var findCityWithStateUrl = '{{ route('findCityWithState') }}';
        var ajaxVar = null;
        var city = null;
        var apiId = null;
        var dataToSend;
        let assetId = '{{ $assetId }}';
        let firstStepFormId;
        let formId = '{{ $formId }}';
        let prevFromId = undefined;
        let nextFormId = undefined;


        function nextStep() {
            dataToSend = {
                tourType,
                tourId: document.getElementById("tourId").value,
                businessId: document.getElementById("businessId").value,
                tourName: document.getElementById("tourName").value,
                srcCityId: document.getElementById("srcCityId").value,
                destPlaceId: document.getElementById("destPlaceId").value,
                kindDest: document.getElementById("destKind").value,
                sameSrcDestInput: document.getElementById("sameSrcDestInput").checked,
                tourDay: parseInt(p2e(document.getElementById("tourDay").value)),
                tourNight: parseInt(p2e(document.getElementById("tourNight").value)),
                minCapacity: parseInt(
                    p2e(document.getElementById("minCapacity").value)
                ),
                maxCapacity: parseInt(
                    p2e(document.getElementById("maxCapacity").value)
                ),
                private: document.querySelector('input[name="private"]:checked').value,
                anyCapacity: document.getElementById("anyCapacity").checked,
                isAllUserInfoNeed: $('input[name="isAllUserInfo"]:checked').val(),
                userInfoNeed: [
                    ...document.querySelectorAll(
                        'input[name="userInfoNeed[]"]:checked'
                    ),
                ].map((item) => item.value),
                dates: [],
            };

            var errorText = "";
            if (dataToSend.tourName.trim().length < 2)
                errorText += "<li>نام تور خود را مشخص کنید.</li>";
            if (!(dataToSend.srcCityId >= 1))
                errorText += "<li>مبدا تور خود را مشخص کنید.</li>";
            if (!(dataToSend.destPlaceId >= 1))
                errorText += "<li>مقصد تور خود را مشخص کنید.</li>";
            if (!(Number.isInteger(dataToSend.tourDay) && dataToSend.tourDay >= 0))
                errorText += "<li>تعداد روزهای تور خود را مشخص کنید.</li>";
            if (!(Number.isInteger(dataToSend.tourNight) && dataToSend.tourNight >= 0))
                errorText += "<li>تعداد شب های تور خود را مشخص کنید.</li>";
            if (!dataToSend.anyCapacity) {
                if (
                    !(
                        Number.isInteger(dataToSend.minCapacity) &&
                        dataToSend.minCapacity >= 0
                    )
                )
                    errorText += "<li>حداقل ظرفیت تور خود را مشخص کنید.</li>";
                if (
                    !(
                        Number.isInteger(dataToSend.maxCapacity) &&
                        dataToSend.maxCapacity >= 0
                    )
                )
                    errorText += "<li>حداکثر ظرفیت تور خود را مشخص کنید.</li>";
            }

            if (dataToSend.userInfoNeed.length == 0)
                errorText += "<li>نمی توانید از مسافرین اطلاعاتی دریافت نکنید.</li>";

            var sDate = "";
            var eDate = "";
            var sRows = $('input[name="sDateNotSame[]"]');
            var eRows = $('input[name="eDateNotSame[]"]');
            for (var i = 0; i < sRows.length; i++) {
                if (
                    $(sRows[i]).val().trim().length != 0 &&
                    $(eRows[i]).val().trim().length != 0
                ) {
                    eDate = $(eRows[i]).val().trim();
                    sDate = $(sRows[i]).val().trim();
                    dataToSend.dates.push({
                        sDate,
                        eDate
                    });
                }
            }

            if (sDate.trim().length == 0 || eDate.trim().length == 0)
                errorText += "<li>تاریخ تور را مشخص کنید.</li>";

            if (errorText != "") {
                errorText = `<ul class="errorList">${errorText}</ul>`;
                openErrorAlertBP(errorText);
            } else submitInputs();

            if (nextFormId !== undefined)
                window.location.href = '/asset/' + assetId + "/step/" + nextFormId;
        }

        function prevStep() {
            if (prevFromId !== undefined)
                window.location.href = '/asset/' + assetId + "/step/" + prevFromId;
        }

        $.ajax({
            type: 'get',
            // url: 'http://myeghamat.com/api/asset/' + assetId + "/form",
            url: 'https://boom.koochita.com/api/asset/' + assetId + "/form",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI0IiwianRpIjoiZTUxMDZjOTNiNGEzOTc5ODdmNjI0ZDllMTYyMGFiNzNkNjM0Y2IzOTA2YTRlNThmOTY3NGQxZDliMzVjYmY5OTE3MmUyMGUzODAxYjBmOTAiLCJpYXQiOjE2ODUxODQyNjcuOTkzNDE3LCJuYmYiOjE2ODUxODQyNjcuOTkzNDIyLCJleHAiOjE3MTY4MDY2NjcuNzgzODkzLCJzdWIiOiIxNCIsInNjb3BlcyI6W119.ieMJMIypKQF-u6-RbyyjQ-IuZsK31o92D7pIh4YHAX0GD8iKUKF9dnZ0cWDtA85cGcNVxTsdL908fmDKB8IyU5ZzfOQC1KBTMaQ8d8-uXafnJfJHFs9sJ8DDap1yoCn7FwHh-ICOYwSiWcZmwcbMYXyA-Vr8ltALZgSSqKHNLw0AfxOd2WColEGpudpnRb5ZSu59t6WnjUMuTlW1qQKjUv2lcuIQMsdTSOIiEDLfAYU1uReWKobNzv3VgiLINLfKNRfopJU7rSWE9qeC5RTXIxh5hR-ojp64hC_vO4KAMJMDjJEtB6y6TQczDSqU7GCupuY5ff2ZNHrKKcAVCrKhhenhWfViJvDVpYdEdyoI_8nvhlCpAVFSvDn6M344RuoTlPJzg8UHsEc-anEO16ihff3VAbo41vy0ZA7WPGWi8JxDajJeMPcl_IGtGwMkTPbNM2NP45-zQWjdr54GgEL2b11TwK_DUXW07RKCcozN1akuOw86q2O86J23s16PtcrVl3_iGhwjrHfOFUNvBDukenKcinB6Dd4tgz6aFacOCeIJSphJzcI7UCKIEyl9VBNIZDAQMqQBq_MyITTslq7DiuikcapUfBlZCnQvWgTOBfinQmo-Tub3ocAZjted5EBnU8vZncLRMftqahLNpmxyPLbgAQf2RvIT9n5Jko_4Io8"
            },
            success: function(res) {
                var html = '';
                if (res.status === 0) {
                    for (let i = 0; i < res.forms.length; i++) {

                        if (res.forms[i].id == formId) {
                            html += '<h1>' + res.forms[i].name + '</h1>';
                            html += '<div style="margin-top: 20px">';
                            html += '<h4>' + res.forms[i].description + '</h4>';
                            html += '<div>';
                            html += '<p>از بین گزینه های زیر یک گزینه را می توانید انتخاب کنید.</p>';
                            html +=
                                '<p>توجه کنید، این انتخاب بعدها قابل تغییر می باشد، اما به سبب گزینه های انتخاب شده، ما نیازمند';
                            html +=
                                'اطلاعات مفصلی از شما هستیم و امکانات متفاوتی را در اختیار شما قرار می دهیم.</p>';
                            html += '</div>';
                            html += '</div>';
                            html += '';
                            html += '';
                            html += '';
                            html += '';
                            html += '';
                            html += '';
                            if (i > 0)
                                prevFromId = res.forms[i - 1].id;

                            if (i < res.forms.length - 1)
                                nextFormId = res.forms[i + 1].id;

                            break;
                        }

                    }
                }
                $('#formMake').empty().append(html);
            }
        });

        function searchForCity(_element) {
            var stateId = $("#selectStateForSelectCity").val();
            var value = $(_element).val().trim();
            var citySrcInput = $(_element);
            citySrcInput.next().empty();

            if (value.length > 1 && stateId != 0) {
                if (ajaxVar != null) ajaxVar.abort();

                ajaxVar = $.ajax({
                    type: "GET",
                    url: `${findCityWithStateUrl}?stateId=${stateId}&value=${value}`,
                    success: (response) => {
                        if (response.status == "ok") {
                            var text = "";
                            response.result.map(
                                (item) =>
                                (text +=
                                    `<div class="searchHover blue" onclick="selectThisCityForSrc(this, ${item.id})">${item.name}</div>`
                                )
                            );
                            citySrcInput.next().html(text);
                        }
                    },
                });
            }
        }

        $.ajax({
            type: 'get',
            // url: 'http://myeghamat.com/api/form/' + formId,
            url: 'https://boom.koochita.com/api/form/' + formId,
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI0IiwianRpIjoiZTUxMDZjOTNiNGEzOTc5ODdmNjI0ZDllMTYyMGFiNzNkNjM0Y2IzOTA2YTRlNThmOTY3NGQxZDliMzVjYmY5OTE3MmUyMGUzODAxYjBmOTAiLCJpYXQiOjE2ODUxODQyNjcuOTkzNDE3LCJuYmYiOjE2ODUxODQyNjcuOTkzNDIyLCJleHAiOjE3MTY4MDY2NjcuNzgzODkzLCJzdWIiOiIxNCIsInNjb3BlcyI6W119.ieMJMIypKQF-u6-RbyyjQ-IuZsK31o92D7pIh4YHAX0GD8iKUKF9dnZ0cWDtA85cGcNVxTsdL908fmDKB8IyU5ZzfOQC1KBTMaQ8d8-uXafnJfJHFs9sJ8DDap1yoCn7FwHh-ICOYwSiWcZmwcbMYXyA-Vr8ltALZgSSqKHNLw0AfxOd2WColEGpudpnRb5ZSu59t6WnjUMuTlW1qQKjUv2lcuIQMsdTSOIiEDLfAYU1uReWKobNzv3VgiLINLfKNRfopJU7rSWE9qeC5RTXIxh5hR-ojp64hC_vO4KAMJMDjJEtB6y6TQczDSqU7GCupuY5ff2ZNHrKKcAVCrKhhenhWfViJvDVpYdEdyoI_8nvhlCpAVFSvDn6M344RuoTlPJzg8UHsEc-anEO16ihff3VAbo41vy0ZA7WPGWi8JxDajJeMPcl_IGtGwMkTPbNM2NP45-zQWjdr54GgEL2b11TwK_DUXW07RKCcozN1akuOw86q2O86J23s16PtcrVl3_iGhwjrHfOFUNvBDukenKcinB6Dd4tgz6aFacOCeIJSphJzcI7UCKIEyl9VBNIZDAQMqQBq_MyITTslq7DiuikcapUfBlZCnQvWgTOBfinQmo-Tub3ocAZjted5EBnU8vZncLRMftqahLNpmxyPLbgAQf2RvIT9n5Jko_4Io8"
            },
            success: function(res) {

                var text = '';
                if (res.status === 0) {
                    for (let i = 0; i < res.fields.length; i++) {
                        text += '<div class="relative-position inputBoxTour" style="width: ' + (res.fields[i]
                            .half == 1 ? '50%' : '100%') + ';">';
                        text += '';

                        if (res.fields[i].type == 'radio') {
                            text += '<p>' + res.fields[i].name + '</p>';
                            text += '<div class="btn-group btn-group-toggle" data-toggle="buttons">';
                            for (let x = 0; x < res.fields[i].options.length; x++) {
                                text += '<label class="btn btn-secondary " for="' + res.fields[i].options[
                                    x] + '">' + res.fields[i].options[x] + '';
                                text += '<input type="radio" name="' + res.fields[i].name + '" id="' + res
                                    .fields[i].options[x] + '" ' + (res.fields[i].necessary == 1 ? 'required ' :
                                        '') + '>';
                                text += '</label>';

                            }
                            text += '</div>';
                        } else if (res.fields[i].type == 'checkbox') {
                            text += '<p>' + res.fields[i].name + '</p>';
                            text += '<div class="btn-group btn-group-toggle" data-toggle="buttons">';
                            for (let x = 0; x < res.fields[i].options.length; x++) {
                                text += '<label class="btn btn-secondary " for="' + res.fields[i].options[
                                    x] + '">' + res.fields[i].options[x] + '';
                                text += '<input type="checkbox" name="' + res.fields[i].name + '" id="' + res
                                    .fields[i].options[x] + '" ' + (res.fields[i].necessary == 1 ? 'required ' :
                                        '') + '>';
                                text += '</label>';

                            }
                            text += '</div>';
                        } else if (res.fields[i].type == 'string') {
                            text += '<div class="inputBoxTextGeneralInfo inputBoxText">';
                            text += '<div class="' + (res.fields[i].necessary == 1 ? ' importantFieldLabel' :
                                '') + '"> ' + res.fields[i].name + '</div>';
                            text += '</div>';
                            text += '<input type="text" id="' + res.fields[i].field_id +
                                '" class="inputBoxInput" placeholder="' + (res.fields[i].placeholder != null ?
                                    '' + res.fields[i].placeholder + '' : '') + '"' + (res.fields[i]
                                    .necessary == 1 ? 'required ' : '') + ' >';
                        } else if (res.fields[i].type == 'time') {
                            text += '<div class="inputBoxTextGeneralInfo inputBoxText clockTitle">';
                            text += '<div class=" name' + (res.fields[i].necessary == 1 ?
                                ' importantFieldLabel' :
                                '') + '"> ' + res.fields[i].name + '</div>';
                            text += '</div>';
                            text += '<input type="text" id="' + res.fields[i].field_id +
                                '" class="form-control clockP" placeholder="' + (res.fields[i].placeholder !=
                                    null ?
                                    '' + res.fields[i].placeholder + '' : '') + '"' + (res.fields[i]
                                    .necessary == 1 ? 'required ' : '') + ' >';
                        } else if (res.fields[i].type == 'int') {
                            text += '<div class="inputBoxTextGeneralInfo inputBoxText">';
                            text += '<div class="' + (res.fields[i].necessary == 1 ? ' importantFieldLabel' :
                                '') + '"> ' + res.fields[i].name + '</div>';
                            text += '</div>';
                            text += '<input type="number" id="' + res.fields[i].field_id +
                                '" class="inputBoxInput" placeholder="' + (res.fields[i].placeholder != null ?
                                    '' + res.fields[i].placeholder + '' : '') + '"' + (res.fields[i]
                                    .necessary == 1 ? 'required ' : '') + ' >';
                        } else if (res.fields[i].type == 'api') {
                            city = res.fields[i].options[0].replace('koochita', 'mykoochita').replace("https",
                                "http");
                            apiId = res.fields[i].field_id;
                            text += '<div class="inputBoxTextGeneralInfo inputBoxText">';
                            text += '<div class="' + (res.fields[i].necessary == 1 ? ' importantFieldLabel' :
                                '') + '"> ' + res.fields[i].name + '</div>';
                            text += '</div>';

                            // text += '<input value=" " type="text" id="' + res.fields[i].field_id +
                            //     '" class="inputBoxInput" placeholder="' + (res.fields[i].placeholder != null ?
                            //         '' + res.fields[i].placeholder + '' : '') + '"' + (res.fields[i]
                            //         .necessary == 1 ? 'required ' : '') + ' onkeyup="searchCityName(this)" >';

                            text += '<input value=" " type="text" id="' + res.fields[i].field_id +
                                '" class="inputBoxInput" placeholder="' + (res.fields[i].placeholder != null ?
                                    '' + res.fields[i].placeholder + '' : '') + '"' + (res.fields[i]
                                    .necessary == 1 ? 'required ' : '') +
                                ' onclick="chooseSrcCityModal()" >';

                            text += '<div id="apiItemList" class"hidden">';
                            text += '</div>';
                        } else if (res.fields[i].type == 'textarea') {
                            text += '<div class="inputBoxTextGeneralInfo inputBoxText">';
                            text += '<div class="' + (res.fields[i].necessary == 1 ? ' importantFieldLabel' :
                                '') + '"> ' + res.fields[i].name + '</div>';
                            text += '</div>';
                            text += '<textarea  id="' + res.fields[i].field_id +
                                '" class="inputBoxInput fullwidthDiv text-align-right full-height textareaInForDescription"  placeholder="' +
                                (res.fields[i].placeholder != null ?
                                    '' + res.fields[i].placeholder + '' : '') + '"' + (res.fields[i]
                                    .necessary == 1 ? 'required ' : '') + ' ></textarea>';
                        } else if (res.fields[i].type == 'calendar') {
                            text += '<div class="inputBoxTextGeneralInfo inputBoxText">';
                            text += '<div class="' + (res.fields[i].necessary == 1 ? ' importantFieldLabel' :
                                '') + '"> ' + res.fields[i].name + '</div>';
                            text += '</div>';
                            text += '<div class="select-side calendarIconTourCreation">';
                            text += '<i class="ui_icon calendar calendarIcon"></i>';
                            text += '</div>';
                            text += ' <input name="sDateNotSame[]" id="' + res.fields[i].field_id +
                                '" class="observer-example inputBoxInput"type="text" placeholder="' + (res
                                    .fields[i].placeholder != null ?
                                    '' + res.fields[i].placeholder + '' : '') + '"' + (res.fields[i]
                                    .necessary == 1 ? 'required ' : '') + ' >';
                            text += '';
                            calenderId = res.fields[i].field_id;
                            console.log(calenderId);
                        } else {
                            text += '<div class="inputBoxTextGeneralInfo inputBoxText">';
                            text += '<div class="' + (res.fields[i].necessary == 1 ? ' importantFieldLabel' :
                                '') + '"> ' + res.fields[i].name + '</div>';
                            text += '</div>';
                            text += '<input type="' + res.fields[i].type + '" id="' + res.fields[i].field_id +
                                '" class="inputBoxInput" placeholder="' + (res.fields[i].placeholder != null ?
                                    '' + res.fields[i].placeholder + '' : '') + '"' + (res.fields[i]
                                    .necessary == 1 ? 'required ' : '') + ' >';
                        }

                        text += '</div>';
                        if (res.fields[i].force_help != null) {
                            text += '<figcaption> ' + res.fields[i].force_help + '';
                            text += '</figcaption>';
                        }
                        text += '';
                        text += '';
                        text += '';
                    }
                    $('#boxMake').empty().append(text);
                    $(".clockP").clockpicker(clockOptions);
                    $(".observer-example").datepicker(datePickerOptions);
                    console.log("mooz");
                }
            }
        });


        function searchCityName(_element) {
            var value = $(_element).val().trim();
            if (value.length > 1) {

                $.ajax({
                    type: "GET",
                    url: city,
                    data: {
                        key: value
                    },
                    success: (response) => {
                        if (response.status == 0) {
                            var text = "";
                            response.result.map(
                                (item) =>
                                (text +=
                                    `<div class="searchHover blue" onclick="selectApi(this)">${item}</div>`
                                )
                            );
                            $('#apiItemList').removeClass('hidden');
                            $('#apiItemList').empty().append(text);
                        }
                    },
                });
            }
        }

        function selectThisCityForSrc(_element, _id) {
            $("#" + apiId).val($(_element).text());
            $("#srcCityId").val(_id);
            $("#addCityModal").modal("hide");
            $(_element).parent().empty();

            // if (document.getElementById("sameSrcDestInput").checked)
            //     $("#destPlaceId").val(_id);
        }

        function selectApi(_element) {
            $("#addCityModal").removeClass("displayBlock");
            $('#apiItemList').addClass('hidden');
            $("#${apiId}").val($(_element).text());
        }

        function chooseSrcCityModal() {
            $("#addCityModal").modal("show");
        }
    </script>

@stop
