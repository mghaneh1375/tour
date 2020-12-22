<?php $placeMode = "ticket";
$state = "تهران";
$kindPlaceId = 10; ?>
<!DOCTYPE html>
<html>
<head>
    @include('layouts.topHeader')
    @include('layouts.phonePopUp')

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/theme2/home_rebranded.css?v=4')}}"/>
    <title>صفحه اصلی</title>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/theme2/long_lived_global_legacy_2.css?v=2')}}"/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/masthead-saves.css?v=2')}}'/>
    <link rel='stylesheet' type='text/css' media='screen, print'
          href='{{URL::asset('css/theme2/hr_north_star.css?v=2')}}'/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/icons.css?v=1')}}'/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/passStyle.css?v=1')}}'/>

    <script src= {{URL::asset("js/calendar.js") }}></script>
    <script src= {{URL::asset("js/jalali.js") }}></script>
</head>

<body id="BODY_BLOCK_JQUERY_REFLOW"
      class=" r_map_position_ul_fake ltr domn_en_US lang_en long_prices globalNav2011_reset rebrand_2017 css_commerce_buttons flat_buttons sitewide xo_pin_user_review_to_top track_back">

<div id="PAGE" class="filterSearch redesign_2015 non_hotels_like desktop scopedSearch">
    @include('layouts.placeHeader')
<div class="mainDiv">

    @include('layouts.buyTicket')

    <div>
        <div>
            <div class="textTitle" style="display: inline-block"> کد تخفیف </div>
            <div style="display: inline-block"> اگر کد تخفیف دارید در اینجا وارد کنید تا در قیمت نهایی اعمال شود </div>
        </div>
        <div style="width: 55%">
            <div class="inputBox" style="width: 45%;">
                <div class="inputBoxText" style="width: 40%">
                    <div style="display: inline-block; position: relative"> کد تخفیف را وارد کنید </div>
                </div>
                <input class="inputBoxInput" style="width: 60%" type="text" placeholder="xxxxxxxxx">
            </div>
            <div style="display: inline-block; margin: 10px 15px; float: left">
                <button class="btn afterBuyBtn" type="button" style="background-color: var(--koochita-light-green); line-height: 22px; margin: 0 !important;"> اعمال کد تخفیف </button>
                <div style="font-size: 0.8em; color: red; float: left; margin-right: 10px"> متأسفانه کد تخفیف معتبر نمی باشد <br>  کد تخفیف وارد شده قبلا استفاده شده است </div>
            </div>
        </div>
        <div> در صورت استفاده از کد تخفیف برای این خرید دیگر امکان خرج کردن امتیاز میسر نمی باشد </div>
    </div>

    <div class="inlineBorder"></div>

    <div style="background-color: #d2fefa; padding: 10px; border-radius: 4px; box-shadow: 0px 0px 14px #c5c5c5">
        <div class="textTitle" style="display: inline-block; color: var(--koochita-light-green) !important;"> خرج کردن امتیاز </div>
        <div> امتیاز خود را به تخفیف تبدیل کنید. توجه داشته باشید در صورت خرج کردن امتیاز رتبه و نشان های افتخار شما از بین نخواهد رفت </div>
        <div style="font-size: 0.8em"> برای اطلاعات بیشتر به صفحه  <a href="" style="color: #050c93"> راهنمای امتیازات  </a> مراجعه کنید </div>
        <div class="inputBox" style="width: 18%;">
            <div class="inputBoxText" style="width: 40%"> امتیاز موجود </div>
            <div class="inputBoxInput" style="width: 60%"> 1005000 </div>
        </div>
        <div>
            برای این بلیط هر امتیاز شما معادل
            <span style="color: #92321b"> 1000 </span>
            تومان تخفیف می باشد. توجه حداکثر مبلغ قابل تخفیف
            <span style="color: #92321b"> 50000 </span>
            تومان می باشد
        </div>
        <div>
            <div class="inputBox" style="width: 18%;">
                <div class="inputBoxText" style="width: 60%">
                    <div style="display: inline-block; position: relative"> چقدر امتیاز خرج می کنید </div>
                </div>
                <input class="inputBoxInput" style="width: 40%" type="text" placeholder="xxxxxxxxx">
            </div>
            <div class="btn" style="background-color: #92321b; color: white; margin-top: 2px; cursor: text;"> ضرب در 1000 تومان </div>
            <div class="inputBox" style="width: 10%; background-color: var(--koochita-light-green); color: white; border: none">
                <div class="inputBoxText" style="width: 60%"> مبلغ تخفیف </div>
                <div class="inputBoxInput" style="width: 40%"> 50000 </div>
            </div>
        </div>
        <div> در صورت انصراف از خرید در آخرین مرحله یا ایجاد هرگونه مشکل امتیاز خرج شده شما به حساب کاربری شما باز می گردد </div>
        <div>
            <button class="btn afterBuyBtn" type="button" style="background-color: var(--koochita-light-green); line-height: 22px;"> خرجش کن </button>
            <div style="font-size: 0.8em; color: red; display: inline-block; margin-right: 10px"> لطفا امتیاز موردنظر برای خرج کردن را وارد نمایید </div>
        </div>
        <div> در صورت خرج امتیاز برای این خرید دیگر امکان استفاده از کد تخفیف نمی باشد </div>
    </div>

    <div style="margin-top: 20px">
        <div style="display: inline-block"> با انتخاب دکمه تأیید و پرداخت شما به صفحه پرداخت فروشنده خدمت متصل می شوید و تنها کافی است مبلغ بلیط را تأیید و پرداخت نمایید </div>
        <div style="color: #92321b" id="msgErr"></div>
        <div style="text-align: left">
            <button onclick="doPayment(1)" class="btn afterBuyBtn" type="button" style="background-color: var(--koochita-light-green)"> تأیید و پرداخت </button>
        </div>
        <div style="text-align: left">
            <button class="btn afterBuyBtn" type="button" style="background-color: #92321b"> انصراف </button>
        </div>
    </div>

</div>

</div>

@include('layouts.footer.layoutFooter')

</body>
</html>