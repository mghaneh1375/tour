
@if(session('goDate') != null && $rooms != null)
    <div id="roomChoice" class="ppr_rup ppr_priv_location_detail_two_column display-block position-relative">

        <div class="column_wrap ui_columns is-mobile position-relative full-width direction-rtl">
            <div class="content_column ui_column is-10 roomBox_IS_10">
                <div class="ppr_rup ppr_priv_location_reviews_container position-relative">
                    <div id="rooms" class="ratings_and_types concepts_and_filters block_wrap position-relative">
                        <div class="header_group block_header" id="roomChoiceDiv">
                            <h3 class="tabs_header reviews_header block_title"> انتخاب اتاق </h3>
                            <div class="srchBox">
                                <button class="srchBtn" onclick="editSearch()">ویرایش جستجو</button>
                            </div>
                        </div>
                        @for($i = 0; $i < count($rooms); $i++)
                            <div class="eachRooms">
                                <div class="roomPic">
                                    <img src="{{$rooms[$i]->pic}}" width="100%" height="100%"
                                         alt='{{$rooms[$i]->name}}'>
                                </div>
                                <div class="roomDetails" id="roomDetailsMainDiv">
                                    <div>
                                        <div class="roomRow">
                                            <div class="roomName"
                                                 onclick="document.getElementById('room_info{{$i}}').style.display = 'flex'">
                                                {{$rooms[$i]->name}}
                                            </div>
                                            <div class="roomPerson">
                                                <div>
                                                    @for($j = 0; $j < ceil($rooms[$i]->capacity->adultCount/2); $j++)
                                                        <span class="shTIcon personIcon"></span>
                                                    @endfor
                                                </div>
                                                <div>
                                                    @for($j = 0; $j < floor($rooms[$i]->capacity->adultCount/2); $j++)
                                                        <span class="shTIcon personIcon"></span>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                        <div class="roomRow float-left">
                                            <div class="roomNumber">
                                                <div>
                                                    تعداد اتاق
                                                </div>
                                                <select name="room_Number" id="roomNumber{{$i}}"
                                                        onclick="changeNumRoom({{$i}}, this.value)">
                                                    @for($j = 0; $j < 11; $j++)
                                                        <option value="{{$j}}">{{$j}}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="roomRow">
                                            <div class="roomOptionTitle">امکانات اتاق</div>
                                        </div>
                                        <div class="roomRow">
                                            <div class="check-box__item hint-system hidden"
                                                 @if(!($rooms[$i]->priceExtraGuest != null && $rooms[$i]->priceExtraGuest != ''))style="display: none;" @endif>
                                                <label class="labelEdit">استفاده از تخت اضافه</label>
                                                <input type="checkbox" id="additional_bed{{$i}}"
                                                       name="additionalBed" value="1" class="display-inline-block"
                                                       onclick="changeRoomPrice({{$i}}); changeNumRoom({{$i}}, this.value)">
                                            </div>
                                        </div>
                                    </div>
                                    <div>

                                        <div class="roomRow">
                                            <div class="roomOption">{{$rooms[$i]->roomFacility}} </div>
                                        </div>
                                        <div class="roomRow">

                                            @if($rooms[$i]->priceExtraGuest != null && $rooms[$i]->priceExtraGuest != '')
                                                <div class="roomAdditionalOption">تخت اضافه</div>
                                            @endif
                                            <div class="roomAdditionalOption">{{$rooms[$i]->roomService}}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="roomPrices" id="roomPricesMainDiv">
                                    <div>قیمت</div>
                                    <div>
                                        <div>{{floor($rooms[$i]->perDay[0]->price/1000)*1000}}
                                            @if($rooms[$i]->priceExtraGuest != null && $rooms[$i]->priceExtraGuest != '')
                                                <div id="extraBedPrice{{$i}}" class="display-none extraBedPrices">
                                                    <div class="salePrice">
                                                        {{floor($rooms[$i]->priceExtraGuest/1000)*1000 + floor($rooms[$i]->perDay[0]->price/1000)*1000}}
                                                    </div>
                                                    <div>
                                                        <div>با احتساب {{floor($rooms[$i]->priceExtraGuest/1000)*1000}}</div>
                                                        <div>با تخت اضافه</div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        <div class="display-inline-block">
                                            از {{$rooms[$i]->provider}}</div>
                                        <img class="float-left">
                                    </div>
                                </div>
                            </div>
                            <div id="room_info{{$i}}" class="roomInfos">
                                <div class="container">
                                    <div class="row direction-rtl">
                                        <div class="col-md-8">
                                            <div class="roomRow">
                                                <div class="roomName">{{$rooms[$i]->name}}</div>
                                                <div class="shTIcon closeXicon float-left"
                                                     onclick="document.getElementById('room_info{{$i}}').style.display = 'none'">
                                                </div>
                                            </div>
                                            <div class="roomRow">
                                                <div class="roomOptionTitle">امکانات اتاق</div>
                                            </div>
                                            <div class="roomRow">
                                                <div class="roomOption">{{$rooms[$i]->roomFacility}} </div>
                                            </div>
                                            <div class="roomRow">
                                                <div class="roomOptionTitle">امکانات ویژه</div>
                                            </div>
                                            <div class="roomRow">
                                                @if($rooms[$i]->priceExtraGuest != null && $rooms[$i]->priceExtraGuest != '')
                                                    <div class="roomAdditionalOption">
                                                        تخت اضافه
                                                    </div>
                                                @endif
                                                <div class="roomAdditionalOption">{{$rooms[$i]->roomService}}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <img src="{{$rooms[$i]->pic}}" width="100%" height="100%" alt='{{$rooms[$i]->name}}'>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>

                </div>
            </div>

            <div class="is-2 roomBox_IS_2 full-width">
                <div class="priceRow_IS_2">
                    <div>قیمت کل برای یک شب</div>
                    <div id="totalPriceOneDay">0</div>
                </div>
                <div class="priceRow_IS_2">
                    <div>
                        <span class="lable_IS_2">قیمت کل </span>
                        برای
                        <span id="numDay"></span>
                        شب
                    </div>
                    <div id="totalPrice">0</div>
                </div>
                <div class="priceRow_IS_2">
                    <div>
                        <div class="lable_IS_2">تعداد اتاق</div>
                        <div class="float-left" id="totalNumRoom"></div>
                    </div>
                    <div id="discriptionNumRoom">
                    </div>
                </div>
                <div>
                    <button class="btn rezervedBtn" type="button" onclick="showReserve()">رزرو
                    </button>
                </div>
                <div>
                    <div>
                    <div>حداکثر سن کودک</div>
                    <div class="color-darkred">یک سال بدون اخذ هزینه</div>
                    </div>
                    <div>
                    <div>ساعت تحویل و تخلیه اتاق</div>
                    <div class="color-darkred">14:00</div>
                    </div>
                    <div>
                    <div>قوانین کنسلی</div>
                    <div class="color-darkred">لورم ییی</div>
                    </div>
                    {{$place->policy}}
                </div>
            </div>
        </div>
    </div>

    <div id="check_room">
    <div class="container">
        <div class="row">
            <span>
                شهر{{$city->name}}
            </span>
            <span>
                {{session('goDate')}}-{{session('backDate')}}
            </span>
            <span class="shTIcon closeXicon float-left"
                  onclick="document.getElementById('check_room').style.display = 'none';">
            </span>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="is-2 roomBox_IS_2">
                    <div class="priceRow_IS_2">
                        <div>
                            <span class="lable_IS_2">قیمت کل </span>
                            برای
                            <span id="check_num_day"></span>
                            شب
                        </div>
                        <div id="check_total_price">
                            0
                        </div>
                    </div>
                    <div class="priceRow_IS_2" >
                        <div>
                            <div class="float-left">
                                <span id="check_total_num_room"></span>
                                اتاق
                            </div>
                            <div class="lable_IS_2">تعداد اتاق</div>
                        </div>
                        <div id="check_description">
                        </div>
                    </div>
                    <div>
                        <span class="float-left">
                            {{$rooms[0]->provider}}
                        </span>
                        <a href="{{url('buyHotel')}}">
                        <button class="btn rezervedBtn" type="button" onclick="updateSession()">
                            تایید و ادامه
                        </button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div>هتل انتخابی شما</div>
                    <div>
                        <div class="col-md-7">
                            <span class="imgWrap imgWrap1stTemp">
                                <img alt="{{$place->alt1}}" src="{{$thumbnail}}" class="centeredImg" width="100%"/>
                            </span>
                        </div>
                        <div class="col-md-5">
                            <div>{{$place->name}}</div>
                            <div class="rating_and_popularity" id="hotelRatingMainDivRoomChoice">
                                <span class="header_rating">
                                    <div class="rs rating" rel="v:rating">
                                        <div class="prw_rup prw_common_bubble_rating overallBubbleRating float-left">
                                            @if($avgRate == 5)
                                               <span class="ui_bubble_rating bubble_50 font-size-16"
                                                     property="ratingValue" content="5"
                                                     alt='5 of 5 bubbles'></span>
                                           @elseif($avgRate == 4)
                                               <span class="ui_bubble_rating bubble_40 font-size-16"
                                                     property="ratingValue" content="4"
                                                     alt='4 of 5 bubbles'></span>
                                           @elseif($avgRate == 3)
                                               <span class="ui_bubble_rating bubble_30 font-size-16"
                                                     property="ratingValue" content="3"
                                                     alt='3 of 5 bubbles'></span>
                                           @elseif($avgRate == 2)
                                               <span class="ui_bubble_rating bubble_20 font-size-16"
                                                     property="ratingValue" content="2"
                                                     alt='2 of 5 bubbles'></span>
                                           @elseif($avgRate == 1)
                                               <span class="ui_bubble_rating bubble_10 font-size-16"
                                                     property="ratingValue" content="1"
                                                     alt='1 of 5 bubbles'></span>
                                           @endif
                                        </div>
                                   </div>
                                </span>
                                <span class="header_popularity popIndexValidation">
                                    <a class="more taLnk" href="#REVIEWS">
                                        <span property="v:count" id="commentCount"></span> نقد
                                    </a>
                                    <a> {{$total}} امتیاز</a>
                                </span>
                            </div>
                            <div id="hotelRatesDivs">
                                <div class="titleInTable">درجه هتل</div>
                                <div class="highlightedAmenity detailListItem">{{$place->rate}}</div>
                            </div>
                            <div class="blEntry blEn address  clickable colCnt3"
                                 onclick="showExtendedMap()">
                                <span class="ui_icon map-pin"></span>
                                <span class="street-address">آدرس : </span>
                                <span>{{$place->address}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="selectedRoomMainDiv">
                    <div>اتاق های انتخابی شما</div>
                    <div id="selected_rooms"></div>
                    <div>
                        <div class="row">
                            <div class="col-md-12">
                                {{$place->policy}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>
@endif