<?php $mode = "profile"; $user = Auth::user(); ?>

@extends('layouts.bodyProfile')

@section('header')
    @parent
    <title>کوچیتا | سفرهای من | {{$trip->name}}</title>

    <link rel="stylesheet" href="{{URL::asset('css/theme2/saves-rest-client.css?v='.$fileVersions)}}">
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/myTripsInner.css?v='.$fileVersions)}}'/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/abbreviations.css?v='.$fileVersions)}}'/>
    <link rel="stylesheet" href="{{URL::asset('css/theme2/bootstrap-datepicker.css?v=1')}}">
    <link rel="stylesheet" href="{{URL::asset('packages/leaflet/leaflet.css')}}">

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

                    <p class="color-red mg-10" style="font-size: 10px !important; line-height: 15px;"> توجه داشته باشید که با تغییر تاریخ سفر چنانچه مکانی از سفر شما تاریخی داشته باشد که در بازه ی جدید قرار نگیرد آن تاریخ پاک می شود</p>

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
        var getPlaceTrips = '{{route('placeTrips')}}';
        var myTripUrlInInner = '{{route('myTrips')}}';
        var editTripDir = '{{route('trip.editTrip')}}';
        var addCommentDir = '{{route('trip.addComment')}}';
        var deleteTripInnerUrl = '{{route('deleteTrip')}}';
        var addNoteUrlInInner = '{{route('trip.addNote')}}';
        var addPlaceInInnerUrl = '{{route("trip.addPlace")}}';
        var changeDateTripDir = '{{route('trip.changeDateTrip')}}';
        var deletePlaceInInnerUrl = '{{route('trip.deletePlace')}}';
        var deleteMemberFromTripInInnerUrl = '{{route('deleteMember')}}';
        var assignDateToPlaceDir = '{{route('trip.assignDateToPlace')}}';
        var searchSuggestionInInnerUrl = '{{route("searchSuggestion")}}';
        var InviteMemberTripInInnerUrl = '{{route('trip.inviteFriend')}}';
        var InviteResultTripInInnerUrl = '{{route("trip.invite.result")}}';
        var tripPlaces = '{{route('tripPlaces', ['tripId' => $trip->id])}}';
        var deleteCommentTripInInnerUrl = '{{route("trip.comment.delete")}}';
        var editUserAccessTripInInnerUrl = '{{route("trip.editUserAccess")}}';

        var notDataPicInInnerUrl = "{{URL::asset('images/mainPics/noData.png')}}";

        var tripInfo = {!! json_encode($trip) !!};
        var tripMember = {!! json_encode($trip->member) !!};
        var tripPlacesInfo = {!! json_encode($tripPlaces) !!};
    </script>

    <script defer type="text/javascript" src="{{URL::asset('packages/leaflet/leaflet.js')}}"></script>
    <script defer type="text/javascript" src="{{URL::asset('packages/leaflet/leaflet-wms-header.js')}}"></script>

    <script src="{{URL::asset('js/pages/trips/myTripInner.js?v='.$fileVersions)}}"></script>

    {{--    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDpeBLW4SWeWuDKKAT0uF7bATx8T2rEiXE&callback=initMap"></script>--}}

@stop
