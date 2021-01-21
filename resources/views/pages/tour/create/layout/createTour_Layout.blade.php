<!DOCTYPE html>
<html lang="fa">
<head>
    @include('layouts.topHeader')
    <title>صفحه اصلی</title>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/theme2/home_rebranded.css?v=4')}}"/>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/theme2/long_lived_global_legacy_2.css?v=2')}}"/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/masthead-saves.css?v=2')}}'/>
    <link rel='stylesheet' type='text/css' media='screen, print' href='{{URL::asset('css/theme2/hr_north_star.css?v=2')}}'/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/passStyle.css?v=1')}}'/>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/shazdeDesigns/tourCreation.css?v=1')}}"/>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/shazdeDesigns/abbreviations.css?v=1')}}"/>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/clockpicker.css?v=1')}}"/>

    <script src= {{URL::asset("js/clockpicker.js") }}></script>


    <style>
        .chooseTourKind{
            background: rgb(77, 199, 188) !important;
            color: white !important;
        }
        .tourLevelIcons::before{
            width: 100%;
            display: flex;
            font-weight: normal;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
        }
        .tourLevelIcons{
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            cursor: pointer;
        }
        .tourKindIcons:hover{
            background: var(--koochita-light-green);
        }

    </style>

    @yield('head')
</head>

<body>

<div>
    @include('general.forAllPages')

    @include('layouts.header1')

    @yield('body')

    @include('layouts.footer.layoutFooter')
</div>

</body>
</html>
