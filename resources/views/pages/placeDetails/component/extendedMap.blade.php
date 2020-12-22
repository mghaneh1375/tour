
<style>
    .mapState {
        position: fixed;
        width: 90%;
        height: 90%;
        left: 5%;
        right: 5%;
        top: 5%;
        padding: 0;
    }
    #mapState1 {
        width: 100%;
        height: 100%;
        position: absolute;
    }
    #mapState1 .leaflet-touch .leaflet-control-layers, .leaflet-touch .leaflet-bar{
        margin-top: 50px;
    }
    .extendedMapClose{
        left: 10px;
        top: 15px;
        z-index: 999;
    }
    .extendedMapClose:before{
        font-size: 70px;
    }
</style>

<div id="mapState" class="modal fade">
    <div class="modal-dialog modal-lg mapState">

        <div id="extendedMapMoreInfoPlace" class="mapMoreInfoPlace">
            <div class="iconFamily iconClose closeMapMoreInfo" onclick="$('#extendedMapMoreInfoPlace').removeClass('showMapMoreInfo');"></div>
            <div class="imgMapMoreDiv">
                <a class="linkMapMore" target="_blank">
                    <div>
                        <img id="extendedMapMoreInfoImg" class="mapMoreInfoImg"   onload="fitThisImg(this)">
                    </div>
                </a>

                @if(\auth()->check())
                    <div id="extendedMoreMapHeart" class="moreMapSaveButtonDiv" onclick="saveToTripList(this)" value="">
                        {{--fill-heart--}}
                        <span class="empty-heart"></span>
                    </div>
                @endif

            </div>
            <div class="contentMapMore">
                <a id="extendedMapMoreName" class="nameMapMore lessShowText linkMapMore" target="_blank"></a>
                <div class="rateMapMore">
                    <span id="extendedMapMoreRate" class=""></span>
                    <span id="extendedMapMoreReview" class="suggestionPackReviewCount"></span>
                    <span>{{__('نقد')}}</span>
                </div>
                <div class="mapMoreState">
                    <div>
                        {{__('استان')}}
                        <span id="extendedMoreMapState"></span>
                    </div>

                    <div>
                        {{__('شهر')}}
                        <span id="extendedMoreMapCity"></span>
                    </div>
                </div>
                <div class="mapMoreIcon">
                    <img id="extendedMapMoreIconImg" class="mapMoreIconImg" src=''>
                </div>
            </div>
        </div>

        <div id="mapState1" class="placeHolderAnime"></div>

        <div class="mapMenuList">
            <span class="mapIconsCommon boomgardyMapIcon" title="{{__('بوم گردی ها')}}" onclick="toggleIconInExtendedMap(this, 'boomgardy')">
                <span class="mapIconIcon boomIcon"></span>
            </span>
            <span class="mapIconsCommon hotelMapIcon" title="{{__('هتل ها')}}" onclick="toggleIconInExtendedMap(this, 'hotels')">
                <span class="mapIconIcon hotelIcon"></span>
            </span>
            <span class="mapIconsCommon amakenMapIcon" title="{{__('جاذبه ها')}}" onclick="toggleIconInExtendedMap(this, 'amaken')">
                <span class="mapIconIcon atraction"></span>
            </span>
            <span class="mapIconsCommon restaurantMapIcon" title="{{__('رستوران ها')}}" onclick="toggleIconInExtendedMap(this, 'restaurant')">
                <span class="mapIconIcon restaurantIcon"></span>
            </span>
            <span class="mapIconsCommon majaraMapIcon" title="{{__('طبیعت گردی ها')}}" onclick="toggleIconInExtendedMap(this, 'majara')">
                <span class="mapIconIcon majaraIcon"></span>
            </span>
            <span class="mapIconsCommon moreInfoMapIcon" title="{{__('اطلاعات بیشتر')}}" onclick="toggleIconInExtendedMap(this, 'moreInfo')">
                <span class="mapIconIcon moreInfoIcon">i</span>
            </span>
        </div>

        <div class="ui_close_x extendedMapClose" onclick="$('#mapState').modal('hide')"></div>
    </div>
</div>

<script>
    let showFirstTime = false;
    let extendedMainMap;
    let extendedMapId;
    let extendedMapData;
    let extendedMapMarker = {
        center: [],
        amaken: [],
        hotels: [],
        restaurant: [],
        majara: [],
        boomgardy: [],
        moreInfo: []
    };

    function showExtendedMap(_x, _y){
        if(window.mobileAndTabletCheck())
            location.href = 'geo:' + _x + ',' + _y;
        else {
            getStatePlaces();
            $('#mapState').modal('show');
        }
    }

    function initExtendedMap(_data, _center, _centerPlace = '') {
        extendedMapData = _data;
        extendedMainMap = L.map("mapState1", {
            minZoom: 1,
            maxZoom: 20,
            crs: L.CRS.EPSG3857,
            center: [_center['x'],  _center['y']],
            zoom: 15
        });
        L.TileLayer.wmsHeader(
            "https://map.ir/shiveh",
            {
                layers: "Shiveh:Shiveh",
                format: "image/png",
                minZoom: 1,
                maxZoom: 20
            },
            [
                {
                    header: "x-api-key",
                    value: window.mappIrToken
                }
            ]
        ).addTo(extendedMainMap);



        // var mapOptions = {
        //     center: new google.maps.LatLng(_center['x'],  _center['y']),
        //     zoom: 15,
        //     styles: window.googleMapStyle
        // };
        // extendedMainMap = new google.maps.Map(document.getElementById('mapState1'), mapOptions);

        if(_centerPlace != ''){
            var marker = L.marker([_centerPlace['C'], _centerPlace['D']], {
                title: _centerPlace['name'],
            }).addTo(extendedMainMap).bindPopup(_centerPlace['name']).on('click', () => openExtendedMapMarkerDescription(x, _centerPlace['id']));
            extendedMainMap.setView([_centerPlace['C'], _centerPlace['D']], 16);
            extendedMapMarker.center.push(marker);

            // var marker = new google.maps.Marker({
            //     position: new google.maps.LatLng(_centerPlace['C'], _centerPlace['D']),
            //     map: extendedMainMap,
            //     title: _centerPlace['name'],
            //     url: _centerPlace['url'],
            //     id: _centerPlace['id']
            // }).addListener('click', function () {
            //     openExtendedMapMarkerDescription(x, this.id);
            // });
        }

        let fk = Object.keys(extendedMapData);
        for (let x of fk) {
            extendedMapData[x].forEach(item => {
                var marker = L.marker([parseFloat(item['C']), parseFloat(item['D'])], {
                    title: item['name'],
                    icon: L.icon({
                        iconUrl: mapIcon[x],
                        iconSize: [30, 35], // size of the icon
                    })
                }).bindPopup(item['name']).on('click', () => openExtendedMapMarkerDescription(x, item['id']));
                var mapMarkerInMap= marker.addTo(extendedMainMap);

                extendedMapMarker[x].push({
                    markerInfo: marker,
                    mapMarkerInMap: mapMarkerInMap,
                });

                // var marker = new google.maps.Marker({
                //     position: new google.maps.LatLng(item['C'], item['D']),
                //     icon: {
                //         url: mapIcon[x],
                //         scaledSize: new google.maps.Size(30, 35), // scaled size
                //     },
                //     map: extendedMainMap,
                //     title: item['name'],
                //     url: item['url'],
                //     id: item['id']
                // }).addListener('click', function () { openExtendedMapMarkerDescription(x, this.id) });
            });
        }
    }

    function openExtendedMapMarkerDescription(_kind, _id){

        let place = null;
        extendedMapData[_kind].forEach(item => {
            if(item.id == _id)
                place = item;
        });

        $('#extendedMapMoreRate').removeClass();
        $('#extendedMapMoreRate').addClass('ui_bubble_rating bubble_' + place.rate + '0');

        $('#extendedMapMoreInfoImg').attr('src', place.pic);
        $('#extendedMapMoreName').text(place.name);
        $('.linkMapMore').attr('href', place.url);
        $('#extendedMapMoreReview').text(place.review);
        $('#extendedMapMoreIconImg').attr('src', mapIcon[_kind]);
        $('#extendedMoreMapCity').text(place.cityName);
        $('#extendedMoreMapState').text(place.stateName);
        $('#extendedMoreMapHeart').attr('value', place.id);

        $('#extendedMapMoreInfoPlace').addClass('showMapMoreInfo');
    }

    function toggleIconInExtendedMap(_element, _kind) {
        $(_element).toggleClass('offMapIcons');
        var showStatus = $(_element).hasClass('offMapIcons') ? 0 : 1;
        setInExtendedMap(showStatus, extendedMapMarker[_kind]);
    }

    function setInExtendedMap(isSet, marker) {
        marker.map(mar => {
            if(isSet == 1)
                mar.mapMarkerInMap = mar.markerInfo.addTo(extendedMainMap);
            else
                extendedMainMap.removeLayer(mar.mapMarkerInMap);
        });
        // if (isSet == 1) {
        //     for (var i = 0; i < marker.length; i++)
        //         marker[i]['j'].setMap(extendedMainMap)
        // } else {
        //     for (var i = 0; i < marker.length; i++)
        //         marker[i]['j'].setMap(null)
        // }
    }

    function getStatePlaces(){
        $.ajax({
            type: 'post',
            url: '{{route("getCityAllPlaces")}}',
            data: {
                _token: '{{csrf_token()}}',
                kind : 'state',
                id: '{{$state->id}}'
            },
            success: function(response){
                let allPlaces = response.allPlaces;
                let center = {
                    x: '{{$place->C}}',
                    y: '{{$place->D}}'
                };

                initExtendedMap(allPlaces, center);
            }
        })
    }
</script>
