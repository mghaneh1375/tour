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

    <link rel="stylesheet" href="{{URL::asset('BusinessPanelPublic/css/fonts.css?v='.$fileVersions)}}">

    <link rel="icon" href="{{URL::asset('images/icons/KOFAV0.svg')}}" sizes="any" type="image/svg+xml">
    <link rel="apple-touch-icon-precomposed" href="{{URL::asset('images/icons/KOFAV0.svg')}}" sizes="any" type="image/svg+xml">

    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/bootstrap/bootstrap-rtl.min.css')}}'  media="all"/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/icons.css?v='.$fileVersions)}}' media="all"/>

    <link rel="stylesheet" href="{{URL::asset('css/theme2/topHeaderStyles.css?v='.$fileVersions)}}">
    <link rel="stylesheet" href="{{URL::asset('css/component/generalFolder.css?v='.$fileVersions)}}">
    <link rel="stylesheet" href="{{URL::asset('BusinessPanelPublic/css/allBusinessPanel.css?v='.$fileVersions)}}">

    <script src="{{URL::asset('js/jquery-3.4.1.min.js')}}"></script>
    <script src="{{URL::asset('js/bootstrap/bootstrap-rtl.min.js')}}"></script>
    <script src="{{URL::asset('BusinessPanelPublic/js/allBusinessPanel.js?v='.$fileVersions)}}"></script>

    <script>
        $.ajaxSetup({
            xhrFields: { withCredentials: true },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
    </script>

    @yield('head')

    <link rel="stylesheet" href="{{URL::asset('packages/fontAwesome6/css/all.min.css')}}">
    <script src="{{URL::asset('packages/fontAwesome6/js/all.min.js')}}"></script>

    <script>
        var csrfTokenGlobal = '{{csrf_token()}}';
    </script>

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
