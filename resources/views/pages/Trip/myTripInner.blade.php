<?php $mode = "profile"; $user = Auth::user(); ?>

@extends('layouts.bodyProfile')

@section('header')
    @parent
    <title>کوچیتا | سفرهای من | {{$trip->name}}</title>

    <link rel="stylesheet" href="{{URL::asset('css/theme2/saves-rest-client.css?v='.$fileVersions)}}">
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/myTripsInner.css?v='.$fileVersions)}}'/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/abbreviations.css?v='.$fileVersions)}}'/>
    <link rel="stylesheet" href="{{URL::asset('css/theme2/bootstrap-datepicker.css?v=1')}}">

    <script defer src="{{URL::asset("js/bootstrap-datepicker.js")}}"></script>

    <style>
        .modalBody{
            border-radius: 10px;
        }
        .hoverChangeBack:hover{
            background: var(--koochita-light-green);
            border-radius: 30px;
        }
        .hoverChangeBack:hover .name{
            color: white !important;
        }
        .backToMyTrip{

        }
        .textRight{
            text-align: right !important;
        }
        @media (max-width: 767px) {
            .backToMyTrip{
                position: fixed !important;
                bottom: 85px;
                z-index: 99;
                opacity: .85;
                border-radius: 50px;
            }
        }
    </style>
@stop

@section('main')

    <div id="MAIN" class="Saves prodp13n_jfy_overflow_visible position-relative">
        <div id="BODYCON" class="col easyClear poolB adjust_padding new_meta_chevron_v2 position-relative">
            <div class="wrpHeader"></div>
            <div id="saves-body" class="styleguide position-relative">
                <div id="saves-root-view" class="position-relative">
                    <div class="position-relative">
                        <div id="saves-single-trip-container" class="position-relative">
                            <div id="trip-header-region" class="trip-header">
                                <div class="saves-title title has-text-centered position-relative">
                                    <div class="position-relative">
                                        <a  class="text-decoration-none saves-back-button ui_button secondary backToMyTrip" href="{{route('myTrips')}}">← بازگشت</a>
                                        <span class="trip-title">{{$trip->name}}</span>
                                        @if($trip->editTrip)
                                            <div id="targetHelp_6" class="targets">
                                                <span onclick="showEditTrip('{{$trip->from_}}', '{{$trip->to_}}')" class="ui_icon settings-fill mg-lt-0Imp"></span>

                                                <div id="helpSpan_6" class="helpSpans hidden row">
                                                    <span class="introjs-arrow"></span>
                                                    <p>در این قسمت می توانید تاریخ شروع و پایان سفرو نام سفر را ویرایش کنید. همچنین می توانید اقدام به حذف سفر اقدام کنید.</p>
                                                    <button data-val="6" class="btn btn-success nextBtnsHelp" id="nextBtnHelp_6">بعدی</button>
                                                    <button data-val="6" class="btn btn-primary backBtnsHelp" id="backBtnHelp_6">قبلی</button>
                                                    <button class="btn btn-danger exitBtnHelp">خروج</button>
                                                </div>
                                            </div>
                                        @endif
                                        @if($trip->status == 0)
                                            <div class="acceptRow">
                                                <div class="acceptBut" onclick="resultInvite(1)">من هستم</div>
                                                <div class="deleteBut" onclick="resultInvite(-1)">من نیستم</div>
                                            </div>
                                        @endif

                                        @if($trip->status == 1)
                                            @if(count($tripPlaces) == 0)
                                                <a class="cursor-pointer float-right link" onclick="initHelp(18, [1, 2, 3, 4, 5, 14, 15, 16, 17], 'MAIN', 100, 400)">
{{--                                                    <div class="helpBtnTimeChange"></div>--}}
                                                </a>
                                            @else
                                                @if($trip->editPlace)
                                                    <a class="cursor-pointer float-right link" onclick="initHelp(18, [1, 2, 3, 4, 5], 'MAIN', 100, 400)">
{{--                                                        <div class="helpBtnTimeChange"></div>--}}
                                                    </a>
                                                @else
                                                    <a class="cursor-pointer float-right link" onclick="initHelp(18, [1, 2, 3, 4, 5, 16], 'MAIN', 100, 400)">
{{--                                                        <div class="helpBtnTimeChange"></div>--}}
                                                    </a>
                                                @endif
                                            @endif
                                        @endif
                                    </div>
                                </div>

                                <div class="saves-header-buttons" style="width: 100%; display: flex; position: relative;">

                                   <div>
                                       @if($trip->editPlace)
                                           <div id="targetHelp_7" class="targets">
                                               <div onclick="openMyModal('addPlaceModal')" class="saves-invite-friends  saves-header-button">
                                                   <div class="ui_icon buildingIcon"></div>
                                                   افزودن محل
                                               </div>
                                               <div id="helpSpan_7" class="helpSpans hidden row">
                                                   <span class="introjs-arrow"></span>
                                                   <p>در این قسمت می توانید به صورت سریع اقدام به اضافه کردن مکان های جدید به لیست خود کنید.</p>
                                                   <button data-val="7" class="btn btn-success nextBtnsHelp" id="nextBtnHelp_7">بعدی</button>
                                                   <button data-val="7" class="btn btn-primary backBtnsHelp" id="backBtnHelp_7">قبلی</button>
                                                   <button class="btn btn-danger exitBtnHelp">خروج</button>
                                               </div>
                                           </div>
                                       @endif

                                       @if($trip->editTrip)
                                           <div id="targetHelp_9" class="targets">
                                               <div onclick="openMyModal('noteModal')" class="saves-invite-friends  saves-header-button">
                                                   <div class="ui_icon custom-note"></div>
                                                   یادداشت سفر
                                               </div>
                                               <div id="helpSpan_9" class="helpSpans hidden row">
                                                   <span class="introjs-arrow"></span>
                                                   <p>در این قسمت می توانید به کل سفر یادداشت اضافه کنید. این یادداشت با نام کاربری شما در بالای لیست نمایش داده می شود.</p>
                                                   <button data-val="9" class="btn btn-success nextBtnsHelp" id="nextBtnHelp_9">بعدی</button>
                                                   <button data-val="9" class="btn btn-primary backBtnsHelp" id="backBtnHelp_9">قبلی</button>
                                                   <button class="btn btn-danger exitBtnHelp">خروج</button>
                                               </div>
                                           </div>
                                       @endif

                                       <div id="targetHelp_10" class="targets" style="border-right: solid 1px #d8d8d8;">
                                           <div onclick="sortBaseOnPlaceDate('{{$sortMode}}')" class="saves-invite-friends  saves-header-button">
                                               <div class="ui_icon seat-regular"></div>
                                               مرتب سازی
                                           </div>
                                           <div id="helpSpan_10" class="helpSpans hidden row">
                                               <span class="introjs-arrow"></span>
                                               <p>شما می توانید به هر مکان موجود در لیست سفر تاریخی به عنوان تاریخ بازدید اضافه کید. این دکمه برای مدیریت نمایش مکان ها بر اساس تاریخ بازدید است.</p>
                                               <button data-val="10" class="btn btn-success nextBtnsHelp" id="nextBtnHelp_10">بعدی</button>
                                               <button data-val="10" class="btn btn-primary backBtnsHelp" id="backBtnHelp_10">قبلی</button>
                                               <button class="btn btn-danger exitBtnHelp">خروج</button>
                                           </div>
                                       </div>
                                   </div>

                                    <div>
                                        <div id="targetHelp_11" class="targets">
                                            <div onclick="showMembers()" class="saves-invite-friends  saves-header-button">
                                                <div class="ui_icon friend-fill"></div>
                                                اعضا
                                            </div>
                                            <div id="helpSpan_11" class="helpSpans hidden row">
                                                <span class="introjs-arrow"></span>
                                                <p>در این قسمت می توانید دوستانتان را که در این لیست عضو هستند مشاهده کنید. همچنین اگر ادمین سفرباشید (کسی که لیست را ایجاد کرده است.) می توانید به مدیریت دسترسی اعضا با فشردن دکمه جزئیات در زیر نام آن ها بپردازید. همچنین می توانید اعضا را حذف کنید.</p>
                                                <button data-val="11" class="btn btn-success nextBtnsHelp" id="nextBtnHelp_11">بعدی</button>
                                                <button data-val="11" class="btn btn-primary backBtnsHelp" id="backBtnHelp_11">قبلی</button>
                                                <button class="btn btn-danger exitBtnHelp">خروج</button>
                                            </div>
                                        </div>
                                        @if($trip->editMember)
                                            <div id="targetHelp_12" class="targets">
                                                <div  onclick="openMyModal('inviteMember')" class="saves-print saves-header-button">
                                                    <div class="ui_icon add-friend-fill"></div>
                                                    دعوت از دوستان
                                                </div>
                                                <div id="helpSpan_12" class="helpSpans hidden row">
                                                    <span class="introjs-arrow"></span>
                                                    <p>در این قسمت می توانید به سفر دوست جدیدی اضافه کنید. درخواست شما برای دوستتان فرستاده می شود تا در صورت تمایل عضو شود. توجه کنید این امکان برای ادمین و یا کسانی که ادمین به آن ها اجازه داده است میسر می شود.</p>
                                                    <button data-val="12" class="btn btn-success nextBtnsHelp" id="nextBtnHelp_12">بعدی</button>
                                                    <button data-val="12" class="btn btn-primary backBtnsHelp" id="backBtnHelp_12">قبلی</button>
                                                    <button class="btn btn-danger exitBtnHelp">خروج</button>
                                                </div>
                                            </div>
                                        @endif
                                        <div id="targetHelp_13" class="targets">
                                            <a target="_blank" href="{{route('trip.print', ['tripId' => $trip->id])}}" class="color-black saves-print saves-header-button">
                                                <div class="ui_icon printer"></div>
                                                <span>چاپ</span>
                                            </a>
                                            <div id="helpSpan_13" class="helpSpans hidden row">
                                                <span class="introjs-arrow"></span>
                                                <p>در این قسمت می توانید به سفر دوست جدیدی اضافه کنید. درخواست شما برای دوستتان فرستاده می شود تا در صورت تمایل عضو شود. توجه کنید این امکان برای ادمین و یا کسانی که ادمین به آن ها اجازه داده است میسر می شود.</p>
                                                <button data-val="13" class="btn btn-success nextBtnsHelp" id="nextBtnHelp_13">بعدی</button>
                                                <button data-val="13" class="btn btn-primary backBtnsHelp" id="backBtnHelp_13">قبلی</button>
                                                <button class="btn btn-danger exitBtnHelp">خروج</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div id="saves-body" class="styleguide position-relative">
                                <div id="saves-root-view" class="position-relative">
                                    <p id="tripNotePElement" style="display: {{isset($trip->note) ? '' : 'none'}}">{{$trip->note}}</p>
                                    @if($tripPlaces == null || count($tripPlaces) == 0)
                                        <div id="saves-itinerary-container">
                                            <div id="trip-dates-region" style="display: none;"></div>
                                            <div id="trip-side-by-side">
                                                <div class="ui_columns">
                                                    <div id="trip-items-region" class="ui_column " data-column-name="items">
                                                        <div id="trip-item-collection-container" data-bucket-id="unscheduled" class="drag_container">
                                                            <div class="no-saves-container">
                                                                <div class="no-saves-content content">
                                                                    <div class="ui_icon heart"></div>
                                                                    <div class="cta-header">هنوز چیزی ذخیره نشده است</div>
                                                                    <div class="cta-text"></div>
                                                                    <a onclick="openMyModal('addPlaceModal')" class="ui_button primary browse_ta">جستجو در کوچیتا</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div id="saves-all-trips" class="position-relative">
                                            <div id="saves-view-tabs-container" class=" position-relative">
                                                <div class="trips-container ui_container position-relative">
                                                    <div id="tripCardSection" class="trips-container-inner ui_columns is-multiline position-relative">
                                                        <?php $i = 0; ?>
                                                        @foreach($tripPlaces as $tripPlace)
                                                            <div id="place_{{$tripPlace->id}}" class="trip-tile-container ui_column is-3 position-relative placeCard">
                                                                <div class="trip-tile ui_card is-fullwidth position-relative" style="width: 100% !important;">
                                                                    <div class="header">
                                                                        <a href="{{$tripPlace->placeInfo->url}}" target="_blank" class="title lessShowText">{{$tripPlace->placeInfo->name}}</a>

                                                                        @if($trip->editPlace)
                                                                            @if($i == 0)
                                                                                <div id="targetHelp_16" class="targets">
                                                                                    <button data-toggle="tooltip" title="حذف مکان" onclick="deletePlace('{{$tripPlace->id}}')" class="ui_button removeBtnTargetHelp_16"></button>
                                                                                    <div id="helpSpan_16" class="helpSpans hidden row">
                                                                                        <span class="introjs-arrow"></span>
                                                                                        <p>با این دکمه مکان مورد نظر از لیست شما حذف می شود.</p>
                                                                                        <button data-val="16" class="btn btn-success nextBtnsHelp" id="nextBtnHelp_16">بعدی</button>
                                                                                        <button data-val="16" class="btn btn-primary backBtnsHelp" id="backBtnHelp_16">قبلی</button>
                                                                                        <button class="btn btn-danger exitBtnHelp">خروج</button>
                                                                                    </div>
                                                                                </div>
                                                                            @else
                                                                                <button data-toggle="tooltip"
                                                                                        title="حذف مکان"
                                                                                        onclick="deletePlace('{{$tripPlace->id}}')"
                                                                                        class="ui_button removeBtnTargetHelp_16"></button>
                                                                            @endif
                                                                        @endif
                                                                    </div>
                                                                    <div class="date">
                                                                        @if($tripPlace->date != "")
                                                                            <p onclick="assignDateToPlace('{{$tripPlace->id}}')">{{$tripPlace->date}}</p>
                                                                            @if($trip->editPlace)
                                                                                @if($i == 0)
                                                                                    <div id="targetHelp_15" class="targets">
                                                                                            <button data-toggle="tooltip" title="افزودن تاریخ به سفر" onclick="assignDateToPlace('{{$tripPlace->id}}')" class="pd-3-13 ui_button secondary trip-add-dates">
                                                                                                <span class="color-green ui_icon calendar textRight"></span>
                                                                                            </button>
                                                                                            <div id="helpSpan_15" class="helpSpans hidden row">
                                                                                                <span class="introjs-arrow"></span>
                                                                                                <p>برای برنامه ریزی دقیق تر می توانید به مکان ها تاریخی برای بازدید اختصاص دهید.</p>
                                                                                                <button data-val="15" class="btn btn-success nextBtnsHelp" id="nextBtnHelp_15">بعدی</button>
                                                                                                <button data-val="15" class="btn btn-primary backBtnsHelp" id="backBtnHelp_15">قبلی</button>
                                                                                                <button class="btn btn-danger exitBtnHelp">خروج</button>
                                                                                            </div>
                                                                                        </div>
                                                                                @else
                                                                                    <button data-toggle="tooltip" title="افزودن تاریخ به سفر" onclick="assignDateToPlace('{{$tripPlace->id}}')" class="pd-3-13 ui_button secondary trip-add-dates">
                                                                                        <span class="color-green ui_icon calendar textRight"></span>
                                                                                    </button>
                                                                                @endif
                                                                            @endif
                                                                        @elseif($trip->editPlace)
                                                                            <button class="chooseDate" onclick="assignDateToPlace('{{$tripPlace->id}}')">انتخاب تاریخ</button>
                                                                        @endif
                                                                        <div id="tripCommentNumber{{$tripPlace->id}}" class="tripCommentCount" style="display: {{count($tripPlace->comments) > 0 ? 'block' : 'none'}}">
                                                                            {{count($tripPlace->comments)}} یادداشت
                                                                        </div>
                                                                    </div>
                                                                    <div class="images">
                                                                        <img class="resizeImgClass"
                                                                             src="{{$tripPlace->placeInfo->pic}}"
                                                                            onload="fitThisImg(this)">
                                                                    </div>
                                                                    <div class="footerCard">

                                                                        @if($i == 0)
                                                                            <div id="targetHelp_17" class="showMoreInfoPlace targets trip-details ui_columns is-mobile is-fullwidth">
                                                                                    <button data-toggle="tooltip" title="نمایش جزئیات" class="btn btn-default showDetailsBtnTargetHelp_17" id="showPlaceInfo_{{$tripPlace->id}}" onclick="showPlaceInfo('{{$tripPlace->id}}', '{{floor($i / 4)}}')"></button>
                                                                                    <div id="helpSpan_17" class="helpSpans hidden row">
                                                                                        <span class="introjs-arrow"></span>
                                                                                        <p>می توانید جزئیات مکان را مشاهده کنید. همچنین در مورد مکان یادداشتی بنویسید مانند توضیحی که نمی خواهید فراموش کنید.</p>
                                                                                        <button data-val="17" class="btn btn-success nextBtnsHelp" id="nextBtnHelp_17">بعدی</button>
                                                                                        <button data-val="17" class="btn btn-primary backBtnsHelp" id="backBtnHelp_17">قبلی</button>
                                                                                        <button class="btn btn-danger exitBtnHelp">خروج</button>
                                                                                    </div>
                                                                                </div>
                                                                        @else
                                                                            <div class="showMoreInfoPlace targets trip-details ui_columns is-mobile is-fullwidth showDetailsBtnTargetHelp_17MainDiv">
                                                                                <button id="showPlaceInfo_{{$tripPlace->id}}"
                                                                                        data-toggle="tooltip"
                                                                                        title="نمایش جزئیات"
                                                                                        class="btn btn-default showDetailsBtnTargetHelp_17"
                                                                                        onclick="showPlaceInfo('{{$tripPlace->id}}', '{{$i}}')"></button>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php $i++; ?>
                                                        @endforeach
                                                        <div id="placeFullInfo">
                                                            <div class="trip-tile-container ui_column is-12 placeDetailsToggleBar showPlaceInfo">
                                                                <div class="tabSection hideOnPhone">
                                                                    <div class="active" onclick="choosePlaceInfoTab('info', this)">اطلاعات محل</div>
                                                                    <div onclick="choosePlaceInfoTab('comment', this)">یادداشت ها</div>
                                                                </div>
                                                                <div class="rightSec show">
                                                                    <div id="map_" class="mapSec"></div>
                                                                    <div class="placeInfo">
                                                                        <div class="img">
                                                                            <img  class="moreInfoPic" style="width: 100%">
                                                                        </div>
                                                                        <div class="info">
                                                                            <div class="name">
                                                                                <a href="#" target="_blank" class="placeName lessShowText"></a>
                                                                                <span class="city"></span>
                                                                            </div>
                                                                            <div class="rating">
                                                                                <span class="ui_bubble_rating bubble_00"></span>
                                                                                <span class="reviewCount"></span>
                                                                            </div>
                                                                            <div class="address"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="leftSec">
                                                                    <div class="header lessShowText">
                                                                        یادداشت های
                                                                        <span class="placeName"></span>
                                                                    </div>
                                                                    <div class="userComments"></div>

                                                                    <div class="yourComments">
                                                                        <input type="text" class="addCommentInput" placeholder="یادداشت خود را بنویسید...">
                                                                        <input type="hidden" class="placeSelectedId">
                                                                        <button class="sendButton sendIcon" onclick="addComment()"></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="notification-container"></div>
                </div>
            </div>
            <link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/saves-rest-client.css?v=1')}}' data-rup='saves-rest-client'/>
        </div>
    </div>

    @if($trip->editMember)
        <div id="inviteMember" class="modalBlackBack fullCenter followerModal" style="z-index: 9999;">
            <div class="modalBody" style="width: 400px; border-radius: 10px;">
                <div>
                    <div onclick="closeMyModal('inviteMember')" class="iconClose closeModal"></div>
                    <div style="color: var(--koochita-light-green); font-size: 25px; font-weight: bold;">از دوستان خود دعوت کنید</div>
                </div>
                @if(auth()->check())
                    <div class="searchSec">
                        <div class="inputSec">
                            <input type="text"
                                   id="myTripUserSearchInput"
                                   onfocus="openUserMyTripSearch(this.value)"
                                   onfocusout="closeUserMyTripSearch(this.value)"
                                   onkeyup="searchForUserMyTrip(this.value)"
                                   placeholder="دوستان خود را پیدا کنید...">
                            <div id="inviteMemberModalSearchButton" onclick="closeUserMyTripSearch(0)">
                                <span class="searchIcon"></span>
                                <span class="iconClose hidden" style="cursor: pointer"></span>
                            </div>
                        </div>
                    </div>
                @endif
                <div id="inviteMemberModalBody" class="body">
                    <div id="searchResultInviteMember" class="searchResult"></div>
                </div>
            </div>
        </div>
    @endif

    <div id="memberModal" class="modalBlackBack" style="z-index: 9999;">
        <div class="modalBody" style="width: 600px;">
            <div onclick="closeMyModal('memberModal')" class="iconClose closeModal"></div>

            <div class="find_location_modal">
                <div class="header_text membersPaneTitle">اعضای سفر</div>
                <div class="ui_typeahead memberList" id="members"></div>
            </div>
        </div>
    </div>

    <div id="memberSample" style="display: none">
        <div id="member_##id##" class="memberCard">
            <div class="cont">
                <a href="{{url('profile/index/')}}/##username##">
                    <div class="img">
                        <img src="##pic##" style="height: 100%;">
                        <div class="loading">در انتظار تایید</div>
                    </div>
                    <div class="name">##username##</div>
                </a>
                @if($trip->owner)
                    <div class="accessBut btn" onclick="showThisUserAccess(this)">
                        دسترسی ها
                    </div>
                @endif
                <div class="row">
                    <a href="{{route('profile.message.page')}}?user=##username##" class="msgBut btn">
                        ارسال پیام
                    </a>
                    @if($trip->editMember)
                        <div class="deleteBut btn" onclick="deleteMember(##uId##, '##username##')">
                            حذف کاربر
                        </div>
                    @endif
                </div>
            </div>
            @if($trip->owner)
                <div class="access hidden">
                    <div class="header">
                        دسترسی های کاربر
                    </div>
                    <div class="input">
                        <div class='ui_input_checkbox'>
                            <input id="canEditTrip_##id##" type="checkbox">
                            <label for="canEditTrip_##id##" class="labelForCheckBox">
                                <span style="margin-left: 5px !important;"></span>
                                ویرایش سفر
                            </label>
                        </div>
                        <div class='ui_input_checkbox'>
                            <input id="canEditMember_##id##" type="checkbox">
                            <label for="canEditMember_##id##" class="labelForCheckBox">
                                <span style="margin-left: 5px !important;"></span>
                                ویرایش اعضا
                            </label>
                        </div>
                        <div class='ui_input_checkbox'>
                            <input id="canEditPlace_##id##" type="checkbox">
                            <label for="canEditPlace_##id##" class="labelForCheckBox">
                                <span style="margin-left: 5px !important;"></span>
                                ویرایش اماکن
                            </label>
                        </div>
                    </div>

                    <div class="back" onclick="submitMemberAccess(this, ##id##)">
                        ثبت
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if($trip->editPlace)
        <div id="addPlaceModal" class="modalBlackBack" style="z-index: 9999;">
            <div class="modalBody">
                <div onclick="closeMyModal('addPlaceModal')" class="iconClose closeModal"></div>
                <div class="find_location_modal">
                    <div class="header_text addPlacePromptTitle">به سفر {{$trip->name}} اضافه کن</div>
                    <div class="trip-dates ui_columns">
                        <div class="ui_column">
                            <div id="date_btn_start_edit">نوع محل را مشخص کنید:</div>
                            <label>
                                <select id="kindPlaceInMyTrip"
                                        class="trip-title ui_input_text"
                                        onchange="$('#addPlaceToTripKindId').hide(); $('#placeSearchNameInAddTrip').val('')">
                                    <option value="boomgardies">بوم گردی</option>
                                    <option value="amaken">اماکن</option>
                                    <option value="restaurant">رستوران</option>
                                    <option value="hotels">هتل</option>
                                    <option value="majara">طبیعت گردی</option>
                                    <option value="sogatSanaies">صنایع دستی و سوغات</option>
                                    <option value="mahaliFood">غذا</option>
                                </select>
                            </label>
                        </div>
                        <div class="ui_column" style="position: relative;">
                            <div id="date_btn_end_edit">نام محل</div>
                            <label style="width: 100%">
                                <input type="text" id="placeSearchNameInAddTrip" class="form-control" onkeyup="searchForPlacesInMyTripInner(this.value)" style="width: 100%">
                            </label>
                            <div id="addPlaceToTripKindId" class="searchResultPlacess"></div>
                        </div>
                    </div>
                    <p id="placePromptError"></p>
                </div>
            </div>
        </div>

        <div id="addDateToPlaceModal" class="modalBlackBack fullCenter chooseDateForPlaceMyTrip" style="z-index: 9999;">
            <div class="modalBody" style="width: 600px;">
                <div onclick="closeMyModal('addDateToPlaceModal')" class="iconClose closeModal"></div>
                <div class="find_location_modal">
                    <div class="header_text addDateToPlaceTitle" style="margin: 0px !important;">اختصاص زمان به مکان</div>
                    <label class="tripCalenderSection">
                        <span class="calendarIcon"></span>
                        <input id="date_input" class="tripDateInput" placeholder="13xx/xx/xx" readonly type="text">
                    </label>
                    <div id="date_input_div" class="tripDateInput"></div>
                </div>
                <div class="submitOptions direction-rtl mg-tp-20">
                    <button id="submitInvite" class="btn successBtn" onclick="doAssignDateToPlace()">ثبت</button>
                    <button class="btn btn-default" onclick="closeMyModal('addDateToPlaceModal')">بستن</button>
                </div>
            </div>
        </div>
    @endif

    @if($trip->editTrip)
        <div id="noteModal" class="modalBlackBack fullCenter" style="z-index: 9999;">
            <div class="modalBody" style="width: 400px;">
                <div onclick="closeMyModal('noteModal')" class="iconClose closeModal"></div>
                <div class="find_location_modal">
                    <div class="header_text addNoteTitle">یادداشت سفر</div>
                    <div class="ui_typeahead">
                        <textarea id='tripNote' placeholder="شما می توانید برای سفر خود یادداشت بگذارید">{!! $trip->note !!}</textarea>
                    </div>
                </div>
                <br>
                <div class="submitOptions direction-rtl">
                    <button onclick="doAddNote()" class="btn successBtn">تایید</button>
                    <button onclick="closeMyModal('noteModal')" class="btn btn-default">خیر</button>
                </div>
            </div>
        </div>

        <div id="editTripModal" class="modalBlackBack fullCenter" style="z-index: 9999;">
            <div class="modalBody">
                <div onclick="closeMyModal('editTripModal')" class="iconClose closeModal"></div>
                <div class="header_text editTripPromptTitle">ویرایش سفر</div>
                <div class="body_text">
                    <div id="trip-title-input-region">
                        <div>
                            <label class="label">نام سفر</label>
                            <div class="control trip-title-control">
                                <input onkeyup="checkBtnDisable()" id="tripNameEdit" class="trip-title ui_input_text" type="text" maxlength="40" placeholder="حداکثر 40 کاراکتر" value="{{$trip->name}}">
                            </div>
                        </div>
                    </div>
                    <div class="trip-dates ui_columns">
                        <div class="ui_column">
                            <div id="date_btn_start_edit">تاریخ شروع</div>
                            <label id="date_btn_start_label">
                                <span class="ui_icon calendar textRight" id="date_btn_start"></span>
                                <input type="text" id="date_input_start_edit" placeholder="روز/ماه/سال" value="{{$trip->from_}}" readonly>
                            </label>
                        </div>
                        <div class="ui_column">
                            <div id="date_btn_end_edit">تاریخ اتمام</div>
                            <label id="date_btn_end_label">
                                <span class="ui_icon calendar textRight" id="date_btn_start"></span>
                                <input type="text" id="date_input_end_edit" placeholder="روز/ماه/سال" value="{{$trip->to_}}" readonly>
                            </label>
                        </div>
                    </div>

                    @if($trip->to_ != "" && $trip->from_ != "")
                        <div class="control clear-dates">
                            <div class='ui_input_checkbox'>
                                <input id="clearDateId" onclick="changeClearCheckBox('{{$trip->from_}}', '{{$trip->to_}}')" type="checkbox">
                                <label for="clearDateId" class="labelForCheckBox">
                                    <span style="margin-left: 5px !important;"></span>
                                    حذف تاریخ
                                </label>
                            </div>
                        </div>
                    @endif

                    <p class="color-red mg-10" style="font-size: 10px !important; line-height: 15px;">
                        توجه داشته باشید که با تغییر تاریخ سفر چنانچه مکانی از سفر شما تاریخی داشته باشد که در بازه ی جدید قرار نگیرد آن تاریخ پاک می شود
                    </p>

                    <div class="mg-tp-10">
                        <div id="error"></div>
                    </div>

                </div>
                <div class="submitOptions direction-rtl mg-tp-20">
                    <button onclick="editTrip()" id="editBtn" class="saves-settings-save ui_button first-button primary">ذخیره</button>
                    @if($trip->owner)
                        <button onclick="deleteTrip()" class="saves-settings-delete ui_button last-button danger">حذف سفر</button>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <script>
        var tripId = '{{$trip->id}}';
        var tripPlaces = '{{route('tripPlaces', ['tripId' => $trip->id])}}';
        var editTripDir = '{{route('trip.editTrip')}}';
        var changeDateTripDir = '{{route('trip.changeDateTrip')}}';
        var addCommentDir = '{{route('trip.addComment')}}';
        var assignDateToPlaceDir = '{{route('trip.assignDateToPlace')}}';
        var getPlaceTrips = '{{route('placeTrips')}}';


        var selectedPlaceId = -1;

        function changeClearCheckBox(from, to) {

            val = $("#clearDateId").is(":checked");

            if(val == true) {
                $("#date_input_start_edit").val("");
                $("#date_input_end_edit").val("");
            }
            else {
                $("#date_input_start_edit").val(from);
                $("#date_input_end_edit").val(to);
            }

            val = $("#clearDateId_2").is(":checked");
        }

        function checkBtnDisable() {

            if($("#tripNameEdit").val() == "")
                $("#editBtn").addClass("disabled");
            else
                $("#editBtn").removeClass("disabled");
        }

        function sortBaseOnPlaceDate(sortMode) {
            if(sortMode == "DESC")
                document.location.href = tripPlaces + "/ASC";
            else
                document.location.href = tripPlaces + "/DESC";
        }
    </script>

    <script>
        let tripInfo = {!! json_encode($trip) !!};
        let tripMember = {!! json_encode($trip->member) !!};
        let tripPlacesInfo = {!! json_encode($tripPlaces) !!};
        let deletedUserId = null;
        let deletedPlaceId = null;
        let getSuggestionPlaceAjaxMyTripInner = null;
        let searchResultPlacesMyTrip = [];
        let fullPlaceInfoHtml = '';
        let mapMarker = false;
        let map = false;

        let memberSample = $('#memberSample').html();
        $('#memberSample').html('');

        fullPlaceInfoHtml = $('#placeFullInfo').html();
        $('#placeFullInfo').remove('');

        function deleteTrip() {
            openWarning('آیا از پاک کردن سفر اطمینان دارید ؟', doDeleteTrip, 'بله پاک شود');
        }

        function doDeleteTrip() {
            $.ajax({
                type: 'post',
                url: '{{route('deleteTrip')}}',
                data: {
                    'tripId': tripId
                },
                success: function (response) {
                    if(response == "ok")
                        document.location.href = '{{route('myTrips')}}';
                }
            });
        }

        function doAddNote() {
            openLoading();
            $.ajax({
                type: 'post',
                url: '{{route('trip.addNote')}}',
                data: {
                    'tripId': tripId,
                    'note': $("#tripNote").val()
                },
                success: function (response) {
                    closeLoading();
                    if(response == "ok") {
                        closeMyModal('noteModal');
                        showSuccessNotifi('{{__('یادداشت شما برای سفر با موفقیت ثبت شد')}}', 'left', 'var(--koochita-blue)');
                        $("#tripNotePElement").empty().append(($("#tripNote").val()));
                        $('#tripNotePElement').show();
                    }
                    else
                        showSuccessNotifi('{{__('در ثبت یادداشت مشکلی پیش امده لطفا دوباره تلاش نمایید')}}', 'left', 'red');
                },
                error: function(err){
                    closeLoading();
                    showSuccessNotifi('{{__('در ثبت یادداشت مشکلی پیش امده لطفا دوباره تلاش نمایید')}}', 'left', 'red');
                }
            });
        }

        function searchForPlacesInMyTripInner(_text){
            if(getSuggestionPlaceAjaxMyTripInner != null)
                getSuggestionPlaceAjaxMyTripInner.abort();

            $('#searchResultPlacesInMyTripInner').html('');
            $('#searchResultPlacesInMyTripInner').hide();

            if(_text.trim().length > 1) {
                getSuggestionPlaceAjaxMyTripInner = $.ajax({
                    type: 'post',
                    url: '{{route("searchSuggestion")}}',
                    data: {
                        _token: '{{csrf_token()}}',
                        kindPlace: $('#kindPlaceInMyTrip').val(),
                        text: _text
                    },
                    success: function (response) {
                        response = JSON.parse(response);
                        if (response.status == 'ok') {
                            searchResultPlacessMyTrip = response.result;
                            createSearchResultInMyTripInner(searchResultPlacessMyTrip);
                        }
                    }
                })
            }
        }

        function createSearchResultInMyTripInner(_result){
            let text = '';
            _result.forEach((item, index) => {
                text += '<div onclick="chooseSearchMyTrip(' + index + ')">\n' +
                    '   <div>' + item.name + '</div>\n' +
                    '   <div style="color: #666666; font-size: 10px">' + item.state + '</div>\n' +
                    '</div>'
            });

            $('#addPlaceToTripKindId').html(text);
            $('#addPlaceToTripKindId').show();
        }

        function chooseSearchMyTrip(_index){

            let sug = searchResultPlacessMyTrip[_index];
            $('#searchResultPlacess').html('');
            $('#searchResultPlacess').hide();
            openLoading();
            $.ajax({
                type: 'post',
                url: '{{route("trip.addPlace")}}',
                data: {
                    _token: '{{csrf_token()}}',
                    tripId: tripId,
                    kindPlaceId: sug.kindPlaceId,
                    placeId: sug.placeId,
                },
                success: response => {
                    if(response.status == 'ok') {
                        showSuccessNotifi('{{__('محل مورد نظر به لیست سفر اضافه شد')}}', 'left', 'var(--koochita-blue)');
                        location.reload();
                    }
                    else{
                        var errorText = '';
                        closeLoading();
                        if(response.status == 'notAccess')
                            errorText = "{{__('شما دسترسی به تغییر محل های سفر ندارید.')}}";
                        else if(response.status == 'nok')
                            errorText = 'این محل در لیست سفر موجود می باشد';
                        else
                            errorText = '{{__('مشکلی در ثبت به وجود امده لطفا دوباره تلاش نمایید')}}';

                        showSuccessNotifi(errorText, 'left', 'red');
                    }
                },
                error: function(err){
                    closeLoading();
                    showSuccessNotifi('{{__('مشکلی در ثبت به وجود امده لطفا دوباره تلاش نمایید')}}', 'left', 'red');
                }
            })
        }

        function deletePlace(tripPlaceId) {
            deletedPlaceId = tripPlaceId;
            openWarning('آیا از پاک کردن محل از برنامه سفر خود اطمینان دارید ؟', doDeleteTripPlace, 'بله پاک شود');
        }

        function doDeleteTripPlace() {
            openLoading();
            $.ajax({
                type: 'post',
                url: '{{route('trip.deletePlace')}}',
                data: {
                    tripPlaceId: deletedPlaceId
                },
                success: function (response) {
                    closeLoading();
                    if(response.trim() == "ok"){
                        showSuccessNotifi('{{__('محل مورد نظر از لیست سفر حذف شد')}}', 'left', 'var(--koochita-blue)');
                        $('#place_' + deletedPlaceId).remove();
                    }
                    else
                        showSuccessNotifi('{{__('مشکلی در حذف محل پیش امده.')}}', 'left', 'red');
                },
                error: function(err){
                    closeLoading();
                    showSuccessNotifi('{{__('مشکلی در حذف محل پیش امده.')}}', 'left', 'red');
                }
            });
        }

        function assignDateToPlace(tripPlaceId) {
            selectedPlaceId = tripPlaceId;
            var calendarOption = {
                numberOfMonths: 1,
                showButtonPanel: true,
                dateFormat: "yy/mm/dd"
            }

            if(tripInfo.from_.length != 0)
                calendarOption.minDate = tripInfo.from_;
            if(tripInfo.to_.length != 0)
                calendarOption.maxDate = tripInfo.to_;

            $('#date_input').datepicker(calendarOption);
            // $('#date_input_div').datepicker(calendarOption);
            openMyModal('addDateToPlaceModal');
        }

        function doAssignDateToPlace() {
            openLoading();
            if($("#date_input").val() != "") {
                $.ajax({
                    type: 'post',
                    url: assignDateToPlaceDir,
                    data: {
                        'tripPlaceId': selectedPlaceId,
                        'date': $("#date_input").val()
                    },
                    success: function (response) {
                        if(response == "ok") {
                            showSuccessNotifi('{{__('تاریخ به محل مورد نظر از اضافه شد')}}', 'left', 'var(--koochita-blue)');
                            document.location.reload();
                        }
                        else{
                            closeLoading();
                            showSuccessNotifi('{{__('مشکلی در درخواست شما به وجود امده')}}', 'left', 'red');
                            $("#errorText").empty().append("تاریخ مورد نظر در بازه ی سفر قرار ندارد");
                        }
                    },
                    error: function(err){
                        closeLoading();
                        showSuccessNotifi('{{__('مشکلی در درخواست شما به وجود امده')}}', 'left', 'red');
                        console.log(err);
                    }
                });
            }
        }

        function showEditTrip(from, to) {

            $("#date_input_start_edit").datepicker({
                numberOfMonths: 1,
                showButtonPanel: true,
                dateFormat: "yy/mm/dd"
            });
            $("#date_input_end_edit").datepicker({
                numberOfMonths: 1,
                showButtonPanel: true,
                dateFormat: "yy/mm/dd"
            });

            $("#date_input_start_edit").val(from);
            $("#date_input_end_edit").val(to);
            $("#error").empty();
            openMyModal('editTripModal');
        }

        function editTrip() {

            date_input_start = $("#date_input_start_edit").val();
            date_input_end = $("#date_input_end_edit").val();
            tripName = $("#tripNameEdit").val();

            if( date_input_start != "" && date_input_end != "" && date_input_start > date_input_end ) {
                $("#error").empty();
                newElement = "<p class='color-red'>تاریخ پایان از تاریخ شروع باید بزرگ تر باشد</p>";
                $("#error").append(newElement);
                showSuccessNotifi('{{__('تاریخ پایان از تاریخ شروع باید بزرگ تر باشد')}}', 'left', 'red');
                return;
            }


            if(tripName.trim().length > 0) {
                openLoading();
                $.ajax({
                    type: 'post',
                    url: editTripDir,
                    data: {
                        'tripName': tripName,
                        'dateInputStart' : date_input_start,
                        'dateInputEnd' : date_input_end,
                        'tripId' : tripId
                    },
                    success: function (response) {
                        if(response == "ok") {
                            showSuccessNotifi('{{__('اطلاعات سفر شما با موفقیت تغییر یافت')}}', 'left', 'var(--koochita-blue)');
                            document.location.reload();
                        }
                        else {
                            closeLoading();
                            showSuccessNotifi('{{__('در ویرایش اطلاعات سفر مشکلی پیش امده')}}', 'left', 'red');
                        }
                    },
                    error: function(err){
                        closeLoading();
                        showSuccessNotifi('{{__('در ویرایش اطلاعات سفر مشکلی پیش امده')}}', 'left', 'red');
                    }
                });
            }
            else
                showSuccessNotifi('{{__('نام برنامه سفر نمی تواند خالی باشد')}}', 'left', 'red');

        }

        let openId = 0;
        function showPlaceInfo(_id, _index) {
            let selectedPlace = null;
            tripPlacesInfo.forEach(item => {
                if(item.id == _id)
                    selectedPlace = item;
            });

            $(".addCommentInput").val('');
            $(".placeSelectedId").val(0);
            $('.placeDetailsToggleBar').remove();
            $('.placeCard').removeClass('fullShow');


            if(selectedPlace != null && openId != _id){
                openId = _id;

                let width = $('#tripCardSection').width();
                let elemWidth = $('#place_' + _id).width() + (2 * parseFloat($('#place_' + _id).css('padding').split('px')[0]));
                let countInRow = Math.floor(width/elemWidth);

                let nextCount = (countInRow - 1) - (_index % countInRow);
                let showAfter = $("#place_" + _id);
                for(let i = 0; i < nextCount; i++) {
                    nextElemes = showAfter.next();
                    if(nextElemes.length == 0)
                        break;
                    showAfter = nextElemes
                }

                $(fullPlaceInfoHtml).insertAfter(showAfter[0]);

                $(".placeSelectedId").val(_id);

                $("#place_" + _id).addClass('fullShow');

                if(selectedPlace.placeInfo.x && selectedPlace.placeInfo.y) {
                    initMap(selectedPlace.placeInfo.x, selectedPlace.placeInfo.y);
                    setTimeout(function(){
                        mapMarker = new google.maps.Marker({
                            position: new google.maps.LatLng(selectedPlace.placeInfo.x, selectedPlace.placeInfo.y),
                            map: map,
                            title: selectedPlace.placeInfo.name
                        });
                    }, 200);
                }
                else
                    $('#map_').hide();

                $('.placeName').text(selectedPlace.placeInfo.name);
                $('.placeName').attr('href', selectedPlace.placeInfo.url);
                $('.moreInfoPic').attr('src', selectedPlace.placeInfo.pic);

                if(selectedPlace.placeInfo.address)
                    $('.address').text(selectedPlace.placeInfo.address);
                else if(selectedPlace.placeInfo.dastresi)
                    $('.address').text(selectedPlace.placeInfo.dastresi);

                $('.reviewCount').text(selectedPlace.placeInfo.review + ' نقد ');
                $('.rating').find('.ui_bubble_rating').addClass('bubble_' + selectedPlace.placeInfo.rate + '0');

                $('.rightSec').find('.city').text(selectedPlace.placeInfo.city + ' در ' + selectedPlace.placeInfo.state);

                if(selectedPlace.comments.length == 0)
                    $('.userComments').html('<div class="notRow"> برای این محل هیچ یادداشتی ثبت نشده است </div>');
                else
                    createCommentsHtml(selectedPlace);
            }
            else
                openId = 0;
        }

        function createCommentsHtml(_selectedPlace){
            $('.userComments').empty();
            _selectedPlace.comments.map(item => {
                let userRows =  '<div class="userRow">\n' +
                    '<div class="userInfo">\n' +
                    '   <div class="img">\n' +
                    '       <img src="' + item.userPic + '" style="width: 100%;">\n' +
                    '   </div>\n' +
                    '   <div class="name">' + item.username + '</div>\n' +
                    '   <div class="date">' + item.date + '</div>\n';

                if(item.yourComments == 1)
                    userRows += '<div class="ui_button removeBtnTargetHelp_16" onclick="deleteComment(' + item.id + ', ' + _selectedPlace.id + ')"></div>\n';

                userRows += '</div>\n' +
                    '<div class="text">' + item.description + '</div>\n' +
                    '</div>';

                $('.userComments').append(userRows)
            })
        }

        function addComment() {
            let inputs = $(".addCommentInput");
            let tripPlaceId = $(".placeSelectedId").val();
            let text = '';

            inputs.map(item => {
                if($(inputs[item]).val().trim() != '')
                    text = $(inputs[item]).val();
            });

            if(text.trim() != '' && tripPlaceId != 0){
                openLoading();
                $.ajax({
                    type: 'post',
                    url: addCommentDir,
                    data: {
                        tripPlaceId: tripPlaceId,
                        comment: text.trim()
                    },
                    success: function (response) {
                        closeLoading();
                        $(".addCommentInput").val('');
                        response = JSON.parse(response);
                        if(response.status == "ok"){
                            tripPlacesInfo.forEach(item => {
                                if(item.id == tripPlaceId){
                                    item.comments.unshift(response.result);
                                    createCommentsHtml(item);
                                    $('#tripCommentNumber'+tripPlaceId).show();
                                    $('#tripCommentNumber'+tripPlaceId).text(item.comments.length + ' یادداشت ');
                                }
                            });
                            showSuccessNotifi('{{__('یادداشت شما با موفقیت ثبت شد.')}}', 'left', 'var(--koochita-blue)');
                        }
                        else
                            showSuccessNotifi('{{__('در ثبت یادداشت مشکلی پیش امده لطفا دوباره تلاش نمایید')}}', 'left', 'red');
                    },
                    error: function(err){
                        closeLoading();
                        showSuccessNotifi('{{__('در ثبت یادداشت مشکلی پیش امده لطفا دوباره تلاش نمایید')}}', 'left', 'red');
                    }
                });
            }
        }

        function deleteComment(_id, _placeId){
            $.ajax({
                type: 'post',
                url: '{{route("trip.comment.delete")}}',
                data: {
                    _token: '{{csrf_token()}}',
                    id: _id
                },
                success: function(response){
                    if(response == 'ok') {
                        tripPlacesInfo.forEach(item => {
                            let index = -1;
                            if(item.id == _placeId){
                                item.comments.map((comment, _index) => {
                                    if(comment.id == _id)
                                        index = _index;
                                });
                                if(index != -1)
                                    item.comments.splice(index, 1);
                                createCommentsHtml(item);
                            }
                        });
                        showSuccessNotifi('{{__('یادداشت شما با موفقیت حذف شد')}}', 'left', 'var(--koochita-blue)');
                    }
                    else
                        showSuccessNotifi('{{__('در حذف یادداشت مشکلی پیش امده لطفا دوباره تلاش نمایید')}}', 'left', 'red');
                },
                error: function(err){
                    showSuccessNotifi('{{__('در حذف یادداشت مشکلی پیش امده لطفا دوباره تلاش نمایید')}}', 'left', 'red');
                }
            })
        }

        function initMap(x = '0', y = '0') {
            var mapOptions = {
                zoom: 14,
                center: new google.maps.LatLng(x, y), // New York
                styles: [
                    {
                        "featureType":"landscape",
                        "stylers":[
                            {"hue":"#FFA800"},
                            {"saturation":0},
                            {"lightness":0},
                            {"gamma":1}
                        ]}, {
                        "featureType":"road.highway",
                        "stylers":[
                            {"hue":"#53FF00"},
                            {"saturation":-73},
                            {"lightness":40},
                            {"gamma":1}
                        ]},	{
                        "featureType":"road.arterial",
                        "stylers":[
                            {"hue":"#FBFF00"},
                            {"saturation":0},
                            {"lightness":0},
                            {"gamma":1}
                        ]},	{
                        "featureType":"road.local",
                        "stylers":[
                            {"hue":"#00FFFD"},
                            {"saturation":0},
                            {"lightness":30},
                            {"gamma":1}
                        ]},	{
                        "featureType":"water",
                        "stylers":[
                            {"hue":"#00BFFF"},
                            {"saturation":6},
                            {"lightness":8},
                            {"gamma":1}
                        ]},	{
                        "featureType":"poi",
                        "stylers":[
                            {"hue":"#679714"},
                            {"saturation":33.4},
                            {"lightness":-25.4},
                            {"gamma":1}
                        ]}
                ]
            };
            var mapElement = document.getElementById('map_');
            map = new google.maps.Map(mapElement, mapOptions);
        }

        function choosePlaceInfoTab(_kind, _element){
            $('.tabSection').find('.active').removeClass('active');
            $(_element).addClass('active');
            $('.placeDetailsToggleBar').find('.rightSec').removeClass('show');
            $('.placeDetailsToggleBar').find('.leftSec').removeClass('show');

            if(_kind == 'info')
                $('.placeDetailsToggleBar').find('.rightSec').addClass('show');
            else
                $('.placeDetailsToggleBar').find('.leftSec').addClass('show');
        }

    </script>

    <script>
        function showMembers() {
            openMyModal('memberModal');
            if(tripMember.length == 0)
                $('#members').html('<button class="ui_icon add-friend-fill inviteFBut" onclick="closeMyModal(\'memberModal\'); openMyModal(\'inviteMember\')">دعوت از دوستان</button>');
            else{
                $('#members').empty();
                tripMember.map(item => {
                    var text = memberSample;
                    let obj = Object.keys(item);

                    for (var x of obj) {
                        var t = '##' + x + '##';
                        var re = new RegExp(t, "g");
                        text = text.replace(re, item[x]);
                    }
                    $('#members').append(text);

                    if(item.status == 1)
                        $('#member_' + item.id).find('.loading').remove();

                    if(item.editTrip == 1)
                        $('#canEditTrip_' + item.id).prop('checked', 'true');
                    if(item.editPlace == 1)
                        $('#canEditPlace_' + item.id).prop('checked', 'true');
                    if(item.editMember == 1)
                        $('#canEditMember_' + item.id).prop('checked', 'true');

                    if(item.owner == true){
                        $('#member_' + item.id).find('.accessBut').remove();
                        $('#member_' + item.id).find('.deleteBut').remove();
                    }

                })
            }
        }
        function showThisUserAccess(_element){
            let hasRot = $('.rotate180');
            let card = $(_element).parent().parent();
            card.addClass('rotate180');
            setTimeout(function(){
                card.addClass('accessType');
            }, 200);

            hasRot.removeClass('rotate180');
            setTimeout(function(){
                hasRot.removeClass('accessType');
            }, 200);
        }
        function submitMemberAccess(_element, _id){
            openLoading();

            let canEditPlace = $('#canEditPlace_' + _id).prop('checked');
            let canEditMember = $('#canEditMember_' + _id).prop('checked');
            let canEditTrip = $('#canEditTrip_' + _id).prop('checked');

            $.ajax({
                type: 'post',
                url: '{{route("trip.editUserAccess")}}',
                data: {
                    _token: '{{csrf_token()}}',
                    uId: _id,
                    tripId: {{$trip->id}},
                    editMember: canEditMember,
                    editTrip: canEditTrip,
                    editPlace: canEditPlace
                },
                success: function(response){
                    closeLoading();
                    response = JSON.parse(response);
                    if(response.status == 'ok'){
                        let hasRot = $('.rotate180');
                        hasRot.removeClass('rotate180');
                        setTimeout(function(){
                            hasRot.removeClass('accessType');
                        }, 200);

                        tripMember.map(item => {
                            if(item.id == _id){
                                item.editMember = response.result.editMember;
                                item.editTrip = response.result.editTrip;
                                item.editPlace = response.result.editPlace;
                            }
                        });
                        showSuccessNotifi('{{__('تغییر دسترسی با موفقیت اعمال شد')}}', 'left', 'var(--koochita-blue)');
                    }
                    else{
                        showSuccessNotifi('{{__('تغییر دسترسی با مشکل مواجه شد')}}', 'left', 'red');
                    }
                },
                error: function(err){
                    closeLoading();
                    showSuccessNotifi('{{__('تغییر دسترسی با مشکل مواجه شد')}}', 'left', 'red');
                }
            });

        }
        function deleteMember(_id, _username) {
            deletedUserId = _id;
            openWarning('آیا می خواهید ' + _username + ' را از سفر خود حذف کنید؟', doDeleteMember, 'بله حذف شود');
        }
        function doDeleteMember() {
            openLoading();
            $.ajax({
                type: 'post',
                url: '{{route('deleteMember')}}',
                data: {
                    'uId': deletedUserId,
                    'tripId': tripId
                },
                success: function (response) {
                    if(response == "ok") {
                        showSuccessNotifi('{{__('کاربر مورد نظر حذف شد')}}', 'left', 'var(--koochita-blue)');
                        document.location.reload();
                    }
                    else {
                        closeLoading();
                        showSuccessNotifi('{{__('در حذف کاربر مشکلی پیش امده')}}', 'left', 'red');
                    }
                },
                error: function(err){
                    closeLoading();
                    showSuccessNotifi('{{__('در حذف کاربر مشکلی پیش امده')}}', 'left', 'red');
                }

            });
        }
        function resultInvite(_kind){
            openLoading();
            $.ajax({
                type: 'post',
                url: '{{route("trip.invite.result")}}',
                data: {
                    _token: '{{csrf_token()}}',
                    kind: _kind,
                    tripId: tripId
                },
                success: function(response){
                    if(response == 'ok')
                        location.reload();
                    else {
                        closeLoading();
                        showSuccessNotifi('{{__('در ثبت درخواست مشکلی پیش امده')}}', 'left', 'red');
                    }
                },
                error: function(err){
                    closeLoading();
                    showSuccessNotifi('{{__('در ثبت درخواست مشکلی پیش امده')}}', 'left', 'red');
                }
            })
        }

        function openUserMyTripSearch(_value){
            var inviteBody = $('#inviteMemberModalBody');
            inviteBody.addClass('openSearch');
            inviteBody.children().addClass('hidden');
            inviteBody.find('searchResult').removeClass('hidden');

            $('#inviteMemberModalSearchButton').children().addClass('hidden');
            $('#inviteMemberModalSearchButton').find('.iconClose').removeClass('hidden');
        }

        function closeUserMyTripSearch(_value){
            if(_value == 0)
                $('#myTripUserSearchInput').val('');

            if(_value == 0 || _value.length == 0) {
                $('#inviteMemberModalBody').removeClass('openSearch');
                $('#inviteMemberModalSearchButton').children().addClass('hidden');
                $('#inviteMemberModalSearchButton').find('.searchIcon').removeClass('hidden');
                $('#searchResultInviteMember').addClass('hidden');
            }
        }

        function searchForUserMyTrip(_value){
            $("#searchResultInviteMember").empty();
            if(_value.trim().length > 1) {
                var userSearchPlaceHolder = `<div class="peopleRow placeHolder">
                                                   <div class="pic placeHolderAnime"></div>
                                                   <div class="name placeHolderAnime resultLineAnim"></div>
                                                   <div class="buttonP placeHolderAnime resultLineAnim"></div>
                                                </div>`;

                $("#searchResultInviteMember").html(userSearchPlaceHolder+userSearchPlaceHolder).removeClass('hidden');

                searchForUserCommon(_value)
                    .then(response => createInviteMemberSearchResult(response.userName))
                    .catch(err => console.error(err));
            }
        }

        function createInviteMemberSearchResult(_result){
            let text = '';
            if(_result.length == 0) {
                text =  `<div class="emptyPeople">
                               <img alt="noData" src="{{URL::asset('images/mainPics/noData.png')}}" >
                               <span class="text">هیچ کاربری ثبت نشده است</span>
                            </div>`;
            }
            else {
                _result.map(item => {
                    text += `<div class="peopleRow hoverChangeBack" onclick="chooseMemberForTrip(${item.id})" style="cursor: pointer;">
                                    <div class="pic">
                                        <img alt="کوچیتا، سامانه جامع گردشگری ایران" src="${item.pic}" class="resizeImgClass" style="width: 100%" onload="fitThisImg(this)">
                                    </div>
                                    <div class="name">${item.username}</div>
                                 </div>`;
                });
            }
            $(`#searchResultInviteMember`).html(text);
        }

        function chooseMemberForTrip(_userId){

            openLoading();
            $.ajax({
                type: 'POST',
                url: '{{route('trip.inviteFriend')}}',
                data: {
                    _token: '{{csrf_token()}}',
                    friendId : _userId,
                    tripId : tripId,
                    editTrip : 0,
                    editPlace : 0,
                    editMember : 0
                },
                success: response => {
                    closeLoading();
                    if(response.status == "ok") {
                        $('.choosenResult').addClass('hidden');
                        $('#inviteId').val(0);
                        $('#friendName').val('');
                        $('#submitInvite').prop('disabled', false);
                        $('#newCanEditTrip').prop('checked', false);
                        $('#newCanEditPlace').prop('checked', false);
                        $('#newCanEditMember').prop('checked', false);
                        tripMember = response.result;
                        showSuccessNotifi('{{__('دوست شما با موفقیت به سفر اضافه شد')}}', 'left', 'var(--koochita-blue)');
                        closeUserMyTripSearch(0);
                        closeMyModal('inviteMember');
                    }
                    else if(response.status == "nok" || response.status == "nullTrip")
                        showSuccessNotifi('{{__('در ثبت کاربر مشکلی پیش امده')}}', 'left', 'red');
                    else if(response.status == "notFindFriend")
                        showSuccessNotifi('{{__('کاربر مورد نظر یافت نشد')}}', 'left', 'red');
                    else if(response.status == "notAccess")
                        showSuccessNotifi('{{__('شما دسترسی به دعوت دیگران ندارید')}}', 'left', 'red');
                    else if(response.status == "nok1")
                        showSuccessNotifi('{{__('شما نمی توانید خود را دعوت کنید.')}}', 'left', 'red');
                    else if(response.status == "beforeRegistered")
                        showSuccessNotifi('{{__('کاربر مورد نظر عضو سفر می باشد')}}', 'left', 'red');
                    else
                        showSuccessNotifi('{{__('در ثبت کاربر مشکلی پیش امده')}}', 'left', 'red');
                },
                error: function(err){
                    showSuccessNotifi('{{__('در ثبت کاربر مشکلی پیش امده')}}', 'left', 'red');
                    closeLoading();
                }
            });
        }
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDpeBLW4SWeWuDKKAT0uF7bATx8T2rEiXE&callback=initMap"></script>
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
            newElement = "<div class='col-xs-12 position-relative'><div class='col-xs-12 bubbles pd-0 mg-rt-0' style='margin-left: " + ((400 - (t * 18)) / 2) + "px'>";

            for (i = 1; i < total; i++) {
                if(!isInFilters(i)) {
                    if(i == curr)
                        newElement += "<div class='isNotInFilterCurrent'></div>";
                    else
                        newElement += "<div class='isNotInFilter helpBubble' onclick='show(\"" + i + "\", 1)'></div>";
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

        $(document).ready(function () {
            checkBtnDisable();
        });
    </script>

@stop
