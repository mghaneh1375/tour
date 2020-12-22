<!DOCTYPE html>
<html>

<head>
    @section('header')

        @include('layouts.topHeader')

        <link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/long_lived_global_legacy_2.css?v=1')}}'/>
        <link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/short_lived_global_legacy.css?v=1')}}'/>
        <link rel="stylesheet" href="{{URL::asset('css/theme2/help.css?v=1')}}">
        <link rel='stylesheet' type='text/css' media='screen, print' href='{{URL::asset('css/theme2/universal_new.css?v=1')}}' data-rup='universal_new'/>
        <link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/masthead-saves.css?v=1')}}' data-rup='long_lived_global_legacy'/>
        <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/bodyProfile.css?v=1')}}' data-rup='long_lived_global_legacy'/>

        <link rel="stylesheet" type="text/css" media="screen, print" href="{{URL::asset('css/theme2/mbr_profile.css?v=1')}}"/>
        <!--[if IE 6]>
        <link rel="stylesheet" type="text/css" media="screen, print" href="{{URL::asset('css/theme2/winIE6.css?v=1')}}" />
        <![endif]-->
        <!--[if IE 7]>
        <link rel="stylesheet" type="text/css" media="screen, print" href="{{URL::asset('css/theme2/winIE7.css?v=1')}}" />
        <![endif]-->

        <link rel='stylesheet' type='text/css' media='screen, print' href='{{URL::asset('css/theme2/modules_member_center.css?v=4')}}' data-rup='modules_member_center'/>
        <link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/persistent_header_achievements.css?v=2')}}' data-rup='persistent_header_achievements'/>

        <script >
            var getRecentlyPath = '{{route('recentlyViewed')}}';
        </script>


        <style>
            .activeTripStyle{
                background-color: var(--koochita-light-green);
                color: white;
                visibility: visible;
            }
        </style>
    @show
</head>

<body class="ltr domn_en_US lang_en long_prices globalNav2011_reset rebrand_2017 css_commerce_buttons flat_buttons sitewide xo_pin_user_review_to_top track_back position-relative">

@include('general.forAllPages')

@include('layouts.pop-up-create-trip')

<div id="fb-root"></div>

<div id="PAGE" class="profilePage non_hotels_like desktop scopedSearch position-relative">

    @include('layouts.header1')

    <div id="MAINWRAP" class="position-relative">

        <style>
            .secondHeader{
                background: var(--koochita-yellow);
                color: black;
                display: flex;
                padding: 10px 0px;
            }
            .secondHeader .container > a{
                color: black;
                margin-left: 25px;
                font-weight: bold;
            }
        </style>

        <div class="secondHeader">
            <div class="container" style="direction: rtl">
                <a href="{{route('profile')}}">صفحه کاربری</a>
                <a href="{{route('myTrips')}}">سفرهای من</a>
{{--                <a href="{{route('profile.bookmark')}}">نشون کرده</a>--}}
{{--                <a href="{{route('profile')}}">اعلانات</a>--}}
                <a href="{{route('profile.accountInfo')}}">تنظیمات</a>
            </div>
        </div>

        @yield('main')
    </div>
</div>

@include('layouts.footer.layoutFooter')

</body>

</html>