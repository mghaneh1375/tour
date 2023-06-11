@extends('panelBusiness.layout.baseLayout')

@section('head')
    <script src="https://cdn.parsimap.ir/third-party/mapbox-gl-js/plugins/parsimap-geocoder/v1.0.0/parsimap-geocoder.js">
    </script>
    <link href="https://cdn.parsimap.ir/third-party/mapbox-gl-js/plugins/parsimap-geocoder/v1.0.0/parsimap-geocoder.css"
        rel="stylesheet" />

    {{-- <script src='https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css' rel='stylesheet' /> --}}
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
            <div id="boxMake" style="display: flex; flex-wrap: wrap;"></div>

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
    <div class="modal fade" id="locMark">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body" style="direction: rtl">
                    <div class="row">
                        <div class="col-md-12 mb-md-0 mb-4">
                            <div id="map" style="width: 100%; height: 500px"></div>
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
        let x = " ";
        let y = " ";

        function nextStep() {
            var errorText = "";
            storeData = {

            }
            var $inputs = $('.inputBoxTour :input');

            // An array of just the ids...
            var ids = {};

            $inputs.each(function() {
                ids[$(this).attr('name')] = {
                    id: $(this).attr('id'),
                    value: $(this).val()
                }
                if ($(this).attr('required'))
                    if ($(this).val() == '') {
                        // alert($(this).attr('name') + ' ' + 'پر شود ');
                        errorText += '<ul class="errorList"> ';
                        errorText += "<li> " + $(this).attr('name') + ' ' + 'پر شود ' + "</li></ul>";
                        openErrorAlertBP(errorText);
                    } else {
                        (nextFormId !== undefined)
                        window.location.href = '/asset/' + assetId + "/step/" + nextFormId;
                    }
            });
            console.log(ids);

        }

        function prevStep() {
            if (prevFromId !== undefined)
                window.location.href = '/asset/' + assetId + "/step/" + prevFromId;
        }

        $.ajax({
            type: 'get',
            // url: 'http://myeghamat.com/api/asset/' + assetId + "/form",
            url: 'https://boom.bogenstudio.com/api/asset/' + assetId + "/form",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzIiwianRpIjoiODcyZjc0YjI4MDcwNjVkOTAzYjBkMGUzYTM3ZGZlZTc1ZjE2OTQ5NzQzYjhlNzhiMjdjNzkyN2Y0YzE3NjEyZjk3Y2Y1MTY3YTkzYjhhYmYiLCJpYXQiOjE2ODYxNDQzMTYuODMxMjU1LCJuYmYiOjE2ODYxNDQzMTYuODMxMjU4LCJleHAiOjE3MTc3NjY3MTYuODI3MTc2LCJzdWIiOiIxNCIsInNjb3BlcyI6W119.ZhLHb_mQTKpyC-YbAEogNL-kV4mpOGdvxApdFAZYJxtBsapF6LQy75AdQINDuy_pbA3D2ZsxKcvhnnPZcFyROmN-HrHK5DphDDkgIAYHIGo-pM6Oe0Z1etpwpzNVQPpG2yqY-A-n9mXK9ElfXuKsyVl70N2nYFXDbTwJile2N8Mh898MQj6vGQAqnbwCs6SUun94eLGt0cte38BEn5-4zWSsDkddGBIDQMaQXyC5wbCs1n_GITA0RtWE04fDlagowZ1SBLQ5uaS5WS2Eu_VLkdYlp3H9-Derg20QcLqqAtSrQzumYrf8_JNfGkkxdAudakIf0oN3lCvvGQJc3yvupnjMlizgBfjO5Gov-JSi58BEe6Dlyh1PH_aHclUMApNqs_GF4znGtlM7vivz56eNJfb7pdiF8DyMVrvgE73CQbqBf71R02D6LuoG6uSuiBvCg7fgprx592kjX3IHZPlRUhO7ecHChPC2A2D9wI8T08l536CceLnySWcD7o_iv-gk1JoJuY_9gfgSkRdumgxQKdXLPCvRCHGeRysLZSJupbh_6VugYBTA2oBRxDuVWKm7msks0XHvRYkc7hwx74EdqygJuVC6ejs_AY3QFHFTXJ2hvTLb5Kf5hJVhPT7xjHnagkiA-PSenc8OfCS-xASDE2woyTdoERSLMHVDJdUQ7h8"
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
            url: 'https://boom.bogenstudio.com/api/form/' + formId,
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzIiwianRpIjoiODcyZjc0YjI4MDcwNjVkOTAzYjBkMGUzYTM3ZGZlZTc1ZjE2OTQ5NzQzYjhlNzhiMjdjNzkyN2Y0YzE3NjEyZjk3Y2Y1MTY3YTkzYjhhYmYiLCJpYXQiOjE2ODYxNDQzMTYuODMxMjU1LCJuYmYiOjE2ODYxNDQzMTYuODMxMjU4LCJleHAiOjE3MTc3NjY3MTYuODI3MTc2LCJzdWIiOiIxNCIsInNjb3BlcyI6W119.ZhLHb_mQTKpyC-YbAEogNL-kV4mpOGdvxApdFAZYJxtBsapF6LQy75AdQINDuy_pbA3D2ZsxKcvhnnPZcFyROmN-HrHK5DphDDkgIAYHIGo-pM6Oe0Z1etpwpzNVQPpG2yqY-A-n9mXK9ElfXuKsyVl70N2nYFXDbTwJile2N8Mh898MQj6vGQAqnbwCs6SUun94eLGt0cte38BEn5-4zWSsDkddGBIDQMaQXyC5wbCs1n_GITA0RtWE04fDlagowZ1SBLQ5uaS5WS2Eu_VLkdYlp3H9-Derg20QcLqqAtSrQzumYrf8_JNfGkkxdAudakIf0oN3lCvvGQJc3yvupnjMlizgBfjO5Gov-JSi58BEe6Dlyh1PH_aHclUMApNqs_GF4znGtlM7vivz56eNJfb7pdiF8DyMVrvgE73CQbqBf71R02D6LuoG6uSuiBvCg7fgprx592kjX3IHZPlRUhO7ecHChPC2A2D9wI8T08l536CceLnySWcD7o_iv-gk1JoJuY_9gfgSkRdumgxQKdXLPCvRCHGeRysLZSJupbh_6VugYBTA2oBRxDuVWKm7msks0XHvRYkc7hwx74EdqygJuVC6ejs_AY3QFHFTXJ2hvTLb5Kf5hJVhPT7xjHnagkiA-PSenc8OfCS-xASDE2woyTdoERSLMHVDJdUQ7h8"
            },
            success: function(res) {

                var text = '';
                if (res.status === 0) {
                    for (let i = 0; i < res.fields.length; i++) {
                        text += '<div class="relative-position inputBoxTour" style="width: ' + (res.fields[
                                i]
                            .half == 1 ? '50%' : '100%') + ';">';
                        text += '';

                        if (res.fields[i].type == 'radio') {
                            text += '<p>' + res.fields[i].name + '</p>';
                            text += '<div class="btn-group btn-group-toggle" data-toggle="buttons">';
                            for (let x = 0; x < res.fields[i].options.length; x++) {
                                text += '<label class="btn btn-secondary " for="' + res.fields[i].options[
                                    x] + '">' + res.fields[i].options[x] + '';
                                text += '<input type="radio" name="' + res.fields[i].name + '" id="' + res
                                    .fields[i].options[x] + '" ' + (res.fields[i].necessary == 1 ?
                                        'required ' :
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
                                text += '<input type="checkbox" name="' + res.fields[i].name + '" id="' +
                                    res
                                    .fields[i].options[x] + '" ' + (res.fields[i].necessary == 1 ?
                                        'required ' :
                                        '') + '>';
                                text += '</label>';

                            }
                            text += '</div>';
                        } else if (res.fields[i].type == 'string') {
                            text += '<div class="inputBoxTextGeneralInfo inputBoxText">';
                            text += '<div class="' + (res.fields[i].necessary == 1 ?
                                ' importantFieldLabel' :
                                '') + '"> ' + res.fields[i].name + '</div>';
                            text += '</div>';
                            text += '<input type="text" id="' + res.fields[i].field_id +
                                '" class="inputBoxInput" name="' + res.fields[i].name + '" placeholder="' +
                                (res
                                    .fields[i].placeholder != null ?
                                    '' + res.fields[i].placeholder + '' : '') + '"' + (res.fields[i]
                                    .necessary == 1 ? 'required ' : '') + ' >';
                        } else if (res.fields[i].type == 'time') {
                            text += '<div class="inputBoxTextGeneralInfo inputBoxText clockTitle">';
                            text += '<div class=" name' + (res.fields[i].necessary == 1 ?
                                ' importantFieldLabel' :
                                '') + '"> ' + res.fields[i].name + '</div>';
                            text += '</div>';
                            text += '<input type="text" name="' + res.fields[i].name + '" id="' + res
                                .fields[i]
                                .field_id +
                                '" class="form-control clockP" placeholder="' + (res.fields[i]
                                    .placeholder !=
                                    null ?
                                    '' + res.fields[i].placeholder + '' : '') + '"' + (res.fields[i]
                                    .necessary == 1 ? 'required ' : '') + ' >';
                        } else if (res.fields[i].type == 'int') {
                            text += '<div class="inputBoxTextGeneralInfo inputBoxText">';
                            text += '<div class="' + (res.fields[i].necessary == 1 ?
                                ' importantFieldLabel' :
                                '') + '"> ' + res.fields[i].name + '</div>';
                            text += '</div>';
                            text += '<input type="number" name="' + res.fields[i].name + '" id="' + res
                                .fields[
                                    i].field_id +
                                '" class="inputBoxInput" placeholder="' + (res.fields[i].placeholder !=
                                    null ?
                                    '' + res.fields[i].placeholder + '' : '') + '"' + (res.fields[i]
                                    .necessary == 1 ? 'required ' : '') + ' >';
                        } else if (res.fields[i].type == 'map') {
                            text += '<div class="inputBoxTextGeneralInfo inputBoxText">';
                            text += '<div class="' + (res.fields[i].necessary == 1 ?
                                ' importantFieldLabel' :
                                '') + '"> ' + res.fields[i].name + '</div>';
                            text += '</div>';
                            text += '<div class="select-side locationIconTourCreation">';
                            text += '<i class="ui_icon  locationIcon"></i>';
                            text += '</div>';
                            text += '<input type="text" name="' + res.fields[i].name + '" id="' + res
                                .fields[i]
                                .field_id +
                                '" class="inputBoxInput mapMark" placeholder="' + (res.fields[i]
                                    .placeholder !=
                                    null ?
                                    '' + res.fields[i].placeholder + '' : '') + '"' + (res.fields[i]
                                    .necessary == 1 ? 'required ' : '') + ' >';
                        } else if (res.fields[i].type == 'api') {
                            city = res.fields[i].options[0].replace('koochita', 'mykoochita').replace(
                                "https",
                                "http");
                            apiId = res.fields[i].field_id;
                            text += '<div class="inputBoxTextGeneralInfo inputBoxText">';
                            text += '<div class="' + (res.fields[i].necessary == 1 ?
                                ' importantFieldLabel' :
                                '') + '"> ' + res.fields[i].name + '</div>';
                            text += '</div>';

                            // text += '<input value=" " type="text" id="' + res.fields[i].field_id +
                            //     '" class="inputBoxInput" placeholder="' + (res.fields[i].placeholder != null ?
                            //         '' + res.fields[i].placeholder + '' : '') + '"' + (res.fields[i]
                            //         .necessary == 1 ? 'required ' : '') + ' onkeyup="searchCityName(this)" >';

                            text += '<input value="" type="text" id="' + res.fields[i].field_id +
                                '" class="inputBoxInput" name="' + res.fields[i].name + '" placeholder="' +
                                (res
                                    .fields[i].placeholder != null ?
                                    '' + res.fields[i].placeholder + '' : '') + '"' + (res.fields[i]
                                    .necessary == 1 ? 'required ' : '') +
                                ' onclick="chooseSrcCityModal()" >';

                            text += '<div id="apiItemList" class"hidden">';
                            text += '</div>';
                        } else if (res.fields[i].type == 'textarea') {
                            text += '<div class="inputBoxTextGeneralInfo inputBoxText">';
                            text += '<div class="' + (res.fields[i].necessary == 1 ?
                                ' importantFieldLabel' :
                                '') + '"> ' + res.fields[i].name + '</div>';
                            text += '</div>';
                            text += '<textarea name="' + res.fields[i].name + '" id="' + res.fields[i]
                                .field_id +
                                '" class="inputBoxInput fullwidthDiv text-align-right full-height textareaInForDescription"  placeholder="' +
                                (res.fields[i].placeholder != null ?
                                    '' + res.fields[i].placeholder + '' : '') + '"' + (res.fields[i]
                                    .necessary == 1 ? 'required ' : '') + ' ></textarea>';
                        } else if (res.fields[i].type == 'calendar') {
                            text += '<div class="inputBoxTextGeneralInfo inputBoxText">';
                            text += '<div class="' + (res.fields[i].necessary == 1 ?
                                ' importantFieldLabel' :
                                '') + '"> ' + res.fields[i].name + '</div>';
                            text += '</div>';
                            text += '<div class="select-side calendarIconTourCreation">';
                            text += '<i class="ui_icon calendar calendarIcon"></i>';
                            text += '</div>';
                            text += ' <input name="' + res.fields[i].name + '" name="sDateNotSame[]" id="' +
                                res
                                .fields[i].field_id +
                                '" class="observer-example inputBoxInput"type="text" placeholder="' + (res
                                    .fields[i].placeholder != null ?
                                    '' + res.fields[i].placeholder + '' : '') + '"' + (res.fields[i]
                                    .necessary == 1 ? 'required ' : '') + ' >';
                            text += '';
                            calenderId = res.fields[i].field_id;
                        } else {
                            text += '<div class="inputBoxTextGeneralInfo inputBoxText">';
                            text += '<div class="' + (res.fields[i].necessary == 1 ?
                                ' importantFieldLabel' :
                                '') + '"> ' + res.fields[i].name + '</div>';
                            text += '</div>';
                            text += '<input name="' + res.fields[i].name + '" type="' + res.fields[i].type +
                                '" id="' + res.fields[i].field_id +
                                '" class="inputBoxInput" placeholder="' + (res.fields[i].placeholder !=
                                    null ?
                                    '' + res.fields[i].placeholder + '' : '') + '"' + (res.fields[i]
                                    .necessary == 1 ? 'required ' : '') + ' >';
                        }

                        text += '</div>';
                        if (res.fields[i].force_help != null) {
                            text += '<figcaption style="width: 100%;"> ' + res.fields[i].force_help + '';
                            text += '</figcaption>';
                        }
                        text += '';
                        text += '';
                        text += '';
                    }
                    $('#boxMake').empty().append(text);
                    $(".clockP").clockpicker(clockOptions);
                    $(".observer-example").datepicker(datePickerOptions);
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

        $(document).on("click", ".mapMark", function() {
            $("#locMark").modal("show");
        });



        $(document).ready(function() {
            mapboxgl.setRTLTextPlugin(
                'https://cdn.parsimap.ir/third-party/mapbox-gl-js/plugins/mapbox-gl-rtl-text/v0.2.3/mapbox-gl-rtl-text.js',
                null,
            );

            const map = new mapboxgl.Map({
                container: 'map',
                // accessToken: "pk.eyJ1Ijoic29saXNoIiwiYSI6ImNsZGExdmJ5bjBkemQzcHN6NzVhbXJidXcifQ.s8Crrxn4TRmtd8pZ5M3Sww",
                style: 'https://api.parsimap.ir/styles/parsimap-streets-v11?key=p1c7661f1a3a684079872cbca20c1fb8477a83a92f',
                center: [51.4, 35.7],
                zoom: 13,
            });

            var marker = undefined;

            if (x !== undefined && y !== undefined) {
                marker = new mapboxgl.Marker();
                marker.setLngLat({
                    lng: y,
                    lat: x
                }).addTo(map);
            }

            function addMarker(e) {

                if (marker !== undefined)
                    marker.remove();

                //add marker
                marker = new mapboxgl.Marker();
                marker.setLngLat(e.lngLat).addTo(map);

                x = e.lngLat.lat;
                y = e.lngLat.lng;
                console.log(x);
                console.log(y);
            }

            map.on('click', addMarker);

        });
    </script>

@stop
