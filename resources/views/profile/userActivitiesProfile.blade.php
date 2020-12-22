<?php $mode = "profile"; $user = Auth::user(); ?>
@extends('layouts.bodyProfile')

@section('main')

    <link rel="stylesheet" href="{{URL::asset('css/shazdeDesigns/profile.css?v=1')}}">
    <link rel="stylesheet" href="{{URL::asset('css/shazdeDesigns/usersActivities.css?v=1')}}">
    <link rel="stylesheet" href="{{URL::asset('css/shazdeDesigns/abbreviations.css?v=1')}}">

    <script>

        var getActivitiesNumPath = '{{route('ajaxRequestToGetActivitiesNum')}}';
        var getActivitiesPath = '{{route('ajaxRequestToGetActivities')}}';
        var sendMyInvitationCode = '{{route('sendMyInvitationCode')}}';

        $(document).ready(function () {
            {{--b = "{{$totalPoint / $userLevels[1]->floor}}";--}}
            initialProgress(b * 100);
        });

        function initialProgress(b) {
            $("#progressId").css("width", b + "%");
        }

        function getFixedFromLeftBODYCON(elem) {

            if(elem.prop('id') == 'BODYCON' || elem.prop('id') == 'PAGE') {
                return parseInt(elem.css('margin-left').split('px')[0]);
            }

            return elem.position().left +
                parseInt(elem.css('margin-left').split('px')[0]) +
                getFixedFromLeftBODYCON(elem.parent());
        }

    </script>

    <div id="MAIN" class="MemberProfile prodp13n_jfy_overflow_visible">

        <div id="BODYCON" class="col easyClear poolB adjust_padding new_meta_chevron_v2">
            <div id="" class="modules-membercenter-content-stream myActivitiesMainDiv">

    <div class="myActivitiesMainDiv">

        <div id="targetHelp_15" class="targets cs-header">
            <div class="myActivitiesHeaderMainDiv">
                <div class="cs-header-points">
                    <span class="label">امتیاز کسب شده :</span>
{{--                    <span class="points">{{$totalPoint}}</span>--}}
                </div>
                <p class="cs-header-title">فعالیت های من</p>
            </div>

            <div id="helpSpan_15" class="helpSpans hidden">
                <span class="introjs-arrow"></span>
                <p>شما می توانید تمامم فعالیت های خود در سایت را در این قسمت مشاهده نمایید. از فیلتر های موجود نیز برای دسترسی راحت تر به فعالیت های خود استفاده کنید.</p>
                <button data-val="15" class="btn btn-success nextBtnsHelp" id="nextBtnHelp_15">بعدی</button>
                <button data-val="15" class="btn btn-primary backBtnsHelp" id="backBtnHelp_15">قبلی</button>
                <button class="btn btn-danger exitBtnHelp" id="exitBtnHelp_15">خروج</button>
            </div>
        </div>

        <div class="postsMainFiltrationBar">
            <span class="showUsersPostsLink changeModeBtn" onclick="activitiesChangeMode(); postsChangeMode()">پست‌ها</span>
            <span class="showUsersPhotosAndVideosLink changeModeBtn" onclick="activitiesChangeMode(); photosChangeMode()">عکس و فیلم</span>
            <span class="showUsersQAndAsLink changeModeBtn" onclick="activitiesChangeMode(); questionsChangeMode()">سؤال‌ها و پاسخ‌ها</span>
            <span class="showUsersArticlesLink changeModeBtn" onclick="activitiesChangeMode(); articleChangeMode()">مقاله‌ها</span>
            <span class="showUsersScores changeModeBtn" onclick="activitiesChangeMode(); scoresChangeMode()">امتیاز‌ها</span>
            <span class="otherActivitiesChoices changeModeBtn" onclick="activitiesChangeMode(); othersChangeMode()">سایر موارد</span>
        </div>

        <div>
            @include('notUse.userActivities.innerParts.userPostsInner')
            @include('notUse.userActivities.innerParts.userPhotosAndVideosInner')
            @include('notUse.userActivities.innerParts.userQuestionsInner')
            @include('notUse.userActivities.innerParts.userArticlesInner')
        </div>

        <script>

            function activitiesChangeMode() {
                $('.userProfileActivitiesDetailsMainDiv').css('display' , 'none');
                $('.changeModeBtn').css('border-color' , 'white');
            }

            function postsChangeMode() {
                $('.userActivitiesPosts').css('display' , 'block');
                $('.showUsersPostsLink').css('border-color' , 'var(--koochita-blue)');
            }

            function photosChangeMode() {
                $('.userActivitiesPhotos').css('display' , 'block');
                $('.showUsersPhotosAndVideosLink').css('border-color' , 'var(--koochita-blue)');
            }

            function questionsChangeMode() {
                $('.userActivitiesQuestions').css('display' , 'block');
                $('.showUsersQAndAsLink').css('border-color' , 'var(--koochita-blue)');
            }

            function articleChangeMode() {
                $('.userActivitiesArticles').css('display' , 'block');
                $('.showUsersArticlesLink').css('border-color' , 'var(--koochita-blue)');
            }

            function scoresChangeMode() {
                // $('.userActivitiesScores').css('display' , 'block');
                $('.showUsersScores').css('border-color' , 'var(--koochita-blue)');
            }

            function othersChangeMode() {
                // $('.userActivitiesOthers').css('display' , 'block');
                $('.otherActivitiesChoices').css('border-color' , 'var(--koochita-blue)');
            }

        </script>

        {{--                    <ul class="cs-contribution-bar">--}}
        {{--                        <?php $i = 0; $allow = true; ?>--}}
        {{--                        @foreach($activities as $activity)--}}
        {{--                            @if($counts[$i] > 0)--}}
        {{--                                <li class="cursor-pointer">--}}
        {{--                                    <a class="headerActivity" id='headerActivity_{{$activity->id}}' onclick="sendAjaxRequestToGiveActivity('{{$activity->id}}', '{{$user->id}}', -1, 'myActivities', 'myActivitiesContent', 1, '{{$counts[$i]}}')">--}}

        {{--                                        @if($allow)--}}
        {{--                                            <script>--}}
        {{--                                                $(document).ready(function () {--}}
        {{--                                                    sendAjaxRequestToGiveActivity('{{$activity->id}}', '{{$user->id}}', -1, 'myActivities', 'myActivitiesContent', 1, '{{$counts[$i]}}');--}}
        {{--                                                });--}}
        {{--                                            </script>--}}
        {{--                                            <?php $allow = false; ?>--}}
        {{--                                        @endif--}}
        {{--                                        <span> {{$activity->name}} </span>--}}
        {{--                                        <span> ({{$counts[$i]}}) </span>--}}
        {{--                                    </a>--}}
        {{--                                </li>--}}
        {{--                            @endif--}}
        {{--                            <?php $i++; ?>--}}
        {{--                        @endforeach--}}
        {{--                    </ul>--}}

        {{--                    <div class="cs-filter-bar" id="myActivities">--}}
        {{--                    </div>--}}


        {{--                    <div class="cs-content-container" id="myActivitiesContent">--}}
        {{--                    </div>--}}
    </div>

</div>
        </div>
    </div>

    <script>

        var total;
        var filters = [];
        var hasFilter = false;
        var topContainer;
        var marginTop;
        var helpWidth;
        var greenBackLimit = 5;
        var pageHeightSize = window.innerHeight;
        var additional = [];
        var indexes = [];

        $(".nextBtnsHelp").click(function () {
            show(parseInt($(this).attr('data-val')) + 1, 1);
        });

        $(".backBtnsHelp").click(function () {
            show(parseInt($(this).attr('data-val')) - 1, -1);
        });

        $(".exitBtnHelp").click(function () {
            myQuit();
        });

        function myQuit() {
            clear();
            $(".dark").hide();
            enableScroll();
        }

        function setGreenBackLimit(val) {
            greenBackLimit = val;
        }

        function initHelp(t, sL, topC, mT, hW) {
            total = t;
            filters = sL;
            topContainer = topC;
            marginTop = mT;
            helpWidth = hW;

            if(sL.length > 0)
                hasFilter = true;

            $(".dark").show();
            show(1, 1);
        }

        function initHelp2(t, sL, topC, mT, hW, i, a) {
            total = t;
            filters = sL;
            topContainer = topC;
            marginTop = mT;
            helpWidth = hW;
            additional = a;
            indexes = i;

            if(sL.length > 0)
                hasFilter = true;

            $(".dark").show();
            show(1, 1);
        }

        function isInFilters(key) {

            key = parseInt(key);

            for(j = 0; j < filters.length; j++) {
                if (filters[j] == key)
                    return true;
            }
            return false;
        }

        function getBack(curr) {

            for(i = curr - 1; i >= 0; i--) {
                if(!isInFilters(i))
                    return i;
            }
            return -1;
        }

        function getFixedFromLeft(elem) {

            if(elem.prop('id') == topContainer || elem.prop('id') == 'PAGE') {
                return parseInt(elem.css('margin-left').split('px')[0]);
            }

            return elem.position().left +
                parseInt(elem.css('margin-left').split('px')[0]) +
                getFixedFromLeft(elem.parent());
        }

        function getFixedFromTop(elem) {

            if(elem.prop('id') == topContainer) {
                return marginTop;
            }

            if(elem.prop('id') == "PAGE") {
                return 0;
            }

            return elem.position().top +
                parseInt(elem.css('margin-top').split('px')[0]) +
                getFixedFromTop(elem.parent());
        }

        function getNext(curr) {

            curr = parseInt(curr);

            for(i = curr + 1; i < total; i++) {
                if(!isInFilters(i))
                    return i;
            }
            return total;
        }

        function bubbles(curr) {

            if(total <= 1)
                return "";

            t = total - filters.length;
            newElement = "<div class='col-xs-12 position-relative'><div class='col-xs-12 bubbles padding-0 mg-rt-0' style='margin-left: " + ((400 - (t * 18)) / 2) + "px'>";

            for (i = 1; i < total; i++) {
                if(!isInFilters(i)) {
                    if(i == curr)
                        newElement += "<div class='filtersBoxProfilePage'></div>";
                    else
                        newElement += "<div onclick='show(\"" + i + "\", 1)' class='helpBubble filtersBoxProfilePageElse'></div>";
                }
            }

            newElement += "</div></div>";

            return newElement;
        }

        function clear() {

            $('.bubbles').remove();

            $(".targets").css({
                'position': '',
                'border': '',
                'padding': '',
                'background-color': '',
                'z-index': '',
                'cursor': '',
                'pointer-events': 'auto'
            });

            $(".helpSpans").addClass('hidden');
            $(".backBtnsHelp").attr('disabled', 'disabled');
            $(".nextBtnsHelp").attr('disabled', 'disabled');
        }

        function show(curr, inc) {

            clear();

            if(hasFilter) {
                while (isInFilters(curr)) {
                    curr += inc;
                }
            }

            if(getBack(curr) <= 0) {
                $("#backBtnHelp_" + curr).attr('disabled', 'disabled');
            }
            else {
                $("#backBtnHelp_" + curr).removeAttr('disabled');
            }

            if(getNext(curr) > total - 1) {
                $("#nextBtnHelp_" + curr).attr('disabled', 'disabled');
            }
            else {
                $("#nextBtnHelp_" + curr).removeAttr('disabled');
            }

            if(curr < greenBackLimit) {
                $("#targetHelp_" + curr).css({
                    'position': 'relative',
                    'border': '5px solid #333',
                    'padding': '10px',
                    'background-color': 'var(--koochita-light-green)',
                    'z-index': 1000001,
                    'cursor': 'auto'
                });
            }
            else {
                $("#targetHelp_" + curr).css({
                    'position': 'relative',
                    'border': '5px solid #333',
                    'padding': '10px',
                    'background-color': 'white',
                    'z-index': 100000001,
                    'cursor': 'auto'
                });
            }

            var targetWidth = $("#targetHelp_" + curr).css('width').split('px')[0];

            var targetHeight = parseInt($("#targetHelp_" + curr).css('height').split('px')[0]);

            for(j = 0; j < indexes.length; j++) {
                if(curr == indexes[j]) {
                    targetHeight += additional[j];
                    break;
                }
            }

            if($("#targetHelp_" + curr).offset().top > 200) {
                $("html, body").scrollTop($("#targetHelp_" + curr).offset().top - 100);
                $("#helpSpan_" + curr).css({
                    'left': $("#targetHelp_" + curr).offset().left + targetWidth / 2 - helpWidth / 2 + "px",
                    'top': targetHeight + 120 + "px"
                }).removeClass('hidden').append(bubbles(curr));
            }
            else {
                $("#helpSpan_" + curr).css({
                    'left': $("#targetHelp_" + curr).offset().left + targetWidth / 2 - helpWidth / 2 + "px",
                    'top': ($("#targetHelp_" + curr).offset().top + targetHeight + 20) % pageHeightSize + "px"
                }).removeClass('hidden').append(bubbles(curr));
            }



            $(".helpBubble").on({

                mouseenter: function () {
                    $(this).css('background-color', '#ccc');
                },
                mouseleave: function () {
                    $(this).css('background-color', '#333');
                }

            });

            disableScroll();
        }

        // left: 37, up: 38, right: 39, down: 40,
        // spacebar: 32, pageup: 33, pagedown: 34, end: 35, home: 36

        var keys = {37: 1, 38: 1, 39: 1, 40: 1};

        function preventDefault(e) {
            e = e || window.event;
            if (e.preventDefault)
                e.preventDefault();
            e.returnValue = false;
        }

        function preventDefaultForScrollKeys(e) {
            if (keys[e.keyCode]) {
                preventDefault(e);
                return false;
            }
        }

        function disableScroll() {
            if (window.addEventListener) // older FF
                window.addEventListener('DOMMouseScroll', preventDefault, false);
            window.onwheel = preventDefault; // modern standard
            window.onmousewheel = document.onmousewheel = preventDefault; // older browsers, IE
            window.ontouchmove  = preventDefault; // mobile
            document.onkeydown  = preventDefaultForScrollKeys;
        }

        function enableScroll() {
            if (window.removeEventListener)
                window.removeEventListener('DOMMouseScroll', preventDefault, false);
            window.onmousewheel = document.onmousewheel = null;
            window.onwheel = null;
            window.ontouchmove = null;
            document.onkeydown = null;
        }

    </script>
@stop