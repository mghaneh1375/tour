@extends('Safarnameh.safarnamehLayout')

@section('head')
    <title>لیست سفرنامه ها</title>

    <style>
        @media (max-width: 768px){
            .gnWhiteBox {
                margin: 0 -15px;
            }
        }
    </style>
@endsection

@section('body')
    <div class="col-md-12 gnWhiteBox" style="padding: 15px;">
        <div class="row im-blog">
            <div class="row headerList">
                <span style="font-weight: bold">سفرنامه های </span>
                <span>{{$headerList}}</span>
            </div>

            <div id="mainListBodyPc" class="clearfix hideOnPhone"></div>
            <div id="mainListBodyMobile" class="clearfix hideOnScreen"></div>

            <div id="loaderFloor" style="height: 1px; width: 100%;"></div>

            <div id="emptyList" class="emptyListSafarnameh hidden">
                <div class="row emptyRow">
                    <div class="pic">
                        <img src="{{URL::asset('images/mainPics/notElemList.png')}}" style="width: 100px;">
                    </div>
                    <div class="text">
                        هیچ سفرنامه ای با این موضوع یافت نشد.
                    </div>
                </div>
            </div>

            <div class="clearfix">
                <nav class="navigation pagination">
                    <div id="allPostPagination" class="nav-links"></div>
                </nav>
            </div>

        </div>
        <div class="gap cf height-30"></div>
    </div>

    <a href="#" id="back-to-top" title="بازگشت به ابتدای صفحه"><i class="fa fa-arrow-up"></i></a>
@endsection

@section('script')

    <script>
        var inAjaxSafarnameh = false;
        var takeSafarnameh = 5;
        var nowPageTaken = 1;
        var type = '{{$type}}';
        var search = '{{$search}}';

        function getSafarnamehList(page){
            if(!inAjaxSafarnameh) {
                inAjaxSafarnameh = true;
                createPlaceHolderSafarnameh(5);
                $.ajax({
                    timeout: 5000,
                    type: 'GET',
                    url: `{{route("safarnameh.list.pagination")}}?page=${page}&take=${takeSafarnameh}&type=${type}&search=${search}`,
                    success: response => {
                        if (response.status == 'ok') createSafarnamehRow(response.result);
                    },
                    error: (error, status) => {
                        if(status == "timeout") getSafarnamehList(page);
                    }
                });
            }
        }

        function createSafarnamehRow(_safarnameh){
            $('#mainListBodyPc').find('.placeHolderCard').remove();
            $('#mainListBodyMobile').find('.placeHolderCard').remove();

            _safarnameh.map(item => {
                var text = pcRowListSafarnamehSample;
                var mobile = mobileListSafarnamehSample;

                for (var x of Object.keys(item)) {
                    text = text.replace(new RegExp(`##${x}##`, "g"), item[x]);
                    mobile = mobile.replace(new RegExp(`##${x}##`, "g"), item[x]);
                }

                mobile = mobile.replace(new RegExp("##bookmark##", "g"), item.bookMark ? 'BookMarkIcon' : 'BookMarkIconEmpty');

                $('#mainListBodyPc').append(text);
                $('#mainListBodyMobile').append(mobile);
            });

            if(nowPageTaken == 1 && _safarnameh.length == 0)
                $('#emptyList').removeClass('hidden');

            if(_safarnameh.length == takeSafarnameh) {
                nowPageTaken++;
                inAjaxSafarnameh = false;

                var stayToLoad;
                if($(window).width() <= 767)
                    stayToLoad = document.getElementById('loaderFloor').getBoundingClientRect().top - 150;
                else
                    stayToLoad = document.getElementById('loaderFloor').getBoundingClientRect().top - 400;
                stayToLoad -= $(window).height();
                if(stayToLoad <= 0)
                    getSafarnamehList(nowPageTaken);
            }
        }

        function createPlaceHolderSafarnameh(_number){
            var pc = '';
            var mobile = '';

            for(var i = 0; i < _number; i++){
                mobile += mobileRowListSafarnamehPlaceHolderSample;
                pc += pcRowListSafarnamehPlaceHolderSample;
            }

            $('#mainListBodyPc').append(pc);
            $('#mainListBodyMobile').append(mobile);
        }

        $(window).on('scroll', e => {
            var stayToLoad;
            if($(window).width() <= 767)
                stayToLoad = document.getElementById('loaderFloor').getBoundingClientRect().top - 150;
            else
                stayToLoad = document.getElementById('loaderFloor').getBoundingClientRect().top - 400;

            stayToLoad -= $(window).height();
            if(stayToLoad <= 0 && !inAjaxSafarnameh){
                getSafarnamehList(nowPageTaken);
            }
        });

        $(window).ready(() => {
            getSafarnamehList(nowPageTaken);
        });
    </script>
@endsection
