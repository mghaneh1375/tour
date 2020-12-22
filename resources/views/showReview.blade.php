<!DOCTYPE html>
<html>
<head>

    @include('layouts.topHeader')

    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/long_lived_global_legacy_2.css?v=1')}}' />
    <link rel='stylesheet' type='text/css' media='screen, print' href='{{URL::asset('css/theme2/attraction_sur.css?v=1')}}'/>
    <link rel='stylesheet' type='text/css' media='screen, print' href='{{URL::asset('css/theme2/attraction_sur_deferrable.css?v=1')}}' />
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/photo_albums_stacked.css?v=1')}}'/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/media_albums_extended.css?v=1')}}'/>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/theme2/popUp.css?v=1')}}">

    <title>{{$log->subject}}</title>

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
            border-radius: 4px;

        }

        .btn-default {
            color: #333;
            background-color: #fff;
            border-color: #ccc;
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
        #MAIN{
            font-size: 0.75em;
        }
        .global-nav-profile-menu .subItem a{
            font-size: 0.75em;
        }
    </style>

</head>
<body class=" sur_layout_redesign  fall_2013_refresh_hr_top  ltr domn_en_US lang_en long_prices globalNav2011_reset rebrand_2017 css_commerce_buttons flat_buttons sitewide xo_pin_user_review_to_top track_back">

    @include('layouts.placeHeader')
    <div id="MAINWRAP" style="direction: rtl;" class=" ">
        <div id="MAIN" class="ShowUserReviews prodp13n_jfy_overflow_visible">
            <div id="BODYCON" class="col easyClear bodLHN poolC adjust_padding new_meta_chevron_v2">
                <div></div>
                <div id="HEADING_GROUP" class=" floatContainer ">
                    <div id="headingWrapper" class="headerWrapPadding jfy_beta " style="">
                        <h1 id="HEADING">
                            <span class="savesPadding" style="float: left !important"></span>
                            <div id="PAGEHEADING">{{$log->subject}}
                                <p style="font-size: 10px;margin-top: 10px;">نقدی درباره {{$placeName}}  </p>
                            </div>

                        </h1>
                    </div>
                </div>
                <div id="listing_main_sur">
                    <div class="metacontent fl" style="float: right !important;">
                        <div id="BC_PHOTOS" class="photoLowPriceContent">
                            <ul class="ug_thumbs wrap">
                                <li class="ug_thumb">
                                    <a>
                                        <img src="{{$placePic}}" alt="" width="100%" height="100%">
                                    </a>
                                </li>
                            </ul>
                            <div class="hPhotoLink hPhotoLinkLrg" style="width: 85px !important; text-align: center">
                                <span class="taLnk hvrIE6">{{$userPhotosCount + $sitePhotosCount}} عکس</span>
                            </div>
                        </div>
                        <div class="locationContentCenter" property="itemReviewed" typeof="LocalBusiness" style="border-right: 0 !important; ">
                            <span property="image" content=""></span>
                            <div class="surContent">
                              <a href="{{route('hotelDetails', ['placeId' => $log->placeId, 'placeName' => $placeName])}}"><span property="name" style="font-size: 15px;">{{$placeName}}</span></a>
                                <div class="wrap infoBox blLinks">

                                    @if(!empty($address))
                                        <address class="addressReset" property="address" typeof="PostalAddress">
                                            <span>
                                               <div class="icnLink ui_icon map-pin-fill fl"></div>
                                               <span class="format_address"><span class="street-address">{{$address}}</span> </span>
                                            </span>
                                        </address>
                                    @endif

                                    <div style="display: block;margin-top: 10px;" class="odcHotel blDetails">
                                        @if(!empty($phone))
                                            <div class="fl notLast">
                                                <div class="  ui_icon phone  fl icnLink"></div>
                                                <div class="fl phoneNumber">{{$phone}}</div>
                                            </div>
                                        @endif

                                        @if(!empty($site))
                                            <div class="fl notLast">
                                                <div class="  ui_icon laptop  fl icnLink"></div>
                                                <div class="fl">
                                                    <a target="_blank" href="{{$site}}" style="cursor: pointer">{{$site}}</a>
                                                </div>
                                            </div>
                                        @endif
                                        <br> <br>

                                    <span class="rating reviewItem">
                                        @if($rate == 5)
                                            <span class="ui_bubble_rating bubble_50" property="ratingValue" content="5.0" alt="5 of 5 bubbles" style="float: right !important; margin: 0 0 0 4px !important"></span>
                                        @elseif($rate == 4)
                                            <span class="ui_bubble_rating bubble_40" property="ratingValue" content="4.0" alt="4 of 5 bubbles" style="float: right !important; margin: 0 0 0 4px !important"></span>
                                        @elseif($rate == 3)
                                            <span class="ui_bubble_rating bubble_30" property="ratingValue" content="3.0" alt="3 of 5 bubbles" style="float: right !important; margin: 0 0 0 4px !important"></span>
                                        @elseif($rate == 2)
                                            <span class="ui_bubble_rating bubble_20" property="ratingValue" content="2.0" alt="2 of 5 bubbles" style="float: right !important; margin: 0 0 0 4px !important"></span>
                                        @else
                                            <span class="ui_bubble_rating bubble_10" property="ratingValue" content="1.0" alt="1 of 5 bubbles" style="float: right !important; margin: 0 0 0 4px !important"></span>
                                        @endif
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearFix"></div>
                </div>
                <div id="SHOW_USER_REVIEW" class="gridA arr">
                    <div class="col balance ad_column ui_column is-8" style="float: right !important; border-left: 1px solid #e6e6e6; border-right: 0 !important; padding: 0 0 5px 20px !important;">
                        <div id="REVIEWS" class="deckC">
                            <div class="nolow hrCA ajax_preserve" data-ajax-preserve="cta_topline_div" id="cta_topline_div" style="display: none;">
                                <div class="attnBar_SA">
                                    <div class="inner">
                                        <div class="sprite-orangeAlert excl"></div>
                                        <div class="header"></div>
                                        <div class="header2 taLnk hvrIE6"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="reviewSelector">
                                <div class="extended provider0 review inlineReviewUpdate first">
                                    <div class="col1of2 COL1OF2">
                                        <div class="member_info">
                                            <div class="memberOverlayLink">
                                                <div class="avatar img_btn" data-val="{{$log->visitorId}}" style="float: right !important">
                                                    <img width="74" class="avatar" height="74" src='{{$log->visitorPic}}'/>
                                                </div>
                                                <div class="username mo"></div>
                                            </div>
                                            <div class="location">{{$log->visitorId}}</div>
                                        </div>
                                        <div class="memberBadging g10n">
                                            <div class="no_cpu">{{$log->city}} در {{$log->state}}</div>
                                            <div id="UID_E2004EF79435C45F98CB1113EDD6B0DE-HV" class="helpfulVotesBadge badge no_cpu" style="text-align: center; margin: 12px 0 3px;background: var(--koochita-light-green);height: 30px;line-height: 30px;border-radius: 4px;
box-shadow: 0 2px 3px 0px #CCC;padding-left: 0;padding-right:0;">

                                          <span class="badgeText">{{$log->commentsCount}} نقد</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2of2 COL2OF2">
                                    <div class="innerBubble">
                                        <div property="name" class="quote">{{$log->subject}}</div>
                                        <div class="rating reviewItemInline">
                                            @if($log->rate == 5)
                                                <span class="ui_bubble_rating bubble_50" style="float: left !important;margin-right: 8px !important;margin-top: -1px;"></span>
                                            @elseif($log->rate == 4)
                                                <span class="ui_bubble_rating bubble_40" style="float: left !important;margin-right: 8px !important;margin-top: -1px;"></span>
                                            @elseif($log->rate == 3)
                                                <span class="ui_bubble_rating bubble_30" style="float: left !important;margin-right: 8px !important;margin-top: -1px;"></span>
                                            @elseif($log->rate == 2)
                                                <span class="ui_bubble_rating bubble_20" style="float: left !important;margin-right: 8px !important;margin-top: -1px;"></span>
                                            @else
                                                <span class="ui_bubble_rating bubble_10" style="float: left !important;margin-right: 8px !important;margin-top: -1px;"></span>
                                            @endif
                                          <span class="ratingDate" content="2016-06-12" property="">{{$log->date}}
                                          </span>
                                        </div>
                                        <div class="entry">
                                            <p property="reviewBody">
                                                {{$log->text}}
                                            </p>
                                        </div>
                                        <br>
                                        <div class="entry">
                                            <p property="reviewBody">
                                                @if(isset($log->userPic))
                                                    <img src="{{$log->userPic}}" style="float: right;width: 100px;"/>
                                                @endif
                                            <div style="clear: both;"></div>
                                            </p>
                                        </div>
                                        <br><br>

                                        <div class="tooltips vertically_centered" onclick="likeComment('{{$log->id}}')" style="float: right !important;">
                                            <div class="reportProblem">
                                             <span style="cursor: pointer;float: right;margin-left: 10px;padding: 0px;" class="thankButton hsx_thank_button">
                                                  <span class="helpful_text" style="line-height: 15px;">
                                                      <span style="color: #3e3e3e;font-size: 15px;color: var(--koochita-light-green)" class="ui_icon thumbs-up-fill emphasizeWithColor"></span>
                                                      <span id='commentLikes_{{$log->id}}' data-val="{{$likes}}" class="numHelp emphasizeWithColor">{{$likes}}</span>
                                                      <span class="thankUser"> {{$log->visitorId}} </span>
                                                  </span>
                                               </span>
                                               <span style="cursor: pointer; float: right;margin-left: 10px;padding: 0px;" onclick="dislikeComment('{{$log->id}}')" class="thankButton hsx_thank_button">
                                                   <span class="helpful_text" style="line-height: 15px;">
                                                       <span style="color: #3e3e3e;font-size: 15px;color: var(--koochita-light-green);" class="ui_icon thumbs-down-fill emphasizeWithColor"></span>
                                                       <span id='commentDislikes_{{$log->id}}' data-val="{{$dislikes}}" class="numHelp emphasizeWithColor">{{$dislikes}}</span>
                                                       <span class="thankUser"> {{$log->visitorId}} </span>
                                                   </span>
                                               </span>

                                                <span style="color: #16174f;font-size: 11px;float: right;margin-right: 10px;" onclick="showReportPrompt('{{$log->id}}')" class="taLnk no_cpu ui_icon ">گزارش تخلف</span>
                                            </div>
                                        </div>
                                        <div class="note"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ratings_and_types">
                            <a href="{{route('review', ['placeId' => $log->placeId, 'kindPlaceId' => $log->kindPlaceId])}}" class="rndBtn ui_button primary button_war" style="float: left !important; margin-right: 5px">نقد</a>
                            @if(Auth::check() && Auth::user()->level == 1)
                                <button onclick="removeReview('{{$log->id}}')" class="rndBtn ui_button primary
                                button_war" style="float: left !important;
                                ">حذف</button>
                            @endif
                            <h3 class="reviews_header">  نقد های دیگر</h3>
                            <div class="ppr_rup ppr_priv_review_filter_controls">
                                <div class="ui_tagcloud_group easyClear">
                                    @foreach($tags as $tag)
                                        <span style="color: #16174f;border-color:#16174f; " onclick="document.location.href = '{{route('home')}}' + '/showReview/{{$tag->id}}';" class="ui_tagcloud fl">{{$tag->subject}}</span>
                                    @endforeach
                                </div>
                                <br><br>
                                <br><br><br><br>
                            </div>
                        </div>
                        <div class="deckTools">
                            <div class="srtTools" style="border-bottom: none !important;">
                            </div>
                        </div>
                    </div>
                </div>
                    <div style="float: left;text-align: center;" class="ad_column ui_column is-4">
                        <img src="{{URL::asset('images/adv1.gif')}}" style="width: 70%;"/>
                    </div>
                    <div style="clear: both;"></div>
            </div>
        </div>
    </div>
</div>

    <span class='ui_overlay ui_popover arrow_right img_popUp' style='position: absolute; left: auto; right: 355px; bottom: auto; direction: rtl; display: none; margin: -25px 20px 0 0'></span>

    @include('layouts.footer.layoutFooter')

    <div class="ui_backdrop dark" style="display: none;"></div>

    @if(!Auth::check())
        @include('layouts.loginPopUp')
    @endif
    <script>
        var showUserBriefDetail = '{{route('showUserBriefDetail')}}';
        var hasLogin = '{{$hasLogin}}';
        var sendReportDir = '{{route('sendReport2')}}';
        var getReportsDir = '{{route('getReports')}}';
        var opOnComment = '{{route('opOnComment')}}';
        var getPhotosDir = '{{route('getPhotos')}}';
        var placeId = '{{$log->placeId}}';
        var kindPlaceId = '{{$log->kindPlaceId}}';
        var totalPhotos = '{{$userPhotosCount + $sitePhotosCount}}';
        var sitePhotosCount = '{{$sitePhotosCount}}';
        var userPhotos = '{{$userPhotosCount}}';
    </script>

    <script async src="{{URL::asset('js/album.js')}}"></script>

    <script>
        var selectedLogId;
        var sliderPics = [];
        var idxSlideBar;
        var SliderFilter;

        $(document).ready(function(){

            $(".img_btn").on({
                mouseenter: function(){

                    var bodyRect = document.body.getBoundingClientRect(),
                            elemRect = this.getBoundingClientRect(),
                            offset2 = elemRect.left - bodyRect.left,
                            offset = elemRect.top - bodyRect.top;

                    if(offset < 0)
                        offset = Math.abs(offset);

                    $(".img_popUp").css("top", offset).css("left", offset2 - 450);

                    showDetails($(this).attr('data-val'));
                },
                mouseleave: function() {
                    $(".img_popUp").addClass('hidden');
                }
            });

            $(".img_popUp").on({
                mouseenter: function(){
                    $(".img_popUp").removeClass('hidden');
                },
                mouseleave: function(){
                    $(".img_popUp").addClass('hidden');
                }
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

        function removeReview(logId) {
            
            $.ajax({
                type: 'post',
                url: '{{route('removeReview')}}',
                data: {
                    'logId': logId
                },
                success: function (response) {
                    if(response == "ok")
                        document.location.href = '{{route('home')}}';
                }
            });
        }
        
        function showDetails(username) {

            if(username == null)
                return;

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
                    newElement += "Level <span>" + response.level + "</span>";
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
                    newElement += "<span>REVIEW DISTRIBUTION</span>";
                    newElement += "</div><ul>";
                    newElement += "<div class='chartRowReviewEnhancements'>";
                    newElement += "<span class='rowLabelReviewEnhancements rowCellReviewEnhancements'>Excellent</span>";
                    newElement += "<span class='rowBarReviewEnhancements rowCellReviewEnhancements'>";
                    newElement += "<span class='barReviewEnhancements'>";
                    newElement += "<span class='fillReviewEnhancements' style='width:" + response.excellent / total + "%;'></span>";
                    newElement += "</span></span>";
                    newElement += "<span class='rowCountReviewEnhancements rowCellReviewEnhancements'> " + response.excellent + "</span>";
                    newElement += "</div>";
                    newElement += "<div class='chartRowReviewEnhancements'>";
                    newElement += "<span class='rowLabelReviewEnhancements rowCellReviewEnhancements'>Very good</span>";
                    newElement += "<span class='rowBarReviewEnhancements rowCellReviewEnhancements'>";
                    newElement += "<span class='barReviewEnhancements'>";
                    newElement += "<span class='fillReviewEnhancements' style='width:" + response.veryGood / total + "%;'></span>";
                    newElement += "</span></span>";
                    newElement += "<span class='rowCountReviewEnhancements rowCellReviewEnhancements'> " + response.veryGood + "</span>";
                    newElement += "</div>";
                    newElement += "<div class='chartRowReviewEnhancements'>";
                    newElement += "<span class='rowLabelReviewEnhancements rowCellReviewEnhancements'>Average</span>";
                    newElement += "<span class='rowBarReviewEnhancements rowCellReviewEnhancements'>";
                    newElement += "<span class='barReviewEnhancements'>";
                    newElement += "<span class='fillReviewEnhancements' style='width:" + response.average / total + "%;'></span>";
                    newElement += "</span></span>";
                    newElement += "<span class='rowCountReviewEnhancements rowCellReviewEnhancements'> " + response.average + "</span>";
                    newElement += "</div>";
                    newElement += "<div class='chartRowReviewEnhancements'>";
                    newElement += "<span class='rowLabelReviewEnhancements rowCellReviewEnhancements'>Poor</span>";
                    newElement += "<span class='rowBarReviewEnhancements rowCellReviewEnhancements'>";
                    newElement += "<span class='barReviewEnhancements'>";
                    newElement += "<span class='fillReviewEnhancements' style='width:" + response.bad / total + "%;'></span>";
                    newElement += "</span></span>";
                    newElement += "<span class='rowCountReviewEnhancements rowCellReviewEnhancements'> " + response.bad + "</span>";
                    newElement += "</div>";
                    newElement += "<div class='chartRowReviewEnhancements'>";
                    newElement += "<span class='rowLabelReviewEnhancements rowCellReviewEnhancements'>Terrible</span>";
                    newElement += "<span class='rowBarReviewEnhancements rowCellReviewEnhancements'>";
                    newElement += "<span class='barReviewEnhancements'>";
                    newElement += "<span class='fillReviewEnhancements' style='width:" + response.veryBad / total + "%;'></span>";
                    newElement += "</span></span>";
                    newElement += "<span class='rowCountReviewEnhancements rowCellReviewEnhancements'> " + response.veryBad + "</span>";
                    newElement += "</div></ul></div></div></div></div></div></div>";

                    $(".img_popUp").append(newElement).removeClass('hidden');
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

        function customReport() {

            if($("#custom-checkBox").is(':checked')) {
                newElement = "<div class='col-xs-12'>";
                newElement += "<textarea id='customDefinedReport' style='width: 375px; height: 100px; padding: 5px !important; margin-top: 5px;' maxlength='1000' required placeholder='حداکثر 1000 کاراکتر'></textarea>";
                newElement += "</label></div>";
                $("#custom-define-report").empty().append(newElement).css("visibility", "visible");
            }
            else {
                $("#custom-define-report").empty().css("visibility", "hidden");
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
                    newElement += "سایر موارد";
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
            $(".dark").hide();
        }

        function showReportPrompt(logId) {

            if(!hasLogin) {
                url = homeURL + "/seeAllAns/" + questionId + "/report/" + logId;
                showLoginPrompt(url);
                return;
            }

            selectedLogId = logId;
            getReports(logId);
            showElement('reportPane');
            $(".dark").show();
        }

        function dislikeComment(logId) {

            $.ajax({
                type: 'post',
                url: opOnComment,
                data: {
                    'logId': logId,
                    'mode': 'dislike'
                },
                success: function (response) {
                    if(response == "1") {
                        $("#commentDislikes_" + logId).empty().attr('data-val', parseInt($("#commentDislikes_" + logId).attr('data-val')) + 1)
                                .append($("#commentDislikes_" + logId).attr('data-val'));
                    }
                    else if(response == "2") {
                        $("#commentDislikes_" + logId).empty()
                                .attr('data-val', parseInt($("#commentDislikes_" + logId).attr('data-val')) + 1)
                                .append($("#commentDislikes_" + logId).attr('data-val'));

                        $("#commentLikes_" + logId).empty()
                                .attr('data-val', parseInt($("#commentLikes_" + logId).attr('data-val')) - 1)
                                .append($("#commentLikes_" + logId).attr('data-val'));
                    }
                }
            });
        }

        function likeComment(logId) {

            $.ajax({
                type: 'post',
                url: opOnComment,
                data: {
                    'logId': logId,
                    'mode': 'like'
                },
                success: function (response) {
                    if(response == "1") {
                        $("#commentLikes_" + logId).empty()
                                .attr('data-val', parseInt($("#commentLikes_" + logId).attr('data-val')) + 1)
                                .append($("#commentLikes_" + logId).attr('data-val'));
                    }
                    else if(response == "2") {
                        $("#commentLikes_" + logId).empty()
                                .attr('data-val', parseInt($("#commentLikes_" + logId).attr('data-val')) + 1)
                                .append($("#commentLikes_" + logId).attr('data-val'));

                        $("#commentDislikes_" + logId).empty()
                                .attr('data-val', parseInt($("#commentDislikes_" + logId).attr('data-val')) - 1)
                                .append($("#commentDislikes_" + logId).attr('data-val'));
                    }
                }
            });
        }

        function showBriefPopUp(thisVar, owner) {

            var bodyRect = document.body.getBoundingClientRect(),
                    elemRect = thisVar.getBoundingClientRect(),
                    offset2 = elemRect.left - bodyRect.left,
                    offset   = elemRect.top - bodyRect.top;

            if(offset < 0)
                offset = Math.abs(offset);

            $(".img_popUp").css("left", offset2 - 450).css("top", offset);
            showDetails(owner);
        }
    </script>

<script>
    $(document).ready(function(){

        $("#BC_PHOTOS").click(function(){
            getPhotos('{{$log->placeId}}', '{{$log->kindPlaceId}}');
        });

        $(".close_album").click(function(){

            $("#photo_album_span").hide();
        });

        {{--$('.login-button').click(function() {--}}

        {{--    var url = '{{route('showReview', ['id' => $log->id])}}';--}}

        {{--    // $(".dark").show();--}}
        {{--    showLoginPrompt(url);--}}
        {{--});--}}

    });
</script>

</body>
</html>

