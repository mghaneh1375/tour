<link rel="stylesheet" href="{{URL::asset('css/pages/secondHeader.css?v='.$fileVersions)}}">

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
