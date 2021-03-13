
isNeedSideProgressBar(true);
updateSideProgressBar(10);

var citySearchAjax = null;
var map;
var marker = 0;
var uploaders = [];
var fetchedContracts = [];
var contracts = [];

$(document).ready(function () {

    $(".businessType").on("click", function () {
        $(".businessType").removeClass('selected');
        $(this).addClass("selected");
        data.type = $(this).attr('data-type');
    });

    $('.clockpicker').clockpicker({
        donetext: 'تایید',
        autoclose: true,
    });

    var dropArea = document.getElementById('uploadedSection');
    var dropAreaJQ = $("#uploadedSection");

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false)
    });
    dropArea.addEventListener('dragenter', () => dropAreaJQ.addClass('highlight'), false);
    dropArea.addEventListener('dragleave', () => dropAreaJQ.removeClass('highlight'), false);
    dropArea.addEventListener('dragover', () => dropAreaJQ.addClass('highlight'), false);
    dropArea.addEventListener('drop', (e) => {

        let files = e.dataTransfer.files;

        if(files.length > 0)
            createAndUploadFilePic(files[0], "additionalValue", "showUploadPicsSection");

    }, false);

    dropArea = document.getElementById('uploadedSection2');
    dropAreaJQ = $("#uploadedSection2");

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false)
    });
    dropArea.addEventListener('dragenter', () => dropAreaJQ.addClass('highlight'), false);
    dropArea.addEventListener('dragleave', () => dropAreaJQ.removeClass('highlight'), false);
    dropArea.addEventListener('dragover', () => dropAreaJQ.addClass('highlight'), false);
    dropArea.addEventListener('drop', (e) => {
        let files = e.dataTransfer.files;
        for (var t = 0; t < files.length; t++) {
            createAndUploadFilePic(files[i], "pic", "showUploadPicsSection2")
        }
    }, false);

    dropArea = document.getElementById('uploadedSection3');
    dropAreaJQ = $("#uploadedSection3");

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false)
    });
    dropArea.addEventListener('dragenter', () => dropAreaJQ.addClass('highlight'), false);
    dropArea.addEventListener('dragleave', () => dropAreaJQ.removeClass('highlight'), false);
    dropArea.addEventListener('dragover', () => dropAreaJQ.addClass('highlight'), false);
    dropArea.addEventListener('drop', (e) => {
        let files = e.dataTransfer.files;
        if(files.length > 0)
            createAndUploadFilePic(files[i], "logo", "showUploadPicsSection3");
    }, false);

});

function clearGlobalResult() {
    $('#globalSearchResult').hide().html('');
}

function closeSearchInput() {
    $('#globalSearch').addClass('hidden');
    // $(".mainBodySection").removeClass('hidden');
}

function createSearchInput(_doFuncName, _placeHolderTxt) {

    // $(".mainBodySection").addClass('hidden');

    // _doFuncName must be string
    clearGlobalResult();

    $('#globalSearchResult').html('').hide();
    $('#globalSearch').css('display', 'flex').removeClass('hidden');

    $('#globalSearchInput').attr('onkeyup', _doFuncName+'(this)')
        .attr('placeholder', _placeHolderTxt).val('').focus();

}

function setResultToGlobalSearch(_txt) {
    $('#globalSearchResult').show().html(_txt);
}

function openSearchFindCity() {
    createSearchInput('searchCity', 'نام شهر را وارد کنید.');
}

function searchCity(_element) {
    activeCityFilter = false;
    var value = _element.value;
    if(value.trim().length > 1){
        if(citySearchAjax != null)
            citySearchAjax.abort();

        citySearchAjax = $.ajax({
            type: 'post',
            url: searchForCityPath,
            data: {
                key: value
            },
            success: function (response) {
                if(response.length == 0)
                    return;
                response = JSON.parse(response);
                var newElement = "";
                response.map(item => {
                    newElement += `<div onclick="chooseThisCity('${item.cityName}', ${item.id})"><div class="icons location spIcons"></div>
                                        <p class="suggest cursor-pointer font-weight-700" style="margin: 0px">شهر ${item.cityName}</p>
                                        <p class="suggest cursor-pointer stateName"> در ${item.stateName}</p>
                                    </div>`;
                });
                setResultToGlobalSearch(newElement);
            }
        });
    }
    else
        clearGlobalResult();
}

function chooseThisCity(_val, _id) {
    $('#cityId').val(_id);
    $('#city').val(_val).addClass('correctInput').removeClass('wrongInput');
    closeSearchInput();
}

function checkStepOne() {

    data.haghighi = $("#haghighi").prop("checked");
    data.hoghoghi = $("#hoghoghi").prop("checked");

    if(!data.haghighi && !data.hoghoghi) {
        showSuccessNotifiBP("لطفا نوع ارائه دهنده خود را مشخص کنید.", 'right', '#ac0020');
        return false;
    }

    updateSideProgressBar(20);
    if(data.haghighi) {
        $(".hogh").addClass("hidden");
        $(".hagh").removeClass("hidden");
    }
    else {
        $(".hagh").addClass("hidden");
        $(".hogh").removeClass("hidden");
    }
    return true;
}

function checkStepTwo() {

    if(data.type === "None") {
        showSuccessNotifiBP("لطفا نوع خدمت قابل ارائه خود را مشخص کنید.", 'right', '#ac0020');
        return false;
    }

    updateSideProgressBar(30);
    return true;
}

function checkStepThree(progress) {

    if(data.haghighi) {
        data.nid = $("#nid").val();
        data.name = $("#name").val();
    }
    else {
        data.nid = $("#businessNID").val();
        data.name = $("#regularName").val();
        data.economyCode = $("#economyCode").val();
    }

    data.tel = $("#tel").val();
    data.site = $("#site").val();
    data.mail = $("#mail").val();
    data.insta = $("#insta").val();
    data.telegram = $("#telegram").val();
    data.introduction = $("#introduction").val();

    if(data.tel.length == 0 || data.mail.length == 0 || data.introduction.length == 0 ||
        data.nid.length == 0 || data.name.length == 0) {
        showSuccessNotifiBP("لطفا تمام فیلد ها را به شکل صحیح پر نمایید.", 'right', '#ac0020');
        return false;
    }

    openLoading();

    var requestUrl = doCreatePath;
    if(created)
        requestUrl = updateBusinessInfo1BaseUrl + "/" + data.id;

    $.ajax({
        type: 'post',
        url: requestUrl,
        data: data,
        success: function (res) {

            closeLoading();

            if (res.status === "nok")
                showSuccessNotifiBP(res.msg, 'right', '#ac0020');
            else if (res.status === "ok") {

                if(!created) {
                    window.location.href = editPath + "/" + res.id + "/4";
                    return;
                }

                currProgress += progress;
                updateSideProgressBar(currProgress);
                $('.indicator_step').addClass('hidden');
                currentPage++;
                $("#step" + currentPage).removeClass('hidden');
            }

        },
        error: function (reject) {
            errorAjax(reject);
        }
    });

    updateSideProgressBar(progress);
    return false;
}

function checkStepFour(progress) {

    data.cityId = $("#cityId").val();
    data.address = $("#address").val();
    data.lat = $("#lat").val();
    data.lng = $("#lng").val();

    if(data.type != "tour") {

        data.fullOpen = $('#allDay24').prop('checked');
        data.afterClosedDayButton = $('#afterClosedDayButton').prop('checked');
        data.closedDayButton = $('#closedDayButton').prop('checked');

        if (data.closedDayButton) {
            data.closedDayStart = "00:00";
            data.closedDayEnd = "00:00";
        } else {
            data.closedDayStart = $('#closedDayStart').val();
            data.closedDayEnd = $('#closedDayEnd').val();
        }

        if (data.fullOpen || data.afterClosedDayButton) {
            data.afterClosedDayStart = "00:00";
            data.afterClosedDayEnd = "00:00";
        } else {
            data.afterClosedDayStart = $('#afterClosedDayStart').val();
            data.afterClosedDayEnd = $('#afterClosedDayEnd').val();
        }

        if (data.fullOpen) {
            data.inWeekDayStart = "00:00";
            data.inWeekDayEnd = "00:00";
        } else {
            data.inWeekDayStart = $('#inWeekDayStart').val();
            data.inWeekDayEnd = $('#inWeekDayEnd').val();
        }

    }
    if(data.cityId.length == 0 || data.cityId < 1 ||
        data.lat.length == 0 || data.lng.length == 0 ||
        data.lat == 0 || data.lng == 0) {
        showSuccessNotifiBP("لطفا تمام فیلد ها را به شکل صحیح پر نمایید.", 'right', '#ac0020');
        return false;
    }

    if(data.type != "tour") {
        if(data.closedDayStart.length == 0 || data.closedDayEnd.length == 0 ||
            data.afterClosedDayStart.length == 0 || data.afterClosedDayEnd.length == 0 ||
            data.inWeekDayStart.length == 0 || data.inWeekDayEnd.length == 0) {
            showSuccessNotifiBP("لطفا تمام فیلد ها را به شکل صحیح پر نمایید.", 'right', '#ac0020');
            return false;
        }
    }
    else {
        data.fullOpen = false;
        data.afterClosedDayButton = false;
        data.closedDayButton = false;
        data.closedDayStart = "00:00";
        data.closedDayEnd = "00:00";
        data.afterClosedDayStart = "00:00";
        data.afterClosedDayEnd = "00:00";
        data.inWeekDayStart = "00:00";
        data.inWeekDayEnd = "00:00";
    }

    data.coordinate = data.lat + ", " + data.lng;
    openLoading();

    $.ajax({
        type: 'post',
        url: updateBusinessInfo2BaseUrl + "/" + data.id,
        data: data,
        success: function (res) {
            closeLoading();
            if (res.status === "nok")
                showSuccessNotifiBP("خطایی در انجام عملیات رخ داده است.", 'right', '#ac0020');
            else if (res.status === "ok") {
                currProgress += progress;
                updateSideProgressBar(currProgress);
                $('.indicator_step').addClass('hidden');
                currentPage++;
                $("#step" + currentPage).removeClass('hidden');
            }
        },
        error: function (reject) {
            errorAjax(reject);
        }
    });

    updateSideProgressBar(progress);
    return false;
}

function checkStepFive(progress) {

    var i, name, idx;
    var names = [];
    var roles = [];

    for(i = 0; i < uploaders.length; i++) {

        if(uploaders[i][0] == "additionalValue" || uploaders[i][0] == "logo")
            continue;

        split = uploaders[i][0].split("_");
        if(split[0] == "pic")
            continue;

        idx = parseInt(split[1]);

        if(id_idx[idx] == -1 || uploaders[i][4].length < 2) {
            showSuccessNotifiBP("لطفا تصاویر مربوط به عضو " + (idx + 1) + " را بارگذاری نمایید.", 'right', '#ac0020');
            return false;
        }

        name = $("#name_" + idx).val();
        if(name.length == 0) {
            showSuccessNotifiBP("لطفا نام عضو " + (idx + 1) + " را وارد نمایید.", 'right', '#ac0020');
            return false;
        }
        names.push(name);
        roles.push($("#role_" + idx).val());
    }

    openLoading();

    $.ajax({
        type: 'post',
        url: updateBusinessInfo5BaseUrl + "/" + data.id,
        data: {
            names: names,
            roles: roles
        },
        success: function (res) {
            closeLoading();
            if (res.status === "nok")
                showSuccessNotifiBP("خطایی در انجام عملیات رخ داده است.", 'right', '#ac0020');
            else if (res.status === "ok") {
                currProgress += progress;
                updateSideProgressBar(currProgress);
                $('.indicator_step').addClass('hidden');
                currentPage++;
                $("#step" + currentPage).removeClass('hidden');
            }
        },
        error: function (reject) {
            errorAjax(reject);
        }
    });

    updateSideProgressBar(progress);
    return false;
}

function checkStepSix(progress) {

    data.expire = $("#expire").val();
    data.shaba = $("#shaba").val();

    var idx = getIdxInFitImages('additionalValue');

    if(data.shaba.length == 0 ||
        (data.hasAdditionalValue && data.expire.length == 0) ||
        (data.hasAdditionalValue && idx == -1) ||
        (data.hasAdditionalValue && uploaders[idx][4].length == 0) ||
        (data.hasAdditionalValue && uploaders[idx][4][0].uploaded != 1)
    ) {
        showSuccessNotifiBP("لطفا تمام فیلد ها را به شکل صحیح پر نمایید.", 'right', '#ac0020');
        return false;
    }

    openLoading();

    $.ajax({
        type: 'post',
        url: updateBusinessInfo4BaseUrl + "/" + data.id,
        data: {
            'shaba': data.shaba,
            'expire': data.expire.replace(/\s/g, ''),
            'additionalValue': (data.hasAdditionalValue) ? "true" : "false"
        },
        success: function (res) {

            closeLoading();

            if(res.status === "ok") {
                currProgress += progress;
                updateSideProgressBar(currProgress);
                $('.indicator_step').addClass('hidden');
                currentPage++;
                $("#step" + currentPage).removeClass('hidden');
            }
            else
                showSuccessNotifiBP(res.msg, 'right', '#ac0020');
        },
        error: function (reject) {
            errorAjax(reject);
        }
    });

    return false;
}

function checkStepSeven() {

    var idx1 = getIdxInFitImages("pic");
    var idx2 = getIdxInFitImages("logo");

    if(idx1 == -1 || idx2 == -1 ||
        uploaders[idx1][4].length < 1 ||
        uploaders[idx2][4].length < 1) {
        showSuccessNotifiBP("لطفا تمام فیلد ها را به شکل صحیح پر نمایید.", 'right', '#ac0020');
        return false;
    }

    return true;
}

function checkFinalStep() {

    if(!$("#confirmContract").prop("checked")) {
        showSuccessNotifiBP("تایید متن قرارداد همکاری الزامی است.", 'right', '#ac0020');
        return;
    }

    openLoading();

    $.ajax({
        type: 'post',
        url: finalizeBusinessInfoBaeUrl + "/" + data.id,
        success: function (res) {

            closeLoading();

            if(res.status == "ok") {
                document.location.href = myBusinessesPath;
                return;
            }

            showSuccessNotifiBP(res.msg, 'right', '#ac0020');
        },
        error: function (reject) {
            errorAjax(reject);
        }
    });
}

function goToPage(_step, progress) {

    if(currentPage == 1 && _step == -1 || (currentPage == 3 && _step == -1 && mode == "edit"))
        return;

    else if(currentPage == 1 && !checkStepOne())
        return;

    else if(currentPage == 2 && _step > 0 && !checkStepTwo())
        return;

    else if(currentPage == 3 && _step > 0 && !checkStepThree(progress))
        return;

    else if(currentPage == 4 && _step > 0 && !checkStepFour(progress))
        return;

    else if(currentPage == 5 && _step > 0 && !checkStepFive(progress))
        return;

    else if(currentPage == 6 && _step > 0 && !checkStepSix(progress))
        return;

    else if(currentPage == 7 && _step > 0 && !checkStepSeven())
        return;

    else if(currentPage == 8 && _step > 0) {
        checkFinalStep();
        return;
    }

    currentPage += _step;

    $('.indicator_step').addClass('hidden');
    $("#step" + currentPage).removeClass('hidden');
    currProgress += progress;
    updateSideProgressBar(currProgress);

    if(currentPage == 8)
        getContract();
}

function scrolled(e) {

    myDiv = document.getElementById("contract");

    if (myDiv.offsetHeight + myDiv.scrollTop >= myDiv.scrollHeight) {
        $("#confirmContract").removeAttr('disabled');
    }
}

function getContract() {

    var contractIdx = fetchedContracts.indexOf(data.type);

    if(contractIdx != -1)
        $("#contract").empty().append(contracts[contractIdx]);
    else {
        openLoading();
        $.ajax({
            type: 'post',
            url: getContractPath,
            data: {
                'type': data.type
            },
            success: function (res) {

                closeLoading();

                if(res.status === "ok") {
                    fetchedContracts.push(data.type);
                    contracts.push(res.contract);
                    $("#contract").empty().append(res.contract);
                }

            },
            error: function (reject) {
                errorAjax(reject);
            }
        })
    }
}

function iAm24Hour(){
    isChecked = $('#allDay24').prop('checked');
    if(isChecked){
        $('#inWeekDiv').addClass('hidden');
        $('#closedBeforeDayDiv').addClass('hidden');
    }
    else{
        $('#inWeekDiv').removeClass('hidden');
        $('#closedBeforeDayDiv').removeClass('hidden');
    }
}

function iAmClose(_element){
    var isChecked = $(_element).prop('checked');
    if(isChecked){
        $(_element).parent().addClass('checked');
        $(_element).parent().prev().addClass('hidden');
    }
    else{
        $(_element).parent().removeClass('checked');
        $(_element).parent().prev().removeClass('hidden');
    }
}

function preventDefaults (e) {
    e.preventDefault();
    e.stopPropagation();
}

function getIdxInFitImages(field) {

    for (var t = 0; t < uploaders.length; t++) {
        if(uploaders[t][0] == field) {
            return t;
        }
    }

    return -1;
}

function initUploader(field, showSection, textSection, max) {

    var idx = getIdxInFitImages(field);

    if(idx != -1) {
        if(max <= uploaders[idx][4].length) {
            showSuccessNotifiBP("در این قسمت حداکثر " + max + " فایل قابل آپلود است.", 'right', '#ac0020');
            return -1;
        }
    }
    else {
        uploaders.push([field, showSection, textSection, max, []]);
        idx = uploaders.length - 1;
    }

    return idx;
}

function uploadPicClickHandler(_input, idx) {
    if(_input.files && _input.files[0])
        createAndUploadFilePic(_input.files[0], idx);
    $(_input).val('');
}

function createAndUploadFilePic(_files, idx) {

    if(uploaders[idx][4].length >= uploaders[idx][3])
        return;

    var reader = new FileReader();

    reader.onload = e => {
        var index = uploaders[idx][4].push({
            file: _files,
            image: e.target.result,
            serverPicId: -1,
            uploaded: -1,
            code: Math.floor(Math.random() * 1000)
        });
        createNewImgUploadCard(index - 1, idx);
        uploadQueuePictures(idx);
    };
    reader.readAsDataURL(_files);
}

function createNewImgUploadCard(_index, idx) {

    // if(_index == 0)
    //     $('#' + uploaders[idx][2]).addClass('hidden');

    var file = uploaders[idx][4][_index];
    var text = `<div id="uplaodedImg_${file.code}" class="uploadFileCard">
                    <div class="img">
                        <img src="${file.image}" class="resizeImgClass" onload="fitThisImg(this)">
                    </div>
                    <div class="absoluteBackground tickIcon"></div>
                    <div id="warningUpload_${file.code}" class="absoluteBackground warningIcon">اشکال در بارگذاری</div>
                    <div class="absoluteBackground process">
                        <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
                        <div class="processCounter">0%</div>
                    </div>
                    <div class="hoverInfos" style="cursor: pointer">
                        <div onclick="deleteThisUploadedImage(${file.code},'${getIdxInFitImages(uploaders[idx][0])}')" class="cancelButton closeIconWithCircle"> حذف عکس </div>
                    </div>
                </div>`;

    $('#' + uploaders[idx][1]).append(text);
}

function deleteThisUploadedImage(_code, idx) {

    var index = null;
    for(var i = 0; i < uploaders[idx][4].length; i++) {
        if(uploaders[idx][4][i].code == _code){
            index = i;
            break;
        }
    }

    if(index != null) {
        if(uploaders[idx][4][index].uploaded == 0)
            cancelThisImg = true;
        else if(uploaders[idx][4][index].uploaded == -1 || uploaders[idx][4][index].uploaded == -2) {
            uploaders[idx][4].splice(index, 1);
            $('#uplaodedImg_' + _code).remove();
        }
        else if(uploaders[idx][4][index].uploaded == 1)
            doDeletePicServer(index, idx);
    }

    if(uploaders[idx][4].length == 0)
        $('#' + uploaders[idx][2]).removeClass('hidden');
}

function doDeletePicServer(_index, idx) {

    var file = uploaders[idx][4][_index];
    var formData = {"id": file.serverPicId};

    if(uploaders[idx][0].indexOf('madarek') != -1) {
        formData["idx"] =  uploaders[idx][0].split("_")[1];
        formData["field"] = "madarek";
    }
    else
        formData["field"] = uploaders[idx][0];

    $.ajax({
        type: 'delete',
        url: deleteBusinessPicBaseUrl + "/" + data.id,
        data: formData,
        success: response => {
            if(response.status == 'ok'){
                $('#uplaodedImg_' + file.code).remove();
                uploaders[idx][4].splice(_index, 1);
            }
            else
                showSuccessNotifiBP(response.msg, 'right', '#ac0020');
        },
        error: function (reject) {
            errorAjax(reject);
        }
    })
}


var uploadPicAjax = null;
var uploadProcess = false;
var cancelThisImg = false;

function uploadQueuePictures(idx) {

    if(uploadProcess == false) {

        uploadProcess = true;
        var uploadIndex = null;

        uploaders[idx][4].map((item, index) => {
            if(item.uploaded == -1 && uploadIndex == null)
                uploadIndex = index;
        });

        if(uploadIndex != null) {

            var uFile = uploaders[idx][4][uploadIndex];
            uFile.uploaded = 0;
            $('#uplaodedImg_' + uFile.code).addClass('process');

            var formData = new FormData();
            formData.append('pic', uFile.file);

            var madarek_idx = -1;

            if(uploaders[idx][0].indexOf('madarek') != -1) {
                madarek_idx = uploaders[idx][0].split("_")[1];
                formData.append("idx", madarek_idx);
                formData.append("field", "madarek");
            }
            else
                formData.append("field", uploaders[idx][0]);

            uploadPicAjax = $.ajax({
                type: 'post',
                url: uploadPicBusinessBaseUrl + "/" + data.id,
                data: formData,
                processData: false,
                contentType: false,
                xhr: function () {
                    var xhr = new XMLHttpRequest();
                    xhr.upload.onprogress = e => {
                        if (e.lengthComputable) {
                            var percent = Math.round((e.loaded / e.total) * 100);
                            $('#uplaodedImg_' + uFile.code).find('.processCounter').text(percent + '%');
                        }
                    };
                    return xhr;
                },
                success: response => {
                    uploadProcess = false;
                    if (response.status == 'ok') {

                        if(madarek_idx != -1)
                            id_idx[madarek_idx] = 1;

                        $('#uplaodedImg_' + uFile.code).removeClass('process').addClass('done');
                        $("#warningUpload_" + uFile.code).remove();
                        uFile.uploaded = 1;
                        uFile.serverPicId = response.id;
                        uploadQueuePictures(idx);

                        if(cancelThisImg) {
                            doDeletePicServer(uploadIndex, idx);
                            cancelThisImg = false;
                        }

                    }
                    else {
                        $('#uplaodedImg_' + uFile.code).removeClass('process').addClass('error');
                        uFile.uploaded = -2;
                    }
                },
                error: err => {
                    uploadProcess = false;
                    $('#uplaodedImg_' + uFile.code).removeClass('process').addClass('error');
                    uFile.uploaded = -2;
                }
            })
        }
        else
            uploadProcess = false;
    }
}

function changeAdditionalValue() {

    data.hasAdditionalValue = $("#additionalValue").prop("checked");

    if(data.hasAdditionalValue)
        $(".additionalValue").removeClass('hidden');
    else
        $(".additionalValue").addClass('hidden');
}
