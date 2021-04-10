<?php
    if(isset($_GET['showDBConnectionCounts']) && $_GET['showDBConnectionCounts'] == 1){
        dd([
            'eloquent connection' => Illuminate\Database\Eloquent\Model::showHowManyCounter(),
            'DB connection' => Illuminate\Support\Facades\DB::showConnectionCounter()
        ]);
    }
?>
<meta content="43970F70216852DDFADD70BBB51A6A8D" name="jetseo-site-verification" rel="verify" />

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<meta name="theme-color" content="#30b4a6"/>
<meta name="msapplication-TileColor" content="#30b4a6">
<meta name="msapplication-TileImage" content="{{URL::asset('images/icons/mainIcon.png')}}">
<meta name="twitter:card" content="summary"/>
<meta property="og:url" content="{{Request::url()}}" />
<meta property="og:site_name" content="سامانه جامع گردشگری کوچیتا" />
<meta name="csrf-token" content="{{ csrf_token() }}"/>

<link rel="icon" href="{{URL::asset('images/icons/KOFAV0.svg')}}" sizes="any" type="image/svg+xml">
<link rel="apple-touch-icon-precomposed" href="{{URL::asset('images/icons/KOFAV0.svg')}}" sizes="any" type="image/svg+xml">

<link rel='stylesheet' type='text/css' href='{{URL::asset('css/fonts.css?v='.$fileVersions)}}' media="all"/>
<link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/bootstrap.min.css?v='.$fileVersions)}}'  media="all"/>
<link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/topHeaderStyles.css?v='.$fileVersions)}}'  media="all"/>
<link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/icons.css?v1='.$fileVersions)}}' media="all"/>
<link rel="stylesheet" type='text/css' href="{{URL::asset('css/theme2/swiper.css?v='.$fileVersions)}}" media="all">
<link rel="stylesheet" href="{{URL::asset('css/component/components.css?v='.$fileVersions)}}" media="all">
<link rel="stylesheet" href="{{URL::asset('css/component/generalFolder.css?v='.$fileVersions)}}">

<link rel="stylesheet" href="{{URL::asset('css/common/header.css?v=.'.$fileVersions)}}">
<link rel="stylesheet" href="{{URL::asset('css/common/header1.css?v='.$fileVersions)}}">
<link rel="stylesheet" href="{{URL::asset('css/common/DA.css?v='.$fileVersions)}}">
<link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/footer.css?v='.$fileVersions)}}' />

<link rel="stylesheet" href="{{URL::asset('packages/fontAwesome6/css/all.min.css')}}">
{{--<script src="{{URL::asset('packages/fontAwesome6/js/all.min.js')}}"></script>--}}


@if(\App::getLocale() == 'en')
    <link rel="stylesheet" href="{{URL::asset('css/ltr/mainPageHeader.css?v='.$fileVersions)}}">
    <link rel="stylesheet" href="{{URL::asset('css/ltr/ltrFooter.css?v='.$fileVersions)}}">
@endif

<script src="{{URL::asset('js/jquery-3.4.1.min.js')}}"></script>
<script async src="{{URL::asset('js/defualt/bootstrap.min.js')}}"></script>

<script src="{{URL::asset('js/defualt/autosize.min.js')}}"></script>
<script src="{{URL::asset('js/swiper/swiper.min.js')}}"></script>
<script async src="{{URL::asset('js/defualt/lazysizes.min.js')}}"></script>

<style>
@if(\App::getLocale() == 'en')

    *{
        font-family: enFonts;
        direction: ltr;
        text-align: left;
    }
    .suggestionPackDetailDiv{
        direction: ltr;
    }
@else
    *{
        font-family: IRANSansWeb;
    }
@endif
</style>


@if(config('app.env') != 'local')
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-158914626-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-158914626-1');
    </script>
@endif

<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Organization",
    "name":"سامانه جامع گردشگری کوچیتا",
	"alternateName":"Koochita",
	"url":"https://koochita.com",
	"sameAs": [
         "https://www.facebook.com/Koochita-115157527076374",
         "https://twitter.com/Koochita_Com",
         "https://www.instagram.com/koochita_com/",
         "https://t.me/koochita",
         "https://wa.me/989120239315"
    ],
	"address":[
        {
            "@type": "PostalAddress",
            "addressCountry": "IR",
            "addressRegion": "تهران",
            "streetAddress": "میدان ونک ، قبل از چهارراه جهان کودک ، ساختمان دانشگاه علامه طبابایی، طبقه سوم ، سیسوتک"
        }
    ],
    "email":"info@koochita.com",
    "logo":"{{URL::asset('images/icons/KOFAV0.svg')}}",
	"founder":[
		{
			"@type": "Person",
			"name": "Soore Vahedzade"
        }
    ]
},
</script>


@if(auth()->check())
    @include('layouts.urlAuthed')
    <script src="{{URL::asset('js/pages/ifLogin.js?v='.$fileVersions)}}"></script>
@endif

<script type="text/javascript">
    $.ajaxSetup({
        xhrFields: { withCredentials: true },
    });

    window.mappIrToken = '{{config('app.MappIrToken')}}';
    window.mainIconsPlaces = {
        amaken: {
            icon: 'touristAttractions',
            nameFa: 'جاذبه'
        },
        restaurant: {
            icon: 'restaurantIcon',
            nameFa: 'رستوران'
        },
        hotels: {
            icon: 'hotelIcon',
            nameFa: 'هتل'
        },
        sogatSanaies:{
            icon: 'souvenirIcon',
            nameFa: 'سوغات و صنایع دستی'
        },
        mahaliFood:{
            icon: 'traditionalFood',
            nameFa: 'غذای محلی'
        },
        majara: {
            icon: 'adventureIcon',
            nameFa: 'طبیعت گردی'
        },
        boomgardies: {
            icon: 'boomIcon',
            nameFa: 'بوم گردی'
        },
        safarnameh: {
            icon: 'safarnameIcon',
            nameFa: 'سفرنامه'
        },
        localShops: {
            icon: 'fullWalletIcon',
            nameFa: 'فروشگاه'
        },
        drinks: {
            icon: 'fas fa-wine-glass-alt',
            nameFa: 'نوشیدنی',
            isAwesome: true,
        },
        state: {
            icon: 'location',
            nameFa: 'استان'
        },
        city:  {
            icon: 'location',
            nameFa: 'شهر'
        },
    };
    window.googleMapStyle = [
        {
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#ebe3cd"
                }
            ]
        },
        {
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#523735"
                }
            ]
        },
        {
            "elementType": "labels.text.stroke",
            "stylers": [
                {
                    "color": "#f5f1e6"
                }
            ]
        },
        {
            "featureType": "administrative",
            "elementType": "geometry",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "administrative",
            "elementType": "geometry.stroke",
            "stylers": [
                {
                    "color": "#c9b2a6"
                }
            ]
        },
        {
            "featureType": "administrative.land_parcel",
            "elementType": "geometry.stroke",
            "stylers": [
                {
                    "color": "#dcd2be"
                }
            ]
        },
        {
            "featureType": "administrative.land_parcel",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#ae9e90"
                }
            ]
        },
        {
            "featureType": "landscape.natural",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#dfd2ae"
                }
            ]
        },
        {
            "featureType": "poi",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "poi",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#dfd2ae"
                }
            ]
        },
        {
            "featureType": "poi",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#93817c"
                }
            ]
        },
        {
            "featureType": "poi.park",
            "elementType": "geometry.fill",
            "stylers": [
                {
                    "color": "#a5b076"
                }
            ]
        },
        {
            "featureType": "poi.park",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#447530"
                }
            ]
        },
        {
            "featureType": "road",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#f5f1e6"
                }
            ]
        },
        {
            "featureType": "road",
            "elementType": "labels.icon",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "road.arterial",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#fdfcf8"
                }
            ]
        },
        {
            "featureType": "road.highway",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#f8c967"
                }
            ]
        },
        {
            "featureType": "road.highway",
            "elementType": "geometry.stroke",
            "stylers": [
                {
                    "color": "#e9bc62"
                }
            ]
        },
        {
            "featureType": "road.highway.controlled_access",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#e98d58"
                }
            ]
        },
        {
            "featureType": "road.highway.controlled_access",
            "elementType": "geometry.stroke",
            "stylers": [
                {
                    "color": "#db8555"
                }
            ]
        },
        {
            "featureType": "road.local",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#806b63"
                }
            ]
        },
        {
            "featureType": "transit",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "transit.line",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#dfd2ae"
                }
            ]
        },
        {
            "featureType": "transit.line",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#8f7d77"
                }
            ]
        },
        {
            "featureType": "transit.line",
            "elementType": "labels.text.stroke",
            "stylers": [
                {
                    "color": "#ebe3cd"
                }
            ]
        },
        {
            "featureType": "transit.station",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#dfd2ae"
                }
            ]
        },
        {
            "featureType": "water",
            "elementType": "geometry.fill",
            "stylers": [
                {
                    "color": "#b9d3c2"
                }
            ]
        },
        {
            "featureType": "water",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#92998d"
                }
            ]
        }
    ];



    var homeURL = "{{route('home')}}";

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function hideElement(e) {
        $(".dark").hide();
        $("#" + e).addClass("hidden");
    }

    function showElement(e) {
        $("#" + e).removeClass("hidden");
        $(".dark").show();
    }

    function setDefaultPic(_element){
        _element.src = '{{URL::asset('images/mainPics/noPicSite.jpg')}}';
    }


    // (function(){
    //     var now = new Date();
    //     var head = document.getElementsByTagName('head')[0];
    //     var script = document.createElement('script');
    //     script.async = true;
    //     var script_address = 'https://cdn.yektanet.com/js/koochita.com/native-koochita.com-14383.js';
    //     script.src = script_address + '?v=' + now.getFullYear().toString() + '0' + now.getMonth() + '0' + now.getDate() + '0' + now.getHours();
    //     head.appendChild(script);
    // })();
    //
    // var head = document.getElementsByTagName("head")[0];
    // var script = document.createElement("script");
    // script.type = "text/javascript";
    // script.async=1;
    // script.src = "https://s1.mediaad.org/serve/koochita.com/loader.js" ;
    // head.appendChild(script);
</script>



