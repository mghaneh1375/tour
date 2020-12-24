<!DOCTYPE html>
<html>

<head>
    @section('header')
        @include('layouts.topHeader')
{{--        <link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/long_lived_global_legacy_1.css?v=1')}}'/>--}}
        <link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/long_lived_global_legacy_2.css?v='.$fileVersions)}}'/>
        <link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/short_lived_global_legacy.css?v='.$fileVersions)}}'/>
        <link rel='stylesheet' type='text/css' media='screen, print' href='{{URL::asset('css/theme2/universal_new.css?v='.$fileVersions)}}' data-rup='universal_new'/>
        <link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/masthead-saves.css?v='.$fileVersions)}}' data-rup='long_lived_global_legacy'/>
        <title>کوچیتا | صفحه کاربری</title>
        <link rel="stylesheet" type="text/css" media="screen, print" href="{{URL::asset('css/theme2/mbr_profile.css?v='.$fileVersions)}}"/>
        <!--[if IE 6]>
        <link rel="stylesheet" type="text/css" media="screen, print" href="{{URL::asset('css/theme2/winIE6.css?v='.$fileVersions)}}" />
        <![endif]-->
        <!--[if IE 7]>
        <link rel="stylesheet" type="text/css" media="screen, print" href="{{URL::asset('css/theme2/winIE7.css?v='.$fileVersions)}}" />
        <![endif]-->

        <link rel='stylesheet' type='text/css' media='screen, print' href='{{URL::asset('css/theme2/modules_member_center.css?v='.$fileVersions)}}'/>
        <link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/persistent_header_achievements.css?v='.$fileVersions)}}' data-rup='persistent_header_achievements'/>

        <script>
            var getRecentlyPath = '{{route('recentlyViewed')}}';
        </script>
        <style>
            .bubble_40:after {
                content: "\e00d\e00b\e00b\e00b\e00b" !important;
            }
            .bubble_30:after {
                content: "\e00d\e00d\e00b\e00b\e00b" !important;
            }
            .bubble_20:after {
                content: "\e00d\e00d\e00d\e00b\e00b" !important;
            }
            .bubble_10:after {
                content: "\e00d\e00d\e00d\e00d\e00b" !important;
            }

            .loader {
                background-image: url("{{URL::asset("images/loading.gif?v=".$fileVersions)}}");

                width: 100px;
                height: 100px;
            }
            .global-nav-links-menu a{
                color: #FFF !important;
            }
            .modules-membercenter-persistent-header-achievements .persistent-header a{
                color: #16174f !important;
            }
            .persistent-header a:hover{
                color:#963019 !important;
                text-decoration: none;
            }
        </style>
    @show
</head>

<body class="ltr domn_en_US lang_en long_prices globalNav2011_reset rebrand_2017 css_commerce_buttons flat_buttons sitewide xo_pin_user_review_to_top track_back">

<div id="fb-root"></div>

<div id="iframediv"></div>

<div id="PAGE" class=" non_hotels_like desktop scopedSearch">

    <div class="masthead">
        <DIV ID="taplc_global_nav_0" class="ppr_rup ppr_priv_global_nav">

            <div class="global-nav global-nav-single-line has-links ">
                <div class="global-nav-top">
                    <div class="global-nav-bar global-nav-green" style="background-color: var(--koochita-light-green) !important;">
                        <div class="ui_container global-nav-bar-container">
                            <div class="global-nav-hamburger is-hidden-tablet"><span class="ui_icon menu-bars"></span></div>
                            <a href="{{route('main')}}" class="global-nav-logo  "><img src="{{URL::asset('images/logo.svg')}}" alt="کوچیتا" class="global-nav-img global-nav-svg"/></a>
                            <div class="global-nav-links ui_tabs inverted is-hidden-mobile">
                                <div id="taplc_global_nav_links_0" class="ppr_rup ppr_priv_global_nav_links" data-placement-name="global_nav_links">
                                    <div class="global-nav-links-container">
                                        <ul class="global-nav-links-menu">
                                            <li class="" data-element=".masthead-dropdown-hotels"><a href="{{route('main')}}" id="global-nav-hotels" class="unscoped global-nav-link ui_tab " data-tracking-label="hotels">هتل</a></li>
                                            <li class=""><a href="{{route('mainMode', ['mode' => 'restaurant'])}}" id="global-nav-vr" class="unscoped global-nav-link ui_tab">رستوران ها</a></li>
                                            <li class=""><a href="{{route('mainMode', ['mode' => 'amaken'])}}" id="global-nav-restaurants" class="unscoped global-nav-link ui_tab">جاذبه ها</a></li>
                                                <li><a href="{{route('tickets')}}" class="unscoped global-nav-link ui_tab ">بلیط</a></li>
                                            <li class=""><a href="" id="global-nav-Flights" class="unscoped global-nav-link ui_tab " data-tracking-label="Flights">جشنواره ها</a></li>
                                            <li class=""><a href="" id="global-nav-Flights" class="unscoped global-nav-link ui_tab " data-tracking-label="Flights"> آداب و رسوم</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="global-nav-actions">
                                @if(Auth::check())
                                    <div id="taplc_global_nav_action_trips_0" class="ppr_rup ppr_priv_global_nav_action_trips">
                                        <div class="masthead-saves" title="My Trips and Recently Viewed">
                                            <a class="trips-icon">
                                                <span onclick="showRecentlyViews('recentlyViewed')" class="ui_icon my-trips"></span>
                                            </a>
                                        </div>
                                        <div class="global-nav-overlays-container">
                                            @include('layouts.recentlyViewAndMyTrips')
                                        </div>
                                    </div>

                                    <div id="taplc_global_nav_action_profile_0" class="ppr_rup ppr_priv_global_nav_action_profile">
                                        <div class="global-nav-profile global-nav-utility">
                                            <div class="global-nav-utility-activator" title="Profile"><span onclick="document.location.href = '{{route('profile')}}'" class="ui_icon member"></span><span id="nameTop" class="name">{{$user->username}}</span></div>
                                            <div class="global-nav-overlays-container"> <div id="profile-drop" class="ui_overlay ui_flyout global-nav-flyout global-nav-utility" style="display:none; position: absolute; left: 32px; top: 49px; bottom: auto;"><ul class="global-nav-profile-menu">
                                                        <li class="subItem"><a href="{{route('profile')}}" class="subLink" data-tracking-label="UserProfile_viewProfile">صفحه کاربری</a></li>
                                                        <li class="subItem rule"><a href="{{route('soon')}}" class="subLink global-nav-submenu-divided" data-tracking-label="UserProfile_bookings">رزروها</a></li>
                                                        <li class="subItem "><a href="{{route('soon')}}" class="subLink" data-tracking-label="UserProfile_inbox">پروازها</a></li>
                                                        <li class="subItem rule"><a href="{{route('msgs')}}" class="subLink global-nav-submenu-divided" data-tracking-label="UserProfile_messages">پیام ها</a> </li>
                                                        <li class="subItem"><a href="{{route('profile.accountInfo')}}" class="subLink" data-tracking-label="UserProfile_settings">اطلاعات کاربر </a></li>
                                                        <li class="subItem"><a href="{{route('logout')}}" class="subLink" data-tracking-label="UserProfile_signout">خروج</a></li>
                                                    </ul></div>
                                            </div>
                                        </div>


                                    </div>
                                @else
                                    <div id="entryBtnId" class="ppr_rup ppr_priv_global_nav_action_profile">
                                        <div class="global-nav-profile global-nav-utility">
                                            <a class="ui_button secondary small login-button" title="Join">عضویت / ورود</a>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div style="clear: both;"></div>
                        </div>
                    </div>
                </div>
                <div class="sidebar-nav-wrapper hidden">
                    <div class="sidebar-nav-backdrop"></div>
                    <div class="sidebar-nav-container">
                        <div class="ui_container">
                            <div class="sidebar-nav-header">
                                <div class="sidebar-nav-close">
                                    <div class="ui_icon times"></div>
                                </div>
                                <a href="/" class="global-nav-logo"><img src='{{URL::asset('images/logo.png')}}' alt="کوچیتا" class="global-nav-img"/></a>
                            </div>
                            @if(Auth::check())
                                <div class="sidebar-nav-profile-container">
                                    <div class="sidebar-nav-profile-linker">
                                        <a class="global-nav-profile-linker">
                                            <span onclick="document.location.href = '{{route('profile')}}'" class="ui_icon member"></span>
                                            <div class="profile-link">
                                                <div class="profile-name">{{Auth::user()->username}}</div>
                                                <div class="profile-link-text">صفحه کاربری</div>
                                            </div>
                                        </a>
                                    </div>
                                    <p class="sidebar-nav-title">اکانت من</p>
                                    <div class="sidebar-nav-profile">
                                        <li class="subItem"><a href="" class="subLink global-nav-submenu-divided">سفرهای من</a></li>
                                        <li class="subItem"><a href="" class="subLink global-nav-submenu-divided" data-tracking-label="UserProfile_ManagementCenter">رزروها</a></li>
                                        <li class="subItem"><a href="" class="subLink" data-tracking-label="UserProfile_inbox">پروازها</a></li>
                                        <li class="subItem"><a href="" class="subLink" data-tracking-label="UserProfile_signout">خروج</a></li>
                                    </div>
                                </div>
                            @endif
                            <div class="sidebar-nav-links-container">
                                <p class="sidebar-nav-title">Browse</p>
                                <div class="sidebar-nav-links"></div>
                                <div class="sidebar-nav-links-more"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="clear: both;"></div>
            </div>

        </DIV>
        <!--etk-->
    </div>

    <div id="MAINWRAP" class=" ">

        <div class="modules-membercenter-persistent-header-achievements " style="background-color: var(--koochita-yellow) !important;">
            <ul class="persistent-header">
                @if($mode == "profile")
                    <li id="Profile" class="profile"><a style="color: #963019 !important" href="{{route('profile', ['username' => $user->username])}}">صفحه کاربری</a> </li>
                @else
                    <li id="Profile" class="profile"><a style="color: #16174f" href="{{route('profile', ['username' => $user->username])}}">صفحه کاربری</a> </li>
                @endif
                @if($mode == "badge")
                    <li id="BadgeCollection" class="badgeCollection"><a style="color: #963019 !important" href="{{route('otherBadge', ['username' => $user->username])}}">مدال های گردشگری</a> </li>
                @else
                    <li id="BadgeCollection" class="badgeCollection"><a style="color: #16174f" href="{{route('otherBadge', ['username' => $user->username])}}">مدال های گردشگری</a> </li>
                @endif
                <li id="TravelMap" class="travelMap"><a style="color: #16174f">سفرنامه من</a> </li>
            </ul>
        </div>

        @yield('main')
        <script>

            $(document).ready(function() {

                $('#Settings').on({

                    mouseenter: function() {
                        $(".settingsDropDown").show();
                    },
                    mouseleave: function() {
                        $(".settingsDropDown").hide();
                    }
                });


                $('#nameTop').click(function(e) {

                    if( $("#profile-drop").is(":hidden")){
                        $("#profile-drop").show();
                        $("#my-trips-not").hide();
                        $("#alert").hide();
                        $("#bookmarkmenu").hide()

                    }else{
                        $("#profile-drop").hide();
                        $("#my-trips-not").hide();
                        $("#alert").hide();
                        $("#bookmarkmenu").hide()
                    }
                });
                $('#memberTop').click(function(e) {

                    if( $("#profile-drop").is(":hidden")){
                        $("#profile-drop").show();
                        $("#my-trips-not").hide();
                        $("#bookmarkmenu").hide();
                        $("#alert").hide();

                    }else{
                        $("#profile-drop").hide();
                        $("#my-trips-not").hide();
                        $("#bookmarkmenu").hide();
                        $("#alert").hide();
                    }
                });

                $('#bookmarkicon').click(function(e) {

                    if( $("#bookmarkmenu").is(":hidden")){
                        $("#bookmarkmenu").show();
                        $("#my-trips-not").hide();
                        $("#profile-drop").hide();
                        $("#alert").hide();

                    }else{
                        $("#bookmarkmenu").hide();
                        $("#my-trips-not").hide();
                        $("#profile-drop").hide();
                        $("#alert").hide();
                    }
                });


                $('.notification-bell').click(function(e) {

                    if( $("#alert").is(":hidden")){
                        $("#alert").show();
                        $("#my-trips-not").hide();
                        $("#profile-drop").hide();
                        $("#bookmarkmenu").hide()

                    }else{
                        $("#alert").hide();
                        $("#my-trips-not").hide();
                        $("#profile-drop").hide();
                        $("#bookmarkmenu").hide()
                    }
                });

                $('#close_span_search').click(function(e) {
                    $('#searchspan').animate({height: '0vh'});
                    $("#myCloseBtn").addClass('hidden');
                });

                $('#openSearch').click(function(e) {
                    $("#myCloseBtn").removeClass('hidden');
                    $('#searchspan').animate({height: '100vh'});
                });

            });

            function showRecentlyViews(element) {
                if( $("#my-trips-not").is(":hidden")){
                    $("#alert").hide();
                    $("#my-trips-not").show();
                    $("#profile-drop").hide();
                    $("#bookmarkmenu").hide();
                }else{
                    $("#alert").hide();
                    $("#my-trips-not").hide();
                    $("#profile-drop").hide();
                    $("#bookmarkmenu").hide();
                }
            }

            /*****************************************************/

            $('body').on("click", function () {

                $("#profile-drop").hide();
                $("#my-trips-not").hide();
                $("#alert").hide();
                $("#bookmarkmenu").hide();
            });
            $('.global-nav-actions').on("click", function (ev) {

                ev.stopPropagation();
            });


            var activitiesFetched = [];
            var filters = [[]];
            var contents = [[]];

            function sendAjaxRequestToGiveActivity(activityId, uId, kindPlaceId, menuId, contentId, page, limit) {

                $(".headerActivity").css('color', '#16174f');
                $("#headerActivity_" + activityId).css('color', 'var(--koochita-light-green)');

                $("#" + menuId).empty();

                var i;

                for(i = 0; i < activitiesFetched.length; i++) {
                    if (activitiesFetched[i] == activityId) {
                        createFilters(i, activityId, uId, kindPlaceId, menuId, limit);
                        createContentOfFilters(i, activityId, uId, kindPlaceId, menuId, contentId, page, limit);
                        return;
                    }
                }

                activitiesFetched[i] = activityId;
                createContentOfFilters(-1, activityId, uId, kindPlaceId, menuId, contentId, page, limit);

                $.ajax({
                    type: 'post',
                    url: getActivitiesNumPath,
                    data: {
                        activityId: activityId,
                        uId: uId
                    },
                    success: function (response2) {

                        filters[i] = JSON.parse(response2);
                        createFilters(i, activityId, uId, kindPlaceId, menuId, limit);
                    }
                });

                $.ajax({
                    type: 'post',
                    url: getActivitiesPath,
                    data: {
                        activityId : activityId,
                        uId : uId,
                        kindPlaceId : kindPlaceId,
                        page : page
                    },
                    success: function (response) {

                        if(response == "empty") {
                            contents[i] = [];
                        }
                        else
                            contents[i] = JSON.parse(response);

                        createContentOfFilters(i, activityId, uId, kindPlaceId, menuId, contentId, page, limit);
                    }
                });

            }

            function doFilterOnItems(kindPlaceId) {

                $(".subHeaderActivity").css('color', 'rgb(22, 23, 79)');
                $("#subHeaderActivity_" + kindPlaceId).css('color', 'rgb(77, 199, 188)');

                if(kindPlaceId == -1) {
                    $(".items").removeClass('hidden');
                    return;
                }

                $(".items").addClass('hidden');
                $(".kind_" + kindPlaceId).removeClass('hidden');

            }

            function createFilters(idx, activityId, uId, kindPlaceId, menuId, limit) {

                var i;
                var element;

                element = "<p>فیلترها :</p>";
                element += "<ul>";
                element += "<li class='subHeaderActivity' id='subHeaderActivity_-1' onclick='doFilterOnItems(-1)'>همه</li>";

                for(i = 0; i < filters[idx].length; i++) {
                    element += "<li class='subHeaderActivity' id='subHeaderActivity_" + filters[idx][i].placeId + "' onclick='doFilterOnItems(" + filters[idx][i].placeId + ")'>";
                    element += "<span>" + filters[idx][i].placeName  + "</span><span> ( </span>" + filters[idx][i].nums + "<span> ) </span>";
                    element += "</li>";
                }

                element += "</ul>";
                $("#" + menuId).append(element);
                $(".subHeaderActivity").css('color', '#16174f');

                $("#subHeaderActivity_" + kindPlaceId).css('color', 'var(--koochita-light-green)');
            }

            function createContentOfFilters(idx, activityId, uId, kindPlaceId, menuId, contentId, page, limit, filterId) {

                var i;
                var element2;

                $("#" + contentId).empty();

                if(idx > -1) {

                    for (i = 0; i < contents[idx].length; i++) {

                        element2 = "<div class='items kind_" + contents[idx][i].kindPlaceId + "'><div class='cs-header-ratings'>";
                        element2 += "<div class='cs-colheader-images'>عکس</div>";
                        element2 += "<div class='cs-colheader-date'>تاریخ</div>";
                        element2 += "<div class='cs-colheader-location'>نام</div>";
                        element2 += "<div class='cs-colheader-points'>خلاصه</div>";
                        element2 += "<div class='cs-colheader-rating'>امتیاز</div>";
                        element2 += "</div><ul><li class='cs-rating'>";
                        element2 += "<div class='cs-rating-thumb' style='z-index: 100'><a href='" + contents[idx][i].placeRedirect + "'><img src='" + contents[idx][i].placePic + "'></a></div>";
                        element2 += "<center class='cs-rating-date'>" + contents[idx][i].date + "</center>";
                        element2 += "<div class='cs-rating-geo'>" + contents[idx][i].visitorId + "</div>";

                        element2 += "<center>";
                        if (contents[idx][i].pic != "")
                            element2 += "<div class='cs-rating-location'><a><img style='width: 100%; vertical-align: middle' src='" + contents[idx][i].pic + "'></a></div>";
                        else
                            element2 += "<div class='cs-rating-location' style='text-align: center'><a>" + contents[idx][i].text + "</a></div>";
                        element2 += "</center>";

                        if (contents[idx][i].point != -1) {
                            element2 += "<div class='cs-rating'>";
                            if (contents[idx][i].point == 5)
                                element2 += "<span class='ui_bubble_rating bubble_5'></span>";
                            else if (contents[idx][i].point == 4)
                                element2 += "<span class='ui_bubble_rating bubble_4'></span>";
                            else if (contents[idx][i].point == 3)
                                element2 += "<span class='ui_bubble_rating bubble_3'></span>";
                            else if (contents[idx][i].point == 2)
                                element2 += "<span class='ui_bubble_rating bubble_2'></span>";
                            else
                                element2 += "<span class='ui_bubble_rating bubble_1'></span>";

                            element2 += "</div>";
                        }
                        else
                            element2 += "<div class='cs-rating'></div>";

                        element2 += "<div class='cs-rating-divider'></div>";
                        element2 += "</li></ul></div>";
                        $("#" + contentId).append(element2);
                    }

                    element2 = "<div class='cs-pagination-bar'>";
                    if (page > 1)
                        element2 += "<button onclick='sendAjaxRequestToGiveActivity(" + activityId + "," + uId + ", " + kindPlaceId + ", \"myActivities\", \"myActivitiesContent\", " + (page - 1) + ", " + limit + ")' id='cs-paginate-previous'>قبلی</button>";
                    if (page < Math.ceil(limit / 5))
                        element2 += "<button onclick='sendAjaxRequestToGiveActivity(" + activityId + "," + uId + ", " + kindPlaceId + ", \"myActivities\", \"myActivitiesContent\", " + (page + 1) + ", " + limit + ")' id='cs-paginate-next'>بعدی</button>";

                    element2 += "<div class='cs-pagination-bar-inner' style='direction: ltr'>";

                    for (i = 1; i <= Math.ceil(limit / 5); i++) {
                        if (i == page)
                            element2 += "<button style='cursor: pointer; color: black' onclick='sendAjaxRequestToGiveActivity(" + activityId + "," + uId + ", " + kindPlaceId + ", \"myActivities\", \"myActivitiesContent\", " + i + ", " + limit + ")' class='cs-paginate-goto active'>" + i + "</button>";
                        else
                            element2 += "<button style='cursor: pointer' onclick='sendAjaxRequestToGiveActivity(" + activityId + "," + uId + ", " + kindPlaceId + ", \"myActivities\", \"myActivitiesContent\", " + i + ", " + limit + ")' class='cs-paginate-goto active'>" + i + "</button>";
                    }

                    element2 += "</div></div>";
                }
                else
                    element2 = "<div style='margin-right: 40%' class='loader'></div>";

                $("#" + contentId).append(element2);
            }

        </script>

    </div>
</div>

@include('layouts.footer.layoutFooter')

</body>

</html>
