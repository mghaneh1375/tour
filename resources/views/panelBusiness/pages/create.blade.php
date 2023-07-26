@extends('panelBusiness.layout.baseLayout')

@section('head')

    <title>عنوان</title>

    <link rel="stylesheet" href="{{ URL::asset('css/pages/localShops/mainLocalShops.css?v=' . $fileVersions) }}">
    <link rel="stylesheet" href="{{ URL::asset('css/pages/business.css?v=' . $fileVersions) }}">
    <link rel="stylesheet" href="{{ URL::asset('BusinessPanelPublic/css/createBusinessPage.css?v=' . $fileVersions) }}">
    <link rel="stylesheet" href="{{ URL::asset('packages/clockPicker/bootstrap-clockpicker.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('packages/clockPicker/jquery-clockpicker.min.css') }}">

    <script defer src="{{ URL::asset('packages/clockPicker/jquery-clockpicker.js') }}"></script>
    <script defer src="{{ URL::asset('packages/clockPicker/bootstrap-clockpicker.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/form.css?v=' . $fileVersions) }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/common.css?v=' . $fileVersions) }}" />

    <script>
        var uploadPicBusinessBaseUrl = '{{ url('uploadBusinessPic') }}';
        var deleteBusinessPicBaseUrl = '{{ url('deleteBusinessPic') }}';
        var doCreatePath = '{{ route('businessPanel.doCreate') }}';
        var editPath = '{{ url('businessEdit') }}';
        var updateBusinessInfo1BaseUrl = '{{ url('updateBusinessInfo1') }}';
        var updateBusinessInfo2BaseUrl = '{{ url('updateBusinessInfo2') }}';
        var updateBusinessInfo4BaseUrl = '{{ url('updateBusinessInfo4') }}';
        var updateBusinessInfo5BaseUrl = '{{ url('updateBusinessInfo5') }}';
        var getContractPath = '{{ route('businessPanel.getContract') }}';
        var finalizeBusinessInfoBaeUrl = '{{ url('finalizeBusinessInfo') }}';
        var myBusinessesPath = '{{ route('businessPanel.myBusinesses') }}';
        var searchForCityPath = "{{ route('searchForCity') }}";
        var deleteMadarekBaseUrl = "{{ url('deleteBusinessMadarek') }}";
        var arr_nums = ["اول", "دوم", "سوم", "چهارم", "پنجم", "ششم", "هفتم", "هشتم", "نهم", "دهم"];
        var busy_idx = [false, false, false, false, false, false, false, false, false, false];
        var id_idx = [-1, -1, -1, -1, -1, -1, -1, -1, -1, -1];
        var data = {
            "type": "None",
            "additionalValue": false
        };
        var currentPage = 1;
        var currProgress = 10;
        var created = false;
        var mode = "create";
    </script>
@endsection

@section('body')
    <div class="createBusinessPage height100">
        <div class="row indicator_step hidden" id="step1">
            <div class="col-md-12">

                <div class="mainBackWhiteBody">
                    <h1 style="border-bottom: solid 1px lightgray;padding-bottom: 10px;">نوع ارائه دهنده</h1>
                    <div style="margin-top: 20px">
                        <h4>کسب و کار خود را چگونه توصیف می کنید؟</h4>
                        <p>با استفاده از این اطلاعات، ما دسترسی های مناسب تری برای شما ایجاد می کنیم.</p>

                        <div class="col-xs-12 col-md-12">
                            <label for="hoghoghi" class="kindOfBusinessOwnerSection">
                                <div class="inputSec">
                                    <input id="hoghoghi" type="radio" name="haghHogh" style="display: block;">
                                </div>
                                <div class="content">
                                    <svg width="20" height="16" viewBox="0 0 20 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_68_180)">
                                            <path opacity="0.4"
                                                d="M3.99012 5C5.36173 5 6.48395 3.875 6.48395 2.5C6.48395 1.125 5.36173 0 3.99012 0C2.61852 0 1.4963 1.125 1.4963 2.5C1.4963 3.875 2.61852 5 3.99012 5ZM15.9605 5C17.3321 5 18.4543 3.875 18.4543 2.5C18.4543 1.125 17.3321 0 15.9605 0C14.5889 0 13.4667 1.125 13.4667 2.5C13.4667 3.875 14.5889 5 15.9605 5ZM17.2074 6H15.2747C14.8694 6 14.4954 6.09375 14.1525 6.25C14.1836 6.4375 14.2148 6.59375 14.2148 6.75C14.2148 7.8125 13.8096 8.75 13.1861 9.5H19.3895C19.7012 9.5 19.9506 9.25 19.9506 8.90625C19.9506 7.3125 18.7349 6 17.2074 6ZM5.79815 6.25C5.45525 6.09375 5.08117 6 4.67593 6H2.74321C1.21574 6 0 7.3125 0 8.90625C0 9.25 0.249383 9.5 0.561111 9.5H6.76451C6.14105 8.75 5.7358 7.8125 5.7358 6.75C5.7358 6.59375 5.76697 6.40625 5.79815 6.25Z"
                                                fill="#0076A3" />
                                            <path
                                                d="M9.97542 10C11.7523 10 13.2174 8.53125 13.2174 6.75C13.2174 4.96875 11.7523 3.5 9.97542 3.5C8.16739 3.5 6.73344 4.96875 6.73344 6.75C6.73344 8.53125 8.16739 10 9.97542 10ZM11.5341 11H8.41678C5.9853 11 3.99023 12.875 3.99023 15.1562C3.99023 15.625 4.39548 16 4.86307 16H15.0878C15.5554 16 15.9606 15.625 15.9606 15.1562C15.9606 12.875 13.9655 11 11.5341 11Z"
                                                fill="#0076A3" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_68_180">
                                                <rect width="19.9506" height="16" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>

                                    <p>ما یک کسب و کار هستیم. (شخصیت حقوقی)</p>
                                </div>
                            </label>
                        </div>

                        <div class="col-xs-12 col-md-12" style="margin-top: 10px">

                            <label for="haghighi" class="kindOfBusinessOwnerSection">
                                <div class="inputSec">
                                    <input id="haghighi" type="radio" name="haghHogh" style="display: block;">
                                </div>
                                <div class="content">
                                    <svg width="14" height="16" viewBox="0 0 14 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_68_174)">
                                            <path opacity="0.4"
                                                d="M11 4C11 6.21875 9.21875 8 7 8C4.78125 8 3 6.21875 3 4C3 1.78125 4.78125 0 7 0C9.21875 0 11 1.78125 11 4Z"
                                                fill="#0076A3" />
                                            <path
                                                d="M8.59375 9.60001H5.40625C2.4375 9.60001 0 12.0375 0 15.0063C0 15.6 0.5 16.1 1.09375 16.1H12.9062C13.5 16.1 14 15.6 14 15.0063C14 12.0375 11.5625 9.60001 8.59375 9.60001Z"
                                                fill="#0076A3" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_68_174">
                                                <rect width="14" height="16" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>

                                    <p>من یک شخص و یا گروه هستم. (شخصیت حقیقی)</p>
                                </div>
                            </label>
                        </div>

                        <div class="col-xs-12 fullyCenterContent" style="margin-top: 10px;">
                            <button onclick="goToPage(1, 10)" class="btn btn-success">مرحله بعد</button>
                            {{-- <button onclick="document.location.href = '/createForm?isHaghighi='+isHaghighi "
                                class="btn btn-success">مرحله بعد</button> --}}
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <div class="row indicator_step height100 hidden" id="step2">

            <div class="col-md-12 height100">

                <div class="mainBackWhiteBody">
                    <div class="head">نوع خدمت قابل ارائه</div>
                    <div style="margin-top: 20px">
                        <h4>مایل به ارائه چه نوع خدمتی هستید؟</h4>
                        <div>
                            <p>از بین گزینه های زیر یک گزینه را می توانید انتخاب کنید.</p>
                            <p>توجه کنید، این انتخاب بعدها قابل تغییر می باشد، اما به سبب گزینه های انتخاب شده، ما نیازمند
                                اطلاعات مفصلی از شما هستیم و امکانات متفاوتی را در اختیار شما قرار می دهیم.</p>
                        </div>

                        <div class="col-xs-12 col-md-8">
                            <div data-type="agency" class="businessType">

                                <div class="picSection">
                                    <img class="resizeImgClass" src="{{ URL::asset('defaultPic/4.jpg') }}"
                                        onload="fitThisImg(this)">
                                </div>

                                <div class="textSec">
                                    <h5>آژانس مسافرتی</h5>
                                    <p>شما می توانید برای فروش تورهای خود از امکانات ما استفاده کنید.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-8" style="margin-top: 10px">
                            <div data-type="tour" class="businessType disabled" disabled="true">
                                <div class="picSection">
                                    <img class="resizeImgClass" src="{{ URL::asset('defaultPic/4.jpg') }}"
                                        onload="fitThisImg(this)">
                                </div>

                                <div class="textSec">
                                    <h5>تور لیدر</h5>
                                    <p>شما می توانید برای معرفی خود به گردشگران از امکانات ما استفاده کنید.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-8" style="margin-top: 10px">
                            <div data-type="hotel" class="businessType disabled" disabled="true">
                                <div class="picSection">
                                    <img class="resizeImgClass" src="{{ URL::asset('defaultPic/4.jpg') }}"
                                        onload="fitThisImg(this)">
                                </div>
                                <div class="textSec">
                                    <h5>صاحب هتل</h5>
                                    <p>شما می توانید کنترل صفحه خود را در دست گرفته و به صورت رسمی به کاربران پاسخ دهید.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-8" style="margin-top: 10px">
                            <div data-type="restaurant" class="businessType disabled" disabled="true">
                                <div class="picSection">
                                    <img class="resizeImgClass" src="{{ URL::asset('defaultPic/4.jpg') }}"
                                        onload="fitThisImg(this)">
                                </div>
                                <div class="textSec">
                                    <h5>صاحب رستوران، فست فود و ...</h5>
                                    <p>شما می توانید کنترل صفحه خود را در دست گرفته و به صورت رسمی به کاربران پاسخ دهید.</p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-xs-12 fullyCenterContent rowReverse SpaceBetween" style="margin-top: 20px;">
                        <button onclick="goToPage(1, 10)" class="btn btn-success">مرحله بعد</button>
                        <button onclick="goToPage(-1, -10)" class="btn btn-danger">مرحله قبل</button>
                    </div>

                </div>

            </div>
        </div>

        <div class="row indicator_step height100 hidden" id="step3">

            <div class="col-md-12 height100">

                <div class="mainBackWhiteBody">

                    <h1>اطلاعات کسب و کار</h1>

                    <div style="margin-top: 20px">

                        <div class="row mt-4 col-xs-12 col-md-6">

                            <div class="col-md-6 hogh">
                                <div class="form-group">
                                    <label for="regularName">نام قانونی کسب و کار</label>
                                    <input type="text" id="regularName" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6 hidden hagh">
                                <div class="form-group">
                                    <label for="name">نام کسب و کار</label>
                                    <input type="text" id="name" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6 hogh">
                                <div class="form-group">
                                    <label for="businessNID">شناسه ملی</label>
                                    <input type="text" id="businessNID" onkeypress="justNum(event)"
                                        class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6 hagh hidden">
                                <div class="form-group">
                                    <label for="nid">شماره ملی</label>
                                    <input type="text" id="nid" onkeypress="justNum(event)"
                                        class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6 hogh">
                                <div class="form-group">
                                    <label for="economyCode">شماره اقتصادی</label>
                                    <input type="text" onkeypress="justNum(event)" id="economyCode"
                                        class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="site">آدرس وب سایت</label>
                                    <input type="text" id="site" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tel">شماره تماس ثابت</label>
                                    <input type="text" id="tel" onkeypress="justNum(event)"
                                        class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mail">آدرس ایمیل</label>
                                    <input type="email" id="mail" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="insta">آدرس صفحه اینستاگرام</label>
                                    <input type="text" id="insta" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telegram">آدرس تلگرام</label>
                                    <input type="text" id="telegram" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="introduction">معرفی کوتاه</label>
                                    <textarea style="height: 150px" id="introduction" class="form-control"></textarea>
                                </div>
                            </div>

                        </div>

                    </div>

                    <center class="col-xs-12 fullyCenterContent rowReverse SpaceBetween" style="margin-top: 20px;">

                        <button onclick="goToPage(1, 10)" class="btn btn-success">مرحله بعد</button>

                        <button onclick="goToPage(-1, -10)" id="step3Back" class="btn btn-danger">مرحله قبل</button>

                    </center>

                </div>

            </div>
        </div>

        <div class="row indicator_step height100 hidden" id="step4">

            <div class="col-md-12 height100">

                <div class="mainBackWhiteBody">
                    <h1>اطلاعات محل کسب و کار</h1>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-sm-12 form-group importantInput">
                                    <label for="city" style="padding-top: 27px;">شهر</label>
                                    <input type="text" class="form-control mustFull" id="city"
                                        placeholder="نام شهر خود را وارد نمایید..." onclick="openSearchFindCity()"
                                        readonly>
                                    <input type="hidden" id="cityId" value="0">
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address">آدرس دقیق</label>
                                        <textarea id="address" style="width: 100%; height: 150px" placeholder="آدرس"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 form-group importantInput" style="padding-top: 25px;">
                            <label for="shopMap">انتخاب از روی نقشه</label>
                            <div class="descriptionText">شما می توانید با کلیک روی نقشه محل مورد نظر را ثبت نمایید .</div>
                            <div class="shopMapInput">
                                <div id="mapDiv" style="width: 100%; height: 100%"></div>
                                <input type="hidden" id="lat" value="0">
                                <input type="hidden" id="lng" value="0">
                                <button class="myLocationButton" onclick="findMyLocation()">
                                    <img src="{{ URL::asset('images/icons/myLocation.svg') }}">
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12" id="workHour">
                        <h2>با پر کردن اطلاعات این بخش به مشتریان خود کمک کنید.</h2>
                        <div class="container" style="width: 100%;">
                            <div class="row">
                                <div class="col-sm-12 headerRowInput">
                                    ساعات کاری کسب و کار
                                    <div class="checkboxDiv">
                                        <label for="allDay24">شبانه روزی هستم</label>
                                        <input type="checkbox" id="allDay24" onchange="iAm24Hour()">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="timeSection">
                                        <div id="inWeekDiv" class="timeRow">
                                            <div class="text">روز های هفته:</div>
                                            <div style="display: flex; align-items: center;">
                                                <div class="smTex">از ساعت </div>
                                                <div class="timePicker clockpicker">
                                                    <input class="form-control" id="inWeekDayStart" type="text"
                                                        placeholder="انتخاب کنید">
                                                </div>
                                                <div class="smTex">تا ساعت </div>
                                                <div class="timePicker clockpicker">
                                                    <input class="form-control" id="inWeekDayEnd" type="text"
                                                        placeholder="انتخاب کنید">
                                                </div>
                                            </div>
                                        </div>

                                        <div id="closedBeforeDayDiv" class="timeRow">
                                            <div class="text">روز های قبل تعطیلی: </div>
                                            <div style="display: flex; align-items: center;">
                                                <div class="smTex">از ساعت </div>
                                                <div class="timePicker clockpicker">
                                                    <input class="form-control" id="afterClosedDayStart" type="text"
                                                        placeholder="انتخاب کنید">
                                                </div>
                                                <div class="smTex">تا ساعت </div>
                                                <div class="timePicker clockpicker">
                                                    <input class="form-control" id="afterClosedDayEnd" type="text"
                                                        placeholder="انتخاب کنید">
                                                </div>
                                            </div>

                                            <label class="openCloseInputDiv" for="afterClosedDayButton">
                                                <input type="checkbox" id="afterClosedDayButton"
                                                    onchange="iAmClose(this)">
                                                <div class="openCloseInputShow"></div>
                                            </label>
                                        </div>
                                        <div id="closedDayDiv" class="timeRow">
                                            <div class="text">روز های تعطیلی: </div>

                                            <div style="display: flex; align-items: center;">
                                                <div class="smTex">از ساعت </div>
                                                <div class="timePicker clockpicker">
                                                    <input class="form-control" id="closedDayStart" type="text"
                                                        placeholder="انتخاب کنید">
                                                </div>
                                                <div class="smTex">تا ساعت </div>
                                                <div class="timePicker clockpicker">
                                                    <input class="form-control" id="closedDayEnd" type="text"
                                                        placeholder="انتخاب کنید">
                                                </div>
                                            </div>
                                            <label class="openCloseInputDiv" for="closedDayButton">
                                                <input type="checkbox" id="closedDayButton" onchange="iAmClose(this)">
                                                <div class="openCloseInputShow"></div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <center class="col-xs-12 fullyCenterContent rowReverse SpaceBetween" style="margin-top: 20px;">

                        <button onclick="goToPage(1, 10)" class="btn btn-success">مرحله بعد</button>

                        <button onclick="goToPage(-1, -10)" class="btn btn-danger">مرحله قبل</button>

                    </center>

                </div>

            </div>
        </div>

        <div class="row indicator_step height100 createBusinessStep5 hidden" id="step5">

            <div class="col-md-12 height100">
                <div class="mainBackWhiteBody">
                    <div class="head">مدارک مورد نیاز</div>

                    <div class="col-md-12">
                        <div class="numOfUserInBusiness form-group">
                            <label for="numOfMembers">تعداد سهام داران</label>
                            <select id="numOfMembers" class="signInInput form-control" name="numOfMembers">
                                @for ($i = 1; $i < 11; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12" id="usersDiv"></div>

                    <div class="col-xs-12 fullyCenterContent rowReverse SpaceBetween" style="margin-top: 20px;">
                        <button onclick="goToPage(1, 10)" class="btn btn-success">مرحله بعد</button>
                        <button onclick="goToPage(-1, -10)" class="btn btn-danger">مرحله قبل</button>
                    </div>

                </div>

            </div>
        </div>

        <div class="row indicator_step height100 hidden" id="step6">

            <div class="col-md-12 height100">

                <div class="mainBackWhiteBody">

                    <div class="head">اطلاعات مالی</div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="additionalValue" style="cursor: pointer;">آیا شما مشمول مالیات بر ارزش افزوده
                                هستید؟</label>
                            <input type="checkbox" id="additionalValue" onchange="changeAdditionalValue()">
                        </div>
                    </div>

                    <div class="col-md-6 additionalValue hidden">
                        <div class="form-group">
                            <label for="expire">تاریخ انقضا گواهی ارزش افزوده</label>
                            <input style="direction: ltr; text-align: left" type="text"
                                onkeydown="validateDate(event, 'expire')" placeholder="____ / __ / __" id="expire">
                        </div>
                    </div>

                    <div class="col-md-6 additionalValue hidden">
                        <div class="boldDescriptionText" style="color: var(--koochita-green);">تصویر گواهی ارزش افزوده
                        </div>
                        <div id="uploadedSection" class="uploadPicSection">
                            <div id="showUploadPicsSection" class="showUploadedFiles"></div>
                            <div id="uploadPicInfoText" class="uploadPic">
                                <img src="{{ URL::asset('images/icons/uploadPic.png') }}">
                                <div>عکس های خود را در اینجا قرار دهید </div>
                                <div style="margin-top: 10px; font-weight: bold;"> و یا </div>
                            </div>
                            <label class="labelForClick" for="additionalValuePics">کلیک کنید</label>
                        </div>
                        <input type="file" accept="image/*" id="additionalValuePics" style="display: none"
                            onchange="var tmpIdx = initUploader('additionalValue', 'showUploadPicsSection', 'uploadPicInfoText', 1); if(tmpIdx != -1) uploadPicClickHandler(this, tmpIdx)">
                    </div>

                    <div class="col-md-12" style="margin-top: 20px">
                        <div class="form-group">
                            <label for="shaba">شماره شبا</label>
                            <input style="width: 400px" type="text" onkeypress="justNum(event)" id="shaba">
                        </div>
                    </div>

                    <center class="col-xs-12 fullyCenterContent rowReverse SpaceBetween" style="margin-top: 20px;">

                        <button onclick="goToPage(1, 10)" class="btn btn-success">مرحله بعد</button>

                        <button onclick="goToPage(-1, -10)" class="btn btn-danger">مرحله قبل</button>

                    </center>

                </div>

            </div>
        </div>

        <div class="row indicator_step height100 hidden" id="step7">

            <div class="col-md-12 height100">

                <div class="mainBackWhiteBody">

                    <div class="head">عکس کسب و کار شما</div>

                    <div class="col-md-6">
                        <div class="boldDescriptionText" style="color: var(--koochita-green);">حداقل یک عکس از کسب و کار
                            خود وارد نمایید.</div>
                        <div class="descriptionText">عکس شما نباید دارای واترمارک بوده و یا از محلی غیر از کسب و کار شما
                            باشد.</div>
                        <div id="uploadedSection2" class="uploadPicSection">
                            <div id="showUploadPicsSection2" class="showUploadedFiles"></div>
                            <div id="uploadPicInfoText2" class="uploadPic">
                                <img src="{{ URL::asset('images/icons/uploadPic.png') }}">
                                <div>عکس های خود را در اینجا قرار دهید </div>
                                <div style="margin-top: 10px; font-weight: bold;"> و یا </div>
                            </div>
                            <label class="labelForClick" for="pics2">کلیک کنید</label>
                        </div>
                        <input type="file" accept="image/*" id="pics2" style="display: none"
                            onchange="var tmpIdx = initUploader('pic', 'showUploadPicsSection2', 'uploadPicInfoText2', 4); if(tmpIdx != -1) uploadPicClickHandler(this, tmpIdx)">
                    </div>


                    <div class="col-md-6">
                        <div class="boldDescriptionText" style="color: var(--koochita-green);">تصویر لوگو یا تصویر شما
                        </div>
                        <div class="descriptionText">اگر لوگو خود را بدون زمینه و در فرمت PNG بارگذاری کنید، صفحه زیباتری
                            خواهید داشت.</div>
                        <div id="uploadedSection3" class="uploadPicSection">
                            <div id="showUploadPicsSection3" class="showUploadedFiles"></div>
                            <div id="uploadPicInfoText3" class="uploadPic">
                                <img src="{{ URL::asset('images/icons/uploadPic.png') }}">
                                <div>عکس های خود را در اینجا قرار دهید </div>
                                <div style="margin-top: 10px; font-weight: bold;"> و یا </div>
                            </div>
                            <label class="labelForClick" for="logoPics">کلیک کنید</label>
                        </div>
                        <input type="file" accept="image/*" id="logoPics" style="display: none"
                            onchange="var tmpIdx = initUploader('logo', 'showUploadPicsSection3', 'uploadPicInfoText3', 1); if(tmpIdx != -1) uploadPicClickHandler(this, tmpIdx)">
                    </div>

                    <center class="col-xs-12 fullyCenterContent rowReverse SpaceBetween" style="margin-top: 20px;">

                        <button onclick="goToPage(1, 10)" class="btn btn-success">مرحله بعد</button>

                        <button onclick="goToPage(-1, -10)" class="btn btn-danger">مرحله قبل</button>

                    </center>

                </div>

            </div>
        </div>

        <div class="row indicator_step height100 hidden" id="step8">

            <div class="col-md-12 height100">

                <div class="mainBackWhiteBody">
                    <div class="head">قرارداد همکاری</div>
                    <div style="margin-top: 20px">

                        <div class="col-xs-12" style="margin-top: 10px">

                            <div class="col-xs-12 col-md-8">

                                <div onscroll="scrolled(event)"
                                    style="width: 100%; height: 200px; overflow: auto; border: 2px solid #7d7d7d; padding: 5px"
                                    id="contract"></div>

                                <div style="width: 100%; margin-top: 20px">
                                    <label for="confirmContract" style="cursor: pointer;">تمامی مطالب را با دقت مطالعه
                                        کردم و همگی را قبول دارم.</label>
                                    <input type="checkbox" id="confirmContract" disabled style="display: inline-block;">
                                </div>

                            </div>
                        </div>

                    </div>

                    <center class="col-xs-12 fullyCenterContent rowReverse SpaceBetween" style="margin-top: 20px;">

                        <button onclick="goToPage(1, 10)" class="btn btn-success">تایید نهایی</button>

                        <button onclick="goToPage(-1, -10)" class="btn btn-danger">مرحله قبل</button>

                    </center>

                </div>

            </div>
        </div>

        <div id="userShareHolderCardHtmlSample" class="hidden">
            <div class="cards shareHolderCard" data-val="##idx##" id="user_##idx##">
                <div id="title_##idx##" class="title">عضو ##arr_nums##</div>
                <div class="content">
                    <div class="inputLabel inputRow" id="inputLabel_title_##idx##">
                        <input type="hidden" name="id_##idx##" value="-1">
                        <div class="form-group">
                            <label for="name_##idx##">نام و نام خانوادگی</label>
                            <input id="name_##idx##" class="signInInput form-control" type="text">
                        </div>
                        <div class="form-group">
                            <label for="role_##idx##">سمت</label>
                            <select id="role_##idx##" class="signInInput form-control">
                                <option value="1">رئیس هیئت مدیره</option>
                                <option value="2">مدیر عامل</option>
                                <option value="3">عضو هیئت مدیره</option>
                                <option value="4">نایب رئیس هیئت مدیره</option>
                                <option value="5">سایر</option>
                            </select>
                        </div>
                    </div>

                    <div id="inputLabel_nid_##idx##" class="inputLabel picSec">
                        <div class="boldDescriptionText title">تصویر رو و پشت کارت ملی را در این قسمت آپلود نمایید.</div>
                        <div id="uploadedSectionMadarek_##idx##" class="uploadPicSection">
                            <div id="showUploadPicsSectionMadarek_##idx##" class="showUploadedFiles"></div>
                            <div id="uploadPicInfoTextMadarek_##idx##" class="uploadPic">
                                <label class="labelForClick" for="madarekPics_##idx##">کلیک کنید</label>
                            </div>
                            <input type="file" accept="image/*" id="madarekPics_##idx##" style="display: none"
                                onchange="var tmpIdx = initUploader('madarek_##idx##', 'showUploadPicsSectionMadarek_##idx##', 'uploadPicInfoTextMadarek_##idx##', 2); if(tmpIdx != -1) uploadPicClickHandler(this, tmpIdx)">
                        </div>
                    </div>
                </div>

                <button data-val="##idx##" class="delete deleteButton">حذف عضو</button>
            </div>
        </div>
    @endsection

    @section('modals')

        <center id="globalSearch" class="globalSearchBlackBackGround hidden">
            <div class="row" style="width: 100%; display: flex; align-items: center; flex-direction: column">

                <div class="globalSearchWithBox" style="margin-top: 20px">

                    <div style="display: inline-block" class="icons iconClose globalSearchCloseIcon"
                        onclick="closeSearchInput()"></div>
                    <input id="globalSearchInput" type="text" class="globalSearchInputField" placeholder=""
                        onkeyup="" autocomplete="off">

                    <div class="row" style="width: 100%; margin-top: 20px">
                        <div id="globalSearchResult" class="data_holder globalSearchResult"></div>
                    </div>
                </div>
            </div>
        </center>

    @endsection

    @section('script')

        <script src="{{ \Illuminate\Support\Facades\URL::asset('BusinessPanelPublic/js/jsNeededForCreate.js') }}"></script>
        <script src="{{ \Illuminate\Support\Facades\URL::asset('BusinessPanelPublic/js/jsNeededForMadareks.js') }}"></script>

        <script async
            src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyCdVEd4L2687AfirfAnUY1yXkx-7IsCER0&callback=initMap">
        </script>

        <script>
            isHaghighi = true;
            openLoading();

            setTimeout(closeLoading, 1000);

            if (!$('#hoghoghi').is(':checked')) {
                isHaghighi = false
            }
            if (!$('#haghighi').is(':checked')) {
                isHaghighi = false
            }
            @if (isset($business))
                openLoading();
                currentPage = parseInt('{{ $step }}');
                $("#step3Back").remove();
                mode = "edit";
                created = true;
                currProgress = currentPage * 10;
                fillDataArr({!! json_encode($business) !!});
            @else
                $("#step1").removeClass('hidden');
                render_a_form(0);
                busy_idx[0] = true;
            @endif

            function fillDataArr(arr) {

                data = arr;
                if (data.haghighi) {
                    $(".hogh").addClass('hidden');
                    $(".hagh").removeClass('hidden');
                    $("#name").val(data.name);
                    $("#nid").val(data.nid);
                } else {
                    $("#regularName").val(data.name);
                    $("#economyCode").val(data.economyCode);
                    $("#businessNID").val(data.nid);
                }

                if (data.type == "tour")
                    $("#workHour").addClass('hidden');
                else
                    $("#workHour").removeClass('hidden');

                $("#site").val(data.site);
                $("#mail").val(data.mail);
                $("#tel").val(data.tel);
                $("#insta").val(data.insta);
                $("#telegram").val(data.telegram);
                $("#introduction").val(data.introduction);

                if ('city' in data)
                    $("#city").val(data.city);

                $("#cityId").val(data.cityId);

                if (data.fullOpen) {
                    $("#allDay24").attr('checked', true);
                } else {

                    $("#inWeekDayStart").val(data.inWeekOpenTime);
                    $("#inWeekDayEnd").val(data.inWeekCloseTime);

                    if (!data.afterClosedDayIsOpen) {
                        $("#afterClosedDayButton").prop('checked', true);
                        iAmClose($("#afterClosedDayButton"));
                    } else {
                        $("#afterClosedDayStart").val(data.afterClosedDayOpenTime);
                        $("#afterClosedDayEnd").val(data.afterClosedDayCloseTime);
                    }

                }

                if (!data.closedDayIsOpen) {
                    $("#closedDayButton").prop('checked', true);
                    iAmClose($("#closedDayButton"));
                } else {
                    $("#closedDayStart").val(data.closedDayOpenTime);
                    $("#closedDayEnd").val(data.closedDayCloseTime);
                }

                iAm24Hour();
                $("#address").val(data.address);

                if (data.hasAdditionalValue) {
                    $("#additionalValue").prop("checked", true);
                    changeAdditionalValue();
                }

                $("#shaba").val(data.shaba);
                $("#expire").val(data.expireAdditionalValue);
                var tmpIdx, code, index;

                if (data.additionalValue != null && data.additionalValue != "null" &&
                    data.additionalValue.length > 0) {
                    tmpIdx = initUploader('additionalValue', 'showUploadPicsSection', 'uploadPicInfoText', 1);
                    code = Math.floor(Math.random() * 1000);
                    index = uploaders[tmpIdx][4].push({
                        image: "{{ \Illuminate\Support\Facades\URL::asset('storage') }}/" + data.additionalValue,
                        serverPicId: -1,
                        uploaded: 1,
                        code: code
                    });
                    createNewImgUploadCard(index - 1, tmpIdx);
                    $('#uplaodedImg_' + code).find('.processCounter').text('100%');
                }

                if (data.logo != null && data.logo != "null" && data.logo.length > 0) {
                    tmpIdx = initUploader('logo', 'showUploadPicsSection3', 'uploadPicInfoText3', 1);
                    code = Math.floor(Math.random() * 1000);
                    index = uploaders[tmpIdx][4].push({
                        image: "{{ \Illuminate\Support\Facades\URL::asset('storage') }}/" + data.logo,
                        serverPicId: -1,
                        uploaded: 1,
                        code: code
                    });
                    createNewImgUploadCard(index - 1, tmpIdx);
                    $('#uplaodedImg_' + code).find('.processCounter').text('100%');
                }

                if (data.pics.length > 0) {
                    tmpIdx = initUploader('pic', 'showUploadPicsSection2', 'uploadPicInfoText2', 4);
                    for (var t = 0; t < data.pics.length; t++) {
                        code = Math.floor(Math.random() * 1000);
                        index = uploaders[tmpIdx][4].push({
                            image: "{{ \Illuminate\Support\Facades\URL::asset('storage') }}/" + data.pics[t].pic,
                            serverPicId: data.pics[t].id,
                            uploaded: 1,
                            code: code
                        });
                        createNewImgUploadCard(index - 1, tmpIdx);
                        $('#uplaodedImg_' + code).find('.processCounter').text('100%');
                    }
                }

                if (data.madareks.length > 0) {
                    for (var z = 0; z < data.madareks.length; z++) {
                        idx = data.madareks[z].idx;
                        id_idx[idx] = data.madareks[z].id;
                        render_a_form(idx);
                        busy_idx[idx] = true;
                        $("#name_" + idx).val(data.madareks[z].name);
                        $("#role_" + idx).val(data.madareks[z].role);

                        tmpIdx = initUploader('madarek_' + idx, 'showUploadPicsSectionMadarek_' + idx,
                            'uploadPicInfoTextMadarek_' + idx, 2);

                        code = Math.floor(Math.random() * 1000);
                        index = uploaders[tmpIdx][4].push({
                            image: "{{ \Illuminate\Support\Facades\URL::asset('storage') }}/" + data.madareks[z].pic1,
                            serverPicId: 1,
                            uploaded: 1,
                            code: code
                        });
                        createNewImgUploadCard(index - 1, tmpIdx);
                        $('#uplaodedImg_' + code).find('.processCounter').text('100%');

                        code = Math.floor(Math.random() * 1000);
                        index = uploaders[tmpIdx][4].push({
                            image: "{{ \Illuminate\Support\Facades\URL::asset('storage') }}/" + data.madareks[z].pic2,
                            serverPicId: 2,
                            uploaded: 1,
                            code: code
                        });
                        createNewImgUploadCard(index - 1, tmpIdx);
                        $('#uplaodedImg_' + code).find('.processCounter').text('100%');
                    }
                } else {
                    render_a_form(0);
                    busy_idx[0] = true;
                }

                $("#step" + currentPage).removeClass('hidden');
                closeLoading();
            }

            function getLat(_lat, _lng) {
                _lat = parseFloat(_lat);
                _lng = parseFloat(_lng);

                if (marker != 0)
                    marker.setMap(null);
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(_lat, _lng),
                    map: map,
                });

                $('#lat').val(_lat);
                $('#lng').val(_lng);
            }

            function findMyLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition((position) => {
                        console.log("mooz");
                        var coordination = position.coords;
                        if (marker != 0)
                            marker.setMap(null);
                        marker = new google.maps.Marker({
                            position: new google.maps.LatLng(coordination.latitude, coordination.longitude),
                            map: map,
                        });
                        map.setCenter({
                            lat: coordination.latitude,
                            lng: coordination.longitude
                        });
                        map.setZoom(16);

                        $('#lat').val(coordination.latitude);
                        $('#lng').val(coordination.longitude);
                    });
                } else
                    console.log("Geolocation is not supported by this browser.");
            }

            function initMap() {

                var lat = 32.42056639964595;
                var lng = 54.00537109375;
                var zoom = 5;

                var mapOptions = {
                    zoom: zoom,
                    center: new google.maps.LatLng(lat, lng),
                    styles: [{
                        "featureType": "landscape",
                        "stylers": [{
                            "hue": "#FFA800"
                        }, {
                            "saturation": 0
                        }, {
                            "lightness": 0
                        }, {
                            "gamma": 1
                        }]
                    }, {
                        "featureType": "road.highway",
                        "stylers": [{
                            "hue": "#53FF00"
                        }, {
                            "saturation": -73
                        }, {
                            "lightness": 40
                        }, {
                            "gamma": 1
                        }]
                    }, {
                        "featureType": "road.arterial",
                        "stylers": [{
                            "hue": "#FBFF00"
                        }, {
                            "saturation": 0
                        }, {
                            "lightness": 0
                        }, {
                            "gamma": 1
                        }]
                    }, {
                        "featureType": "road.local",
                        "stylers": [{
                            "hue": "#00FFFD"
                        }, {
                            "saturation": 0
                        }, {
                            "lightness": 30
                        }, {
                            "gamma": 1
                        }]
                    }, {
                        "featureType": "water",
                        "stylers": [{
                            "hue": "#00BFFF"
                        }, {
                            "saturation": 6
                        }, {
                            "lightness": 8
                        }, {
                            "gamma": 1
                        }]
                    }, {
                        "featureType": "poi",
                        "stylers": [{
                            "hue": "#679714"
                        }, {
                            "saturation": 33.4
                        }, {
                            "lightness": -25.4
                        }, {
                            "gamma": 1
                        }]
                    }]
                };

                var mapElementSmall = document.getElementById('mapDiv');
                map = new google.maps.Map(mapElementSmall, mapOptions);

                var marker = null;

                if (zoom == 10) {
                    marker = new google.maps.Marker({
                        position: {
                            lat,
                            lng
                        }
                    });

                    marker.setMap(map);
                }

                google.maps.event.addListener(map, 'click', event => {
                    if (marker != null) {
                        marker.setMap(null);
                        marker = null;
                    }
                    getLat(event.latLng.lat(), event.latLng.lng());
                });

                if ("lat" in data && data.lat != null && data.lat != "null" &&
                    parseFloat(data.lat) > 0 && "lng" in data && data.lng != null &&
                    data.lng != "null" && parseFloat(data.lng) > 0) {
                    getLat(data.lat, data.lng);
                    zoom = 10;
                }
            }
        </script>

    @stop
