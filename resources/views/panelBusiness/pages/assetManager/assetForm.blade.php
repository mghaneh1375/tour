@extends('panelBusiness.layout.baseLayout')

@section('head')
    <title>پنل تعریف کسب و کار</title>
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css' rel='stylesheet' />
    <script async src="{{ URL::asset('js/bootstrap-datepicker.js') }}"></script>
    <script src={{ URL::asset('js/clockpicker.js') }}></script>
    <script src="https://unpkg.com/jalali-moment/dist/jalali-moment.browser.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-element-bundle.min.js"></script>
    <script src="{{ asset('js/newck/ckeditor5/ckeditorUpload.js') }}"></script>
    <script src="{{ asset('js/newck/ckeditor5/ckeditor.js') }}"></script>
    <script defer src="{{ URL::asset('js/uploadLargFile.js?v=' . $fileVersions) }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/clockpicker.css?v=2') }}" />
    <link rel="stylesheet" href="{{ URL::asset('css/theme2/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/shazdeDesigns/tourCreation.css?v=11') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/form.css?v=' . $fileVersions) }}" />
    <link rel="stylesheet" href="{{ URL::asset('BusinessPanelPublic/css/createBusinessPage.css?v=' . $fileVersions) }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/common.css?v=' . $fileVersions) }}" />
    <style>
        input[type="search"]::-webkit-search-cancel-button:hover {
            cursor: pointer;
        }

        .textEditor {
            width: 100%;
        }

        .mainBodySection {
            top: unset;
        }

        input::file-selector-button {
            display: none;
        }

        input[type="checkbox"],
        input[type="radio"] {
            display: unset !important;
        }

        .btn-group>label {
            padding: 10px 8px;
        }

        .whiteBox {
            border-bottom: unset;
        }
    </style>
@endsection

@section('body')

    <div class="mainBackWhiteBody">
        <div class="whiteBox">
            <div id="formMake"></div>
            <div id="searchForm"></div>
            <div id="boxMake" style="flex-direction:;"></div>
            <div class="row fullyCenterContent rowReverse SpaceBetween" style="padding: 15px;">
                <button class="btn nextStepBtnTourCreation nextPageVal" type="button" onclick="nextStep()">مرحله
                    بعد</button>
                <button class="btn nextStepBtnTourCreation goToPrevStep" type="button" onclick="prevStep()">مرحله
                    قبل</button>
            </div>

        </div>
    </div>
@endsection

@section('modals')
    <div class="modal fade" id="addCityModal" style="top:100px !important;">
        <div class="modal-dialog modal-lg" style="max-width: 500px !important">
            <div class="modal-content">
                <div class="modal-body" style="direction: rtl ;border-bottom: 1px solid #707070;">
                    <div class="fullwidthDiv">
                        <div class="addPlaceGeneralInfoTitleTourCreation">
                            شهر مورد نظر خود را اضافه کنید
                        </div>
                    </div>

                    <div class="row" style="display: flex;flex-direction: column;">
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
                        <div>
                            <p>ابتدا نام استان را انتخاب نماید. پس از وارد کردن نام شهر منتظر بمانید و از طریق لیست
                                نمایش داده شده نام شهر مدنظر خود را وارد کنید</p>
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
                <div class="modal-footerrow fullyCenterContent rowReverse SpaceBetween"
                    style="padding: 15px; text-align: center">
                    <button style="width: 20%;" id="goToForthStep" class="btn nextStepBtnTourCreation"
                        data-dismiss="modal">تأیید</button>
                    <button style="width: 20%;" class="btn nextStepBtnTourCreation goToPrevStep"
                        data-dismiss="modal">انصراف</button>
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
    <div class="modal fade" id="listAdd">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body" style="direction: rtl;overflow: auto;">
                    <div class="row">
                        <div class="col-md-12 mb-md-0 mb-4">
                            <div id="formModal"></div>
                            <div id="redirectList" style="width: 100%; height: 360px"></div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer" style="text-align: center">
                    <button onclick="saveModal()" value="Submit" id="addModal"
                        class="btn nextStepBtnTourCreation">تأیید</button>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('script')

    <script>
        var datePickerOptions = {
            yearRange: "-100:+10",
            changeYear: true,
            changeMonth: true,
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
        let allData;
        var dataToSend;
        let assetId = '{{ $assetId }}';
        let firstStepFormId;
        let formId = '{{ $formId }}';
        let prevFromId = undefined;
        let nextFormId = undefined;
        var moreItems = [];
        var roomName = [];
        var subAsset = [];
        let x = " ";
        let y = " ";
        var userFormDataId = null;
        let userAssetId = parseInt('{{ $userAssetId }}');
        var radioSet = '';
        var z;
        var allForm = 0;
        var formComplite = 0;
        var ageVal;
        var percent;
        var filePic = false;
        let isInFirstStep = false;
        var listview = false;
        var itemsVal = null;
        var addId = null;
        var fileId = null;
        var roomId = -1;
        var calenderId = null;
        var ckeditorId = null;
        var ckeditorId = null;
        var modal = false;
        var redirector = false;
        var subAssetFromId = null;
        var oneItems = false;
        var multipleVal = false;
        var ckeditorExist = false;
        var multiple = false;
        var initMap = false;
        var callInitMap = false;
        var formFieldPic = true;
        var cityName;
        var stateName;
        let url = '{{ route('formCreator.root') }}';
        let token = 'Bearer ' + localStorage.getItem("token");

        function storePic(userAssetId, fields) {
            openLoading();
            var fileStore = new FormData();
            fileStore.append('pic', $("#" + fileId)[0].files[0]);
            $.ajax({
                type: 'post',
                url: url + '/user_asset/' + userAssetId + "/set_asset_pic/" + fileId,
                processData: false,
                complete: closeLoading,
                contentType: false,
                headers: {
                    'Accept': 'application/json',
                },
                data: fileStore,
                success: function(res) {
                    if (res.status === "0") {
                        if (nextFormId !== undefined) {
                            window.location.href = '/asset/' + assetId + "/step/" + nextFormId + "/" +
                                userAssetId;
                        } else {
                            lastPage();
                        }
                    } else {}
                }
            });
        }

        function storeFieldFiles(fileIds, fields) {
            openLoading();
            storeFile($("#" + fileIds[0])[0].files[0], fields);
        }

        function storeFile(localFile, fields) {

            var fileStore = new FormData();
            fileStore.append('file', localFile);
            $.ajax({
                type: 'post',
                url: url + '/user_asset/' + userAssetId + "/set_formField_file/" + fileId,
                processData: false,
                complete: closeLoading,
                contentType: false,
                headers: {
                    'Accept': 'application/json',
                },
                data: fileStore,
                success: function(res) {
                    if (res.status === "0") {

                        formFieldPic = true;

                        if (fields.length > 0)
                            storeData(fields);

                    } else {}
                }
            });
        }

        function storeData(fields) {
            if (fields.length == 0) {
                if (nextFormId !== undefined) {
                    window.location.href = '/asset/' + assetId + "/step/" + nextFormId + "/" + userAssetId;
                    return;
                } else {
                    lastPage();
                }
            }
            if (isInFirstStep) {
                if (userAssetId === -1) {
                    openLoading();
                    $.ajax({
                        type: 'post',
                        complete: closeLoading,
                        url: url + '/asset/' + assetId + '/user_asset',
                        headers: {
                            'Accept': 'application/json',
                        },
                        data: fields[0],
                        success: function(res) {
                            if (res.status === "0") {
                                userAssetId = res.id;
                                if (filePic) {
                                    storePic(userAssetId, fields);
                                } else {
                                    window.location.href = '/asset/' + assetId + "/step/" + nextFormId + "/" +
                                        userAssetId;
                                }
                            } else {

                            }
                        }

                    });
                } else {
                    if (fields[0].id == fileId) {
                        storePic(userAssetId, fields);
                    } else {
                        openLoading();
                        $.ajax({
                            type: 'put',
                            complete: closeLoading,
                            url: url + '/user_asset/' + userAssetId,
                            headers: {
                                'Accept': 'application/json',
                            },
                            data: {
                                'data': fields[0].data
                            },
                            success: function(res) {
                                if (res.status === "0") {
                                    window.location.href = '/asset/' + assetId + "/step/" + nextFormId +
                                        "/" + userAssetId;
                                } else {
                                    showSuccessNotifiBP(res.errs, 'right', '#ac0020');

                                }
                            },
                            error: function(rejected) {
                                errorAjax(rejected);
                            }
                        });
                    }
                }
            } else {
                $.ajax({
                    type: 'post',
                    url: url + '/user_forms_data/' + userAssetId,
                    headers: {
                        'Accept': 'application/json',
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
                        console.log(res);
                        if (res.status === 0) {
                            if (nextFormId !== undefined) {
                                window.location.href = '/asset/' + assetId + "/step/" + nextFormId +
                                    "/" +
                                    userAssetId;
                            } else {
                                lastPage();
                            }
                        } else {
                            showSuccessNotifiBP(res.errs, 'right', '#ac0020');
                        }
                    },
                    // error: function(rejected) {
                    //     errorAjax(rejected);
                    // }
                });

            }
        }

        function lastPage() {
            openLoading();
            $.ajax({
                type: 'put',
                complete: closeLoading,
                url: url + '/user_asset/' + userAssetId + '/updateStatus',
                headers: {
                    'Accept': 'application/json',
                },

                success: function(res) {
                    if (res.status === "0") {
                        window.location.href = "{{ route('businessPanel.panel') }} "
                    } else {
                        showSuccessNotifiBP(res.errs, 'right', '#ac0020');
                    }
                },
                error: function(rejected) {
                    errorAjax(rejected);
                }
            });

        }

        function nextStep() {
            var errorText = "";
            var $inputs = $('.inputBoxTour :input');
            var fields = [];
            var radioFields = [];
            var checkBoxFields = [];

            let fileIds = [];

            if (ckeditorExist) {
                const editorData = editor.getData();
                fields.push({
                    id: ckeditorId,
                    data: editorData
                });
            }

            $("#boxMake").children().removeClass("errorInput");
            $inputs.each(function() {

                // $(this).parent().removeClass('errorInput');

                var inputAttr = $(this).attr('id');

                if (inputAttr === 'selectStateForSelectCity')
                    return;
                if (inputAttr === 'searchInput')
                    return;
                if (inputAttr === 'inputSearchCity')
                    return;
                if ($(this).attr('data-change') === '0')
                    return;
                if (!$(this).attr('required') && $(this).val() === '') {
                    return;
                }
                if (apiId !== null && inputAttr == apiId) {
                    fields.push({
                        id: $(this).attr('id'),
                        data: stateName + '$$' + cityName
                    });
                    return;
                }
                if (inputAttr === calenderId) {
                    if ($(this).val() !== '') {
                        underAgeValidate($(this).val());
                        if (ageVal === true) {
                            return
                        } else {
                            errorText += '<ul class="errorList"> ';
                            errorText += "<li> سن کمتر از ۱۸ سال است</li></ul>";
                            $(this).parent().addClass('errorInput');
                        }
                    }
                }
                if ($(this).hasClass('phone')) {
                    if (multiple) {
                        if (moreItems.length > 0) {
                            fields.push({
                                id: inputAttr,
                                data: moreItems.join("_")
                            });
                        } else {
                            if ($(this).attr('required')) {
                                if (moreItems.length < 1) {
                                    errorText += '<ul class="errorList"> ';
                                    errorText += "<li> " + $(this).attr('name') + ' ' + 'پر شود ' +
                                        "</li></ul>";
                                    $(this).parent().addClass('errorInput');
                                }
                            }
                        }
                        return;
                    }


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

                }
                if ($(this).attr('type') === 'file') {
                    if ($(this).val() !== '') {
                        fileIds.push(inputAttr);
                        return;
                    }
                }
                if ($(this).attr('required')) {
                    if ($(this).val() === '') {
                        errorText += '<ul class="errorList"> ';
                        errorText += "<li> " + $(this).attr('name') + ' ' + 'پر شود ' + "</li></ul>";
                        $(this).parent().addClass('errorInput');
                    }
                }

                fields.push({
                    id: inputAttr,
                    data: $(this).val()
                });
            });

            radioFields.forEach(e => {
                if (e.isRequired && !e.hasSelected) {
                    errorText += '<ul class="errorList"> ';
                    errorText += "<li> " + e.name + ' ' + 'پر شود ' + "</li></ul>";
                    $errors = $(".inputBoxTour .inputBoxText").find("[name='" + e.name + "']");
                    $errors.parent().parent().addClass('errorInput');
                }
            });
            checkBoxFields.forEach(e => {
                if (!e.isRequired && !e.hasSelected) {
                    return
                } else {
                    if (e.isRequired && !e.hasSelected) {
                        errorText += '<ul class="errorList"> ';
                        errorText += "<li> " + e.name + ' ' + 'پر شود ' + "</li></ul>";
                        $errors = $(".inputBoxTour .inputBoxText").find("[name='" + e.name + "']");
                        $errors.parent().parent().addClass('errorInput');
                    } else {

                        fields.push({
                            id: e.id,
                            data: e.value
                        });
                    }
                }
            });

            if (errorText.length > 0) {
                openErrorAlertBP(errorText);
            } else {
                if (fileIds.length > 0 && !isInFirstStep) {
                    storeFieldFiles(fileIds, fields);
                } else if (fields.length > 0) {
                    storeData(fields);
                } else {
                    if (nextFormId !== undefined) {
                        window.location.href = '/asset/' + assetId + "/step/" + nextFormId +
                            "/" +
                            userAssetId;
                    } else {
                        lastPage();
                    }
                }

            }

        }

        function prevStep() {
            if (prevFromId !== undefined) {
                window.location.href = '/asset/' + assetId + "/step/" + prevFromId + "/" + userAssetId;
            } else {
                window.location.href = '/createForm?isHaghighi=';
            }
        }
        openLoading();
        $.ajax({
            type: 'get',
            url: url + '/asset/' + assetId + "/form",
            complete: closeLoading,
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            success: function(res) {
                var html = '';

                if (res.status === 0) {

                    for (let i = 0; i < res.forms.length; i++) {
                        formExist = i;
                        allForm = res.forms.length;
                        if (i == 0)
                            firstStepFormId = res.forms[i].id;

                        if (res.forms[i].id == formId) {
                            if (i == 0)
                                isInFirstStep = true;
                            else if (userAssetId === -1)
                                window.location.href = '/asset/' + assetId + "/step/" + firstStepFormId;

                            html +=
                                '<div class="formTitle">';
                            html +=
                                '<div><h1 >' +
                                res.forms[i].name + '</h1> </div>';
                            html += '<div class="formTitleProgress">';
                            html += '<div class="progressBarSection" style="justify-content: space-evenly;">';
                            html += '<div class="progressBarDiv">';
                            html += '<div id="sideProgressBarFull" class="full"></div>';
                            html += '</div>';
                            html += '<div class="text" style="white-space: nowrap;">';
                            html += '<span id="sideProgressBarNumber">0%</span> کامل شده';
                            html += '</div>';
                            html += '</div>';
                            html += '';
                            html += '</div>';
                            html += '</div>';
                            html += '<div style="margin-top: 20px">';
                            html += '<p class="bold">' + (res.forms[i].description != null ? '' + res.forms[i]
                                .description + '' : '') + '</p>';
                            html += '<div>';
                            html += '<p>' + (res.forms[i].notice != null ? '' + res.forms[i].notice + '' : '') +
                                '</p>';
                            html += '</div>';
                            html += '</div>';

                            html += '';

                            if (i > 0)
                                prevFromId = res.forms[i - 1].id;
                            if (i < res.forms.length - 1) {
                                nextFormId = res.forms[i + 1].id;

                            }
                            if (nextFormId == undefined) {
                                $('.nextPageVal').empty().append("ثبت نهایی");

                            }
                            break;
                        }

                    }
                } else {}

                $('#formMake').empty().append(html);
                percent = (formExist / allForm) * 100;
                percent = Math.ceil(percent);
                updateSideProgressBar(percent);
            },
            error: function(request, status, error) {
                if (request.status === 404) {
                    window.location.href = '/404';
                }
            }
        });

        function searchForCity(_element) {
            var stateId = $("#selectStateForSelectCity").val();
            stateName = $("#selectStateForSelectCity option[value=" + stateId + "]").text();

            var value = $(_element).val().trim();
            var citySrcInput = $(_element);
            citySrcInput.next().empty();

            if (value.length > 1 && stateId != 0) {
                if (ajaxVar != null) ajaxVar.abort();
                openLoading();
                ajaxVar = $.ajax({
                    type: "GET",
                    complete: closeLoading,
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
            cityName = $(_element).text();
            $("#srcCityId").val(_id);
            $("#addCityModal").modal("hide");
            $(_element).parent().empty();
        }
        $('#addCityModal').on('hidden.bs.modal', function(e) {
            $(this)
                .find("input,textarea,select")
                .val('')
                .end()
                .find("input[type=checkbox], input[type=radio]")
                .prop("checked", "")
                .end();
        })

        function selectApi(_element) {
            $("#addCityModal").removeClass("displayBlock");
            $('#apiItemList').addClass('hidden');
            $("#${apiId}").val($(_element).text());
        }

        function underAgeValidate(birthday) {
            var myAge = parseInt(birthday.replaceAll("/", ""));
            let today = new Date().toLocaleDateString('fa-IR-u-nu-latn', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                formatMatcher: 'basic'
            });
            var todayInt = parseInt(today.replaceAll("/", ""));
            if (todayInt - myAge > 18000) {
                return ageVal = true;
            } else {
                return ageVal = false;
            }
        }

        function chooseSrcCityModal() {
            $("#addCityModal").modal("show");
        }
        $(document).on("click", ".mapMark", function() {
            $("#locMark").modal("show");
        });

        function saveModal() {
            var errorText = "";
            var $inputs = $('#redirectList :input');
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
                if ($(this).hasClass('input-file')) {
                    return;
                }
                if (!$(this).attr('required') && $(this).val() === '') {
                    return;
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
                            errorText += "<li> " + $(this).attr('name') + ' ' + 'پر شود ' +
                                "</li></ul>";
                        }
                    }
                }

                fields.push({
                    id: $(this).attr('id'),
                    data: $(this).val()
                });
            });
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
            if (errorText.length > 0) {
                openErrorAlertBP(errorText);
            } else {
                storeDataModal(fields);
                $('#addModal').attr("data-dismiss", "modal");
            }
        }

        function storeDataModal(fields) {
            $.ajax({
                type: 'post',
                url: url + '/user_forms_data/' + userAssetId,
                headers: {
                    'Accept': 'application/json',
                },

                data: {
                    data: fields,
                    sub_asset_id: subAssetId,
                    user_sub_asset_id: roomId

                },

                success: function(res) {
                    if (res.status == '0') {
                        userAssetId = res.id;
                        // location.reload();
                    } else {}
                },
                error: function(request, status, error) {
                    if (request.status === 500) {
                        showSuccessNotifiBP('خطایی در سرور به جود آمده است', 'right', '#ac0020');
                    }
                }

            });
        }

        function openModal(callBack = undefined) {

            if (callBack === undefined)
                roomId = -1;
            $("#listAdd").modal("show");
            modal = true;
            openLoading();
            $.ajax({
                type: 'get',

                url: url + '/form/' + subAssetFromId,
                complete: closeLoading,
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                success: function(res) {
                    buildFormHtml(res, 'redirectList', true);
                    tourPicUrl = url + '/user_asset/' + userAssetId + '/add_pic_to_gallery_sub/' + picId + '/' +
                        subAssetId + '/' + roomId;
                    deleteTourPicUrl = url + '/' + 'user_sub_asset/' + roomId +
                        '/delete_pic_from_gallery_sub/' + picId;
                    picCardSample = $('#picCardSample').html();
                    $('#picCardSample').remove();
                    if (callBack !== undefined)
                        callBack();

                }
            });
        }

        function addPhone() {
            var errorText = "";
            itemsVal = $("#" + addId).val();
            let x = true;
            if (moreItems.length < 2 && oneItems) {
                oneItems = false;
                moreItems = [];

            } else {
                moreItems.forEach((item) => {
                    if (item === itemsVal) {
                        x = false
                        errorText += '<ul class="errorList"> ';
                        errorText += "<li> محتوای وارد شده تکراری است</li></ul>";
                        openErrorAlertBP(errorText);
                    }
                })
            }
            if (x) {
                moreItems.push(itemsVal);
                $("#input-" + addId + "-items").append(
                    '<div class="itemsAdd"><div class="itemsDelete"onclick="deleteItems(' + itemsVal +
                    ',this)">حذف</div><div style="margin: auto;padding: 5px;">' +
                    itemsVal + '</div></div>');
                $("#" + addId).val('')
            }

        }

        function deleteItems(itemVal, el) {
            moreItems = moreItems.filter((x) => x !== String(itemVal))
            $(el).parent().remove();
        }

        function deleteFromListview(id, el) {
            $.ajax({
                type: 'DELETE',
                url: url + '/user_sub_asset/' + id,
                success: function(res) {
                    if (res.status === "0" || res.status === "ok") {
                        $(el).parent().parent().parent().parent().remove();
                        showSuccessNotifiBP('عملیات با موفقیت انجام شد', 'right', '#053a3e');
                    } else {
                        if (res.msg !== undefined && err.length > 1)
                            showSuccessNotifiBP(res.msg, 'right', '#ac0020');
                    }
                }
            })
        }

        function editSubAsset(i, y) {


            let data = allData.fields[i].items[y];
            roomId = allData.fields[i].items[y].id;

            openModal(() => {

                picInput = 1;

                data.fields.forEach((e, index) => {

                    if (e.type === 'gallery') {
                        for (let u = 0; u < e.val.length; u++)
                            setImg(e.val[u], u);

                    } else if (e.type === 'textarea') {
                        $("textarea[name='" + e.key_ + "']").val(e.val);
                    } else if (e.type === 'radio') {
                        $("input[value='" + e.val + "']").prop("checked", true);
                    } else if (e.type === 'checkbox') {
                        $("input[value='" + e.val + "']").prop("checked", true);
                    } else
                        $("input[name='" + e.key_ + "']").val(e.val);
                });

            });


        }

        function buildFormHtml(res, resultBox, modal) {
            if (!modal)
                allData = res;

            let text = "";
            let html = "";
            let elm = "";
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
                if (res.fields[i].type.toLowerCase() == 'radio') {
                    text += '<div class="relative-position inputBoxTour" style="margin-left: 10px; width: ' + (res
                        .fields[i].half == 1 ? '48%' : '100%') + ';">';
                    text += '<div class="inputBoxTextGeneralInfo inputBoxText ">';
                    text += '<div class="' + (res.fields[i].necessary == 1 ?
                            ' importantFieldLabel' : '') + '" name="' + res.fields[i].name + '"> ' + res.fields[i].name +
                        '</div>';
                    text += '</div>';
                    text += '<div class="select">';
                    for (let x = 0; x < res.fields[i].options.length; x++) {
                        text +=
                            '<label style="font-size: 15px;white-space: nowrap;justify-content: center;display: inline-flex;" class="' +
                            (res.fields[i].status == 'REJECT' ? 'errorInput' :
                                '') + ' cursorPointer mg-rt-10 ' + (res.fields[i].data == res.fields[i].options[x] ?
                                'active' : '') + '" for="' + res.fields[i].field_id + '">' + res.fields[i].options[x] +
                            '';
                        text += '<input class="cursorPointer mg-rt-6" type="radio" value="' + res.fields[i].options[x] +
                            '" name="' + res.fields[i].name + '" id="' + res.fields[i].field_id + '" ' + (res.fields[i]
                                .data == res.fields[i].options[x] ?
                                'checked ' : ' ') + (res.fields[i].necessary == 1 ? 'required ' : '') +
                            '>';
                        text += '</label>';

                    }
                    text += '</div>';
                    text += '</div>';
                } else if (res.fields[i].type.toLowerCase() == 'checkbox') {
                    text += '<div class="relative-position inputBoxTour" style="margin-left: 10px; width: ' + (res
                        .fields[i].half == 1 ? '48%' : '100%') + ';">';
                    text += '<div class="inputBoxTextGeneralInfo inputBoxText">';
                    text += '<div class="' + (res.fields[i].necessary == 1 ?
                            ' importantFieldLabel' : '') + '"name="' + res.fields[i].name + '"> ' + res.fields[i].name +
                        '</div>';
                    text += '</div>';
                    let data = res.fields[i].data !== null && res.fields[i].data != '' ?
                        res.fields[i].data.split("_") : [];
                    text += '<div class="select">';
                    for (let x = 0; x < res.fields[i].options.length; x++) {
                        let isSelected = data.indexOf(res.fields[i].options[x]) !== -1;
                        text += '<label class="' + (res.fields[i].status == 'REJECT' ? 'errorInput' : '') +
                            ' mg-rt-10 cursorPointer ' + (isSelected ? 'active' : '') + '" for="c' + res.fields[i].options[
                                x] +
                            '" style="font-size: 15px;white-space: nowrap;justify-content: center;display: inline-flex;">' +
                            res.fields[i]
                            .options[x] + '';
                        text += '<input class="mg-rt-6 cursorPointer " type="checkbox" value="' + res.fields[i].options[x] +
                            '" name="' + res.fields[i].name + '" id="c' + res.fields[i].options[x] + '" data-id="' + res
                            .fields[i].field_id + '" ' + (isSelected ? 'checked ' : ' ') + (res.fields[i].necessary == 1 ?
                                'required ' : '') +
                            '>';
                        text += '</label>';

                    }
                    text += '</div>';
                    text += '</div>';
                } else if (res.fields[i].type.toLowerCase() == 'string') {
                    text += '<div class="relative-position inputBoxTour" style="margin-left: 10px; width: ' + (res
                        .fields[i]
                        .half == 1 ? '48%' : '100%') + ';">';
                    text += '<div class="inputBoxTextGeneralInfo inputBoxText  ">';
                    text += '<div class="' + (res.fields[i].necessary == 1 ?
                        ' importantFieldLabel' : '') + '"> ' + res.fields[i].name + '</div>';
                    text += '</div>';
                    text += '<input type="text" data-change="' + (res.fields[i].data != null ? '0' : '1') +
                        '" value="' + (res.fields[i].data != null ? '' + res.fields[i].data + '' : '') + '" id="' + res
                        .fields[i].field_id +
                        '" class="inputBoxInput ' + (res.fields[i].status == 'REJECT' ? 'errorInput' : '') + '" name="' +
                        res.fields[i].name +
                        '" placeholder="' + (res.fields[i].placeholder != null ? '' + res.fields[i].placeholder + '' : '') +
                        '"' + (res.fields[i].necessary == 1 ? 'required ' : '') + ' >';
                    text += '</div>';
                } else if (res.fields[i].type.toLowerCase() == 'ckeditor') {
                    ckeditorExist = true;
                    userFormDataId = res.fields[i].user_form_data_id;
                    ckeditorId = res.fields[i].field_id;
                    text +=
                        '<div  class=" relative-position inputBoxTour" style="margin-left: 10px; width: ' +
                        (res
                            .fields[i]
                            .half == 1 ? '48%' : '100%') + ';">';
                    text += '<div class="inputBoxTextGeneralInfo inputBoxText  ">';
                    text += '<div class="' + (res.fields[i].necessary == 1 ?
                        ' importantFieldLabel' : '') + '"> ' + res.fields[i].name + '</div>';
                    text += '</div>';
                    text += '<div id="ck' + ckeditorId + '" class="textEditor' + (res.fields[i].status == 'REJECT' ?
                        'errorInput' : '') + '">';
                    if (res.fields[i].data !== null) {

                        text += res.fields[i].data;
                    }
                    text += '</div>';
                    text += '</div>';

                } else if (res.fields[i].type.toLowerCase() == 'time') {
                    text += '<div class="relative-position inputBoxTour" style="margin-left: 10px; width: ' + (res
                        .fields[i]
                        .half == 1 ? '48%' : '100%') + ';">';
                    text +=
                        '<div class="inputBoxTextGeneralInfo inputBoxText   clockTitle">';
                    text += '<div class=" name' + (res.fields[i].necessary == 1 ?
                        ' importantFieldLabel' :
                        '') + '"> ' + res.fields[i].name + '</div>';
                    text += '</div>';
                    text += '<input style="border: none;" onkeydown="return false;" type="text" value="' + (res.fields[i]
                            .data != null ? '' +
                            res
                            .fields[i].data + '' :
                            '') + '" value="' + (res.fields[i].data != null ? '' + res.fields[i].data +
                            '' :
                            '') + '" name="' + res.fields[i].name +
                        '" id="' + res
                        .fields[i]
                        .field_id +
                        '" class="form-control clockP ' + (res.fields[i].status == 'REJECT' ? 'errorInput' : '') +
                        '" placeholder="' + (res.fields[i]
                            .placeholder !=
                            null ?
                            '' + res.fields[i].placeholder + '' : '') + '"' + (res
                            .fields[i]
                            .necessary == 1 ? 'required ' : '') + ' >';
                    text += '</div>';
                } else if (res.fields[i].type.toLowerCase() == 'int') {
                    text += '<div class="relative-position inputBoxTour" style="margin-left: 10px; width: ' + (res
                        .fields[i]
                        .half == 1 ? '48%' : '100%') + ';">';


                    if (res.fields[i].multiple === 1) {
                        moreItems = res.fields[i].data !== null && res.fields[i].data != '' && res.fields[i].multiple ===
                            1 ?
                            res.fields[i].data.split("_") : [];
                        if (moreItems.length < 2) {
                            oneItems = true;
                            text += '<div class="inputBoxTextGeneralInfo inputBoxText  ">';
                            text += '<div class="' + (res.fields[i].necessary == 1 ?
                                ' importantFieldLabel' :
                                '') + '"> ' + res.fields[i].name + '</div>';
                            text += '</div>';
                            text += '<input type="text" onkeypress="return isNumber(event)" value="' + (res.fields[i]
                                    .data !=
                                    null ?
                                    '' +
                                    res.fields[i].data +
                                    '' :
                                    '') + '" name="' + res.fields[i].name + '" id="' + res.fields[i].field_id +
                                '" class="inputBoxInput  ' + (res.fields[i].multiple === 1 ? 'phone' : '') + '  ' + (res
                                    .fields[i].status == 'REJECT' ? 'errorInput' : '') +
                                '" placeholder="' + (res
                                    .fields[
                                        i]
                                    .placeholder !=
                                    null ?
                                    '' + res.fields[i].placeholder + '' : '') + '"' + (res
                                    .fields[i]
                                    .necessary == 1 ? 'required ' : '') + ' >';
                        } else {
                            multipleVal = true;
                            text += '<div class="inputBoxTextGeneralInfo inputBoxText  ">';
                            text += '<div class="' + (res.fields[i].necessary == 1 ?
                                ' importantFieldLabel' :
                                '') + '"> ' + res.fields[i].name + '</div>';
                            text += '</div>';
                            text += '<input type="text" onkeypress="return isNumber(event)" name="' + res.fields[i].name +
                                '" id="' + res.fields[i].field_id + '" class="inputBoxInput ' + (res.fields[i].multiple ==
                                    1 ? 'phone' : '') + ' " placeholder="' + (res.fields[i].placeholder != null ? '' + res
                                    .fields[i]
                                    .placeholder + '' : '') + '"' + (res
                                    .fields[i].necessary == 1 ? 'required ' : '') + ' >';

                        }
                        multiple = true;
                        text += '<div class="inputBoxTextGeneralInfo inputBoxAdd "onclick="addPhone()">';
                        text += '<div class="plus2" style="font-size: 18px;font-weight: bold;"></div>';
                        text += '<div style="font-size: 14px;" > اضافه کن</div>';
                        text += '</div>';
                    } else {
                        text += '<div class="inputBoxTextGeneralInfo inputBoxText  ">';
                        text += '<div class="' + (res.fields[i].necessary == 1 ?
                            ' importantFieldLabel' :
                            '') + '"> ' + res.fields[i].name + '</div>';
                        text += '</div>';
                        text += '<input type="text" onkeypress="return isNumber(event)" value="' + (res.fields[i]
                                .data !=
                                null ?
                                '' +
                                res.fields[i].data +
                                '' :
                                '') + '" name="' + res.fields[i].name + '" id="' + res.fields[i].field_id +
                            '" class="inputBoxInput  ' + (res.fields[i].multiple ===
                                1 ? 'phone' : '') + '  ' + (res.fields[i].status == 'REJECT' ? 'errorInput' : '') +
                            '" placeholder="' + (res
                                .fields[
                                    i]
                                .placeholder !=
                                null ?
                                '' + res.fields[i].placeholder + '' : '') + '"' + (res
                                .fields[i]
                                .necessary == 1 ? 'required ' : '') + ' >';
                    }
                    text += '</div>';
                } else if (res.fields[i].type.toLowerCase() == 'listview') {
                    for (let x = 0; x < res.fields[i].options.length; x++) {
                        subAssetId = res.fields[i].options[x];
                        subAsserName = res.fields[i].name;
                    }
                    if (res.fields[i].items.length < 1) {
                        elm += '<div style="width:100%;">هنوز ' + subAsserName + ' تعریف نشده است.</div>';
                        elm += '';
                    } else {
                        listview = true;
                        roomCount = res.fields[i].items.length;
                        sameRoom = res.fields[i].items[4];
                        elm += '<div style="width:100%;align-items: baseline;" class="row">';
                        elm += '<div style="padding-left:10px">در حال حاضر ' + roomCount + ' ' + subAsserName +
                            ' موجود است.</div>';
                        elm += '<div class="relative-position inputBoxTour" style="margin-left: 10px; width: 30%;"';
                        elm += '<div class="inputBoxTextGeneralInfo inputBoxText">';

                        elm +=
                            '<div style="white-space: nowrap;padding: 5px;border-left: 1px solid #D4D4D4;">' +
                            subAsserName + '</div>';
                        elm +=
                            '<input id="searchInput" class"inputBoxInput " type="search" style="width:100%;border:0px;position:relative;">';
                        elm += '</div>';
                        elm += '</div>';
                        elm += '</div>';
                        for (let y = 0; y < res.fields[i].items.length; y++) {

                            let name, img, count, rId, roomStatus;
                            rId = res.fields[i].items[y].id;

                            for (let m = 0; m < res.fields[i].items[y].fields.length; m++) {
                                if (res.fields[i].items[y].fields[m].status == 'REJECT') {
                                    roomStatus = false;
                                }
                            }
                            text +=
                                '<div id="subAsset_' + rId +
                                '" class=" ' + (roomStatus ? 'errorInput' : '') +
                                'relative-position inputBoxTour boxRoom" style="order: 2;min-height: 150px;">';

                            text += '<div class="row" >';

                            text += '<div class="col-md-5 col-sm-5 col-5"style="padding: 0px!important;">';
                            for (let m = 0; m < res.fields[i].items[y].fields.length; m++) {
                                if (res.fields[i].items[y].fields[m].type == 'gallery') {
                                    img = res.fields[i].items[y].fields[m].val[0];
                                }
                            }
                            if (img === undefined || img === 'https://boom.bogenstudio.com/../storage/default.png') {
                                text +=
                                    '<div style="height: 100%;align-items: center;display: flex;"><i class="boomIcon" style="font-size: 130px;font-style: unset;"></i></div>';
                            } else {
                                text += '<img src="' + img + '" style="height: 100%; width: 100%;object-fit: contain;">';
                            }
                            text += '</div>';
                            text +=
                                '<div class="col-md-7 col-sm-7 col-7 flexDirectionCol SpaceBetween" style="padding-left:0px;">';
                            text += '<div>';
                            for (let m = 0; m < res.fields[i].items[y].fields.length; m++) {
                                if (res.fields[i].items[y].fields[m].type !== 'gallery') {
                                    name = res.fields[i].items[y].fields[m].val;
                                    nameKey = res.fields[i].items[y].fields[m].key_;
                                    text += '<div class="colorOrag bold"> ' + nameKey + '</div>';
                                    text += '<div class="bold roomName">' + name + ' </div>';
                                }
                            }
                            text += '</div>';
                            text += '<div class="row SpaceBetween" style="padding-bottom: 5px;">';
                            text +=
                                '<div class="backOrang colorWhite editBtn"onclick="editSubAsset(\'' + i + '\', \'' + y +
                                '\')"> <i class="editIcon iconStyle"></i>ویرایش</div>';
                            text +=
                                '<div class="colorWhite backBlue editBtn" onclick="deleteFromListview(' + rId +
                                ',this)"><i class="trashIcon iconStyle"></i> حذف</div>';
                            text += '</div>';
                            text += '</div>';
                            text += '</div>';
                            text += '</div>';

                        }
                    }
                } else if (res.fields[i].type.toLowerCase() == 'gallery') {
                    text += '<div class="relative-position inputBoxTour" style="margin-left: 10px; width: ' + (res
                        .fields[i]
                        .half == 1 ? '48%' : '100%') + '; order:' + (res
                        .fields[i].type == 'listview' ? '2' : '') + '">';
                    picId = res.fields[i].field_id;

                    text += '<div class="inputBoxTextGeneralInfo inputBoxText  ">';
                    text += '<div class="' + (res.fields[i].necessary == 1 ?
                        ' importantFieldLabel' :
                        '') + '"> ' + res.fields[i].name + '</div>';
                    text += '</div>';
                    text += '<div id="uploadImgDiv" class="fullwidthDiv"style="padding:10px">';
                    text += '<div id="picDiv0" style="display: inline-block; width: 23%; position: relative">';
                    text +=
                        '<input class="input-file" id="picsInput_0" name="pics[]" accept="image/*" type="file" onchange="readURL(this, 0);" style="display: none">';
                    text += '<div id="picHover_0" class="uploadHover hidden" >';
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
                    text += '</div>';
                } else if (res.fields[i].type.toLowerCase() == 'redirector') {
                    text += '<div class="relative-position inputBoxTour boxRoom" style="order:' + (res
                        .fields[i].type == 'listview' ? '2' : '') + '">';
                    redirector = true;
                    for (let x = 0; x < res.fields[i].options.length; x++) {
                        subAssetFromId = res.fields[i].options[x];
                        text += '<div class="row" onclick="openModal()" style="display: flex;align-items: center;">';
                        text +=
                            '<div class="col-md-4 col-sm-4 col-4" style="padding:8px;"><svg max-width="100%" viewBox="0 0 127 127" fill="none" xmlns="http://www.w3.org/2000/svg">';
                        text +=
                            '<path d="M126.999 58.6058V68.3794C127.017 69.6463 126.785 70.9044 126.317 72.0816C125.848 73.2588 125.152 74.332 124.269 75.2399C123.386 76.1478 122.332 76.8726 121.168 77.3727C120.004 77.8728 118.753 78.1385 117.487 78.1545H78.1727V117.224C78.2068 119.782 77.2236 122.249 75.4395 124.082C73.6554 125.916 71.2165 126.965 68.6592 126.999H58.5794C57.313 127.017 56.0556 126.785 54.8791 126.316C53.7025 125.847 52.6298 125.151 51.7224 124.267C50.815 123.384 50.0906 122.33 49.5908 121.166C49.0909 120.001 48.8254 118.75 48.8094 117.483C48.8094 117.397 48.8094 117.311 48.8094 117.225V78.1545H9.75752C7.20048 78.1846 4.73619 77.1975 2.90655 75.4103C1.07691 73.6231 0.0317299 71.1821 0.000855259 68.6241C0.000855259 68.5529 0.000855259 68.4832 0.000855259 68.4135V58.6058C-0.0331826 56.0475 0.949974 53.5805 2.73408 51.7473C4.51818 49.9142 6.95711 48.865 9.51441 48.8306H48.8272V9.76127C48.8111 8.49437 49.0449 7.23672 49.5151 6.06028C49.9854 4.88384 50.6829 3.81169 51.5677 2.90517C52.4526 1.99865 53.5074 1.27554 54.6719 0.777209C55.8363 0.278878 57.0876 0.0151043 58.354 0.000976567C58.4296 0.000976567 58.5023 0.000976567 58.5838 0.000976567H68.3538C69.6203 -0.0170586 70.8778 0.214871 72.0546 0.683497C73.2313 1.15212 74.3042 1.84825 75.2118 2.73205C76.1193 3.61585 76.8438 4.66999 77.3437 5.83415C77.8437 6.99831 78.1093 8.24966 78.1253 9.5166C78.1253 9.60261 78.1253 9.68861 78.1253 9.77462V48.8514H117.18C119.736 48.8042 122.207 49.7744 124.048 51.5488C125.889 53.3232 126.951 55.7565 126.999 58.3136C126.999 58.4115 126.999 58.5079 126.999 58.6058Z" fill="#444444"/> </svg>';
                        text += '</div>';
                        text += '<div class="col-md-8 col-sm-8 col-8" >';
                        text += '<div> ' + res.fields[i].name + '';
                        text += '</div>';
                        text += '</div>';
                        text += '</div>';

                    }
                    text += '</div>';
                } else if (res.fields[i].type.toLowerCase() == 'float') {
                    text += '<div class="relative-position inputBoxTour" style="margin-left: 10px; width: ' + (res
                        .fields[i]
                        .half == 1 ? '48%' : '100%') + '; order:' + (res
                        .fields[i].type == 'listview' ? '2' : '') + '">';
                    text += '<div class="inputBoxTextGeneralInfo inputBoxText  ">';
                    text += '<div class="' + (res.fields[i].necessary == 1 ?
                        ' importantFieldLabel' :
                        '') + '"> ' + res.fields[i].name + '</div>';
                    text += '</div>';
                    text += '<input type="number" step="0.01" value="' + (res.fields[i].data != null ? '' + res.fields[
                                i]
                            .data +
                            '' :
                            '') + '" name="' + res.fields[i].name +
                        '" id="' + res
                        .fields[
                            i].field_id +
                        '" class="inputBoxInput ' + (res.fields[i].status == 'REJECT' ? 'errorInput' : '') +
                        '" placeholder="' + (res.fields[i]
                            .placeholder !=
                            null ?
                            '' + res.fields[i].placeholder + '' : '') + '"' + (res
                            .fields[i]
                            .necessary == 1 ? 'required ' : '') + ' >';
                    text += '</div>';
                } else if (res.fields[i].type.toLowerCase() == 'file') {
                    filePic = true;
                    text +=
                        '<div class="relative-position inputBoxTour SpaceBetween" style="align-items: center;margin-left: 10px; width: ' +
                        (
                            res.fields[i]
                            .half == 1 ? '48%' : '100%') + ';">';
                    text += '<div class="inputBoxTextGeneralInfo inputBoxText ">';
                    text += '<div class="' + (res.fields[i].necessary == 1 ?
                        ' importantFieldLabel' :
                        '') + '"> ' + res.fields[i].name + '</div>';
                    text += '</div>';
                    fileId = res.fields[i].field_id;;
                    text += '<input data-change="' + (res.fields[i].data != null ? '0' : '1') +
                        '" type="file" name="' + res.fields[i].name + '" style=" display:' + (res.fields[i].data != null ?
                            'none' : '') +
                        '"  id="' + res.fields[i].field_id + '" class=" inputBoxInput file ' + (res.fields[i].status ==
                            'REJECT' ? 'errorInput' : '') + '"' + (res.fields[i]
                            .necessary ==
                            1 ? 'required ' : '') + '>';
                    if (res.fields[i].data != null) {
                        text += '<label style="max-width: 50%;  overflow: hidden;" for="' + res.fields[i].field_id + '">' +
                            (
                                res.fields[i].data != null ? '' + res
                                .fields[i].data + '' : '') + '</label>';
                        text += '<div style="display:flex;align-items: center;">';
                        text += '<a class="colorBlack" href="' + res.fields[i].data + '" target="_blank">';
                        text +=
                            '<div class="colorBlack editBtn borderLeft borderRight" ><i class="fa fa-eye iconStyle"></i>';

                        text += '</div>';
                        text += '</a>';
                        if (res.fields[i].necessary !== 1) {

                            text += '<div class="colorBlack editBtn borderLeft" onclik="$(\'#' + fileId +
                                '\').val(" ")"><i class="trashIcon iconStyle"></i></div>';
                        }
                        text +=
                            '  <button class="fileBtn cursorPointer" style="display:block;width:60%; height:30px;white-space: nowrap;" onclick="$(\'#' +
                            fileId + '\').click()">تغییر فایل</button>';
                        text += '</div>';
                    } else {
                        text +=
                            '  <button class="fileBtn cursorPointer" style="display:block;width:120px; height:30px;" onclick="$(\'#' +
                            fileId +
                            '\').click()">انتخاب فایل</button>';
                    }

                    text += '</div>';
                } else if (res.fields[i].type.toLowerCase() == 'map') {
                    text += '<div class="relative-position inputBoxTour" style="margin-left: 10px; width: ' + (res
                        .fields[i]
                        .half == 1 ? '48%' : '100%') + '; order:' + (res
                        .fields[i].type == 'listview' ? '2' : '') + '">';
                    text += '<div class="inputBoxTextGeneralInfo inputBoxText  ">';
                    text += '<div class="' + (res.fields[i].necessary == 1 ?
                        ' importantFieldLabel' :
                        '') + '"> ' + res.fields[i].name + '</div>';
                    text += '</div>';
                    text += '<div class="select-side locationIconTourCreation">';
                    text +=
                        '<svg width="33" height="22" viewBox="0 0 33 22" fill="none" xmlns="http://www.w3.org/2000/svg">';
                    text +=
                        '<path d ="M15.2925 12.1671V17.4579C15.2945 17.6484 15.3324 17.8369 15.4041 18.0134L15.9594 19.0496C16.0049 19.1487 16.0779 19.2328 16.1698 19.2916C16.2616 19.3505 16.3685 19.3818 16.4776 19.3818C16.5867 19.3818 16.6935 19.3505 16.7854 19.2916C16.8772 19.2328 16.9502 19.1487 16.9958 19.0496L17.5511 18.0134C17.6235 17.8371 17.6608 17.6484 17.6611 17.4579V12.1671C16.8786 12.3159 16.075 12.3159 15.2925 12.1671ZM16.4779 0.440002C13.5475 0.452322 11.1821 2.838 11.1944 5.76796C11.2067 8.69792 13.5919 11.0636 16.5219 11.0513C19.4519 11.0389 21.8177 8.65326 21.8054 5.7233C21.7933 2.8105 19.4351 0.452322 16.5219 0.440002H16.4779ZM16.4779 3.40032C15.8513 3.40481 15.2517 3.65569 14.8085 4.09873C14.3654 4.54176 14.1144 5.14137 14.1098 5.76796C14.1113 5.84674 14.0971 5.92503 14.068 5.99825C14.0389 6.07148 13.9955 6.13816 13.9404 6.19441C13.8852 6.25066 13.8193 6.29534 13.7467 6.32585C13.674 6.35635 13.596 6.37206 13.5173 6.37206C13.4385 6.37206 13.3605 6.35635 13.2878 6.32585C13.2152 6.29534 13.1493 6.25066 13.0941 6.19441C13.039 6.13816 12.9956 6.07148 12.9665 5.99825C12.9374 5.92503 12.9232 5.84674 12.9247 5.76796C12.9254 4.82584 13.3 3.92252 13.9662 3.25638C14.6324 2.59025 15.5358 2.21577 16.4779 2.21518C16.6331 2.21817 16.7809 2.28192 16.8896 2.39272C16.9983 2.50352 17.0592 2.65254 17.0592 2.80775C17.0592 2.96296 16.9983 3.11198 16.8896 3.22278C16.7809 3.33359 16.6331 3.39733 16.4779 3.40032Z"';
                    text += 'fill = "#4DC7BC" / > < /svg>';
                    text += '</div>';
                    text += '<input onkeydown="return false;" type="text" value="' +
                        (res
                            .fields[i]
                            .data != null ? '' + res
                            .fields[i].data + '' :
                            '') + '" name="' + res.fields[i].name +
                        '" id="' + res
                        .fields[i]
                        .field_id +
                        '" class="inputBoxInput mapMark ' + (res.fields[i].status == 'REJECT' ? 'errorInput' : '') +
                        '" placeholder="' + (res.fields[i]
                            .placeholder !=
                            null ?
                            '' + res.fields[i].placeholder + '' : '') + '"' + (res
                            .fields[i]
                            .necessary == 1 ? 'required ' : '') + ' >';
                    text += '</div>';
                } else if (res.fields[i].type.toLowerCase() == 'api') {
                    text += '<div class="relative-position inputBoxTour" style="margin-left: 10px; width: ' + (res
                        .fields[i]
                        .half == 1 ? '48%' : '100%') + '; order:' + (res
                        .fields[i].type == 'listview' ? '2' : '') + '">';
                    needSearchCityModal = true;

                    city = res.fields[i].options[0].replace('koochita', 'mykoochita')
                        .replace(
                            "https",
                            "http");
                    let myArray;
                    cityFullName = res.fields[i].data;
                    if (cityFullName !== null) {
                        myArray = cityFullName.split("$$");
                        cityName = myArray[1];
                        stateName = myArray[0];
                    }
                    apiId = res.fields[i].field_id;
                    text += '<div class="inputBoxTextGeneralInfo inputBoxText ">';
                    text += '<div class="' + (res.fields[i].necessary == 1 ?
                        ' importantFieldLabel' :
                        '') + '"> ' + res.fields[i].name + '</div>';
                    text += '</div>';
                    text += '<input value="' + (res.fields[i].data != null ? '' + cityName + '' : '') +
                        '" type="text" id="' + res.fields[i]
                        .field_id +
                        '" class="inputBoxInput" name="' + res.fields[i].name +
                        '" placeholder="' +
                        (res
                            .fields[i].placeholder != null ?
                            '' + res.fields[i].placeholder + '' : '') + '"' + (res
                            .fields[i]
                            .necessary == 1 ? 'required ' : '') +
                        ' onclick="chooseSrcCityModal()" onkeydown="return false;">';

                    text += '<div id="apiItemList" class"hidden">';
                    text += '</div>';
                    text += '</div>';
                } else if (res.fields[i].type.toLowerCase() == 'textarea') {
                    text += '<div class="relative-position inputBoxTour" style="margin-left: 10px; width: ' + (res
                        .fields[i]
                        .half == 1 ? '48%' : '100%') + '; order:' + (res
                        .fields[i].type == 'listview' ? '2' : '') + '">';
                    text += '<div class="inputBoxTextGeneralInfo inputBoxText ">';
                    text += '<div class="' + (res.fields[i].necessary == 1 ?
                        ' importantFieldLabel' :
                        '') + '"> ' + res.fields[i].name + '</div>';
                    text += '</div>';
                    text += '<textarea name="' + res.fields[i].name + '" id="' + res
                        .fields[i]
                        .field_id +
                        '" class="' + (res.fields[i].status == 'REJECT' ? 'errorInput' : '') +
                        'inputBoxInput fullwidthDiv text-align-right full-height textareaInForDescription"  placeholder="' +
                        (res.fields[i].placeholder != null ?
                            '' + res.fields[i].placeholder + '' : '') + '"' + (res
                            .fields[i]
                            .necessary == 1 ? 'required ' : '') + ' >' + (res.fields[i].data != null ? '' + res.fields[
                                i]
                            .data + '' : '') + '</textarea>';
                    text += '</div>';
                } else if (res.fields[i].type.toLowerCase() == 'calendar') {
                    text += '<div class="relative-position inputBoxTour" style="margin-left: 10px; width: ' + (res
                        .fields[i]
                        .half == 1 ? '48%' : '100%') + ';">';
                    text += '<div class="inputBoxTextGeneralInfo inputBoxText ">';
                    text += '<div class="' + (res.fields[i].necessary == 1 ?
                        ' importantFieldLabel' :
                        '') + '"> ' + res.fields[i].name + '</div>';
                    text += '</div>';
                    text += '<div class="select-side calendarIconTourCreation">';
                    text += '<i class="ui_icon calendar calendarIcon"></i>';
                    text += '</div>';
                    text += ' <input onkeydown="return false;" value="' + (res.fields[i].data != null ? '' + res.fields[i]
                            .data + '' : '') + '" name="' + res.fields[i].name + '" name="sDateNotSame[]" id="' +
                        res.fields[i].field_id +
                        '" class="' + (res.fields[i].status == 'REJECT' ? 'errorInput' : '') +
                        'observer-example inputBoxInput" type="text" style="direction: ltr;" placeholder="' +
                        (
                            res
                            .fields[i].placeholder != null ?
                            '' + res.fields[i].placeholder + '' : '') + '"' + (res
                            .fields[i]
                            .necessary == 1 ? 'required ' : '') + ' >';
                    text += '';
                    calenderId = res.fields[i].field_id;
                    text += '</div>';
                } else {
                    text += '<div class="relative-position inputBoxTour" style="margin-left: 10px; width: ' + (res
                        .fields[i]
                        .half == 1 ? '48%' : '100%') + '; order:' + (res
                        .fields[i].type == 'listview' ? '2' : '') + '">';
                    text += '<div class="inputBoxTextGeneralInfo inputBoxText ">';
                    text += '<div class="' + (res.fields[i].necessary == 1 ?
                        ' importantFieldLabel' :
                        '') + '"> ' + res.fields[i].name + '</div>';
                    text += '</div>';
                    text += '<input name="' + res.fields[i].name + '" type="' + res
                        .fields[i]
                        .type +
                        '" id="' + res.fields[i].field_id +
                        '" class="' + (res.fields[i].status == 'REJECT' ? 'errorInput' : '') +
                        'inputBoxInput" placeholder="' + (res.fields[i]
                            .placeholder !=
                            null ?
                            '' + res.fields[i].placeholder + '' : '') + '"' + (res
                            .fields[i]
                            .necessary == 1 ? 'required ' : '') + ' >';
                    text += '</div>';
                }
                if (res.fields[i].multiple === 1 || multipleVal) {
                    addId = res.fields[i].field_id;
                    text += '<div id="input-' + res.fields[i].field_id +
                        '-items" style="display: flex;flex-direction: row;flex-wrap: wrap;">';
                    if (multipleVal) {
                        for (x = 0; x < moreItems.length; x++) {
                            itemsVal = moreItems[x];
                            text += '<div class="itemsAdd "><div class="itemsDelete"onclick="deleteItems(' + itemsVal +
                                ',this)">حذف</div><div style="margin: auto;padding: 5px;">' +
                                moreItems[x] + '';
                            text += '</div>';
                            text += '</div>';
                        }
                        multipleVal = false;
                    }
                    text += '</div>';
                }
                if (res.fields[i].force_help !== null && res.fields[i].force_help !== "") {
                    text += '<figcaption style="width: 100%;"> ' + res.fields[i].force_help + '';
                    text += '</figcaption>';
                }
                if (res.fields[i].err_text != null && res.fields[i].err_text !== "") {
                    text += '<figcaption style="width: 100%;"> ' + res.fields[i].err_text + '';
                    text += '</figcaption>';
                }
            }
            $('#' + resultBox).empty().append(text);
            if (ckeditorExist) {
                ckeditor(ckeditorId);
            }
            $('#searchForm').append(elm);
            $(".clockP").clockpicker(clockOptions);
            $(".observer-example").datepicker(datePickerOptions);
            if (!needSearchCityModal) {
                $("#addCityModal").remove();
            }
            $("#" + addId).on('keypress', function(e) {
                if (e.which == 13) {
                    addPhone();
                }
            });
            if (listview) {

                document.getElementById("searchInput").addEventListener("search", function(event) {
                    $("#searchInput").keyup();
                });
            }
        }
        var t = null;

        $(document).on('keyup', '#searchInput', function() {

            let searchForLabel = $(this).prev().text();
            var value = this.value.toLowerCase().trim();
            $(".boxRoom:not(:last-child)").addClass('hidden');

            allData.fields.forEach((e, index) => {
                if (e.type !== 'listview')
                    return;

                e.items.forEach((ee, index2) => {
                    ee.fields.forEach((eee, index3) => {
                        if (eee.key_ !== searchForLabel)
                            return;

                        if (eee.val.indexOf(value) !== -1)
                            $("#subAsset_" + ee.id).removeClass('hidden');
                    });

                });

            });
        });

        function callMap() {

            initMap = true;

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

                marker = new mapboxgl.Marker();
                marker.setLngLat(e.lngLat).addTo(map);

                x = e.lngLat.lat;
                y = e.lngLat.lng;
                z = x + " " + y;
                $('.mapMark').val(z);
            }

            map.on('click', addMarker);
        }

        $(document).ready(function() {

            $(document).on('change', 'input', function() {
                $(this).attr('data-change', '1');
            });

            $(document).on('click', '.mapMark', function() {
                if (!initMap) {
                    setTimeout(() => {
                        callMap();
                    }, 500);
                }
            });

            if (userAssetId != -1) {
                openLoading();
                $.ajax({
                    type: 'get',
                    url: url + '/form/' + formId + '/' + userAssetId,
                    complete: closeLoading,
                    headers: {
                        'Accept': 'application/json'
                    },
                    success: function(res) {
                        var text = '';
                        if (res.status === 0) {
                            buildFormHtml(res, 'boxMake', false);
                        }
                    },
                    error: function(request, status, error) {
                        if (request.status === 404) {
                            window.location.href = '/404';
                        }
                    }
                });
            } else {
                openLoading();
                $.ajax({
                    type: 'get',
                    url: url + '/form/' + formId,
                    complete: closeLoading,
                    headers: {
                        'Accept': 'application/json',
                    },
                    success: function(res) {
                        buildFormHtml(res, 'boxMake', false);
                    },
                    error: function(request, status, error) {
                        if (request.status === 404) {
                            window.location.href = '/404';
                        }
                    }
                });
            }
        });

        function updateSideProgressBar(_percent) {
            $("#sideProgressBarNumber").text(_percent + "%");
            $("#sideProgressBarFull").css("width", _percent + "%");
        }

        function isNumber(evt) {

            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }
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

        function setImg(src, _index) {

            var text = picCardSample;
            text = text.replace(new RegExp('##index##', 'g'), picInput);

            $('#picHover_' + _index).removeClass('hidden');
            $('#showPic' + _index).removeClass('hidden');
            $('#addPic' + _index).addClass('hidden');
            picInput++;

            $('#imgPic' + _index).attr('src', src);
            $('#uploadImgDiv').append(text);

            picQueue.push({
                id: _index,
                uploadedName: src,
                process: 2,
                index: _index
            });

            var element = $(`#picHover_${_index}`);

            element.find('.process').addClass('hidden');
            element.find('.tickIcon').removeClass('hidden');

        }

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
                if (index != null) {
                    uploadProcess = true;
                    uploadProcessId = picQueue[index].id;
                    var file = document.getElementById(`picsInput_${uploadProcessId}`).files;
                    uploadLargeFile(tourPicUrl, file[0], {}, uploadPicResult,
                        token
                    );
                }
            }
        }

        function uploadPicResult(_status, _fileName = '', _roomId = '') {


            var element = $(`#picHover_${uploadProcessId}`);
            var porcIndex = null;
            picQueue.map((item, index) => {
                if (item.id == uploadProcessId && porcIndex == null)
                    porcIndex = index;
            });
            if (_status == 'done') {

                roomId = _roomId;
                tourPicUrl = url + '/user_asset/' + userAssetId + '/add_pic_to_gallery_sub/' + picId + '/' + subAssetId +
                    '/' + roomId;
                deleteTourPicUrl = url + '/' + 'user_sub_asset/' + roomId +
                    '/delete_pic_from_gallery_sub/' + picId;
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
            openLoading();
            $.ajax({
                type: 'DELETE',
                complete: closeLoading,
                url: deleteTourPicUrl,
                data: {
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

        function ckeditor(ckeditorId_) {
            BalloonBlockEditor.create(document.querySelector('#ck' + ckeditorId), {
                    placeholder: 'متن سفرنامه خود را اینجا وارد کنید...',
                    toolbar: {
                        items: [
                            'bold',
                            'italic',
                            'link',
                            'highlight'
                        ]
                    },
                    language: 'fa',
                    blockToolbar: [
                        'blockQuote',
                        'heading',
                        'indent',
                        'outdent',
                        'numberedList',
                        'bulletedList',
                        'insertTable',
                        'imageUpload',
                        'undo',
                        'redo'
                    ],
                    table: {
                        contentToolbar: [
                            'tableColumn',
                            'tableRow',
                            'mergeTableCells'
                        ]
                    },
                    licenseKey: '',
                })
                .then(editor => {
                    window.editor = editor;

                    let token = 'Bearer ' + localStorage.getItem("token");

                    window.uploaderClass = editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {

                        return new MyUploadAdapter(loader, url + '/ckeditor/' +
                            userFormDataId,
                            token, {});
                    };


                })
                .catch(error => {
                    console.error('Oops, something went wrong!');
                    console.error(
                        'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:'
                    );
                    console.warn('Build id: wgqoghm20ep6-7otme29let2s');
                    console.error(error);
                });
        }
    </script>

@stop
