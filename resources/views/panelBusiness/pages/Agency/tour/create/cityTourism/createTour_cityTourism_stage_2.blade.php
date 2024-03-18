@extends('panelBusiness.layout.baseLayout')

@section('head')
    <title>ویرایش تور : مرحله دوم</title>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/shazdeDesigns/tourCreation.css?v=' . $fileVersions) }}" />
    <link rel="stylesheet" type="text/css"
        href="{{ URL::asset('BusinessPanelPublic/css/tour/cityTourism.css?v=' . $fileVersions) }}" />

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/clockpicker.css?v=1') }}" />
    <script src={{ URL::asset('js/clockpicker.js') }}></script>

    <link rel="stylesheet" href="{{ URL::asset('packages/leaflet/leaflet.css') }}">
@endsection


@section('body')
    <div class="mainBackWhiteBody">
        <div class="head">ویرایش تور : مرحله دوم</div>
        <div>
            <div class="menu whiteBox">
                <div class="boxTitlesTourCreation">رفت و آمد</div>
                <div id="tourMainTransports">
                    <div id="sDiv">
                        <div class="row">
                            <div class="col-md-12 inboxHelpSubtitle">نوع وسیله رفت و آمد در تور خود را مشخص کنید.</div>
                            <div class="col-md-4 inputBoxTour transportationKindTourCreation">
                                <div class="inputBoxText">
                                    <div class="importantFieldLabel">نوع وسیله</div>
                                </div>
                                <select id="sTransport" class="inputBoxInput styled-select">
                                    <option value="0">انتخاب کنید</option>
                                    @foreach ($transport as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="seperatorInWhiteSec">
                            <div class="col-md-12 inboxHelpSubtitle">در این بخش اطلاعات شروع حرکت خود را وارد کنید.</div>
                            <div class="row">
                                <div class="col-md-4 inputBoxTour transportationStartTimeTourCreation">
                                    <div class="inputBoxText">
                                        <div class="importantFieldLabel">ساعت حرکت</div>
                                    </div>
                                    <input id="sTime" type="text" class="inputBoxInput center clock"
                                        placeholder="00:00" required readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="inputBoxTour col-md-9" id="sAddressDiv" style="margin-left: 10px;">
                                    <div class="inputBoxText">
                                        <div class="importantFieldLabel">آدرس دقیق محل سوار شدن</div>
                                    </div>
                                    <input id="sAddress" class="inputBoxInput" type="text"
                                        placeholder="آدرس سوار شدن مسافران">
                                </div>
                                <button type="button" class="transportationMapPinningTourCreation col-md-2"
                                    onclick="changeCenter('src')">نشانه‌گذاری بر روی نقشه</button>
                                <input type="hidden" id="sLat" value="0">
                                <input type="hidden" id="sLng" value="0">
                            </div>

                            <div class="row">
                                <div class="inputBoxTour col-md-12">
                                    <div class="inputBoxText" style="width: 120px">توضیحات تکمیلی</div>
                                    <textarea id="sDescription" class="inputBoxInput" placeholder="حداکثر 100 کاراکتر" maxlength="100"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="seperatorInWhiteSec">
                            <div class="col-md-12 inboxHelpSubtitle">در این بخش اطلاعات پایان تور خود را وارد کنید.</div>

                            <div class="row">
                                <div class="col-md-4 inputBoxTour transportationStartTimeTourCreation"
                                    style="margin-left: 10px;">
                                    <div class="inputBoxText">
                                        <div class="importantFieldLabel">ساعت پیاده شدن</div>
                                    </div>
                                    <input id="eTime" type="text" class="inputBoxInput clock" placeholder="00:00"
                                        readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="inputBoxTour col-md-9" style="margin-left: 10px;">
                                    <div class="inputBoxText">
                                        <div class="importantFieldLabel">آدرس دقیق محل پیاده شدن</div>
                                    </div>
                                    <input id="eAddress" class="inputBoxInput" type="text" placeholder="فارسی">
                                </div>
                                <button type="button" class="transportationMapPinningTourCreation col-md-2"
                                    onclick="changeCenter('dest')">نشانه‌گذاری بر روی نقشه</button>
                                <input id="eLat" type="hidden" value="0">
                                <input id="eLng" type="hidden" value="0">
                            </div>

                            <div class="row" style="display: flex">
                                <div class="inputBoxTour col-md-12">
                                    <div class="inputBoxText" style="width: 120px">توضیحات تکمیلی</div>
                                    <textarea id="eDescription" class="inputBoxInput" placeholder="حداکثر 100 کاراکتر" maxlength="100"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="whiteBox">
                <div class="boxTitlesTourCreation">زبان تور</div>
                <div class="nonGovernmentalTitleTourCreation">
                    <span>آیا مسافران خارجی هم می توانند در این تور شرکت کنند؟ در صورت بله بودن ، زبان های قابل ارائه را
                        انتهاب کنید.</span>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-secondary">
                            <input type="radio" name="hasOtherLanguage" value="1" autocomplete="off"
                                onchange="changeOtherLanguage(this.value)">
                            بله
                        </label>
                        <label class="btn btn-secondary active">
                            <input type="radio" name="hasOtherLanguage" value="0" autocomplete="off"
                                onchange="changeOtherLanguage(this.value)" checked>
                            خیر
                        </label>
                    </div>
                </div>

                <div id="otherLanguageSection" class="hidden">
                    <div class=" col-md-12 inputBoxTour relative-position">
                        <div class="inputBoxText width-130"> زبان‌های دیگر</div>
                        <div id="multiSelectedLanguage" class="transportationKindChosenMainDiv multiSelected"
                            onclick="openMultiSelect(this)"></div>
                        <div id="multiSelectLanguage" class="multiselect"></div>
                    </div>
                </div>
            </div>

            <div class="whiteBox">
                <div class="boxTitlesTourCreation">راهنمای تور</div>
                <div class="inboxHelpSubtitle"> نام راهنمای تور خود را وارد نمایید. این امر نقش مؤثری در اطمینان خاطر
                    کاربران خواهد داشت.</div>
                <div class="tourGuiderQuestions mg-tp-15">
                    <span>آیا تور شما راهنما دارد؟</span>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-secondary active">
                            <input type="radio" name="isTourGuide" value="1"
                                onchange="showSection('isTourGuidDiv', this)" checked>بلی
                        </label>
                        <label class="btn btn-secondary">
                            <input type="radio" name="isTourGuide" value="0"
                                onchange="showSection('isTourGuidDiv', this)">خیر
                        </label>
                    </div>
                </div>
                <div id="isTourGuidDiv">
                    <div class="tourGuiderQuestions mg-tp-15">
                        <span>آیا راهنمای تور شما از افراد محلی منطقه می باشد؟</span>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary active">
                                <input type="radio" name="isLocalTourGuide" value="1" checked>بلی
                            </label>
                            <label class="btn btn-secondary">
                                <input type="radio" name="isLocalTourGuide" value="0">خیر
                            </label>
                        </div>
                    </div>
                    <div class="tourGuiderQuestions mg-tp-15">
                        <span>آیا راهنمای تور شما تجربه‌ی مخصوصی برای افراد فراهم می‌آورد؟</span>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary active">
                                <input type="radio" name="isSpecialTourGuid" value="1" checked>بلی
                            </label>
                            <label class="btn btn-secondary">
                                <input type="radio" name="isSpecialTourGuid" value="0">خیر
                            </label>
                        </div>
                    </div>
                    <div class="inboxHelpSubtitle mg-tp-5" style="width: 100%">برخی از راهنمایان تور صرفاً گروه را هدایت
                        می‌کنند اما برخی همراه با گردشگران در همه جا حضور می‌یابند و تجربه‌ی اختصاصی‌تری ایجاد می‌کنند.
                    </div>
                    <div class="tourGuiderQuestions mg-tp-15">
                        <span>آیا راهنمای تور شما هم اکنون مشخص است؟</span>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary active">
                                <input type="radio" name="isTourGuidDefined" value="1"
                                    onchange="showSection('isTourGuidDefinedDiv', this)" checked>بلی
                            </label>
                            <label class="btn btn-secondary">
                                <input type="radio" name="isTourGuidDefined" value="0"
                                    onchange="showSection('isTourGuidDefinedDiv', this)">خیر
                            </label>
                        </div>
                    </div>

                    <div id="isTourGuidDefinedDiv">
                        <div class="tourGuiderQuestions mg-tp-15">
                            <span>آیا راهنمای تور شما دارای حساب کاربری کوچیتا می‌باشد؟</span>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-secondary ">
                                    <input type="radio" name="isTourGuidInKoochita" value="1"
                                        onchange="hasKoochitaAccount(this.value)">بلی
                                </label>
                                <label class="btn btn-secondary active">
                                    <input type="radio" name="isTourGuidInKoochita" value="0"
                                        onchange="hasKoochitaAccount(this.value)" checked>خیر
                                </label>
                            </div>
                        </div>

                        <div id="notKoochitaAccountDiv">
                            <div class="inboxHelpSubtitle mg-tp-5">
                                به راهنمای تور خود توصیه کنید تا حساب خود را در کوچیتا ایجاد نماید و از مزایای آن بهره‌مند
                                شود. برای ما راهنمایان تور دارای حساب کاربری از اهمیت بیشتری برخوردار هستند. پس از باز کردن
                                حساب کاربری راهنمای تور شما می‌تواند با وارد کردن کد تور و پس از تأیید شما نام خود را به
                                صفحه‌ی کاربریش اتصال دهد.
                            </div>
                            <div class="row" style="align-items: center;">
                                <div class="col-md-5 inputBoxTour">
                                    <div class="inputBoxText" style="width: 160px">
                                        <div class="importantFieldLabel">نام و نام خانوادگی</div>
                                    </div>
                                    <input id="tourGuidName" class="inputBoxInput" type="text" placeholder="فارسی">
                                </div>
                                <div class="col-md-2 inputBoxTour" style="margin: 0px 10px;">
                                    <div class="inputBoxText width-45per">
                                        <div class="importantFieldLabel">جنسیت</div>
                                    </div>
                                    <div class="select-side">
                                        <i class="glyphicon glyphicon-triangle-bottom"></i>
                                    </div>
                                    <select id="tourGuidSex" class="inputBoxInput width-50per styled-select">
                                        <option value="1">مرد</option>
                                        <option value="0">زن</option>
                                    </select>
                                </div>
                                <div class="col-md-4 inputBoxTour">
                                    <div class="inputBoxText width-45per">
                                        <div class="importantFieldLabel">شماره تماس</div>
                                    </div>
                                    <input id="tourGuidPhone" class="inputBoxInput" type="text"
                                        placeholder="09xxxxxxxx">
                                </div>

                            </div>
                        </div>

                        <div id="haveKoochitaAccountDiv" style="display: none;">
                            <div class="inboxHelpSubtitle mg-tp-5" style="width: 100%;">درخواست شما برای کاربر مورد نظر
                                ارسال می‌شود و پس از تأیید او نام او به عنوان راهنمای تور معرفی می‌گردد.</div>
                            <div class="inputBoxTour float-right col-md-3">
                                <div class="inputBoxText">
                                    <div class="importantFieldLabel">نام کاربری</div>
                                </div>
                                <input id="tourGuidKoochitaUsername" class="inputBoxInput" type="text"
                                    onclick="openSearchKoochitaAccount()" value="{{ $tour->koochitaUserName ?? '' }}"
                                    readonly>
                                <input type="hidden" id="tourGuidUserId" value="{{ $tour->tourGuidKoochitaId }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="whiteBox">
                <div class="boxTitlesTourCreation">تلفن پشتیبانی برای این تور</div>
                <div id="backUpPhoneDiv">
                    <div class="inputBoxTour float-right col-md-3">
                        <div class="inputBoxText">
                            <div class="importantFieldLabel">تلفن</div>
                        </div>
                        <input id="backUpPhone" class="inputBoxInput" type="text">
                    </div>
                    <div class="inboxHelpSubtitle" style="width: 100%;">
                        شماره را همانگونه که با موبایل خود تماس می‌گیرید وارد نمایید. در صورت وجود بیش از یک شماره با
                        استفاده از - شماره‌ها را جدا نمایید.
                    </div>
                </div>
            </div>


            <div class="row submitAndPrevButton">
                <button class="btn nextStepBtnTourCreation" type="button" onclick="checkInput()">ثبت اطلاعات و رفتن به
                    گام بعدی</button>
                <button class="btn nextStepBtnTourCreation goToPrevStep" type="button" onclick="goToPrevStep()">بازگشت
                    به مرحله قبل</button>
            </div>
        </div>
    </div>
@endsection


@section('modals')
    @include('panelBusiness.component.userKoochitaSearchBP')

    <div class="modal fade" id="modalMap">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="mapDiv" style="width: 100%; height: 500px"></div>
                </div>
                <div class="modal-footer" style="text-align: center">
                    <button type="button" class="btn btn-success" data-dismiss="modal">تایید</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script defer type="text/javascript" src="{{ URL::asset('packages/leaflet/leaflet-src.js') }}"></script>
    <script defer type="text/javascript" src="{{ URL::asset('packages/leaflet/leaflet-wms-header.js') }}"></script>

    <script>
        var mappIrToken = '{{ config('app.MappIrToken') }}';

        var tour = {!! $tour !!};
        var transports = {!! $transport !!};
        var prevStageUrl =
            "{{ route('businessManagement.tour.create.stage_1', ['business' => $businessIdForUrl, 'tourId' => $tour->id]) }}";
        var nextStageUrl =
            "{{ route('businessManagement.tour.create.stage_3', ['business' => $businessIdForUrl, 'tourId' => $tour->id]) }}";
        var storeStageURL = "{{ route('businessManagement.tour.store.stage_2') }}";
    </script>

    <script defer
        src="{{ URL::asset('BusinessPanelPublic/js/tour/create/cityTourism/cityTourism_stage_2.js?v=' . $fileVersions) }}">
    </script>
@endsection
