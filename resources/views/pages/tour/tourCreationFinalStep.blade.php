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
                <div class="prw_rup darkGreyBox tourDetailsMainFormHeading">
                    <b class="formName">تمام شد :)</b>
                    <div class="tourCreationStepInfo">
                        <span>
                            گام
                            <span>6</span>
                            از
                            <span>6</span>
                        </span>
                        <span>
                            آخرین ویرایش
                            <span>
                                {{$tour->lastUpdate}}
                            </span>
                            <span>
                                {{$tour->lastUpdateTime}}
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="supportingInfosMainBox" class="Hotel_Review prodp13n_jfy_overflow_visible lightGreyBox">
        <div class="ui_container">
            <div class="menu ui_container whiteBox" id="supportingInfos">
                <div id="">
                    <span>تمامی اطلاعات تور شما با موفقیت ثبت گردید و در حال بررسی می‌باشد. شما می‌توانید وضعیت تور خود را پیش از انتظار و پس از آن از داخل پنل کاربری خود و تحت عنوان مدیریت کسب‌ و کار بررسی نمایید. اگر در پروسه‌ی بررسی تور مشکلی پیش بیاید شما را در جریان می‌گذاریم.</span>
                    <span>کد شناسایی تور: 100-001-1200-01</span>
                    <span>با تشکر از شما</span>
                </div>
                <a href="{{route('profile')}}">
                    <button id="goToProfile" class="btn float-left">رفتن به پروفایل</button>
                </a>
            </div>
        </div>
    </div>

@include('layouts.footer.layoutFooter')

</body>
</html>