var priceIndex = 0;
var lastDayDiscoutnIndex = 0;
var featuresCount = 0;
var disCountNumber = 0;
var featureRowCard = $("#featureRowSample").html();
var disCountCard = $("#discountSample").html();
var datePickerOptions = {
    numberOfMonths: 1,
    showButtonPanel: true,
    dateFormat: "yy/mm/dd",
};
$("#featureRowSample").remove();
$("#discountSample").remove();

var disCountIndex = 1;
var disCounts = [];
var discountError = false;

var storeData = {
    cost: tour.minCost,
    isInsurance: tour.isInsurance,
    features: tour.features,
    discounts: tour.groupDiscount == [] ? 0 : tour.groupDiscount,
    prices: tour.prices,
    lastDays: tour.lastDays,
    // disCountReason:  tour.reasonDiscount == null ? 0 : tour.reasonDiscount.discount,
    // sDiscountDate: tour.reasonDiscount == null ? 0 : tour.reasonDiscount.sReasonDate,
    // eDiscountDate: tour.reasonDiscount == null ? 0 : tour.reasonDiscount.eReasonDate,
    // ticketKind: tour.ticketKind,
    // childDisCount: tour.childDiscount == null ? 0 : tour.childDiscount.discount,
};

$(window).ready(() => {
    $(".datePic").datepicker(datePickerOptions);
    // createFeatureRow();
    // createDisCountCard();

    fillInputs();
});

function goToPrevStep() {
    openLoading(false, () => {
        location.href = prevStageUrl;
    });
}

function fillInputs() {
    $("#tourCost").val(numberWithCommas(storeData.cost));
    // $('input[name="isInsurance"]').parent().removeClass("active");
    $(`input[name="isInsurance"][value="${storeData.isInsurance}"]`)
        .prop("checked", true)
        .parent()
        .addClass("active");

    storeData.features.map((features, index) => {
        if ((index != 0 && features, $("#featureName_" + index).length == 0))
            createFeatureRow();

        setTimeout(() => {
            $("#featureName_" + index).val(features.name);
            $("#featureDesc_" + index).val(features.description);
            $("#featureCost_" + index).val(numberWithCommas(features.cost));
        }, 100);
    });

    storeData.discounts.map((discount, index) => {
        if (index != 0 && $("#disCountFrom_" + index).length == 0)
            createDisCountCard();

        setTimeout(() => {
            disCounts[index].from = discount.min;
            disCounts[index].to = discount.max;

            $("#disCountFrom_" + index).val(discount.min);
            $("#disCountTo_" + index).val(discount.max);
            $("#disCountCap_" + index).val(parseInt(discount.discount));
        }, 50);
    });

    // storeData.prices.forEach(() => createNewPriceRow());
    storeData.prices.map((item, index) => {
        if ($(`#priceInput_${index}`).length == 0) createNewPriceRow();

        $(`#priceInput_${index}`).val(item.cost);
        $(`#priceAgeFrom_${index}`).val(item.ageFrom);
        $(`#priceAgeTo_${index}`).val(item.ageTo);

        $(`input[name="isFreePrice_${index}"]`).parent().removeClass("active");
        $(`input[name="isFreePrice_${index}"][value="${item.isFree}"]`)
            .prop("checked", true)
            .parent()
            .addClass("active");
        changeFreePrice(index, item.isFree);

        $(`input[name="inCapacity_${index}"]`).parent().removeClass("active");
        $(`input[name="inCapacity_${index}"][value="${item.inCapacity}"]`)
            .prop("checked", true)
            .parent()
            .addClass("active");
    });

    // storeData.lastDays.forEach(() => addLastDayDiscount());
    storeData.lastDays.map((item, index) => {
        if ($("#dayDiscountInput_" + index).length == 0) addLastDayDiscount();
        $("#dayDiscountInput_" + index).val(item.discount);
        $("#dayDiscountDay_" + index).val(item.remainingDay);
    });

    setTimeout(() => {
        disableAllSelectAges();
        checkAllDiscount();
    }, 1000);
}

function createFeatureRow() {
    $(".deleteButton").removeClass("hidden");
    var text = featureRowCard;
    text = text.replace(new RegExp("##index##", "g"), featuresCount);
    $("#featuresDiv").append(text);
    featuresCount++;
    console.log(featuresCount);
}

function deleteFeatureRow(_index) {
    if ($(".featuresRow").length > 0) $("#features_" + _index).remove();
}

function createDisCountCard() {
    $(".deleteDisCountButton").removeClass("hidden");
    $(".confirmDisCountButton").addClass("hidden");

    var text = disCountCard;
    text = text.replace(new RegExp("##index##", "g"), disCountNumber);
    $("#groupDiscountDiv").append(text);
    disCountNumber++;

    disCounts.push({ to: 0, from: 0 });

    if (disCountNumber > 1) checkAllDiscount();
}

function deleteDisCountCard(_index) {
    disCounts[_index] = { to: -1, from: -1 };
    if ($(".discountrow").length > 0) $("#groupDiscount_" + _index).remove();
}

function checkDiscount(_index, _value, _kind) {
    var errorIndex = false;
    if (_kind == 1) disCounts[_index].to = parseInt(_value);
    else disCounts[_index].from = parseInt(_value);

    for (i = disCounts.length - 1; i >= 0; i--) {
        if (i != _index) {
            if (
                disCounts[i].to != 0 &&
                disCounts[i].to != -1 &&
                disCounts[i].from != 0 &&
                disCounts[i].from != -1
            ) {
                if (_value >= disCounts[i].from && _value <= disCounts[i].to) {
                    errorIndex = true;
                    break;
                }
            }
        }
    }

    var showId = (_kind == 1 ? "disCountTo_" : "disCountFrom_") + _index;
    if (errorIndex) $(`#${showId}`).addClass("errorClass");
    else $(`#${showId}`).removeClass("errorClass");
}

function checkAllDiscount() {
    discountError = false;
    for (var i = disCounts.length - 1; i >= 0; i--) {
        if (disCounts[i].to != -1 && disCounts[i].from != -1) {
            if (disCounts[i].from == 0 || disCounts[i].to == 0) {
                if (disCounts[i].to == 0)
                    document
                        .getElementById("disCountTo_" + i)
                        .classList.add("errorClass");
                if (disCounts[i].from == 0)
                    document
                        .getElementById("disCountFrom_" + i)
                        .classList.add("errorClass");
            } else if (disCounts[i].from > disCounts[i].to) {
                document
                    .getElementById("disCountTo_" + i)
                    .classList.add("errorClass");
                document
                    .getElementById("disCountFrom_" + i)
                    .classList.add("errorClass");
            } else {
                var checkErrorTo = false;
                var checkErrorFrom = false;

                for (var j = i - 1; j >= 0; j--) {
                    if (
                        disCounts[j].to != 0 &&
                        disCounts[j].to != -1 &&
                        disCounts[j].from != 0 &&
                        disCounts[j].from != -1
                    ) {
                        if (
                            !checkErrorFrom &&
                            disCounts[i].from >= disCounts[j].from &&
                            disCounts[i].from <= disCounts[j].to
                        ) {
                            document
                                .getElementById("disCountFrom_" + i)
                                .classList.add("errorClass");
                            checkErrorFrom = true;
                            discountError = true;
                        }
                        if (
                            !checkErrorTo &&
                            disCounts[i].to >= disCounts[j].from &&
                            disCounts[i].to <= disCounts[j].to
                        ) {
                            document
                                .getElementById("disCountTo_" + i)
                                .classList.add("errorClass");
                            checkErrorTo = true;
                            discountError = true;
                        }
                    }
                }

                if (!checkErrorFrom)
                    document
                        .getElementById("disCountFrom_" + i)
                        .classList.remove("errorClass");
                if (!checkErrorTo)
                    document
                        .getElementById("disCountTo_" + i)
                        .classList.remove("errorClass");
            }
        }
    }
}

function checkInput(_mainStore = true) {
    var errorText = "";

    storeData = {
        cost: $("#tourCost").val().replace(new RegExp(",", "g"), ""),
        isInsurance: $('input[name="isInsurance"]:checked').val(),
        lastDays: [],
        prices: [],
        features: [],
        discounts: [],
        // disCountReason: $('#disCountReason').val(),
        // sDiscountDate: $('#sDiscountDate').val(),
        // eDiscountDate: $('#eDiscountDate').val(),
        // ticketKind: $('#ticketKind').val(),
        // childDisCount: $('#childDisCount').val(),
    };

    if (storeData.cost.trim().length == 0)
        errorText = "<li>قیمت پایه تور خود را مشخص کنید</li>";

    if (errorText == "" || _mainStore == false) {
        var warning = "";
        var index;

        var features = $(".featuresRow");
        var featureWarning = false;
        for (var i = 0; i < features.length; i++) {
            index = $(features[i]).attr("data-index");

            var name = $(`#featureName_${index}`).val();
            var description = $(`#featureDesc_${index}`).val();
            var cost = $(`#featureCost_${index}`).val();

            if (name.trim().length > 0 && cost.trim().length > 0) {
                storeData.features.push({
                    name: name,
                    description: description,
                    cost: cost.replace(new RegExp(",", "g"), ""),
                });
            } else featureWarning = true;
        }
        if (featureWarning)
            warning +=
                "<li>بعضی از امکانات شما یا اسم ندارند یا قیمت . در این صورت ثبت نمی شوند.</li>";

        var discounts = $(".discountrow");
        var discountWarning = false;
        for (i = 0; i < discounts.length; i++) {
            index = $(discounts[i]).attr("data-index");

            var disCountFrom = $(`#disCountFrom_${index}`).val();
            var disCountTo = $(`#disCountTo_${index}`).val();
            var discount = $(`#disCountCap_${index}`).val();

            if (disCountFrom > 0 && disCountTo > 0 && discount > 0) {
                storeData.discounts.push({
                    min: disCountFrom,
                    max: disCountTo,
                    discount: discount,
                });
            } else discountWarning = true;
        }

        if (discountWarning)
            warning +=
                "<li>بعضی از تخفیف های گروهی بازه و درصد تخفیف ندارند . در این صورت ثبت نمی شوند.</li>";

        var lastDaysDiscounts = $(".dayToDiscountRow");
        for (i = 0; i < lastDaysDiscounts.length; i++) {
            var dIndex = $(lastDaysDiscounts[i]).attr("data-index");
            var discount = $("#dayDiscountInput_" + dIndex).val();
            var days = $("#dayDiscountDay_" + dIndex).val();

            if (discount > 0 && days > 0) {
                storeData.lastDays.push({
                    discount: discount,
                    remainingDay: days,
                });
            }
        }

        var priceSelects = $(".selectAges");
        for (i = 0; i < priceSelects.length; i++) {
            var pIndex = $(priceSelects[i]).attr("data-index");
            var cost = $(`#priceInput_${pIndex}`)
                .val()
                .replace(new RegExp(",", "g"), "");
            var ageFrom = $(`#priceAgeFrom_${pIndex}`).val();
            var ageTo = $(`#priceAgeTo_${pIndex}`).val();
            var inCapacity = $(
                `input[name="inCapacity_${pIndex}"]:checked`
            ).val();
            var isFree = $(`input[name="isFreePrice_${pIndex}"]:checked`).val();

            if (
                (cost.trim().length != 0 || isFree == 1) &&
                ageFrom >= 0 &&
                ageTo >= 0
            ) {
                storeData.prices.push({
                    cost,
                    ageFrom,
                    ageTo,
                    inCapacity,
                    isFree,
                });
            }
        }

        if (warning == "" && _mainStore) doSaveInfos();
        else if (_mainStore == false)
            localStorage.setItem(
                `stageFourTourCreation_${tour.id}`,
                JSON.stringify(storeData)
            );
        else openWarningBP(`<ul>${warning}</ul>`, doSaveInfos, "مشکلی نیست");
    } else openErrorAlertBP(`<ul>${errorText}</ul>`);
}

function doSaveInfos() {
    openLoading();

    $.ajax({
        type: "POST",
        url: storeStageFourURL,
        data: {
            _token: csrfTokenGlobal,
            tourId: tour.id,
            data: JSON.stringify(storeData),
        },
        success: (response) => {
            if (response.status == "ok") {
                localStorage.removeItem(`stageFourTourCreation_${tour.id}`);
                location.href = nextStageUrl;
            } else {
                closeLoading();
                showSuccessNotifiBP("در ثبت مشکلی پیش امده", "left", "red");
            }
        },
        error: (err) => {
            closeLoading();
            showSuccessNotifiBP("در ثبت مشکلی پیش امده", "left", "red");
        },
    });
}

function changeFreePrice(_index, _value) {
    if (_value == 1) $(`#price_${_index}`).addClass("forceHidden");
    else $(`#price_${_index}`).removeClass("forceHidden");
}

function createNewPriceRow() {
    var options = "";
    for (var i = 0; i < 18; i++)
        options += `<option value="${i}">${i}</option>`;

    var priceHtml = `<div class="tourBasicPriceTourCreation tourOtherPrice col-md-12">
                        <div class="row" style="display: flex; align-items: center;">
                            <div id="price_${priceIndex}" class="inputBoxTour col-md-3" style="margin-left: 10px">
                                <div class="inputBoxText">
                                    <div>
                                        قیمت
                                    </div>
                                </div>
                                <input class="inputBoxInput" id="priceInput_${priceIndex}" type="text" placeholder="ریال" onkeyup="$(this).val(numberWithCommas(this.value))">
                            </div>
                            <div class="col-md-8 float-right">
                                <div class="inputBox discountLimitationWholesale float-right" style="display: flex">
                                    <div class="inputBoxText" style="width: 180px">
                                        <div>
                                            بازه‌ی سن<span>*</span>
                                        </div>
                                    </div>
                                    <select id="priceAgeFrom_${priceIndex}" data-index="${priceIndex}" class="selectAges inputBoxInput" onchange="disableAllSelectAges()">
                                        ${options}
                                    </select>
                                    <div class="inputBoxText">الی</div>
                                    <select id="priceAgeTo_${priceIndex}" data-index="${priceIndex}" class="inputBoxInput" onchange="disableAllSelectAges()">
                                        ${options}
                                    </select>
                                </div>
                                <div class="inline-block mg-rt-10">
                                    <div class="deleteButton iconFullClose wholesaleDiscountLimitationBtn deleteBtnTourCreation" onclick="deleteThisPrice(this)">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 pd-0">
                                <p class="dispalyInline bold">آیا این بازه سنی جز ظرفیت حساب می شود؟</p>
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-secondary active">
                                        <input type="radio" name="inCapacity_${priceIndex}" value="1" checked>بلی
                                    </label>
                                    <label class="btn btn-secondary">
                                        <input type="radio" name="inCapacity_${priceIndex}" value="0">خیر
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6 pd-0">
                                <p class="dispalyInline bold">آیا این بازه سنی رایگان است؟</p>
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-secondary">
                                        <input type="radio" name="isFreePrice_${priceIndex}" value="1" onchange="changeFreePrice(${priceIndex}, this.value)">بلی
                                    </label>
                                    <label class="btn btn-secondary active">
                                        <input type="radio" name="isFreePrice_${priceIndex}" value="0" checked onchange="changeFreePrice(${priceIndex}, this.value)">خیر
                                    </label>
                                </div>
                            </div>
                        </div>

                        
                </div>`;
    $("#pricesSection").append(priceHtml);
    priceIndex++;

    disableAllSelectAges();
}

function deleteThisPrice(_element) {
    $(_element).parent().parent().parent().parent().remove();
    disableAllSelectAges();
}

function disableThisSelectAges(_index) {
    var value = $(`#priceAgeFrom_${_index}`).val();
    for (var i = 0; i <= 17; i++)
        document.getElementById("priceAgeTo_" + _index).options[i].disabled =
            i <= value;

    value = $(`#priceAgeTo_${_index}`).val();
    if (value > 0) {
        for (i = 0; i <= 17; i++)
            document.getElementById("priceAgeFrom_" + _index).options[
                i
            ].disabled = i >= value;
    }
}

function disableAllSelectAges() {
    var index;
    var index2;
    var period = [0, 0];
    var selects = $(".selectAges");

    for (var i = 0; i < selects.length; i++) {
        index = $(selects[i]).attr("data-index");
        disableThisSelectAges(index);
    }

    for (i = 0; i < selects.length; i++) {
        index = $(selects[i]).attr("data-index");

        period[0] = parseInt($("#priceAgeFrom_" + index).val());
        period[1] = parseInt($("#priceAgeTo_" + index).val());

        if (period[0] != null && period[1] != null) {
            for (var j = 0; j < selects.length; j++) {
                if (j != i) {
                    index2 = $(selects[j]).attr("data-index");
                    for (var k = 0; k <= 17; k++) {
                        if (k >= period[0] && k <= period[1]) {
                            document.getElementById(
                                "priceAgeTo_" + index2
                            ).options[k].disabled = true;
                            document.getElementById(
                                "priceAgeFrom_" + index2
                            ).options[k].disabled = true;
                        }
                    }
                }
            }
        }
    }
}

function addLastDayDiscount() {
    var options = "";
    for (var i = 0; i < 16; i++)
        options += `<option value="${i}">${i}</option>`;

    var html = `<div id="dayDiscount_${lastDayDiscoutnIndex}" data-index="${lastDayDiscoutnIndex}" class="col-md-12 pd-0 dayToDiscountRow" style="display: flex">
                    <div class="inputBox discountLimitationWholesale float-right">
                        <div class="inputBoxText">
                            <div>
                                درصد تخفیف<span>*</span>
                            </div>
                        </div>
                        <input id="dayDiscountInput_${lastDayDiscoutnIndex}" class="inputBoxInput no-border-imp" type="number" placeholder="درصد تخفیف">
                    </div>
                    <div class="textSec">
                        <span>این تخفیف از</span>
                        <select id="dayDiscountDay_${lastDayDiscoutnIndex}" class="inputBoxInput dayInput">${options}</select>
                        <span>روز مانده به برگزاری تور اعمال شود</span>
                    </div>
                    <div class="inline-block mg-rt-10">
                        <button type="button" class="wholesaleDiscountLimitationBtn deleteBtnTourCreation deleteDisCountButton iconFullClose" onclick="deleteDisCountDay(${lastDayDiscoutnIndex})">
                            
                        </button>
                    </div>
                </div>`;

    lastDayDiscoutnIndex++;

    $("#lastDayesDiscounts").append(html);
}

function deleteDisCountDay(_index) {
    $("#dayDiscount_" + _index).remove();
}

function doLastUpdate() {
    storeData = JSON.parse(lastData);
    fillInputs();
}

var lastData = localStorage.getItem(`stageFourTourCreation_${tour.id}`);
if (!(lastData == false || lastData == null))
    openWarningBP(
        "بازگرداندن اطلاعات قبلی",
        doLastUpdate,
        "بله قبلی را ادامه می دهم"
    );
setInterval(() => checkInput(false), 5000);
