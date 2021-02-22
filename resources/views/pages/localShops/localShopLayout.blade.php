<!doctype html>
<html lang="{{\App::getLocale()}}">
<head>
    @include('layouts.topHeader')


    <link rel="stylesheet" href="{{URL::asset('css/pages/localShops/mainLocalShops.css?v='.$fileVersions)}}">
    @yield('head')
</head>
<body>

    @include('general.forAllPages')

    @include('layouts.header1')

    <div class="mainAllBody">
        @yield('body')
    </div>

    @include('layouts.footer.layoutFooter')

    @yield('script')
</body>
</html>
