@extends('Safarnameh.safarnamehLayout')

@section('head')
    <title>صفحه سفرنامه</title>

    <style>
        .safarnamehMinRows{
            margin: 0px;
            min-height: 0px;
            height: 70px;
            display: flex;
            align-items: center;
        }
        .safarnamehMinRows .im-widget-thumb > a{
            height: 100%;
            display: flex !important;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            border-radius: 5px;
        }
        .im-widget-thumb{
            height: 100% !important;
        }
    </style>
@endsection

@section('beforeBody')

    <div id="pcBannerSafarnameh" class="hidden">
        <div class="##class##" style="margin-bottom: 2px;">
            <article class="row grid-carousel" style="height: ##height##">
                <div class="im-entry-thumb">
                    <a class="im-entry-thumb-link pcBannerPic" href="##url##" title="##title##" style="height: ##height##">
                        <img src="##pic##" alt="##title##" class="resizeImgClass" onload="fitThisImg(this)"/>
                    </a>
                    <div class="im-entry-header">
                        <div class="im-entry-category">
                            <div class="iranomag-meta clearfix">
                                <div class="cat-links im-meta-item">
                                    <a style="background-color: #666; color: #fff !important;" href="#" title="##category##">##category##</a>
                                </div>
                            </div>
                        </div>
                        <h2 class="im-entry-title">
                            <a style="color: #fff" href="##url##" rel="bookmark">##title##</a>
                        </h2>
                        <div class="im-entry-footer">
                            <div class="iranomag-meta clearfix">
                                <div class="posted-on im-meta-item">
                                    <span class="entry-date published updated">##date##</span>
                                </div>
                                <div class="comments-link im-meta-item">
                                    <i class="fas fa-comments"></i>
                                    ##msgs##
                                </div>
                                <div class="author vcard im-meta-item">
                                    <i class="fa fa-user"></i>
                                    ##username##
                                </div>
                                <div class="post-views im-meta-item">
                                    <i class="fa fa-eye"></i>
                                    ##seen##
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </div>

    <div class="gnTopPics hideOnPhone">
        <div class="container">
            <div id="pcBannerSection" class="im_post_grid_box clearfix">
                <div class="col-sm-6" style="height: 210px; margin-bottom: 2px">
                    <div class="placeHolderAnime"></div>
                </div>
                <div class="col-sm-6" style="height: 210px; margin-bottom: 2px">
                    <div class="placeHolderAnime"></div>
                </div>
                <div class="col-sm-6" style="height: 210px; margin-bottom: 2px">
                    <div class="placeHolderAnime"></div>
                </div>
                <div class="col-sm-6" style="height: 210px; margin-bottom: 2px">
                    <div class="placeHolderAnime"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="hideOnScreen">
        <div class="mainTopPicture">
            <img src="{{URL::asset('images/mainPics/safarname.webp')}}" alt="koochita" style="width: 100%">
            <div class="content">
                <div class="withBack">
                    <div class="text">
{{--                        <div style="margin-bottom: 50px; text-align: left;">اخبار</div>--}}
                        <div style="margin-bottom: 9px;">سفرنامه</div>
                        <div style="line-height: 38px; padding-bottom: 12px; padding-top: 19px;">کوچیتا</div>
                    </div>
                </div>
                <div class="trans"></div>
            </div>
        </div>

        <div class="safarnamehList">
            <div class="titleSec">
                <div class="title"> پیشنهاد کوچیتا </div>
            </div>
            <div class="list safarnamehHorizontalList swiper-container">
                <div id="mainSuggestionSafarnamehMobile" class="swiper-wrapper"></div>
            </div>
        </div>

        <div class="safarnamehList">
            <div class="titleSec">
                <div class="title">پرطرفدارها</div>
            </div>
            <div class="list safarnamehHorizontalList swiper-container">
                <div id="popularSafarnamehMobile" class="swiper-wrapper"></div>
            </div>
        </div>

        <div class="safarnamehList">
            <div class="titleSec">
                <div class="title">داغ ترین ها</div>
            </div>
            <div class="list safarnamehHorizontalList swiper-container">
                <div id="hotSafarnamehMobile" class="swiper-wrapper"></div>
            </div>
        </div>

        <div class="safarnamehList">
            <div class="titleSec">
                <div class="title">تازه ها</div>
            </div>
            <div id="allSafarnamehListMobile" class="colList"></div>
        </div>

        <div id="loaderFloorMobile" style="height: 1px; width: 100%;"></div>
    </div>

    <div id="safarnamehMainCardPlaceHolderMobile" class="hidden">
        <div class="swiper-slide safarnCardMobile">
            <div class="contents placeHolderAnime">
                <div class="userPic" style="background: white"></div>
            </div>
        </div>
    </div>
    <div id="safarnamehMainCardMobile" class="hidden">
        <div class="swiper-slide safarnCardMobile">
            <img src="##pic##" alt="##title##" class="resizeImgClass" onload="fitThisImg(this)">
            <div class="icon ##bookmark##" onclick="bookMarkSafarnameh(##id##, this)"></div>
            <a href="##url##" class="contents">
                <div class="userPic">
                    <img src="##writerPic##" alt="userPic" style="width: 100%">
                </div>
                <div class="name">##title##</div>
            </a>
        </div>
    </div>

    <div id="safarnamehRowCardPlaceHolderMobile" class="hidden">
        <div class="rowSafarnamehCard placeHolderCard">
            <div class="imgSec">
                <div class="safarPic placeHolderAnime"></div>
            </div>
            <div class="content">
                <div class="title placeHolderAnime resultLineAnim" style="width: 50%; height: 10px; margin-bottom: 15px;"></div>
                <div class="summery placeHolderAnime resultLineAnim" style="width: 90%; height: 6px; margin-bottom: 5px;"></div>
                <div class="summery placeHolderAnime resultLineAnim" style="width: 90%; height: 6px; margin-bottom: 5px;"></div>
                <div class="summery placeHolderAnime resultLineAnim" style="width: 90%; height: 6px; margin-bottom: 5px;"></div>
                <div class="summery placeHolderAnime resultLineAnim" style="width: 90%; height: 6px; margin-bottom: 5px;"></div>
            </div>
        </div>
    </div>
    <div id="safarnamehRowCardMobile" class="hidden">
        <div class="rowSafarnamehCard">
            <div class="imgSec">
                <a href="##url##" class="safarPic">
                    <img src="##pic##" alt="##title##" class="resizeImgClass" onload="fitThisImg(this)">
                </a>
                <div class="userInfos">
                    <img src="##writerPic##" alt="userPicture" style="height: 100%;">
                </div>
                <div class="icon ##bookmark##" onclick="bookMarkSafarnameh(##id##, this)"></div>
            </div>
            <a href="##url##" class="content">
                <div class="title">##title##</div>
                <div class="summery">##summery##</div>
            </a>
        </div>
    </div>

    <script>
        var mobileMainListPlaceHolderSample = $('#safarnamehMainCardPlaceHolderMobile').html();
        var mobileMainListSample = $('#safarnamehMainCardMobile').html();
        var mobileListSample = $('#safarnamehRowCardMobile').html();
        var mobileRowListPlaceHolderSample = $('#safarnamehRowCardPlaceHolderMobile').html();

        $('#safarnamehRowCardPlaceHolderMobile').remove();
        $('#safarnamehRowCardMobile').empty();
        $('#safarnamehMainCardPlaceHolderMobile').remove();
        $('#safarnamehMainCardMobile').remove();

        var fiveMobilePlaceHolder = '';
        for(var i = 0; i < 5; i++)
            fiveMobilePlaceHolder += mobileMainListPlaceHolderSample;

        $('#mainSuggestionSafarnamehMobile').html(fiveMobilePlaceHolder);
        $('#hotSafarnamehMobile').html(fiveMobilePlaceHolder);
        $('#popularSafarnamehMobile').html(fiveMobilePlaceHolder);

        new Swiper('.safarnamehHorizontalList', {
            loop: true,
            slidesPerView: 'auto',
            centeredSlides: true,
            spaceBetween: 10,
        });
    </script>
@endsection

@section('body')
    <div class="hideOnPhone">

        <div class="col-md-12 col-sm-12 gnWhiteBox" style="padding: 0;">
            <div class="col-md-6 col-sm-12">
                <div class="category-element-holder style2">
                    <div class="widget-head widget-head-46">
                        <strong class="widget-title">پرطرفدار ها</strong>
                        <div class="widget-head-bar"></div>
                        <div class="widget-head-line"></div>
                    </div>
                    <div id="pcMostCommentSafarnameh" class="row">

                        <div class="pcSafarnamehMainBig col-md-12">
                            <div class="imgSec placeHolderAnime"></div>
                        </div>

                        <div class="pcSafarnamehMainSmall col-md-12">
                            <div class="imgSec placeHolderAnime"></div>
                            <div class="content">
                                <div class="placeHolderAnime resultLineAnim" style="width: 50%; height: 8px"></div>
                                <div class="placeHolderAnime resultLineAnim" style="width: 80%; height: 5px"></div>
                            </div>
                        </div>
                        <div class="pcSafarnamehMainSmall col-md-12">
                            <div class="imgSec placeHolderAnime"></div>
                            <div class="content">
                                <div class="placeHolderAnime resultLineAnim" style="width: 50%; height: 8px"></div>
                                <div class="placeHolderAnime resultLineAnim" style="width: 80%; height: 5px"></div>
                            </div>
                        </div>
                        <div class="pcSafarnamehMainSmall col-md-12">
                            <div class="imgSec placeHolderAnime"></div>
                            <div class="content">
                                <div class="placeHolderAnime resultLineAnim" style="width: 50%; height: 8px"></div>
                                <div class="placeHolderAnime resultLineAnim" style="width: 80%; height: 5px"></div>
                            </div>
                        </div>
                        <div class="pcSafarnamehMainSmall col-md-12">
                            <div class="imgSec placeHolderAnime"></div>
                            <div class="content">
                                <div class="placeHolderAnime resultLineAnim" style="width: 50%; height: 8px"></div>
                                <div class="placeHolderAnime resultLineAnim" style="width: 80%; height: 5px"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="category-element-holder style2">
                    <div class="widget-head widget-head-46">
                        <strong class="widget-title">داغ ترین ها</strong>
                        <div class="widget-head-bar"></div>
                        <div class="widget-head-line"></div>
                    </div>
                    <div id="pcHotSafarnameh" class="row">
                        <div class="pcSafarnamehMainBig col-md-12">
                            <div class="imgSec placeHolderAnime"></div>
                        </div>

                        <div class="pcSafarnamehMainSmall col-md-12">
                            <div class="imgSec placeHolderAnime"></div>
                            <div class="content">
                                <div class="placeHolderAnime resultLineAnim" style="width: 50%; height: 8px"></div>
                                <div class="placeHolderAnime resultLineAnim" style="width: 80%; height: 5px"></div>
                            </div>
                        </div>
                        <div class="pcSafarnamehMainSmall col-md-12">
                            <div class="imgSec placeHolderAnime"></div>
                            <div class="content">
                                <div class="placeHolderAnime resultLineAnim" style="width: 50%; height: 8px"></div>
                                <div class="placeHolderAnime resultLineAnim" style="width: 80%; height: 5px"></div>
                            </div>
                        </div>
                        <div class="pcSafarnamehMainSmall col-md-12">
                            <div class="imgSec placeHolderAnime"></div>
                            <div class="content">
                                <div class="placeHolderAnime resultLineAnim" style="width: 50%; height: 8px"></div>
                                <div class="placeHolderAnime resultLineAnim" style="width: 80%; height: 5px"></div>
                            </div>
                        </div>
                        <div class="pcSafarnamehMainSmall col-md-12">
                            <div class="imgSec placeHolderAnime"></div>
                            <div class="content">
                                <div class="placeHolderAnime resultLineAnim" style="width: 50%; height: 8px"></div>
                                <div class="placeHolderAnime resultLineAnim" style="width: 80%; height: 5px"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-sm-12 gnWhiteBox">
            <div class="widget-head light">
                <strong class="widget-title">همه مطالب</strong>
                <div class="widget-head-bar"></div>
                <div class="widget-head-line"></div>
            </div>
            <div class="row im-blog">

                <div id="pcRowListSafarnameh" class="clearfix" style="display: none">
                    <div class="small-12 columns">
                        <article class="im-article content-column clearfix post type-post status-publish format-standard has-post-thumbnail hentry">
                            <div class="im-entry-thumb col-md-5 col-sm-12">
                                <a class="im-entry-thumb-link" href="##url##" title="##title##" style="max-height: 200px;">
                                    <img data-src="##pic##" src="##pic##" alt="##keyword##"/>
                                </a>
                            </div>
                            <div class="im-entry col-md-7 col-sm-12">
                                <header class="im-entry-header">
                                    <div class="im-entry-category">
                                        <div class="iranomag-meta clearfix">
                                            <div class="cat-links im-meta-item">
                                                <a style="background-color: #666; color: #fff !important;" href="{{url('/safarnameh/list/category/')}}/##category##" title="##category##">##category##</a>
                                            </div>
                                        </div>
                                    </div>
                                    <h3 class="im-entry-title">
                                        <a href="##url##" rel="bookmark">##title##</a>
                                    </h3>
                                </header>

                                <div style="max-height: 100px !important; overflow: hidden" class="im-entry-content">
                                    <p>##meta##</p>
                                </div>

                                <div style="margin-top: 7px"
                                     class="iranomag-meta clearfix">
                                    <div class="posted-on im-meta-item">
                                        <span class="entry-date published updated">##date##</span>
                                    </div>
                                    <div class="comments-link im-meta-item">
                                        <i class="fas fa-comments"></i>
                                        ##msgs##
                                    </div>
                                    <div class="author vcard im-meta-item">
                                        <i class="fa fa-user"></i>
                                        ##username##
                                    </div>
                                    <div class="post-views im-meta-item">
                                        <i class="fa fa-eye"></i>
                                        ##seen##
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>

                <div id="loaderFloorPc" style="height: 1px; width: 100%;"></div>

            </div>
            <div class="gap cf" style="height:30px;"></div>
        </div>

    </div>

    <div id="safarnamehRowCardPlaceHolderPC" class="hidden">
        <div class="small-12 columns placeHolderCard">
            <article class="im-article content-column clearfix post type-post status-publish format-standard has-post-thumbnail hentry">
                <div class="im-entry-thumb col-md-5 col-sm-12">
                    <div class="im-entry-thumb-link placeHolderAnime" style="height: 200px;"></div>
                </div>
                <div class="im-entry col-md-7 col-sm-12">
                    <header class="im-entry-header">
                        <div class="placeHolderAnime resultLineAnim" style="width: 50%; height: 10px; margin-bottom: 15px;"></div>
                    </header>
                    <div class="summery placeHolderAnime resultLineAnim" style="width: 90%; height: 6px; margin-bottom: 5px;"></div>
                    <div class="summery placeHolderAnime resultLineAnim" style="width: 90%; height: 6px; margin-bottom: 5px;"></div>
                    <div class="summery placeHolderAnime resultLineAnim" style="width: 90%; height: 6px; margin-bottom: 5px;"></div>
                    <div class="summery placeHolderAnime resultLineAnim" style="width: 90%; height: 6px; margin-bottom: 5px;"></div>
                </div>
            </article>
        </div>
    </div>

    <div id="safarnamehItemCardPC" class="hidden">
        <a href="##url##" class="##class## col-md-12">
            <div class="imgSec">
                <img src="##pic##" alt="##title##" class="resizeImgClass" onload="fitThisImg(this)">
            </div>
            <div class="content">
                <div class="name">##title##</div>
                <div class="icons">
                    <div class="posted-on im-meta-item">
                        <span class="entry-date published updated">##date##</span>
                    </div>
                    <div class="comments-link im-meta-item">
                        <i class="fas fa-comments"></i>
                        ##msgs##
                    </div>
                    <div class="author vcard im-meta-item">
                        <i class="fa fa-user"></i>
                        ##username##
                    </div>
                    <div class="post-views im-meta-item">
                        <i class="fa fa-eye"></i>
                        ##seen##
                    </div>
                </div>
            </div>
        </a>
    </div>
@endsection

@section('script')
    <script>
        var inAjaxSafarnameh = false;
        var takeSafarnameh = 5;
        var nowPageTaken = 1;

        var pcBannerSafarnameh = $('#pcBannerSafarnameh').html();
        var pcItemSafarnameh = $('#safarnamehItemCardPC').html();
        var pcRowListSample = $('#pcRowListSafarnameh').html();
        var pcRowListPlaceHolderSample = $('#safarnamehRowCardPlaceHolderPC').html();

        $('#safarnamehRowCardPlaceHolderPC').remove();
        $('#pcBannerSafarnameh').remove();
        $('#safarnamehItemCardPC').remove();
        $('#pcRowListSafarnameh').empty().show();

        function getMainDataSafarnameh(){
            getBanners();
            getOther();
        }

        function getBanners(){
            $.ajax({
                timeout: 5000,
                type: 'GET',
                url: '{{route("safarnameh.getMainPageData")}}?banner=1',
                success: response => {
                    if(response.status == 'ok') {
                        createPcBanner(response.bannerPosts);
                        createMobileSections('mainSuggestionSafarnamehMobile', response.bannerPosts);
                    }
                },
                error: (err, status) => {
                    if(status == "timeout") getBanners();
                }
            });
        }

        function getOther(){
            $.ajax({
                timeout: 5000,
                type: 'GET',
                url: '{{route("safarnameh.getMainPageData")}}?other=1',
                success: response => {
                    if(response.status == 'ok'){
                        createMobileSections('hotSafarnamehMobile', response.mostCommentSafarnameh);
                        createMobileSections('popularSafarnamehMobile', response.mostSeenSafarnameh);

                        createPcSafarnamehItem('pcMostCommentSafarnameh', response.mostCommentSafarnameh);
                        createPcSafarnamehItem('pcHotSafarnameh', response.mostSeenSafarnameh);
                    }
                },
                error: (err, status) => {
                    if(status == "timeout") getOther();
                }
            });
        }

        function getSafarnamehMainPage(page){
            if(!inAjaxSafarnameh) {
                inAjaxSafarnameh = true;
                createPlaceHolderSafarnameh(5);
                $.ajax({
                    timeout: 5000,
                    type: 'GET',
                    url: `{{route("safarnameh.getListElement")}}?page=${page}&take=${takeSafarnameh}`,
                    success: response => {
                        if (response.status == 'ok') createPostRow(response.result);
                    },
                    error: (error, status) => {
                        console.log(status);
                        if(status == "timeout") getSafarnamehMainPage(page);
                    }
                });
            }
        }

        function createPostRow(_safarnameh){
            $('#pcRowListSafarnameh').find('.placeHolderCard').remove();
            $('#allSafarnamehListMobile').find('.placeHolderCard').remove();

            _safarnameh.map(item => {
                var text = pcRowListSample;
                var mobile = mobileListSample;

                for (var x of Object.keys(item)) {
                    text = text.replace(new RegExp(`##${x}##`, "g"), item[x]);
                    mobile = mobile.replace(new RegExp(`##${x}##`, "g"), item[x]);
                }

                mobile = mobile.replace(new RegExp("##bookmark##", "g"), item.bookMark ? 'BookMarkIcon' : 'BookMarkIconEmpty');

                $('#pcRowListSafarnameh').append(text);
                $('#allSafarnamehListMobile').append(mobile);
            });

            if(_safarnameh.length == takeSafarnameh) {
                nowPageTaken++;
                inAjaxSafarnameh = false;

                var stayToLoad;
                if($(window).width() <= 767)
                    stayToLoad = document.getElementById('loaderFloorMobile').getBoundingClientRect().top - 150;
                else
                    stayToLoad = document.getElementById('loaderFloorPc').getBoundingClientRect().top - 400;
                stayToLoad -= $(window).height();
                if(stayToLoad <= 0)
                    getSafarnamehMainPage(nowPageTaken);
            }
        }

        function createPlaceHolderSafarnameh(_number){
            var pc = '';
            var mobile = '';

            for(var i = 0; i < _number; i++){
                mobile += mobileRowListPlaceHolderSample;
                pc += pcRowListPlaceHolderSample;
            }

            $('#pcRowListSafarnameh').append(pc);
            $('#allSafarnamehListMobile').append(mobile);
        }

        function createMobileSections(_id, _result){
            var text = '';
            _result.map(item => {
                var nText = mobileMainListSample;
                for (var x of Object.keys(item))
                    nText = nText.replace(new RegExp(`##${x}##`, "g"), item[x]);

                nText = nText.replace(new RegExp("##bookmark##", "g"), item.bookMark ? 'BookMarkIcon' : 'BookMarkIconEmpty');
                text += nText;
            });

            $(`#${_id}`).html(text);

            new Swiper($(`#${_id}`).parents(), {
                loop: true,
                slidesPerView: 'auto',
                centeredSlides: true,
                spaceBetween: 10,
            });
        }

        function createPcSafarnamehItem(_id, _result){
            var text = '';

            _result.map((item, index) => {
                var className = '';
                var nText = pcItemSafarnameh;
                for (var x of Object.keys(item))
                    nText = nText.replace(new RegExp(`##${x}##`, "g"), item[x]);

                className = index == 0 ? 'pcSafarnamehMainBig' : 'pcSafarnamehMainSmall';
                nText = nText.replace(new RegExp(`##class##`, "g"), className);

                text += nText;
            });
            $(`#${_id}`).html(text);
        }

        function createPcBanner(_data){
            var text = '';
            _data.map((item, index) => {
                var className = '';
                var height = '';
                var nText = pcBannerSafarnameh;

                for (var x of Object.keys(item))
                    nText = nText.replace(new RegExp(`##${x}##`, "g"), item[x]);

                if(_data.length == 1){
                    className = 'col-md-12';
                    height = '310px';
                }
                else if(_data.length == 2){
                    className = 'col-sm-6';
                    height = '310px';
                }
                else if(_data.length == 3){
                    className = 'col-sm-4';
                    height = '310px';
                }
                else if(_data.length == 4){
                    className = 'col-sm-6';
                    height = '310px';
                }
                else if(_data.length == 5){
                    className = index < 2 ? 'col-sm-6' : 'col-sm-4';
                    height = '310px';
                }


                nText = nText.replace(new RegExp('##class##', "g"), className);
                nText = nText.replace(new RegExp('##height##', "g"), height);

                text += nText;
            });

            $('#pcBannerSection').html(text);
        }

        $(window).on('scroll', e => {
            var stayToLoad;
            if($(window).width() <= 767)
                stayToLoad = document.getElementById('loaderFloorMobile').getBoundingClientRect().top - 150;
            else
                stayToLoad = document.getElementById('loaderFloorPc').getBoundingClientRect().top - 400;

            stayToLoad -= $(window).height();
            if(stayToLoad <= 0 && !inAjaxSafarnameh){
                getSafarnamehMainPage(nowPageTaken);
            }
        });

        $(window).ready(() => {
            getMainDataSafarnameh();
        })
    </script>
@endSection


