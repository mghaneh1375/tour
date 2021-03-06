{{--<div class="descriptionSections">--}}

{{--    <div class="row">--}}
{{--        <div class="col-xs-6" style="float: right">--}}
{{--            <div class="titleSection">--}}
{{--                <div class="titlesPlaceDetail">--}}
{{--                    <span class="titleSectionSpan">--}}
{{--                        نوع غذا--}}
{{--                    </span>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="contentSection">{{$place->kindName}}</div>--}}
{{--        </div>--}}
{{--        <div class="col-xs-6" style="float: right">--}}
{{--            <div class="titleSection">--}}
{{--                <div class="titlesPlaceDetail">--}}
{{--                    <span class="titleSectionSpan">--}}
{{--                        نوع سرو--}}
{{--                    </span>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="contentSection">{{$place->hotOrCold}}</div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="titleSection">--}}
{{--        <div class="titlesPlaceDetail">--}}
{{--            <span class="titleSectionSpan">--}}
{{--                مناسب برای--}}
{{--            </span>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="contentSection col-xs-12">افراد گیاه خوار--}}
{{--        <span style=" color: {{$place->vegetarian == 1 ? 'green' : 'red'}};">--}}
{{--        {{$place->vegetarian == 1 ? 'هست' : 'نیست'}}--}}
{{--    </span>--}}
{{--    </div>--}}
{{--    <div class="contentSection col-xs-12">افراد وگان--}}
{{--        <span style=" color: {{$place->vegan == 1 ? 'green' : 'red'}};">--}}
{{--        {{$place->vegan == 1 ? 'هست' : 'نیست'}}--}}
{{--    </span>--}}
{{--    </div>--}}
{{--    <div class="contentSection col-xs-12">افراد دیابتی--}}
{{--        <span style=" color: {{$place->diabet == 1 ? 'green' : 'red'}};">--}}
{{--            {{$place->diabet == 1 ? 'هست' : 'نیست'}}--}}
{{--        </span>--}}
{{--    </div>--}}

{{--    <div class="titleSection">--}}
{{--        <div class="titlesPlaceDetail">--}}
{{--            <span class="titleSectionSpan">--}}
{{--                کالری--}}
{{--            </span>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="contentSection col-xs-12">--}}
{{--        <span style="float: right"> : {{$place->name}} </span>--}}
{{--        <span style="float: right"> {{$place->energy}} </span>--}}
{{--        <span style="float: right"> کالری در هر</span>--}}
{{--        <span style="float: right"> {{$place->volume}} </span>--}}
{{--        <span style="float: right"> {{$place->source}} </span>--}}
{{--    </div>--}}
{{--    @if($place->rice == 1)--}}
{{--        <div class="contentSection col-xs-12">--}}
{{--            برنج: 20 کالری در 1 قاشق غذاخوری--}}
{{--        </div>--}}
{{--    @endif--}}
{{--    @if($place->bread == 1)--}}
{{--            <div class="contentSection col-xs-12">--}}
{{--                نان: 40 کالری به اندازه ی هر کف دست--}}
{{--            </div>--}}
{{--        @endif--}}

{{--</div>--}}


<div class="ui_columns is-multiline is-mobile reviewsAndDetails direction-rtlImp">
    <div id="generalDescriptionMobile" class="ui_column is-8 generalDescription tabContent">

        <div class="block_header">
            <div class="titlesPlaceDetail">
                <h3 class="block_title">مواد لازم</h3>
            </div>
        </div>

        <div class="row materSection">
            @if(isset($place->material))
                <div class="col-sm-6">
                    @foreach($place->material as $key => $item)
                        @if($key%2 == 0)
                            <div class="row font-size-20 materialRows">
                                <div class="col-sm-6 col-xs-12 float-right materialName">{{$item->name}}</div>
                                <div class="col-sm-6 col-xs-12 color-green materialVolume">{{$item->volume}}</div>
                            </div>
                            <hr>
                        @endif
                    @endforeach
                </div>
                <div class="col-sm-6" style="border-left: 1px solid #eee;">
                    @foreach($place->material as $key => $item)
                        @if($key%2 != 0)
                            <div class="row font-size-20 materialRows">
                                <div class="col-sm-6 col-xs-12 float-right materialName">{{$item->name}}</div>
                                <div class="col-sm-6 col-xs-12 color-green materialVolume">{{$item->volume}}</div>
                            </div>
                            <hr>
                        @endif
                    @endforeach
                </div>
            @endif

            <div class="hideOnScreen" style="display: flex; justify-content: space-between; margin-top: 14px; text-align: center;">
                <div class="foodKindMob" style="box-shadow: -2px 2px 4px 0px #333;">
                    <div class="title">نوع غذا</div>
                    <div class="val">{{$place->kindName}}</div>
                </div>
                <div class="foodKindMob">
                    <div class="title">نوع سرو</div>
                    <div class="val">{{$place->hotOrCold}}</div>
                </div>
            </div>
        </div>

    </div>

    <div class="seperatorSections"></div>

    <div id="detailsAndFeaturesMobile" class="ui_column is-4 details tabContent mahaliFoodSeperator topAndBottomBorderAndMargin {{$mainInfoClass}} hideOnPhone">
        <div class="direction-rtl featureOfPlaceMiddleContent row " style="margin: 0px">
            <div class="descriptionSections">

                <div class="row">
                    <div class="col-xs-6" style="float: right">
                        <div class="titleSection">
                            <div class="titlesPlaceDetail">
                                <span class="titleSectionSpan">
                                    نوع غذا
                                </span>
                            </div>
                        </div>
                        <div class="contentSection">{{$place->kindName}}</div>
                    </div>
                    <div class="col-xs-6" style="float: right">
                        <div class="titleSection">
                            <div class="titlesPlaceDetail">
                                <span class="titleSectionSpan">
                                    نوع سرو
                                </span>
                            </div>
                        </div>
                        <div class="contentSection">{{$place->hotOrCold}}</div>
                    </div>
                </div>

                <div class="titleSection">
                    <div class="titlesPlaceDetail">
            <span class="titleSectionSpan">
                مناسب برای
            </span>
                    </div>
                </div>
                <div class="contentSection col-xs-12">افراد گیاه خوار
                    <span style=" color: {{$place->vegetarian == 1 ? 'green' : 'red'}};">
                        {{$place->vegetarian == 1 ? 'هست' : 'نیست'}}
                    </span>
                </div>
                <div class="contentSection col-xs-12">افراد وگان
                    <span style=" color: {{$place->vegan == 1 ? 'green' : 'red'}};">
                        {{$place->vegan == 1 ? 'هست' : 'نیست'}}
                    </span>
                </div>
                <div class="contentSection col-xs-12">افراد دیابتی
                    <span style=" color: {{$place->diabet == 1 ? 'green' : 'red'}};">
                        {{$place->diabet == 1 ? 'هست' : 'نیست'}}
                    </span>
                </div>

                <div class="titleSection">
                    <div class="titlesPlaceDetail">
                        <span class="titleSectionSpan">
                            کالری
                        </span>
                    </div>
                </div>
                <div class="contentSection col-xs-12">
                    <span style="float: right"> : {{$place->name}} </span>
                    <span style="float: right"> {{$place->energy}} </span>
                    <span style="float: right"> کالری در هر</span>
                    <span style="float: right"> {{$place->volume}} </span>
                    <span style="float: right"> {{$place->source}} </span>
                </div>
                @if($place->rice == 1)
                    <div class="contentSection col-xs-12">
                        برنج: 20 کالری در 1 قاشق غذاخوری
                    </div>
                @endif
                @if($place->bread == 1)
                    <div class="contentSection col-xs-12">
                        نان: 40 کالری به اندازه ی هر کف دست
                    </div>
                @endif

            </div>
        </div>
    </div>

    <div id="recepieForFood" class="ui_column is-8 generalDescription tabContent">
        <div class="block_header">
            <div class="titlesPlaceDetail">
                <h3 class="block_title">
                    دستورپخت :
                </h3>
            </div>
        </div>
        <div class="toggleDescription" style="position: relative">
            <div class="unselectedText overviewContent descriptionOfPlaceMiddleContent"
                 id="introductionText">
                {!! $place->recipes !!}
            </div>
        </div>
    </div>

    <div class="ui_column is-4 reviews tabContent hideOnPhone">
        <div class="rateOfPlaceMiddleContent">
            @include('pages.placeDetails.component.PlaceDetailRateSection')
        </div>
    </div>
</div>

