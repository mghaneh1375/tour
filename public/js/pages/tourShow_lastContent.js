
<script>
var hotelMap = [];
var amakenMap = [];
var restMap = [];
var majaraMap = [];
var newHotelMap = [];
var newRestMap = [];
var newAmakenMap = [];
var newMajaraMap = [];
var isHotelOn = 1;
var isRestaurantOn = [1, 1];
var isAmakenOn = [1, 1, 1, 1, 1, 1];
var map1;
var markersHotel = [];
var markersRest = [];
var markersFast = [];
var markersMus = [];
var markersPla = [];
var markersShc = [];
var markersFun = [];
var markersAdv = [];
var markersNat = [];
var iconBase = '{{URL::asset('images') . '/'}}';
var icons = {
    hotel: iconBase + 'mhotel.png',
    pla: iconBase + 'matr_pla.png',
    mus: iconBase + 'matr_mus.png',
    shc: iconBase + 'matr_shc.png',
    nat: iconBase + 'matr_nat.png',
    fun: iconBase + 'matr_fun.png',
    adv: iconBase + 'matr_adv.png',
    vil: iconBase + 'matr_vil',
    fastfood: iconBase + 'mfast.png',
    rest: iconBase + 'mrest.png'
};
var kindIcon;
var isMapAchieved = false;
var newBounds = [];
var newBound;
var numOfNewHotel = 0;
var numOfNewAmaken = 0;
var numOfNewRest = 0;
var numOfNewMajara = 0;
var availableHotelIdMarker = [];
var availableRestIdMarker = [];
var availableAmakenlIdMarker = [];
var availableMajaraIdMarker = [];
var num = 0;
var isItemClicked = false;

function showExtendedMap() {
    if (!isMapAchieved) {
        $('.dark').show();
        showElement('mapState');//mapState
        isMapAchieved = true;
        init2();
    }
    else {
        $("#mapState").removeClass('hidden');
    }
}

function init2() {
    var mapOptions = {
        zoom: 18,
        center: new google.maps.LatLng(x, y),
        styles: [{
            "featureType": "landscape",
            "stylers": [{"hue": "#FFA800"}, {"saturation": 0}, {"lightness": 0}, {"gamma": 1}]
        }, {
            "featureType": "road.highway",
            "stylers": [{"hue": "#53FF00"}, {"saturation": -73}, {"lightness": 40}, {"gamma": 1}]
        }, {
            "featureType": "road.arterial",
            "stylers": [{"hue": "#FBFF00"}, {"saturation": 0}, {"lightness": 0}, {"gamma": 1}]
        }, {
            "featureType": "road.local",
            "stylers": [{"hue": "#00FFFD"}, {"saturation": 0}, {"lightness": 30}, {"gamma": 1}]
        }, {
            "featureType": "water",
            "stylers": [{"hue": "#00BFFF"}, {"saturation": 6}, {"lightness": 8}, {"gamma": 1}]
        }, {
            "featureType": "poi",
            "stylers": [{"hue": "#679714"}, {"saturation": 33.4}, {"lightness": -25.4}, {"gamma": 1}]
        }
        ]
    };
    var mapElementSmall = document.getElementById('mapState1');
    map1 = new google.maps.Map(mapElementSmall, mapOptions);
    google.maps.event.addListenerOnce(map1, 'idle', function () {
        newBound = map1.getBounds();
        newBounds[0] = newBound.getNorthEast().lat();
        newBounds[1] = newBound.getNorthEast().lng();
        newBounds[2] = newBound.getSouthWest().lat();
        newBounds[3] = newBound.getSouthWest().lng();
        addNewPlace(newBounds);
        zoomChangeOrCenterChange();
    });
}

function toggleHotelsInExtendedMap(value) {
    if (isHotelOn == value) {
        document.getElementById('hotelImg').src = "{{URL::asset('images') . '/'}}mhoteloff.png";
        isHotelOn = 0;
        mySetMap(isHotelOn, markersHotel);
    }
    else {
        document.getElementById('hotelImg').src = "{{URL::asset('images') . '/'}}mhotel.png";
        isHotelOn = 1;
        mySetMap(isHotelOn, markersHotel);
    }
}

function toggleRestaurantsInExtendedMap(value) {
    if (isRestaurantOn[0] == value) {
        document.getElementById('restImg').src = "{{URL::asset('images') . '/'}}mrestoff.png";
        isRestaurantOn[0] = 0;
        mySetMap(isRestaurantOn[0], markersRest);
    }
    else {
        document.getElementById('restImg').src = "{{URL::asset('images') . '/'}}mrest.png";
        isRestaurantOn[0] = 1;
        mySetMap(isRestaurantOn[0], markersRest);
    }
}

function toggleFastFoodsInExtendedMap(value) {
    if (isRestaurantOn[1] == value) {
        document.getElementById('fastImg').src = "{{URL::asset('images') . '/'}}mfastoff.png";
        isRestaurantOn[1] = 0;
        mySetMap(isRestaurantOn[1], markersFast);
    }
    else {
        document.getElementById('fastImg').src = "{{URL::asset('images') . '/'}}mfast.png";
        isRestaurantOn[1] = 1;
        mySetMap(isRestaurantOn[1], markersFast);
    }
}

function toggleMuseumsInExtendedMap(value) {
    if (isAmakenOn[0] == value) {
        document.getElementById('musImg').src = "{{URL::asset('images') . '/'}}matr_musoff.png";
        isAmakenOn[0] = 0;
        mySetMap(isAmakenOn[0], markersMus);
    }
    else {
        document.getElementById('musImg').src = "{{URL::asset('images') . '/'}}matr_mus.png";
        isAmakenOn[0] = 1;
        mySetMap(isAmakenOn[0], markersMus);
    }
}

function toggleHistoricalInExtendedMap(value) {
    if (isAmakenOn[1] == value) {
        document.getElementById('plaImg').src = "{{URL::asset('images') . '/'}}matr_plaoff.png";
        isAmakenOn[1] = 0;
        mySetMap(isAmakenOn[1], markersPla);
    }
    else {
        document.getElementById('plaImg').src = "{{URL::asset('images') . '/'}}matr_pla.png";
        isAmakenOn[1] = 1;
        mySetMap(isAmakenOn[1], markersPla);
    }
}

function toggleShopCenterInExtendedMap(value) {
    if (isAmakenOn[2] == value) {
        document.getElementById('shcImg').src = "{{URL::asset('images') . '/'}}matr_shcoff.png";
        isAmakenOn[2] = 0;
        mySetMap(isAmakenOn[2], markersShc);
    }
    else {
        document.getElementById('shcImg').src = "{{URL::asset('images') . '/'}}matr_shc.png";
        isAmakenOn[2] = 1;
        mySetMap(isAmakenOn[2], markersShc);
    }
}

function toggleFunCenterInExtendedMap(value) {
    if (isAmakenOn[3] == value) {
        document.getElementById('funImg').src = "{{URL::asset('images') . '/'}}matr_funoff.png";
        isAmakenOn[3] = 0;
        mySetMap(isAmakenOn[3], markersFun);
    }
    else {
        document.getElementById('funImg').src = "{{URL::asset('images') . '/'}}matr_fun.png";
        isAmakenOn[3] = 1;
        mySetMap(isAmakenOn[3], markersFun);
    }
}

function toggleMajaraCenterInExtendedMap(value) {
    if (isAmakenOn[5] == value) {
        document.getElementById('advImg').src = "{{URL::asset('images') . '/'}}matr_advoff.png";
        isAmakenOn[5] = 0;
        mySetMap(isAmakenOn[5], markersAdv);
    }
    else {
        document.getElementById('advImg').src = "{{URL::asset('images') . '/'}}matr_adv.png";
        isAmakenOn[5] = 1;
        mySetMap(isAmakenOn[5], markersAdv);
    }
}

function toggleNaturalsInExtendedMap(value) {
    if (isAmakenOn[4] == value) {
        document.getElementById('natImg').src = "{{URL::asset('images') . '/'}}matr_natoff.png";
        isAmakenOn[4] = 0;
        mySetMap(isAmakenOn[4], markersNat);
    }
    else {
        document.getElementById('natImg').src = "{{URL::asset('images') . '/'}}matr_nat.png";
        isAmakenOn[4] = 1;
        mySetMap(isAmakenOn[4], markersNat);
    }
}

function addMarker() {
    var marker;
    for (i = numOfNewHotel; i < hotelMap.length; i++) {
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(hotelMap[i].C, hotelMap[i].D),
            map: map1,
            title: hotelMap[i].name,
            icon: {
                url: icons.hotel,
                scaledSize: new google.maps.Size(35, 35)
            }
        });
        var hotelDetail = {
            url: '{{route('home') . '/hotel-details/'}}',
            name: hotelMap[i].name
        };
        hotelDetail.url = hotelDetail.url + hotelMap[i].id + '/' + hotelMap[i].name;
        markersHotel[i] = marker;
        hotelMap[i].kind = 4;
        hotelMap[i].url = hotelDetail.url;
        hotelMap[i].first = true;
        hotelMap[i].pic = "{{URL::asset("images/loading.gif?v=".$fileVersions)}}";
        availableHotelIdMarker[i] = hotelMap[i].id;
        numOfNewHotel = hotelMap.length;
        clickable(markersHotel[i], hotelMap[i]);
    }
    for (i = numOfNewRest; i < restMap.length; i++) {
        if (restMap[i].kind_id == 1)
            kindIcon = icons.rest;
        else
            kindIcon = icons.fastfood;
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(restMap[i].C, restMap[i].D),
            map: map1,
            title: restMap[i].name,
            icon: {
                url: kindIcon,
                scaledSize: new google.maps.Size(35, 35)
            }
        });
        var restDetail = {
            url: '{{route('home') . '/restaurant-details/'}}',
            name: restMap[i].name
        };
        restDetail.url = restDetail.url + restMap[i].id + '/' + restMap[i].name;
        restMap[i].kind = 3;
        restMap[i].url = restDetail.url;
        restMap[i].first = true;
        restMap[i].pic = "{{URL::asset("images/loading.gif?v=".$fileVersions)}}";
        numOfNewRest = restMap.length;
        availableRestIdMarker[i] = restMap[i].id;
        clickable(marker, restMap[i]);
        if (restMap[i].kind_id == 1) {
            markersRest[markersRest.length] = marker;
        }
        else {
            markersFast[markersFast.length] = marker;
        }
    }
    for (i = numOfNewAmaken; i < amakenMap.length; i++) {
        if (amakenMap[i].mooze == 1)
            kindIcon = icons.mus;
        else if (amakenMap[i].tarikhi == 1)
            kindIcon = icons.pla;
        else if (amakenMap[i].tabiatgardi == 1)
            kindIcon = icons.nat;
        else if (amakenMap[i].tafrihi == 1)
            kindIcon = icons.fun;
        else if (amakenMap[i].markazkharid == 1)
            kindIcon = icons.shc;
        else
            kindIcon = icons.pla;
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(amakenMap[i].C, amakenMap[i].D),
            map: map1,
            title: amakenMap[i].name,
            icon: {
                url: kindIcon,
                scaledSize: new google.maps.Size(35, 35)
            }
        });
        var amakenDetail = {
            url: '{{route('home') . '/amaken-details/'}}',
            name: amakenMap[i].name
        };
        amakenDetail.url = amakenDetail.url + amakenMap[i].id + '/' + amakenMap[i].name;
        amakenMap[i].kind = 1;
        amakenMap[i].url = amakenDetail.url;
        amakenMap[i].first = true;
        numOfNewAmaken = amakenMap.length;
        availableAmakenlIdMarker[i] = amakenMap[i].id;
        amakenMap[i].pic = "{{URL::asset("images/loading.gif?v=".$fileVersions)}}";
        clickable(marker, amakenMap[i]);
        if (amakenMap[i].mooze == 1)
            markersMus[markersMus.length] = marker;
        else if (amakenMap[i].tarikhi == 1)
            markersPla[markersPla.length] = marker;
        else if (amakenMap[i].tabiatgardi == 1)
            markersNat[markersNat.length] = marker;
        else if (amakenMap[i].tafrihi == 1)
            markersFun[markersFun.length] = marker;
        else if (amakenMap[i].markazkharid == 1)
            markersShc[markersShc.length] = marker;
        else
            markersPla[markersPla.length] = marker;
    }
    for (i = numOfNewMajara; i < majaraMap.length; i++) {
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(majaraMap[i].C, majaraMap[i].D),
            map: map1,
            title: majaraMap[i].name,
            icon: {
                url: icons.adv,
                scaledSize: new google.maps.Size(35, 35)
            }
        });
        var majaraDetail = {
            url: '{{route('home') . '/hotel-details/'}}',
            name: majaraMap[i].name
        };
        majaraDetail.url = majaraDetail.url + majaraMap[i].id + '/' + majaraMap[i].name;
        markersAdv[i] = marker;
        majaraMap[i].kind = 6;
        majaraMap[i].url = majaraDetail;
        majaraMap[i].first = true;
        majaraMap[i].pic = "{{URL::asset("images/loading.gif?v=".$fileVersions)}}";
        majaraMap[i].address = majaraMap[i].dastresi;
        numOfNewMajara = majaraMap.length;
        availableMajaraIdMarker[i] = majaraMap[i].id;
        clickable(markersAdv[i], majaraMap[i]);
    }
    mySetMap(isHotelOn, markersHotel);
    mySetMap(isRestaurantOn[0], markersRest);
    mySetMap(isRestaurantOn[1], markersFast);
    mySetMap(isAmakenOn[0], markersMus);
    mySetMap(isAmakenOn[1], markersPla);
    mySetMap(isAmakenOn[2], markersShc);
    mySetMap(isAmakenOn[3], markersFun);
    mySetMap(isAmakenOn[4], markersNat);
    mySetMap(isAmakenOn[5], majaraMap);
}

function mySetMap(isSet, marker) {
    if (isSet == 1) {
        for (var i = 0; i < marker.length; i++) {
            marker[i].setMap(map1);
        }
    }
    else
        for (var i = 0; i < marker.length; i++) {
            marker[i].setMap(null);
        }
}

// bounds
function zoomChangeOrCenterChange() {
    google.maps.event.addListener(map1, 'bounds_changed', function () {
        // map1.setOptions({draggable: false})
        newBound = map1.getBounds();
        newBounds[0] = newBound.getNorthEast().lat();
        newBounds[1] = newBound.getNorthEast().lng();
        newBounds[2] = newBound.getSouthWest().lat();
        newBounds[3] = newBound.getSouthWest().lng();
        addNewPlace(newBounds)
    });
}

function addNewPlace(newBounds) {
    var hotelId = JSON.stringify(availableHotelIdMarker);
    var restId = JSON.stringify(availableRestIdMarker);
    var amakenId = JSON.stringify(availableAmakenlIdMarker);
    var majaraId = JSON.stringify(availableMajaraIdMarker);
    $.ajax({
        type: 'post',
        url: '{{route('newPlaceForMap')}}',
        data: {
            'swLat': newBounds[2],
            'swLng': newBounds[3],
            'neLat': newBounds[0],
            'neLng': newBounds[1],
            'C': x,
            'D': y,
            'hotelId': hotelId,
            'restId': restId,
            'amakenId': amakenId,
            'majaraId': majaraId
        },
        success: function (response) {
            response = JSON.parse(response);
            newHotelMap = response.hotel;
            newRestMap = response.rest;
            newAmakenMap = response.amaken;
            newMajaraMap = response.majara;
            afterSuccess();
        }
    });
}

function afterSuccess() {
    for (i = 0; i < newHotelMap.length; i++) {
        hotelMap[hotelMap.length] = newHotelMap[i];
    }
    for (i = 0; i < newMajaraMap.length; i++) {
        majaraMap[majaraMap.length] = newMajaraMap[i];
    }
    for (i = 0; i < newRestMap.length; i++) {
        restMap[restMap.length] = newRestMap[i];
    }
    for (i = 0; i < newAmakenMap.length; i++) {
        amakenMap[amakenMap.length] = newAmakenMap[i];
    }
    addMarker();
}

function clickable(marker, name) {
    google.maps.event.addListener(marker, 'click', function () {
        document.getElementById('placeInfoInExtendedMap').style.display = 'inline';
        document.getElementById('url').innerHTML = name.name;
        document.getElementById('url').href = name.url;
        isItemClicked = true;
        if (name.first)
            getPic(name);
        else {
            $("#placeInfoPicInExtendedMap").attr('src', name.pic);
        }
        switch (name.rate) {
            case 1:
                document.getElementById('star').className = "ui_bubble_rating bubble_10";
                document.getElementById('star').content = '1';
                document.getElementById('rateNum').innerHTML = '1';
                break;
            case 2:
                document.getElementById('star').className = "ui_bubble_rating bubble_20";
                document.getElementById('star').content = '2';
                document.getElementById('rateNum').innerHTML = '2';
                break;
            case 3:
                document.getElementById('star').className = "ui_bubble_rating bubble_30";
                document.getElementById('star').content = '3';
                document.getElementById('rateNum').innerHTML = '3';
                break;
            case 4:
                document.getElementById('star').className = "ui_bubble_rating bubble_40";
                document.getElementById('star').content = '4';
                document.getElementById('rateNum').innerHTML = '4';
                break;
            case 5:
                document.getElementById('star').className = "ui_bubble_rating bubble_50";
                document.getElementById('star').content = '5';
                document.getElementById('rateNum').innerHTML = '5';
                break;
        }
        switch (name.kind) {
            case 4:
                document.getElementById('nearTitle').innerHTML = 'سایر هتل ها';
                break;
            case 3:
                document.getElementById('nearTitle').innerHTML = 'سایر رستوران ها';
                break;
            case 1:
                document.getElementById('nearTitle').innerHTML = 'سایر اماکن ';
                break;
        }
        document.getElementById('rev').innerHTML = name.reviews + "نقد";
        document.getElementById('address').innerHTML = "آدرس : " + name.address;
        var scope = angular.element(document.getElementById("nearbyInExtendedMap")).scope();
        scope.$apply(function () {
            scope.findNearPlaceForMap(name);
        });
    });
    var classRatingHover;
    switch (name.rate) {
        case 1:
            // classRatingHover.className = 'ui_bubble_rating bubble_10';
            classRatingHover = 'ui_bubble_rating bubble_10';
            // classRatingHover.content = '1';
            break;
        case 2:
            classRatingHover = 'ui_bubble_rating bubble_20';
            // classRatingHover.content = '2';
            break;
        case 3:
            classRatingHover = 'ui_bubble_rating bubble_30';
            // classRatingHover.content = '3';
            break;
        case 4:
            classRatingHover = 'ui_bubble_rating bubble_40';
            // classRatingHover.content = '4';
            break;
        case 5:
            classRatingHover = 'ui_bubble_rating bubble_50';
            // classRatingHover.content = '5';
            break;
    }
    var hoverContent = "<div id='myTotalPane' style='width:100%'><img id='itemPicInExtendedMap' style='height: 80px; width: 40%; display:inline-block;' src=" + '{{URL::asset("images/loading.gif?v=".$fileVersions)}}' + " >" +
        "<a href='" + name.url + "' style='display: inline-block; margin-right: 5%; font-size: 110%;'>" + name.name + "</a>" +
        "<div class='rating' style='display: block;margin-top: -18%; margin-right: 45%;'>" +
        "<span id='rateNum1' class='overallRating'> </span>" +
        "<div class='prw_rup prw_common_bubble_rating overallBubbleRating' style='display: inline;'>" +
        "<span id='star1' class='" + classRatingHover + "' style='font-size:20px;' property='ratingValue' content='' ></span>" +
        "</div>" +
        "<span id='rev1' class='autoResize' style='margin-right: 10%;font-size: 115%;'>" + name.reviews + "نقد </span>" +
        "</div>" +
        "<h1 style='margin-right:42%; margin-top:2%'>فاصله :" + name.distance * 1000 + "متر</h1>" +
        "<h1 id='address1' style='display: block; font-size: 130%; margin-top: 6%;'>" + name.address + "</h1>" +
        "</div>";
    var infowindow = new google.maps.InfoWindow({
        content: hoverContent,
        maxWidth: 350
    });
    google.maps.event.addListener(marker, 'mouseover', function () {
        if (name.first)
            getPic(name);
        else {
            $("#itemPicInExtendedMap").attr('src', name.pic);
        }
        infowindow.open(map1, marker);
    });
    google.maps.event.addListener(marker, 'mouseout', function () {
        infowindow.close(map1, marker);
    });
    google.maps.event.addListener(infowindow, 'domready', function () {
        var iwOuter = $('.gm-style-iw');
        var iwBackground = iwOuter.prev();
        // Removes background shadow DIV
        iwBackground.children(':nth-child(2)').css({'display': 'none'});
        // Removes white background DIV
        iwBackground.children(':nth-child(4)').css({'display': 'none'});
        // Moves the infowindow 115px to the right.
        iwOuter.parent().parent().css({left: '0px', 'overflow': 'none'});
        // Moves the shadow of the arrow 76px to the left margin.
        iwBackground.children(':nth-child(1)').attr('style', function (i, s) {
            return s + 'left: 76px !important;'
        });
        // Moves the arrow 76px to the left margin.
        iwBackground.children(':nth-child(3)').attr('style', function (i, s) {
            return s + 'left: 0px !important;'
        });
        // Changes the desired tail shadow color.
        iwBackground.children(':nth-child(3)').find('div').children().css({
            'box-shadow': 'rgba(72, 181, 233, 0.6) 0px 1px 6px',
            'z-index': '1'
        });
        // Reference to the div that groups the close button elements.
        var iwCloseBtn = iwOuter.next();
        // Apply the desired effect to the close button
        iwCloseBtn.css({display: 'none'});
        $("#myTotalPane").parent().attr('style', function (i, s) {
            return s + 'min-height: 152px !important; max-height: 200px !important;'
        })
    });
}

function getPic(name) {
    $.ajax({
        type: 'post',
        url: '{{route('getPlacePicture')}}',
        data: {
            'kindPlaceId': name.kind,
            'placeId': name.id
        },
        success: function (response) {
            $("#itemPicInExtendedMap").attr('src', response);
            $("#placeInfoPicInExtendedMap").attr('src', name.pic);
            name.first = false;
            name.pic = response;
        }
    });
}

function getJustPic(name) {
    $.ajax({
        type: 'post',
        url: '{{route('getPlacePicture')}}',
        data: {
            'kindPlaceId': name.kind,
            'placeId': name.id
        },
        success: function (response) {
            name.pic = response;
            name.first = false;
            $("#itemNearbyPic_" + name.id + "_" + name.kind).attr('src', response);
        }
    });
}
</script>

<script>
var app = angular.module("mainApp", ['infinite-scroll'], function ($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});
{{--var placeMode = '{{$placeMode}}';--}}
var data;
var requestURL;
const config = {
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;',
        'X-CSRF-TOKEN': '{{csrf_token()}}'
    }
};
app.controller('LogPhotoController', function ($scope, $http) {
    $scope.places = [];
    {{--$scope.kindPlaceId = '{{$kindPlaceId}}';--}}
    data = $.param({
    {{--placeId: '{{$place->id}}',--}}
    //                kindPlaceId: $scope.kindPlaceId
});
    $scope.ngGetPhotos = function (val) {
        getPhotos(val);
    };
    $scope.myPagingFunction = function () {
        {{--$http.post('{{route('getLogPhotos')}}', data, config).then(function (response) {--}}
            {{--    $scope.logs = response.data;--}}
            {{--}).catch(function (err) {--}}
{{--    console.log(err);--}}
{{--});--}}
};
$scope.$on('myPagingFunctionAPI', function (event) {
    $scope.myPagingFunction();
});
});
app.controller('SimilarController', function ($scope, $http, $rootScope) {
    var title;
    $scope.show = false;
    $scope.places = [];
    if (placeMode == "hotel") {
        this.title = "هتل های مشابه";
        requestURL = '{{route('getSimilarsHotel')}}';
    }
    if (placeMode == "amaken") {
        this.title = "اماکن مشابه";
        requestURL = '{{route('getSimilarsAmaken')}}';
    }
    if (placeMode == "restaurant") {
        this.title = "رستوران های مشابه";
        requestURL = '{{route('getSimilarsRestaurant')}}';
    }
    if (placeMode == "majara") {
        this.title = "ماجراجویی های مشابه";
        requestURL = '{{route('getSimilarsMajara')}}';
    }
    data = $.param({
    {{--placeId: '{{$place->id}}'--}}
});
    $scope.redirect = function (url) {
        document.location.href = url;
    };
    $scope.disable = false;
    $scope.myPagingFunction = function () {
        var scroll = $(window).scrollTop();
        if (scroll < 1200 || $scope.disable)
            return;
        $scope.disable = true;
        $rootScope.$broadcast('myPagingFunctionAPI');
        $rootScope.$broadcast('myPagingFunctionAPINearby');
        $http.post(requestURL, data, config).then(function (response) {
            if (response.data != null && response.data != null && response.data.length > 0)
                $scope.show = true;
            $scope.places = response.data;
            var i;
            for (i = 0; i < response.data.length; i++) {
                if (placeMode == "hotel")
                    $scope.places[i].redirect = '{{ route('home') . '/hotel-details/' }}' + $scope.places[i].id + "/" + $scope.places[i].name;
            else if (placeMode == "amken")
                    $scope.places[i].redirect = '{{ route('home') . '/amaken-details/' }}' + $scope.places[i].id + "/" + $scope.places[i].name;
            else if (placeMode == "restaurant")
                    $scope.places[i].redirect = '{{ route('home') . '/restaurant-details/' }}' + $scope.places[i].id + "/" + $scope.places[i].name;
            else if (placeMode == "majara")
                    $scope.places[i].redirect = '{{ route('home') . '/majara-details/' }}' + $scope.places[i].id + "/" + $scope.places[i].name;
                switch ($scope.places[i].rate) {
                    case 5:
                        $scope.places[i].ngClass = 'ui_bubble_rating bubble_50';
                        break;
                    case 4:
                        $scope.places[i].ngClass = 'ui_bubble_rating bubble_40';
                        break;
                    case 3:
                        $scope.places[i].ngClass = 'ui_bubble_rating bubble_30';
                        break;
                    case 2:
                        $scope.places[i].ngClass = 'ui_bubble_rating bubble_20';
                        break;
                    default:
                        $scope.places[i].ngClass = 'ui_bubble_rating bubble_10';
                }
            }
        }).catch(function (err) {
            console.log(err);
        });
    };
});
var x1 = [];
var y1 = [];
var placeName = [];
var lengthPlace = [];
var kind;
//این متفیر برای تعیین نوع رستوران برای ایکون نقشه است که 1 ایرانی و 0 فست فود است
var kindRest = [];
//این متغیر برای تعیین نوع مکان است
var kindAmaken = [];
app.controller('NearbyController', function ($scope, $http, $rootScope) {
    var kindPlaceId = (placeMode == "hotel") ? 4 : (placeMode == "amaken") ? 1 : 3;
    kind = kindPlaceId;
    data = $.param({
    {{--placeId: '{{$place->id}}',--}}
    kindPlaceId: kindPlaceId
});
    $scope.redirect = function (url) {
        document.location.href = url;
    };
    $scope.hotels = [];
    $scope.amakens = [];
    $scope.restaurants = [];
    $scope.myPagingFunction = function () {
        $http.post('{{route('getNearby')}}', data, config).then(function (response) {
            var i;
            lengthPlace[0] = 0;
            $scope.hotels = response.data[0];
            for (i = 0; i < response.data[0].length; i++) {
                $scope.hotels[i].redirect = '{{ route('home') . '/hotel-details/' }}' + $scope.hotels[i].id + "/" + $scope.hotels[i].name;
                x1[i] = $scope.hotels[i].C;
                y1[i] = $scope.hotels[i].D;
                placeName[i] = $scope.hotels[i].name;
                switch ($scope.hotels[i].rate) {
                    case 5:
                        $scope.hotels[i].ngClass = 'ui_bubble_rating bubble_50';
                        break;
                    case 4:
                        $scope.hotels[i].ngClass = 'ui_bubble_rating bubble_40';
                        break;
                    case 3:
                        $scope.hotels[i].ngClass = 'ui_bubble_rating bubble_30';
                        break;
                    case 2:
                        $scope.hotels[i].ngClass = 'ui_bubble_rating bubble_20';
                        break;
                    default:
                        $scope.hotels[i].ngClass = 'ui_bubble_rating bubble_10';
                }
            }
            lengthPlace[1] = x1.length;
            $scope.amakens = response.data[2];
            for (i = 0; i < response.data[2].length; i++) {
                $scope.amakens[i].redirect = '{{ route('home') . '/amaken-details/' }}' + $scope.amakens[i].id + "/" + $scope.amakens[i].name;
                x1[i + lengthPlace[1]] = $scope.amakens[i].C;
                y1[i + lengthPlace[1]] = $scope.amakens[i].D;
                placeName[i + lengthPlace[1]] = $scope.amakens[i].name;
                if ($scope.amakens[i].mooze == 1)
                    kindAmaken[i] = 1;
                else if ($scope.amakens[i].tarikhi == 1)
                    kindAmaken[i] = 2;
                else if ($scope.amakens[i].tabiatgardi == 1)
                    kindAmaken[i] = 3;
                else if ($scope.amakens[i].tafrihi == 1)
                    kindAmaken[i] = 4;
                else if ($scope.amakens[i].markazkharid == 1)
                    kindAmaken[i] = 5;
                else
                    kindAmaken[i] = 1;
                switch ($scope.amakens[i].rate) {
                    case 5:
                        $scope.amakens[i].ngClass = 'ui_bubble_rating bubble_50';
                        break;
                    case 4:
                        $scope.amakens[i].ngClass = 'ui_bubble_rating bubble_40';
                        break;
                    case 3:
                        $scope.amakens[i].ngClass = 'ui_bubble_rating bubble_30';
                        break;
                    case 2:
                        $scope.amakens[i].ngClass = 'ui_bubble_rating bubble_20';
                        break;
                    default:
                        $scope.amakens[i].ngClass = 'ui_bubble_rating bubble_10';
                }
            }
            $scope.restaurants = response.data[1];
            lengthPlace[2] = x1.length;
            for (i = 0; i < response.data[1].length; i++) {
                $scope.restaurants[i].redirect = '{{ route('home') . '/restaurant-details/' }}' + $scope.restaurants[i].id + "/" + $scope.restaurants[i].name;
                x1[i + lengthPlace[2]] = $scope.restaurants[i].C;
                y1[i + lengthPlace[2]] = $scope.restaurants[i].D;
                placeName[i + lengthPlace[2]] = $scope.restaurants[i].name;
                if ($scope.restaurants[i].kind_id == 1)
                    kindRest[i] = 1;
                else
                    kindRest[i] = 0;
                switch ($scope.restaurants[i].rate) {
                    case 5:
                        $scope.restaurants[i].ngClass = 'ui_bubble_rating bubble_50';
                        break;
                    case 4:
                        $scope.restaurants[i].ngClass = 'ui_bubble_rating bubble_40';
                        break;
                    case 3:
                        $scope.restaurants[i].ngClass = 'ui_bubble_rating bubble_30';
                        break;
                    case 2:
                        $scope.restaurants[i].ngClass = 'ui_bubble_rating bubble_20';
                        break;
                    default:
                        $scope.restaurants[i].ngClass = 'ui_bubble_rating bubble_10';
                }
            }
            lengthPlace[3] = x1.length;
            initBigMap();
        }).catch(function (err) {
            console.log(err);
        });
    };
    $scope.$on('myPagingFunctionAPINearby', function (event) {
        $scope.myPagingFunction();
    });
});
var testhh2 = 1;
var testshow = 1;

function closeDiv(di) {
    if (di == 'nearbyInExtendedMap') {
        if (testhh2 == 1) {
            document.getElementById(di).style.display = 'block';
            document.getElementById('closeNearbyPlaces').style.transform = 'rotate(-90deg)';
            testhh2 = 0;
        }
        else {
            document.getElementById(di).style.display = 'none';
            document.getElementById('closeNearbyPlaces').style.transform = 'rotate(90deg)';
            testhh2 = 1;
        }
    }
    if (di == 'placeInfoInExtendedMap')
        document.getElementById(di).style.display = 'none';
    if (di == 'show') {
        if (testshow == 1) {
            testshow = 0;
            document.getElementById('closeShow').style.transform = 'scaleX(-1)';
            document.getElementById(di).style.display = 'none';
        }
        else {
            testshow = 1;
            document.getElementById('closeShow').style.transform = 'scaleX(1)';
            document.getElementById(di).style.display = 'inline-block';
        }
    }
}

app.controller('nearPlaceRepeat', function ($scope) {
    $scope.findNearPlaceForMap = function (place) {
        if (!isItemClicked)
            return;
        var C = place.C * 3.14 / 180;
        var D = place.D * 3.14 / 180;
        var counter = 0;
        var i;
        if (place.kind == 4) {
            $scope.nearPlaces = [];
            for (i = 0; i < hotelMap.length; i++) {
                if (Math.acos(Math.sin(D) * Math.sin(hotelMap[i].D / 180 * 3.14) + Math.cos(D) * Math.cos(hotelMap[i].D / 180 * 3.14) * Math.cos(hotelMap[i].C / 180 * 3.14 - C)) * 6371 < 1) {
                    $scope.nearPlaces[counter] = hotelMap[i];
                    if ($scope.nearPlaces[counter].first)
                        getJustPic($scope.nearPlaces[counter]);
                    $scope.nearPlaces[counter++].distance = Math.acos(Math.sin(D) * Math.sin(hotelMap[i].D / 180 * 3.14) + Math.cos(D) * Math.cos(hotelMap[i].D / 180 * 3.14) * Math.cos(hotelMap[i].C / 180 * 3.14 - C)) * 6371;
                }
            }
        }
        else if (place.kind == 3) {
            $scope.nearPlaces = [];
            for (i = 0; i < restMap.length; i++) {
                if (Math.acos(Math.sin(D) * Math.sin(restMap[i].D / 180 * 3.14) + Math.cos(D) * Math.cos(restMap[i].D / 180 * 3.14) * Math.cos(restMap[i].C / 180 * 3.14 - C)) * 6371 < 1) {
                    $scope.nearPlaces[counter] = restMap[i];
                    if ($scope.nearPlaces[counter].first)
                        getJustPic($scope.nearPlaces[counter]);
                    $scope.nearPlaces[counter++].distance = Math.acos(Math.sin(D) * Math.sin(restMap[i].D / 180 * 3.14) + Math.cos(D) * Math.cos(restMap[i].D / 180 * 3.14) * Math.cos(restMap[i].C / 180 * 3.14 - C)) * 6371;
                }
            }
        }
        else if (place.kind == 1) {
            $scope.nearPlaces = [];
            for (i = 0; i < amakenMap.length; i++) {
                if (Math.acos(Math.sin(D) * Math.sin(amakenMap[i].D / 180 * 3.14) + Math.cos(D) * Math.cos(amakenMap[i].D / 180 * 3.14) * Math.cos(amakenMap[i].C / 180 * 3.14 - C)) * 6371 < 1) {
                    $scope.nearPlaces[counter] = amakenMap[i];
                    if ($scope.nearPlaces[counter].first)
                        getJustPic($scope.nearPlaces[counter]);
                    $scope.nearPlaces[counter++].distance = Math.acos(Math.sin(D) * Math.sin(amakenMap[i].D / 180 * 3.14) + Math.cos(D) * Math.cos(amakenMap[i].D / 180 * 3.14) * Math.cos(amakenMap[i].C / 180 * 3.14 - C)) * 6371;
                }
            }
        }
        else {
            $scope.nearPlaces = [];
            for (i = 0; i < majaraMap.length; i++) {
                if (Math.acos(Math.sin(D) * Math.sin(majaraMap[i].D / 180 * 3.14) + Math.cos(D) * Math.cos(majaraMap[i].D / 180 * 3.14) * Math.cos(majaraMap[i].C / 180 * 3.14 - C)) * 6371 < 1) {
                    $scope.nearPlaces[counter] = majaraMap[i];
                    if (majaraMap[i].first)
                        getJustPic(majaraMap[i]);
                    $scope.nearPlaces[counter++].distance = Math.acos(Math.sin(D) * Math.sin(majaraMap[i].D / 180 * 3.14) + Math.cos(D) * Math.cos(majaraMap[i].D / 180 * 3.14) * Math.cos(majaraMap[i].C / 180 * 3.14 - C)) * 6371;
                }
            }
        }
        $scope.nearPlaces.sort(function (a, b) {
            return a.distance - b.distance
        });
        for (i = 0; i < $scope.nearPlaces.length; i++) {
            $scope.nearPlaces[i].distance = Math.round($scope.nearPlaces[i].distance * 1000);
            switch ($scope.nearPlaces[i].rate) {
                case 5:
                    $scope.nearPlaces[i].ngClass = 'ui_bubble_rating bubble_50';
                    break;
                case 4:
                    $scope.nearPlaces[i].ngClass = 'ui_bubble_rating bubble_40';
                    break;
                case 3:
                    $scope.nearPlaces[i].ngClass = 'ui_bubble_rating bubble_30';
                    break;
                case 2:
                    $scope.nearPlaces[i].ngClass = 'ui_bubble_rating bubble_20';
                    break;
                default:
                    $scope.nearPlaces[i].ngClass = 'ui_bubble_rating bubble_10';
            }
        }
    };
});
</script>

<script async>
var mod;
mod = angular.module("infinite-scroll", []), mod.directive("infiniteScroll", ["$rootScope", "$window", "$timeout", function (i, n, e) {
    return {
        link: function (t, l, o) {
            var r, c, f, a;
            return n = angular.element(n), f = 0, null != o.infiniteScrollDistance && t.$watch(o.infiniteScrollDistance, function (i) {
                return f = parseInt(i, 10)
            }), a = !0, r = !1, null != o.infiniteScrollDisabled && t.$watch(o.infiniteScrollDisabled, function (i) {
                return a = !i, a && r ? (r = !1, c()) : void 0
            }), c = function () {
                var e, c, u, d;
                return d = n.height() + n.scrollTop(), e = l.offset().top + l.height(), c = e - d, u = n.height() * f >= c, u && a ? i.$$phase ? t.$eval(o.infiniteScroll) : t.$apply(o.infiniteScroll) : u ? r = !0 : void 0
            }, n.on("scroll", c), t.$on("$destroy", function () {
                return n.off("scroll", c)
            }), e(function () {
                return o.infiniteScrollImmediateCheck ? t.$eval(o.infiniteScrollImmediateCheck) ? c() : void 0 : c()
            }, 0)
        }
    }
}])
</script>

<script>
{{--var x = '{{$place->C}}';--}}
{{--var y = '{{$place->D}}';--}}

function initBigMap() {
    var locations = [];
    var k;
    var iconBase = '{{URL::asset('images') . '/'}}';
    var icons = {
        hotel: {
            icon: iconBase + 'mhotel.png'
        },
        amaken1: {
            icon: iconBase + 'matr_pla.png'
        },
        amaken2: {
            icon: iconBase + 'matr_mus.png'
        },
        amaken3: {
            icon: iconBase + 'matr_shc.png'
        },
        amaken4: {
            icon: iconBase + 'matr_nat.png'
        },
        amaken5: {
            icon: iconBase + 'matr_fun.png'
        },
        fastfood: {
            icon: iconBase + 'mfast.png'
        },
        rest: {
            icon: iconBase + 'mrest.png'
        }
    };
    var mapOptions = {
        zoom: 14,
        center: new google.maps.LatLng(x, y),
        // How you would like to style the map.
        // This is where you would paste any style found on Snazzy Maps.
        styles: [{
            "featureType": "landscape",
            "stylers": [{"hue": "#FFA800"}, {"saturation": 0}, {"lightness": 0}, {"gamma": 1}]
        }, {
            "featureType": "road.highway",
            "stylers": [{"hue": "#53FF00"}, {"saturation": -73}, {"lightness": 40}, {"gamma": 1}]
        }, {
            "featureType": "road.arterial",
            "stylers": [{"hue": "#FBFF00"}, {"saturation": 0}, {"lightness": 0}, {"gamma": 1}]
        }, {
            "featureType": "road.local",
            "stylers": [{"hue": "#00FFFD"}, {"saturation": 0}, {"lightness": 30}, {"gamma": 1}]
        }, {
            "featureType": "water",
            "stylers": [{"hue": "#00BFFF"}, {"saturation": 6}, {"lightness": 8}, {"gamma": 1}]
        }, {
            "featureType": "poi",
            "stylers": [{"hue": "#679714"}, {"saturation": 33.4}, {"lightness": -25.4}, {"gamma": 1}]
        }]
    };
    // Get the HTML DOM element that will contain your map
    // We are using a div with id="map" seen below in the <body>
//            var mapElement = document.getElementById('map');
    // Create the Google Map using our element and options defined above
//            var map = new google.maps.Map(mapElement, mapOptions);
    // Let's also add a marker while we're at it for big map
//            switch (kind) {
//                case 4:
//                    k = 'hotel';
//                    break;
//                case 1:
    {{--if ('{{ $place->mooze }}' == 1)--}}
    {{--k = 'amaken2';--}}
    {{--else if ('{{ $place->tarikhi }}' == 1)--}}
    {{--k = 'amaken1';--}}
    {{--else if ('{{ $place->tabiatgardi }}' == 1)--}}
    {{--k = 'amaken4';--}}
    {{--else if ('{{ $place->tafrihi }}' == 1)--}}
    {{--k = 'amaken5';--}}
    {{--else if ('{{ $place->markazkharid }}' == 1)--}}
    {{--k = 'amaken3';--}}
    {{--else--}}
    {{--k = 'amaken1';--}}
    {{--break;--}}
    {{--case 3:--}}
    {{--if ('{{$place->kind_id}}' == 1)--}}
    {{--k = 'rest';--}}
    {{--else--}}
    {{--k = 'fastfood';--}}
    {{--break;--}}
    //            }
    {{--locations[0] = {positions: new google.maps.LatLng(x, y), name: '{{ $place->name }}', type: k};--}}
    for (j = 0; j < 3; j++) {
        var number = 0;
        for (i = lengthPlace[j]; i < lengthPlace[j + 1]; i++) {
            if (j == 0)
                k = 'hotel';
            if (j == 2 && kindRest[number] == 1) {
                k = 'rest';
                number++;
            }
            else if (j == 2) {
                k = 'fastfood';
                number++;
            }
            if (j == 1) {
                switch (kindAmaken[number]) {
                    case 1:
                        k = 'amaken2';
                        break;
                    case 2:
                        k = 'amaken1';
                        break;
                    case 3:
                        k = 'amaken4';
                        break;
                    case 4:
                        k = 'amaken5';
                        break;
                    case 5:
                        k = 'amaken3';
                        break;
                }
                number++;
            }
            locations[i + 1] = {
                positions: new google.maps.LatLng(x1[i], y1[i]),
                name: placeName[i],
                type: k
            };
        }
        locations.forEach(function (location) {
            var marker = new google.maps.Marker({
                position: location.positions,
                icon: {
                    url: icons[location.type].icon,
                    scaledSize: new google.maps.Size(35, 35)
                },
                map: map,
                title: location.name
            });
        });
    }
}

function init() {
    {{--var x = '{{$place->C}}';--}}
    {{--var y = '{{$place->D}}';--}}
    {{--var place_name = '{{ $place->name }}';--}}
    var mapOptions = {
        zoom: 14,
        center: new google.maps.LatLng(x, y),
        // How you would like to style the map.
        // This is where you would paste any style found on Snazzy Maps.
        styles: [{
            "featureType": "landscape",
            "stylers": [{"hue": "#FFA800"}, {"saturation": 0}, {"lightness": 0}, {"gamma": 1}]
        }, {
            "featureType": "road.highway",
            "stylers": [{"hue": "#53FF00"}, {"saturation": -73}, {"lightness": 40}, {"gamma": 1}]
        }, {
            "featureType": "road.arterial",
            "stylers": [{"hue": "#FBFF00"}, {"saturation": 0}, {"lightness": 0}, {"gamma": 1}]
        }, {
            "featureType": "road.local",
            "stylers": [{"hue": "#00FFFD"}, {"saturation": 0}, {"lightness": 30}, {"gamma": 1}]
        }, {
            "featureType": "water",
            "stylers": [{"hue": "#00BFFF"}, {"saturation": 6}, {"lightness": 8}, {"gamma": 1}]
        }, {
            "featureType": "poi",
            "stylers": [{"hue": "#679714"}, {"saturation": 33.4}, {"lightness": -25.4}, {"gamma": 1}]
        }]
    };
    // Get the HTML DOM element that will contain your map
    // We are using a div with id="map" seen below in the <body>
    var mapElementSmall = document.getElementById('map-small');
    // Create the Google Map using our element and options defined above
    var map2 = new google.maps.Map(mapElementSmall, mapOptions);
    // Let's also add a marker while we're at it smal map
    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(x, y),
        map: map2,
        title: place_name
    });
}
</script>

<script src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyCdVEd4L2687AfirfAnUY1yXkx-7IsCER0&callback=init"></script>
    <script async src="{{URL::asset('js/album.js')}}"></script>

    <script>
    {{--var totalPhotos = '{{$sitePhotos + $userPhotos}}';--}}
{{--var sitePhotosCount = '{{$sitePhotos}}';--}}
{{--var hasLogin = '{{$hasLogin}}';--}}
{{--var bookMarkDir = '{{route('bookMark')}}';--}}
{{--var getPlaceTrips = '{{route('placeTrips')}}';--}}
{{--            var assignPlaceToTripDir = '{{route('assignPlaceToTrip')}}';--}}
{{--var placeMode = '{{$placeMode}}';--}}
{{--var placeId = '{{$place->id}}';--}}
{{--var kindPlaceId = '{{$kindPlaceId}}';--}}

{{--var soon = '{{route('soon')}}';--}}
{{--var hotelDetails;--}}
{{--var hotelDetailsInBookMarkMode;--}}
{{--var hotelDetailsInAskQuestionMode;--}}
{{--var hotelDetailsInAnsMode;--}}
{{--var hotelDetailsInSaveToTripMode;--}}
{{--var getQuestions = '{{route('getQuestions')}}';--}}
{{--var getCommentsCount = '{{route('getCommentsCount')}}';--}}
{{--var opOnComment = '{{route('opOnComment')}}';--}}
{{--var askQuestionDir = '{{route('askQuestion')}}';--}}
{{--var sendAnsDir = '{{route('sendAns')}}';--}}
{{--var showAllAnsDir = '{{route('showAllAns')}}';--}}
{{--var filterComments = '{{route('filterComments')}}';--}}
{{--var getReportsDir = '{{route('getReports')}}';--}}
{{--var sendReportDir = '{{route('sendReport2')}}';--}}
{{--var getPhotoFilter = '{{route('getPhotoFilter')}}';--}}
{{--var getPhotosDir = '{{route('getPhotos')}}';--}}
{{--var showUserBriefDetail = '{{route('showUserBriefDetail')}}';--}}
{{--var homePath = '{{route('home')}}';--}}
{{--var hotelDetailsInAddPhotoMode = '{{route('hotelDetails', ['placeId' => $place->id, 'placeName' => $place->name, 'mode' => 'addPhoto'])}}';--}}
</script>

<script>
var selectedPlaceId = -1;
var selectedKindPlaceId = -1;
var currPage = 1;
var currPageQuestions = 1;
var selectedTag = "";
var roundRobinPhoto;
var roundRobinPhoto2;
var selectedTrips;
var currHelpNo;
var noAns = false;
var photos = [];
var photos2 = [];

function saveToTrip() {
    if (!hasLogin) {
        showLoginPrompt(hotelDetailsInSaveToTripMode);
        return;
    }
    selectedPlaceId = placeId;
    selectedKindPlaceId = kindPlaceId;
    $.ajax({
        type: 'post',
        url: getPlaceTrips,
        data: {
            'placeId': placeId,
            'kindPlaceId': kindPlaceId
        },
        success: function (response) {
            selectedTrips = [];
            $('.dark').show();
            response = JSON.parse(response);
            var newElement = "<div class='row'>";
            for (i = 0; i < response.length; i++) {
                newElement += "<div class='col-xs-3' style='cursor: pointer' onclick='addToSelectedTrips(\"" + response[i].id + "\")'>";
                if (response[i].select == "1") {
                    newElement += "<div id='trip_" + response[i].id + "' style='width: 150px; height: 150px; border: 2px solid var(--koochita-light-green);cursor: pointer;' onclick='' class='trip-images ui_columns is-gapless is-multiline is-mobile'>";
                    selectedTrips[selectedTrips.length] = response[i].id;
                }
                else
                    newElement += "<div id='trip_" + response[i].id + "' style='width: 150px; height: 150px; border: 2px solid #a0a0a0;cursor: pointer;' onclick='' class='trip-images ui_columns is-gapless is-multiline is-mobile'>";
                if (response[i].placeCount > 0) {
                    tmp = "url('" + response[i].pic1 + "')";
                    newElement += "<div class='trip-image ui_column is-6' style='background: " + tmp + " repeat 0 0; background-size: 100% 100%'></div>";
                }
                else
                    newElement += "<div class='trip-image trip-image-empty ui_column is-6' style='background-color: #cfcfcf'></div>";
                if (response[i].placeCount > 1) {
                    tmp = "url('" + response[i].pic2 + "')";
                    newElement += "<div class='trip-image ui_column is-6' style='background: " + tmp + " repeat 0 0; background-size: 100% 100%'></div>";
                }
                else
                    newElement += "<div class='trip-image trip-image-empty ui_column is-6' style='background-color: #cfcfcf'></div>";
                if (response[i].placeCount > 1) {
                    tmp = "url('" + response[i].pic3 + "')";
                    newElement += "<div class='trip-image ui_column is-6' style='background: " + tmp + " repeat 0 0; background-size: 100% 100%'></div>";
                }
                else
                    newElement += "<div class='trip-image trip-image-empty ui_column is-6' style='background-color: #cfcfcf'></div>";
                if (response[i].placeCount > 1) {
                    tmp = "url('" + response[i].pic4 + "')";
                    newElement += "<div class='trip-image ui_column is-6' style='background: " + tmp + " repeat 0 0; background-size: 100% 100%'></div>";
                }
                else
                    newElement += "<div class='trip-image trip-image-empty ui_column is-6' style='background-color: #cfcfcf'></div>";
                newElement += "</div><div class='create-trip-text' style='font-size: 1.2em;'>" + response[i].name + "</div>";
                newElement += "</div>";
            }
            newElement += "<div class='col-xs-3'>";
            newElement += "<a onclick='showPopUp()' class='single-tile is-create-trip'>";
            newElement += "<div class='tile-content' style='font-size: 20px !important; text-align: center'>";
            newElement += "<span class='ui_icon plus'></span>";
            newElement += "<div class='create-trip-text'>ایجاد سفر</div>";
            newElement += "</div></a></div>";
            newElement += "</div>";
            $("#tripsForPlace").empty().append(newElement);
            showElement('addPlaceToTripPrompt');
        }
    });
}

function showElement(element) {
    $(".pop-up").addClass('hidden');
    $("#" + element).removeClass('hidden');
}

function hideElement(element) {
    $(".dark").hide();
    $("#" + element).addClass('hidden');
}


function addToSelectedTrips(id) {
    allow = true;
    for (i = 0; i < selectedTrips.length; i++) {
        if (selectedTrips[i] == id) {
            allow = false;
            $("#trip_" + id).css('border', '2px solid #a0a0a0');
            selectedTrips.splice(i, 1);
            break;
        }
    }
    if (allow) {
        $("#trip_" + id).css('border', '2px solid var(--koochita-light-green)');
        selectedTrips[selectedTrips.length] = id;
    }
}

function assignPlaceToTrip() {
    if (selectedPlaceId != -1) {
        var checkedValuesTrips = selectedTrips;
        if (checkedValuesTrips == null || checkedValuesTrips.length == 0)
            checkedValuesTrips = "empty";
        $.ajax({
            type: 'post',
            url: assignPlaceToTripDir,
            data: {
                'checkedValuesTrips': checkedValuesTrips,
                'placeId': selectedPlaceId,
                'kindPlaceId': selectedKindPlaceId
            },
            success: function (response) {
                if (response == "ok")
                    document.location.href = hotelDetails;
                else {
                    err = "<p>به جز سفر های زیر که اجازه ی افزودن مکان به آنها را نداشتید بقیه به درستی اضافه شدند</p>";
                    response = JSON.parse(response);
                    for (i = 0; i < response.length; i++)
                        err += "<p>" + response[i] + "</p>";
                    $("#errorAssignPlace").append(err);
                }
            }
        });
    }
}

function showUpdateReserveResult() {
    $(".update_results_button").removeClass('hidden');
}

function showChildBox(val, childAge) {
    var newElement = "";
    for (i = 0; i < val; i++) {
        newElement += "<span class='unified-picker age-picker'><select id='child_" + (i + 1) + "'>";
        newElement += "<option value='none'>سن</option>";
        for (j = 1; j <= childAge; j++) {
            newElement += "<option value='" + j + "'>" + j + "</option>";
        }
        newElement += "</select></span>";
    }
    $("#ages-wrap").empty().append(newElement);
}

function changeCommentPage(element) {
    $('.pageNumComment').removeClass('current').addClass('taLnk');
    $(element).removeClass('taLnk');
    $(element).addClass('current');
    if ($(element).attr('data-page-number')) {
        currPage = $(element).attr('data-page-number');
        comments(selectedTag);
        location.href = "#taplc_location_review_keyword_search_hotels_0_search";
    }
}

function changePageQuestion(element) {
    $('.pageNumComment').removeClass('current').addClass('taLnk');
    $(element).removeClass('taLnk');
    $(element).addClass('current');
    if ($(element).attr('data-page-number')) {
        currPageQuestions = $(element).attr('data-page-number');
        questions();
        location.href = "#taplc_location_qa_hotels_0";
    }
}

function showAskQuestion() {
    if (!hasLogin) {
        showLoginPrompt(hotelDetailsInAskQuestionMode);
        return;
    }
    $(".askQuestionForm").removeClass('hidden');
    document.href = ".askQuestionForm";
}

function hideAskQuestion() {
    $(".askQuestionForm").addClass('hidden');
}

function askQuestion() {
    if (!hasLogin) {
        showLoginPrompt(hotelDetailsInAskQuestionMode);
        return;
    }
    if ($("#questionTextId").val() == "")
        return;
    $.ajax({
        type: 'post',
        url: askQuestionDir,
        data: {
            'placeId': placeId,
            'kindPlaceId': kindPlaceId,
            'text': $("#questionTextId").val()
        },
        success: function (response) {
            if (response == "ok") {
                $(".dark").css('display', '');
                $("#questionSubmitted").removeClass('hidden');
            }
        }
    });
}


function comments(tag) {
    selectedTag = tag;
    filter();
}

function questions() {
    $.ajax({
        type: 'post',
        url: getQuestions,
        data: {
            'placeId': placeId,
            'kindPlaceId': kindPlaceId,
            'page': currPageQuestions
        },
        success: function (response) {
            showQuestions(JSON.parse(response));
        }
    });
}

$(window).ready(function () {

    {{--@foreach($sections as $section)--}}
    {{--fillMyDivWithAdv('{{$section->sectionId}}', '{{$state->id}}');--}}
    {{--@endforeach--}}

    checkOverFlow();
    $('.menu').addClass('original').clone().insertAfter('.menu').addClass('cloned').css('position', 'fixed').css('top', '0').css('margin-top', '0').css('z-index', '500').removeClass('original').hide();
    scrollIntervalID = setInterval(stickIt, 10);
    $(".close_album").click(function () {
        $("#photo_album_span").hide();
    });
    var i;
    {{--photos[0] = '{{$photos[0]}}';--}}
    //            for (i = 1; i < totalPhotos; i++)
    //                photos[i] = -1;
    //            for (i = 1; i < totalPhotos - sitePhotosCount; i++)
    //                photos2[i] = -1;
    currPage = 1;
    comments(-1);
    questions();
    roundRobinPhoto = -1;
    photoRoundRobin(1);
    if (totalPhotos - sitePhotosCount > 0) {
        roundRobinPhoto2 = -1;
        photoRoundRobin2(1);
    }
    $(".img_popUp").on({
        mouseenter: function () {
            $(".img_popUp").removeClass('hidden');
        },
        mouseleave: function () {
            $(".img_popUp").addClass('hidden');
        }
    });
    $('.ui_tagcloud').click(function () {
        $(".ui_tagcloud").removeClass('selected');
        $(this).addClass("selected");
        if ($(this).attr("data-content")) {
            var data_content = $(this).attr("data-content");
            currPage = 1;
            comments(data_content);
        }
    });
});

{{--function getSliderPhoto(mode, val, mode2) {--}}
    {{--    var url = (mode2 == 2) ? '{{route('getSlider2Photo')}}' : '{{route('getSlider1Photo')}}';--}}
    {{--    $.ajax({--}}
        {{--        type: 'post',--}}
        {{--        url: url,--}}
        {{--        data: {--}}
            {{--            --}}{{--'placeId': '{{$place->id}}',--}}
            {{--                    --}}{{--'kindPlaceId': '{{$kindPlaceId}}',--}}
            {{--            'val': val--}}
            {{--        },--}}
        {{--        success: function (response) {--}}
            {{--            if (response != "nok") {--}}
                {{--                if (mode == 1) {--}}
                    {{--                    photos[roundRobinPhoto] = response;--}}
                    {{--                    $(".carousel_images_header").css('background', "url(" + photos[roundRobinPhoto] + ") no-repeat")--}}
                    {{--                            .css('background-size', "cover");--}}
                    {{--                }--}}
                {{--                else {--}}
                    {{--                    photos2[roundRobinPhoto2] = response;--}}
                    {{--                    $(".carousel_images_footer").css('background', "url(" + photos2[roundRobinPhoto2] + ") no-repeat")--}}
                    {{--                            .css('background-size', "cover");--}}
                    {{--                }--}}
                {{--            }--}}
            {{--        }--}}
        {{--    });--}}
{{--}--}}

function photoRoundRobin(val) {
    if (roundRobinPhoto + val < totalPhotos && roundRobinPhoto + val >= 0)
        roundRobinPhoto += val;
    if (photos[roundRobinPhoto] != -1) {
        $(".carousel_images_header").css('background', "url(" + photos[roundRobinPhoto] + ") no-repeat")
            .css('background-size', "cover");
    }
    else {
        if (roundRobinPhoto + 1 <= sitePhotosCount)
            getSliderPhoto(1, roundRobinPhoto + 1, 1);
        else
            getSliderPhoto(1, roundRobinPhoto + 1 - sitePhotosCount, 2);
    }
    if (roundRobinPhoto + 1 >= totalPhotos)
        $('.right-nav-header').addClass('hidden');
    else
        $('.right-nav-header').removeClass('hidden');
    if (roundRobinPhoto - 1 < 0)
        $('.left-nav-header').addClass('hidden');
    else
        $('.left-nav-header').removeClass('hidden');
}

function photoRoundRobin2(val) {
    if (roundRobinPhoto2 + val < totalPhotos - sitePhotosCount && roundRobinPhoto2 + val >= 0)
        roundRobinPhoto2 += val;
    if (photos2[roundRobinPhoto2] != -1) {
        $(".carousel_images_footer").css('background', "url(" + photos2[roundRobinPhoto2] + ") no-repeat")
            .css('background-size', "cover");
    }
    else {
        getSliderPhoto(2, roundRobinPhoto2, 2);
    }
    if (roundRobinPhoto2 + 1 >= totalPhotos - sitePhotosCount)
        $('.right-nav-footer').addClass('hidden');
    else
        $('.right-nav-footer').removeClass('hidden');
    if (roundRobinPhoto2 - 1 < 0)
        $('.left-nav-footer').addClass('hidden');
    else
        $('.left-nav-footer').removeClass('hidden');
}

function showComments(arr) {
    $("#reviewsContainer").empty();
    var checkedValues = $("input:checkbox[name='filterComment[]']:checked").map(function () {
        return this.value;
    }).get();
    if (checkedValues.length == 0)
        checkedValues = -1;
    $.ajax({
        type: 'post',
        url: getCommentsCount,
        data: {
            'placeId': placeId,
            'kindPlaceId': kindPlaceId,
            'tag': selectedTag,
            'filters': checkedValues
        },
        success: function (response) {
            response = JSON.parse(response);
            $(".seeAllReviews").empty().append(response[1] + " نقد");
            $(".reviews_header_count").empty().append("(" + response[1] + " نقد)");
            var newElement = "<p id='pagination-details' class='pagination-details' style='clear: both; padding: 12px 0 !important;'><b>" + response[0] + "</b> از <b>" + response[1] + "</b> نقد</p>";
            {{--if (response[1] == 0) {--}}
                {{--tmp = "<p style='font-size: 15px; color: #b7b7b7; float: right; margin: 8px 5px 8px 20px !important'>اولین نفری باشید که درباره ی این مکان نقد می نویسید</p>";--}}
                {{--tmp += "<span style='color: #FFF !important; max-width: 100px; float: right;' onclick='document.location.href = showAddReviewPageHotel('{{route('review', ['placeId' => $place->id, 'kindPlaceId' => $kindPlaceId])}}')' class='button_war write_review ui_button primary col-xs-12'>نوشتن نقد</span>";--}}
                {{--$("#reviewsContainer").empty().append(tmp);--}}
                {{--}--}}
            for (i = 0; i < arr.length; i++) {
                newElement += "<div style='border-bottom: 1px solid #E3E3E3;' class='review'>";
                newElement += "<div class='prw_rup prw_reviews_basic_review_hsx'>";
                newElement += "<div class='reviewSelector'>";
                newElement += "<div class='review hsx_review ui_columns is-multiline inlineReviewUpdate provider0'>";
                newElement += "<div class='ui_column is-2' style='float: right;'>";
                newElement += "<div class='prw_rup prw_reviews_member_info_hsx'>";
                newElement += "<div class='member_info'>";
                newElement += "<div class='avatar_wrap'>";
                newElement += "<div class='prw_rup prw_common_centered_image qa_avatar' onmouseleave='$(\".img_popUp\").addClass(\"hidden\");' onmouseenter='showBriefPopUp(this, \"" + arr[i].visitorId + "\")'>";
                newElement += "<span class='imgWrap fixedAspect' style='max-width:80px; padding-bottom:100.000%'>";
                newElement += "<img src='" + arr[i].visitorPic + "' class='centeredImg' height='100%' style='border-radius: 100%;'/>";
                newElement += "</span></div>";
                newElement += "<div class='username' style='text-align: center;margin-top: 5px;'>" + arr[i].visitorId + "</div>";
                newElement += "</div>";
                newElement += "<div class='memberOverlayLink'>";
                newElement += "<div class='memberBadgingNoText'><span class='ui_icon pencil-paper'></span><span class='badgetext'>" + arr[i].comments + "</span>&nbsp;&nbsp;";
                newElement += "<span class='ui_icon thumbs-up-fill'></span><span id='commentLikes_" + arr[i].id + "' data-val='" + arr[i].likes + "' class='badgetext'>" + arr[i].likes + "</span>&nbsp;&nbsp;";
                newElement += "<span class='ui_icon thumbs-down-fill'></span><span id='commentDislikes_" + arr[i].id + "' data-val='" + arr[i].dislikes + "' class='badgetext'>" + arr[i].dislikes + "</span>";
                newElement += "</div>";
                newElement += "</div></div></div></div>";
                newElement += "<div class='ui_column is-9' style='float: right;'>";
                newElement += "<div class='innerBubble'>";
                newElement += "<div class='wrap'>";
                newElement += "<div class='rating reviewItemInline'>";
                switch (arr[i].rate) {
                    case 5:
                        newElement += "<span class='ui_bubble_rating bubble_50'></span>";
                        break;
                    case 4:
                        newElement += "<span class='ui_bubble_rating bubble_40'></span>";
                        break;
                    case 3:
                        newElement += "<span class='ui_bubble_rating bubble_30'></span>";
                        break;
                    case 2:
                        newElement += "<span class='ui_bubble_rating bubble_20'></span>";
                        break;
                    default:
                        newElement += "<span class='ui_bubble_rating bubble_10'></span>";
                        break;
                }
                newElement += "<span class='ratingDate relativeDate' style='float: right;'>نوشته شده در تاریخ " + arr[i].date + " </span></div>";
                newElement += "<div class='quote isNew'><a href='" + homePath + "/showReview/" + arr[i].id + "'><h2 style='font-size: 1em;' class='noQuotes'>" + arr[i].subject + "</h2></a></div>";
                newElement += "<div class='prw_rup prw_reviews_text_summary_hsx'>";
                newElement += "<div class='entry'>";
                newElement += "<p class='partial_entry' id='partial_entry_" + arr[i].id + "' style='line-height: 20px; max-height: 70px; overflow: hidden; padding: 10px; font-size: 12px'>" + arr[i].text;
                newElement += "</p>";
                newElement += "<div style='color: #16174f;cursor: pointer;text-align: left;' id='showMoreReview_" + arr[i].id + "' class='hidden' onclick='showMoreReview(" + arr[i].id + ")'>بیشتر</div></div></div>";
                if (arr[i].pic != -1)
                    newElement += "<div><img id='reviewPic_" + arr[i].id + "' class='hidden' width='150px' height='150px' src='" + arr[i].pic + "'></div>";
                newElement += "<div class='prw_rup prw_reviews_vote_line_hsx'>";
                newElement += "<div class='tooltips wrap'><span style='cursor: pointer;font-size: 10px;color: #16174f' onclick='showReportPrompt(\"" + arr[i].id + "\")' class='taLnk no_cpu ui_icon '>گزارش تخلف</span></div>";
                newElement += "<div class='helpful redesigned hsx_helpful'>";
                newElement += "<span onclick='likeComment(\"" + arr[i].id + "\")' class='thankButton hsx_thank_button'>";
                newElement += "<span class='helpful_text'><span class='ui_icon thumbs-up-fill emphasizeWithColor'></span><span class='numHelp emphasizeWithColor'></span><span class='thankUser'>" + arr[i].visitorId + " </span></span>";
                newElement += "<div class='buttonShade hidden'><img src='https://static.tacdn.com/img2/generic/site/loading_anim_gry_sml.gif'/></div>";
                newElement += "</span>";
                newElement += "<span onclick='dislikeComment(\"" + arr[i].id + "\")' class='thankButton hsx_thank_button'>";
                newElement += "<span class='helpful_text'><span class='ui_icon thumbs-down-fill emphasizeWithColor'></span><span class='numHelp emphasizeWithColor'></span><span class='thankUser'>" + arr[i].visitorId + " </span></span>";
                newElement += "<div class='buttonShade hidden'><img src='https://static.tacdn.com/img2/generic/site/loading_anim_gry_sml.gif'/></div>";
                newElement += "</span>";
                newElement += "</div></div></div>";
                newElement += "<div class='loadingShade hidden'>";
                newElement += "<div class='ui_spinner'></div></div></div></div></div></div></div></div>";
            }
            $("#reviewsContainer").append(newElement);
            for (i = 0; i < arr.length; i++) {
                scrollHeight = $("#partial_entry_" + arr[i].id).prop('scrollHeight');
                offsetHeight = $("#partial_entry_" + arr[i].id).prop('offsetHeight');
                if (offsetHeight < scrollHeight) {
                    $('#showMoreReview_' + arr[i].id).removeClass('hidden');
                }
                else {
                    $('#showMoreReview_' + arr[i].id).addClass('hidden');
                }
            }
            newElement = "";
            limit = Math.ceil(response[0] / 6);
            preCurr = passCurr = false;
            for (k = 1; k <= limit; k++) {
                if (Math.abs(currPage - k) < 4 || k == 1 || k == limit) {
                    if (k == currPage) {
                        newElement += "<span data-page-number='" + k + "' class='pageNum current pageNumComment'>" + k + "</span>";
                    }
                    else {
                        newElement += "<a onclick='changeCommentPage(this)' data-page-number='" + k + "' class='pageNum taLnk pageNumComment'>" + k + "</a>";
                    }
                }
                else if (k < currPage && !preCurr) {
                    preCurr = true;
                    newElement += "<span class='separator'>&hellip;</span>";
                }
                else if (k > currPage && !passCurr) {
                    passCurr = true;
                    newElement += "<span class='separator'>&hellip;</span>";
                }
            }
            $("#pageNumCommentContainer").empty().append(newElement);
            if ($("#commentCount").empty())
                $("#commentCount").append(response[1]);
        }
    });
}

function startHelp() {
    setGreenBackLimit(7);
    if (hasLogin) {
        if (noAns)
            initHelp2(16, [0, 4, 15], 'MAIN', 100, 400, [14, 15], [50, 100]);
        else
            initHelp2(16, [0, 4], 'MAIN', 100, 400, [15], [100]);
    }
    else {
        if (noAns)
            initHelp2(16, [0, 1, 2, 5, 8, 15], 'MAIN', 100, 400, [14, 15], [50, 100]);
        else
            initHelp2(16, [0, 1, 2, 5, 8], 'MAIN', 100, 400, [15], [100]);
    }
}

function showQuestions(arr) {
    $("#questionsContainer").empty();
    if (arr.length == 0) {
        noAns = true;
        $("#questionsContainer").append('<p class="no-question">با پرسیدن اولین سوال، از دوستان خود کمک بگیرید و به دیگران کمک کنید. سوال شما فقط به اندازه یک کلیک وقت می گیرد</p>');
    }

    var newElement;

    for (i = 0; i < arr.length; i++) {
        newElement = "<div class='ui_column is-12' style='position: relative'><div class='ui_column is-2' style='float: right;'>";
        newElement += "<div class='avatar_wrap'>";
        newElement += "<div class='prw_rup prw_common_centered_image qa_avatar' onmouseleave='$(\".img_popUp\").addClass(\"hidden\");' onmouseenter='showBriefPopUp(this, \"" + arr[i].visitorId + "\")'>";
        newElement += "<span class='imgWrap fixedAspect' style='max-width:80px; padding-bottom:100.000%'>";
        newElement += "<img src='" + arr[i].visitorPic + "' class='centeredImg' height='100%'/>";
        newElement += "</span></div>";
        newElement += "<div class='username'>" + arr[i].visitorId + "</div>";
        newElement += "</div></div>";
        newElement += "<div class='ui_column is-8' style='position: relative'><a href='" + homePath + "/seeAllAns/" + arr[i].id + "'>" + arr[i].text + "</a>";
        newElement += "<div class='question_date'>" + arr[i].date + "<span class='iapSep'>|</span><span style='cursor: pointer;font-size:10px;' onclick='showReportPrompt(\"" + arr[i].id + "\")' class='ui_icon'>گزارش تخلف</span></div>";
        if (i == 0) {
            newElement += "<div id='targetHelp_15' style='max-width: 100px; margin: 0 !important; float: right;' class='targets row'><span class='col-xs-12 ui_button primary small answerButton' onclick='showAnsPane(\"" + arr[i].id + "\")'>پاسخ ";
            newElement += "</span>";
            newElement += '<div id="helpSpan_15" class="helpSpans hidden">';
            newElement += '<span class="introjs-arrow"></span>';
            newElement += "<p>";
            newElement += "می توانید با این دکمه به سوال ها پاسخ دهید تا دوستا ن تان هم به سوالات شما پاسخ دهند.";
            newElement += "</p>";
            newElement += '<button data-val="15" class="btn btn-success nextBtnsHelp" id="nextBtnHelp_15">بعدی</button>';
            newElement += '<button onclick="show(14, -1)" data-val="15" class="btn btn-primary backBtnsHelp" id="backBtnHelp_15">قبلی</button>';
            newElement += '<button onclick="myQuit();" class="btn btn-danger exitBtnHelp">خروج</button>';
            newElement += '</div>';
            newElement += "</div>";
        }
        else {
            newElement += "<span class='ui_button primary small answerButton' style='float: right;' onclick='showAnsPane(\"" + arr[i].id + "\")'>پاسخ ";
            newElement += "</span>";
        }
        newElement += "<span style='float: right; margin-top: 12px' class='ui_button secondary small' id='showAll_" + arr[i].id + "' onclick='showAllAns(\"" + arr[i].id + "\", -1)'>نمایش " + arr[i].ansNum + " جواب</span> ";
        newElement += "<span class='ui_button secondary small hidden' id='hideAll_" + arr[i].id + "' onclick='showAllAns(\"" + arr[i].id + "\", 1)'>پنهان کردن جواب ها</span>";
        newElement += "<div class='confirmDeleteExplanation hidden'>آیا می خواهی این سوال حذف شود ؟</div>";
        newElement += "<span class='ui_button primary small delete hidden'>Delete</span>";
        newElement += "<span class='ui_button primary small confirmDelete hidden'>Confirm</span>";
        newElement += "<span class='ui_button secondary small cancelDelete hidden'>Cancel</span>";
        newElement += "<div class='answerForm hidden' id='answerForm_" + arr[i].id + "'>";
        newElement += "<div class='whatIsYourAnswer'>جواب شما چیست ؟</div>";
        newElement += "<textarea class='answerText ui_textarea' id='answerText_" + arr[i].id + "' placeholder='سلام ، جواب خود را وارد کنید'></textarea>";
        newElement += "<ul class='errors hidden'></ul>";
        newElement += "<a target='_blank' href='" + soon + "' class='postingGuidelines' style='float: left;'>راهنما  و قوانین</a>";
        newElement += "<div><span class='ui_button primary small formSubmit' onclick='sendAns(\"" + arr[i].id + "\")'>ارسال</span>";
        newElement += "<span class='ui_button secondary small' onclick='hideAnsPane()'>لغو</span></div>";
        newElement += "<div class='captcha_here'></div>";
        newElement += "</div>";
        newElement += "<div id='response_" + arr[i].id + "' class='answerList hidden' style='clear:both !important;'>";
        newElement += "</div><p id='ans_err_" + arr[i].id + "'></p></div></div><div style='clear: both;'></div> ";
        $("#questionsContainer").append(newElement);
    }
    $("#pageNumQuestionContainer").empty();
    // newElement = "";
    // limit = Math.ceil(response[0] / 6);
    // preCurr = passCurr = false;
    //
    // for(k = 1; k <= limit; k++) {
    //     if(Math.abs(currPageQuestions - k) < 4 || k == 1 || k == limit) {
    //         if (k == currPageQuestions) {
    //             newElement += "<span data-page-number='" + k + "' class='pageNum current pageNumQuestion'>" + k + "</span>";
    //         }
    //         else {
    //             newElement += "<a onclick='changePageQuestion(this)' data-page-number='" + k + "' class='pageNum taLnk pageNumQuestion'>" + k + "</a>";
    //         }
    //     }
    //     else if(k < currPage && !preCurr) {
    //         preCurr = true;
    //         newElement += "<span class='separator'>&hellip;</span>";
    //     }
    //     else if(k > currPage && !passCurr) {
    //         passCurr = true;
    //         newElement += "<span class='separator'>&hellip;</span>";
    //     }
    // }
    //
    // $("#pageNumQuestionContainer").append(newElement);
}

function toggleMoreCities() {
    if ($('#moreCities').hasClass('hidden')) {
        $('#moreCities').removeClass('hidden');
        $('#moreLessSpan').empty().append('شهر های کمتر');
    }
    else {
        $('#moreCities').addClass('hidden');
        $('#moreLessSpan').empty().append('شهر های بیشتر');
    }
}

function customReport() {
    if ($("#custom-checkBox").is(':checked')) {
        var newElement = "<div class='col-xs-12'>";
        newElement += "<textarea id='customDefinedReport' style='width: 375px; height:120px; padding: 5px !important; margin-top: 5px;' maxlength='1000' required placeholder='حداکثر 1000 کاراکتر'></textarea>";
        newElement += "</label></div>";
        $("#custom-define-report").empty().append(newElement).css("visibility", "visible");
    }
    else {
        $("#custom-define-report").empty().css("visibility", "hidden");
    }
}

function getReports(logId) {
    $("#reports").empty();
    $.ajax({
        type: 'post',
        url: getReportsDir,
        data: {
            'logId': logId
        },
        success: function (response) {
            if (response != "")
                response = JSON.parse(response);
            var newElement = "<div id='reportContainer' class='row'>";
            if (response != "") {
                for (i = 0; i < response.length; i++) {
                    newElement += "<div class='col-xs-12'>";
                    newElement += "<div class='ui_input_checkbox'>";
                    if (response[i].selected == true)
                        newElement += "<input id='report_" + response[i].id + "' type='checkbox' name='reports' checked value='" + response[i].id + "'>";
                    else
                        newElement += "<input id='report_" + response[i].id + "' type='checkbox' name='reports' value='" + response[i].id + "'>";
                    newElement += "<label class='labelForCheckBox' for='report_" + response[i].id + "'>";
                    newElement += "<span></span>&nbsp;&nbsp;";
                    newElement += response[i].description;
                    newElement += "</label>";
                    newElement += "</div></div>";
                }
            }
            newElement += "<div class='col-xs-12'>";
            newElement += "<div class='ui_input_checkbox'>";
            newElement += "<input id='custom-checkBox' onchange='customReport()' type='checkbox' name='reports' value='-1'>";
            newElement += "<label class='labelForCheckBox' for='custom-checkBox'>";
            newElement += "<span></span>&nbsp;&nbsp;";
            newElement += "سایر موارد</label>";
            newElement += "</div></div>";
            newElement += "<div id='custom-define-report' style='visibility: hidden'></div>";
            newElement += "</div>";
            $("#reports").append(newElement);
            if (response != "" && response.length > 0 && response[0].text != "") {
                customReport();
                $("#customDefinedReport").val(response[0].text);
            }
        }
    });
}

function sendReport() {
    customMsg = "";
    if ($("#customDefinedReport").val() != null)
        customMsg = $("#customDefinedReport").val();
    var checkedValuesReports = $("input:checkbox[name='reports']:checked").map(function () {
        return this.value;
    }).get();
    if (checkedValuesReports.length <= 0)
        return;
    if (!hasLogin) {
        url = homePath + "/seeAllAns/" + questionId + "/report/" + selectedLogId;
        showLoginPrompt(url);
        return;
    }
    $.ajax({
        type: 'post',
        url: sendReportDir,
        data: {
            "logId": selectedLogId,
            "reports": checkedValuesReports,
            "customMsg": customMsg
        },
        success: function (response) {
            if (response == "ok") {
                closeReportPrompt();
            }
            else {
                $("#errMsgReport").append('مشکلی در انجام عملیات مورد نقد رخ داده است');
            }
        }
    });
}

function closeReportPrompt() {
    $("#custom-checkBox").css("visibility", 'hidden');
    $("#custom-define-report").css("visibility", 'hidden');
    $("#reportPane").addClass('hidden');
    $('.dark').hide();
}

function showReportPrompt(logId) {
    if (!hasLogin) {
        url = homePath + "/seeAllAns/" + questionId + "/report/" + logId;
        showLoginPrompt(url);
        return;
    }
    $('.dark').show();
    selectedLogId = logId;
    getReports(logId);
    showElement('reportPane');
}

function showAnsPane(logId) {
    $(".answerForm").addClass('hidden');
    $("#answerForm_" + logId).removeClass('hidden');
}

function hideAnsPane() {
    $(".answerForm").addClass('hidden');
}

function sendAns(logId) {
    if (!hasLogin) {
        showLoginPrompt(hotelDetailsInAnsMode);
        return;
    }
    if ($("#answerText_" + logId).val() == "")
        return;
    $.ajax({
        type: 'post',
        url: sendAnsDir,
        data: {
            'placeId': placeId,
            'kindPlaceId': kindPlaceId,
            'text': $("#answerText_" + logId).val(),
            'relatedTo': logId
        },
        success: function (response) {
            if (response == "ok") {
                $(".dark").css('display', '');
                $('#ansSubmitted').removeClass('hidden');
            }
            else {
                $("#ans_err_" + logId).empty().append('تنها یکبار می توانید به هر سوال پاسخ دهید');
            }
        }
    });
}

function showAllAns(logId, num) {
    $.ajax({
        type: 'post',
        url: showAllAnsDir,
        data: {
            'logId': logId,
            'num': num
        },
        success: function (response) {
            if (num == -1) {
                $("#hideAll_" + logId).removeClass('hidden');
                $("#showAll_" + logId).addClass('hidden');
                $("#response_" + logId).removeClass('hidden');
            }
            else {
                $("#hideAll_" + logId).addClass('hidden');
                $("#showAll_" + logId).removeClass('hidden');
                $("#response_" + logId).addClass('hidden');
            }
            response = JSON.parse(response);
            newElement = "";
            for (i = 0; i < response.length; i++) {
                newElement += "<div class='prw_rup prw_common_location_posting'>";
                newElement += "<div class='response'>";
                newElement += "<div class='header' style='margin-right:22%;'><span>پاسخ از " + response[i].visitorId + "</span> | ";
                newElement += "<span class='iapSep'>|</span>";
                newElement += "<span style='cursor: pointer;font-size:10px;' onclick='showReportPrompt(\"" + response[i].id + "\")' class='ui_icon '>گزارش تخلف</span>";
                newElement += "</div>";
                newElement += "<div class='content'>";
                newElement += "<div class='abbreviate'>" + response[i].text;
                newElement += "</div></div>";
                newElement += "<div class='confirmDeleteExplanation hidden'>آیا می خواهی این سوال حذف شود ؟</div>";
                newElement += "<span class='ui_button primary small delete hidden'>حذف</span> <span class='ui_button primary small confirmDelete hidden'>ثبت</span> <span class='ui_button secondary small cancelDelete hidden'>لغو</span>";
                newElement += "<div class='votingForm'>";
                newElement += "<div class='voteIcon' onclick='likeAns(" + response[i].id + ")'>";
                newElement += "<div class='ui_icon single-chevron-up-circle'></div>";
                newElement += "<div class='ui_icon single-chevron-up-circle-fill'></div>";
                newElement += "<div class='contents hidden'>پاسخ مفید</div>";
                newElement += "</div>";
                newElement += "<div class='voteCount'>";
                newElement += "<div class='score' data-val='" + response[i].rate + "' id='score_" + response[i].id + "'>" + response[i].rate + "</div>";
                newElement += "<div>نقد من</div>";
                newElement += "</div>";
                newElement += "<div class='voteIcon' onclick='dislikeAns(" + response[i].id + ")'>";
                newElement += "<div class='ui_icon single-chevron-down-circle-fill'></div>";
                newElement += "<div class='ui_icon single-chevron-down-circle'></div>";
                newElement += "<div class='contents hidden'>پاسخ غیر مفید</div>";
                newElement += "</div></div></div></div>";
            }
            $("#response_" + logId).empty().append(newElement);
        }
    });
}

function likeComment(logId) {
    $.ajax({
        type: 'post',
        url: opOnComment,
        data: {
            'logId': logId,
            'mode': 'like'
        },
        success: function (response) {
            if (response == "1") {
                $("#commentLikes_" + logId).empty()
                    .attr('data-val', parseInt($("#commentLikes_" + logId).attr('data-val')) + 1)
                    .append($("#commentLikes_" + logId).attr('data-val'));
            }
            else if (response == "2") {
                $("#commentLikes_" + logId).empty()
                    .attr('data-val', parseInt($("#commentLikes_" + logId).attr('data-val')) + 1)
                    .append($("#commentLikes_" + logId).attr('data-val'));
                $("#commentDislikes_" + logId).empty()
                    .attr('data-val', parseInt($("#commentDislikes_" + logId).attr('data-val')) - 1)
                    .append($("#commentDislikes_" + logId).attr('data-val'));
            }
        }
    });
}

function likeAns(logId) {
    $.ajax({
        type: 'post',
        url: opOnComment,
        data: {
            'logId': logId,
            'mode': 'like'
        },
        success: function (response) {
            if (response == "1") {
                $("#score_" + logId).empty()
                    .attr('data-val', parseInt($("#score_" + logId).attr('data-val')) + 1)
                    .append($("#score_" + logId).attr('data-val'));
            }
            else if (response == "2") {
                $("#score_" + logId).empty()
                    .attr('data-val', parseInt($("#score_" + logId).attr('data-val')) + 2)
                    .append($("#score_" + logId).attr('data-val'));
            }
        }
    });
}

function dislikeAns(logId) {
    $.ajax({
        type: 'post',
        url: opOnComment,
        data: {
            'logId': logId,
            'mode': 'dislike'
        },
        success: function (response) {
            if (response == "1") {
                $("#score_" + logId).empty()
                    .attr('data-val', parseInt($("#score_" + logId).attr('data-val')) - 1)
                    .append($("#score_" + logId).attr('data-val'));
            }
            else if (response == "2") {
                $("#score_" + logId).empty()
                    .attr('data-val', parseInt($("#score_" + logId).attr('data-val')) - 2)
                    .append($("#score_" + logId).attr('data-val'));
            }
        }
    });
}

function dislikeComment(logId) {
    $.ajax({
        type: 'post',
        url: opOnComment,
        data: {
            'logId': logId,
            'mode': 'dislike'
        },
        success: function (response) {
            if (response == "1") {
                $("#commentDislikes_" + logId).empty()
                    .attr('data-val', parseInt($("#commentDislikes_" + logId).attr('data-val')) + 1)
                    .append($("#commentDislikes_" + logId).attr('data-val'));
            }
            else if (response == "2") {
                $("#commentDislikes_" + logId).empty()
                    .attr('data-val', parseInt($("#commentDislikes_" + logId).attr('data-val')) + 1)
                    .append($("#commentDislikes_" + logId).attr('data-val'));
                $("#commentLikes_" + logId).empty()
                    .attr('data-val', parseInt($("#commentLikes_" + logId).attr('data-val')) - 1)
                    .append($("#commentLikes_" + logId).attr('data-val'));
            }
        }
    });
}

function filter() {
    var checkedValues = $("input:checkbox[name='filterComment[]']:checked").map(function () {
        return this.value;
    }).get();
    if (checkedValues.length == 0)
        checkedValues = -1;
    $.ajax({
        type: 'post',
        url: filterComments,
        data: {
            'filters': checkedValues,
            'placeId': placeId,
            'kindPlaceId': kindPlaceId,
            'tag': selectedTag,
            'page': currPage
        },
        success: function (response) {
            showComments(JSON.parse(response));
        }
    });
}

function showAddPhotoPane() {
    if (!hasLogin) {
        showLoginPrompt(hotelDetailsInAddPhotoMode);
        return;
    }
    $('.dark').show();
    showElement('photoEditor');
    getPhotoFilters();
}

function checkSendPhotoBtnAbility() {
    var checkedValues = $("input:radio[name='filter']:checked").map(function () {
        return this.value;
    }).get();
    if (checkedValues.length == 0) {
        $("#sendPhotoBtn").attr('disabled', 'disabled');
    }
    else {
        $("#sendPhotoBtn").removeAttr('disabled');
    }
}

function getPhotoFilters() {
    $.ajax({
        type: 'post',
        url: getPhotoFilter,
        data: {
            'kindPlaceId': kindPlaceId
        },
        success: function (response) {
            response = JSON.parse(response);
            newElement = "";
            for (i = 0; i < response.length; i++) {
                newElement += '<div class="ui_input_checkbox radioOption" style="float: right !important;">';
                newElement += '<input type="radio" name="mask" value="' + response[i].id + '" id="cat_file_' + response[i].id + '">';
                newElement += '<label class="labelForCheckBox" for="cat_file_' + response[i].id + '">';
                newElement += '<span></span>&nbsp;&nbsp;';
                newElement += response[i].name + '</label>'
                newElement += '</div><div style="clear: both"></div>';
            }
            $("#photoTags").empty().append(newElement);
        }
    });
}

function showDetails(username) {
    if (username == null)
        return;
    $.ajax({
        type: 'post',
        url: showUserBriefDetail,
        data: {
            'username': username
        },
        success: function (response) {
            if (response.length == 0)
                return;
            response = JSON.parse(response);
            total = response.excellent + response.veryGood + response.average + response.bad + response.veryBad;
            total /= 100;
            var newElement = "<div class='arrow' style='margin: 0 30px 155px 0;'></div>";
            newElement += "<div class='body_text'>";
            newElement += "<div class='memberOverlay simple container moRedesign'>";
            newElement += "<div class='innerContent'>";
            newElement += "<div class='memberOverlayRedesign g10n'>";
            newElement += "<a href='" + homePath + "/profile/index/" + username + "'>";
            newElement += "<h3 class='username reviewsEnhancements'>" + username + "</h3>";
            newElement += "</a>";
            newElement += "<div class='memberreviewbadge'>";
            newElement += "<div class='badgeinfo'>";
            newElement += "سطح <span>" + response.level + "</span>";
            newElement += "</div></div>";
            newElement += "<ul class='memberdescriptionReviewEnhancements'>";
            newElement += "<li>تاریخ عضویت در سایت " + response.created + "</li>";
            newElement += "<li>از " + response.city + " در " + response.state + " </li>";
            newElement += "</ul>";
            newElement += "<ul class='countsReviewEnhancements'>";
            newElement += "<li class='countsReviewEnhancementsItem'>";
            newElement += "<span class='ui_icon pencil-paper iconReviewEnhancements'></span>";
            newElement += "<span class='badgeTextReviewEnhancements'>" + response.rates + " نقد</span>";
            newElement += "</li>";
            newElement += "<li class='countsReviewEnhancementsItem'>";
            newElement += "<span class='ui_icon globe-world iconReviewEnhancements'></span>";
            newElement += "<span class='badgeTextReviewEnhancements'>" + response.seen + " مشاهده</span>";
            newElement += "</li>";
            newElement += "<li class='countsReviewEnhancementsItem'>";
            newElement += "<span class='ui_icon thumbs-up-fill iconReviewEnhancements'></span>";
            newElement += "<span class='badgeTextReviewEnhancements'>" + response.likes + " رای مثبت</span>";
            newElement += "</li>";
            newElement += "<li class='countsReviewEnhancementsItem'>";
            newElement += "<span class='ui_icon thumbs-down-fill iconReviewEnhancements'></span>";
            newElement += "<span class='badgeTextReviewEnhancements'>" + response.dislikes + " رای منفی</span>";
            newElement += "</li>";
            newElement += "</ul>";
            newElement += "<div class='wrap'>";
            newElement += "<ul class='memberTagsReviewEnhancements'>";
            newElement += "</ul></div>";
            newElement += "<div class='wrap'>";
            newElement += "<div class='wrap container histogramReviewEnhancements'>";
            newElement += "<div class='barlogoReviewEnhancements'>";
            newElement += "<span>پراکندگی نقدها</span>";
            newElement += "</div><ul>";
            newElement += "<div class='chartRowReviewEnhancements'>";
            newElement += "<span class='rowLabelReviewEnhancements rowCellReviewEnhancements'>عالی</span>";
            newElement += "<span class='rowBarReviewEnhancements rowCellReviewEnhancements'>";
            newElement += "<span class='barReviewEnhancements'>";
            newElement += "<span class='fillReviewEnhancements' style='width:" + response.excellent / total + "%;'></span>";
            newElement += "</span></span>";
            newElement += "<span class='rowCountReviewEnhancements rowCellReviewEnhancements'> " + response.excellent + "</span>";
            newElement += "</div>";
            newElement += "<div class='chartRowReviewEnhancements'>";
            newElement += "<span class='rowLabelReviewEnhancements rowCellReviewEnhancements'>خوب</span>";
            newElement += "<span class='rowBarReviewEnhancements rowCellReviewEnhancements'>";
            newElement += "<span class='barReviewEnhancements'>";
            newElement += "<span class='fillReviewEnhancements' style='width:" + response.veryGood / total + "%;'></span>";
            newElement += "</span></span>";
            newElement += "<span class='rowCountReviewEnhancements rowCellReviewEnhancements'> " + response.veryGood + "</span>";
            newElement += "</div>";
            newElement += "<div class='chartRowReviewEnhancements'>";
            newElement += "<span class='rowLabelReviewEnhancements rowCellReviewEnhancements'>معمولی</span>";
            newElement += "<span class='rowBarReviewEnhancements rowCellReviewEnhancements'>";
            newElement += "<span class='barReviewEnhancements'>";
            newElement += "<span class='fillReviewEnhancements' style='width:" + response.average / total + "%;'></span>";
            newElement += "</span></span>";
            newElement += "<span class='rowCountReviewEnhancements rowCellReviewEnhancements'> " + response.average + "</span>";
            newElement += "</div>";
            newElement += "<div class='chartRowReviewEnhancements'>";
            newElement += "<span class='rowLabelReviewEnhancements rowCellReviewEnhancements'>ضعیف</span>";
            newElement += "<span class='rowBarReviewEnhancements rowCellReviewEnhancements'>";
            newElement += "<span class='barReviewEnhancements'>";
            newElement += "<span class='fillReviewEnhancements' style='width:" + response.bad / total + "%;'></span>";
            newElement += "</span></span>";
            newElement += "<span class='rowCountReviewEnhancements rowCellReviewEnhancements'> " + response.bad + "</span>";
            newElement += "</div>";
            newElement += "<div class='chartRowReviewEnhancements'>";
            newElement += "<span class='rowLabelReviewEnhancements rowCellReviewEnhancements'>خیلی بد</span>";
            newElement += "<span class='rowBarReviewEnhancements rowCellReviewEnhancements'>";
            newElement += "<span class='barReviewEnhancements'>";
            newElement += "<span class='fillReviewEnhancements' style='width:" + response.veryBad / total + "%;'></span>";
            newElement += "</span></span>";
            newElement += "<span class='rowCountReviewEnhancements rowCellReviewEnhancements'> " + response.veryBad + "</span>";
            newElement += "</div></ul></div></div></div></div></div></div>";
            $(".img_popUp").empty().append(newElement).removeClass('hidden');
        }
    });
}

function showBriefPopUp(thisVar, owner) {
    var bodyRect = document.body.getBoundingClientRect(),
        elemRect = thisVar.getBoundingClientRect(),
        offset = elemRect.top - bodyRect.top,
        offset2 = elemRect.left - bodyRect.left;
    if (offset < 0)
        offset = Math.abs(offset);
    $(".img_popUp").css("top", offset).css("left", offset2 - 450);
    showDetails(owner);
}

function stickIt() {
    var orgElementPos = $('.original').offset();
    orgElementTop = orgElementPos.top;
    if ($(window).scrollTop() >= (orgElementTop)) {
        // scrolled past the original position; now only show the cloned, sticky element.
        // Cloned element should always have same left position and width as original element.
        orgElement = $('.original');
        coordsOrgElement = orgElement.offset();
        leftOrgElement = coordsOrgElement.left;
        widthOrgElement = orgElement.css('width');
        $('.cloned').addClass('my_moblie_hidden')
            .css('left', '0%').css('top', 0).css('font-size', '13px').css('right', '0%').css('width', 'auto').show()
            .css('visibility', 'hidden');
    } else {
        // not scrolled past the menu; only show the original menu.
        $('.cloned').hide();
        $('.original').css('visibility', 'visible');
    }
}

function checkOverFlow() {
    offsetHeight = $('#introductionText').prop('offsetHeight');
    scrollHeight = $('#introductionText').prop('scrollHeight');
    if (offsetHeight < scrollHeight)
        $('#showMore').removeClass('hidden');
    else {
        $('#showMore').addClass('hidden');
    }
}

function showMore() {
    scrollHeight = $('#introductionText').prop('scrollHeight');
    $('#introductionText').css('max-height', '');
    $('#showMore').empty().append('کمتر').attr('onclick', 'showLess()').css('padding-top', (scrollHeight - 12) + 'px');
}

function showLess() {
    $('#introductionText').css('max-height', '21px');
    $('#showMore').empty().append('بیشتر').attr('onclick', 'showMore()').css('padding-top', '');
}

function showMoreReview(idx) {
    $('#partial_entry_' + idx).css('max-height', '');
    $('#showMoreReview_' + idx).empty().append('کمتر').attr('onclick', 'showLessReview("' + idx + '")');
    $("#reviewPic_" + idx).removeClass('hidden');
}

function showLessReview(idx) {
    $('#partial_entry_' + idx).css('max-height', '70px');
    $('#showMoreReview_' + idx).empty().append('بیشتر').attr('onclick', 'showMoreReview(' + idx + ')');
    $("#reviewPic_" + idx).addClass('hidden');
}

function showAddReviewPageHotel(url) {
    if (!hasLogin) {
        showLoginPrompt(url);
    }
    else {
        document.location.href = url;
    }
}
</script>

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
    if (sL.length > 0)
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
    if (sL.length > 0)
        hasFilter = true;
    $(".dark").show();
    show(1, 1);
}

function isInFilters(key) {
    key = parseInt(key);
    for (j = 0; j < filters.length; j++) {
        if (filters[j] == key)
            return true;
    }
    return false;
}

function getBack(curr) {
    for (i = curr - 1; i >= 0; i--) {
        if (!isInFilters(i))
            return i;
    }
    return -1;
}

function getFixedFromLeft(elem) {
    if (elem.prop('id') == topContainer || elem.prop('id') == 'PAGE') {
        return parseInt(elem.css('margin-left').split('px')[0]);
    }
    return elem.position().left +
        parseInt(elem.css('margin-left').split('px')[0]) +
        getFixedFromLeft(elem.parent());
}

function getFixedFromTop(elem) {
    if (elem.prop('id') == topContainer) {
        return marginTop;
    }
    if (elem.prop('id') == "PAGE") {
        return 0;
    }
    return elem.position().top +
        parseInt(elem.css('margin-top').split('px')[0]) +
        getFixedFromTop(elem.parent());
}

function getNext(curr) {
    curr = parseInt(curr);
    for (i = curr + 1; i < total; i++) {
        if (!isInFilters(i))
            return i;
    }
    return total;
}

function bubbles(curr) {
    if (total <= 1)
        return "";
    t = total - filters.length;
    newElement = "<div class='col-xs-12' style='position: relative'><div class='col-xs-12 bubbles' style='padding: 0; margin-right: 0; margin-left: " + ((400 - (t * 18)) / 2) + "px'>";
    for (i = 1; i < total; i++) {
        if (!isInFilters(i)) {
            if (i == curr)
                newElement += "<div style='border: 1px solid #ccc; background-color: #ccc; border-radius: 50%; margin-right: 2px; width: 12px; height: 12px; float: left'></div>";
            else
                newElement += "<div onclick='show(\"" + i + "\", 1)' class='helpBubble' style='border: 1px solid #333; background-color: black; border-radius: 50%; margin-right: 2px; width: 12px; height: 12px; float: left'></div>";
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
    if (hasFilter) {
        while (isInFilters(curr)) {
            curr += inc;
        }
    }
    if (getBack(curr) <= 0) {
        $("#backBtnHelp_" + curr).attr('disabled', 'disabled');
    }
    else {
        $("#backBtnHelp_" + curr).removeAttr('disabled');
    }
    if (getNext(curr) > total - 1) {
        $("#nextBtnHelp_" + curr).attr('disabled', 'disabled');
    }
    else {
        $("#nextBtnHelp_" + curr).removeAttr('disabled');
    }
    if (curr < greenBackLimit) {
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
    for (j = 0; j < indexes.length; j++) {
        if (curr == indexes[j]) {
            targetHeight += additional[j];
            break;
        }
    }
    if ($("#targetHelp_" + curr).offset().top > 200) {
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
    window.ontouchmove = preventDefault; // mobile
    document.onkeydown = preventDefaultForScrollKeys;
}

function enableScroll() {
    if (window.removeEventListener)
        window.removeEventListener('DOMMouseScroll', preventDefault, false);
    window.onmousewheel = document.onmousewheel = null;
    window.onwheel = null;
    window.ontouchmove = null;
    document.onkeydown = null;
}
</script>

<script>
var room = 0;
var adult = 0;
var children = 0;
@if(session('room') != null)
room = parseInt('{{session('room')}}');
adult = parseInt('{{session('adult')}}');
children = parseInt('{{session('children')}}');
@endif
var passengerNoSelect = false;
$(".room").html(room);
$(".adult").html(adult);
$(".children").html(children);
for (var i = 0; i < children; i++) {
    $(".childBox").append("" +
        "<div class='childAge' data-id='" + i + "'>" +
        "<div>سن بچه</div>" +
        "<div><select class='selectAgeChild' name='ageOfChild' id='ageOfChild'>" +
        "<option value='0'>1<</option>" +
        "<option value='1'>1</option>" +
        "<option value='2'>2</option>" +
        "<option value='3'>3</option>" +
        "<option value='4'>4</option>" +
        "<option value='5'>5</option>" +
        "</select></div>" +
        "</div>");
}

function togglePassengerNoSelectPane() {
    if (!passengerNoSelect) {
        passengerNoSelect = true;
        $("#passengerNoSelectPane").removeClass('hidden');
        $("#passengerNoSelectPane1").removeClass('hidden');
        $("#passengerArrowUp").removeClass('hidden');
        $("#passengerArrowDown").addClass('hidden');
    }
    else {
        $("#passengerNoSelectPane").addClass('hidden');
        $("#passengerNoSelectPane1").addClass('hidden');
        $("#passengerArrowDown").removeClass('hidden');
        $("#passengerArrowUp").addClass('hidden');
        passengerNoSelect = false;
    }
}

function addClassHidden(element) {
    $("#" + element).addClass('hidden');
    if (element == 'passengerNoSelectPane' || element == 'passengerNoSelectPane1') {
        $("#passengerArrowDown").removeClass('hidden');
        $("#passengerArrowUp").addClass('hidden');
    }
}

function changeRoomPassengersNum(inc, mode) {
    switch (mode) {
        case 3:
        default:
            if (room + inc >= 0)
                room += inc;

            if (room > 0 && adult == 0) {
                adult = 1;
                $("#adultPassengerNumInSelect").empty().append(adult);
                $("#adultPassengerNumInSelect1").empty().append(adult);
            }

            $("#roomNumInSelect").empty().append(room);
            $("#roomNumInSelect1").empty().append(room);
            break;
        case 2:
            if (adult + inc >= 0)
                adult += inc;
            $("#adultPassengerNumInSelect").empty().append(adult);
            $("#adultPassengerNumInSelect1").empty().append(adult);
            break;
        case 1:
            if (children + inc >= 0)
                children += inc;
            if (inc >= 0) {
                $(".childBox").append("<div class='childAge' data-id='" + (children - 1) + "'>" +
                    "<div>سن بچه</div>" +
                    "<div><select class='selectAgeChild' name='ageOfChild' id='ageOfChild'>" +
                    "<option value='0'>1<</option>" +
                    "<option value='1'>1</option>" +
                    "<option value='2'>2</option>" +
                    "<option value='3'>3</option>" +
                    "<option value='4'>4</option>" +
                    "<option value='5'>5</option>" +
                    "</select></div>" +
                    "</div>");
                ;
            } else {
                $(".childAge[data-id='" + (children) + "']").remove();
            }
            $("#childrenPassengerNumInSelect").empty().append(children);
            $("#childrenPassengerNumInSelect1").empty().append(children);
            break;
    }
    var text = '<span style="float: right;">' + room + '</span>&nbsp;\n' +
        '                                                <span>اتاق</span>&nbsp;-&nbsp;\n' +
        '                                                <span id="childPassengerNo">' + adult + '</span>\n' +
        '                                                <span>بزرگسال</span>&nbsp;-&nbsp;\n' +
        '                                                <span id="infantPassengerNo">' + children + '</span>\n' +
        '                                                <span>بچه</span>&nbsp;';
    // document.getElementById('roomDetailRoom').innerHTML = text;
    while ((4 * room) < adult) {
        room++;
        $("#roomNumInSelect").empty().append(room);
    }
    document.getElementById('num_room').innerText = room;
    document.getElementById('num_adult').innerText = adult;
}
</script>

<script>
function changeStatetounReserved() {
    document.getElementById('bestPriceRezerved').style.display = 'none';
    document.getElementById('bestPrice').style.display = 'block';
}

function changeRoomPrice(id) {
    var x = document.getElementById("extraBedPrice" + id);
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}

function dotedNumber(number) {
    var i = 1;
    var num = 0;
    while (i < number) {
        i *= 10;
        num++;
    }
    var string_number = '';
    var mande = num % 3;
    string_number = Math.floor(number / (Math.pow(10, num - mande))) + '.';
    number = number % (Math.pow(10, num - mande));
    num = num - mande;
    var div = num;
    for (i = 0; i < div / 3; i++) {
        if (number != 0) {
            num -= 3;
            string_number += Math.floor(number / (Math.pow(10, num))) + '.';
            number = number % (Math.pow(10, num));
        }
        else if (i < (div / 3) - 1) {
            string_number += '000.';
        }
        else {
            string_number += '000';
        }
    }
    return string_number;
}

function inputSearch() {
    var ageOfChild = [];
    var goDate;
    var backDate;
    var childSelect = document.getElementsByName('ageOfChild');
    for (var i = 0; i < children; i++) {
        ageOfChild[i] = childSelect[i + 1].value;
    }
    goDate = document.getElementById('goDate').value;
    backDate = document.getElementById('backDate').value;
    document.getElementById('form_room').value = room;
    document.getElementById('form_adult').value = adult;
    document.getElementById('form_children').value = children;
    document.getElementById('form_goDate').value = goDate;
    document.getElementById('form_backDate').value = backDate;
    document.getElementById('form_ageOfChild').value = ageOfChild;
    document.getElementById('form_hotel').submit();
}

function editSearch() {
    changeStatetounReserved();
    window.location.href = '#bestPrice';
}

@if(session('backDate') != null)
document.getElementById('backDate').value = '{{session("backDate")}}';
var rooms = '{!! $jsonRoom !!}';
rooms = JSON.parse(rooms);
var totalMoney = 0;
var totalPerDayMoney = 0;
var numDay = rooms[0].perDay.length;
var room_code = [];
var adult_count = [];
var extra = [];
var num_room_code = [];
var room_name = [];
document.getElementById('numDay').innerText = numDay;
document.getElementById('check_num_day').innerText = numDay;

function scrollToBed() {
    var elmnt = document.getElementById("rooms");
    elmnt.scrollIntoView();
}

function changeNumRoom(_index, value) {
    totalMoney = 0;
    totalPerDayMoney = 0;
    var totalNumRoom = 0;
    var text = '';
    var reserve_text = '';
    var reserve_money_text = '';
    room_code = [];
    adult_count = [];
    extra = [];
    num_room_code = [];
    room_name = [];
    for (i = 0; i < rooms.length; i++) {
        numRoom = parseInt(document.getElementById('roomNumber' + i).value);
        totalNumRoom += numRoom;
        price = parseInt(rooms[i].perDay[0].price);
        priceExtraBed = rooms[i].priceExtraGuest;
        extraBed = document.getElementById('additional_bed' + i).checked;
        totalPerDayMoney += numRoom * Math.floor(price / 1000) * 1000;
        if (numRoom != 0) {
            room_code.push(rooms[i].roomNumber);
            adult_count.push(rooms[i].capacity['adultCount']);
            num_room_code.push(numRoom);
            room_name.push(rooms[i].name);
            text += '<div><span>X' + numRoom + '</span>' + rooms[i].name;
            reserve_money_text += '<div><span style="float: right">X' + numRoom + '</span><span style="float: right">' + rooms[i].name + '</span>';
            reserve_text += '<div class="row" style="background: white; margin: 1px; box-shadow: 0 0 20px 0px gray; margin-bottom: 10px; ">\n' +
                '<div class="col-md-9" style="font-size: 15px; padding-top: 2%;">\n' +
                '<div class="row" style="display: flex; flex-direction: row;">\n' +
                '<div style="width: 33%">\n' +
                '<span style="color: #92321b">نام اتاق: </span>\n' +
                '<span>' + rooms[i].name + '</span>\n' +
                '</div>\n' +
                '<div style="width: 33%">\n' +
                '<span style="color: #92321b">تاریخ ورود: </span>\n' +
                '<span>{{session("goDate")}}</span>\n' +
                '</div>\n' +
                '<div style="width: 33%">\n' +
                '<span style="color: #92321b">تاریخ خروج: </span>\n' +
                '<span>{{session("backDate")}}</span>\n' +
                '</div>\n' +
                '</div>\n' +
                '<div class="row" style="display: flex; flex-direction: row; margin-bottom: 2%; margin-top: 2%;">\n' +
                '<div style="width: 33%">\n' +
                '<span style="color: #92321b">تعداد مسافر: </span>\n' +
                '<span>' + rooms[i].capacity.adultCount + '</span>\n' +
                '</div>\n' +
                '<div style="width: 33%">\n' +
                '<span style="color: #92321b">سرویس تخت اضافه: </span>\n';
            if (extraBed) {
                text += '<span style="font-size: 0.85em">با تخت اضافه</span>';
                reserve_money_text += '<span style="font-size: 0.85em; float: right">با تخت اضافه</span><span style="float: left;">' + dotedNumber((Math.floor(priceExtraBed / 1000) * 1000) + (Math.floor(price / 1000) * 1000)) + '</span>';
                totalPerDayMoney += numRoom * Math.floor(priceExtraBed / 1000) * 1000;
                reserve_text += '<span>دارد</span>\n';
                extra.push(true);
            } else {
                reserve_money_text += '<span style="float: left;">' + dotedNumber(Math.floor(price / 1000) * 1000) + '</span>';
                reserve_text += '<span>ندارد</span>\n';
                extra.push(false);
            }
            text += '</div>';
            reserve_money_text += '</div>';
            reserve_text += '</div>\n' +
                '</div><div class="row" style="display: flex; flex-direction: row;">\n' +
                '<div>\n' +
                '<span style="color: #92321b"> صبحانه مجانی: </span>\n' +
                '<span>دارد</span>\n' +
                '</div>\n' +
                '</div>\n' +
                '</div>\n';
            reserve_text += '<div class="col-md-3"><img src="' + rooms[i].pic + '" style="width: 100%;"></div></div>';
        }
    }
    totalMoney += totalPerDayMoney * numDay;
    document.getElementById('totalPriceOneDay').innerText = dotedNumber(totalPerDayMoney);
    document.getElementById('totalPrice').innerText = dotedNumber(totalMoney);
    document.getElementById('check_total_price').innerText = dotedNumber(totalMoney);
    document.getElementById('totalNumRoom').innerText = totalNumRoom;
    document.getElementById('check_total_num_room').innerText = totalNumRoom;
    document.getElementById('discriptionNumRoom').innerHTML = text;
    document.getElementById('check_description').innerHTML = reserve_money_text;
    document.getElementById('selected_rooms').innerHTML = reserve_text;
}

function showReserve() {
    if (totalMoney > 0)
        document.getElementById('check_room').style.display = 'flex';
}
function updateSession() {
    $.ajax({
        url: '{{route("updateSession")}}',
        type: 'post',
        data: {
            'room_code': room_code,
            'adult_count': adult_count,
            'extra': extra,
            'num_room_code': num_room_code,
            'room_name': room_name,
    {{--'hotel_name': '{{$place->hotel_name}}',--}}
    {{--'rph': '{{$place->rph}}',--}}
    'backURL': window.location.href
},
    success: function (response) {
        window.location.href = '{{url('buyHotel')}}';
    }
})
}
@endif
</script>

<script src="{{URL::asset('js/adv.js')}}"></script>
