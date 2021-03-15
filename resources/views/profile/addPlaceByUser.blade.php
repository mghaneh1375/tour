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
                {{__('addPlaceByUser.امروز از هم جداییم ، اما برای فردای با هم بودن تلاش می کنیم')}}
            </div>

            <div class="box">

                <div class="topSection">

                    <div class="headerOfBox">
                        <div class="textTopTopHeader">
                            {{__('addPlaceByUser.معرفی و تبلیغ فعالیت شما به تمامی علاقه مندان به سفر')}}
                        </div>

                        <div class="stepsMilestoneMainDiv">
                            <div class="dotDiv">
                                <div id="stepName">{{__('addPlaceByUser.اولین مرحله')}}</div>
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
                            {{__('addPlaceByUser.پس از شیوع کرونا و با توجه به مشکلاتی که برای کسب و کار ها در حوزه سفر و گردشگری ایجاد شده ، تصمیم گرفتیم که بستری را به صورت رایگان فراهم کنیم تا صاحبان مشاغل و ایران گردان به معرفی کسب و کار خود و معرفی ایران عزیزمان بپردازید. لطفا در چند مرحله ساده، به پرسش های ما پاسخ دهید.')}}
                            </div>
                        </div>
                        <div class="step2 stepHeader hidden">
                            <div class="stepTitle">{{__('addPlaceByUser.لطفا اطلاعات پایه را وارد نمایید.')}}</div>
                            <div class="boxNotice">{{__('addPlaceByUser.وارد نمودن اطلاعات ستاره دار اجباری است.')}}</div>
                        </div>
                        <div class="step3 stepHeader hidden">
                            <div id="step3MainTitle" class="stepTitle">مهم ترین بخش ، توصیف <span class="headerCategoryName"></span> است</div>
                            <div id="step3MainUnderTitle" class="boxNotice">از بین گزینه های زیر، مواردی را که <span class="headerCategoryName"></span> را توصیف می نماید اضافه کنید. سپاسگذاریم.</div>
                        </div>
                        <div class="step4 stepHeader hidden">
                            <div id="step4MainTitle" class="stepTitle">اگر توضیحات خاصی در مورد <span class="headerCategoryName"></span> دارید در این قسمت با ما در میان بگذارید</div>
                        </div>
                        <div class="step5 stepHeader hidden">
                            <div id="step5MainTitle" class="stepTitle">اگر عکسی از <span class="headerCategoryName"></span> دارید آن را بارگذاری نمایید</div>
                            <div class="boxNotice">{{__('addPlaceByUser.شما می توانید به هر تعداد عکس که در اختیار دارید آپلود نمایید. در این صورت علاوه بر امتیاز تعریف و یا ویرایش مکان، امتیاز عکس نیز به شما تعلق می گیرد')}}</div>
                        </div>
                        <div class="step6 stepHeader hidden">
                            <div class="stepTitle">
                                {{__('addPlaceByUser.تمام اطلاعات به طور کامل دریافت شد. این اطلاعات پس از بررسی اعمال خواهد شد و امتیاز شما در پروفایل افزایش خواهد یافت. به ویرایش و اضافه کردن مقصد های جدید ادامه دهید تا علاوه بر افزایش امتیاز، نشان های افتخار متفاوتی برنده شوید.')}}
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
                        <div class="step1Header">{{__('addPlaceByUser.لطفا دسته مناسب را با توجه به فعالیت خود انتخاب کنید.')}}</div>
                        <div id="selectCategoryDiv" class="text-align-center"></div>
                    </div>

                    <div class="step2 bodyOfSteps hidden">
                        <div class="inputFliedRow inputFlied">
                            <div class="icons stepInputIconRequired redStar"></div>
                            <div class="stepInputBox">
                                <div class="stepInputBoxText">
                                    <div class="stepInputBoxRequired">
                                        {{__('نام')}}
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
                                            <div class="stepInputBoxRequired">
                                                {{__('استان')}}
                                            </div>
                                        </div>
                                        <select class="stepInputBoxInput" name="state" id="state" onchange="changeState(this.value)" style="padding-left: 20px">
                                            <option id="noneState" value="0">{{__('استان را انتخاب کنید')}}</option>
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
                                        <div class="stepInputBoxRequired">{{__('شهر')}}</div>
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
                                    <textarea accept-charset="character_set" class="addresText" id="address" name="address" placeholder="{{__('addPlaceByUser.آدرس دقیق محل را وارد نمایید - حداقل 100 کاراکتر')}}" rows="2" style="font-size: 20px"></textarea>
                                </div>
                                <input type="hidden" name="lat" id="lat" value="0">
                                <input type="hidden" name="lng" id="lng" value="0">

                                <div class="overMapButton">
                                    <button class="btn btn-success mapButton" onclick="openMap()">{{__('addPlaceByUser.محل را از روی نقشه مشخص کنید')}}</button>
                                </div>

                                <div class="mg-tp-5" style="font-size: 15px; text-align: center">{{__('addPlaceByUser.موقعیت موردنظر را بر روی نقشه پیدا نموده و پین را بر روی آن قرار دهید. (کلیک در کامپیوتر و لمس نقشه در گوشی)')}}</div>
                            </div>

                            <div class="row inputFliedRow onlyForHotelsRestBoom ">
                                <div class="inputFliedRow inputFlied" style="display: flex; align-items: center">
                                    <div class="icons stepInputIconRequired redStar"></div>
                                    <div class="stepInputBox">
                                        <div class="stepInputBoxText">
                                            <div class="stepInputBoxRequired" style=" font-size: 13px; font-weight: bold;"> {{__('تلفن ثابت')}} <span class="headerCategoryName"></span> </div>
                                        </div>
                                        <input class="stepInputBoxInput" id="fixPhone">
                                    </div>
                                </div>

                                <div class="inputFliedRow inputFlied marginRight">
                                    <div class="stepInputBox">
                                        <div class="stepInputBoxText">
                                            <div class="stepInputBoxRequired" style=" font-weight: bold; font-size: 13px;">{{__('تلفن همراه')}}</div>
                                        </div>
                                        <div>
                                            <input class="stepInputBoxInput" id="phone" placeholder="09xxxxxxxxx" style="text-align: right; padding-right: 15px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="stepNotice onlyForHotelsRestBoom">{{__('addPlaceByUser.شماره را همانگونه که با موبایل خود تماس می گیرید وارد نمایید. در صورت وجود بیش از یک شماره با استفاده از - شماره ها را جدا نمایید')}}</div>

                            <div class="row inputFliedRow onlyForHotelsRest" style="margin-top: 20px;">
                                <div class="inputFliedRow inputFlied">
                                    <div class="stepInputBox">
                                        <div class="stepInputBoxText">
                                            <div class="stepInputBoxRequired">{{__('سایت')}}</div>
                                        </div>
                                        <input class="stepInputBoxInput" id="website" type="url">
                                    </div>
                                </div>
                                <div class="inputFliedRow inputFlied marginRight">
                                    <div class="stepInputBox">
                                        <div class="stepInputBoxText">
                                            <div class="stepInputBoxRequired">{{__('ایمیل')}}</div>
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
                                        <div class="step5Title">{{__('amaken.'.$kind->name)}}</div>
                                        <div class="subListItem">
                                            @foreach($kind->subFeat as $sub)
                                                <div class="detailListItem">
                                                    <div class="display-inline-block">

                                                        <label class="checkBoxDiv">
                                                            <input id="amaken_{{$sub->id}}" name="amakenFeature[]" value="{{$sub->id}}" type="checkbox">
                                                            {{__('amaken.'. $sub->name)}}
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
                                    <div class="step5Title">{{__('restaurant.نوع رستوران')}}</div>
                                    <div class="subListItem">
                                        <div class="detailListItem">
                                            <select class="selectInput" id="restaurantKind" onchange="changeRestaurantKind(this.value)">
                                                <option value="rest">{{__('restaurant.رستوران')}}</option>
                                                <option value="fastfood">{{__('restaurant.فست فود')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                @foreach($kindPlace['restaurant']['features'] as $kind)
                                    <div {{$kind->name == 'نوع غذای رستوران' ? 'id=restaurantFoodKind' : ''}} class="listItem">
                                        <div class="step5Title">{{__('restaurant.'.$kind->name)}}</div>
                                        <div class="subListItem">
                                            @foreach($kind->subFeat as $sub)
                                                <div class="detailListItem">
                                                    <label class="checkBoxDiv">
                                                        <input id="amaken_{{$sub->id}}" name="restaurantFeature[]" value="{{$sub->id}}" type="checkbox">
                                                        {{__('restaurant.'.$sub->name)}}
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
                                        <div class="step5Title" style="width: auto;">{{__('hotel.نوع اقامتگاه')}}</div>
                                    </div>
                                    <div class="subListItem">
                                        <div class="detailListItem">
                                            <select name="hotelKind" id="hotelKind" class="selectInput" onchange="changHotelKind(this.value)">
                                                <option value="0">...</option>
                                                <option value="1">{{__('hotel.هتل')}}</option>
                                                <option value="2">{{__('hotel.هتل آپارتمان')}}</option>
                                                <option value="3">{{__('hotel.مهمان سرا')}}</option>
                                                <option value="4">{{__('hotel.ویلا')}}</option>
                                                <option value="5">{{__('hotel.متل')}}</option>
                                                <option value="6">{{__('hotel.مجتمع تفریحی')}}</option>
                                                <option value="7">{{__('hotel.پانسیون')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div id="hotelRate" class="listItem" style="display: none">
                                    <div class="step5Title">{{__('addPlaceByUser.هتل چند ستاره است؟')}}</div>
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
                                        <div class="step5Title">{{__('hotel.'.$kind->name)}}</div>
                                        <div class="subListItem">
                                            @foreach($kind->subFeat as $sub)
                                                <div class="detailListItem">
                                                    <label class="checkBoxDiv">
                                                        <input id="amaken_{{$sub->id}}" name="hotelFeature[]" value="{{$sub->id}}" type="checkbox">
                                                        {{__('hotel.'.$sub->name)}}
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
                                    <div class="step5Title">{{__('handicrafts.نوع')}}</div>
                                    <div class="subListItem">

                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input id="sanaye_1" name="sanayeFeature[]" value="jewelry" type="checkbox">
                                                {{__('handicrafts.زیورآلات')}}
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">

                                            <label class="checkBoxDiv">
                                                <input id="sanaye_2" name="sanayeFeature[]" value="cloth" type="checkbox">
                                                {{__('handicrafts.پارچه و پوشیدنی')}}
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input id="sanaye_3" name="sanayeFeature[]" value="decorative" type="checkbox">
                                                {{__('handicrafts.لوازم تزئینی')}}
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input id="sanaye_4" name="sanayeFeature[]" value="applied" type="checkbox">
                                                {{__('handicrafts.لوازم کاربردی منزل')}}
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>

                                    </div>
                                </div>

                                <div class="listItem">
                                    <div class="step5Title">{{__('handicrafts.سبک')}}</div>
                                    <div class="subListItem">
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="sanayeFeature[]" value="style_1" type="checkbox">
                                                {{__('handicrafts.سنتی')}}
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">

                                            <label class="checkBoxDiv">
                                                <input name="sanayeFeature[]" value="style_2" type="checkbox">
                                                {{__('handicrafts.مدرن')}}
                                                <span class="checkmark"></span>
                                            </label>

                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="sanayeFeature[]" value="style_3" type="checkbox">
                                                {{__('handicrafts.تلفیقی')}}
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
                                                {{__('handicrafts.شکستنی')}}
                                                <span class="checkmark"></span>
                                            </label>

                                        </div>

                                    </div>
                                </div>

                                <div class="listItem">
                                    <div class="step5Title">{{__('handicrafts.ابعاد')}}</div>
                                    <div class="subListItem">

                                        <div class="detailListItem">

                                            <label class="checkBoxDiv">
                                                <input name="sizeSanaye" value="1" type="radio">
                                                {{__('handicrafts.کوچک')}}
                                                <span class="checkmark"></span>
                                            </label>

                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="sizeSanaye" value="2" type="radio">
                                                {{__('handicrafts.متوسط')}}
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">

                                            <label class="checkBoxDiv">
                                                <input name="sizeSanaye" value="3" type="radio">
                                                {{__('handicrafts.بزرگ')}}
                                                <span class="checkmark"></span>
                                            </label>

                                        </div>

                                    </div>
                                </div>

                                <div class="listItem">
                                    <div class="step5Title">{{__('handicrafts.وزن')}}</div>
                                    <div class="subListItem">

                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="weiSanaye" value="1" type="radio">
                                                {{__('handicrafts.سبک')}}
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">

                                            <label class="checkBoxDiv">
                                                <input name="weiSanaye" value="2" type="radio">
                                                {{__('handicrafts.متوسط')}}
                                                <span class="checkmark"></span>
                                            </label>

                                        </div>
                                        <div class="detailListItem">

                                            <label class="checkBoxDiv">
                                                <input name="weiSanaye" value="3" type="radio">
                                                {{__('handicrafts.سنگین')}}
                                                <span class="checkmark"></span>
                                            </label>

                                        </div>

                                    </div>
                                </div>

                                <div class="listItem">
                                    <div class="step5Title">{{__('handicrafts.کلاس قیمتی')}}</div>
                                    <div class="subListItem">

                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="priceSanaye" value="1" type="radio">
                                                {{__('handicrafts.ارزان')}}
                                                <span class="checkmark"></span>
                                            </label>

                                        </div>
                                        <div class="detailListItem">

                                            <label class="checkBoxDiv">
                                                <input name="priceSanaye" value="2" type="radio">
                                                {{__('handicrafts.متوسط')}}
                                                <span class="checkmark"></span>
                                            </label>

                                        </div>
                                        <div class="detailListItem">

                                            <label class="checkBoxDiv">
                                                <input name="priceSanaye" value="3" type="radio">
                                                {{__('handicrafts.گران')}}
                                                <span class="checkmark"></span>
                                            </label>

                                        </div>

                                    </div>
                                </div>

                            </div>

                            <div class="inputBody_10_soghat inputBody">

                                <div class="listItem">
                                    <div class="step5Title">{{__('souvenir.مزه')}}</div>
                                    <div class="subListItem">

                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="soghatFeatures[]" value="torsh" type="checkbox">
                                                {{__('souvenir.ترش')}}
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="soghatFeatures[]" value="shirin" type="checkbox">
                                                {{__('souvenir.شیرین')}}
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="soghatFeatures[]" value="talkh" type="checkbox">
                                                {{__('souvenir.تلخ')}}
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="soghatFeatures[]" value="malas" type="checkbox">
                                                {{__('souvenir.ملس')}}
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="soghatFeatures[]" value="shor" type="checkbox">
                                                {{__('souvenir.شور')}}
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="soghatFeatures[]" value="tond" type="checkbox">
                                                {{__('souvenir.تند')}}
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>

                                    </div>
                                </div>

                                <div class="listItem">
                                    <div class="step5Title">{{__('souvenir.ابعاد')}}</div>
                                    <div class="subListItem">

                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="sizeSoghat" value="1" type="radio">
                                                {{__('souvenir.کوچک')}}
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="sizeSoghat" value="2" type="radio">
                                                {{__('souvenir.متوسط')}}
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="sizeSoghat" value="3" type="radio">
                                                {{__('souvenir.بزرگ')}}
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>

                                    </div>
                                </div>

                                <div class="listItem">
                                    <div class="step5Title">{{__('souvenir.وزن')}}</div>
                                    <div class="subListItem">
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="weiSoghat" value="1" type="radio">
                                                {{__('souvenir.سبک')}}
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="weiSoghat" value="2" type="radio">
                                                {{__('souvenir.متوسط')}}
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="weiSoghat" value="3" type="radio">
                                                {{__('souvenir.سنگین')}}
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="listItem">
                                    <div class="step5Title">{{__('souvenir.کلاس قیمتی')}}</div>
                                    <div class="subListItem">

                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="priceSoghat" value="1" type="radio">
                                                {{__('souvenir.ارزان')}}
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="priceSoghat" value="2" type="radio">
                                                {{__('souvenir.متوسط')}}
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="priceSoghat" value="3" type="radio">
                                                {{__('souvenir.گران')}}
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="inputBody_11 inputBody">

                                <div class="listItem">
                                    <div class="step5Title">{{__('food.نوع غذا')}}</div>
                                    <div class="subListItem">
                                        <div class="detailListItem">
                                            <select id="foodKind" name="foodKind"  class="selectInput">
                                                <option value="1">{{__('food.چلوخورش')}}</option>
                                                <option value="2">{{__('food.خوراک')}}</option>
                                                <option value="8">{{__('food.سوپ و آش')}}</option>
                                                <option value="3">{{__('food.سالاد و پیش غذا')}}</option>
                                                <option value="4">{{__('food.ساندویچ')}}</option>
                                                <option value="5" selected="">{{__('food.کباب')}}</option>
                                                <option value="6">{{__('food.دسر')}}</option>
                                                <option value="7">{{__('food.نوشیدنی')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="listItem">
                                    <div class="step5Title">{{__('food.غذا سرد است و یا گرم؟')}}</div>
                                    <div class="subListItem">
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="hotFood" value="cold" type="radio">
                                                {{__('food.سرد')}}
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="hotFood" value="hot" type="radio">
                                                {{__('food.گرم')}}
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="listItem">
                                    <div class="step5Title">{{__('addPlaceByUser.مناسب چه افرادی است؟')}}</div>
                                    <div class="subListItem">
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="foodFeatures[]" value="vegetarian" type="checkbox">
                                                {{__('food.افراد گیاه‌خوار')}}
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="foodFeatures[]" value="vegan" type="checkbox">
                                                {{__('food.وگان')}}
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="detailListItem">
                                            <label class="checkBoxDiv">
                                                <input name="foodFeatures[]" value="diabet" type="checkbox">
                                                {{__('food.افراد مبتلا به دیابت')}}
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="listItem">
                                    <div class="step5Title" style="display: flex; align-items: center;">
                                        {{__('مواد لازم')}}
                                    </div>
                                    <div id="materialRow" class="subListItem">
                                        <div class="row" style="display: flex; justify-content: space-around; direction: ltr">
                                            <div class="matInputTopDiv">
                                                <div class="stepInputBox">
                                                    <input class="stepInputBoxInput stepInputBoxMat" id="materialVol_1" style="text-align: right; padding-right: 10px;" placeholder="{{__('مقدار')}}" onchange="addNewRow(1)">
                                                </div>
                                            </div>

                                            <div class="matInputTopDiv">
                                                <div class="stepInputBox ">
                                                    <input class="stepInputBoxInput stepInputBoxMat" id="materialName_1" style="text-align: right; padding-right: 10px;" placeholder="{{__('addPlaceByUser.چه چیزی نیاز است')}}" onkeyup="changeMaterialName(this, 1)" onchange="addNewRow(1)">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="display: flex; justify-content: space-around; direction: ltr">
                                            <div class="matInputTopDiv">
                                                <div class="stepInputBox ">
                                                    <input class="stepInputBoxInput stepInputBoxMat" id="materialVol_2" style="text-align: right; padding-right: 10px;" placeholder="{{__('مقدار')}}" onchange="addNewRow(2)">
                                                </div>
                                            </div>

                                            <div class="matInputTopDiv">
                                                <div class="stepInputBox ">
                                                    <input class="stepInputBoxInput stepInputBoxMat" id="materialName_2" style="text-align: right; padding-right: 10px;" placeholder="{{__('addPlaceByUser.چه چیزی نیاز است')}}" onkeyup="changeMaterialName(this, 2)" onchange="addNewRow(2)">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="display: flex; justify-content: space-around; direction: ltr">
                                            <div class="matInputTopDiv">
                                                <div class="stepInputBox ">
                                                    <input class="stepInputBoxInput stepInputBoxMat" id="materialVol_3" style="text-align: right; padding-right: 10px;" placeholder="{{__('مقدار')}}" onchange="addNewRow(3)">
                                                </div>
                                            </div>

                                            <div class="matInputTopDiv">
                                                <div class="stepInputBox ">
                                                    <input class="stepInputBoxInput stepInputBoxMat" id="materialName_3" style="text-align: right; padding-right: 10px;" placeholder="{{__('addPlaceByUser.چه چیزی نیاز است')}}" onkeyup="changeMaterialName(this, 3)" onchange="addNewRow(3)">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="listItem">
                                    <div class="step5Title" style="margin-bottom: 0px">{{__('food.دستور پخت')}}</div>
                                    <div class="subListItem" style="width: 100%;">
                                        <textarea class="addresText" name="recipes" id="recipes" rows="5" placeholder="{{__('addPlaceByUser.دستور پخت را اینجا وارد کنید...')}}" style="width: 100%; padding: 10px; font-size: 20px"> </textarea>
                                    </div>
                                </div>

                            </div>

                            <div class="inputBody_12 inputBody">

                                <div class="listItem listItemHotelKind" style="display: flex">
                                    <div style="display: flex; align-items: center">
                                        <div class="icons stepInputIconRequired redStar"></div>
                                        <div class="step5Title" style="width: auto; margin-bottom: 0px">{{__('تعداد اتاق')}}</div>
                                    </div>
                                    <div class="subListItem">
                                        <div class="detailListItem">
                                            <input type="number" class="selectInput" id="room_num" name="room_num">
                                        </div>
                                    </div>
                                </div>

                                @foreach($kindPlace['boomgardy']['features'] as $kind)
                                    <div class="listItem">
                                        <div class="step5Title">{{__('boomgardy.'.$kind->name)}}</div>
                                        <div class="subListItem">
                                            @foreach($kind->subFeat as $sub)
                                                <div class="detailListItem">
                                                    <label class="checkBoxDiv">
                                                        <input id="amaken_{{$sub->id}}" name="boomgardyFeature[]" value="{{$sub->id}}" type="checkbox">
                                                        {{__('boomgardy.'.$sub->name)}}
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
                        <textarea class="addresText" name="placedescription" id="placedescription" rows="10" style="width: 100%; font-size: 20px" placeholder="{{__('addPlaceByUser.توضیحات خود با توجه به نمونه متن پایین وارد کنید.')}}" ></textarea>
                        <div class="sampleDescription">
                            <div id="sampleText"></div>
                        </div>
                    </div>

                    <div class="step5 bodyOfSteps hidden" style="display: flex; flex-wrap: wrap; justify-content: space-around;">
                        <div id="addNewPic" class="step6picBox">
                            <label for="newPicAddPlace" class="step6pic showOnMobile">
                                <div class="step6plusText">{{__('addPlaceByUser.اضافه کنید')}}</div>
                                <div class="icons plus2 step6plusIcon"></div>
                            </label>
                            <input id="newPicAddPlace" type="file" style="display: none" onchange="addPhotoInMobile(this)">
                            <div class="step6pic showOnPc" onclick="$('#dropModal').modal('show');">
                                <div class="step6plusText">{{__('addPlaceByUser.اضافه کنید')}}</div>
                                <div class="icons plus2 step6plusIcon"></div>
                            </div>
                            <div class="step6picText">{{__('addPlaceByUser.نام عکس')}}</div>
                        </div>
                    </div>

                    <div class="step6 bodyOfSteps hidden" style="display: flex; flex-wrap: wrap; justify-content: space-around; flex-direction: column; text-align: center">
                        <div id="step6MainTitle" style="font-size: 20px; margin-top: 23px; text-align: center">
                            پس از بررسی اطلاعات <span class="headerCategoryName" style="font-size: 20px !important;"></span> شما به لیست <span class="headerCategoryName" style="font-size: 20px !important;"></span> های ما اضافه خواهد شد.
                        </div>
                        <a id="sampleLink" href="" target="_blank" style="font-size: 25px; margin-top: 15px; text-align: center"></a>
                    </div>
                </div>

                <div class="downBody">
                    <button class="btn boxPreviousBtn" type="button" id="previousStep" onclick="changeSteps(-1)" style="display: none">{{__('بازگشت')}}</button>
                    <div class="footerBox1"></div>
                    <button class="btn boxNextBtn" type="button" id="nextStep" onclick="changeSteps(1)" >{{__('شروع')}}</button>
                    <a href="{{route('main')}}" id="lastButton" class="hidden" style="width: 100%; display: flex;">
                        <button class="btn boxNextBtn" type="button" style="width: 100%; border-radius: 50px;">{{__('addPlaceByUser.اتمام و بازگشت به صفحه اصلی')}}</button>
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
                        <div class="myLocationIcon" onclick="getMyLocation()">
                            محل من
                        </div>
                    </div>
                </div>

                <div class="modal-footer" style="text-align: center">
                    <button class="btn btn-success" data-dismiss="modal">
                        {{__('تایید')}}
                    </button>
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
                            <span>{{__('توجه نمایید که عکس‌ما می‌بایست در فرمت های رایج تصویر و با حداکثر سایز 500 مگابایت باشد. تصاویر پیش از انتشار توسط ما بازبینی می‌گردد. لطفاً از آپلود تصاویری که با قوانین سایت مغایرت دارند اجتناب کنید.')}}</span>
                            <span class="footerPolicyLink">{{__('صفحه مقررات')}}</span>
                        </div>
                    </div>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer" style="text-align: center">
                    <button class="btn nextStepBtnTourCreation" data-dismiss="modal">
                        {{__('تایید')}}
                    </button>
                </div>

            </div>
        </div>
    </div>

    <script src="{{URL::asset('packages/dropzone/dropzone.js')}}"></script>
    <script src="{{URL::asset('packages/dropzone/dropzone-amd-module.js')}}"></script>

    <script type="text/javascript" src="{{URL::asset('packages/leaflet/leaflet.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('packages/leaflet/leaflet-wms-header.js')}}"></script>

    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
            @if(app()->getLocale() == 'fa')
                $("#name").farsiInput();
                $("#address").farsiInput();
                $("#recipes").farsiInput();
                $("#material").farsiInput();
                $("#placedescription").farsiInput();
            @endif
            autosize($('textarea'));
        });

        let categories = [
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
        let selectedCategory = null;
        let isPlace = true;
        let tryToGetFeatures = 3;
        let newPlaceId = 0;

        let myDropzone = new Dropzone("div#dropzone", {
            url: '{{route("upload.addPlaceByUser.storeImg")}}',
            paramName: "pic",
            dictDefaultMessage: '{{__('به سادگی عکس های خود را در این قاب بی اندازید و یا کلیک کنید')}}',
            timeout: 60000,
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            parallelUploads: 1,
            acceptedFiles: 'image/*',
            init: function() {
                this.on("sending", function(file, xhr, formData){
                    formData.append("id", newPlaceId);
                });
            },
        }).on('success', function(file, response){
            response = JSON.parse(response);
            if(response['status'] == 'ok'){
                 text =  '<div class="step6picBox">\n' +
                         '  <div class="step6pic">' +
                         '    <div class="deletedSlid">' +
                     '             <button class="btn btn-danger" onclick="deleteThisPic(this, \'' + response['result'] + '\')">حذف تصویر</button>' +
                     '        </div>\n' +
                         '    <img src="' + file['dataURL'] + '" style="max-height: 100%; max-width: 100%;">\n' +
                         '  </div>\n' +
                         '  <div class="step6picText">نام عکس</div>\n' +
                         '</div>';
                $(text).insertBefore($('#addNewPic'));
            }
            else
                myDropzone.removeFile(file);

        }).on('error', function(file, response, err){
            $(file.previewElement).find('.dz-error-message').find('span').text('آپود عکس شما با مشکل مواجه شد دوباره تلاش کنید');
        });

        categories.forEach((item, index) => {
            text =  '<div id="category_' + index + '" class="categories" onclick="selectCategory(this, ' + index + ');">\n' +
                    '   <div class="icons iconsOfCategories ' + item["icon"] + '"></div>\n' +
                    '   <div>' + item["name"] + '</div>\n' +
                    '</div>';
            $('#selectCategoryDiv').append(text);
        });

        function selectCategory (elem, _categoryIndex){

            $($('.choosedCategory')[0]).removeClass('choosedCategory');
            $(elem).addClass('choosedCategory');

            selectedCategory = categories[_categoryIndex];
            location.href = location.origin + location.pathname + '#' + selectedCategory.kind;
            $('#nextStep').attr('disabled', false);

            $('.selectCategoryDiv').removeClass('hidden');

            categories.forEach(item => {
                $('.headerCategoryIcon').removeClass(item['icon']);
            });
            $('.headerCategoryIcon').addClass(selectedCategory['icon']);
            $('.headerCategoryName').text(selectedCategory['name']);

            $('#step3MainTitle').text(selectedCategory['step3']);
            $('#step3MainUnderTitle').text(selectedCategory['step3Under']);
            $('#step4MainTitle').text(selectedCategory['step4']);
            $('#step5MainTitle').text(selectedCategory['step5']);
            $('#step6MainTitle').text(selectedCategory['step6']);

            $('.onlyForHotelsRest').css('display', 'none');
            $('.onlyForHotelsRestBoom').css('display', 'none');

            if(selectedCategory['id'] == 4 || selectedCategory['id'] == 3 )
                $('.onlyForHotelsRest').css('display', 'flex');

            if(selectedCategory['id'] == 4 || selectedCategory['id'] == 3 || selectedCategory['id'] == 12)
                $('.onlyForHotelsRestBoom').css('display', 'flex');

            if(selectedCategory['id'] == 10 || selectedCategory['id'] == 11) {
                $('#textForChooseCity').hide();
                $('#onlyForPlaces').hide();
                isPlace = false;
            }
            else{
                $('#onlyForPlaces').show();
                $('#textForChooseCity').show();
                isPlace = true;
            }

            $('#sampleText').text(selectedCategory['text']);
            $('#sampleLink').text(selectedCategory['sample']['name']);
            $('#sampleLink').attr('href', selectedCategory['sample']['link']);

            createInputPlace();
        }

        let currentSteps = 1;
        function changeSteps(inc){
            $('#nextStep').attr('disabled', true);

            if(currentSteps == 1 && selectedCategory == null)
                return;
            else {
                $('#nextStep').attr('disabled', false);
            }

            if(inc == 1) {
                if (currentSteps == 0 || currentSteps == 1) {
                    stepLog(currentSteps);
                    doChangeStep(inc);
                }
                else if (currentSteps == 2 && checkStep2()) {
                    stepLog(currentSteps);
                    doChangeStep(inc);
                }
                else if(currentSteps == 3 && checkStep3()) {
                    stepLog(currentSteps);
                    doChangeStep(inc);
                }
                else if(currentSteps == 4) {
                    stepLog(currentSteps);
                    storeData();
                }
                else if(currentSteps == 5 || currentSteps == 6) {
                    stepLog(currentSteps);
                    doChangeStep(inc);
                }
            }
            else
                doChangeStep(inc);

        }

        function deleteThisPic(_element, _name){
            $.ajax({
                type: 'post',
                url: '{{route("upload.addPlaceByUser.deleteImg")}}',
                data: {
                    _token: '{{csrf_token()}}',
                    name: _name,
                    id: newPlaceId
                },
                success: function(response){
                    try {
                        response = JSON.parse(response);
                        if(response['status'] == 'ok')
                            $(_element).parent().parent().parent().remove();
                    }
                    catch (e) {
                        console.log(e);
                    }
                },
                error: function(error){

                }
            })
        }

        function doChangeStep(inc){
            if(!checkLogin(location.href))
                return;

            $('html, body').animate({ scrollTop: 0 }, 'fast');

            $('.bodyOfSteps').addClass('hidden');
            $('.stepHeader').addClass('hidden');
            currentSteps += inc;

            if (currentSteps == 0) {
                $('#stepName').addClass('hidden');
                $('.selectCategoryDiv').addClass('hidden');
            }
            else {
                $('#stepName').removeClass('hidden');
                $('.selectCategoryDiv').removeClass('hidden');
            }

            if (currentSteps <= 0 || currentSteps >= 7)
                $('.steps').addClass('hidden');
            else
                $('.steps').removeClass('hidden');

            if(currentSteps > 1) {
                $('#previousStep').show();
                $('.footerBox1').css('width', 'calc(100% - 230px)')
            }
            else {
                $('#previousStep').hide();
                $('.footerBox1').css('width', 'calc(100% - 115px)')
            }

//for change name of button in steps
            if (currentSteps < 0){
                document.location.href = '{{route('main')}}';
                currentSteps = 0;
            } else if(currentSteps == 0){
                $('#nextStep').html('شروع');
                $('#previousStep').html('{{__('بازگشت')}}');
            }
            else if(currentSteps > 0 && currentSteps < 3){
                $('#nextStep').html('{{__('بعدی')}}');
                $('#previousStep').html('{{__('بازگشت')}}');
            }
            else if(currentSteps == 4){
                $('#nextStep').html('{{__('ذخیره')}}');
                $('#previousStep').html('{{__('بازگشت')}}');
            }
            else if(currentSteps == 5){
                $('#nextStep').html('{{__('بعدی')}}');
                $('.footerBox1').css('width', 'calc(100% - 115px)');
                $('#previousStep').css('display', 'none');
            }
            else if(currentSteps == 6){
                $('#nextStep').addClass('hidden');
                $('#lastButton').removeClass('hidden');
                $('#previousStep').css('display', 'none');
                $('#nextStep').addClass('endSectionButton');
                $('.footerBox1').addClass('endSectionFooter');
            }
            else if(currentSteps == 7){
                document.location.href = '{{route('main')}}';
            }
//for change color of each box of step
            $('.step' + currentSteps).removeClass('hidden');

            $(".bigCircle, .littleCircle").removeClass('completeStep').each(function() {
                if($(this).attr('data-val') <= currentSteps)
                    $(this).addClass('completeStep');
            });
//for change name of step
            if (currentSteps == 1){
                $('#stepName').html('{{__('addPlaceByUser.اولین مرحله')}}');
            } else if(currentSteps == 2){
                $('#stepName').html('{{__('addPlaceByUser.دومین مرحله')}}');
            } else if(currentSteps == 3){
                $('#stepName').html('{{__('addPlaceByUser.سومین مرحله')}}');
            } else if(currentSteps == 4){
                $('#stepName').html('{{__('addPlaceByUser.چهارمین مرحله')}}');
            } else if(currentSteps == 5){
                $('#stepName').html('{{__('addPlaceByUser.پنجمین مرحله')}}');
            } else if(currentSteps == 6){
                $('#stepName').html('{{__('addPlaceByUser.ششمین مرحله')}}');
            } else if(currentSteps == 7) {
                $('#stepName').html('{{__('addPlaceByUser.موفق شدید')}}');
            }
        }

        function storeData(){
            openLoading();

            let data = {};
            let featureName;

            data['kindPlaceId'] = selectedCategory['id'];
            data['name'] = $('#name').val();
            data['cityId'] = $('#cityId').val();
            data['stateId'] = $('#state').val();
            data['address'] = $('#address').val();
            data['lat'] = $('#lat').val();
            data['lng'] = $('#lng').val();
            data['phone'] = $('#phone').val();
            data['fixPhone'] = $('#fixPhone').val();
            data['email'] = $('#email').val();
            data['website'] = $('#website').val();
            data['description'] = $('#placedescription').val();

            switch(selectedCategory['kind']){
                case 'atraction':
                    featureName = 'amakenFeature[]';
                    break;
                case 'restaurant':
                    featureName = 'restaurantFeature[]';
                    data['restaurantKind'] = $('#restaurantKind').val();
                    break;
                case 'hotel':
                    featureName = 'hotelFeature[]';
                    data['hotelKind'] = $('#hotelKind').val();
                    data['hotelStar'] = $('#hotelStar').val();
                    break;
                case 'boomgardy':
                    featureName = 'boomgardyFeature[]';
                    data['room_num'] = $('#room_num').val();
                    break;
                case 'soghat':
                    featureName = 'soghatFeatures[]';
                    data['eatable'] = 1;
                    data['size'] = $('input[name="sizeSoghat"]:checked').val();
                    data['weight'] = $('input[name="weiSoghat"]:checked').val();
                    data['price'] = $('input[name="priceSoghat"]:checked').val();
                    break;
                case 'sanaye':
                    featureName = 'sanayeFeature[]';
                    data['eatable'] = 0;
                    data['size'] = $('input[name="sizeSanaye"]:checked').val();
                    data['weight'] = $('input[name="weiSanaye"]:checked').val();
                    data['price'] = $('input[name="priceSanaye"]:checked').val();
                    break;
                case 'ghazamahali':
                    featureName = 'foodFeatures[]';
                    data['kind'] = $('#foodKind').val();
                    let material = [];
                    for(let i = 1; i <= nowMaterialRow; i++){
                        let mat = [];
                        mat[0] = $("#materialName_" + i).val();
                        mat[1] = $("#materialVol_" + i).val();
                        material.push(mat);
                    }
                    data['material'] = material;
                    data['recipes'] = $('#recipes').val();
                    data['hotFood'] = $('input[name="hotFood"]:checked').val();
                    break;
            }

            vals = $("input[name='" + featureName + "']").map(function(){
                return [$(this).is(":checked") ? $(this).val() : '-'];
            }).get();
            data['features'] = [];
            vals.forEach(item => {
                if(item != '-')
                    data['features'].push(item);
            });

            data = JSON.stringify(data);

            $.ajax({
                type: 'post',
                url : '{{route("addPlaceByUser.store")}}',
                data: {
                    _token: '{{csrf_token()}}',
                    data: data
                },
                success: function (response) {
                    try {
                        response = JSON.parse(response);
                        if(response['status'] == 'ok'){
                            newPlaceId = response['result'];
                            doChangeStep(1);
                        }
                        else
                            console.log(response['status']);

                        closeLoading();
                    }
                    catch (e) {
                        console.log(e);
                        closeLoading();
                    }
                },
                error: function(err){
                    console.log(err);
                    closeLoading();
                }
            });

        }

        function checkStep2(){
            let name = $('#name').val();
            let city = $('#cityId').val();
            let error = true;
            let errorText = '';

            if(name.trim().length == 0) {
                $('#name').parent().css('background', '#ffafaf');
                error = false;
            }
            else
                $('#name').parent().css('background', '#ebebeb');

            if(city == 0){
                $('#cityId').parent().css('background', '#ffafaf');
                error = false;
            }
            else
                $('#cityId').parent().css('background', '#ebebeb');

            if(isPlace){
                let lat = $('#lat').val();
                let lng = $('#lng').val();
                let address = $('#address').val();

                if(address.trim().length == 0){
                    $('#address').css('background', '#ffafaf');
                    error = false;
                }
                else
                    $('#address').css('background', '#ebebeb');

                if(lat == 0 || lng == 0){
                    openWarning('{{__('addPlaceByUser.محل را بر روی نقشه مشخص کنید')}}');
                    error = false;
                }

                if(selectedCategory['id'] == 3 || selectedCategory['id'] == 4 || selectedCategory['id'] == 12){
                    let fixPhone = $('#fixPhone').val();
                    if(fixPhone.trim().length == 0){
                        $('#fixPhone').parent().css('background', '#ffafaf');
                        error = false;
                    }
                    else
                        $('#fixPhone').parent().css('background', '#ebebeb');
                }
            }

            return error;
        }

        function checkStep3(){
            if(selectedCategory['id'] == 12){
                let room_num = $('#room_num').val();
                if(room_num == 0 || room_num == null){
                    openWarning('{{__('addPlaceByUser.تعداد اتاق ها را مشخص کنید.')}}');
                    return false;
                }
            }
            if(selectedCategory['id'] == 4){
                let kind = $('#hotelKind').val();
                if(kind == 0){
                    openWarning('{{__('addPlaceByUser.نوع اقامتگاه خود را مشخص کنید.')}}');
                    return false;
                }
            }
            if(selectedCategory['id'] == 11){
                let haveMaterial = 0;
                for(let i = 1; i <= nowMaterialRow; i++){
                    let mat = [];
                    mat[0] = $("#materialName_" + i).val();
                    mat[1] = $("#materialVol_" + i).val();

                    if(mat[0].trim().length > 0 && mat[1].trim().length > 0)
                        haveMaterial++;
                }
                if(haveMaterial == 0){
                    openWarning('{{__('پر کردن مواد لازم برای غذا الزامی است.')}}');
                    return false;
                }


                let recipes = $('#recipes').val();
                if(recipes.trim().length < 2){
                    openWarning('{{__('پر کردن دستور پخت غذا الزامی است.')}}');
                    return false;
                }
            }

            return true;

        }

        function createInputPlace(){
            $('.inputBody').css('display', 'none');
            if(selectedCategory['id'] == 10)
                $('.inputBody_' + selectedCategory['id'] + '_' + selectedCategory['icon']).css('display', 'block');
            else
                $('.inputBody_' + selectedCategory['id']).css('display', 'block');
        }

        function changHotelKind(_value){
            if(_value == 1)
                $('#hotelRate').css('display', 'block');
            else
                $('#hotelRate').css('display', 'none');
        }

        function changeMaterialName(_element, _num){
            let value = $(_element).val();
            text = '{{__('مقدار')}} ' + value;
            $('#materialVol_' + _num).attr('placeholder', text);
        }

        nowMaterialRow = 1;
        numMaterialRow = 3;
        function addNewRow(_num){
            if(nowMaterialRow == _num){
                let name = $('#materialName_' + _num).val();
                let vol = $('#materialVol_' + _num).val();
                if(name.trim().length > 0 && vol.trim().length > 0){
                    nowMaterialRow++;
                    numMaterialRow++;
                    text = '<div class="row" style="display: flex; justify-content: space-around; direction: ltr">\n' +
                        '<div class="matInputTopDiv">\n' +
                        '<div class="stepInputBox ">\n' +
                        '<input class="stepInputBoxInput stepInputBoxMat" id="materialVol_' + numMaterialRow + '" style="text-align: right; padding-right: 10px;" placeholder="{{__('مقدار')}}" onchange="addNewRow(' + numMaterialRow + ')">\n' +
                        '</div>\n' +
                        '</div>\n' +
                        '<div class="matInputTopDiv">\n' +
                        '<div class="stepInputBox ">\n' +
                        '<input class="stepInputBoxInput stepInputBoxMat" id="materialName_' + numMaterialRow + '" style="text-align: right; padding-right: 10px;" placeholder="{{__('addPlaceByUser.چه چیزی نیاز است')}}" onkeyup="changeMaterialName(this, ' + numMaterialRow + ')" onchange="addNewRow(' + numMaterialRow + ')">\n' +
                        '</div>\n' +
                        '</div>\n' +
                        '</div>';

                    $('#materialRow').append(text);
                }
            }

        }

        function addPhotoInMobile(input){
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    formData = new FormData();
                    formData.append("_token", '{{csrf_token()}}');
                    formData.append("id", newPlaceId);
                    formData.append("pic", input.files[0]);

                    $.ajax({
                        type: 'post',
                        url : '{{route("upload.addPlaceByUser.storeImg")}}',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response){
                            try{
                                response = JSON.parse(response);
                                if(response['status'] == 'ok'){
                                    text =  '<div class="step6picBox">\n' +
                                        '  <div class="step6pic">' +
                                        '    <div class="deletedSlid">' +
                                        '             <button class="btn btn-danger" onclick="deleteThisPic(this, \'' + response['result'] + '\')">حذف تصویر</button>' +
                                        '        </div>\n' +
                                        '    <img src="' + e.target.result + '" style="max-height: 100%; max-width: 100%;">\n' +
                                        '  </div>\n' +
                                        '  <div class="step6picText">نام عکس</div>\n' +
                                        '</div>';

                                    $(text).insertBefore($('#addNewPic'));
                                }
                            }
                            catch (e) {}

                            $(input).val('');
                            $(input).files = null;

                        }
                    });

                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function stepLog(_step){
            $.ajax({
                type: 'post',
                url: '{{route("addPlaceByUser.createStepLog")}}',
                data: {
                    _token: '{{csrf_token()}}',
                    step: _step
                },
                success: function(){},
                error: function(){}
            })
        }

        let hash = location.hash;
        if(hash != '' && hash != '#'){
            for(i = 0; i < categories.length; i++){
                if('#'+categories[i].kind == hash){
                    selectCategory($('#category_' + i), i);
                    changeSteps(1);
                    break;
                }
            }
        }

    </script>

    <script>
        let cities = null;
        function changeState(_value){
            $('#cityId').val(0);
            $('#cityName').val('');

            if($('#noneState'))
                $('#noneState').remove();

            openLoading();
            $.ajax({
                type: 'post',
                url: '{{route("getCitiesDir")}}',
                data:{
                    _token: '{{csrf_token()}}',
                    stateId: _value,
                },
                success: function(response){
                    try{
                        cities = JSON.parse(response);
                        createSearchInput(findCity ,'{{__('شهر مورد نظر را وارد کنید...')}}');
                    }
                    catch (e) {
                        console.log(e)
                    }

                    closeLoading();
                },
                error: function(){
                    closeLoading()
                }
            })
        }

        function findCity(_element){
            let result = '';
            let likeCity = [];
            let value = _element.value;

            valeu = value.trim();
            if(value.length > 1){
                for(city of cities){
                    if(city.name.indexOf(value) > -1)
                        likeCity.push(city);
                }

                likeCity.forEach(item => {
                    if(item.isVillage == 0)
                        cityKind = 'شهر' ;
                    else
                        cityKind = 'روستا' ;

                    result +=   '<div onclick="selectCity(this)" class="resultSearch" cityId="' + item.id + '">' +
                        '   <p class="suggest cursor-pointer font-weight-700" id="suggest_1" style="margin: 0px">' + cityKind + ' ' + item.name + '</p>' +
                        '</div>';
                });

                if(result == ''){
                    result =   '<div onclick="selectCity(this)" class="resultSearch" cityId="-1">' +
                        '   <p class="suggest cursor-pointer font-weight-700" id="suggest_1" style="margin: 0px; color: blue; font-size: 20px !important;">' +
                        '<span id="newCityName">' + value + '</span> را اضافه کن</p>' +
                        '</div>';
                }

                setResultToGlobalSearch(result);
            }
            else
                setResultToGlobalSearch('');
        }

        function selectCity(_element){
            closeSearchInput();
            let id = $(_element).attr('cityId');
            let name;
            if(id == -1) {
                name = $("#newCityName").text();
                id = name;
            }
            else
                name = $(_element).children().first().text();

            $('#cityName').val(name);
            $('#cityId').val(id);
        }

        function chooseCity(){
            if(cities == null){
                openWarning('{{__('addPlaceByUser.ابتدا استان خود را مشخص کنید.')}}');
                return;
            }
            else
                createSearchInput(findCity ,'شهر خود را وارد کنید...');
        }
    </script>

    <script>
        let marker = null;
        let map = null;
        function initMap() {
            // var mapOptions = {
            //     center: {lat: 32.427908, lng: 53.688046},
            //     zoom: 5,
            //     styles: [
            //         {
            //             "featureType": "landscape",
            //             "stylers": [{"hue": "#FFA800"}, {"saturation": 0}, {"lightness": 0}, {"gamma": 1}]
            //         }, {
            //             "featureType": "road.highway",
            //             "stylers": [{"hue": "#53FF00"}, {"saturation": -73}, {"lightness": 40}, {"gamma": 1}]
            //         }, {
            //             "featureType": "road.arterial",
            //             "stylers": [{"hue": "#FBFF00"}, {"saturation": 0}, {"lightness": 0}, {"gamma": 1}]
            //         }, {
            //             "featureType": "road.local",
            //             "stylers": [{"hue": "#00FFFD"}, {"saturation": 0}, {"lightness": 30}, {"gamma": 1}]
            //         }, {
            //             "featureType": "water",
            //             "stylers": [{"hue": "#00BFFF"}, {"saturation": 6}, {"lightness": 8}, {"gamma": 1}]
            //         }]
            // };
            //
            // map = document.getElementById('map');
            // map = new google.maps.Map(map, mapOptions);
            // google.maps.event.addListener(map, 'click', function(event) {
            //     getLat(event.latLng);
            // });

            if(map == null) {
                map = L.map("mapDiv", {
                    minZoom: 1,
                    maxZoom: 20,
                    crs: L.CRS.EPSG3857,
                    center: [32.427908, 53.688046],
                    zoom: 5
                }).on('click', e => getLat(e.latlng));

                L.TileLayer.wmsHeader(
                    "https://map.ir/shiveh",
                    {
                        layers: "Shiveh:Shiveh",
                        format: "image/png",
                        minZoom: 1,
                        maxZoom: 20
                    },
                    [{header: "x-api-key", value: window.mappIrToken}]
                ).addTo(map);
            }

            let lat = 0;
            let lng = 0;
            let zoom = 10;
            let cityId = $('#cityId').val();

            var numbers = /^[0-9]+$/;

            if(cityId != 0 && cityId.match(numbers)){
                for(city of cities){
                    if(city['id'] == cityId){
                        lat = city['x'];
                        lng = city['y'];
                        zoom = 10;
                        break;
                    }
                }
            }
            else if(cityId != 0 && !cityId.match(numbers)){
                $numsss = 0;
                for(city of cities){
                    if(city['x'] != 0 && city['y'] != 0){
                        lat += city['x'];
                        lng += city['y'];
                        $numsss++;
                    }
                }
                lat /= $numsss;
                lng /= $numsss;
                zoom = 8;
            }

            if(lat != 0 && lng != 0)
                map.setView([lat, lng], zoom);

            if($('#lng').val() != 0 && $('#lat').val())
                setNewMarker();
        }

        function getLat(_location){
            $('#lat').val(_location.lat);
            $('#lng').val(_location.lng);
            setNewMarker();
        }

        function setNewMarker(){
            if(marker != null)
                map.removeLayer(marker);
            var latLng = [$('#lat').val(), $('#lng').val()];
            marker = L.marker(latLng).addTo(map);
            map.setView(latLng, 15);
        }

        function openMap(){
            $('#mapModal').modal('show');
            setTimeout(initMap, 500);
        }

        function getMyLocation(){
            if (navigator.geolocation)
                navigator.geolocation.getCurrentPosition(position => getLat({lat: position.coords.latitude, lng: position.coords.longitude}));
            else
                console.log("Geolocation is not supported by this browser.");
        }

    </script>

@stop
