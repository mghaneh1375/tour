<!doctype html>
<html lang="{{app()->getLocale()}}">
<head>

    @include('layouts.topHeader')

    <link rel="stylesheet" href="{{URL::asset('css/pages/news.css')}}">

    @yield('head')


    <style>

    </style>

</head>
<body>

    @include('general.forAllPages')

    @include('layouts.header1')


    <div class="container-fluid secHeadMain hideOnPhone">
        <div class="container secHeadNavs">
            <div class="secHeadTabs">
                <a href="{{route('news.main')}}" style="color: #16174f">خانه</a>
            </div>
            @foreach($newsCategories as $category)
                <div class="secHeadTabs {{count($category->sub) > 0 ? 'arrowAfter' : ''}}">
                    <span>{{$category->name}}</span>
                    <div class="secHeadTabsSubList">
                        @foreach($category->sub as $sub)
                            <a href="#">{{$sub->name}}</a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>


    <div class="container">
        @yield('body')
    </div>


    @yield('script')

    @include('layouts.footer.layoutFooter')

</body>
</html>
