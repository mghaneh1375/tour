<?php $mode = "badge"; $user = Auth::user(); ?>

@extends('layouts.bodyProfile')

@section('header')
    @parent
@stop

@section('main')



    <div id="MAIN" class="MemberProfile prodp13n_jfy_overflow_visible badgesPageMainDiv">
        <div id="BODYCON" class="col easyClear poolX adjust_padding new_meta_chevron_v2">
            <div class="wrpHeader">
            </div>
            <div class="mc-badge-collection-container">
                <h1 class="heading wrap">
                    <div class="modules-membercenter-badge-collection-header " data-backbone-name="modules.membercenter.BadgeCollectionHeader"
                         data-backbone-context="Achievements_Badges, Social_CompositeMember, Member">
                        <div class="header">
                            <span></span>مدال‌های من
                        </div>
                        <div class="sub-header">نمی‌شود از مدال‌های زیر چشم‌پوشی کرد. پس حتماً امتیازات مورد نیاز را کسب کنید تا یک گردشگر پرافتخار باشید.</div>
                    </div>
                </h1>
                <center class="modules-membercenter-badge-collection " data-backbone-name="modules.membercenter.BadgeCollection"
                     data-backbone-context="Achievements_Badges, Social_CompositeMember, LoggedInMember, Achievements_BadgeFlyoutView, Member, features">
                    <ul data-list="earnedBadges">

                    </ul>



                    <ul data-list="nextBadges" class="badgeListBadgePage">
                        @foreach($badges as $badge)
                            <li id="{{$badge->id}}" onclick="hideAllBadges(); showElements('badge_' + this.id)" class="memberBadges border">
                                <div class="badgeInfo">
                                    @if(!$badge->status)
                                        <div class="badgeIcon sprite-badge_large_grey_rev_01" style="background: url('{{URL::asset('_images/badges' . '/' . $badge->pic_1)}}'); background-size:100%; width: 100px; height: 100px;"></div>
                                    @else
                                        <div class="badgeIcon sprite-badge_large_grey_rev_01" style="background: url('{{URL::asset('_images/badges' . '/' . $badge->pic_2)}}'); background-size:100%; width: 100px; height: 100px;">
                                        </div>
                                    @endif
                                    <div class="badgeText">{{$badge->name}}</div>
                                    <span class="subText">{{$badge->floor}}</span>

                                    <span id="badge_{{$badge->id}}" class="ui_overlay ui_popover arrow_right badgeDesc badgeContainer badgesPage">
{{--                                          style="left: {{$marginLeft}}px; top: {{$marginTop}}px;"--}}

                {{--                        <div class="arrow"></div>--}}
                                        <div class="header_text">
                                            <div class="text">{{$badge->activityId}}</div>
                                        </div>
                                        <div class="body_text">
                                            <div class="body_text">
                                                <div>
                                                    @if($badge->kindPlaceId != -1)
                                                        <p>
                                                            <span>
                                                                 این مدال بعد از
                                                                {{$badge->floor}} {{$badge->activityId}} در {{$badge->kindPlaceId}} بدست می‌آید
                                                            </span>
{{--                                                            <span></span>--}}
{{--                                                            <span>&nbsp;</span>--}}
{{--                                                            <span>&nbsp;</span>--}}
{{--                                                            <span></span>--}}
{{--                                                            <span>&nbsp;&nbsp;</span>--}}
{{--                                                            <span></span>--}}
{{--                                                            <span>&nbsp;</span>--}}
{{--                                                            <span></span>--}}
                                                        </p>
                                                    @else
                                                        <p>
                                                            <span>این مدال بعد از&nbsp;</span>
                                                            <span>{{$badge->floor}}</span>
{{--                                                            <span>&nbsp;</span>--}}
{{--                                                            <span>&nbsp;</span>--}}
                                                            <span>{{$badge->activityId}}</span>
{{--                                                            <span>&nbsp;</span>--}}
                                                            <span>بدست می‌آید</span></p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ui_close_x" onclick="hideElements('badge_{{$badge->id}}',event)"></div>
                                    </span>

                                </div>
                            </li>
                        @endforeach
                    </ul>
                </center>

                <?php $i = 0; ?>

                @foreach($badges as $badge)

                    <?php
                    $marginLeft = 60;
                    if($i % 3 == 0)
                        $marginLeft = 400;
                    else if($i % 3 == 1)
                        $marginLeft = 85;

                    $marginTop = 320 + 320 * floor($i / 3);
                    $i++;
                    ?>

                @endforeach
            </div>

        </div>
        <script>
            function hideAllBadges() {
              $(".badgeContainer").css("visibility", "hidden");

            }
        </script>
        <script>

            function showElements(id) {
                $("#" + id).css("visibility", "visible");
            }

            function hideElements(id,event) {
                $("#" + id).css("visibility", "hidden");
                event.stopPropagation();
            }
        </script>
    </div>
@stop