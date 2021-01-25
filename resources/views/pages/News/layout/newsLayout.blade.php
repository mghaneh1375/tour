<!doctype html>
<html lang="{{app()->getLocale()}}">
<head>
    @include('layouts.topHeader')

    <link rel="stylesheet" href="{{URL::asset('css/pages/news.css?v='.$fileVersions)}}">

    @yield('head')
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
                    <a href="{{route('news.list', ['kind' => 'category', 'content' => $category->name])}}" style="color: black">{{$category->name}}</a>
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

    <script>
        function getAdv(){
            var edsNeedType = [];
            var eds = $('.edSections');
            for(var i = 0; i < eds.length; i++)
                edsNeedType.push($(eds[i]).attr('data-kind'));


            edsNeedType = JSON.stringify(edsNeedType);
            $.ajax({
                type: 'GET',
                url: '{{route("advertisement.get")}}?section=news&data='+edsNeedType,
                success: response =>{
                    if(response.status == 'ok')
                        fillAdvs(response.result);
                }
            })
        }

        function fillAdvs(_advs){
            var eds = $('.edSections');
            for(var i = 0; i < eds.length; i++){
                var type = $(eds[i]).attr('data-kind');
                var html = '';
                var selectedIndex = -1;
                for(var j = 0; j < _advs.length; j++){
                    if(_advs[j].kind == type){
                        _advs[j].ads.map(item => {
                            html += `<a href="${item.url}" class="fullyCenterContent">
                                        <picture>
                                            <source media="(max-width:767px)" srcset="${item.pics.mobile}">
                                            <source media="(min-width:767px)" srcset="${item.pics.pc}">
                                            <img src="${item.pics.pc}" alt="${item.title}" style="width: 100%">
                                        </picture>
                                    </a>`;
                        });
                        selectedIndex = j;
                        break;
                    }
                }

                if(selectedIndex != -1)
                    _advs.splice(selectedIndex, 1);

                if(html != '')
                    $(eds[i]).html(html);
                else
                    $(eds[i]).remove();
            }
        }

        getAdv();
    </script>

    @include('layouts.footer.layoutFooter')

</body>
</html>
