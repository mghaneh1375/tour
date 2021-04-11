@extends('layouts.bodyPlace')

@section('header')
    @parent
    <title>معرفی مطلب جدید</title>

    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/photo_albums_stacked.css?v=1')}}'/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/media_albums_extended.css?v=1')}}'/>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/theme2/popUp.css?v=1')}}">
    <link rel="stylesheet" href="{{URL::asset('css/theme2/help.css?v=1')}}">
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/icons.css?v=2')}}' />
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/addPlaceByUser.css?v=1')}}' />
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/abbreviations.css?v=1')}}' />

    <link rel="stylesheet" href="{{URL::asset('css/pages/addPlaceByUser.css?v=1')}}">

    <link rel="stylesheet" href="{{asset('packages/dropzone/basic.css?v=1')}}">
    <link rel="stylesheet" href="{{asset('packages/dropzone/dropzone.css?v=1')}}">

    <link rel="stylesheet" href="{{URL::asset('packages/leaflet/leaflet.css')}}">

    @if(app()->getLocale() == 'en')
        <link rel="stylesheet" href="{{URL::asset('css/pages/ltr/addPlaceByUser.css?v=1')}}">
    @endif

    <style>
        .myLocationIcon{
            background: var(--koochita-yellow);
            color: white;
            width: 60px;
            display: flex;
            height: 60px;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            position: absolute;
            left: 10px;
            bottom: 10px;
            cursor: pointer;
            z-index: 999;
            animation: glowing 2s infinite;
        }

        @keyframes glowing {
            0% {
                background: #ffdda0;
            }
            50%{
                background: var(--koochita-yellow);
            }
            100% {
                background: #ffdda0;
            }
        }
    </style>

@stop

@section('main')
    <div class="container">
        <div class="bodyStyle">

            <div class="textTopHeader">
                امروز از هم جداییم ، اما برای فردای با هم بودن تلاش می کنیم
            </div>

            <div class="box">

                <div class="topSection">

                    <div class="headerOfBox">
                        <div class="textTopTopHeader">
                            معرفی و تبلیغ فعالیت شما به تمامی علاقه مندان به سفر
                        </div>

                        <div class="stepsMilestoneMainDiv">
                            <div class="dotDiv">
                                <div id="stepName">اولین مرحله</div>
                                <div style="position: relative">
                                    <div data-val="1" class="steps bigCircle completeStep"></div>
                                    <div data-val="1" class="steps middleCircle"></div>
                                    <div data-val="1" class="steps littleCircle completeStep"></div>
                                </div>

                                <div class="lineBetweenDot"></div>

                                <div style="position: relative">
                                    <div data-val="2" class="steps bigCircle"></div>
                                    <div data-val="2" class="steps middleCircle"></div>
                                    <div data-val="2" class="steps littleCircle"></div>
                                </div>

                                <div class="lineBetweenDot"></div>

                                <div style="position: relative">
                                    <div data-val="3" class="steps bigCircle"></div>
                                    <div data-val="3" class="steps middleCircle"></div>
                                    <div data-val="3" class="steps littleCircle"></div>
                                </div>

                                <div class="lineBetweenDot"></div>

                                <div style="position: relative">
                                    <div data-val="4" class="steps bigCircle"></div>
                                    <div data-val="4" class="steps middleCircle"></div>
                                    <div data-val="4" class="steps littleCircle"></div>
                                </div>

                                <div class="lineBetweenDot"></div>

                                <div style="position: relative">
                                    <div data-val="5" class="steps bigCircle"></div>
                                    <div data-val="5" class="steps middleCircle"></div>
                                    <div data-val="5" class="steps littleCircle"></div>
                                </div>

                                <div class="lineBetweenDot"></div>

                                <div style="position: relative">
                                    <div data-val="6" class="steps bigCircle"></div>
                                    <div data-val="6" class="steps middleCircle"></div>
                                    <div data-val="6" class="steps littleCircle"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bodyOfBox">
                        <div class="step1 stepHeader">
                            <div class="stepTitle">
                                پس از شیوع کرونا و با توجه به مشکلاتی که برای کسب و کار ها در حوزه سفر و گردشگری ایجاد شده ، تصمیم گرفتیم که بستری را به صورت رایگان فراهم کنیم تا صاحبان مشاغل و ایران گردان به معرفی کسب و کار خود و معرفی ایران عزیزمان بپردازید. لطفا در چند مرحله ساده، به پرسش های ما پاسخ دهید
                            </div>
                        </div>
                        <div class="step2 stepHeader hidden">
                            <div class="stepTitle">لطفا اطلاعات پایه را وارد نمایید</div>
                            <div class="boxNotice">وارد نمودن اطلاعات ستاره دار اجباری است</div>
                        </div>
                        <div class="step3 stepHeader hidden">
                            <div id="step3MainTitle" class="stepTitle">مهم ترین بخش ، توصیف <span class="headerCategoryName"></span> است</div>
                            <div id="step3MainUnderTitle" class="boxNotice">از بین گزینه های زیر، مواردی را که <span class="headerCategoryName"></span> را توصیف می نماید اضافه کنید. سپاسگذاریم.</div>
                        </div>
                        <div class="step4 stepHeader hidden">
                            <div id="step4MainTitle" class="stepTitle">اگر توضیحات خاصی در مورد <span class="headerCategoryName"></span> دارید در این قسمت با ما در میان بگذارید</div>
                        </div>
                        <div class="step5 stepHeader hidden">
                            <div id="step5MainTitle" class="stepTitle">
                                اگر عکسی از
                                <span class="headerCategoryName"></span>
                                دارید آن را بارگذاری نمایید
                            </div>
                            <div class="boxNotice">
                                شما می توانید به هر تعداد عکس که در اختیار دارید آپلود نمایید. در این صورت علاوه بر امتیاز تعریف و یا ویرایش مکان، امتیاز عکس نیز به شما تعلق می گیرد
                            </div>
                        </div>
                        <div class="step6 stepHeader hidden">
                            <div class="stepTitle">
                                تمام اطلاعات به طور کامل دریافت شد. این اطلاعات پس از بررسی اعمال خواهد شد و امتیاز شما در پروفایل افزایش خواهد یافت. به ویرایش و اضافه کردن مقصد های جدید ادامه دهید تا علاوه بر افزایش امتیاز، نشان های افتخار متفاوتی برنده شوید
                            </div>
                        </div>


                        <div class="selectCategoryDiv hidden">
                            <div class="headerCategoryIcon icons iconOfSelectCategory"></div>
                            <div class="headerCategoryName nameOfSelectCategory"></div>
                        </div>
                    </div>
                </div>

                <div class="bodySection">
                    <div class="step1 bodyOfSteps">
                        <div class="step1Header">لطفا دسته مناسب را با توجه به فعالیت خود انتخاب کنید</div>
                        <div id="selectCategoryDiv" class="text-align-center"></div>
                    </div>

                    <div class="step2 bodyOfSteps hidden">
                        <div class="inputFliedRow inputFlied">
                            <div class="icons stepInputIconRequired redStar"></div>
                            <div class="stepInputBox">
                                <div class="stepInputBoxText">
                                    <div class="stepInputBoxRequired">
                                        نام
                                        <span class="headerCategoryName"></span>
                                    </div>
                                </div>
                                <input class="stepInputBoxInput" id="name">
                            </div>
                        </div>

                        <div class="inputFliedRow">
                            <div class="inputFliedRow inputFlied">
                                <div class="icons stepInputIconRequired redStar"></div>
                                <div class="stepInputBox">
                                    <div style="display: flex; align-items: center">
                                        <div class="stepInputBoxText">
                                            <div class="stepInputBoxRequired">استان</div>
                                        </div>
                                        <select class="stepInputBoxInput" name="state" id="state" onchange="changeState(this.value)" style="padding-left: 20px">
                                            <option id="noneState" value="0">استان را انتخاب کنید</option>
                                            @foreach($states as $item)
                                                <option value="{{$item->id}}">
                                                    {{$item->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="inputFliedRow inputFlied marginRight">
                                <div class="icons stepInputIconRequired redStar"></div>
                                <div class="stepInputBox float-left">
                                    <div class="stepInputBoxText">
                                        <div class="stepInputBoxRequired">شهر</div>
                                    </div>
                                    <input id="cityName" class="stepInputBoxInput" onclick="chooseCity()" readonly>
                                    <input id="cityId" type="hidden" value="0">
                                </div>
                            </div>
                        </div>

                        <div id="onlyForPlaces">
                            <div class="addressSection">
                                <div style="display: flex; justify-content: center; align-items: center">
                                    <div class="icons stepInputIconRequired redStar"></div>
                                    <textarea accept-charset="character_set" class="addresText" id="address" name="address" placeholder="آدرس دقیق محل را وارد نمایید - حداقل 100 کاراکتر" rows="2" style="font-size: 20px"></textarea>
                                </div>
                                <input type="hidden" name="lat" id="lat" value="0">
                                <input type="hidden" name="lng" id="lng" value="0">

                                <div class="overMapButton">
                                    <button class="btn btn-success mapButton" onclick="openMap()">محل را از روی نقشه مشخص کنید</button>
                                </div>

                                <div class="mg-tp-5" style="font-size: 15px; text-align: center">موقعیت موردنظر را بر روی نقشه پیدا نموده و پین را بر روی آن قرار دهید. (کلیک در کامپیوتر و لمس نقشه در گوشی)</div>
                            </div>

                            <div class="row inputFliedRow onlyForHotelsRestBoom ">
                                <div class="inputFliedRow inputFlied" style="display: flex; align-items: center">
                                    <div class="icons stepInputIconRequired redStar"></div>
                                    <div class="stepInputBox">
                                        <div class="stepInputBoxText">
                                            <div class="stepInputBoxRequired" style=" font-size: 13px; font-weight: bold;">
                                                تلفن ثابت
                                                <span class="headerCategoryName"></span>
                                            </div>
                                        </div>
                                        <input class="stepInputBoxInput" id="fixPhone">
                                    </div>
                                </div>

                                <div class="inputFliedRow inputFlied marginRight">
                                    <div class="stepInputBox">
                                        <div class="stepInputBoxText">
                                            <div class="stepInputBoxRequired" style=" font-weight: bold; font-size: 13px;">تلفن همراه</div>
                                        </div>
                                        <div>
                                            <input class="stepInputBoxInput" id="phone" placeholder="09xxxxxxxxx" style="text-align: right; padding-right: 15px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="stepNotice onlyForHotelsRestBoom">شماره را همانگونه که با موبایل خود تماس می گیرید وارد نمایید. در صورت وجود بیش از یک شماره با استفاده از - شماره ها را جدا نمایید</div>

                            <div class="row inputFliedRow onlyForHotelsRest" style="margin-top: 20px;">
                                <div class="inputFliedRow inputFlied">
                                    <div class="stepInputBox">
                                        <div class="stepInputBoxText">
                                            <div class="stepInputBoxRequired">سایت</div>
                                        </div>
                                        <input class="stepInputBoxInput" id="website" type="url">
                                    </div>
                                </div>
                                <div class="inputFliedRow inputFlied marginRight">
                                    <div class="stepInputBox">
                                        <div class="stepInputBoxText">
                                            <div class="stepInputBoxRequired">ایمیل</div>
                                        </div>
                                        <input class="stepInputBoxInput" id="email" type="email">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="step3 bodyOfSteps hidden">
                        <div class="font-weight-400">

                            <div class="inputBody_1 inputBody">
                                @foreach($kindPlace['amaken']['features'] as $kind)
                                    <div class="listItem">
                                        <div class="step5Title">{{$kind->name}}</div>
                                        <div class="subListItem">
                                            @foreach($kind->subFeat as $sub)
                                                <div class="detailListItem">
                                                    <div class="display-inline-block">

                                                        <label class="checkBoxDiv">
                                                            <input id="amaken_{{$sub->id}}" name="amakenFeature[]" value="{{$sub->id}}" type="checkbox">
                                                            {{$sub->name}}
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="inputBody_3 inputBody">

                                <div class="listItem">
                                    <div class="step5Title">نوع رستوران</div>
                                    <div class="subListItem">
                                        <div class="detailListItem">
                                            <select class="selectInput" id="restaurantKind" onchange="changeRestaurantKind(this.value)">
                                                <option value="rest">رستوران</option>
                                                <option value="fastfood">فست فود</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                @foreach($kindPlace['restaurant']['features'] as $kind)
                                    <div {{$kind->name == 'نوع غذای رستوران' ? 'id=restaurantFoodKind' : ''}} class="listItem">
                                        <div class="step5Title">{{$kind->name}}</div>
                                        <div class="subListItem">
                                            @foreach($kind->subFeat as $sub)
                                                <div class="detailListItem">
                                                    <label class="checkBoxDiv">
                                                        <input id="amaken_{{$sub->id}}" name="restaurantFeature[]" value="{{$sub->id}}" type="checkbox">
                                                        {{$sub->name}}
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <script>
                                function changeRestaurantKind(_value){
                                    if(_value == 'rest')
                                        $('#restaurantFoodKind').show();
                                    else
                                        $('#restaurantFoodKind').hide();
                                }
                            </script>

                            <div class="inputBody_4 inputBody">

                                <div class="listItem listItemHotelKind" style="display: flex">
                                    <div style="display: flex; align-items: center">
                                        <div class="icons stepInputIconRequired redStar"></div>
                                        <div class="step5Title" style="width: auto;">نوع اقامتگاه</div>
                                    </div>
                                    <div class="subListItem">
                                        <div class="detailListItem">
                                            <select name="hotelKind" id="hotelKind" class="selectInput" onchange="changHotelKind(this.value)">
                                                <option value="0">...</option>
                                                <option value="1">هتل</option>
                                                <option value="2">هتل آپارتمان</option>
                                                <option value="3">مهمان سرا</option>
                                                <option value="4">ویلا</option>
                                                <option value="5">متل</option>
                                                <option value="6">مجتمع تفریحی</option>
                                                <option value="7">پانسیون</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div id="hotelRate" class="listItem" style="display: none">
                                    <div class="step5Title">هتل چند ستاره است؟</div>
                                    <div class="subListItem">
                                        <div class="detailListItem">
                                            <select name="hotelStar" id="hotelStar" class="selectInput">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                @foreach($kindPlace['hotel']['features'] as $kind)
                                    <div class="listItem">
                                        <div class="step5Title">{{$kind->name}}</div>
                                        <div class="subListItem">
                                            @foreach($kind->subFeat as $sub)
                                                <div class="detailListItem">
                                                    <label class="checkBoxDiv">
                                                        <input id="amaken_{{$sub->id}}" name="hotelFeature[]" value="{{$sub->id}}" type="checkbox">
                                                        {{$sub->name}}
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="inputBody_10_sanaye inputBody">
                                <div class="listItem">
                                    <div class="step5Title">نوع</div>
                                    <div class="subListItem">

                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input id="sanaye_1" name="sanayeFeature[]" value="jewelry" type="checkbox">
                                                زیورآلات
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input id="sanaye_2" name="sanayeFeature[]" value="cloth" type="checkbox">
                                                پارچه و پوشیدنی
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input id="sanaye_3" name="sanayeFeature[]" value="decorative" type="checkbox">
                                                لوازم تزئینی
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input id="sanaye_4" name="sanayeFeature[]" value="applied" type="checkbox">
                                                لوازم کاربردی منزل
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="listItem">
                                    <div class="step5Title">سبک</div>
                                    <div class="subListItem">
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="sanayeFeature[]" value="style_1" type="checkbox">
                                                سنتی
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="sanayeFeature[]" value="style_2" type="checkbox">
                                                مدرن
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="sanayeFeature[]" value="style_3" type="checkbox">
                                                تلفیقی
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="listItem">
                                    <div class="step5Title"></div>
                                    <div class="subListItem">
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="sanayeFeature[]" value="fragile" type="checkbox">
                                                شکستنی
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="listItem">
                                    <div class="step5Title">ابعاد</div>
                                    <div class="subListItem">
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="sizeSanaye" value="1" type="radio">
                                                کوچک
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="sizeSanaye" value="2" type="radio">
                                                متوسط
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="sizeSanaye" value="3" type="radio">
                                                بزرگ
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="listItem">
                                    <div class="step5Title">وزن</div>
                                    <div class="subListItem">
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="weiSanaye" value="1" type="radio">
                                                سبک
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="weiSanaye" value="2" type="radio">
                                                متوسط
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="weiSanaye" value="3" type="radio">
                                                سنگین
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="listItem">
                                    <div class="step5Title">کلاس قیمتی</div>
                                    <div class="subListItem">
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="priceSanaye" value="1" type="radio">
                                                ارزان
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="priceSanaye" value="2" type="radio">
                                                متوسط
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">

                                            <label class="checkBoxDiv">
                                                <input name="priceSanaye" value="3" type="radio">
                                                گران
                                                <span class="checkmark"></span>
                                            </label>

                                        </div>

                                    </div>
                                </div>

                            </div>

                            <div class="inputBody_10_soghat inputBody">

                                <div class="listItem">
                                    <div class="step5Title">مزه</div>
                                    <div class="subListItem">
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="soghatFeatures[]" value="torsh" type="checkbox">
                                                ترش
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="soghatFeatures[]" value="shirin" type="checkbox">
                                                شیرین
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="soghatFeatures[]" value="talkh" type="checkbox">
                                                تلخ
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="soghatFeatures[]" value="malas" type="checkbox">
                                                ملس
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="soghatFeatures[]" value="shor" type="checkbox">
                                                شور
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="soghatFeatures[]" value="tond" type="checkbox">
                                                تند
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>

                                    </div>
                                </div>

                                <div class="listItem">
                                    <div class="step5Title">ابعاد</div>
                                    <div class="subListItem">

                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="sizeSoghat" value="1" type="radio">
                                                کوچک
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="sizeSoghat" value="2" type="radio">
                                                متوسط
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="sizeSoghat" value="3" type="radio">
                                                بزرگ
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>

                                    </div>
                                </div>

                                <div class="listItem">
                                    <div class="step5Title">وزن</div>
                                    <div class="subListItem">
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="weiSoghat" value="1" type="radio">
                                                سبک
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="weiSoghat" value="2" type="radio">
                                                متوسط
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="weiSoghat" value="3" type="radio">
                                                سنگین
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="listItem">
                                    <div class="step5Title">کلاس قیمتی</div>
                                    <div class="subListItem">

                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="priceSoghat" value="1" type="radio">
                                                ارزان
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="priceSoghat" value="2" type="radio">
                                                متوسط
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="priceSoghat" value="3" type="radio">
                                                گران
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="inputBody_11 inputBody">

                                <div class="listItem">
                                    <div class="step5Title">نوع غذا</div>
                                    <div class="subListItem">
                                        <div class="detailListItem">
                                            <select id="foodKind" name="foodKind"  class="selectInput">
                                                <option value="1">چلوخورش</option>
                                                <option value="2">خوراک</option>
                                                <option value="8">سوپ و آش</option>
                                                <option value="3">سالاد و پیش غذا</option>
                                                <option value="4">ساندویچ</option>
                                                <option value="5" selected="">کباب</option>
                                                <option value="6">دسر</option>
                                                <option value="7">نوشیدنی</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="listItem">
                                    <div class="step5Title">غذا سرد است و یا گرم؟</div>
                                    <div class="subListItem">
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="hotFood" value="cold" type="radio">
                                                سرد
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="hotFood" value="hot" type="radio">
                                                گرم
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="listItem">
                                    <div class="step5Title">مناسب چه افرادی است؟</div>
                                    <div class="subListItem">
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="foodFeatures[]" value="vegetarian" type="checkbox">
                                                افراد گیاه‌خوار
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="foodFeatures[]" value="vegan" type="checkbox">
                                                وگان
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="foodFeatures[]" value="diabet" type="checkbox">
                                                افراد مبتلا به دیابت
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="listItem">
                                    <div class="step5Title" style="display: flex; align-items: center;">مواد لازم</div>
                                    <div id="materialRow" class="subListItem">
                                        <div class="row" style="display: flex; justify-content: space-around; direction: ltr">
                                            <div class="matInputTopDiv">
                                                <div class="stepInputBox">
                                                    <input class="stepInputBoxInput stepInputBoxMat" id="materialVol_1" style="text-align: right; padding-right: 10px;" placeholder="مقدار" onchange="addNewRow(1)">
                                                </div>
                                            </div>

                                            <div class="matInputTopDiv">
                                                <div class="stepInputBox ">
                                                    <input class="stepInputBoxInput stepInputBoxMat" id="materialName_1" style="text-align: right; padding-right: 10px;" placeholder="چه چیزی نیاز است" onkeyup="changeMaterialName(this, 1)" onchange="addNewRow(1)">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="display: flex; justify-content: space-around; direction: ltr">
                                            <div class="matInputTopDiv">
                                                <div class="stepInputBox ">
                                                    <input class="stepInputBoxInput stepInputBoxMat" id="materialVol_2" style="text-align: right; padding-right: 10px;" placeholder="مقدار" onchange="addNewRow(2)">
                                                </div>
                                            </div>

                                            <div class="matInputTopDiv">
                                                <div class="stepInputBox ">
                                                    <input class="stepInputBoxInput stepInputBoxMat" id="materialName_2" style="text-align: right; padding-right: 10px;" placeholder="چه چیزی نیاز است" onkeyup="changeMaterialName(this, 2)" onchange="addNewRow(2)">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="display: flex; justify-content: space-around; direction: ltr">
                                            <div class="matInputTopDiv">
                                                <div class="stepInputBox ">
                                                    <input class="stepInputBoxInput stepInputBoxMat" id="materialVol_3" style="text-align: right; padding-right: 10px;" placeholder="مقدار" onchange="addNewRow(3)">
                                                </div>
                                            </div>

                                            <div class="matInputTopDiv">
                                                <div class="stepInputBox ">
                                                    <input class="stepInputBoxInput stepInputBoxMat" id="materialName_3" style="text-align: right; padding-right: 10px;" placeholder="چه چیزی نیاز است" onkeyup="changeMaterialName(this, 3)" onchange="addNewRow(3)">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="listItem">
                                    <div class="step5Title" style="margin-bottom: 0px">دستور پخت</div>
                                    <div class="subListItem" style="width: 100%;">
                                        <textarea class="addresText" name="recipes" id="recipes" rows="5" placeholder="دستور پخت را اینجا وارد کنید..." style="width: 100%; padding: 10px; font-size: 20px"> </textarea>
                                    </div>
                                </div>

                            </div>

                            <div class="inputBody_12 inputBody">

                                <div class="listItem listItemHotelKind" style="display: flex">
                                    <div style="display: flex; align-items: center">
                                        <div class="icons stepInputIconRequired redStar"></div>
                                        <div class="step5Title" style="width: auto; margin-bottom: 0px">تعداد اتاق</div>
                                    </div>
                                    <div class="subListItem">
                                        <div class="detailListItem">
                                            <input type="number" class="selectInput" id="room_num" name="room_num">
                                        </div>
                                    </div>
                                </div>

                                @foreach($kindPlace['boomgardy']['features'] as $kind)
                                    <div class="listItem">
                                        <div class="step5Title">{{$kind->name}}</div>
                                        <div class="subListItem">
                                            @foreach($kind->subFeat as $sub)
                                                <div class="detailListItem">
                                                    <label class="checkBoxDiv">
                                                        <input id="amaken_{{$sub->id}}" name="boomgardyFeature[]" value="{{$sub->id}}" type="checkbox">
                                                        {{$sub->name}}
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>

                    <div class="step4 bodyOfSteps hidden" style="display: flex; flex-wrap: wrap; justify-content: space-around;">
                        <textarea class="addresText" name="placeDescription" id="placeDescription" rows="10" style="width: 100%; font-size: 20px" placeholder="توضیحات خود با توجه به نمونه متن پایین وارد کنید" ></textarea>
                        <div class="sampleDescription">
                            <div id="sampleText"></div>
                        </div>
                    </div>

                    <div class="step5 bodyOfSteps hidden" style="display: flex; flex-wrap: wrap; justify-content: space-around;">
                        <div id="addNewPic" class="step6picBox">
                            <label for="newPicAddPlace" class="step6pic showOnMobile">
                                <div class="step6plusText">اضافه کنید</div>
                                <div class="icons plus2 step6plusIcon"></div>
                            </label>
                            <input id="newPicAddPlace" type="file" style="display: none" onchange="addPhotoInMobile(this)">
                            <div class="step6pic showOnPc" onclick="$('#dropModal').modal('show');">
                                <div class="step6plusText">اضافه کنید</div>
                                <div class="icons plus2 step6plusIcon"></div>
                            </div>
                            <div class="step6picText">نام عکس</div>
                        </div>
                    </div>

                    <div class="step6 bodyOfSteps hidden" style="display: flex; flex-wrap: wrap; justify-content: space-around; flex-direction: column; text-align: center">
                        <div id="step6MainTitle" style="font-size: 20px; margin-top: 23px; text-align: center">
                            <span>پس از بررسی اطلاعات</span>
                            <span class="headerCategoryName" style="font-size: 20px !important;"></span>
                            <span>شما به لیست </span>
                            <span class="headerCategoryName" style="font-size: 20px !important;"></span>
                            <span>های ما اضافه خواهد شد.</span>
                        </div>
                        <a id="sampleLink" href="" target="_blank" style="font-size: 25px; margin-top: 15px; text-align: center"></a>
                    </div>
                </div>

                <div class="downBody">
                    <button class="btn boxPreviousBtn" type="button" id="previousStep" onclick="changeSteps(-1)" style="display: none">بازگشت</button>
                    <div class="footerBox1"></div>
                    <button class="btn boxNextBtn" type="button" id="nextStep" onclick="changeSteps(1)" >شروع</button>
                    <a href="{{route('main')}}" id="lastButton" class="hidden" style="width: 100%; display: flex;">
                        <button class="btn boxNextBtn" type="button" style="width: 100%; border-radius: 50px;">اتمام و بازگشت به صفحه اصلی</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mapModal">
        <div class="modal-dialog modal-lg" style="width: 95%; margin-top: 5px">
            <div class="modal-content">
                <div class="modal-body" style="direction: rtl">
                    <div style="width: 100%; height: calc(80vh - 100px); position: relative">
                        <div id="mapDiv" style="width: 100%; height: 100%"></div>
                        <div class="myLocationIcon" onclick="getMyLocation()">محل من</div>
                    </div>
                </div>
                <div class="modal-footer" style="text-align: center">
                    <button class="btn btn-success" data-dismiss="modal">تایید</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="dropModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body" style="direction: rtl; overflow: hidden">
                    <div class="startScreen infoScreen addPlaceDropZone">
                        <div class="inner" style="width: 100%">
                            <div class="innerPicAddPlace">
                                <img src="{{URL::asset('images/cropImagesIcons/bck.png')}}" width="100%">
                            </div>
                            <div id="dropzone" class="dropzone dragDropTextAddPlace"></div>
                        </div>
                        <div class="footerTextBoxAddPlace stFooter">
                            <span>توجه نمایید که عکس‌ما می‌بایست در فرمت های رایج تصویر و با حداکثر سایز 500 مگابایت باشد. تصاویر پیش از انتشار توسط ما بازبینی می‌گردد. لطفاً از آپلود تصاویری که با قوانین سایت مغایرت دارند اجتناب کنید.</span>
                            <span class="footerPolicyLink">صفحه مقررات</span>
                        </div>
                    </div>
                </div>

                <div class="modal-footer" style="text-align: center">
                    <button class="btn nextStepBtnTourCreation" data-dismiss="modal">تایید</button>
                </div>

            </div>
        </div>
    </div>

    <script src="{{URL::asset('packages/dropzone/dropzone.js')}}"></script>
    <script src="{{URL::asset('packages/dropzone/dropzone-amd-module.js')}}"></script>

    <script type="text/javascript" src="{{URL::asset('packages/leaflet/leaflet.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('packages/leaflet/leaflet-wms-header.js')}}"></script>

    <script>

        var searchInCityUrl = '{{route("getCitiesDir")}}';
        var uploadPicForAddPlaceByUserUrl = '{{route("upload.addPlaceByUser.storeImg")}}';
        var deletePicForAddPlaceByUserUrl = '{{route("upload.addPlaceByUser.deleteImg")}}';
        var storeAddPlaceByUserUrl = '{{route("addPlaceByUser.store")}}';
        var stepLogAddPlaceByUserUrl = '{{route("addPlaceByUser.createStepLog")}}';
        var mainRoutURl = '{{route('main')}}';

        var categories = [
            {
                'name': '{{__('بوم گردی')}}',
                'kind': 'boomgardy',
                'icon': 'hotel',
                'id'  : 12,
                'text' : 'اقامتگاه بوم گردی بابامیرزا واقع در روستای کاغذی، از توابع ابوزیدآباد شهرستان کاشان می‌باشد.این اقامتگاه اولین خانه ساخته شده در روستای کاغذی می‌باشد که متعلق به خان روستا بوده و قدمتی 220 ساله دارد فضای داخلی و بیرونی بنا نمایی از کاهگل داشته و تنور کاهگلی آن نیز در حیاط همچنان مورد استفاده قرار می‌گیرد.  ظرفیت کلی پذیرش مسافر در این مجموعه تا سقف 50 نفر بوده و تمامی اتاق‌های آن به صورت کف‌خواب است و در صورت نیاز لحاف و تشک در اختیار مهمانان قرار خواهد گرفت. اتاق‌های اقامتگاه دارای کرسی به عنوان سیستم گرمایشی و کولر به عنوان سیستم سرمایشی می‌باشند؛ همچنین آشپزخانه با امکاناتی همچون گازو یخچال در حیاط واقع شده و گردشگران می‌توانند به صورت مشترک از آن استفاده کنند.حیاط اقامتگاه 250متر بوده که کف آن سنگ فرش شده است. قسمت دیگری از حیاط به پارک ماشین‌ها اختصاص یافته که قابلیت گنجایش 5 ماشین در آن وجود دارد. در قسمت بیرونی اقامتگاه نیز میدان بسیار بزرگی قرار گرفته است که متعلق به همین اقامتگاه بوده و به عنوان پارکینگ مسقف، با ظرفیت 50 ماشین از آن استفاده می‌شود. در قسمتی دیگر از حیاط سکویی به وسعت 40 متر ساخته شده که به عنوان بهارخواب مورد استفاده قرار می‌گیرد و در شب‌های تابستان مکان مناسبی برای رصد آسمان شب است. کویر سیازگه، نخلستان چاه عروس، دریاچه نمک و قلعه کشایی از مکان دیدنی اطراف این اقامتگاه است.از دیگر خدمات ارائه شده در این مجموعه پرسنل مسلط به زبان انگلیسی و راهنمای تور برای گردشگران می‌باشد.حلیم بادمجان، کشک بادمجان، شیربرنج، پلو جوجه، کالاجوش، کاچی و آش محلی از جمله غذاهای سرو شده توسط اقامتگاه است. جاذبه‌های گردشگری اطراف به علت قرار گرفتن این اقامتگاه بوم گردی بر روی تپه‌ای بلند، حیاط و بام آن مشرف به زیبایی‌های اطراف روستا از جمله رمل، کوه و دشت می‌باشد.',
                'sample': {
                    'name': '{{__('addPlaceByUser.لیست تمامی بوم گردی ها')}}',
                    'link': 'https://koochita.com/placeList/12/country'
                },
                'step3' : '{{__('addPlaceByUser.مهم ترین بخش ، توصیف بوم گردی است')}}',
                'step3Under' : '{{__('addPlaceByUser.از بین گزینه های زیر، مواردی را که بوم گردی را توصیف می نماید اضافه کنید. سپاسگذاریم.')}}',
                'step4' : '{{__('addPlaceByUser.اگر توضیحات خاصی در مورد بوم گردی دارید در این قسمت با ما در میان بگذارید')}}',
                'step5' : '{{__('addPlaceByUser.اگر عکسی از بوم گردی دارید آن را بارگذاری نمایید')}}',
                'step6' : '{{__('addPlaceByUser.پس از بررسی اطلاعات بوم گردی شما به لیست بوم گردی های ما اضافه خواهد شد.')}}',
            },
            {
                'name': '{{__('رستوران')}}',
                'kind': 'restaurant',
                'icon': 'restaurant',
                'id'  : 3,
                'text' : 'رستوران شهرزاد یکی از رستوران‌های لوکس و قدیمی اصفهانه که تزئینات نقاشی و آئینه کاری‌های سنتی وشیکی داره که فقط و فقط مخصوصه اصفهان و نصف جهانه. در این رستوران انواع غذاهای ایرانی و فرنگی سرو می‌شه و موقع نوش جان کردن غذات می‌تونی از موسیقی زنده هم لذت ببری.',
                'sample': {
                    'name': '{{__('addPlaceByUser.لیست تمامی رستوران ها')}}',
                    'link': 'https://koochita.com/placeList/3/country'
                },
                'step3' : '{{__('addPlaceByUser.مهم ترین بخش ، توصیف رستوران است')}}',
                'step3Under' : '{{__('addPlaceByUser.از بین گزینه های زیر، مواردی را که رستوران را توصیف می نماید اضافه کنید. سپاسگذاریم.')}}',
                'step4' : '{{__('addPlaceByUser.اگر توضیحات خاصی در مورد رستوران دارید در این قسمت با ما در میان بگذارید')}}',
                'step5' : '{{__('addPlaceByUser.اگر عکسی از رستوران دارید آن را بارگذاری نمایید')}}',
                'step6' : '{{__('addPlaceByUser.پس از بررسی اطلاعات رستوران شما به لیست رستوران های ما اضافه خواهد شد.')}}',
            },
            {
                'name': '{{__('سوغات')}}',
                'icon': 'soghat',
                'kind': 'soghat',
                'id'  : 10,
                'text' : 'خیلی‌ها معتقدن هنر مینیاتور از چین وارد ایران شده. در واقع این هنر در دوره صفویه پیشرفت کرد و از مینیاتوری چینی خیلی فاصله گرفت. اکثر هنرمندهای مینیاتور از رنگ دست ساز برای کارهاشون استفاده میکنن. آبرنگ روحي، سياه قلم رنگي، سفيد قلم و زيرروغني از شیوه‌های مختلف این هنر هستن. در بناهای تاریخی اصفهان مثل كاخ‌هاي عالي قاپو و چهلستون و هشت بهشت و ... میتونید تزئینات مینیاتوری رو به خوبی ببینید. اگر به دنبال مینیاتورهای خوب برای سوغاتی هستید، بهتره به خیابون چهارباغ برید.',
                'sample': {
                    'name': '{{__('addPlaceByUser.لیست تمامی سوغات')}}',
                    'link': 'https://koochita.com/placeList/10/country'
                },
                'step3' : '{{__('addPlaceByUser.مهم ترین بخش ، توصیف سوغات است')}}',
                'step3Under' : '{{__('addPlaceByUser.از بین گزینه های زیر، مواردی را که سوغات را توصیف می نماید اضافه کنید. سپاسگذاریم.')}}',
                'step4' : '{{__('addPlaceByUser.اگر توضیحات خاصی در مورد سوغات دارید در این قسمت با ما در میان بگذارید')}}',
                'step5' : '{{__('addPlaceByUser.اگر عکسی از سوغات دارید آن را بارگذاری نمایید')}}',
                'step6' : '{{__('addPlaceByUser.پس از بررسی اطلاعات سوغات شما به لیست سوغات های ما اضافه خواهد شد.')}}',
            },
            {
                'name': '{{__('صنایع دستی')}}',
                'kind': 'sanaye',
                'icon': 'sanaye',
                'id'  : 10,
                'text' : 'خیلی‌ها معتقدن هنر مینیاتور از چین وارد ایران شده. در واقع این هنر در دوره صفویه پیشرفت کرد و از مینیاتوری چینی خیلی فاصله گرفت. اکثر هنرمندهای مینیاتور از رنگ دست ساز برای کارهاشون استفاده میکنن. آبرنگ روحي، سياه قلم رنگي، سفيد قلم و زيرروغني از شیوه‌های مختلف این هنر هستن. در بناهای تاریخی اصفهان مثل كاخ‌هاي عالي قاپو و چهلستون و هشت بهشت و ... میتونید تزئینات مینیاتوری رو به خوبی ببینید. اگر به دنبال مینیاتورهای خوب برای سوغاتی هستید، بهتره به خیابون چهارباغ برید.',
                'sample': {
                    'name': '{{__('addPlaceByUser.لیست تمامی صنایع دستی')}}',
                    'link': 'https://koochita.com/placeList/10/country'
                },
                'step3' : '{{__('addPlaceByUser.مهم ترین بخش ، توصیف صنایع دستی است')}}',
                'step3Under' : '{{__('addPlaceByUser.از بین گزینه های زیر، مواردی را که صنایع دستی را توصیف می نماید اضافه کنید. سپاسگذاریم.')}}',
                'step4' : '{{__('addPlaceByUser.اگر توضیحات خاصی در مورد صنایع دستی دارید در این قسمت با ما در میان بگذارید')}}',
                'step5' : '{{__('addPlaceByUser.اگر عکسی از صنایع دستی دارید آن را بارگذاری نمایید')}}',
                'step6' : '{{__('addPlaceByUser.پس از بررسی اطلاعات صنایع دستی شما به لیست صنایع دستی های ما اضافه خواهد شد.')}}',
            },
            {
                'name': '{{__('غذای محلی')}}',
                'icon': 'ghazamahali',
                'kind': 'ghazamahali',
                'id'  : 11,
                'text' : 'غذای محلی مد نظر خود را به صورت مختصر توضیح دهید. سعی کنید ابتدا آن را توصیف کنید، در مورد تاریخچه آن مختصری بنویسید، مزه آن را شرح دهید. راحت باشید و کاملا ساده بنویسید.',
                'sample': {
                    'name': '{{__('addPlaceByUser.لیست تمامی غذاهای محلی')}}',
                    'link': 'https://koochita.com/placeList/11/country'
                },
                'step3' : '{{__('addPlaceByUser.مهم ترین بخش ، توصیف غذای محلی است')}}',
                'step3Under' : '{{__('addPlaceByUser.از بین گزینه های زیر، مواردی را که غذای محلی را توصیف می نماید اضافه کنید. سپاسگذاریم.')}}',
                'step4' : '{{__('addPlaceByUser.اگر توضیحات خاصی در مورد غذای محلی دارید در این قسمت با ما در میان بگذارید')}}',
                'step5' : '{{__('addPlaceByUser.اگر عکسی از غذای محلی دارید آن را بارگذاری نمایید')}}',
                'step6' : '{{__('addPlaceByUser.پس از بررسی اطلاعات غذای محلی شما به لیست غذای محلی های ما اضافه خواهد شد.')}}',
            },
            {
                'name': '{{__('مرکز اقامتی')}}',
                'kind': 'hotel',
                'icon': 'hotel',
                'id'  : 4,
                'text' : 'مهمانسرای ورزش شهر زیبا و دیدنی همدان از اقامتگاه‌های خوب این شهره که مجهز به امکانات رفاهی شایسته‌ای برای رفاه مسافران و مهمانان عزیزه. ورزشکاران محترم و تیم‌های ورزشی می تونن با اقامات توی این مهمانسرا علاوه بر استراحت از امکانات ویژه اون هم بهره ببرند. این مهمانسرا که در نزدیکی ورزشگاه شهید حاجی بابایی افتتاح شده، دارای چندین سالن مجزا و استاندار از جمله بدنسازی، زمین چمن و سالن‌های چندمنظوره انواع رشته‌های ورزشی هست که آماده میزبانی اقشار مختلف و به طور ویژه ورزشکاران عزیز هست.',
                'sample': {
                'name': '{{__('addPlaceByUser.لیست تمامی هتل ها')}}',
                'link': 'https://koochita.com/placeList/4/country'
                },
                'step3' : '{{__('addPlaceByUser.مهم ترین بخش ، توصیف مرکز اقامتی است')}}',
                'step3Under' : '{{__('addPlaceByUser.از بین گزینه های زیر، مواردی را که مرکز اقامتی را توصیف می نماید اضافه کنید. سپاسگذاریم.')}}',
                'step4' : '{{__('addPlaceByUser.اگر توضیحات خاصی در مورد مرکز اقامتی دارید در این قسمت با ما در میان بگذارید')}}',
                'step5' : '{{__('addPlaceByUser.اگر عکسی از مرکز اقامتی دارید آن را بارگذاری نمایید')}}',
                'step6' : '{{__('addPlaceByUser.پس از بررسی اطلاعات مرکز اقامتی شما به لیست مرکز اقامتی های ما اضافه خواهد شد.')}}',
            },
            {
                'name': '{{__('جاذبه')}}',
                'kind': 'atraction',
                'icon': 'atraction',
                'id'  : 1,
                'text' : 'دریاچه سد زاینده رود روی رودخونه زاینده رود یا زنده رود و در منطقه کوهستانی آبادچی،کنار شهر چادگان قرار گرفته. اطراف این سد هم امکانات خوبی برای مسافرها وجود داره. اطراف اون هم پر از فضای سبز و درخت‌های میوه هست که لذت کنار آب بودن رو دو برابر می‌کنه. اینجا میشه قایقرانی و ماهی گیری کرد. به خاطر آب و هوای این منطقه ماهی قزل‌آلای رنگین کمان، کپور و زردک رو میشه اینجا صید کرد. ',
                'sample': {
                    'name': '{{__('addPlaceByUser.لیست تمامی جاذبه ها')}}',
                    'link': 'https://koochita.com/placeList/1/country'
                },
                'step3' : '{{__('addPlaceByUser.مهم ترین بخش ، توصیف جاذبه است')}}',
                'step3Under' : '{{__('addPlaceByUser.از بین گزینه های زیر، مواردی را که جاذبه را توصیف می نماید اضافه کنید. سپاسگذاریم.')}}',
                'step4' : '{{__('addPlaceByUser.اگر توضیحات خاصی در مورد جاذبه دارید در این قسمت با ما در میان بگذارید')}}',
                'step5' : '{{__('addPlaceByUser.اگر عکسی از جاذبه دارید آن را بارگذاری نمایید')}}',
                'step6' : '{{__('addPlaceByUser.پس از بررسی اطلاعات جاذبه شما به لیست جاذبه های ما اضافه خواهد شد.')}}',
            },
        ];


        let myDropzone = new Dropzone("div#dropzone", {
            url: uploadPicForAddPlaceByUserUrl,
            paramName: "pic",
            dictDefaultMessage: '{{__('به سادگی عکس های خود را در این قاب بی اندازید و یا کلیک کنید')}}',
            timeout: 60000,
            headers: {
                'X-CSRF-TOKEN': csrfTokenGlobal
            },
            parallelUploads: 1,
            acceptedFiles: 'image/*',
            init: function() {
                this.on("sending", function(file, xhr, formData){
                    formData.append("id", newPlaceId);
                });
            },
        }).on('success', function(file, response){
            if(response.status == 'ok')
                createPlacePicCard(response, file);
            else
                myDropzone.removeFile(file);

        }).on('error', function(file, response, err){
            $(file.previewElement).find('.dz-error-message').find('span').text('آپود عکس شما با مشکل مواجه شد دوباره تلاش کنید');
        });

        categories.forEach((item, index) => {
            let text = `<div id="category_' + index + '" class="categories" onclick="selectCategory(this, ${index});">
                        <div class="icons iconsOfCategories ${item["icon"]}"></div>
                        <div>${item["name"]}</div>
                    </div>`;
            $('#selectCategoryDiv').append(text);
        });

        $(document).ready(() => {

            $('[data-toggle="tooltip"]').tooltip();
            @if(app()->getLocale() == 'fa')
                $("#name").farsiInput();
                $("#address").farsiInput();
                $("#recipes").farsiInput();
                $("#material").farsiInput();
                $("#placeDescription").farsiInput();
            @endif
            autosize($('textarea'));

            let hash = location.hash;
            if(hash != '' && hash != '#'){
                for(let i = 0; i < categories.length; i++){
                    if('#'+categories[i].kind == hash){
                        selectCategory($('#category_' + i), i);
                        changeSteps(1);
                        break;
                    }
                }
            }

        })

    </script>

    <script src="{{URL::asset('js/pages/addPlaceByUser.js?v='.$fileVersions)}}"></script>

@stop
