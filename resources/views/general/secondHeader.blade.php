<style>
    .secHeadMain{
        direction: rtl;
        text-align: right;
        position: relative;
        padding: 0px 20px;
        background-color: var(--koochita-yellow);
    }

    .secHeadTabs:not(:first-child) {

        margin-right: 20px;
    }

    .secHeadTabs {
        font-size: 13px;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #16174f;
        font-weight: bold;
        position: relative;
        cursor: pointer;
        height: 40px;
    }

    .secHeadNavs{
        display: flex;
    }

    .secHeadTabsSubList{
        position: absolute;
        top: 40px;
        z-index: 10;
        display: none;
        flex-direction: column;
        min-width: 130px;
        background-color: var(--koochita-yellow);
        border-radius: 0px 0px 10px 10px;
    }

    .secHeadTabs:hover .secHeadTabsSubList{
        display: flex;
    }

    .secHeadTabsSubList > a{
        color: black;
        padding: 10px 5px;
        font-size: 12px;
        text-align: center;
    }

    .secHeadTabsSubList > a:hover{
        background-color: #88070B;
        color: white;
    }

    .linkRoute{
        color: #16174f !important;
        font-size: 15px;
    }

    .spanMarginSecHead{
        flex-wrap: wrap;
    }

    .spanMarginSecHead > span {
        margin: 3px 7px 0;
    }

    .spanMarginSecHead > a {
        display: flex;
        align-items: center;
    }

    .secHeadTabsSubList > a:last-child {
        border-radius:  0 0 10px 10px;
    }

    .secHeaderPathDiv{
        margin-right: 10px;
        /*min-width: 90px;*/
    }

    .yelCol{
        color: var(--koochita-yellow);
    }
    .listSecHeadContainer{
        font-size: 20px;
        flex-wrap: nowrap;
    }
    .fluidPlacePath{
        background-color: white;
        padding-top: 10px;
        overflow-y: hidden;
        overflow-x: auto;
    }
    .linkRoute{
        min-width: 60px;
    }

    @media (max-width: 889px) {
        .secHeadTabs{
            margin-right: 13px;
            font-size: 10px;
            font-weight: 800;
        }
    }

    @media (max-width: 650px){

        .listSecHeadContainer{
            width: fit-content;
        }
        .linkRoute {
            font-size: 12px;
        }
        .spanMarginSecHead{
            padding: 0px;
            padding-left: 10px;
        }
    }
</style>

<div class="container-fluid secHeadMain hideOnPhone">
    <div class="container secHeadNavs">
        <div class="secHeadTabs arrowAfter">
            <span>
                {{$locationName['cityName']}}
            </span>
            <div class="secHeadTabsSubList">
                <a href="{{route('cityPage', ['kind' => $locationName['kindState'], 'city' => $locationName['cityNameUrl'] ])}}" target="_blank" >
                    {{$locationName['cityName']}}
                </a>
                @if(isset($locationName['state']) && $locationName['kindState'] == 'city')
                    <a href="{{route('cityPage', ['kind' => 'state', 'city' => $locationName['state'] ])}}" target="_blank" >{{__('استان')}} {{$locationName['state']}}</a>
                @endif
                <a href="{{url('/main')}}">{{__('صفحه اصلی')}}</a>
            </div>
        </div>
        <div class="secHeadTabs arrowAfter">
            <span>
                {{__('اقامتگاه')}}
            </span>
            <div class="secHeadTabsSubList">
                <a href="{{route('place.list', ['kindPlaceId' => 4, 'mode' => $locationName['kindState'], 'city' => $locationName['cityNameUrl']])}}">
                    {{__('اقامتگاه‌های')}}
                    {{$locationName['cityName']}}
                </a>
                @if(isset($locationName['state']) && $locationName['kindState'] == 'city')
                    <a href="{{route('place.list', ['kindPlaceId' => 4, 'mode' => 'state', 'city' => $locationName['state']])}}">
                        {{__('اقامتگاه‌های استان')}}
                        {{$locationName['state']}}
                    </a>
                @endif
            </div>
        </div>
        <div class="secHeadTabs arrowAfter">
            <span>
                {{__('رستوران‌')}}
            </span>
            <div class="secHeadTabsSubList">
                <a href="{{route('place.list', ['kindPlaceId' => 3, 'mode' =>  $locationName['kindState'], 'city' => $locationName['cityNameUrl']])}}">
                    {{__('رستوران‌های')}}
                    {{$locationName['cityName']}}
                </a>
                @if(isset($locationName['state']) && $locationName['kindState'] == 'city')
                    <a href="{{route('place.list', ['kindPlaceId' => 3, 'mode' => 'state', 'city' => $locationName['state']])}}">
                        {{__('رستوران‌های استان')}}
                        {{$locationName['state']}}
                    </a>
                @endif
            </div>
        </div>
        <div class="secHeadTabs arrowAfter">
            <span>
                {{__('جاذبه‌')}}
            </span>
            <div class="secHeadTabsSubList">
                <a href="{{route('place.list', ['kindPlaceId' => 1, 'mode' =>  $locationName['kindState'], 'city' => $locationName['cityNameUrl']])}}">
                    {{__('جاذبه‌های')}}
                    {{$locationName['cityName']}}
                </a>
                @if(isset($locationName['state'])  && $locationName['kindState'] == 'city')
                    <a href="{{route('place.list', ['kindPlaceId' => 1, 'mode' => 'state', 'city' => $locationName['state']])}}">
                        {{__('جاذبه‌های استان')}}
                        {{$locationName['state']}}
                    </a>
                @endif
            </div>
        </div>
        <div class="secHeadTabs arrowAfter">
            <span>
                {{__('طبیعت‌گردی')}}
            </span>
            <div class="secHeadTabsSubList">
                <a href="{{route('place.list', ['kindPlaceId' => 6, 'mode' =>  $locationName['kindState'], 'city' => $locationName['cityNameUrl']])}}">
                    {{__('طبیعت‌گردی‌های')}}
                    {{$locationName['cityName']}}
                </a>
                @if(isset($locationName['state']) && $locationName['kindState'] == 'city')
                    <a href="{{route('place.list', ['kindPlaceId' => 6, 'mode' => 'state', 'city' => $locationName['state']])}}">
                        {{__('طبیعت‌گردی‌های استان')}}
                        {{$locationName['state']}}
                    </a>
                @endif
            </div>
        </div>
        <div class="secHeadTabs arrowAfter">
            <span>
                {{__('سوغات و صنایع‌دستی')}}
            </span>
            <div class="secHeadTabsSubList">
                <a href="{{route('place.list', ['kindPlaceId' => 10, 'mode' =>  $locationName['kindState'], 'city' => $locationName['cityNameUrl']])}}">
                    {{__('سوغات و صنایع‌دستی')}}
                    {{$locationName['cityName']}}
                </a>
                @if(isset($locationName['state'])  && $locationName['kindState'] == 'city')
                    <a href="{{route('place.list', ['kindPlaceId' => 10, 'mode' => 'state', 'city' => $locationName['state']])}}">
                        {{__('سوغات و صنایع‌دستی استان')}}
                        {{$locationName['state']}}
                    </a>
                @endif
            </div>
        </div>
        <div class="secHeadTabs arrowAfter">
            <span>
                {{__('غذاهای محلی')}}
            </span>
            <div class="secHeadTabsSubList">
                <a href="{{route('place.list', ['kindPlaceId' => 11, 'mode' => $locationName['kindState'], 'city' => $locationName['cityNameUrl']])}}">
                    {{__('غذاهای محلی')}}
                    {{$locationName['cityName']}}
                </a>
                @if(isset($locationName['state']) && $locationName['kindState'] == 'city')
                    <a href="{{route('place.list', ['kindPlaceId' => 11, 'mode' => 'state', 'state' => $locationName['state']])}}">
                        {{__('غذاهای محلی استان')}}
                        {{$locationName['state']}}
                    </a>
                @endif
            </div>
        </div>
        <div class="secHeadTabs arrowAfter">
            <span>
                {{__('بوم گردی')}}
            </span>
            <div class="secHeadTabsSubList">
                <a href="{{route('place.list', ['kindPlaceId' => 12, 'mode' => $locationName['kindState'], 'city' => $locationName['cityNameUrl']])}}">
                    {{__('بوم گردی های')}}
                    {{$locationName['cityName']}}</a>
                @if(isset($locationName['state']) && $locationName['kindState'] == 'city')
                    <a href="{{route('place.list', ['kindPlaceId' => 12, 'mode' => 'state', 'state' => $locationName['state']])}}">
                        {{__('بوم گردی های استان')}}
                        {{$locationName['state']}}</a>
                @endif
            </div>
        </div>
        <div class="secHeadTabs ">
            <a href="{{route('safarnameh.index')}}" style="color: #16174f">{{__('سفرنامه‌ها')}}</a>
        </div>
    </div>
</div>

@if(isset($kindPlace))
    <div class="container-fluid fluidPlacePath secHeadMain">
        <script type="application/ld+json">
    <?php
      $schemaPosition = 1;
    ?>
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement":
        [
            @if($locationName['kindState'] != 'country')
            {
                "@type": "ListItem",
                "item":  {
                    "@type": "Thing",
                    "name": "استان {{$locationName['state']}}",
                    "alternateName": "استان {{$locationName['state']}}",
                    "url": "{{route('cityPage', ['kind' => 'state', 'city' => $locationName['state']])}}",
                    "id":"state"
                },
                "position": "{{++$schemaPosition}}"
            },
            @endif

            @if($locationName['kindState'] == 'city')
            {
                "@type": "ListItem",
                "item":  {
                    "@type": "Thing",
                    "name": "{{$locationName['cityNameUrl']}}",
                    "alternateName": "{{$locationName['cityNameUrl']}}",
                    "url": "{{route('cityPage', ['kind' => 'city', 'city' => $locationName['cityNameUrl']])}}",
                    "id":"city"
                },
                "position": "{{++$schemaPosition}}"
            },
            @endif

            {
            "@type": "ListItem",
                "item":  {
                    "@type": "Thing",
                    "name": "{{$kindPlace->title}}",
                    "alternateName": "{{$kindPlace->title}}",
                    "url": "{{route('place.list', ['kindPlaceId' => $kindPlaceId, 'mode' => $locationName['kindState'], 'city' => $locationName['cityNameUrl'] ])}}",
                    "id":"list"
                },
                "position": "{{++$schemaPosition}}"
            },

            @if($locationName['kindPage'] == 'place')
                {
                   "@type": "ListItem",
                   "item":  {
                       "@type": "Thing",
                       "name": "{{$place->name}}",
                        "alternateName": "{{$place->name}}",
                        "url": "{{Request::url()}}",
                        @if(isset($photos[0]))
                            "image": "{{$photos[0]}}",
                        @endif
                        "id":"place"
                   },
                   "position": "{{++$schemaPosition}}"
                },
            @endif

            {
                "@type": "ListItem",
                "item":  {
                    "@type": "Thing",
                    "name": "خانه",
                    "alternateName": "کوچیتا | سامانه جامع گردشگری",
                    "url": "{{url('/main')}}",
                    "id":"home"
                },
                "position": "1"
            }
       ]
    }
    </script>
        <div class="container listSecHeadContainer secHeadNavs spanMarginSecHead">
            <a class="linkRoute" href="{{url('/main')}}">
                {{__('صفحه اصلی')}}
            </a>
            @if($locationName['kindState'] != 'country')
                <div class="secHeaderPathDiv lessShowText">
                    <span class="yelCol"> > </span>
                    <a class="linkRoute" href="{{route('cityPage', ['kind' => 'state', 'city' => $locationName['state']])}}">
                        استان {{$locationName['state']}}
                    </a>
                </div>
            @endif

            @if($locationName['kindState'] == 'city')
                <div class="secHeaderPathDiv lessShowText">
                    <span class="yelCol"> > </span>
                    <a class="linkRoute" href="{{route('cityPage', ['kind' => 'city', 'city' => $locationName['cityNameUrl']])}}">
                        {{$locationName['cityNameUrl']}}
                    </a>
                </div>
            @endif

            <div class="secHeaderPathDiv lessShowText">
                <span class="yelCol"> > </span>
                <a class="linkRoute" href="{{route('place.list', ['kindPlaceId' => $kindPlaceId, 'mode' => $locationName['kindState'], 'city' => $locationName['cityNameUrl'] ])}}">
                    {{$kindPlace->title}}
                    @if($mode != 'country')
                        {{$mode == 'state' ? ' استان '.$city->name : $city->name}}
                    @else
                        ایران من
                    @endif
                </a>
            </div>

            @if($locationName['kindPage'] == 'place')
                <div class="secHeaderPathDiv lessShowText">
                    <span class="yelCol"> > </span>
                    <a class="linkRoute" href="{{Request::url()}}">
                        {{$place->name}}
                    </a>
                </div>
            @endif

        </div>
    </div>
@endif