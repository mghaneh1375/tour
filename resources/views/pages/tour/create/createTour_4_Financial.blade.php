@extends('pages.tour.create.layout.createTour_Layout')

@section('head')

    <style>
        .verifyBtnTourCreation{
            left: 100px;
            background-color: var(--koochita-light-green);
            bottom: 13px;
        }

        .tourOtherPrice{
            border-bottom: solid 1px lightgray;
            padding: 20px 0px;
            margin-bottom: 0;
            position: relative;
        }
        .tourOtherPrice .deleteButton{
            position: absolute;
            left: 15px;
            background: var(--koochita-red);
            padding: 4px 15px;
            border-radius: 10px;
            top: 20%;
            cursor: pointer;
        }
        .newPriceButton{
            background: var(--koochita-blue);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 10px;
            margin-top: 20px;
            box-shadow: 1px 1px 4px 1px grey;
        }

        .forceHidden{
            display: none !important;
        }

        select option:disabled{
            background: lightgrey;
        }


        .dayToDiscountRow{
            display: flex;
            align-items: center;
        }
        .dayToDiscountRow .textSec{
            align-items: center;
            display: flex;
            margin: 0px 10px;
        }
        .dayToDiscountRow .dayInput{
            width: 100px;
            background: #ebebeb;
            padding: 3px 0px;
            margin: 0px 10px;
            border: 1px solid #cccccc;
            border-radius: 5px;
            text-align: center;
        }

    </style>
@endsection

@section('body')
    @include('pages.tour.create.layout.createTour_Header', ['createTourStep' => 5])

    <div class="ui_container">
        <div class="whiteBox">
            <div class="col-md-12">
                <div class="boxTitlesTourCreation">قیمت پایه</div>
                <div class="inboxHelpSubtitle">قیمت پایه‌ی تور قیمتی است که فارغ از هرگونه امکانات اضافه بدست آمده است و کمترین قیمتی است که کاربران می‌توانند تور را با آن خریداری نمایند. اگر برخی امکانات قیمت تور را تغییر می‌دهد، آن‌ها را در قسمت‌های بعدی وارد نمایید.</div>
                <div class="tourBasicPriceTourCreation col-xs-6">
                    <div class="inputBoxTour col-xs-10">
                        <div class="inputBoxText">
                            <div>
                                قیمت پایه
                                <span>*</span>
                            </div>
                        </div>
                        <input class="inputBoxInput" id="tourCost" type="text" placeholder="ریال" onkeyup="$(this).val(numberWithCommas(this.value))">
                    </div>
                    <div id="tourInsuranceConfirmation" class="col-xs-10 pd-0">
                        <span>آیا تور شما دارای بیمه می‌باشد؟</span>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary">
                                <input type="radio" name="isInsurance" value="0">خیر
                            </label>
                            <label class="btn btn-secondary active">
                                <input type="radio" name="isInsurance" value="1" checked>بلی
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12" style="margin-top: 20px;">
                <div class="inboxHelpSubtitle">اگر تور شما به ازای سن های مختلف قیمت متفاوتی دارد، در زیر می توانید قیمت ها را به ازای سن تعریف کنید.</div>
                <div id="pricesSection" class="fullyCenterContent" style="display: flex; flex-direction: column;"></div>

                <div class="fullyCenterContent">
                    <button class="newPriceButton" onclick="createNewPriceRow()">افزودن قیمت جدید</button>
                </div>
            </div>
{{--            <div class="tourTicketKindTourCreation col-xs-6">--}}
{{--                <div class="inputBoxTour col-xs-10" >--}}
{{--                    <div class="inputBoxText">--}}
{{--                        <div>--}}
{{--                            نوع بلیط--}}
{{--                            <span>*</span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="select-side">--}}
{{--                        <i class="glyphicon glyphicon-triangle-bottom"></i>--}}
{{--                    </div>--}}
{{--                    <select id="ticketKind" class="inputBoxInput styled-select">--}}
{{--                        <option value="fast">بلیط با امکان رزرو سریع</option>--}}
{{--                        <option value="call">بلیط نیازمند تماس با ارایه دهنده</option>--}}
{{--                    </select>--}}
{{--                </div>--}}
{{--                <div class="col-xs-10 pd-0">--}}
{{--                    <span class="inboxHelpSubtitleBlue">نیاز به راهنمایی دارید؟</span>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>

        <div class="whiteBox">
            <div class="boxTitlesTourCreation">امکانات اضافه</div>
            <div class="inboxHelpSubtitle">سایر امکاناتی که شما در تور با دریافت هزینه‌ی اضافه ارئه می‌دهید را وارد نمایید.</div>
            <div style="position: relative">
                <div id="featuresDiv"></div>
                <button type="button"  class="tourMoreFacilityDetailsBtn verifyBtnTourCreation" onclick="createFeatureRow()">
                    <img src="{{URL::asset("images/tourCreation/approve.png")}}">
                </button>
            </div>
        </div>

        <div class="whiteBox">
            <div class="fullwidthDiv">
                <div class="boxTitlesTourCreation">تخفیف خرید گروهی</div>
                <div class="inboxHelpSubtitle">تخفیف‌های گروهی به خریداران ظرفیت‌های بالا اعمال می‌شود. شما می‌توانید با تعیین بازه‌های متفاوت تخفیف‌های متفاوتی اعمال نمایید.</div>
                <div id="groupDiscountDiv"></div>
            </div>
        </div>

        <div class="whiteBox">
            <div class="fullwidthDiv">
                <div class="boxTitlesTourCreation">تخفیف های لحظه اخری</div>
                <div id="lastDayesDiscounts" style="display: flex; flex-direction: column;"></div>
                <div class="fullyCenterContent">
                    <button class="newPriceButton" onclick="addLastDayDiscount()">افزودن تخفیف لحظه آخری</button>
                </div>
            </div>
        </div>


        <div class="row" style="padding: 15px;">
            <button class="btn nextStepBtnTourCreation" type="button" onclick="checkInput()">گام بعدی</button>
            <button class="btn nextStepBtnTourCreation goToPrevStep" type="button" onclick="goToPrevStep()">بازگشت به مرحله قبل</button>
        </div>
    </div>

    <div id="featureRowSample" style="display: none">
        <div id="features_##index##" data-index="##index##" class="row featuresRow">
            <div class="inputBoxTour float-right col-xs-2" >
                <input id="featureName_##index##" class="inputBoxInput moreFacilityInputs" type="text" placeholder="نام">
            </div>
            <div class="inputBoxTour float-right col-xs-3 mg-rt-10" >
                <input id="featureDesc_##index##" class="inputBoxInput moreFacilityInputs" type="text" placeholder="توضیحات" maxlength="250">
            </div>
                <div class="inputBoxTour float-right col-xs-3 mg-rt-10 relative-position" >
                    <input id="featureCost_##index##" class="inputBoxInput moreFacilityInputs" type="text" placeholder="ریال" onkeyup="$(this).val(numberWithCommas(this.value))">
                    <div class="inboxHelpSubtitle" style="position: absolute; top: 100%;">میزان افزایش قیمت را وارد نمایید.</div>
                </div>

            <div class="col-xs-2" style="text-align: left; position: relative">
                <button type="button" class="tourMoreFacilityDetailsBtn deleteBtnTourCreation" style="position: relative; bottom: 0px; left: 0px; top: 0px" onclick="deleteFeatureRow(##index##)">
                    <img src="{{URL::asset("images/tourCreation/delete.png")}}">
                </button>
            </div>
        </div>
    </div>
    <div id="discountSample" style="display: none">
        <div id="groupDiscount_##index##" data-index="##index##" class="col-xs-12 pd-0 discountrow">
            <div class="inputBox discountLimitationWholesale float-right">
                <div class="inputBoxText">
                    <div>
                        بازه‌ی تخفیف<span>*</span>
                    </div>
                </div>
                <input id="disCountFrom_##index##" class="inputBoxInput startDisCountNumber" type="number" placeholder="از" onkeyup="checkDiscount(##index##, this.value, 0)" onchange="checkAllDiscount()">
                <div class="inputBoxText">
                    <div>الی</div>
                </div>
                <input id="disCountTo_##index##" class="inputBoxInput endDisCountNumber" type="number" placeholder="تا" onkeyup="checkDiscount(##index##, this.value, 1)" onchange="checkAllDiscount()">
                <div class="inputBoxText">
                    <div>
                        درصد تخفیف<span>*</span>
                    </div>
                </div>
                <input id="disCountCap_##index##" class="inputBoxInput no-border-imp" type="number" placeholder="درصد تخفیف">
            </div>
            <div class="inline-block mg-tp-12 mg-rt-10">
                <button type="button" class="wholesaleDiscountLimitationBtn verifyBtnTourCreation confirmDisCountButton" onclick="createDisCountCard()">
                    <img src="{{URL::asset("images/tourCreation/approve.png")}}">
                </button>
                <button type="button" class="wholesaleDiscountLimitationBtn deleteBtnTourCreation deleteDisCountButton hidden" onclick="deleteDisCountCard(##index##)">
                    <img src="{{URL::asset("images/tourCreation/delete.png")}}">
                </button>
            </div>
        </div>
    </div>

    <script>
        var tour = {!! $tour !!};
        var prevStageUrl = "{{route('tour.create.stage.three', ['id' => $tour->id])}}";
        var nextStageUrl = "{{route('tour.create.stage.five', ['id' => $tour->id])}}";
        var storeStageThreeURL = '{{route("tour.create.stage.four.store")}}';


        var priceIndex = 0;
        var lastDayDiscoutnIndex = 0;
        var featuresCount = 0;
        var disCountNumber = 0;
        var featureRowCard = $('#featureRowSample').html();
        var disCountCard = $('#discountSample').html();
        var datePickerOptions = {
            numberOfMonths: 1,
            showButtonPanel: true,
            dateFormat: "yy/mm/dd"
        };
        $('#featureRowSample').remove();
        $('#discountSample').remove();

        var disCountIndex = 1;
        var disCounts = [];
        var discountError = false;

        var storeData = {
            cost: tour.minCost,
            isInsurance: tour.isInsurance,
            features: tour.features,
            discounts: tour.groupDiscount == [] ? 0 : tour.groupDiscount,
            prices: tour.prices,
            lastDays: tour.lastDays
            // disCountReason:  tour.reasonDiscount == null ? 0 : tour.reasonDiscount.discount,
            // sDiscountDate: tour.reasonDiscount == null ? 0 : tour.reasonDiscount.sReasonDate,
            // eDiscountDate: tour.reasonDiscount == null ? 0 : tour.reasonDiscount.eReasonDate,
            // ticketKind: tour.ticketKind,
            // childDisCount: tour.childDiscount == null ? 0 : tour.childDiscount.discount,
        };

        $(window).ready(() => {
            $(".datePic").datepicker(datePickerOptions);
            createFeatureRow();
            createDisCountCard();

            fillInputs();
        });

        function goToPrevStep(){
            openLoading(false, () => {
                location.href = prevStageUrl;
            })
        }

        function fillInputs(){
            $('#tourCost').val(numberWithCommas(storeData.cost));
            // $('#disCountReason').val(storeData.disCountReason);
            // $('#sDiscountDate').val(storeData.sDiscountDate);
            // $('#eDiscountDate').val(storeData.eDiscountDate);
            // $('#ticketKind').val(storeData.ticketKind);
            // $('#childDisCount').val(storeData.childDisCount);

            $('input[name="isInsurance"]').parent().removeClass('active');
            $(`input[name="isInsurance"][value="${storeData.isInsurance}"]`).prop('checked', true).parent().addClass('active');

            storeData.features.map((features, index) => {
                if(index != 0)
                    createFeatureRow();

                setTimeout(() => {
                    $('#featureName_'+index).val(features.name);
                    $('#featureDesc_'+index).val(features.description);
                    $('#featureCost_'+index).val(numberWithCommas(features.cost));
                }, 100);
            });

            storeData.discounts.map((discount, index) => {
                if(index != 0)
                    createDisCountCard();

                setTimeout(() => {
                    disCounts[index].from = discount.min;
                    disCounts[index].to = discount.max;

                    $("#disCountFrom_"+index).val(discount.min);
                    $("#disCountTo_"+index).val(discount.max);
                    $("#disCountCap_"+index).val(parseInt(discount.discount));
                }, 50);
            });

            storeData.prices.forEach(() => createNewPriceRow());
            storeData.prices.map((item, index) => {
                $(`#priceInput_${index}`).val(item.cost);
                $(`#priceAgeFrom_${index}`).val(item.ageFrom);
                $(`#priceAgeTo_${index}`).val(item.ageTo);

                $(`input[name="isFreePrice_${index}"]`).parent().removeClass('active');
                $(`input[name="isFreePrice_${index}"][value="${item.isFree}"]`).prop('checked', true).parent().addClass('active');
                changeFreePrice(index, item.isFree);


                $(`input[name="inCapacity_${index}"]`).parent().removeClass('active');
                $(`input[name="inCapacity_${index}"][value="${item.inCapacity}"]`).prop('checked', true).parent().addClass('active');
            });

            storeData.lastDays.forEach(() => addLastDayDiscount());
            storeData.lastDays.map((item, index) => {
                $('#dayDiscountInput_'+index).val(item.discount);
                $('#dayDiscountDay_'+index).val(item.remainingDay);
            });

            setTimeout(() => {
                disableAllSelectAges();
                checkAllDiscount()
            }, 1000);
        }

        function createFeatureRow(){
            var text = featureRowCard;
            text = text.replace(new RegExp('##index##', 'g'), featuresCount);
            $('#featuresDiv').append(text);
            featuresCount++;
        }

        function deleteFeatureRow(_index){
            if($('.featuresRow').length > 1)
                $('#features_'+_index).remove();
        }

        function createDisCountCard(){
            $('.deleteDisCountButton').removeClass('hidden');
            $('.confirmDisCountButton').addClass('hidden');

            var text = disCountCard;
            text = text.replace(new RegExp('##index##', 'g'), disCountNumber);
            $('#groupDiscountDiv').append(text);
            disCountNumber++;

            disCounts.push({to: 0, from: 0});

            if(disCountNumber > 1)
                checkAllDiscount();
        }

        function deleteDisCountCard(_index){
            disCounts[_index] = {to: -1, from: -1};

            if($('.discountrow').length > 1)
                $('#groupDiscount_'+_index).remove();
        }

        function checkDiscount(_index, _value, _kind){
            var errorIndex = false;
            if(_kind == 1)
                disCounts[_index].to = parseInt(_value);
            else
                disCounts[_index].from = parseInt(_value);


            for(i = disCounts.length-1; i >= 0; i--){
                if(i != _index){
                    if(disCounts[i].to != 0 && disCounts[i].to != -1 && disCounts[i].from != 0 && disCounts[i].from != -1){
                        if((_value >= disCounts[i].from && _value <= disCounts[i].to)){
                            errorIndex = true;
                            break;
                        }
                    }
                }
            }

            var showId = (_kind == 1 ? 'disCountTo_' : 'disCountFrom_') + _index;
            if(errorIndex)
                $(`#${showId}`).addClass('errorClass');
            else
                $(`#${showId}`).removeClass('errorClass');
        }

        function checkAllDiscount(){
            discountError = false;
            for(var i = disCounts.length-1; i >= 0 ; i--){
                if (disCounts[i].to != -1 && disCounts[i].from != -1) {
                    if (disCounts[i].from == 0 || disCounts[i].to == 0) {
                        if (disCounts[i].to == 0)
                            document.getElementById('disCountTo_' + i).classList.add('errorClass');
                        if (disCounts[i].from == 0)
                            document.getElementById('disCountFrom_' + i).classList.add('errorClass');
                    }
                    else if (disCounts[i].from > disCounts[i].to) {
                        document.getElementById('disCountTo_' + i).classList.add('errorClass');
                        document.getElementById('disCountFrom_' + i).classList.add('errorClass');
                    }
                    else {
                        var checkErrorTo = false;
                        var checkErrorFrom = false;

                        for (var j = i - 1; j >= 0; j--) {
                            if (disCounts[j].to != 0 && disCounts[j].to != -1 && disCounts[j].from != 0 && disCounts[j].from != -1) {
                                if (!checkErrorFrom && disCounts[i].from >= disCounts[j].from && disCounts[i].from <= disCounts[j].to) {
                                    document.getElementById('disCountFrom_' + i).classList.add('errorClass');
                                    checkErrorFrom = true;
                                    discountError = true;
                                }
                                if (!checkErrorTo && disCounts[i].to >= disCounts[j].from && disCounts[i].to <= disCounts[j].to) {
                                    document.getElementById('disCountTo_' + i).classList.add('errorClass');
                                    checkErrorTo = true;
                                    discountError = true;
                                }
                            }
                        }

                        if(!checkErrorFrom)
                            document.getElementById('disCountFrom_' + i).classList.remove('errorClass');
                        if(!checkErrorTo)
                            document.getElementById('disCountTo_' + i).classList.remove('errorClass');
                        }
                }
            }
        }

        function checkInput(_mainStore = true){
            var errorText = '';

            storeData = {
                cost: $('#tourCost').val().replace(new RegExp(',', 'g'), ''),
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

            if(storeData.cost.trim().length == 0)
                errorText = '<li>قیمت پایه تور خود را مشخص کنید</li>';

            if (errorText == '' || _mainStore == false) {
                var warning = '';
                var index;

                var features = $('.featuresRow');
                var featureWarning = false;
                for (var i = 0; i < features.length; i++) {
                    index = $(features[i]).attr('data-index');

                    var name = $(`#featureName_${index}`).val();
                    var description = $(`#featureDesc_${index}`).val();
                    var cost = $(`#featureCost_${index}`).val();

                    if (name.trim().length > 0 && cost.trim().length > 0) {
                        storeData.features.push({
                            name: name,
                            description: description,
                            cost: cost.replace(new RegExp(',', 'g'), '')
                        });
                    } else
                        featureWarning = true;
                }
                if (featureWarning)
                    warning += '<li>بعضی از امکانات شما یا اسم ندارند یا قیمت . در این صورت ثبت نمی شوند.</li>';

                var discounts = $('.discountrow');
                var discountWarning = false;
                for (i = 0; i < discounts.length; i++) {
                    index = $(discounts[i]).attr('data-index');

                    var disCountFrom = $(`#disCountFrom_${index}`).val();
                    var disCountTo = $(`#disCountTo_${index}`).val();
                    var discount = $(`#disCountCap_${index}`).val();

                    if (disCountFrom > 0 && disCountTo > 0 && discount > 0) {
                        storeData.discounts.push({
                            min: disCountFrom,
                            max: disCountTo,
                            discount: discount
                        });
                    } else
                        discountWarning = true;
                }

                if (discountWarning)
                    warning += '<li>بعضی از تخفیف های گروهی بازه و درصد تخفیف ندارند . در این صورت ثبت نمی شوند.</li>';

                var lastDaysDiscounts = $('.dayToDiscountRow');
                for(i = 0; i < lastDaysDiscounts.length; i++){
                    var dIndex = $(lastDaysDiscounts[i]).attr('data-index');
                    var discount = $('#dayDiscountInput_'+dIndex).val();
                    var days = $('#dayDiscountDay_'+dIndex).val();

                    if(discount > 0 && days > 0){
                        storeData.lastDays.push({
                            discount: discount,
                            remainingDay: days
                        })
                    }
                }


                var priceSelects = $('.selectAges');
                for(i = 0; i < priceSelects.length; i++){
                    var pIndex = $(priceSelects[i]).attr('data-index');
                    var cost = $(`#priceInput_${pIndex}`).val().replace(new RegExp(',', 'g'), '');
                    var ageFrom = $(`#priceAgeFrom_${pIndex}`).val();
                    var ageTo = $(`#priceAgeTo_${pIndex}`).val();
                    var inCapacity = $(`input[name="inCapacity_${pIndex}"]:checked`).val();
                    var isFree = $(`input[name="isFreePrice_${pIndex}"]:checked`).val();

                    if((cost.trim().length != 0 || isFree == 1) && ageFrom >= 0 && ageTo >= 0){
                        storeData.prices.push({
                            cost,
                            ageFrom,
                            ageTo,
                            inCapacity,
                            isFree
                        });
                    }
                }


                if (warning == '' && _mainStore)
                    doSaveInfos();
                else if(_mainStore == false)
                    localStorage.setItem('stageFourTourCreation_{{$tour->id}}', JSON.stringify(storeData));
                else
                    openWarning(`<ul>${warning}</ul>`, doSaveInfos, 'مشکلی نیست');
            }
            else
                openErrorAlert(`<ul>${errorText}</ul>`);

        }

        function doSaveInfos(){
            openLoading();

            $.ajax({
                type: 'POST',
                url: '{{route('tour.create.stage.four.store')}}',
                data: {
                    _token: '{{csrf_token()}}',
                    tourId: '{{$tour->id}}',
                    data: JSON.stringify(storeData)
                },
                complete: closeLoading,
                success: response => {
                    if(response.status == 'ok'){
                        localStorage.removeItem('stageFourTourCreation_{{$tour->id}}');
                        location.href = '{{route("tour.create.stage.five", ['id' => $tour->id])}}';
                        // location.reload();
                    }
                }
            })
        }

        function changeFreePrice(_index, _value){
            if(_value == 1)
                $(`#price_${_index}`).addClass('forceHidden');
            else
                $(`#price_${_index}`).removeClass('forceHidden');
        }

        function createNewPriceRow(){
            var options = '';
            for(var i = 0; i < 18; i++)
                options += `<option value="${i}">${i}</option>`;

            var priceHtml = `<div class="tourBasicPriceTourCreation tourOtherPrice col-xs-12">
                                <div class="row" style="display: flex">
                                    <div id="price_${priceIndex}" class="inputBoxTour col-xs-4" style="margin-left: 10px">
                                        <div class="inputBoxText">
                                            <div>
                                                قیمت
                                            </div>
                                        </div>
                                        <input class="inputBoxInput" id="priceInput_${priceIndex}" type="text" placeholder="ریال" onkeyup="$(this).val(numberWithCommas(this.value))">
                                    </div>
                                    <div class="col-xs-8 float-right">
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
                                    </div>
                                </div>
                                <div class="col-xs-6 pd-0">
                                    <span>آیا این بازه سنی جز ظرفیت حساب می شود؟</span>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-secondary">
                                            <input type="radio" name="inCapacity_${priceIndex}" value="0">خیر
                                    </label>
                                    <label class="btn btn-secondary active">
                                        <input type="radio" name="inCapacity_${priceIndex}" value="1" checked>بلی
                                    </label>
                                </div>
                            </div>

                            <div class="col-xs-6 pd-0">
                                <span>آیا این بازه سنی رایگان است؟</span>
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-secondary active">
                                        <input type="radio" name="isFreePrice_${priceIndex}" value="0" checked onchange="changeFreePrice(${priceIndex}, this.value)">خیر
                                    </label>
                                    <label class="btn btn-secondary">
                                        <input type="radio" name="isFreePrice_${priceIndex}" value="1" onchange="changeFreePrice(${priceIndex}, this.value)">بلی
                                </label>
                            </div>
                        </div>

                        <div class="deleteButton" onclick="deleteThisPrice(this)"><img src={{URL::asset('images/tourCreation/delete.png')}}></div>
                    </div>`;
            $('#pricesSection').append(priceHtml);
            priceIndex++;

            disableAllSelectAges();
        }

        function deleteThisPrice(_element){
            $(_element).parent().remove();
            disableAllSelectAges();
        }

        function disableThisSelectAges(_index){
            var value = $(`#priceAgeFrom_${_index}`).val();
            for(var i = 0; i <= 17; i++)
                document.getElementById('priceAgeTo_' + _index).options[i].disabled = (i <= value);

            value = $(`#priceAgeTo_${_index}`).val();
            if(value > 0) {
                for (i = 0; i <= 17; i++)
                    document.getElementById('priceAgeFrom_' + _index).options[i].disabled = (i >= value);
            }
        }

        function disableAllSelectAges(){
            var index;
            var index2;
            var period = [0, 0];
            var selects = $('.selectAges');

            for(var i = 0; i < selects.length; i++){
                index = $(selects[i]).attr('data-index');
                disableThisSelectAges(index);
            }

            for(i = 0; i < selects.length; i++){
                index = $(selects[i]).attr('data-index');

                period[0] = parseInt($('#priceAgeFrom_'+index).val());
                period[1] = parseInt($('#priceAgeTo_'+index).val());

                if(period[0] != null && period[1] != null) {
                    for (var j = 0; j < selects.length; j++) {
                        if (j != i) {
                            index2 = $(selects[j]).attr('data-index');
                            for (var k = 0; k <= 17; k++) {
                                if (k >= period[0] && k <= period[1]){
                                    document.getElementById('priceAgeTo_' + index2).options[k].disabled = true;
                                    document.getElementById('priceAgeFrom_' + index2).options[k].disabled = true;
                                }
                            }
                        }
                    }
                }
            }
        }

        function addLastDayDiscount(){
            var options = '';
            for(var i = 0; i < 16; i++)
                options += `<option value="${i}">${i}</option>`;

            var html = `<div id="dayDiscount_${lastDayDiscoutnIndex}" data-index="${lastDayDiscoutnIndex}" class="col-xs-12 pd-0 dayToDiscountRow">
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
                                    <button type="button" class="wholesaleDiscountLimitationBtn deleteBtnTourCreation deleteDisCountButton" onclick="deleteDisCountDay(${lastDayDiscoutnIndex})">
                                        <img src="{{URL::asset('images/tourCreation/delete.png')}}">
                                    </button>
                                </div>
                            </div>`;

            lastDayDiscoutnIndex++;

            $('#lastDayesDiscounts').append(html);
        }

        function deleteDisCountDay(_index){
            $('#dayDiscount_'+_index).remove();
        }

        function doLastUpdate(){
            storeData = JSON.parse(lastData);
            fillInputs();
        }

        var lastData = localStorage.getItem('stageFourTourCreation_{{$tour->id}}');
        if(!(lastData == false || lastData == null))
            openWarning('بازگرداندن اطلاعات قبلی', doLastUpdate, 'بله قبلی را ادامه می دهم');
        setInterval(() => checkInput(false), 5000);
    </script>

    <script src="{{URL::asset('js/pages/tour/create/tourCreateStageFour.js?v='.$fileVersions)}}"></script>
@endsection
