@extends('panelBusiness.layout.baseLayout')

@section('head')

    <title>عنوان</title>

    <style>

        .selected {
            background-color: #fcc15691;
        }

        .spIcons {
            display: inline-block;
        }

        .suggest {
            display: inline-block;
            cursor: pointer;
        }

        .globalSearchWithBox {
            width: 40%;
        }

        #globalSearchResult {
            width: 100%;
        }

        .resizeImgClass {
            width: 100% !important;
            height: auto !important;
        }
    </style>

    <link rel="stylesheet" href="{{URL::asset('css/pages/localShops/mainLocalShops.css?v='.$fileVersions)}}">
    <link rel="stylesheet" href="{{URL::asset('css/pages/business.css?v='.$fileVersions)}}">
    <link rel="stylesheet" href="{{URL::asset('packages/clockPicker/bootstrap-clockpicker.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('packages/clockPicker/jquery-clockpicker.min.css')}}">

    <script defer src="{{URL::asset('packages/clockPicker/jquery-clockpicker.min.js')}}"></script>
    <script defer src="{{URL::asset('packages/clockPicker/bootstrap-clockpicker.min.js')}}"></script>


    <style>

        .createBusinessPage .kindOfBusinessOwnerSection{
            width: 100%;
            height: 50px;
            border: 2px solid #7d7d7d;
            padding: 5px;
            position: relative;
            display: flex;
            align-items: center;
            cursor: pointer;
        }
        .createBusinessPage .kindOfBusinessOwnerSection .inputSec{
            width: 40px;
            border-left: 2px dashed black;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .createBusinessPage .kindOfBusinessOwnerSection .content{
            display: flex;
            align-items: center;
            height: 100%;
            justify-content: center;
            margin-right: 10px;
        }
        .createBusinessPage .kindOfBusinessOwnerSection .content > i{

        }
        .createBusinessPage .kindOfBusinessOwnerSection .content > p{
            margin: 0;
            margin-right: 10px;
        }

        .createBusinessPage .businessType{
            width: 100%;
            cursor: pointer;
            border: 2px solid #7d7d7d;
            padding: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
        }
        .createBusinessPage .businessType .picSection{
            float: right;
            width: 100px;
            height: 100px;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            border-radius: 10px;
        }
        .createBusinessPage .businessType .textSec{
            width: calc(100% - 100px);
            padding-right: 20px;
        }
        .createBusinessPage .businessType .textSec h5{
            font-weight: bold;
            margin: 0px;
        }
        .createBusinessPage .businessType .textSec p{
            margin: 0px;
            color: gray;
            font-size: 13px;
            margin-top: 5px;
        }
    </style>

    <script>
        var uploadPicBusinessBaseUrl = '{{url("uploadBusinessPic")}}';
        var deleteBusinessPicBaseUrl =  '{{url('deleteBusinessPic')}}';
        var doCreatePath = '{{route('businessPanel.doCreate')}}';
        var editPath = '{{url('businessEdit')}}';
        var updateBusinessInfo1BaseUrl = '{{url('updateBusinessInfo1')}}';
        var updateBusinessInfo2BaseUrl = '{{url('updateBusinessInfo2')}}';
        var updateBusinessInfo4BaseUrl = '{{url('updateBusinessInfo4')}}';
        var updateBusinessInfo5BaseUrl = '{{url('updateBusinessInfo5')}}';
        var getContractPath = '{{route('businessPanel.getContract')}}';
        var finalizeBusinessInfoBaeUrl = '{{url('finalizeBusinessInfo')}}';
        var myBusinessesPath = '{{route('businessPanel.myBusinesses')}}';
        var searchForCityPath = "{{route('searchForCity')}}";
        var deleteMadarekBaseUrl = "{{url('deleteBusinessMadarek')}}";
        var arr_nums = ["اول", "دوم", "سوم", "چهارم", "پنجم", "ششم", "هفتم", "هشتم", "نهم", "دهم"];
        var busy_idx = [false, false, false, false, false, false, false, false, false, false];
        var id_idx = [-1, -1, -1, -1, -1, -1, -1, -1, -1, -1];
        var data = { "type": "None", "additionalValue": false };
        var currentPage = 1;
        var currProgress = 10;
        var created = false;
        var mode = "create";
    </script>
@endsection

@section('body')
<div class="createBusinessPage">
    <div class="row indicator_step hidden" id="step1">
        <div class="col-md-12">

            <div class="mainBackWhiteBody">
                <div class="head">نوع ارائه دهنده</div>
                <div style="margin-top: 20px">
                    <h4>کسب و کار خود را چگونه توصیف می کنید؟</h4>
                    <p>با استفاده از این اطلاعات، ما دسترسی های مناسب تری برای شما ایجاد می کنیم.</p>

                    <div class="col-xs-12 col-md-6">
                        <label for="hoghoghi" class="kindOfBusinessOwnerSection">
                            <div class="inputSec">
                                <input id="hoghoghi" type="radio" name="haghHogh">
                            </div>
                            <div class="content">
                                <i class="fa fa-users"></i>
                                <p>ما یک کسب و کار هستیم. (شخصیت حقوقی)</p>
                            </div>
                        </label>
                    </div>

                    <div class="col-xs-12 col-md-6" style="margin-top: 10px">

                        <label for="haghighi" class="kindOfBusinessOwnerSection">
                            <div class="inputSec">
                                <input id="haghighi" type="radio" name="haghHogh">
                            </div>
                            <div class="content">
                                <i class="fa fa-user"></i>
                                <p>من یک شخص و یا گروه هستم. (شخصیت حقیقی)</p>
                            </div>
                        </label>
                    </div>

                    <div class="col-xs-12 fullyCenterContent" style="margin-top: 10px;">
                        <button onclick="goToPage(1, 10)" class="btn btn-success">مرحله بعد</button>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <div class="row indicator_step hidden" id="step2">

        <div class="col-md-12">

            <div class="mainBackWhiteBody">
                <div class="head">نوع خدمت قابل ارائه</div>
                <div style="margin-top: 20px">
                    <h4>مایل به ارائه چه نوع خدمتی هستید؟</h4>
                    <div>
                        <p>از بین گزینه های زیر یک گزینه را می توانید انتخاب کنید.</p>
                        <p>توجه کنید، این انتخاب بعدها قابل تغییر می باشد، اما به سبب گزینه های انتخاب شده، ما نیازمند اطلاعات مفصلی از شما هستیم و امکانات متفاوتی را در اختیار شما قرار می دهیم.</p>
                    </div>

                    <div class="col-xs-12 col-md-8">
                        <div data-type="agency" class="businessType">

                            <div class="picSection">
                                <img class="resizeImgClass" src="{{URL::asset('defaultPic/4.jpg')}}" onload="fitThisImg(this)">
                            </div>

                            <div class="textSec">
                                <h5>آژانس مسافرتی</h5>
                                <p>شما می توانید برای فروش تورهای خود از امکانات ما استفاده کنید.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-8" style="margin-top: 10px">
                        <div data-type="tour" class="businessType">
                            <div class="picSection">
                                <img class="resizeImgClass" src="{{URL::asset('defaultPic/4.jpg')}}" onload="fitThisImg(this)">
                            </div>

                            <div class="textSec">
                                <h5>تور لیدر</h5>
                                <p>شما می توانید برای معرفی خود به گردشگران از امکانات ما استفاده کنید.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-8" style="margin-top: 10px">
                        <div data-type="hotel" class="businessType">
                            <div class="picSection">
                                <img class="resizeImgClass" src="{{URL::asset('defaultPic/4.jpg')}}" onload="fitThisImg(this)">
                            </div>
                            <div class="textSec">
                                <h5>صاحب هتل</h5>
                                <p>شما می توانید کنترل صفحه خود را در دست گرفته و به صورت رسمی به کاربران پاسخ دهید.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-8" style="margin-top: 10px">
                        <div data-type="restaurant" class="businessType">
                            <div class="picSection">
                                <img class="resizeImgClass" src="{{URL::asset('defaultPic/4.jpg')}}" onload="fitThisImg(this)">
                            </div>
                            <div class="textSec">
                                <h5>صاحب رستوران، فست فود و ...</h5>
                                <p>شما می توانید کنترل صفحه خود را در دست گرفته و به صورت رسمی به کاربران پاسخ دهید.</p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-xs-12 fullyCenterContent" style="margin-top: 20px; margin-bottom: 100px">
                    <button onclick="goToPage(1, 10)" class="btn btn-success">مرحله بعد</button>
                    <button onclick="goToPage(-1, -10)" class="btn btn-danger">مرحله قبل</button>
                </div>

            </div>

        </div>
    </div>

    <div class="row indicator_step hidden" id="step3">

        <div class="col-md-12">

            <div class="mainBackWhiteBody">

                <div class="head">اطلاعات کسب و کار</div>

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
                                <input type="text" id="businessNID" onkeypress="justNum(event)" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6 hagh hidden">
                            <div class="form-group">
                                <label for="nid">شماره ملی</label>
                                <input type="text" id="nid" onkeypress="justNum(event)" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6 hogh">
                            <div class="form-group">
                                <label for="economyCode">شماره اقتصادی</label>
                                <input type="text" onkeypress="justNum(event)" id="economyCode" class="form-control">
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
                                <input type="text" id="tel" onkeypress="justNum(event)" class="form-control">
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

                <center class="col-xs-12" style="margin-top: 20px; margin-bottom: 100px">

                    <button onclick="goToPage(1, 10)" class="btn btn-success">مرحله بعد</button>

                    <button onclick="goToPage(-1, -10)" id="step3Back" class="btn btn-danger">مرحله قبل</button>

                </center>

            </div>

        </div>
    </div>

    <div class="row indicator_step hidden" id="step4">

        <div class="col-md-12">

            <div class="mainBackWhiteBody">
                <div class="head">اطلاعات محل کسب و کار</div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-sm-12 form-group importantInput">
                                <label for="city" style="padding-top: 27px;">شهر</label>
                                <input type="text" class="form-control mustFull" id="city" placeholder="نام شهر خود را وارد نمایید..." onclick="openSearchFindCity()" readonly>
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
                                <img src="{{URL::asset('images/icons/myLocation.svg')}}">
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-md-12" id="workHour">
                    <div class="descriptionText">با پر کردن اطلاعات این بخش به مشتریان خود کمک کنید.</div>
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
                                                <input class="form-control" id="inWeekDayStart" type="text" placeholder="انتخاب کنید">
                                            </div>
                                            <div class="smTex">تا ساعت </div>
                                            <div class="timePicker clockpicker">
                                                <input class="form-control" id="inWeekDayEnd" type="text" placeholder="انتخاب کنید">
                                            </div>
                                        </div>
                                    </div>

                                    <div id="closedBeforeDayDiv" class="timeRow">
                                        <div class="text">روز های قبل تعطیلی: </div>
                                        <div style="display: flex; align-items: center;">
                                            <div class="smTex">از ساعت </div>
                                            <div class="timePicker clockpicker">
                                                <input class="form-control" id="afterClosedDayStart" type="text" placeholder="انتخاب کنید">
                                            </div>
                                            <div class="smTex">تا ساعت </div>
                                            <div class="timePicker clockpicker">
                                                <input class="form-control" id="afterClosedDayEnd" type="text" placeholder="انتخاب کنید">
                                            </div>
                                        </div>

                                        <label class="openCloseInputDiv" for="afterClosedDayButton">
                                            <input type="checkbox" id="afterClosedDayButton" onchange="iAmClose(this)">
                                            <div class="openCloseInputShow"></div>
                                        </label>
                                    </div>
                                    <div id="closedDayDiv" class="timeRow">
                                        <div class="text">روز های تعطیلی: </div>

                                        <div style="display: flex; align-items: center;">
                                            <div class="smTex">از ساعت </div>
                                            <div class="timePicker clockpicker">
                                                <input class="form-control" id="closedDayStart" type="text" placeholder="انتخاب کنید">
                                            </div>
                                            <div class="smTex">تا ساعت </div>
                                            <div class="timePicker clockpicker">
                                                <input class="form-control" id="closedDayEnd" type="text" placeholder="انتخاب کنید">
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

                <center class="col-xs-12" style="margin-top: 20px; margin-bottom: 100px">

                    <button onclick="goToPage(1, 10)" class="btn btn-success">مرحله بعد</button>

                    <button onclick="goToPage(-1, -10)" class="btn btn-danger">مرحله قبل</button>

                </center>

            </div>

        </div>
    </div>

    <div class="row indicator_step createBusinessStep5 hidden" id="step5">

        <div class="col-md-12">
            <div class="mainBackWhiteBody">
                <div class="head">مدارک مورد نیاز</div>
                <style>
                    .createBusinessPage .createBusinessStep5 .numOfUserInBusiness{
                        padding: 3px 0 10px 30px;
                        font-size: 15px;
                        width: 50%;
                    }
                </style>
                <div class="col-md-12">
                    <div class="numOfUserInBusiness form-group">
                        <label for="numOfMembers">تعداد سهام داران</label>
                        <select id="numOfMembers" class="signInInput form-control" name="numOfMembers">
                            @for($i = 1; $i < 11; $i++)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="col-md-12" id="usersDiv"></div>

                <div class="col-xs-12 fullyCenterContent" style="margin-top: 20px; margin-bottom: 100px">
                    <button onclick="goToPage(1, 10)" class="btn btn-success">مرحله بعد</button>
                    <button onclick="goToPage(-1, -10)" class="btn btn-danger">مرحله قبل</button>
                </div>

            </div>

        </div>
    </div>

    <div class="row indicator_step hidden" id="step6">

        <div class="col-md-12">

            <div class="mainBackWhiteBody">

                <div class="head">اطلاعات مالی</div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="additionalValue" style="cursor: pointer;">آیا شما مشمول مالیات بر ارزش افزوده هستید؟</label>
                        <input type="checkbox" id="additionalValue" onchange="changeAdditionalValue()">
                    </div>
                </div>

                <div class="col-md-6 additionalValue hidden">
                    <div class="form-group">
                        <label for="expire">تاریخ انقضا گواهی ارزش افزوده</label>
                        <input style="direction: ltr; text-align: left" type="text" onkeydown="validateDate(event, 'expire')" placeholder="____ / __ / __" id="expire">
                    </div>
                </div>

                <div class="col-md-6 additionalValue hidden">
                    <div class="boldDescriptionText" style="color: var(--koochita-green);">تصویر گواهی ارزش افزوده</div>
                    <div id="uploadedSection" class="uploadPicSection">
                        <div id="showUploadPicsSection" class="showUploadedFiles"></div>
                        <div id="uploadPicInfoText" class="uploadPic">
                            <img src="{{URL::asset('images/icons/uploadPic.png')}}">
                            <div>عکس های خود را در اینجا قرار دهید </div>
                            <div style="margin-top: 10px; font-weight: bold;"> و یا </div>
                        </div>
                        <label class="labelForClick" for="additionalValuePics">کلیک کنید</label>
                    </div>
                    <input type="file" accept="image/*" id="additionalValuePics" style="display: none" onchange="var tmpIdx = initUploader('additionalValue', 'showUploadPicsSection', 'uploadPicInfoText', 1); if(tmpIdx != -1) uploadPicClickHandler(this, tmpIdx)">
                </div>

                <div class="col-md-12" style="margin-top: 20px">
                    <div class="form-group">
                        <label for="shaba">شماره شبا</label>
                        <input style="width: 400px" type="text" onkeypress="justNum(event)" id="shaba">
                    </div>
                </div>

                <center class="col-xs-12" style="margin-top: 20px; margin-bottom: 100px">

                    <button onclick="goToPage(1, 10)" class="btn btn-success">مرحله بعد</button>

                    <button onclick="goToPage(-1, -10)" class="btn btn-danger">مرحله قبل</button>

                </center>

            </div>

        </div>
    </div>

    <div class="row indicator_step hidden" id="step7">

        <div class="col-md-12">

            <div class="mainBackWhiteBody">

                <div class="head">عکس کسب و کار شما</div>

                <div class="col-md-6">
                    <div class="boldDescriptionText" style="color: var(--koochita-green);">حداقل یک عکس از کسب و کار خود وارد نمایید.</div>
                    <div class="descriptionText">عکس شما نباید دارای واترمارک بوده و یا از محلی غیر از کسب و کار شما باشد.</div>
                    <div id="uploadedSection2" class="uploadPicSection">
                        <div id="showUploadPicsSection2" class="showUploadedFiles"></div>
                        <div id="uploadPicInfoText2" class="uploadPic">
                            <img src="{{URL::asset('images/icons/uploadPic.png')}}">
                            <div>عکس های خود را در اینجا قرار دهید </div>
                            <div style="margin-top: 10px; font-weight: bold;"> و یا </div>
                        </div>
                        <label class="labelForClick" for="pics2">کلیک کنید</label>
                    </div>
                    <input type="file" accept="image/*" id="pics2" style="display: none" onchange="var tmpIdx = initUploader('pic', 'showUploadPicsSection2', 'uploadPicInfoText2', 4); if(tmpIdx != -1) uploadPicClickHandler(this, tmpIdx)">
                </div>


                <div class="col-md-6">
                    <div class="boldDescriptionText" style="color: var(--koochita-green);">تصویر لوگو یا تصویر شما</div>
                    <div class="descriptionText">اگر لوگو خود را بدون زمینه و در فرمت PNG بارگذاری کنید، صفحه زیباتری خواهید داشت.</div>
                    <div id="uploadedSection3" class="uploadPicSection">
                        <div id="showUploadPicsSection3" class="showUploadedFiles"></div>
                        <div id="uploadPicInfoText3" class="uploadPic">
                            <img src="{{URL::asset('images/icons/uploadPic.png')}}">
                            <div>عکس های خود را در اینجا قرار دهید </div>
                            <div style="margin-top: 10px; font-weight: bold;"> و یا </div>
                        </div>
                        <label class="labelForClick" for="logoPics">کلیک کنید</label>
                    </div>
                    <input type="file" accept="image/*" id="logoPics" style="display: none" onchange="var tmpIdx = initUploader('logo', 'showUploadPicsSection3', 'uploadPicInfoText3', 1); if(tmpIdx != -1) uploadPicClickHandler(this, tmpIdx)">
                </div>

                <center class="col-xs-12" style="margin-top: 20px; margin-bottom: 100px">

                    <button onclick="goToPage(1, 10)" class="btn btn-success">مرحله بعد</button>

                    <button onclick="goToPage(-1, -10)" class="btn btn-danger">مرحله قبل</button>

                </center>

            </div>

        </div>
    </div>

    <div class="row indicator_step hidden" id="step8">

        <div class="col-md-12">

            <div class="mainBackWhiteBody">
                <div class="head">قرارداد همکاری</div>
                <div style="margin-top: 20px">

                    <div class="col-xs-12" style="margin-top: 10px">

                        <div class="col-xs-12 col-md-8">

                            <div onscroll="scrolled(event)" style="width: 100%; height: 200px; overflow: auto; border: 2px solid #7d7d7d; padding: 5px" id="contract"></div>

                            <div style="width: 100%; margin-top: 20px">
                                <label for="confirmContract" style="cursor: pointer;">تمامی مطالب را با دقت مطالعه کردم و همگی را قبول دارم.</label>
                                <input type="checkbox" id="confirmContract" disabled>
                            </div>

                        </div>
                    </div>

                </div>

                <center class="col-xs-12" style="margin-top: 20px; margin-bottom: 100px">

                    <button onclick="goToPage(1, 10)" class="btn btn-success">تایید نهایی</button>

                    <button onclick="goToPage(-1, -10)" class="btn btn-danger">مرحله قبل</button>

                </center>

            </div>

        </div>
    </div>


    <style>
        .shareHolderCard{
            background-color: #fcc1560f;
            padding: 10px;
            border-radius: 5px;
            border: solid 1px var(--koochita-yellow);
            margin-bottom: 30px;
        }
        .shareHolderCard > .title{
            font-size: 19px;
            width: 100%;
            color: #aa0800;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .shareHolderCard > .content{
            display: flex;
            justify-content: space-between;
        }

        .shareHolderCard .deleteButton{
            cursor: pointer;
            background: var(--koochita-red);
            color: white;
            padding: 2px 5px;
            border-radius: 3px;
            border: none;
            margin-right: auto;
            display: flex;
            margin-top: 10px;
        }
        .shareHolderCard .content .inputRow{
            width: 49%;
        }
        .shareHolderCard .content .picSec{
            width: 49%;
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
        }
        .shareHolderCard .picSec .uploadPicSection{
            height: 200px;
            width: 100%;
            border: solid 1px #c7c7c7;
            flex-wrap: wrap;
            padding: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            cursor: pointer;
            background-color: white;
        }
        .shareHolderCard .picSec > .title{
            color: var(--koochita-green);
            font-size: 12px;
            text-align: center;
            margin-bottom: 10px;
        }
        .shareHolderCard .uploadPicSection .labelForClick{
            cursor: pointer;
            z-index: 99;
            font-weight: bold;
            font-size: 24px;
            text-align: center;
            width: 100%;
            color: black;
        }
        .shareHolderCard .uploadPicSection .uploadPic{
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0px auto;
            flex-direction: column;
            font-size: 18px;
            color: black;
            opacity: 1;
        }
    </style>

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
                        <input type="file" accept="image/*" id="madarekPics_##idx##" style="display: none" onchange="var tmpIdx = initUploader('madarek_##idx##', 'showUploadPicsSectionMadarek_##idx##', 'uploadPicInfoTextMadarek_##idx##', 2); if(tmpIdx != -1) uploadPicClickHandler(this, tmpIdx)">
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

                <div style="display: inline-block" class="icons iconClose globalSearchCloseIcon" onclick="closeSearchInput()"></div>
                <input id="globalSearchInput" type="text" class="globalSearchInputField" placeholder="" onkeyup="" autocomplete="off">

                <div class="row" style="width: 100%; margin-top: 20px">
                    <div id="globalSearchResult" class="data_holder globalSearchResult"></div>
                </div>
            </div>
        </div>
    </center>

@endsection

@section('script')

    <script src="{{\Illuminate\Support\Facades\URL::asset('BusinessPanelPublic/js/jsNeededForCreate.js')}}"></script>
    <script src="{{\Illuminate\Support\Facades\URL::asset('BusinessPanelPublic/js/jsNeededForMadareks.js')}}"></script>

    <script async src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyCdVEd4L2687AfirfAnUY1yXkx-7IsCER0&callback=initMap"></script>

    <script>

        @if(isset($business))
            openLoading();
            currentPage = parseInt('{{$step}}');
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
            if(data.haghighi) {
                $(".hogh").addClass('hidden');
                $(".hagh").removeClass('hidden');
                $("#name").val(data.name);
                $("#nid").val(data.nid);
            }
            else {
                $("#regularName").val(data.name);
                $("#economyCode").val(data.economyCode);
                $("#businessNID").val(data.nid);
            }

            if(data.type == "tour")
                $("#workHour").addClass('hidden');
            else
                $("#workHour").removeClass('hidden');

            $("#site").val(data.site);
            $("#mail").val(data.mail);
            $("#tel").val(data.tel);
            $("#insta").val(data.insta);
            $("#telegram").val(data.telegram);
            $("#introduction").val(data.introduction);

            if('city' in data)
                $("#city").val(data.city);

            $("#cityId").val(data.cityId);

            if(data.fullOpen) {
                $("#allDay24").attr('checked', true);
            }
            else {

                $("#inWeekDayStart").val(data.inWeekOpenTime);
                $("#inWeekDayEnd").val(data.inWeekCloseTime);

                if(!data.afterClosedDayIsOpen) {
                    $("#afterClosedDayButton").prop('checked', true);
                    iAmClose($("#afterClosedDayButton"));
                }
                else {
                    $("#afterClosedDayStart").val(data.afterClosedDayOpenTime);
                    $("#afterClosedDayEnd").val(data.afterClosedDayCloseTime);
                }

            }

            if(!data.closedDayIsOpen) {
                $("#closedDayButton").prop('checked', true);
                iAmClose($("#closedDayButton"));
            }
            else {
                $("#closedDayStart").val(data.closedDayOpenTime);
                $("#closedDayEnd").val(data.closedDayCloseTime);
            }

            iAm24Hour();
            $("#address").val(data.address);

            if(data.hasAdditionalValue) {
                $("#additionalValue").prop("checked", true);
                changeAdditionalValue();
            }

            $("#shaba").val(data.shaba);
            $("#expire").val(data.expireAdditionalValue);
            var tmpIdx, code, index;

            if(data.additionalValue != null && data.additionalValue != "null" &&
                data.additionalValue.length > 0) {
                tmpIdx = initUploader('additionalValue', 'showUploadPicsSection', 'uploadPicInfoText', 1);
                code = Math.floor(Math.random() * 1000);
                index = uploaders[tmpIdx][4].push({
                    image: "{{\Illuminate\Support\Facades\URL::asset('storage')}}/" + data.additionalValue,
                    serverPicId: -1,
                    uploaded: 1,
                    code: code
                });
                createNewImgUploadCard(index - 1, tmpIdx);
                $('#uplaodedImg_' + code).find('.processCounter').text('100%');
            }

            if(data.logo != null && data.logo != "null" && data.logo.length > 0) {
                tmpIdx = initUploader('logo', 'showUploadPicsSection3', 'uploadPicInfoText3', 1);
                code = Math.floor(Math.random() * 1000);
                index = uploaders[tmpIdx][4].push({
                    image: "{{\Illuminate\Support\Facades\URL::asset('storage')}}/" + data.logo,
                    serverPicId: -1,
                    uploaded: 1,
                    code: code
                });
                createNewImgUploadCard(index - 1, tmpIdx);
                $('#uplaodedImg_' + code).find('.processCounter').text('100%');
            }

            if(data.pics.length > 0) {
                tmpIdx = initUploader('pic', 'showUploadPicsSection2', 'uploadPicInfoText2', 4);
                for(var t = 0; t < data.pics.length; t++) {
                    code = Math.floor(Math.random() * 1000);
                    index = uploaders[tmpIdx][4].push({
                        image: "{{\Illuminate\Support\Facades\URL::asset('storage')}}/" + data.pics[t].pic,
                        serverPicId: data.pics[t].id,
                        uploaded: 1,
                        code: code
                    });
                    createNewImgUploadCard(index - 1, tmpIdx);
                    $('#uplaodedImg_' + code).find('.processCounter').text('100%');
                }
            }

            if(data.madareks.length > 0) {
                for (var z = 0; z < data.madareks.length; z++) {
                    idx = data.madareks[z].idx;
                    id_idx[idx] = data.madareks[z].id;
                    render_a_form(idx);
                    busy_idx[idx] = true;
                    $("#name_" + idx).val(data.madareks[z].name);
                    $("#role_" + idx).val(data.madareks[z].role);

                    tmpIdx = initUploader('madarek_' + idx, 'showUploadPicsSectionMadarek_' + idx, 'uploadPicInfoTextMadarek_' + idx, 2);

                    code = Math.floor(Math.random() * 1000);
                    index = uploaders[tmpIdx][4].push({
                        image: "{{\Illuminate\Support\Facades\URL::asset('storage')}}/" + data.madareks[z].pic1,
                        serverPicId: 1,
                        uploaded: 1,
                        code: code
                    });
                    createNewImgUploadCard(index - 1, tmpIdx);
                    $('#uplaodedImg_' + code).find('.processCounter').text('100%');

                    code = Math.floor(Math.random() * 1000);
                    index = uploaders[tmpIdx][4].push({
                        image: "{{\Illuminate\Support\Facades\URL::asset('storage')}}/" + data.madareks[z].pic2,
                        serverPicId: 2,
                        uploaded: 1,
                        code: code
                    });
                    createNewImgUploadCard(index - 1, tmpIdx);
                    $('#uplaodedImg_' + code).find('.processCounter').text('100%');
                }
            }
            else {
                render_a_form(0);
                busy_idx[0] = true;
            }

            $("#step" + currentPage).removeClass('hidden');
            closeLoading();
        }

        function getLat(_lat, _lng){
            _lat = parseFloat(_lat);
            _lng = parseFloat(_lng);

            if(marker != 0)
                marker.setMap(null);
            marker = new google.maps.Marker({
                position:  new google.maps.LatLng(_lat, _lng),
                map: map,
            });

            $('#lat').val(_lat);
            $('#lng').val(_lng);
        }

        function findMyLocation() {
            if (navigator.geolocation)
                navigator.geolocation.getCurrentPosition((position) => {
                    var coordination = position.coords;
                    if(marker != 0)
                        marker.setMap(null);
                    marker = new google.maps.Marker({
                        position:  new google.maps.LatLng(coordination.latitude, coordination.longitude),
                        map: map,
                    });
                    map.setCenter({
                        lat : coordination.latitude,
                        lng : coordination.longitude
                    });
                    map.setZoom(16);

                    $('#lat').val(coordination.latitude);
                    $('#lng').val(coordination.longitude);
                });
            else
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
                    "stylers": [{"hue": "#FFA800"}, {"saturation": 0}, {"lightness": 0}, {"gamma": 1}]
                }, {
                    "featureType": "road.highway",
                    "stylers": [{"hue": "#53FF00"}, {"saturation": -73}, {"lightness": 40}, {"gamma": 1}]
                }, {
                    "featureType": "road.arterial",
                    "stylers": [{"hue": "#FBFF00"}, {"saturation": 0}, {"lightness": 0}, {"gamma": 1}]
                }, {
                    "featureType": "road.local",
                    "stylers": [{"hue": "#00FFFD"}, {"saturation": 0}, {"lightness": 30}, {"gamma": 1}]
                }, {
                    "featureType": "water",
                    "stylers": [{"hue": "#00BFFF"}, {"saturation": 6}, {"lightness": 8}, {"gamma": 1}]
                }, {
                    "featureType": "poi",
                    "stylers": [{"hue": "#679714"}, {"saturation": 33.4}, {"lightness": -25.4}, {"gamma": 1}]
                }]
            };

            var mapElementSmall = document.getElementById('mapDiv');
            map = new google.maps.Map(mapElementSmall, mapOptions);

            var marker = null;

            if(zoom == 10) {
                marker = new google.maps.Marker({
                    position: {lat, lng}
                });

                marker.setMap(map);
            }

            google.maps.event.addListener(map, 'click', event => {
                if(marker != null) {
                    marker.setMap(null);
                    marker = null;
                }
                getLat(event.latLng.lat(), event.latLng.lng());
            });

            if("lat" in data && data.lat != null && data.lat != "null" &&
                parseFloat(data.lat) > 0 && "lng" in data && data.lng != null &&
                data.lng != "null" && parseFloat(data.lng) > 0) {
                getLat(data.lat, data.lng);
                zoom = 10;
            }
        }


    </script>

@stop
