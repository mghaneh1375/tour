@extends('pages.tour.create.createTourLayout')

@section('head')

    <style>
        .verifyBtnTourCreation{
            left: 100px;
            background-color: var(--koochita-light-green);
            bottom: 13px;
        }
    </style>
@endsection

@section('body')
    <div class="ui_container">
        <div class="whiteBox">
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
            <div class="tourTicketKindTourCreation col-xs-6">
                <div class="inputBoxTour col-xs-10" >
                    <div class="inputBoxText">
                        <div>
                            نوع بلیط
                            <span>*</span>
                        </div>
                    </div>
                    <div class="select-side">
                        <i class="glyphicon glyphicon-triangle-bottom"></i>
                    </div>
                    <select id="ticketKind" class="inputBoxInput styled-select">
                        <option value="fast">بلیط با امکان رزرو سریع</option>
                        <option value="call">بلیط نیازمند تماس با ارایه دهنده</option>
                    </select>
                </div>
                <div class="col-xs-10 pd-0">
                    <span class="inboxHelpSubtitleBlue">نیاز به راهنمایی دارید؟</span>
                </div>
            </div>
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
{{--            <div class="inboxHelpSubtitle">امکاناتی را که امکان انتخاب همزمان آن‌ها موجود نمی‌باشد، در هم‌گروهی‌های یکسان قرار دهید.</div>--}}
        </div>

        <div class="whiteBox">
            <div class="fullwidthDiv">
                <div class="boxTitlesTourCreation">تخفیف خرید گروهی</div>
                <div class="inboxHelpSubtitle">تخفیف‌های گروهی به خریداران ظرفیت‌های بالا اعمال می‌شود. شما می‌توانید با تعیین بازه‌های متفاوت تخفیف‌های متفاوتی اعمال نمایید.</div>
                <div id="groupDiscountDiv"></div>
            </div>

            <div class="fullwidthDiv specialDiscountBoxes seperatorInWhiteSec">
                <div class="boxTitlesTourCreation">تخفیف ویژه‌ی کودکان</div>
                <div class="inboxHelpSubtitle" style="width: 100%">تخفیف ویژه برای کودکان و نوجوانان (زیر 12 سال) از این قسمت تعریف می‌گردد.</div>
                <div class="inputBoxTour col-xs-3 float-right">
                    <div class="inputBoxText" style="width: 155px">
                        <div>
                            درصد تخفیف
                            <span>*</span>
                        </div>
                    </div>
                    <input id="babyDisCount" class="inputBoxInput" type="number" placeholder="درصد تخفیف">
                </div>
            </div>

            <div class="fullwidthDiv specialDiscountBoxes seperatorInWhiteSec" style="position: relative">
                <div class="boxTitlesTourCreation">تخفیف‌های مناسبتی و کد تخفیف</div>
                <div class="inboxHelpSubtitle" style="width: 100%">در صورت تعریف سیستم تخفیف زیر ، ما از زمان اعلامی شما به صورت خودکار تخفیف خرید در روزهای پایانی را اعمال می‌نماییم.</div>
                <div class="inputBoxTour col-xs-3 mg-rt-10 float-right">
                    <div class="inputBoxText" style="width: 140px">
                        <div>
                            درصد تخفیف
                            <span>*</span>
                        </div>
                    </div>
                    <input id="disCountReason" class="inputBoxInput" type="number" placeholder="درصد تخفیف">
                </div>
                <div class="inputBoxTour col-xs-3 mg-rt-10 float-right">
                    <div class="inputBoxText">
                        <div>
                            زمان پایان
                            <span>*</span>
                        </div>
                    </div>
                    <input id="eDiscountDate" type="text" class="inputBoxInput datePic" readonly>
                </div>
                <div class="inputBoxTour col-xs-3 mg-rt-10 float-right">
                    <div class="inputBoxText">
                        <div>
                            زمان شروع
                            <span>*</span>
                        </div>
                    </div>
                    <input id="sDiscountDate" type="text" class="inputBoxInput datePic" readonly>
                </div>
            </div>

        </div>

        <div class="row" style="padding: 15px;">
            <button class="btn nextStepBtnTourCreation" type="button" onclick="checkInput()">گام بعدی</button>
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
{{--            <div class="inputBoxTour float-right col-xs-2 mg-rt-10" >--}}
{{--                <div class="select-side">--}}
{{--                    <i class="glyphicon glyphicon-triangle-bottom"></i>--}}
{{--                </div>--}}
{{--                <select id="featureGroup_##index##"  class="inputBoxInput moreFacilityInputs styled-select">--}}
{{--                    <option value="0">هم‌گروهی</option>--}}
{{--                    <option value="a">a</option>--}}
{{--                    <option value="b">b</option>--}}
{{--                    <option value="c">c</option>--}}
{{--                    <option value="d">d</option>--}}
{{--                    <option value="e">e</option>--}}
{{--                    <option value="f">f</option>--}}
{{--                    <option value="g">g</option>--}}
{{--                    <option value="h">h</option>--}}
{{--                    <option value="i">i</option>--}}
{{--                    <option value="j">j</option>--}}
{{--                </select>--}}
{{--            </div>--}}
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
            cost: 0,
            ticketKind: '',
            isInsurance: 0,
            features: [],
            discounts: [],
            childDisCount: 0,
            disCountReason: 0,
            sDiscountDate: 0,
            eDiscountDate: 0,
        };

        $(window).ready(() => {
            createFeatureRow();
            createDisCountCard();

            $(".datePic").datepicker(datePickerOptions);
        });

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

        function checkInput(){
            var errorText = '';

            storeData = {
                cost: $('#tourCost').val().replace(new RegExp(',', 'g'), ''),
                ticketKind: $('#ticketKind').val(),
                isInsurance: $('input[name="isInsurance"]:checked').val(),
                features: [],
                discounts: [],
                childDisCount: $('#babyDisCount').val(),
                disCountReason: $('#disCountReason').val(),
                sDiscountDate: $('#sDiscountDate').val(),
                eDiscountDate: $('#eDiscountDate').val(),
            };

            if(storeData.cost.trim().length == 0)
                errorText = '<li>قیمت پایه تور خود را مشخص کنید</li>';


            if(errorText == '') {

                var warning = '';

                var features = $('.featuresRow');
                var featureWarning = false;
                for (var i = 0; i < features.length; i++) {
                    var index = $(features[i]).attr('data-index');

                    var name = $(`#featureName_${index}`).val();
                    var description = $(`#featureDesc_${index}`).val();
                    var cost = $(`#featureCost_${index}`).val();

                    if (name.trim().length > 0 && cost.trim().length > 0) {
                        storeData.features.push({
                            name: name,
                            description: description,
                            cost: cost.replace(new RegExp(',', 'g'), '')
                        });
                    }
                    else
                        featureWarning = true;
                }
                if(featureWarning)
                    warning += '<li>بعضی از امکانات شما یا اسم ندارند یا قیمت . در این صورت ثبت نمی شوند.</li>';

                var discounts = $('.discountrow');
                var discountWarning = false;
                for (var i = 0; i < discounts.length; i++) {
                    var index = $(discounts[i]).attr('data-index');

                    var disCountFrom = $(`#disCountFrom_${index}`).val();
                    var disCountTo = $(`#disCountTo_${index}`).val();
                    var discount = $(`#disCountCap_${index}`).val();

                    if (disCountFrom > 0 && disCountTo > 0 && discount > 0) {
                        storeData.discounts.push({
                            min: disCountFrom,
                            max: disCountTo,
                            discount: discount
                        });
                    }
                    else
                        discountWarning = true;
                }

                if(discountWarning)
                    warning += '<li>بعضی از تخفیف های گروهی بازه و درصد تخفیف ندارند . در این صورت ثبت نمی شوند.</li>';

                if(!(storeData.sDiscountDate.trim().length == 0 && storeData.eDiscountDate.trim().length == 0 && storeData.disCountReason > 0)) {
                    warning += '<li>اطالاعات تخفیف مناسبتی شما ناقص است و ذخیره نمی شود.</li>';
                    storeData.sDiscountDate = '';
                    storeData.eDiscountDate = '';
                    storeData.disCountReason = '';
                }


                if(warning == '')
                    doSaveInfos();
                else
                    openWarning(`<ul>${warning}</ul>`, doSaveInfos, 'مشکلی نیست');

            }
            else
                openErrorAlert(`<ul>${errorText}</ul>`);

            console.log(storeData);

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
                    if(response.status == 'ok')
                        location.href = '{{route("tour.create.stage.five")}}';
                }
            })
        }
    </script>
@endsection
