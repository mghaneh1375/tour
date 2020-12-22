<!DOCTYPE html>
<html>
    <head>

        @include('layouts.topHeader')
        <link rel='stylesheet' type='text/css' media='screen, print' href='{{URL::asset('css/theme2/hotel_review.css?v=1')}}'/>
        <link rel='stylesheet' type='text/css' media='screen, print' href='{{URL::asset('css/theme2/travel_answers_page.css?v=1')}}'/>
        <link rel='stylesheet' type='text/css' media='screen, print' href='{{URL::asset('css/theme2/overlays_defer.css?v=1')}}'/>
        <link rel='stylesheet' type='text/css' media='screen, print' href='{{URL::asset('css/theme2/long_lived_global_legacy_3.css?v=1')}}'/>
        <link rel="stylesheet" type="text/css" href="{{URL::asset('css/theme2/popUp.css?v=1')}}">

        <style type="text/css">

            .COL1OF2{
                float: right !important;
                width: 85px !important;
            }
            .COL2OF2{
                margin-right: 125px;
                margin-left: 0 !important;
            }
            .innerBubble:before {
                left: 475px !important;
                border-width: 13px 0 13px 15px !important;
            }
            .innerBubble:after {
                left: 474px !important;
                border-width: 12px 0 12px 14px !important;
            }
        </style>

        <style>

            input[type="checkbox"] {
                display:none;
            }

            input[type="checkbox"] + label {
                color:#666666;
            }

            input[type="checkbox"] + label span {
                display:inline-block;
                width:19px;
                height:19px;
                margin:-2px 10px 0 0;
                vertical-align:middle;
                background:url('{{URL::asset('images/check_radio_sheet.png')}}') left top no-repeat;
                cursor:pointer;
            }

            input[type="checkbox"]:checked + label span {
                background:url('{{URL::asset('images/check_radio_sheet.png')}}') -19px top no-repeat;
            }

            .labelForCheckBox:before{
                background-color: transparent !important;
                border: none !important;
                content: "" !important;
            }

        </style>
        <style>
            .btn{
        display: inline-block;
        padding: 6px 12px;
        margin-bottom: 0;
        font-size: 14px;
        font-weight: 400;
        line-height: 1.42857143;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        -ms-touch-action: manipulation;
        touch-action: manipulation;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        background-image: none;
        border: 1px solid transparent;
        border-top-color: transparent;
        border-right-color: transparent;
        border-bottom-color: transparent;
        border-left-color: transparent;
        border-radius: 4px;

    }

            .btn-default {
                color: #333;
                background-color: #fff;
                border-color: #ccc;
            }

        </style>
    </head>

    <body style="direction: rtl;">

    <div id="PAGE" class=" non_hotels_like desktop scopedSearch">
        @if(!Auth::check())
            @include('layouts.loginPopUp')
        @endif

        @include('layouts.placeHeader')

        <div id="MAINWRAP" class=" ">
            <div id="MAIN" class="FAQ_Answers
                prodp13n_jfy_overflow_visible
                ">
                <div id="BODYCON" class="col easyClear poolC adjust_padding new_meta_chevron_v2">
                    <div class="wrpHeader">
                      <span class="apt" style="float: right !important; margin-left: 18px; margin-right: 0 !important;">
                         <div class="sizedThumb  " style="height: 46px; width: 46px; ">
                            <a href="{{route('hotelDetails', ['placeId' => $placeId, 'placeName' => $placeName])}}" class="photo_link ">
                            <img src="{{$placePic}}" class="photo_image" style="height: 46px; width: 46px;" alt="{{$placeName}}" width="46" height="46"/>
                            </a>
                         </div>
                      </span>

                        <div id="HEADING_GROUP" class=" QAHeadingGroup">
                            <div id="headingWrapper" class="headerNoSaves jfy_beta " style="">
                                <h1 id="HEADING" style="cursor: pointer" onclick="document.location.href = hotelDetails;">{{$placeName}}</h1>
                                <div class="info wrap">
                                    <div class="rating" style="float: right !important;color: var(--koochita-light-green);">
                                        @if($rate == 5)
                                            <span class="ui_bubble_rating bubble_50" style="font-size:16px;" property="ratingValue" content="5" alt='5 of 5 bubbles'></span>
                                        @elseif($rate == 4)
                                            <span class="ui_bubble_rating bubble_40" style="font-size:16px;" property="ratingValue" content="4" alt='4 of 5 bubbles'></span>
                                        @elseif($rate == 3)
                                            <span class="ui_bubble_rating bubble_30" style="font-size:16px;" property="ratingValue" content="3" alt='3 of 5 bubbles'></span>
                                        @elseif($rate == 2)
                                            <span class="ui_bubble_rating bubble_20" style="font-size:16px;" property="ratingValue" content="2" alt='2 of 5 bubbles'></span>
                                        @elseif($rate == 1)
                                            <span class="ui_bubble_rating bubble_10" style="font-size:16px;" property="ratingValue" content="1" alt='1 of 5 bubbles'></span>
                                        @endif
                                        <a style="color: #16174f;">{{$reviews}} نقد</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="gridA">
                        <div class="col balance" style="float: right !important; border-right: 0 !important; border-left: 1px solid #e6e6e6; padding: 0 5px 25px 0 !important;">
                            <div id="SINGLE_QUESTION">
                                <div id="question_3775401" class="question wrap hasAnswers singleQuestion" data-topicid="3775401" style="margin-left: 35px !important;">
                                    <div class="col1of2 COL1OF2">
                                        <div class="member_info">
                                            <div class="memberOverlayLink">
                                                <div class="avatar profile_0673E54B022BE899FECB36C83DC80A68 ">
                                                    <a class="img_btn" data-val="{{$question->visitorId}}">
                                                        <img src="{{$question->userPhoto}}" class="avatar" width="74" height="74"/>
                                                    </a>
                                                </div>
                                                <div class="username mo">
                                                    <span class="expand_inline scrname mbrName_0673E54B022BE899FECB36C83DC80A68">{{$question->visitorId}}</span>
                                                </div><br>
                                                <div class="username mo">
                                                    <span class="expand_inline scrname mbrName_0673E54B022BE899FECB36C83DC80A68">{{$question->city}}</span> - <span>{{$question->state}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2of2 COL2OF2">
                                        <div class="questionSummaryWrap">
                                            <div class="innerBubble">
                                                <div class="questionText">
                                                    <h2>
                                                        <p>{{$question->text}}</p>
                                                    </h2>
                                                </div>
                                                <div class="questionMeta">
                                                    <span class="subTime">{{$question->date}}</span>
                                                   <span class="reportWrap">
                                                   <span style="color:#16174f;font-size: 11px;" onclick="showReportPrompt('{{$question->id}}')" class="problem collapsed taLnk">
                                                    گزارش تخلف
                                                   <span class="hidden ulBlueLinks topic3775401">Problem with this question?</span> </span>
                                                   </span> <a class="postButton ui_button primary small" href="#AnswerQuestionForm">پاسخ</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="postCount"></div>
                                    </div>
                                </div>
                                <h3 id="QA_POST_COUNT" class="QASort">
                                    {{count($answers)}} جواب
                                </h3>
                                <div id="ANSWERS" class="answerSection ">
                                    <div class="answerList" style="margin-left: 35px !important">
                                        @foreach($answers as $answer)
                                            <div class="wrap answer" style="overflow: visible;">
                                            <div class="col1of2 COL1OF2">
                                                <div class="member_info">
                                                    <div class="memberOverlayLink">
                                                        <div class="avatar profile_103B1DA925CF5CAA0D5733FF01705793 ">
                                                            <a class="img_btn" data-val="{{$answer->visitorId}}">
                                                                <img src="{{$answer->userPhoto}}" class="avatar" width="74" height="74"/>
                                                            </a>
                                                        </div>

                                                        <div class="username mo">
                                                            <span class="expand_inline scrname mbrName_103B1DA925CF5CAA0D5733FF01705793"> {{$answer->visitorId}}</span>
                                                        </div>
                                                        <div class="username mo">
                                                            <span class="expand_inline scrname mbrName_0673E54B022BE899FECB36C83DC80A68">{{$answer->city}}</span> - <span>{{$answer->state}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2of2 COL2OF2" style="overflow: visible;">
                                                <div class="answerSummaryWrap">
                                                    <div class="innerBubble wrap" style="overflow: visible;">
                                                        <div class="QA_vote" style="float: left;">
                                                 <span class="voteIcon" onclick="likeAns('{{$answer->id}}')">
                                                    <div class="ui_icon single-chevron-up-circle"></div>
                                                    <div class="ui_icon single-chevron-up-circle-fill"></div>
                                                    <div class="tooltip">رای مفید</div>
                                                    <div class="sprite-tooltip-arrow"></div>
                                                 </span>
                                                            <div class="voteCount">
                                                                <div style="float: right;" class="score" id="score_{{$answer->id}}" data-val="{{$answer->rate}}">{{$answer->rate}}</div>
                                                                <div>رای</div>
                                                            </div>
                                                 <span class="voteIcon" onclick="dislikeAns('{{$answer->id}}')">
                                                    <div class="ui_icon single-chevron-down-circle"></div>
                                                    <div class="ui_icon single-chevron-down-circle-fill"></div>
                                                    <div class="tooltip">رای غیر مفید</div>
                                                    <div class="sprite-tooltip-arrow"></div>
                                                 </span>
                                                        </div>
                                                        <div class="answerText">
                                                            <p>{{$answer->text}}</p>
                                                        </div>
                                                        <div class="answerMeta">
                                                            <span class="subTime">{{$answer->date}}</span>
                                                 <span class="reportWrap">
                                                 <span style="color:#16174f;font-size: 11px;" class="problem collapsed taLnk" onclick="showReportPrompt('{{$answer->id}}')">
                                                 گزارش تخلف
                                                 <span class="hidden ulBlueLinks posting8623944">Problem with this answer?</span> </span>
                                                 </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div id="AnswerQuestionForm" class="QA_form_wrap">
                                    <div class="QA_form_header" style="margin-left: 35px !important">جواب شما</div>
                                    <div class="col2of2 COL2OF2" style="margin-right: 120px !important;">
                                        <div class="QA_form">
                                            <fieldset class="textWrap">
                                                <div class="innerBubble">
                                                    <textarea id="ansText" placeholder=""></textarea>
                                                </div>
                                            </fieldset>
                                            <ul class="QA_errors hidden"></ul>
                                            <fieldset class="submitWrap wrap">
                                                <button onclick="sendAns('{{$question->id}}')" class="postButton submit ui_button primary">پاسخ</button>
                                                <a style="color: #16174f" href=""> <span class="postingGuidelines" style="float: left;">راهنما  و قوانین</span></a>
                                            </fieldset>
                                            <h4 style="color: red" id="errMsg"></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="float: left;text-align: center;padding-top: 80px;" class="ad_column ui_column is-4">
                            <img src="{{URL::asset('images/adv1.gif)}}" style="width: 70%;"/>
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footer.layoutFooter')
    </div>

    <div class="ui_backdrop dark" style="display: none;"></div>

    <span id="reportPane" class="ui_overlay ui_modal editTags hidden" style="position: fixed; left: 24%; right: 24%; top:19%; bottom: auto;overflow: auto;max-height: 500px;">
        <div class="header_text">گزارش</div>
        <div class="subheader_text">
       گزارش خود را از بین موضوعات موجود انتخاب نمایید
        </div>
        <div class="body_text">
            <fieldset id="memberTags">
                <div class="reports" id="reports">
                </div>
            </fieldset>
            <br>
            <div class="submitOptions">
                <button onclick="sendReport()" class="btn btn-success" style="color: #FFF;background-color: var(--koochita-light-green);border-color:var(--koochita-light-green);">تایید</button>
                <input type="submit" onclick="closeReportPrompt()" value="خیر" class="btn btn-default">
            </div>
            <div id="errMsgReport" style="color: red"></div>
        </div>
        <div onclick="closeReportPrompt()" class="ui_close_x"></div>
    </span>

    <span class='ui_overlay ui_popover arrow_right img_popUp' style='position: absolute; bottom: auto; display: none; margin: -25px 20px 0 0'>
    </span>

    <script>
        @if($mode == "err")
            $("#errMsg").append('شما قبلا به این سوال پاسخ داده اید');
        @elseif($mode == "report")
            showReportPrompt('{{$logId}}');
        @endif
    </script>

    <script>
        var showUserBriefDetail = '{{route('showUserBriefDetail')}}';
        var opOnComment = '{{route('opOnComment')}}';
        var sendAnsDir = '{{route('sendAns2')}}';
        var hotelDetails = '{{route('hotelDetails', ['placeId' => $placeId, 'placeName' => $place->name])}}';
        var questionList = '{{route('seeAllAns', ['questionId' => $question->id])}}';
        var reportDir = '{{route('report')}}';
        var hasLogin = '{{$hasLogin}}';
        var questionId = '{{$question->id}}';
        var sendReportDir = '{{route('sendReport2')}}';
        var getReportsDir = '{{route('getReports')}}';
        var questionListInLikeMode = '{{route('seeAllAns', ['questionId' => $question->id, 'mode' => 'like'])}}';
    </script>

    <script>

        @if($mode == "like")
            likeAns('{{$logId}}');
        @elseif($mode == "dislike")
            dislikeAns('{{$logId}}');
        @elseif($mode == "sendAns")
            sendAns2('{{$question->id}}', '{{$logId}}');
        @endif
    </script>

    <script>
        var selectedLogId;

        $(document).ready(function(){

            $(".img_btn").on({
                mouseenter: function(){

                    var bodyRect = document.body.getBoundingClientRect(),
                            elemRect = this.getBoundingClientRect(),
                            offset2 = elemRect.left - bodyRect.left,
                            offset   = elemRect.top - bodyRect.top;

                    if(offset < 0)
                        offset = Math.abs(offset);

                    $(".img_popUp").css("top", offset);
                    $(".img_popUp").css("left", offset2 - 450);

                    showDetails($(this).attr('data-val'));
                },
                mouseleave: function(){
                    $(".img_popUp").hide();
                },
            });

            $(".img_popUp").on({
                mouseenter: function(){
                    $(".img_popUp").show();
                },
                mouseleave: function(){
                    $(".img_popUp").hide();
                },
            });

        });

        function showElement(element) {
            $(".pop-up").addClass('hidden');
            $(".item").addClass('hidden');
            $("#" + element).removeClass('hidden');
        }

        function hideElement(element) {
            $("#" + element).addClass('hidden');
        }

        function showDetails(username) {

            $.ajax({
                type: 'post',
                url: showUserBriefDetail,
                data: {
                    'username': username
                },
                success: function (response) {

                    response = JSON.parse(response);

                    total = response.excellent + response.veryGood + response.average + response.bad + response.veryBad;
                    total /= 100;

                    $(".img_popUp").empty();

                    newElement = "<div class='arrow' style=' margin: 0 30px 155px 0;'></div>";
                    newElement += "<div class='body_text'>";
                    newElement += "<div class='memberOverlay simple container moRedesign'>";
                    newElement += "<div class='innerContent'>";
                    newElement += "<div class='memberOverlayRedesign g10n'>";
                    newElement += "<a href='" + homeURL + "/profile/index/" + username + "'>";
                    newElement += "<h3 class='username reviewsEnhancements'>" + username + "</h3>";
                    newElement += "</a>";
                    newElement += "<div class='memberreviewbadge'>";
                    newElement += "<div class='badgeinfo'>";
                    newElement += "سطح <span>" + response.level + "</span>";
                    newElement += "</div></div>";
                    newElement += "<ul class='memberdescriptionReviewEnhancements'>";
                    newElement += "<li>تاریخ عضویت در سایت " + response.created + "</li>";
                    newElement += "<li>از " + response.city + " در " + response.state +  " </li>";
                    newElement += "</ul>";
                    newElement += "<ul class='countsReviewEnhancements'>";
                    newElement += "<li class='countsReviewEnhancementsItem'>";
                    newElement += "<span class='ui_icon pencil-paper iconReviewEnhancements'></span>";
                    newElement += "<span class='badgeTextReviewEnhancements'>" + response.rates + " نظر</span>";
                    newElement += "</li>";
                    newElement += "<li class='countsReviewEnhancementsItem'>";
                    newElement += "<span class='ui_icon globe-world iconReviewEnhancements'></span>";
                    newElement += "<span class='badgeTextReviewEnhancements'>" + response.seen + " مشاهده</span>";
                    newElement += "</li>";
                    newElement += "<li class='countsReviewEnhancementsItem'>";
                    newElement += "<span class='ui_icon thumbs-up-fill iconReviewEnhancements'></span>";
                    newElement += "<span class='badgeTextReviewEnhancements'>" + response.likes + " رای مثبت</span>";
                    newElement += "</li>";
                    newElement += "<li class='countsReviewEnhancementsItem'>";
                    newElement += "<span class='ui_icon thumbs-down-fill iconReviewEnhancements'></span>";
                    newElement += "<span class='badgeTextReviewEnhancements'>" + response.dislikes + " رای منفی</span>";
                    newElement += "</li>";
                    newElement += "</ul>";
                    newElement += "<div class='wrap'>";
                    newElement += "<ul class='memberTagsReviewEnhancements'>";
                    newElement += "</ul></div>";
                    newElement += "<div class='wrap'>";
                    newElement += "<div class='wrap container histogramReviewEnhancements'>";
                    newElement += "<div class='barlogoReviewEnhancements'>";
                    newElement += "<span>پراکندگی نظرات</span>";
                    newElement += "</div><ul>";
                    newElement += "<div class='chartRowReviewEnhancements'>";
                    newElement += "<span class='rowLabelReviewEnhancements rowCellReviewEnhancements'>عالی</span>";
                    newElement += "<span class='rowBarReviewEnhancements rowCellReviewEnhancements'>";
                    newElement += "<span class='barReviewEnhancements'>";
                    newElement += "<span class='fillReviewEnhancements' style='width:" + response.excellent / total + "%;'></span>";
                    newElement += "</span></span>";
                    newElement += "<span class='rowCountReviewEnhancements rowCellReviewEnhancements'> " + response.excellent + "</span>";
                    newElement += "</div>";
                    newElement += "<div class='chartRowReviewEnhancements'>";
                    newElement += "<span class='rowLabelReviewEnhancements rowCellReviewEnhancements'>خوب</span>";
                    newElement += "<span class='rowBarReviewEnhancements rowCellReviewEnhancements'>";
                    newElement += "<span class='barReviewEnhancements'>";
                    newElement += "<span class='fillReviewEnhancements' style='width:" + response.veryGood / total + "%;'></span>";
                    newElement += "</span></span>";
                    newElement += "<span class='rowCountReviewEnhancements rowCellReviewEnhancements'> " + response.veryGood + "</span>";
                    newElement += "</div>";
                    newElement += "<div class='chartRowReviewEnhancements'>";
                    newElement += "<span class='rowLabelReviewEnhancements rowCellReviewEnhancements'>معمولی</span>";
                    newElement += "<span class='rowBarReviewEnhancements rowCellReviewEnhancements'>";
                    newElement += "<span class='barReviewEnhancements'>";
                    newElement += "<span class='fillReviewEnhancements' style='width:" + response.average / total + "%;'></span>";
                    newElement += "</span></span>";
                    newElement += "<span class='rowCountReviewEnhancements rowCellReviewEnhancements'> " + response.average + "</span>";
                    newElement += "</div>";
                    newElement += "<div class='chartRowReviewEnhancements'>";
                    newElement += "<span class='rowLabelReviewEnhancements rowCellReviewEnhancements'>ضعیف</span>";
                    newElement += "<span class='rowBarReviewEnhancements rowCellReviewEnhancements'>";
                    newElement += "<span class='barReviewEnhancements'>";
                    newElement += "<span class='fillReviewEnhancements' style='width:" + response.bad / total + "%;'></span>";
                    newElement += "</span></span>";
                    newElement += "<span class='rowCountReviewEnhancements rowCellReviewEnhancements'> " + response.bad + "</span>";
                    newElement += "</div>";
                    newElement += "<div class='chartRowReviewEnhancements'>";
                    newElement += "<span class='rowLabelReviewEnhancements rowCellReviewEnhancements'>خیلی بد</span>";
                    newElement += "<span class='rowBarReviewEnhancements rowCellReviewEnhancements'>";
                    newElement += "<span class='barReviewEnhancements'>";
                    newElement += "<span class='fillReviewEnhancements' style='width:" + response.veryBad / total + "%;'></span>";
                    newElement += "</span></span>";
                    newElement += "<span class='rowCountReviewEnhancements rowCellReviewEnhancements'> " + response.veryBad + "</span>";
                    newElement += "</div></ul></div></div></div></div></div></div>";

                    $(".img_popUp").append(newElement);
                    $(".img_popUp").show();
                }
            });

        }

        function likeAns(logId) {

            if(!hasLogin) {
                url = homeURL + "/seeAllAns/" + questionId + "/like/" + logId;
                showLoginPrompt(url);
                return;
            }

            $.ajax({
                type: 'post',
                url: opOnComment,
                data: {
                    'logId': logId,
                    'mode': 'like'
                },
                success: function (response) {
                    if(response == "1") {
                        $("#score_" + logId).empty();
                        $("#score_" + logId).attr('data-val', parseInt($("#score_" + logId).attr('data-val')) + 1);
                        $("#score_" + logId).append($("#score_" + logId).attr('data-val'));
                    }
                    else if(response == "2") {
                        $("#score_" + logId).empty();
                        $("#score_" + logId).attr('data-val', parseInt($("#score_" + logId).attr('data-val')) + 2);
                        $("#score_" + logId).append($("#score_" + logId).attr('data-val'));
                    }
                }
            });
        }

        function dislikeAns(logId) {

            if(!hasLogin) {
                url = homeURL + "/seeAllAns/" + questionId + "/dislike/" + logId;
                showLoginPrompt(url);
                return;
            }

            $.ajax({
                type: 'post',
                url: opOnComment,
                data: {
                    'logId': logId,
                    'mode': 'dislike'
                },
                success: function (response) {
                    if(response == "1") {
                        $("#score_" + logId).empty();
                        $("#score_" + logId).attr('data-val', parseInt($("#score_" + logId).attr('data-val')) - 1);
                        $("#score_" + logId).append($("#score_" + logId).attr('data-val'));
                    }
                    else if(response == "2") {
                        $("#score_" + logId).empty();
                        $("#score_" + logId).attr('data-val', parseInt($("#score_" + logId).attr('data-val')) - 2);
                        $("#score_" + logId).append($("#score_" + logId).attr('data-val'));
                    }
                }
            });
        }

        function report(logId) {

            $.ajax({
                type: 'post',
                url: reportDir,
                data: {
                    'logId': logId
                }
            });

        }

        function sendAns(logId) {

            if($("#ansText").val() == "")
                return;

            if(!hasLogin) {
                url = homeURL + "/seeAllAns/" + questionId + "/sendAns/" + $("#ansText").val();
                showLoginPrompt(url);
                return;
            }

            $.ajax({
                type: 'post',
                url: sendAnsDir,
                data: {
                    'text': $("#ansText").val(),
                    'relatedTo': logId
                },
                success: function (response) {
                    if(response == "ok")
                        document.location.href = questionList;
                    else if(response == "nok") {
                        $("#errMsg").append('شما قبلا به این سوال پاسخ داده اید');
                    }
                }
            });
        }

        function sendAns2(logId, ans) {

            if(ans == "")
                return;

            if(!hasLogin) {
                url = homeURL + "/seeAllAns/" + questionId + "/sendAns/" + ans;
                showLoginPrompt(url);
                return;
            }

            $.ajax({
                type: 'post',
                url: sendAnsDir,
                data: {
                    'text': ans,
                    'relatedTo': logId
                },
                success: function (response) {
                    if(response == "ok")
                        document.location.href = questionList;
                    else if(response == "nok") {
                        document.location.href = homeURL + "/seeAllAns/" + questionId + "/err";
                    }
                }
            });
        }

        function customReport() {

            if($("#custom-checkBox").is(':checked')) {
                $("#custom-define-report").empty();
                newElement = "<div class='col-xs-12'>";
                newElement += "<textarea id='customDefinedReport' style='width: 375px; height: 100px; padding: 5px !important; margin-top: 5px;' maxlength='1000' required placeholder='حداکثر 1000 کاراکتر'></textarea>";
                newElement += "</label></div>";
                $("#custom-define-report").append(newElement);
                $("#custom-define-report").css("visibility", "visible");
            }
            else {
                $("#custom-define-report").empty();
                $("#custom-define-report").css("visibility", "hidden");
            }
        }

        function getReports(logId) {

            $("#reports").empty();

            $.ajax({
                type: 'post',
                url: getReportsDir,
                data: {
                    'logId': logId
                },
                success: function (response) {

                    if(response != "")
                        response = JSON.parse(response);

                    newElement = "<div id='reportContainer' class='row'>";

                    if(response != "") {
                        for (i = 0; i < response.length; i++) {
                            newElement += "<div class='col-xs-12'>";
                            newElement += "<div class='ui_input_checkbox'>";
                            if(response[i].selected == true)
                                newElement += "<input id='report_" + response[i].id + "' type='checkbox' name='reports' checked value='" + response[i].id + "'>";
                            else
                                newElement += "<input id='report_" + response[i].id + "' type='checkbox' name='reports' value='" + response[i].id + "'>";
                            newElement += "<label class='labelForCheckBox' for='report_" + response[i].id + "'><span></span>&nbsp;&nbsp;";
                            newElement += response[i].description;
                            newElement += "</label>";
                            newElement += "</div></div>";
                        }
                    }

                    newElement += "<div class='col-xs-12'>";
                    newElement += "<div class='ui_input_checkbox'>";
                    newElement += "<input id='custom-checkBox' onchange='customReport()' type='checkbox' name='reports' value='-1'>";
                    newElement += "<label class='labelForCheckBox' for='custom-checkBox'><span></span>&nbsp;&nbsp;";
                    newElement += " سایر موارد";
                    newElement += "</label>";
                    newElement += "</div></div>";

                    newElement += "<div id='custom-define-report' style='visibility: hidden'></div>";

                    newElement += "</div>";

                    $("#reports").append(newElement);

                    if(response != "" && response.length > 0 && response[0].text != "") {
                        customReport();
                        $("#customDefinedReport").val(response[0].text);
                    }

                }
            });
        }

        function sendReport() {

            customMsg = "";

            if($("#customDefinedReport").val() != null)
                customMsg = $("#customDefinedReport").val();

            var checkedValuesReports = $("input:checkbox[name='reports']:checked").map(function() {
                return this.value;
            }).get();

            if(checkedValuesReports.length <= 0)
                return;

            if(!hasLogin) {
                url = homeURL + "/seeAllAns/" + questionId + "/report/" + selectedLogId;
                showLoginPrompt(url);
                return;
            }

            $.ajax({
                type: 'post',
                url: sendReportDir,
                data: {
                    "logId": selectedLogId,
                    "reports": checkedValuesReports,
                    "customMsg" : customMsg
                },
                success: function (response) {
                    if(response == "ok") {
                        closeReportPrompt();
                    }
                    else {
                        $("#errMsgReport").append('مشکلی در انجام عملیات مورد نظر رخ داده است');
                    }
                }
            });
        }

        function closeReportPrompt() {
            $("#custom-checkBox").css("visibility", 'hidden');
            $("#custom-define-report").css("visibility", 'hidden');
            $("#reportPane").addClass('hidden');
            $('.dark').hide();
        }

        function showReportPrompt(logId) {

            if(!hasLogin) {
                url = homeURL + "/seeAllAns/" + questionId + "/report/" + logId;
                showLoginPrompt(url);
                return;
            }

            selectedLogId = logId;
            getReports(logId);
            $('.dark').show();
            showElement('reportPane');
        }
    </script>


    </body>
</html>