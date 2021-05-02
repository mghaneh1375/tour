@extends('panelBusiness.layout.baseLayout')

@section('head')
    <title>مرحله اول</title>

    <link rel="stylesheet" href="{{URL::asset('css/theme2/bootstrap-datepicker.css')}}">
    <script async src="{{URL::asset("js/bootstrap-datepicker.js")}}"></script>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/shazdeDesigns/tourCreation.css?v='.$fileVersions)}}"/>

    <style>
        .submitBTNCircleIcon{
            border: none;
            background: green;
            /* width: 30px; */
            /* height: 30px; */
            border-radius: 5px;
            color: white;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            font-size: 15px;
        }
        .personInfosLabel{
            display: inline-flex;
            align-items: center;
            margin: 7px 20px;
            font-size: 14px;
        }
        .transportInfoSec{
            display: flex !important;
            align-items: center;
            flex-wrap: wrap;
            direction: rtl;
            float: unset;
        }
        .transportInfoSec > div{
            width: 100%;
            display: flex;
            align-items: center;
        }

        .dayActionButton{
            margin: 0px 10px;
            padding: 4px 10px;
            background: var(--koochita-blue);
            color: white;
            border-radius: 7px;
            cursor: pointer;
            box-shadow: 1px 1px 4px 2px #bbbbbb;
        }

        .icon-circle-arrow-right{
            width: 10px;
            height: 10px;
            display: flex;
            border-right: solid 2px black;
            border-top: solid 2px black;
            transform: rotate(45deg);
        }
        .icon-circle-arrow-left{
            width: 10px;
            height: 10px;
            display: flex;
            border-left: solid 2px black;
            border-bottom: solid 2px black;
            transform: rotate(45deg);
        }
        .calendarIcon{
            font-style: normal;
        }
        .addNewDateRow{
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            margin-top: 20px;
            padding-top: 20px;
        }

        .calendarRow{
            display: flex;
            width: 100%;
            align-items: center;
        }
        .youCantSelect{
            opacity: 1 !important;
        }
        .youCantSelect > span{
            background: var(--koochita-blue) !important;
            color: white !important;
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
        .onlyInputBackGray{
            width: 45px;
            background: #ebebeb;
            border: 1px solid #cccccc !important;
            margin: 0px 10px;
            border-radius: 5px;
        }
        .textareaInForDescription{
            width: 100%;
            text-align: right;
        }


        .dateModal .topBorder{
            border-top: solid 1px gray;
            padding-top: 10px;
            margin-top: 10px;
        }
        .dateModal .secTitle{
            font-size: 18px;
            font-weight: bold;
        }

        .otherDateSection{
            margin-top: 14px;
        }
        .tableButton{
            font-size: 11px;
            padding: 4px 10px;
        }
    </style>

    <script src="{{URL::asset('js/jalali.js')}}"></script>
@endsection


@section('body')

    <div class="mainBackWhiteBody">
        <div class="head">
            {{$tour == null ? 'ایجاد' : 'ویرایش'}}
            تور: قدم اول
        </div>
        <div>
            <input type="hidden" id="tourId" name="id" value="{{$tour->id ?? 0}}">
            <input type="hidden" id="businessId" value="{{$businessIdForUrl}}">

            <div class="whiteBox">

                <div class="inboxHelpSubtitle big">
                    برای تور خود یک نام مشخص کنید.
                </div>
                <div class="inputBoxGeneralInfo inputBoxTour" style="width: 50%;">
                    <div class="inputBoxTextGeneralInfo inputBoxText">
                        <div class="importantFieldLabel">نام تور</div>
                    </div>
                    <input id="tourName" class="inputBoxInput" type="text" name="name" placeholder="نام تور خود را اینجا وارد کنید..." required>
                </div>


                <div class="inboxHelpSubtitle big" style="margin-top: 25px;">
                    شهری که در آن قرار است تور برگزار شود را مشخص کنید.
                </div>
                <div class="inboxHelpSubtitle" style="width: 100%;">
                    با وارد کردن نام شهر گزینه‌های موجود نمایش داده می‌شود تا از بین آن‌ها انتخاب نمایید. اگر نام شهر خود را نیافتید از گزینه‌ی اضافه کردن استفاده نمایید
                </div>
                <div class="inputBoxGeneralInfo inputBoxTour InlineTourInputBoxes" style="width: 50%; position: relative;">
                    <div class="inputBoxTextGeneralInfo inputBoxText">
                        <div class="importantFieldLabel">شهر برگزاری تور</div>
                    </div>
                    <input class="inputBoxInput" id="srcCity" type="text" placeholder="نام شهر را اینجا وارد کنید..." onkeyup="searchInCity(this.value)" onchange="changeCityName(this)">
                    <input id="srcCityId" type="hidden" name="src">

                    <div id="citySearchResultSec" class="searchResultBoxSection hidden">
                        <div id="citySearchLoader" class="loader fullyCenterContent">
                            <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
                        </div>
                        <div id="citySearchResult" class="hidden" style="max-height: 200px; overflow: auto;"></div>
                    </div>

                </div>

                <div class="nonGovernmentalTitleTourCreation" style="margin-top: 25px;">
                    <span>آیا تور شما به صورت خصوصی هم برگزار می‌شود؟</span>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-secondary">
                            <input type="radio" name="private" value="1" autocomplete="off">بله
                        </label>
                        <label class="btn btn-secondary active">
                            <input type="radio" name="private" value="0" autocomplete="off" checked>خیر
                        </label>
                    </div>
                    <div class="inboxHelpSubtitle" style="margin-bottom: 20px; width: 100%">تورهای خصوصی برای گروه محدودی از مخاطبان برگزار می‌شوند و مخاطبان می‌توانند تجربه‌ای خصوصی داشته باشند.</div>
                </div>
            </div>

            <div class="whiteBox">
                <div class="boxTitlesTourCreation">تاریخ برگزاری تور</div>
                <div class="inboxHelpSubtitle">در این بخش تاریخ های برگزاری این تور را تعریف کنید.</div>
                <div class="row">
                    <div class="col-md-6 inputBoxTour" style="margin-left: 10px;">
                        <div class="inputBoxText">
                            <div class="importantFieldLabel">تاریخ تور</div>
                        </div>
                        <div class="select-side calendarIconTourCreation">
                            <i class="ui_icon calendar calendarIcon" ></i>
                        </div>
                        <input id="mainDate" class="observer-example inputBoxInput" type="text" placeholder="انتخاب کنید..." onchange="changeModalDate(this.value, 'main')">
                    </div>
                </div>
            </div>

            <div class="whiteBox ">
                <div class="boxTitlesTourCreation">
                    <span>ظرفیت تور برای تاریخ </span>
                    <span class="mainDateShow">....</span>
                </div>
                <div style="display: flex; flex-direction: column;">
                    <div id="tourCapacitySection2">
                        <div class="col-xs-4 float-right" style="margin-left: 50px;">
                            <div class="inputBoxTour">
                                <div class="inputBoxText" style="width: 140px">
                                    <div class="importantFieldLabel" style="white-space: nowrap;">حداقل ظرفیت تور</div>
                                </div>
                                <input id="minCapacity" class="inputBoxInput" type="number" placeholder="تعداد">
                            </div>
                        </div>
                        <div class="col-xs-4 float-right">
                            <div class="inputBoxTour">
                                <div class="inputBoxText" style="width: 140px">
                                    <div class="importantFieldLabel" style="white-space: nowrap;">حداکثر ظرفیت تور</div>
                                </div>
                                <input id="maxCapacity" class="inputBoxInput" type="number" placeholder="تعداد">
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="whiteBox">
                <div class="boxTitlesTourCreation">
                    <span>قیمت تور برای تاریخ </span>
                    <span class="mainDateShow">....</span>
                </div>
                <div class="inboxHelpSubtitle">قیمت پایه تور خود را به تومان وارد کنید. توجه کنید شما می توانید در بخش تاریخ برگزاری تور به ازای هر تاریخ مقدار افزایش قیمت تور را مشخص کنید.</div>
                <div class="row" style="align-items: center;">
                    <div class="col-md-6">
                        <div class="inputBoxGeneralInfo inputBoxTour" style="width: 100%;">
                            <div class="inputBoxTextGeneralInfo inputBoxText">
                                <div class="importantFieldLabel" style="white-space: nowrap;">قیمت پایه تور(تومان)</div>
                            </div>
                            <input id="tourCost" class="inputBoxInput" type="text" name="cost" placeholder="قیمت پایه تور خود را اینجا وارد کنید..." onkeyup="$(this).val(numberWithCommas(this.value))">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="pd-0" style="margin-right: 25px;">
                            <span>آیا تور شما دارای بیمه می‌باشد؟</span>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-secondary">
                                    <input type="radio" name="isInsurance" value="1">
                                    بله
                                </label>
                                <label class="btn btn-secondary active">
                                    <input type="radio" name="isInsurance" value="0" checked>
                                    خیر
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="whiteBox">
                <div class="fullwidthDiv">
                    <div class="boxTitlesTourCreation">
                        <span>تخفیف خرید گروهی تور برای تاریخ </span>
                        <span class="mainDateShow">....</span>
                    </div>
                    <div class="inboxHelpSubtitle">تخفیف‌های گروهی به خریداران ظرفیت‌های بالا اعمال می‌شود. شما می‌توانید با تعیین بازه‌های متفاوت تخفیف‌های متفاوتی اعمال نمایید.</div>
                    <div id="mainGroupDiscount"></div>

                    <div class="addNewDateRow">
                        <button class="btn btn-primary" onclick="createGroupDisCountCard('main')">افزدون تخفیف گروهی جدید</button>
                    </div>
                </div>
            </div>


            <div class="whiteBox">
                <div class="nonGovernmentalTitleTourCreation" style="margin-top: 25px;">
                    <span>آیا این تور شما در تاریخ های دیگری نیز برگزار می شود؟</span>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-secondary">
                            <input type="radio" name="otherDays" value="1" autocomplete="off" onchange="hasOtherDate(this.value)">
                            بله
                        </label>
                        <label class="btn btn-secondary active">
                            <input type="radio" name="otherDays" value="0" autocomplete="off" checked onchange="hasOtherDate(this.value)">
                            خیر
                        </label>
                    </div>
                </div>
                <div id="otherDateSection" class="otherDateSection hidden">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>تاریخ</th>
                                <th>قیمت</th>
                                <th>ظرفیت</th>
                                <th>تعداد تخفیف گروهی</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="otherDateTableBody"></tbody>
                    </table>
                    <div class="addNewDateRow">
                        <button class="btn btn-primary" onclick="openDateModal()">افزدون تاریخ جدید</button>
                    </div>
                </div>
            </div>


            <div class="whiteBox  hidden">
                <div class="fullwidthDiv">
                    <div class="boxTitlesTourCreation">تخفیف های لحظه اخری</div>
                    <div id="lastDayesDiscounts" style="display: flex; flex-direction: column;"></div>
                    <div class="addNewDateRow">
                        <button class="btn btn-primary" onclick="addLastDayDiscount()">افزودن تخفیف لحظه آخری</button>
                    </div>
                </div>
            </div>

            <div class="whiteBox">
                <div class="boxTitlesTourCreation">شرایط کنسلی</div>
                <div class="inboxHelpSubtitle">شرایط کنسلی تور خود را به اطلاع مسافران خود برسانید.</div>
                <div class="tourGuiderQuestions mg-tp-15">
                    <span>آیا تور شما دارای کنسلی می‌باشد؟</span>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-secondary active">
                            <input type="radio" name="isCancelAbel" value="1" onchange="changeCancelAble(this.value)" checked>بلی
                        </label>
                        <label class="btn btn-secondary">
                            <input type="radio" name="isCancelAbel" value="0" onchange="changeCancelAble(this.value)">خیر
                        </label>
                    </div>
                </div>
                <div id="cancelDiv">
                    <div class="inboxHelpSubtitle" style="width: 100%">در این صورت شرایط آن را توضیح دهید.</div>
                    <div class="inputBox cancellingSituationTourCreation height-250">
                        <textarea id="cancelDescription" class="inputBoxInput fullwidthDiv text-align-right full-height textareaInForDescription" placeholder="متن خود را وارد کنید"></textarea>
                    </div>
                </div>
            </div>

            <div class="row" style="padding: 15px;">
                <button class="btn nextStepBtnTourCreation" type="button" onclick="checkInput()">گام بعدی</button>
            </div>
        </div>
    </div>

@endsection

@section('modals')
    <div id="timeRowSample" class="hidden">
        <div id="calendar_##number##" class="calendarRow">
            <div class="inputBoxTour col-md-3 relative-position float-right" style="margin-left: 10px;">
                <div class="inputBoxText">
                    <div>تاریخ تور</div>
                </div>
                <div class="select-side calendarIconTourCreation">
                    <i class="ui_icon calendar calendarIcon" ></i>
                </div>
                <input name="sDateNotSame[]" id="sDate_##number##" class="observer-example inputBoxInput" type="text" placeholder="انتخاب کنید...">
            </div>
            <div class="inputBoxTour col-md-3 relative-position float-right" style="margin-left: 10px;">
                <div class="inputBoxText">
                    <div>مقدار افزایش قیمت(تومان)</div>
                </div>
                <input name="sDateNotSameCost[]" id="sDateCost_##number##" class="inputBoxInput" type="text" onkeyup="this.value = numberWithCommas(this.value)" placeholder="مقدار افزایش قیمت به تومان را وارد کنید...">
            </div>
            <div class="inline-block mg-rt-10">
                <button type="button" id="deleteCalendar_##number##" class="wholesaleDiscountLimitationBtn deleteBtnTourCreation" onclick="deleteCalendar(##number##)">حذف تاریخ</button>
            </div>
        </div>
    </div>

    <div id="dateModal" class="modalBlackBack fullCenter notCloseOnClick dateModal" style="z-index: 9999;">
        <div class="modalBody" style="max-width: 850px; width: 95%; overflow: auto; max-height: 95%;">
            <div onclick="closeMyModalBP('dateModal')" class="iconClose closeModal"></div>
            <input type="hidden" id="tourDateCode">
            <div class="options" style="padding-bottom: 10px;">
                <div class="title"> ایجاد/ویرایش تاریخ برگزاری تور</div>
            </div>

            <div class="row">
                <div class="col-md-6 inputBoxTour" style="margin-left: 10px;">
                    <div class="inputBoxText">
                        <div class="importantFieldLabel">تاریخ تور</div>
                    </div>
                    <div class="select-side calendarIconTourCreation">
                        <i class="ui_icon calendar calendarIcon" ></i>
                    </div>
                    <input id="dateInModal" class="observer-example inputBoxInput" type="text" placeholder="انتخاب کنید..." onchange="changeModalDate(this.value, 'modal')">
                </div>
            </div>

            <div class="row topBorder">
                <div class="col-md-12 secTitle">
                    <span>ظرفیت تور برای تاریخ </span>
                    <span class="dateClassInModal">...</span>
                </div>
                <div class="col-md-12">
                    <div id="tourCapacitySection" class="row">
                        <div class="col-xs-4" style="margin-left: 50px;">
                            <div class="inputBoxTour">
                                <div class="inputBoxText">
                                    <div class="importantFieldLabel">حداقل ظرفیت</div>
                                </div>
                                <input class="inputBoxInput" type="number" id="minCapacityInModal" placeholder="تعداد">
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="inputBoxTour">
                                <div class="inputBoxText">
                                    <div class="importantFieldLabel">حداکثر ظرفیت</div>
                                </div>
                                <input class="inputBoxInput" type="number" id="maxCapacityInModal" placeholder="تعداد">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row topBorder">
                <div class="col-md-12 secTitle">
                    <span>قیمت تور برای تاریخ </span>
                    <span class="dateClassInModal">...</span>
                </div>
                <div class="col-md-12">
                    <div class="inboxHelpSubtitle">در این قسمت قیمت تور در این تاریخ خاص را وارد کنید.</div>
                </div>
                <div class="col-md-8">
                    <div class="inputBoxTour">
                        <div class="inputBoxText">
                            <div class="importantFieldLabel">قیمت به تومان</div>
                        </div>
                        <input id="costInModal" class="inputBoxInput" type="text" placeholder="0" onkeyup="$(this).val(numberWithCommas(this.value))">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="nonGovernmentalTitleTourCreation">
                        <span style="font-weight: normal;">آیا تور شما در این تاریخ بیمه دارد؟</span>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary">
                                <input type="radio" name="isInsuranceInModal" value="1" autocomplete="off">
                                بله
                            </label>
                            <label class="btn btn-secondary active">
                                <input type="radio" name="isInsuranceInModal" value="0" autocomplete="off" checked>
                                خیر
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row topBorder">
                <div class="col-md-12 secTitle">
                    <span>تخفیف خرید گروهی تور برای تاریخ </span>
                    <span class="dateClassInModal">...</span>
                </div>
                <div id="groupDiscountDiv" class="col-md-12"></div>
                <div class="col-md-12 fullyCenterContent">
                    <button class="btn btn-primary" onclick="createGroupDisCountCard('modal')">افزدون تخفیف گروهی جدید</button>
                </div>
            </div>

            <div class="submitOptions direction-rtl mg-tp-20" style="display: flex;">
                <button class="btn btn-default" onclick="closeMyModalBP('dateModal')" style="margin-right: 10px; margin-right: auto;">بستن</button>
                <button class="btn successBtn" onclick="submitDateModal()" style="color: white; background: green;">ثبت تاریخ</button>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        var tour = {!! json_encode($tour) !!};
        var tourType = '{{$type}}';
        var stageOneStoreUrl = "{{route('businessManagement.tour.store.stage_1')}}";
        var stageTwoUrl = "{{url('businessManagement/'.$businessIdForUrl.'/tour/create/stage_2')}}";
        var findCityWithStateUrl = '{{route("BP.ajax.searchCity")}}';
        var findPlaceWithKindPlaceIdUrl = '{{route("search.place.with.name.kindPlaceId")}}';
        var nowCitySearchResult = [];
        var otherDates = [];

        function hasOtherDate(_value){
            if(otherDates.length === 0 && _value == 1)
                openDateModal();
        }

        function openDateModal(_date = null){
            if(_date == null){
                _date = {
                    code: 0,
                    date: '',
                    anyCapacity: 0,
                    minCapacity: '',
                    maxCapacity: '',
                    cost: '',
                    isInsurance: 1,
                    sDateRegister: {
                        date: '',
                        time: ''
                    },
                    eDateRegister: {
                        date: '',
                        time: ''
                    },
                    groupDiscount: [],
                }
            }

            document.getElementById('tourDateCode').value = _date.code;

            createGroupDisCountCard('modal');
            openMyModalBP('dateModal');
        }

        function changeModalDate(_value, _type){
            let className = _type === 'main' ? '.mainDateShow' : '.dateClassInModal';
            [...document.querySelectorAll(className)].map(item => item.innerText = _value);
        }

        function submitDateModal(){
            let errorText = '';

            let code = document.getElementById('tourDateCode').value;
            if(code == 0)
                code = Math.floor(Math.random() * 100000);

            let index = null;
            for(let i = 0; i < otherDates.length; i++) {
                if(code == otherDates.code){
                    index = i;
                    break;
                }
            }

            let groupDiscount = [];
            let date = document.getElementById('dateInModal').value;
            let cost = parseFloat(document.getElementById('costInModal').value.replace(new RegExp(',', 'g'), ''));
            let isInsurance = document.querySelector('input[name="isInsuranceInModal"]:checked').value;
            let minCapacity = parseInt(document.getElementById('minCapacityInModal').value);
            let maxCapacity = parseInt(document.getElementById('maxCapacityInModal').value);

            let groupDiscountRow = 0;
            [...document.querySelectorAll('#groupDiscountDiv .discountRow')].map(item => {
                groupDiscountRow++;
                let hasError = false;
                let index = item.getAttribute('data-index');

                let disId = document.getElementById(`disCountGroupId_${index}`).value;
                let min = parseInt(document.getElementById(`disCountFrom_${index}`).value);
                let max = parseInt(document.getElementById(`disCountTo_${index}`).value);
                let discount = parseFloat(document.getElementById(`disCountCap_${index}`).value);

                if(!(min > 0)){
                    hasError = true;
                    document.getElementById(`disCountFrom_${index}`).classList.add('errorClass');
                }
                if(!(max > 0)){
                    hasError = true;
                    document.getElementById(`disCountTo_${index}`).classList.add('errorClass');
                }
                if(!(discount > 0)){
                    hasError = true;
                    document.getElementById(`disCountCap_${index}`).classList.add('errorClass');
                }

                if(!hasError)
                    groupDiscount.push({ id: disId, min, max, discount});
            });

            if(date.trim().length === 0)
                errorText += `<li>تاریخ را مشخص کنید</li>`;
            for(let i = 0; i < otherDates.length; i++){
                if(otherDates[i].code != code){
                    if(otherDates[i].date === date){
                        errorText += `<li>تاریخ تکراری می باشد.</li>`;
                        break;
                    }
                }
            }
            if(!(cost > 0))
                errorText += `<li>قیمت تور را  مشخص کنید.</li>`;
            if(!(minCapacity > 0))
                errorText += `<li>حداقل ظرفیت را مشخص کنید</li>`;
            if(!(maxCapacity > 0))
                errorText += `<li>حداکثر ظرفیت را مشخص کنید</li>`;
            if(groupDiscountRow != groupDiscount.length)
                errorText += `<li>بعضی از فیلد های تخفیف خالی است. آنها را پر کنید.</li>`;
            if(minCapacity > maxCapacity)
                errorText += `<li>حداکثر ظرفیت نمی تواند از حداقل کمتر باشد</li>`;


            if(errorText.trim().length > 0){
                errorText = `<ul class="errorList">${errorText}</ul>`;
                openErrorAlertBP(errorText);
            }
            else {
                let data = {id: 0, code, date, cost, isInsurance, minCapacity, maxCapacity, groupDiscount};

                if (index == null)
                    otherDates.push(data);
                else
                    otherDates[index] = data;

                let html = '';
                otherDates.forEach(item => {
                    html += `<tr id="dateRow_${item.code}">
                            <td>${item.date}</td>
                            <td>${numberWithCommas(item.cost)} تومان</td>
                            <td>${item.minCapacity}-${item.maxCapacity} نفر</td>
                            <td>${item.groupDiscount.length} تا تخفیف گروهی</td>
                            <td>
<!--                                <button class="btn btn-primary tableButton" onclick="editThisDate(${item.id})">ویرایش</button>-->
                                <button class="btn btn-danger tableButton" onclick="deleteThisDate(${item.code})">حذف</button>
                            </td>
                        </tr>`;
                });
                document.getElementById('otherDateTableBody').innerHTML = html;
                document.getElementById('otherDateSection').classList.remove('hidden');

                closeMyModalBP('dateModal');
                cleanDateModalDate();
            }
        }

        function cleanDateModalDate(){
            document.getElementById('dateInModal').value = '';
            document.getElementById('minCapacityInModal').value = '';
            document.getElementById('maxCapacityInModal').value = '';
            document.getElementById('costInModal').value = '';
            document.getElementById('groupDiscountDiv').innerHTML = '';
        }

        function editThisDate(_code){

        }

        function deleteThisDate(_code){
            let index = null;
            for(let i = 0; i < otherDates.length; i++){
                if(otherDates[i].code == _code){
                    index = i;
                    break;
                }
            }

            if(index != null){
                document.getElementById(`dateRow_${otherDates[index].code}`).remove();
                otherDates.splice(index, 1);
            }
        }

        function checkInput() {
            let allDates = [];
            dataToSend = {
                tourType,
                tourId: document.getElementById('tourId').value,
                businessId: document.getElementById('businessId').value,
                tourName: document.getElementById('tourName').value,
                srcCityId: document.getElementById('srcCityId').value,
                anyCapacity: 0,
                private: document.querySelector('input[name="private"]:checked').value,
                userInfoNeed: ['faName', 'sex', 'birthDay', 'meliCode'],
                cancelAble: document.querySelector('input[name="isCancelAbel"]:checked').value,
                cancelDescription: document.getElementById('cancelDescription').value,

                dates: []
            };

            let errorText = '';
            if (dataToSend.tourName.trim().length < 2)
                errorText += '<li>نام تور خود را مشخص کنید.</li>';

            if (!(dataToSend.srcCityId >= 1))
                errorText += '<li>شهر برگزاری تور خود را مشخص کنید.</li>';

            if(dataToSend.cancelAble == 1 && dataToSend.cancelDescription.trim().length === 0)
                errorText += '<li>در صورت داشتن شرایط کنسلی، شرایط آن را بنویسید.</li>';

            let mainDate = document.getElementById('mainDate').value;
            let mainCost = parseFloat(document.getElementById('tourCost').value.replace(new RegExp(',', 'g'), ''));
            let mainMinCapacity = parseInt(document.getElementById('minCapacity').value);
            let mainMaxCapacity = parseInt(document.getElementById('maxCapacity').value);
            let mainIsInsurance = document.querySelector('input[name="isInsurance"]:checked').value;

            let mainGroupDiscount = [];
            let mainGroupDiscountRow = 0;
            [...document.querySelectorAll('#mainGroupDiscount .discountRow')].map(item => {
                mainGroupDiscountRow++;
                let index = item.getAttribute('data-index');

                let min = parseInt(document.getElementById(`disCountFrom_${index}`).value);
                let max = parseInt(document.getElementById(`disCountTo_${index}`).value);
                let discount = parseFloat(document.getElementById(`disCountCap_${index}`).value);
                let hasError = false;

                if(!(min > 0)){
                    hasError = true;
                    document.getElementById(`disCountFrom_${index}`).classList.add('errorClass');
                }

                if(!(max > 0)){
                    hasError = true;
                    document.getElementById(`disCountTo_${index}`).classList.add('errorClass');
                }

                if(!(discount > 0)){
                    hasError = true;
                    document.getElementById(`disCountCap_${index}`).classList.add('errorClass');
                }

                if(!hasError)
                    mainGroupDiscount.push({id: 0, min, max, discount});
            });

            if (mainDate.trim().length === 0)
                errorText += `<li>تاریخ اصلی تور را مشخص کنید.</li>`;
            if (!(mainCost > 0))
                errorText += `<li>قیمت تور در تاریخ ${mainDate} را مشخص کنید.</li>`;
            if (!(mainMinCapacity >= 0))
                errorText += `<li>حداقل ظرفیت تور در تاریخ ${mainDate} را مشخص کنید.</li>`;
            if (!(mainMaxCapacity >= 0))
                errorText += `<li>حداکثر ظرفیت تور در تاریخ ${mainDate} را مشخص کنید.</li>`;
            if (mainMaxCapacity < mainMinCapacity)
                errorText += `<li>حداکثر ظرفیت تور نمی تواند کوچکتر از حداقل باشد</li>`;
            if(mainGroupDiscount.length != mainGroupDiscountRow)
                errorText += `<li>بعضی از فیلدهای تخفیف گروهی برای تاریخ ${mainDate} خالی است. آنها را پر کنید و یا حذف کنید.</li>`;

            allDates.push({
                id: 0,
                date: mainDate,
                cost: mainCost,
                inInsurance: mainIsInsurance,
                minCapacity: mainMinCapacity,
                maxCapacity: mainMaxCapacity,
                groupDiscount: mainGroupDiscount
            });

            otherDates.forEach(item => allDates.push(item));

            dataToSend.dates = allDates;

            let errorInEmpty = false;
            if (errorInEmpty)
                errorText += '<li>بعضی از فیلدهای تخفیف خالی است. انها را کامل کنید.</li>';

            if (errorText != '') {
                errorText = `<ul class="errorList">${errorText}</ul>`;
                openErrorAlertBP(errorText);
            }
            else
                submitInputs();
        }

        function submitInputs(){
            openLoading(false, () => {
                $.ajax({
                    type: 'POST',
                    url: stageOneStoreUrl,
                    data: dataToSend,
                    success: response => {
                        if(response.status === 'ok')
                            location.href = `${stageTwoUrl}/${response.result}`;
                        else{
                            closeLoading();
                            showSuccessNotifiBP('در ثبت مشکلی پیش آمده', 'left', 'red');
                        }
                    },
                    error: err =>{
                        closeLoading();
                        showSuccessNotifiBP('در ثبت مشکلی پیش آمده', 'left', 'red')
                    }
                })
            });
        }

    </script>

    <script defer src="{{URL::asset('BusinessPanelPublic/js/tour/create/cityTourism/cityTourism_stage_1.js?v='.$fileVersions)}}"></script>
@endsection


