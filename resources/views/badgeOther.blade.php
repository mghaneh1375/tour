<?php $mode = "badge"; ?>

@extends('layouts.bodyProfileOther')

@section('header')
    @parent

    <script>

        function showElements(id) {
            $("#" + id).css("visibility", "visible");
        }

        function hideElement(id) {
            $("#" + id).css("visibility", "hidden");
        }
    </script>

@stop

@section('main')
    <div id="MAIN" class="MemberProfile
           prodp13n_jfy_overflow_visible
           ">
        <div id="BODYCON" class="col easyClear poolX adjust_padding new_meta_chevron_v2">
            <div class="wrpHeader">
            </div>
            <div class="mc-badge-collection-container">
                <h1 class="heading wrap">
                    <div class="modules-membercenter-badge-collection-header " data-backbone-name="modules.membercenter.BadgeCollectionHeader" data-backbone-context="Achievements_Badges, Social_CompositeMember, Member">
                        <div class="header"><span></span>مدال های من</div>
                        <div class="sub-header">نمی شود از مدال های زیر چشم پوشی کرد. پس حتما امتیازات مورد نیاز را کسب کنید تا یک گردشگر پر افتخار باشید.</div>
                    </div>
                </h1>
                <div class="modules-membercenter-badge-collection " data-backbone-name="modules.membercenter.BadgeCollection" data-backbone-context="Achievements_Badges, Social_CompositeMember, LoggedInMember, Achievements_BadgeFlyoutView, Member, features">
                    <ul data-list="earnedBadges">

                    </ul>

                    <script>
                        function hideAllBadges() {
                            $(".badgeContainer").css("visibility", "hidden");
                        }
                    </script>

                    <ul data-list="nextBadges">
                        @foreach($badges as $badge)
                            <li onclick="hideAllBadges(); showElements('badge_' + this.id)" id="{{$badge->id}}" class="memberBadges border">
                                <div class="badgeInfo">
                                    @if(!$badge->status)
                                        <div class="badgeIcon sprite-badge_large_grey_rev_01" style="background: url('{{URL::asset('_images/badges' . '/' . $badge->pic_1)}}'); background-size: 100%; width: 100px; height: 100px;">
                                        </div>
                                    @else
                                        <div class="badgeIcon sprite-badge_large_grey_rev_01" style="background: url('{{URL::asset('_images/badges' . '/' . $badge->pic_2)}}'); background-size: 100%; width: 100px; height: 100px;">
                                        </div>
                                    @endif
                                    <div class="badgeText">{{$badge->name}}</div>
                                    <span class="subText">{{$badge->floor}}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <?php $i = 0; ?>

                @foreach($badges as $badge)

                    <?php
                    $marginLeft = 60;
                    if($i % 3 == 0)
                        $marginLeft = 660;
                    else if($i % 3 == 1)
                        $marginLeft = 360;

                    $marginTop = 250 + 300 * floor($i / 3);
                    $i++;
                    ?>

                    <span id="badge_{{$badge->id}}" class="ui_overlay ui_popover arrow_right badgeDesc badgeContainer" style="position: absolute; left: {{$marginLeft}}px; right: auto; top: {{$marginTop}}px; bottom: auto; visibility: hidden">
                        <div class="arrow"></div>
                        <div class="header_text">
                            <div class="text">{{$badge->activityId}}</div>
                        </div>
                        <div class="body_text">
                            <div class="body_text">
                                <div class="desc">
                                     این مدال بعد از{{$badge->floor}}  {{$badge->activityId}} بدست می آید
                                </div>
                                <div class="descLineTwo">
                                </div>
                                <a class="action" href="" target="_blank">اضافه کردن {{$badge->activityId}}</a>
                            </div>
                        </div>
                        <div class="ui_close_x" onclick="hideElement('badge_{{$badge->id}}')"></div>
                    </span>
                @endforeach



                <div class="modules-membercenter-badge-flyout " data-backbone-name="modules.membercenter.BadgeFlyout" data-backbone-context="Achievements_Badges, Achievements_BadgeFlyoutView, Member">
                    <div class="hidden">
                    <!-- @oxEach name="eachEarnedBadge" context="badgeFlyout in Achievements_Badges.data.earnedBadgeFlyouts" -->
                        <!-- /oxEach -->
                    <!-- @oxEach name="eachNextBadge" context="badgeFlyout in Achievements_Badges.data.nextBadgeFlyouts" -->
                        <div data-badge-id="32_ReviewerBadge">
                            <div class="badgeContents">
                                <div class="text">New Reviewer</div>
                                <div class="body_text">
                                    <div class="desc">This badge is earned after 1 review.</div>
                                    <div class="descLineTwo">With 0 reviews, you&#39;re 1 review away from this badge.</div>
                                    <a class="action" href="" target="_blank">Write a Review</a>
                                </div>
                            </div>
                        </div>


                        <!-- /oxEach -->
                    </div>
                </div>
            </div>

        </div>
    </div>
@stop