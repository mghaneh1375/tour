<!doctype html>
<html lang="{{app()->getLocale()}}">
<head>
    @include('layouts.topHeader')

    <link rel="stylesheet" href="{{URL::asset('css/pages/news.css?v='.$fileVersions)}}">

    <style>
        .addNewReviewButtonMobileFooter{
            display: none;
        }
    </style>

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

    <div class="mobileFiltersButtonTabs hideOnScreen">
        <div class="tabs">
            <div class="tab filterIcon" onclick="openMyModal('newCategoryMobileModal')">دسته بندی</div>
            <div class="tab searchIcon" onclick="openMyModal('newsSearchMobile')">جستجو</div>
        </div>
    </div>

    <div id="newCategoryMobileModal" class="modalBlackBack fullCenter hideOnScreen" style="transition: .7s">
        <div class="gombadi">
            <div class="mobileFooterFilterPic" style="max-height: 400px">
                <img src="{{URL::asset('images/mainPics/news/news.jpg')}}" style="width: 100%">
                <div class="gradientWhite">
                    <div class="closeThisModal iconClose" onclick="closeMyModal('newCategoryMobileModal')"></div>
                </div>
            </div>
            <div class="newsCategoryListMFooter">
                <div class="list">
                    @foreach($newsCategories as $cat)
                        <a href="{{route('news.list', ['kind' => 'category', 'content' => $cat->name])}}" class="categ">
                            <div class="categIcon" style="{{$cat->icon == 'sogatsanaie.svg' ? 'margin: 0px;' : ''}}">
                                <img src="{{URL::asset('images/mainPics/news/icons/'.$cat->icon)}}" alt="{{$cat->name}}">
                            </div>
                            <div class="title">{{$cat->name}}</div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div id="newsSearchMobile" class="modalBlackBack fullCenter hideOnScreen">
        <div class="gombadi">
            <div class="mobileFooterFilterPic" style="max-height: 400px">
                <img src="{{URL::asset('images/mainPics/news/news.jpg')}}" style="width: 100%">
                <div class="gradientWhite">
                    <div class="closeThisModal iconClose" onclick="closeMyModal('newsSearchMobile')"></div>
                </div>
            </div>
            <div class="newsCategoryListMFooter searchInMobileNewsBody" style="height: 100%">
                <div class="title">جستجو در اخبار</div>
                <div class="fullyCenterContent">
                    <input type="text" id="newsSearchInputInMobile" class="searchInput" placeholder="عبارت خود را وارد کنید...">
                </div>
                <div class="fullyCenterContent" style="margin-top: 20px">
                    <button class="searchButton" onclick="searchInNews('newsSearchInputInMobile')">جستجو</button>
                </div>
            </div>
        </div>
    </div>


    @yield('script')

    <script>
        var newCategoryMobileModalElement = $('#newCategoryMobileModal');
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

        function searchInNews(_inputId){
            var value = $('#'+_inputId).val();

            if(value.trim().length > 2){
                openLoading();
                location.href = `{{url("/news/list/content")}}/${value}`;
            }
        }

        function resizeMobileListHeight(){
            var height = newCategoryMobileModalElement.find('.mobileFooterFilterPic').height() + 5;
            newCategoryMobileModalElement.find('.newsCategoryListMFooter').css('height', `calc(100% - ${height}px)`);
        }

        $(window).on('resize', resizeMobileListHeight);
        $(window).ready(() => resizeMobileListHeight());
        getAdv();

    </script>

    @include('layouts.footer.layoutFooter')

</body>
</html>
