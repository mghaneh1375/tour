@extends('panelBusiness.layout.baseLayout')

@section('head')
    {{-- <script src="https://cdn.parsimap.ir/third-party/mapbox-gl-js/plugins/parsimap-geocoder/v1.0.0/parsimap-geocoder.js">
    </script>
    <link href="https://cdn.parsimap.ir/third-party/mapbox-gl-js/plugins/parsimap-geocoder/v1.0.0/parsimap-geocoder.css"
        rel="stylesheet" /> --}}

    <script src='https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css' rel='stylesheet' />
    <script async src="{{ URL::asset('js/bootstrap-datepicker.js') }}"></script>
    <script src={{ URL::asset('js/clockpicker.js') }}></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-element-bundle.min.js"></script>
    <script type="text/javascript" src="http://example.com/image-uploader.min.js"></script>
    <script defer src="{{ URL::asset('js/uploadLargFile.js?v=' . $fileVersions) }}"></script>
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
            <div id="formModal"></div>
            <div id="listMake"></div>

            <div class="row fullyCenterContent rowReverse SpaceBetween" style="padding: 15px;">
                <button class="btn nextStepBtnTourCreation" type="button" onclick="nextStep()">گام بعدی</button>
                <button class="btn nextStepBtnTourCreation goToPrevStep" type="button" onclick="prevStep()">بازگشت به
                    مرحله قبل</button>
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
            let userAssetId = parseInt('{{ $userAssetId }}');
            let isInFirstStep = false;
            var radioSet = '';
            var z;
            var modal = false;
            var roomNum = -1;
            let token =
                "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI0IiwianRpIjoiNDNjNWY4YzE0NGQ3YmE5NjNlMzNlYjUxNGQwZjQxODFjZGEwZmUzOTdkMDdhNDYyOGNhNDIwYmQ3OTM5M2FjMjRhNGEyM2VkMWZhMDlmMDEiLCJpYXQiOjE2ODY1NTQzOTQuODk5OTcyLCJuYmYiOjE2ODY1NTQzOTQuODk5OTc3LCJleHAiOjE3MTgxNzY3OTQuNzA0ODg2LCJzdWIiOiIyNCIsInNjb3BlcyI6W119.mZ46Gw-eW5rTBSeT7O7-sUYDyWJAMbMTmslvH9NWHb70wN5svyaUSirhIP9nCU8boiMubFcRC1KOi3WVn5CuUhbtkxmyO9M88CkodEu3DYwLFHg0soc5kCLLHuSJ6juKuVRgl5CtYacFHaRFSPhsnN_RRbf3EF3ooUeFgZlxU8gO3QK0yeBYoiCG4TlJMpQh5rx3iBxqwzKUsTxfXMRyt2ijK-dZtvbUhHIFXzx7aNkn-IRH0S-p2gCrTgifHIorWyLstk1clTTLYmNghrfVPDNXAjtK7wrUc-jFY-2yLIIqRzClTX1OvkSdOiBlrGHUZt7MrlcjgFkP0AxkNQ26WkDJ2fwPadlxa_Wr_mUv8zQ7rUvPGTt2Wt0xxQip9HHJL4aUsHN-9X44UQ501rKnWC-tHFBnMnpXi6pZED8zG0cd-MfYxNZ_xGwgO1-jrpGYvZ1zXR3RDoy33dd7MyA5pOfUDXlVqUYmpuNR3_MsSJGIFWm3G0MGLH1KdVD8ho_Kd2Wiqnq9N6uXICgKHrdmSFR87QNDfTowg-b3Ok_1BQR42CCpW7cHEPI5jIPSy5_v4fsxqzwzNfSNf3VkhZ9LorMA-OCzmaVXsJQpChvsfSwkVTXb4NpDJtEKb9E5JAHb3boxPVDB6RDFNMqHS_RKbcXQmo8xgep8qXKDFOQ2QcA";

            function storePic(userAssetId, fields) {
                var fileStore = new FormData();
                fileStore.append('pic', $("#" + fields[1].id)[0].files[0]);
                $.ajax({
                    type: 'post',
                    url: 'http://myeghamat.com/api/user_asset/' + userAssetId + "/set_asset_pic/" + fields[1].id,
                    processData: false,
                    contentType: false,
                    headers: {
                        'Accept': 'application/json',
                        "Authorization": token
                    },
                    data: fileStore,
                    success: function(res) {
                        if (res.status === "0") {
                            console.log('pic ok');
                        } else {
                            console.log('pic Nok');
                        }
                    }
                });
            }


            function storeData(fields) {

                if (fields.length == 0) {
                    window.location.href = '/asset/' + assetId + "/step/" + nextFormId + "/" + userAssetId;
                    return;
                }

                if (isInFirstStep) {

                    if (userAssetId === -1) {
                        // todo: call store asset api
                        $.ajax({
                            type: 'post',
                            url: 'http://myeghamat.com/api/asset/1/user_asset',
                            headers: {
                                'Accept': 'application/json',
                                "Authorization": token
                            },
                            data: fields[0],
                            success: function(res) {
                                if (res.status === "0") {
                                    userAssetId = res.id;
                                    storePic(userAssetId, fields);
                                } else {}
                            }

                        });
                    } else {
                        $.ajax({
                            type: 'post',
                            url: 'http://myeghamat.com/api/user_forms_data/' + userAssetId,
                            headers: {
                                'Accept': 'application/json',
                                "Authorization": token
                            },
                            data: fields[0],
                            success: function(res) {
                                if (res.status === "0") {
                                    console.log("save shode");
                                } else {
                                    console.log('store NOk');
                                }
                            }
                        });
                        // window.location.href = '/asset/' + assetId + "/step/" + nextFormId + "/" + userAssetId;
                    }
                    // todp: call update asset api
                    // check if form has img, call set pic api
                } else {
                    $.ajax({
                        type: 'post',
                        url: 'http://myeghamat.com/api/user_forms_data/' + userAssetId,
                        headers: {
                            'Accept': 'application/json',
                            "Authorization": token
                        },
                        data: {
                            data: fields.map(e => {
                                return {
                                    id: e.id,
                                    data: e.data
                                }
                            })
                        },
                        success: function(res) {
                            console.log(res)
                            if (res.status === 0) {
                                console.log("save shode");
                            } else {
                                console.log('store NNOk');
                            }
                        }
                    });
                }
            }

            function nextStep() {

                var errorText = "";
                var $inputs = $('.inputBoxTour :input');

                // An array of just the ids...
                var fields = [];
                var radioFields = [];
                var checkBoxFields = [];

                $inputs.each(function() {
                    if ($(this).attr('id') === 'selectStateForSelectCity')
                        return;
                    if ($(this).attr('id') === 'inputSearchCity')
                        return;
                    if ($(this).attr('data-change') === '0')
                        return;
                    if ($(this).hasClass('mapMark')) {
                        $(this).val(z);
                    }


                    if ($(this).attr('type') === 'checkbox') {

                        let checkName = $(this).attr('name');
                        let tmp = checkBoxFields.find(e => e.name == checkName);

                        if (tmp === undefined) {

                            let tmpArr = [];
                            $("input[type='checkbox'][name='" + checkName + "']:checked").each(function() {
                                tmpArr.push($(this).val());
                            });

                            tmp = {
                                id: $(this).attr('data-id'),
                                hasSelected: tmpArr.length > 0,
                                name: checkName,
                                value: tmpArr.join("_"),
                                isRequired: $(this).attr('required')
                            };
                            checkBoxFields.push(tmp);
                        }

                        return;

                    }
                    if ($(this).attr('type') === 'radio') {

                        let id = $(this).attr('id');

                        let tmp = radioFields.find(e => e.id == id);
                        if (tmp === undefined) {
                            tmp = {
                                id: id,
                                hasSelected: false,
                                name: $(this).attr('name'),
                                isRequired: $(this).attr('required')
                            };
                            radioFields.push(tmp);
                        }

                        if (!$(this).is(':checked'))
                            return;
                        else
                            tmp.hasSelected = true;

                    } else {

                        if ($(this).attr('required')) {
                            if ($(this).val() === '') {
                                errorText += '<ul class="errorList"> ';
                                errorText += "<li> " + $(this).attr('name') + ' ' + 'پر شود ' + "</li></ul>";
                            }
                        }
                    }

                    fields.push({
                        id: $(this).attr('id'),
                        data: $(this).val()
                    });
                });

                console.log(fields);

                radioFields.forEach(e => {
                    if (e.isRequired && !e.hasSelected) {
                        errorText += '<ul class="errorList"> ';
                        errorText += "<li> " + e.name + ' ' + 'پر شود ' + "</li></ul>";
                    }
                });
                checkBoxFields.forEach(e => {

                    if (e.isRequired && !e.hasSelected) {
                        errorText += '<ul class="errorList"> ';
                        errorText += "<li> " + e.name + ' ' + 'پر شود ' + "</li></ul>";
                    } else {

                        fields.push({
                            id: e.id,
                            data: e.value
                        });
                    }
                });

                if (errorText.length > 0)
                    openErrorAlertBP(errorText);
                else {
                    if (nextFormId !== undefined) {
                        console.log('moooz');
                        storeData(fields);
                    }
                }

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

                            if (i == 0)
                                firstStepFormId = res.forms[i].id;

                            if (res.forms[i].id == formId) {

                                if (i == 0)
                                    isInFirstStep = true;
                                else if (userAssetId === -1)
                                    window.location.href = '/asset/' + assetId + "/step/" + firstStepFormId;


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

            function openModal(x) {

                $.ajax({
                    type: 'get',
                    // url: 'http://myeghamat.com/api/asset/' + assetId + "/form",
                    url: 'http://myeghamat.com/api/form/' + x,
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        "Authorization": token
                    },
                    success: function(res) {
                        buildFormHtml(res, 'listMake', true);
                        tourPicUrl = 'http://myeghamat.com/api/user_asset/' + userAssetId +
                            '/add_pic_to_gallery_sub/' + picId + '/' + subAssetId + '/' + roomNum;
                        deleteTourPicUrl = 'http://myeghamat.com/api/' +
                            'user_sub_asset/31/delete_pic_from_gallery_sub/' + picId;
                        picCardSample = $('#picCardSample').html();
                        $('#picCardSample').remove();

                    }
                });
            }

            function buildFormHtml(res, resultBox, modal) {

                let text = "";
                let html = "";
                let needSearchCityModal = false;

                if (modal) {
                    html += '<h1>' + res.form.name + '</h1>';
                    html += '<div style="margin-top: 20px">';
                    html += '<h4>' + (res.form.description != null ? '' + res.form.description + '' : '') + '</h4>';
                    html += '<div>';
                    html += '<p>' + (res.form.notice != null ? '' + res.form.notice + '' : '') + ' </p>';
                    html += '</div>';
                    html += '</div>';
                    $('#formModal').empty().append(html);
                }
                for (let i = 0; i < res.fields.length; i++) {
                    text += '<div class="relative-position inputBoxTour" style="width: ' + (res.fields[i].half == 1 ? '50%' :
                        '100%') + ';flex-direction: ' + (res.fields[i].type == 'listview' ? ' column' : '') + '">';
                    if (res.fields[i].type == 'radio') {
                        text += '<p>' + res.fields[i].name + '</p>';
                        text +=
                            '<div class="btn-group btn-group-toggle" data-toggle="buttons">';
                        for (let x = 0; x < res.fields[i].options.length; x++) {
                            text += '<label class="btn btn-secondary ' + (res.fields[i].data == res.fields[i].options[x] ?
                                    'active' : '') + '" for="' + res.fields[i].options[x] + '">' + res
                                .fields[i].options[x] + '';
                            text += '<input type="radio" value="' + res.fields[i].options[x] + '" name="' + res.fields[
                                    i].name + '" id="' + res.fields[i].field_id +
                                '" ' + (res.fields[i].data == res.fields[i].options[x] ?
                                    'checked ' : ' ') + (res.fields[i].necessary == 1 ? 'required ' : '') + '>';
                            text += '</label>';

                        }
                        text += '</div>';
                    } else if (res.fields[i].type == 'checkbox') {

                        text += '<p>' + res.fields[i].name + '</p>';
                        text +=
                            '<div class="btn-group btn-group-toggle" data-toggle="buttons">';

                        let data = res.fields[i].data !== undefined && res.fields[i].data != '' ?
                            res.fields[i].data.split("_") : [];


                        for (let x = 0; x < res.fields[i].options.length; x++) {

                            let isSelected = data.indexOf(res.fields[i].options[x]) !== -1;


                            text += '<label class="btn btn-secondary ' + (isSelected ? 'active' : '') + '" for="' + res.fields[
                                    i]
                                .options[
                                    x] + '">' + res.fields[i].options[x] + '';
                            text += '<input type="checkbox" value="' + res.fields[i].options[x] + '" name="' + res.fields[i]
                                .name + '"  data-id="' + res.fields[i].field_id +
                                '" ' + (isSelected ?
                                    'checked ' : ' ') + (res.fields[i].necessary == 1 ? 'required ' : '') + '>';
                            text += '</label>';

                        }
                        text += '</div>';
                    } else if (res.fields[i].type == 'string') {
                        text += '<div class="inputBoxTextGeneralInfo inputBoxText">';
                        text += '<div class="' + (res.fields[i].necessary == 1 ?
                            ' importantFieldLabel' :
                            '') + '"> ' + res.fields[i].name + '</div>';
                        text += '</div>';

                        text += '<input type="text" data-change="' + (res.fields[i].data != null ? '0' : '1') +
                            '" value="' + (res.fields[i].data != null ? '' + res.fields[i].data + '' : '') + '" id="' + res
                            .fields[i].field_id +
                            '" class="inputBoxInput" name="' + res.fields[i].name +
                            '" placeholder="' + (res.fields[i].placeholder != null ? '' + res.fields[i].placeholder + '' : '') +
                            '"' + (res
                                .fields[i]
                                .necessary == 1 ? 'required ' : '') + ' >';
                    } else if (res.fields[i].type == 'time') {
                        text +=
                            '<div class="inputBoxTextGeneralInfo inputBoxText clockTitle">';
                        text += '<div class=" name' + (res.fields[i].necessary == 1 ?
                            ' importantFieldLabel' :
                            '') + '"> ' + res.fields[i].name + '</div>';
                        text += '</div>';
                        text += '<input type="text" value="' + (res.fields[i].data != null ? '' + res.fields[i].data + '' :
                                '') + '" value="' + (res.fields[i].data != null ? '' + res.fields[i].data +
                                '' :
                                '') + '" name="' + res.fields[i].name +
                            '" id="' + res
                            .fields[i]
                            .field_id +
                            '" class="form-control clockP" placeholder="' + (res.fields[i]
                                .placeholder !=
                                null ?
                                '' + res.fields[i].placeholder + '' : '') + '"' + (res
                                .fields[i]
                                .necessary == 1 ? 'required ' : '') + ' >';
                    } else if (res.fields[i].type == 'int') {
                        text += '<div class="inputBoxTextGeneralInfo inputBoxText">';
                        text += '<div class="' + (res.fields[i].necessary == 1 ?
                            ' importantFieldLabel' :
                            '') + '"> ' + res.fields[i].name + '</div>';
                        text += '</div>';
                        text += '<input type="number" value="' + (res.fields[i].data != null ? '' + res.fields[i].data +
                                '' :
                                '') + '" name="' + res.fields[i].name +
                            '" id="' + res
                            .fields[
                                i].field_id +
                            '" class="inputBoxInput" placeholder="' + (res.fields[i]
                                .placeholder !=
                                null ?
                                '' + res.fields[i].placeholder + '' : '') + '"' + (res
                                .fields[i]
                                .necessary == 1 ? 'required ' : '') + ' >';
                    } else if (res.fields[i].type == 'listview') {
                        for (let x = 0; x < res.fields[i].options.length; x++) {
                            subAssetId = res.fields[i].options[x];
                        }
                        for (let y = 0; y < res.fields[i].items.length; y++) {
                            text += '<div style="display:flex;flex-direction: column">';
                            text += '<div class="inputBoxTextGeneralInfo inputBoxText inputBoxTour">';
                            text += '<div class="' + (res.fields[i].necessary == 1 ?
                                ' importantFieldLabel' :
                                '') + '"> ' + res.fields[i].name + '</div>';
                            text += '<input type="text" data-change="' + (res.fields[i].data != null ? '0' : '1') +
                                '" value="' + res.fields[i].items[y].fields[0].key_ + '" id="' + res.fields[i].items[y].id +
                                '" class="inputBoxInput" name="' + res.fields[i].name +
                                '" placeholder="' + (res.fields[i].placeholder != null ? '' + res.fields[i].placeholder + '' :
                                    '') +
                                '"' + (res
                                    .fields[i]
                                    .necessary == 1 ? 'required ' : '') + ' >';
                            text += '</div>';


                            text += '<div id="uploadImgDiv" class="fullwidthDiv">';
                            text += '<div id="picDiv0" style="display: inline-block; width: 23%; position: relative">';
                            text +=
                                '<input class="input-file" id="picsInput_0" name="pics[]" accept="image/*" type="file" onchange="readURL(this, 0);" style="display: none">';
                            text += '<div id="picHover_0" class="uploadHover hidden">';
                            text += '<div class="tickIcon hidden"></div>';
                            text += '<div class="warningIcon hidden"> اشکال در بارگذاری</div>';
                            text += '<div class="process">';
                            text += '<div class="lds-ring">';
                            text += '<div></div>';
                            text += '<div></div>';
                            text += '</div>';
                            text += '<div class="processCounter">0%</div>';
                            text += '</div>';
                            text += '<div class="hoverInfos">';
                            text += '<div class="cancelButton closeIconWithCircle" onclick="deleteThisPic(0)">حذف عکس</div>';
                            text += '</div>';
                            text += '</div>';
                            text +=
                                '<label tabindex="0" for="picsInput_0" class="input-file-trigger"style="position: relative; width: 100%; margin: 0px;">';
                            text +=
                                '<div class="imgUploadsTourCreation imgAddDivTourCreation uploadImgCenter" style="width: 100%">';
                            text += '<div id="addPic0" class="addPicText" style="width: 100%">';
                            text += ' <img src="{{ URL::asset('images/tourCreation/add.png') }}">';
                            text += '<b>اضافه کنید</b>';
                            text += '</div>';
                            text += '<div id="showPic0" class="imgUploadsTourCreation hidden" style="width: 100%;">';
                            text += ' <img id="imgPic0" class="resizeImgClass" onload="fitThisImg(this)">';
                            text += '</div>';
                            text += '</div>';
                            text += ' </label>';
                            text += '</div>';
                            text += '</div>';
                            text += '<div id="picCardSample" style="display: none;">';
                            text +=
                                '<div id="picDiv##index##" data-value="##index##" style="display: inline-block; width: 23%; position: relative">';
                            text +=
                                '<input class="input-file" id="picsInput_##index##" type="file" accept="image/*"onchange="readURL(this, ##index##)" style="display: none">';
                            text += '<div id="picHover_##index##" class="uploadHover hidden">';
                            text += '<div class="tickIcon hidden"></div>';
                            text += '<div class="warningIcon hidden"> اشکال در بارگذاری</div>';
                            text += '<div class="process">';
                            text += '<div class="lds-ring">';
                            text += '<div></div>';
                            text += '<div></div>';
                            text += '<div></div>';
                            text += '<div></div>';
                            text += '</div>';
                            text += '<div class="processCounter">0%</div>';
                            text += '</div>';
                            text += '<div class="hoverInfos">';
                            text +=
                                '<div class="cancelButton closeIconWithCircle" onclick="deleteThisPic(##index##)">حذف عکس</div>';
                            text += '</div>';
                            text += '</div>';
                            text +=
                                '<label tabindex="##index##" for="picsInput_##index##" class="input-file-trigger"style="position: relative; width: 100%; margin: 0px;">';
                            text +=
                                '<div class="imgUploadsTourCreation imgAddDivTourCreation uploadImgCenter" style="width: 100%">';
                            text += '<div id="addPic##index##" class="addPicText" style="width: 100%">';
                            text += '<img src="{{ URL::asset('images/tourCreation/add.png') }}">';
                            text += ' <b>اضافه کنید</b>';
                            text += '</div>';
                            text += '<div id="showPic##index##" class="imgUploadsTourCreation hidden" style="width: 100%;">';
                            text += '<img id="imgPic##index##" class="resizeImgClass" src="" onload="fitThisImg(this)">';
                            text += '</div>';
                            text += '</div>';
                            text += ' </label>';
                            text += '</div>';
                            text += '</div>';
                            text += '</div>';
                        }
                    } else if (res.fields[i].type == 'gallery') {
                        picId = res.fields[i].field_id;

                        text += '<div class="inputBoxTextGeneralInfo inputBoxText">';
                        text += '<div class="' + (res.fields[i].necessary == 1 ?
                            ' importantFieldLabel' :
                            '') + '"> ' + res.fields[i].name + '</div>';
                        text += '</div>';
                        text += '<div id="uploadImgDiv" class="fullwidthDiv">';
                        text += '<div id="picDiv0" style="display: inline-block; width: 23%; position: relative">';
                        text +=
                            '<input class="input-file" id="picsInput_0" name="pics[]" accept="image/*" type="file" onchange="readURL(this, 0);" style="display: none">';
                        text += '<div id="picHover_0" class="uploadHover hidden">';
                        text += '<div class="tickIcon hidden"></div>';
                        text += '<div class="warningIcon hidden"> اشکال در بارگذاری</div>';
                        text += '<div class="process">';
                        text += '<div class="lds-ring">';
                        text += '<div></div>';
                        text += '<div></div>';
                        text += '</div>';
                        text += '<div class="processCounter">0%</div>';
                        text += '</div>';
                        text += '<div class="hoverInfos">';
                        text += '<div class="cancelButton closeIconWithCircle" onclick="deleteThisPic(0)">حذف عکس</div>';
                        text += '</div>';
                        text += '</div>';
                        text +=
                            '<label tabindex="0" for="picsInput_0" class="input-file-trigger"style="position: relative; width: 100%; margin: 0px;">';
                        text +=
                            '<div class="imgUploadsTourCreation imgAddDivTourCreation uploadImgCenter" style="width: 100%">';
                        text += '<div id="addPic0" class="addPicText" style="width: 100%">';
                        text += ' <img src="{{ URL::asset('images/tourCreation/add.png') }}">';
                        text += '<b>اضافه کنید</b>';
                        text += '</div>';
                        text += '<div id="showPic0" class="imgUploadsTourCreation hidden" style="width: 100%;">';
                        text += ' <img id="imgPic0" class="resizeImgClass" onload="fitThisImg(this)">';
                        text += '</div>';
                        text += '</div>';
                        text += ' </label>';
                        text += '</div>';
                        text += '</div>';
                        text += '<div id="picCardSample" style="display: none;">';
                        text +=
                            '<div id="picDiv##index##" data-value="##index##" style="display: inline-block; width: 23%; position: relative">';
                        text +=
                            '<input class="input-file" id="picsInput_##index##" type="file" accept="image/*"onchange="readURL(this, ##index##)" style="display: none">';
                        text += '<div id="picHover_##index##" class="uploadHover hidden">';
                        text += '<div class="tickIcon hidden"></div>';
                        text += '<div class="warningIcon hidden"> اشکال در بارگذاری</div>';
                        text += '<div class="process">';
                        text += '<div class="lds-ring">';
                        text += '<div></div>';
                        text += '<div></div>';
                        text += '<div></div>';
                        text += '<div></div>';
                        text += '</div>';
                        text += '<div class="processCounter">0%</div>';
                        text += '</div>';
                        text += '<div class="hoverInfos">';
                        text +=
                            '<div class="cancelButton closeIconWithCircle" onclick="deleteThisPic(##index##)">حذف عکس</div>';
                        text += '</div>';
                        text += '</div>';
                        text +=
                            '<label tabindex="##index##" for="picsInput_##index##" class="input-file-trigger"style="position: relative; width: 100%; margin: 0px;">';
                        text +=
                            '<div class="imgUploadsTourCreation imgAddDivTourCreation uploadImgCenter" style="width: 100%">';
                        text += '<div id="addPic##index##" class="addPicText" style="width: 100%">';
                        text += '<img src="{{ URL::asset('images/tourCreation/add.png') }}">';
                        text += ' <b>اضافه کنید</b>';
                        text += '</div>';
                        text += '<div id="showPic##index##" class="imgUploadsTourCreation hidden" style="width: 100%;">';
                        text += '<img id="imgPic##index##" class="resizeImgClass" src="" onload="fitThisImg(this)">';
                        text += '</div>';
                        text += '</div>';
                        text += ' </label>';
                        text += '</div>';
                        text += '</div>';
                        text += '</div>';

                    } else if (res.fields[i].type == 'redirector') {
                        text += '<div class="inputBoxTextGeneralInfo inputBoxText ">';
                        text += '<div class="' + (res.fields[i].necessary == 1 ?
                            ' importantFieldLabel' :
                            '') + '"> ' + res.fields[i].name + '</div>';
                        text += '</div>';
                        for (let x = 0; x < res.fields[i].options.length; x++) {

                            text += '<button type="button" onclick="openModal(' + res.fields[i].options[x] +
                                ')">اضافه کردن</button>';
                        }
                    } else if (res.fields[i].type == 'float') {
                        text += '<div class="inputBoxTextGeneralInfo inputBoxText">';
                        text += '<div class="' + (res.fields[i].necessary == 1 ?
                            ' importantFieldLabel' :
                            '') + '"> ' + res.fields[i].name + '</div>';
                        text += '</div>';
                        text += '<input type="number" step="0.01" value="' + (res.fields[i].data != null ? '' + res.fields[i]
                                .data +
                                '' :
                                '') + '" name="' + res.fields[i].name +
                            '" id="' + res
                            .fields[
                                i].field_id +
                            '" class="inputBoxInput" placeholder="' + (res.fields[i]
                                .placeholder !=
                                null ?
                                '' + res.fields[i].placeholder + '' : '') + '"' + (res
                                .fields[i]
                                .necessary == 1 ? 'required ' : '') + ' >';
                    } else if (res.fields[i].type == 'file') {
                        text += '<div class="inputBoxTextGeneralInfo inputBoxText">';
                        text += '<div class="' + (res.fields[i].necessary == 1 ?
                            ' importantFieldLabel' :
                            '') + '"> ' + res.fields[i].name + '</div>';
                        text += '</div>';
                        text += '<input data-change="' + (res.fields[i].data != null ? '0' : '1') +
                            '" type="file" value="' + (
                                res.fields[i].data != null ? '' + res.fields[i].data + '' :
                                '') + '" name="' + res.fields[i].name +
                            '" id="' + res
                            .fields[
                                i].field_id +
                            '" class="inputBoxInput file" placeholder="' + (res.fields[i]
                                .placeholder !=
                                null ?
                                '' + res.fields[i].placeholder + '' : '') + '"' + (res
                                .fields[i]
                                .necessary == 1 ? 'required ' : '') + ' >';
                        text += '<div><img src="' + res.fields[i].data + '" class="" alt="25"></div>';
                    } else if (res.fields[i].type == 'map') {
                        callMap();
                        text += '<div class="inputBoxTextGeneralInfo inputBoxText">';
                        text += '<div class="' + (res.fields[i].necessary == 1 ?
                            ' importantFieldLabel' :
                            '') + '"> ' + res.fields[i].name + '</div>';
                        text += '</div>';
                        text += '<div class="select-side locationIconTourCreation">';
                        text += '<i class="ui_icon  locationIcon"></i>';
                        text += '</div>';
                        text += '<input type="text" value="' + (res.fields[i].data != null ? '' + res.fields[i].data + '' :
                                '') + '" name="' + res.fields[i].name +
                            '" id="' + res
                            .fields[i]
                            .field_id +
                            '" class="inputBoxInput mapMark" placeholder="' + (res.fields[i]
                                .placeholder !=
                                null ?
                                '' + res.fields[i].placeholder + '' : '') + '"' + (res
                                .fields[i]
                                .necessary == 1 ? 'required ' : '') + ' >';
                    } else if (res.fields[i].type == 'api') {
                        needSearchCityModal = true;
                        city = res.fields[i].options[0].replace('koochita', 'mykoochita')
                            .replace(
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

                        text += '<input value="' + (res.fields[i].data != null ? '' + res.fields[i].data + '' : '') +
                            '" type="text" id="' + res.fields[i]
                            .field_id +
                            '" class="inputBoxInput" name="' + res.fields[i].name +
                            '" placeholder="' +
                            (res
                                .fields[i].placeholder != null ?
                                '' + res.fields[i].placeholder + '' : '') + '"' + (res
                                .fields[i]
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
                        text += '<textarea name="' + res.fields[i].name + '" id="' + res
                            .fields[i]
                            .field_id +
                            '" class="inputBoxInput fullwidthDiv text-align-right full-height textareaInForDescription"  placeholder="' +
                            (res.fields[i].placeholder != null ?
                                '' + res.fields[i].placeholder + '' : '') + '"' + (res
                                .fields[i]
                                .necessary == 1 ? 'required ' : '') + ' >' + (res.fields[i].data != null ? '' + res.fields[i]
                                .data + '' : '') + '</textarea>';
                    } else if (res.fields[i].type == 'calendar') {
                        text += '<div class="inputBoxTextGeneralInfo inputBoxText">';
                        text += '<div class="' + (res.fields[i].necessary == 1 ?
                            ' importantFieldLabel' :
                            '') + '"> ' + res.fields[i].name + '</div>';
                        text += '</div>';
                        text += '<div class="select-side calendarIconTourCreation">';
                        text += '<i class="ui_icon calendar calendarIcon"></i>';
                        text += '</div>';
                        text += ' <input value="' + (res.fields[i].data != null ? '' + res.fields[i].data + '' : '') +
                            '" name="' + res.fields[i].name +
                            '" name="sDateNotSame[]" id="' +
                            res
                            .fields[i].field_id +
                            '" class="observer-example inputBoxInput"type="text" placeholder="' +
                            (
                                res
                                .fields[i].placeholder != null ?
                                '' + res.fields[i].placeholder + '' : '') + '"' + (res
                                .fields[i]
                                .necessary == 1 ? 'required ' : '') + ' >';
                        text += '';
                        calenderId = res.fields[i].field_id;
                    } else {
                        text += '<div class="inputBoxTextGeneralInfo inputBoxText">';
                        text += '<div class="' + (res.fields[i].necessary == 1 ?
                            ' importantFieldLabel' :
                            '') + '"> ' + res.fields[i].name + '</div>';
                        text += '</div>';
                        text += '<input name="' + res.fields[i].name + '" type="' + res
                            .fields[i]
                            .type +
                            '" id="' + res.fields[i].field_id +
                            '" class="inputBoxInput" placeholder="' + (res.fields[i]
                                .placeholder !=
                                null ?
                                '' + res.fields[i].placeholder + '' : '') + '"' + (res
                                .fields[i]
                                .necessary == 1 ? 'required ' : '') + ' >';
                    }
                    text += '</div>';
                    if (res.fields[i].force_help != null) {
                        text += '<figcaption style="width: 100%;"> ' + res.fields[i]
                            .force_help +
                            '';
                        text += '</figcaption>';
                    }
                    text += '';
                    text += '';
                    text += '';
                }
                $('#' + resultBox).empty().append(text);
                $(".clockP").clockpicker(clockOptions);
                $(".observer-example").datepicker(datePickerOptions);
                if (!needSearchCityModal)
                    $("#addCityModal").remove();
            }

            function callMap() {
                mapboxgl.setRTLTextPlugin(
                    'https://cdn.parsimap.ir/third-party/mapbox-gl-js/plugins/mapbox-gl-rtl-text/v0.2.3/mapbox-gl-rtl-text.js',
                    null,
                );

                const map = new mapboxgl.Map({
                    container: 'map',
                    accessToken: "pk.eyJ1Ijoic29saXNoIiwiYSI6ImNsZGExdmJ5bjBkemQzcHN6NzVhbXJidXcifQ.s8Crrxn4TRmtd8pZ5M3Sww",
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
                    z = x + " " + y;
                }

                map.on('click', addMarker);
            }
            $(document).ready(function() {


                $(document).on('change', 'input', function() {
                    $(this).attr('data-change', '1');
                });

                if (userAssetId != -1) {
                    $.ajax({
                        type: 'get',
                        url: 'http://myeghamat.com/api/form/' + formId + '/' + userAssetId,
                        headers: {
                            'Accept': 'application/json',
                            "Authorization": token
                        },
                        success: function(res) {
                            console.log(res);
                            var text = '';
                            if (res.status === 0) {
                                buildFormHtml(res, 'boxMake', false);
                            }
                        }
                    });
                } else {
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
                            buildFormHtml(res, 'boxMake', false);
                        }
                    });
                }
            });

            var assetRoom = -1;
            var picId;
            var subAssetId;
            var tourPicUrl = '';
            var deleteTourPicUrl = '';
            var uploadProcess = false;
            var uploadProcessId = null;
            var uploadedPics = [];
            var picQueue = [];
            var picInput = 1;
            var picCardSample = '';

            function readURL(input, _index) {

                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    var text = picCardSample;
                    text = text.replace(new RegExp('##index##', 'g'), picInput);

                    $('#picHover_' + _index).removeClass('hidden');
                    $('#showPic' + _index).removeClass('hidden');
                    $('#addPic' + _index).addClass('hidden');
                    picInput++;

                    reader.onload = e => {
                        $('#imgPic' + _index).attr('src', e.target.result);
                        $('#uploadImgDiv').append(text);
                    };
                    reader.readAsDataURL(input.files[0]);

                    picQueue.push({
                        id: _index,
                        uploadedName: input.files[0].name,
                        process: 0,
                    });
                    checkUpload();
                }
            }

            function checkUpload() {
                var index = null;
                if (!uploadProcess) {
                    picQueue.forEach((item, _index) => {
                        if (item.process == 0 && index == null) {
                            item.process = 1;
                            index = _index;
                        }
                    });
                    console.log(picQueue);
                    if (index != null) {
                        uploadProcess = true;
                        uploadProcessId = picQueue[index].id;
                        var file = document.getElementById(`picsInput_${uploadProcessId}`).files;
                        uploadLargeFile(tourPicUrl, file[0], {
                                //tourId: tour.id
                            }, uploadPicResult,
                            'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI0IiwianRpIjoiNDNjNWY4YzE0NGQ3YmE5NjNlMzNlYjUxNGQwZjQxODFjZGEwZmUzOTdkMDdhNDYyOGNhNDIwYmQ3OTM5M2FjMjRhNGEyM2VkMWZhMDlmMDEiLCJpYXQiOjE2ODY1NTQzOTQuODk5OTcyLCJuYmYiOjE2ODY1NTQzOTQuODk5OTc3LCJleHAiOjE3MTgxNzY3OTQuNzA0ODg2LCJzdWIiOiIyNCIsInNjb3BlcyI6W119.mZ46Gw-eW5rTBSeT7O7-sUYDyWJAMbMTmslvH9NWHb70wN5svyaUSirhIP9nCU8boiMubFcRC1KOi3WVn5CuUhbtkxmyO9M88CkodEu3DYwLFHg0soc5kCLLHuSJ6juKuVRgl5CtYacFHaRFSPhsnN_RRbf3EF3ooUeFgZlxU8gO3QK0yeBYoiCG4TlJMpQh5rx3iBxqwzKUsTxfXMRyt2ijK-dZtvbUhHIFXzx7aNkn-IRH0S-p2gCrTgifHIorWyLstk1clTTLYmNghrfVPDNXAjtK7wrUc-jFY-2yLIIqRzClTX1OvkSdOiBlrGHUZt7MrlcjgFkP0AxkNQ26WkDJ2fwPadlxa_Wr_mUv8zQ7rUvPGTt2Wt0xxQip9HHJL4aUsHN-9X44UQ501rKnWC-tHFBnMnpXi6pZED8zG0cd-MfYxNZ_xGwgO1-jrpGYvZ1zXR3RDoy33dd7MyA5pOfUDXlVqUYmpuNR3_MsSJGIFWm3G0MGLH1KdVD8ho_Kd2Wiqnq9N6uXICgKHrdmSFR87QNDfTowg-b3Ok_1BQR42CCpW7cHEPI5jIPSy5_v4fsxqzwzNfSNf3VkhZ9LorMA-OCzmaVXsJQpChvsfSwkVTXb4NpDJtEKb9E5JAHb3boxPVDB6RDFNMqHS_RKbcXQmo8xgep8qXKDFOQ2QcA'
                        );
                    }
                }
            }

            function uploadPicResult(_status, _fileName = '') {
                console.log(_fileName);
                var element = $(`#picHover_${uploadProcessId}`);
                var porcIndex = null;
                picQueue.map((item, index) => {
                    if (item.id == uploadProcessId && porcIndex == null)
                        porcIndex = index;
                });
                if (_status == 'done') {
                    picQueue[porcIndex].process = 2;
                    element.find('.process').addClass('hidden');
                    element.find('.tickIcon').removeClass('hidden');
                    picQueue[porcIndex].uploadedName = _fileName;

                    uploadProcessId = null;
                    uploadProcess = false;
                }
                // else if (_status == 'error') {
                //     picQueue[porcIndex].process = -1;
                //     element.find('.process').addClass('hidden');
                //     element.find('.warningIcon').removeClass('hidden');
                //     uploadProcessId = null;
                //     uploadProcess = false;
                //     setTimeout(checkUpload, 200);
                // } else if (_status == 'cancelUpload') {
                //     element.find('.process').addClass('hidden');
                //     $('#picDiv' + uploadProcessId).remove();
                //     picQueue.splice(porcIndex, 1);
                //     uploadProcessId = null;
                //     uploadProcess = false;
                //     setTimeout(checkUpload, 200);
                // } else if (_status == 'queue') {

                //     setTimeout(checkUpload, 200);
                // } 
                else {

                    picQueue[porcIndex].uploadedName = _fileName;
                    element.find('.processCounter').text(_status + '%');
                }
            }

            function deleteThisPic(_id) {

                if (uploadProcessId == _id)
                    cancelLargeUploadedFile();
                else {
                    var deleteIndex = null;
                    var deleteId = null;
                    picQueue.map((item, index) => {
                        if (item.id == _id) {
                            deleteIndex = index;
                            deleteId = item.id;
                        }
                    });
                    if (deleteIndex != null) {
                        $('#picDiv' + deleteId).remove();
                        if (picQueue[deleteIndex].process == 2)
                            deletedUploadedPic(picQueue[deleteIndex].uploadedName);
                        picQueue.splice(deleteIndex, 1);
                    }
                }
            }

            function deletedUploadedPic(_fileName) {
                $.ajax({
                    type: 'DELETE',
                    url: deleteTourPicUrl,
                    headers: {
                        "Authorization": token
                    },
                    data: {
                        // tourId: tour.id,
                        pic: _fileName,
                    }
                })
            }

            uploadedPics.map((item, index) => {
                var text = picCardSample;
                text = text.replace(new RegExp('##index##', 'g'), picInput);
                $('#uploadImgDiv').append(text);
                picInput++;

                picQueue.push({
                    id: index,
                    uploadedName: item.pic,
                    process: 2,
                });

                $('#showPic' + index).removeClass('hidden');
                $('#addPic' + index).addClass('hidden');
                $('#imgPic' + index).attr('src', item.url);

                var element = $('#picHover_' + index);
                element.removeClass('hidden');
                element.find('.process').addClass('hidden');
                element.find('.tickIcon').removeClass('hidden');

            });
        </script>

    @stop
