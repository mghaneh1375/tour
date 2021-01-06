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
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/shazdeDesigns/tourCreation.css?v=1')}}"/>
</head>

<body id="BODY_BLOCK_JQUERY_REFLOW"
      class=" r_map_position_ul_fake ltr domn_en_US lang_en long_prices globalNav2011_reset rebrand_2017 css_commerce_buttons flat_buttons sitewide xo_pin_user_review_to_top track_back">

<div id="PAGE" class="filterSearch redesign_2015 non_hotels_like desktop scopedSearch">
    @include('layouts.placeHeader')
    <div class="ppr_rup ppr_priv_hr_atf_north_star_nostalgic">

        <div class="atf_header_wrapper">
            <div class="atf_header ui_container is-mobile full_width">

                <div class="ppr_rup ppr_priv_location_detail_header relative-position">
                    <h1 id="HEADING"  property="name">
                        <b class="tourCreationMainTitle">شما در حال ایجاد یک تور جدید هستید</b>
                    </h1>
                    <div class="tourAgencyLogo circleBase type2"></div>
                    <b id="tourAgencyName">آژانس ستاره طلایی</b>
                </div>
            </div>
        </div>

        <div class="atf_meta_and_photos_wrapper">
            <div class="atf_meta_and_photos ui_container is-mobile easyClear">
                <div class="prw_rup darkGreyBox" id="StartCreationTourBox">
                    <h1 id="preStartText">پیش از شروع ....</h1>
                    <p>
                        ما برای جلب رضایت کاربرانمان اطلاعات کاملی را از شما درخواست می‌کنیم. مسئولیت صحت اطلاعات وارد و یا کافی بودن آن برعهده‌ی شماست. اما پیشنهاد ما بر ارائه‌ی کامل و دقیق اطلاعات مطابق مراحل گام به گام طراحی شده می‌باشد. توجه کنید تمام تلاش ما حمایت همزمان از ارائه‌دهنده و مصرف‌کننده می‌باشد و ارائه‌ی هرگونه اطلاعات نادرست و یا ناقض به گونه‌ای که احتمال استفاده از آن برای تضییع حقوق مصرف‌کنندگان باشد از نظر ما مردود است. با ارائه‌ی شفاف اطلاعات به حقوق یکدیگر حترام می‌گذاریم. ما هم تلاش خود را به کتر بردیم تا با استفاده از داده‌های شما انتخاب کاربران را آگاهانه‌تر نماییم. خواهشمندیم به مرام‌نامه‌ی ما احترام بگذارید و تا حد امکان اطلاعاتی جامع، کامل و دقیق ارائه دهید.
                    </p>
                    <p>
                        برای مشاهده‌ی صفحه‌ی قوانین و مقررات
                        <a>اینجا</a>
                        را کلیک کنید.
                    </p>
                    <p>
                        برای مشاهده‌ی صفحه‌ی ارائه‌دهدگان دیگر
                        <a>اینجا</a>
                        را کلیک کنید.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div id="termsAndConditionMainBox" class="Hotel_Review prodp13n_jfy_overflow_visible lightGreyBox">
        <div class="ui_container">
            <div class="menu ui_container whiteBox" id="termsAndConditionAcceptBox">
                <div id="termsAndConditionText">
                    <span>اگر با مرامنامه‌ی ما و قوانین و مقررات سایت هستید، لطفاً اطلاعات لازم را آماده نموده و شروع نمایید.</span>
                    <span>نگران نباشید. شما همواره از طریق پروفایل خود امکان ادامه ایجاد تور را خواهید داشت. هر اطلاعاتی که وارد می‌کنید به صورت موقت ذخیره می‌شود مگر آن‌که هشداری مبنی بر عدم صحت آن دریافت کنید.</span>
                    <span>این فرآیند تقریباً مابین ... الی ... دقیقه زمان می‌برد.</span>
                </div>
                <a href="{{route('tour.create.stage.one')}}">
                    <button id="termsAndConditionBtn" class="btn nextStepBtnTourCreation">شروع کنید</button>
                </a>
            </div>
        </div>
    </div>
@include('layouts.footer.layoutFooter')
</div>

</body>
</html>
