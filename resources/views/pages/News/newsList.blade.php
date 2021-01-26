@extends('pages.News.layout.newsLayout')


@section('head')

    <style>

    </style>
@endsection


@section('body')
    <div class="row listHeaderRow">
        <h2 style="font-weight: bold;">لیست {{$header}}</h2>
    </div>

    <div class="row">
        <div class="col-md-2 hideOnPhone" >
            <div data-kind="ver_b" class="edSections edBetween onED"></div>
            <div data-kind="ver_s" class="edSections edBetween onED"></div>
            <div data-kind="ver_s" class="edSections edBetween onED"></div>
        </div>

        <div class="col-md-10">
            <div id="listBody" class="listBody"></div>
            <div id="bottomMainList"></div>
        </div>
    </div>


@endsection


@section('script')
    <script>
        var mustBeTaken = true;
        var isFinish = false;
        var inTake = false;

        var kind = '{{$kind}}';
        var content = '{{$content}}';
        var page = 0;
        var take = 8;

        function getListElemes(){
            openLoading();
            if(!inTake && !isFinish) {
                inTake = true;
                $.ajax({
                    type: 'GET',
                    url: `{{route("news.list.getElements")}}?kind=${kind}&content=${content}&take=${take}&page=${page}`,
                    success: response => {
                        if(response.status == 'ok')
                            createListElements(response.result);
                        else
                            getsList();
                    },
                    error: err => {
                        console.log(err);
                        getsList();
                    }
                })
            }
        }

        function getsList(){
            inTake = false;
            closeLoading();
        }

        function createListElements(_news){
            var html = '';

            if(_news.length != take)
                isFinish = true;

            _news.map(item => {
                html += `<div class="newsRow">
                            <a href="${item.url}" class="picSec fullyCenterContent">
                                <img src="${item.pic}" alt="${item.keyword}" class="resizeImgClass" onload="fitThisImg(this)">
                            </a>
                            <div class="content">
                                <a href="${item.url}" class="title">${item.title}</a>
                                <div class="summery">${item.meta}</div>
                                <div class="time">${item.dateAndTime}</div>
                            </div>
                        </div>`;
            });

            $('#listBody').html(html);
            closeLoading();
        }


        $(window).on('scroll', e => {
            var bottomOfList = document.getElementById('bottomMainList').getBoundingClientRect().top;
            var windowHeight = $(window).height();

            if(bottomOfList-windowHeight < 0 && !inTake && (!isFinish || mustBeTaken))
                getListElemes();
        });

        $(window).ready(getListElemes);
    </script>
@endsection
