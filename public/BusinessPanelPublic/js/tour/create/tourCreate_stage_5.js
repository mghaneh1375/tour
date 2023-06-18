var selectedEquipment = tour.euipment;
var dragedElementId = 0;
var storeData = {
    levels: tour.levels,
    kinds: tour.kinds,
    focus: tour.focus,
    fitFor: tour.fitFor,
    style: tour.style,
    equipment: selectedEquipment,
    mainDescription: tour.description,
    textExpectation: tour.textExpectation,
    specialInformation: tour.specialInformation,
    opinion: tour.opinion,
    tourLimit: tour.tourLimit,
    sideDescription: tour.sideDescription,

    isCancelAbel: tour.cancelAble,
    cancelDescription: tour.cancelDescription,
};

$(window).ready(() => {
    autosize($("textarea"));

    fillInputs();
});

function fillInputs() {
    $("#mainDescription").val(storeData.mainDescription);
    $("#textExpectation").val(storeData.textExpectation);
    $("#specialInformation").val(storeData.specialInformation);
    $("#opinionText").val(storeData.opinion);
    $("#tourLimit").val(storeData.tourLimit);
    $("#cancelDescription").val(storeData.cancelDescription);

    var sideDesc = $('input[name="sideDescription[]"]');
    for (var i = 0; i < sideDesc.length; i++)
        $(sideDesc[i]).val(storeData.sideDescription[i]);

    storeData.equipment.necessary.map((item) => {
        dragedElementId = item;
        drop("necessary");
    });
    storeData.equipment.suggest.map((item) => {
        dragedElementId = item;
        drop("suggest");
    });

    storeData.kinds.map((item) => $(`#tourKind${item}`).parent().click());
    storeData.levels.map((item) => $(`#tourDifficult${item}`).click());
    storeData.focus.map((item) => $(`#focus_${item}`).prop("checked", true));
    storeData.fitFor.map((item) => $(`#fitFor_${item}`).prop("checked", true));
    storeData.style.map((item) =>
        $(`#tourStyle_${item}`).prop("checked", true)
    );

    $(`input[name="isCancelAbel"][value="${storeData.isCancelAbel}"]`).click();
}

function checkTourStyleCount(_element) {
    var checkStyles = $('input[name="style[]"]:checked');
    if (checkStyles.length > 3) _element.checked = false;
}

function checkTourFitForCount(_element) {
    var checkFitFors = $('input[name="fitFor[]"]:checked');
    if (checkFitFors.length > 2) _element.checked = false;
}

var allowDrop = (ev) => ev.preventDefault();
var drag = (_element) => (dragedElementId = $(_element).attr("data-id"));

var changeCancelAble = (_value) =>
    $("#cancelDiv").css("display", _value == 1 ? "block" : "none");

function chooseTourKind(_element) {
    var kindsElements = $(".tourKind.chooseTourKind");
    $(_element).toggleClass("chooseTourKind");

    setTimeout(() => {
        if (kindsElements.length >= 3)
            $(kindsElements[0]).removeClass("chooseTourKind");
    }, 200);
}

function drop(_kind) {
    if (dragedElementId != 0) {
        var element = $(`#equipmentItem_${dragedElementId}`);
        var html = `<div data-id="${dragedElementId}" class="lessShowText" onclick="deleteEquipment(this, '${_kind}')">
                        <span>${element.text()}</span>
                        <i class="fa-regular fa-xmark"></i>
                    </div>`;

        selectedEquipment[_kind].push(dragedElementId);
        $(`#${_kind}ItemsTourCreation`).append(html);

        element.addClass("hidden");
        dragedElementId = 0;
    }
}

function chooseDifficult(_element) {
    if ($(_element).hasClass("aloneDifficult"))
        $(".aloneDifficult").removeClass("chooseTourKind");

    $(_element).toggleClass("chooseTourKind");
}

function changeEquipment(_id) {
    document.getElementById("equipmentSection_" + lastEquipment).style.display =
        "none";
    document.getElementById("equipmentSection_" + _id).style.display =
        "inline-block";

    document
        .getElementById("mainEquipment" + lastEquipment)
        .classList.remove("selectTag");
    document.getElementById("mainEquipment" + _id).classList.add("selectTag");

    lastEquipment = _id;
}

function deleteEquipment(_element, _kind) {
    var id = $(_element).attr("data-id");
    var index = selectedEquipment[_kind].indexOf(id);
    if (index > -1) selectedEquipment[_kind].splice(index, 1);

    $(`#equipmentItem_${id}`).removeClass("hidden");
    $(_element).remove();
}

function checkInput(_mainStore = true) {
    storeData = {
        levels: [],
        kinds: [],
        focus: [],
        fitFor: [],
        style: [],
        equipment: selectedEquipment,
        mainDescription: $("#mainDescription").val(),
        textExpectation: $("#textExpectation").val(),
        specialInformation: $("#specialInformation").val(),
        opinion: $("#opinionText").val(),
        tourLimit: $("#tourLimit").val(),
        sideDescription: [],

        isCancelAbel: $('input[name="isCancelAbel"]:checked').val(),
        cancelDescription: $("#cancelDescription").val(),
    };

    var levelsElements = $(".tourLevelIcons.chooseTourKind");
    var kindsElements = $(".tourKind.chooseTourKind");
    var focus = $('input[name="focus[]"]:checked');
    var style = $('input[name="style[]"]:checked');
    var fitFor = $('input[name="fitFor[]"]:checked');

    for (var i = 0; i < levelsElements.length; i++)
        storeData.levels.push($(levelsElements[i]).attr("data-id"));

    for (i = 0; i < kindsElements.length; i++)
        storeData.kinds.push($(kindsElements[i]).attr("data-id"));

    for (i = 0; i < focus.length; i++) storeData.focus.push($(focus[i]).val());

    for (i = 0; i < fitFor.length; i++)
        storeData.fitFor.push($(fitFor[i]).val());

    for (i = 0; i < style.length; i++) storeData.style.push($(style[i]).val());

    var sideDescription = $('input[name="sideDescription[]"]');
    for (i = 0; i < sideDescription.length; i++)
        storeData.sideDescription.push($(sideDescription[i]).val());

    if (_mainStore) doStore();
    else
        localStorage.setItem(
            `stageFiveTourCreation_${tour.id}`,
            JSON.stringify(storeData)
        );
}

function doStore() {
    openLoading();
    $.ajax({
        type: "POST",
        url: storeStageThreeURL,
        data: {
            _token: csrfTokenGlobal,
            tourId: tour.id,
            data: JSON.stringify(storeData),
        },
        success: (response) => {
            if (response.status == "ok") {
                localStorage.removeItem(`stageFiveTourCreation_${tour.id}`);
                location.href = nextStageUrl;
            } else {
                closeLoading();
                showSuccessNotifiBP("Server Error", "left", "red");
            }
        },
        error: (err) => {
            closeLoading();
            showSuccessNotifiBP("Server Error", "left", "red");
        },
    });
}

function doLastUpdate() {
    storeData = JSON.parse(lastData);
    fillInputs();
}

var lastData = localStorage.getItem(`stageFiveTourCreation_${tour.id}`);
if (!(lastData == false || lastData == null))
    openWarningBP(
        "بازگرداندن اطلاعات قبلی",
        doLastUpdate,
        "بله قبلی را ادامه می دهم"
    );
setInterval(() => checkInput(false), 5000);

var uploadProcess = false;
var uploadProcessId = null;
var picQueue = [];
var picInput = 1;
var picCardSample = $("#picCardSample").html();
$("#picCardSample").remove();

function readURL(input, _index) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        var text = picCardSample;
        text = text.replace(new RegExp("##index##", "g"), picInput);

        $("#picHover_" + _index).removeClass("hidden");
        $("#showPic" + _index).removeClass("hidden");
        $("#addPic" + _index).addClass("hidden");
        picInput++;

        reader.onload = (e) => {
            $("#imgPic" + _index).attr("src", e.target.result);
            $("#uploadImgDiv").append(text);
        };
        reader.readAsDataURL(input.files[0]);

        picQueue.push({
            id: _index,
            uploadedName: "",
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

            var file = document.getElementById(
                `picsInput_${uploadProcessId}`
            ).files;
            console.log(tour.id);
            uploadLargeFile(
                tourPicUrl,
                file[0],
                { tourId: tour.id },
                uploadPicResult
            );
        }
    }
}

function uploadPicResult(_status, _fileName = "") {
    var element = $(`#picHover_${uploadProcessId}`);
    var porcIndex = null;
    picQueue.map((item, index) => {
        if (item.id == uploadProcessId && porcIndex == null) porcIndex = index;
    });
    if (_status == "done") {
        picQueue[porcIndex].process = 2;
        element.find(".process").addClass("hidden");
        element.find(".tickIcon").removeClass("hidden");
        picQueue[porcIndex].uploadedName = _fileName;

        uploadProcessId = null;
        uploadProcess = false;

        checkUpload();
    } else if (_status == "error") {
        picQueue[porcIndex].process = -1;
        element.find(".process").addClass("hidden");
        element.find(".warningIcon").removeClass("hidden");
        uploadProcessId = null;
        uploadProcess = false;
        setTimeout(checkUpload, 200);
    } else if (_status == "cancelUpload") {
        element.find(".process").addClass("hidden");
        $("#picDiv" + uploadProcessId).remove();
        picQueue.splice(porcIndex, 1);
        uploadProcessId = null;
        uploadProcess = false;
        setTimeout(checkUpload, 200);
    } else if (_status == "queue") setTimeout(checkUpload, 200);
    else {
        picQueue[porcIndex].uploadedName = _fileName;
        element.find(".processCounter").text(_status + "%");
    }
}

function deleteThisPic(_id) {
    if (uploadProcessId == _id) cancelLargeUploadedFile();
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
            $("#picDiv" + deleteId).remove();
            if (picQueue[deleteIndex].process == 2)
                deletedUploadedPic(picQueue[deleteIndex].uploadedName);
            picQueue.splice(deleteIndex, 1);
        }
    }
}

function deletedUploadedPic(_fileName) {
    $.ajax({
        type: "DELETE",
        url: deleteTourPicUrl,
        data: {
            _token: csrfTokenGlobal,
            tourId: tour.id,
            fileName: _fileName,
        },
    });
}

uploadedPics.map((item, index) => {
    var text = picCardSample;
    text = text.replace(new RegExp("##index##", "g"), picInput);
    $("#uploadImgDiv").append(text);
    picInput++;

    picQueue.push({
        id: index,
        uploadedName: item.pic,
        process: 2,
    });

    $("#showPic" + index).removeClass("hidden");
    $("#addPic" + index).addClass("hidden");
    $("#imgPic" + index).attr("src", item.url);

    var element = $("#picHover_" + index);
    element.removeClass("hidden");
    element.find(".process").addClass("hidden");
    element.find(".tickIcon").removeClass("hidden");
});
