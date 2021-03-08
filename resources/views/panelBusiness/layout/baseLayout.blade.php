<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <meta name="theme-color" content="#30b4a6"/>
    <meta name="msapplication-TileColor" content="#30b4a6">
    <meta name="msapplication-TileImage" content="{{URL::asset('images/icons/mainIcon.png')}}">
    <meta name="twitter:card" content="summary"/>
    <meta property="og:url" content="{{Request::url()}}" />
    <meta property="og:site_name" content="سامانه جامع گردشگری کوچیتا" />
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <style>
        @font-face {
            font-family: 'IRANSansWeb';
            font-style: normal;
            font-weight: normal;
            src: url('{{URL::asset("fonts/eot/IRANSansWeb(FaNum).eot")}}');
            src: url('{{URL::asset("fonts/eot/IRANSansWeb(FaNum).eot?#iefix")}}') format('embedded-opentype'),  /* IE6-8 */
            url('{{URL::asset("fonts/woff2/IRANSansWeb(FaNum).woff2")}}') format('woff2'),  /* FF39+,Chrome36+, Opera24+*/
            url('{{URL::asset("fonts/woff/IRANSansWeb(FaNum).woff")}}') format('woff'),  /* FF3.6+, IE9, Chrome6+, Saf5.1+*/
            url('{{URL::asset("fonts/ttf/IRANSansWeb(FaNum).ttf")}}') format('truetype');
        }

        @font-face {
            font-weight: normal;
            font-style: normal;
            font-family: 'Shazde_Regular2';
            src: url('{{URL::asset("fonts/shazdemosafer/Shazdemosafer.eot?v003.200")}}');
            src: url('{{URL::asset("fonts/shazdemosafer/Shazdemosafer.eot?v003.200#iefix")}}') format('embedded-opentype'),
            url('{{URL::asset("fonts/shazdemosafer/Shazdemosafer.woff2?v003.200")}}') format('woff2'),
            url('{{URL::asset("fonts/shazdemosafer/Shazdemosafer.woff?v003.200")}}') format('woff'),
            url('{{URL::asset("fonts/shazdemosafer/Shazdemosafer.ttf?v003.200")}}') format('truetype'),
        }

        @font-face {
            font-weight: normal;
            font-style: normal;
            font-family: 'Shazde_Regular';
            src: url('{{URL::asset("fonts/shazdemosafer/Shazdemosafer_Regular.eot?v003.200")}}');
            src: url('{{URL::asset("fonts/shazdemosafer/Shazdemosafer_Regular.eot?v003.200#iefix")}}') format('embedded-opentype'),
            url('{{URL::asset("fonts/shazdemosafer/Shazdemosafer_Regular.woff2?v003.200")}}') format('woff2'),
            url('{{URL::asset("fonts/shazdemosafer/Shazdemosafer_Regular.woff?v003.200")}}') format('woff'),
            url('{{URL::asset("fonts/shazdemosafer/Shazdemosafer_Regular.ttf?v003.200")}}') format('truetype'),
        }
        @font-face {
            font-weight: normal;
            font-style: normal;
            font-family: 'shazdemosafer-tour';
            src: url('{{URL::asset("fonts/shazdemosafer-tour.otf")}}');
            src: url('{{URL::asset("fonts/shazdemosafer-tour.otf")}}') format('embedded-opentype'),
            url('{{URL::asset("fonts/shazdemosafer-tour.woff2?v003.200")}}') format('woff2'),
            url('{{URL::asset("fonts/shazdemosafer-tour.woff?v003.200")}}') format('woff'),
            url('{{URL::asset("fonts/shazdemosafer/Shazdemosafer.ttf?v003.200")}}') format('truetype');
        }

        @font-face {
            font-weight: normal;
            font-style: normal;
            font-family: 'Glyphicons Halflings';
            src: url('{{URL::asset("fonts/glyphicons-halflings-regular.eot")}}');
            src: url('{{URL::asset("fonts/glyphicons-halflings-regular.eot")}}') format('embedded-opentype'),
            url('{{URL::asset("fonts/glyphicons-halflings-regular.woff2?v003.200")}}') format('woff2'),
            url('{{URL::asset("fonts/glyphicons-halflings-regular.woff?v003.200")}}') format('woff'),
            url('{{URL::asset("fonts/glyphicons-halflings-regular.ttf?v003.200")}}') format('truetype');
        }

        @font-face {
            font-family: Shin;
            src: url('{{URL::asset("fonts/shin.ttf")}}');
        }

        @font-face {
            font-family: Afsane;
            src: url('{{URL::asset("fonts/AFSANEH.ttf")}}');
        }
    </style>

    <link rel="icon" href="{{URL::asset('images/icons/KOFAV0.svg')}}" sizes="any" type="image/svg+xml">
    <link rel="apple-touch-icon-precomposed" href="{{URL::asset('images/icons/KOFAV0.svg')}}" sizes="any" type="image/svg+xml">
{{--    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/fonts.css?v='.$fileVersions)}}' media="all"/>--}}
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/bootstrap/bootstrap-rtl.min.css?v='.$fileVersions)}}'  media="all"/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/icons.css?v='.$fileVersions)}}' media="all"/>

    <link rel="stylesheet" href="{{URL::asset('packages/fontAwesome6/css/all.min.css')}}">

    <link rel="stylesheet" href="{{URL::asset('BusinessPanelPublic/css/allBusinessPanel.css')}}">

    <script src="{{URL::asset('js/jquery-3.4.1.min.js')}}"></script>
    <script src="{{URL::asset('packages/fontAwesome6/js/all.min.js')}}"></script>

    <script async src="{{URL::asset('js/bootstrap/bootstrap-rtl.min.js')}}"></script>
    <script src="{{URL::asset('BusinessPanelPublic/js/allBusinessPanel.js')}}"></script>
    <script>
        $.ajaxSetup({
            xhrFields: { withCredentials: true },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
    </script>

    @yield('head')

</head>
<body>
    @include('panelBusiness.layout.businessPanelGeneral')

    @include('panelBusiness.layout.header')

    @if(auth()->check())
        @include('panelBusiness.layout.sideBar')
    @endif

    <div class="mainBodySection">
        @yield('body')
    </div>


    @yield('modals')

    @yield('script')
</body>
</html>
