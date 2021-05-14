var planMap;
var events = [];
var numbers = [];
var typesTitles = {
    place : {
        name: 'بازدید ',
        hover: '#4dc7bc59',
        class: 'placeCardPlace',
    },
    meal : {
        name: 'وعده غذایی ',
        class: 'placeCardMeals'
    },
    special : {
        name: 'برنامه ویژه ',
        class: 'placeCardSpecial',
    },
    start : {
        name: 'شروع'
    },
    end : {
        name: 'پایان'
    }
};

function initPlanMap()  {
    planMap = L.map("planMapDiv", {
        minZoom: 1,
        maxZoom: 20,
        crs: L.CRS.EPSG3857,
        center: [35.72351645367768, 51.37030005455017],
        zoom: 6
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
    ).addTo(planMap);
}

function createPlanBox(){
    for(let x in typesTitles)
        numbers[x] = 0;

    let html = '';
    events.forEach((item, index) => {
        numbers[item.type]++;
        let typeTitle = `${typesTitles[item.type].name}`;
        if(item.type != 'start' && item.type != 'end')
            typeTitle += ` ${numbers[item.type]}`;

        let typeClass = item.type === 'place' ? 'seenPlaceTypeRow' : (item.type === 'special' ? 'specialTypeRow' : 'mealTypeRow');

        events[index].number = numbers[item.type];

        html += `<div data-index="${index}" class="placeCard ${typeClass}">
                        <span class="number">
                            ${index+1}
                            <span class="dash"></span>
                        </span>
                        <a href="${item.url}" ${item.url != '#' ? `target="_blank"` : ''} class="imgSection">
                            <img src="${item.picture}" class="resizeImgClass" onload="fitThisImg(this)">
                        </a>
                        <div class="infoSection">
                            <a href="${item.url}" ${item.url != '#' ? `target="_blank"` : ''} class="name lessShowText">
                                <span style="margin-left: 10px;">${item.title}</span>
                                <span class="kindType">${typeTitle}</span>
                            </a>
                            <div class="time">${item.sTime} ${item.eTime != '' ? `تا ${item.eTime}` : ''}</div>
                            ${item.placeRate == null ? '' :
                                    `<div class="ratesAndReview">
                                        <div class="rate ui_bubble_rating bubble_${item.placeRate}0"></div>
                                        <div class="review">${item.placeReviewCount} نقد</div>
                                    </div>`
        }
                            <div class="description">${item.description}</div>
                        </div>
                    </div>`;
    });

    document.getElementById('eventBoxSection').innerHTML = html;
    createHoverOnPlaceCard();
}

function createHoverOnPlaceCard(){
    [...document.querySelectorAll('.placeCard')].map(item => {
        item.addEventListener('mouseenter', function (){
            let index = this.getAttribute('data-index');
            if(events[index].lat != 0 && events[index].lng != 0) {
                [...document.querySelectorAll('.myIconOnMap')].map(e => e.classList.add('hideMarker'));
                planMap.setView([events[index].lat, events[index].lng], 15);

                if(document.querySelector(`.mapMarker_${index}`) != null)
                    document.querySelector(`.mapMarker_${index}`).classList.remove('hideMarker');
            }
        });
        item.addEventListener('mouseleave', function (){
            [...document.querySelectorAll('.myIconOnMap')].map(e => e.classList.remove('hideMarker'));
        });
    });
}

function createMarkers(){
    let locations = [];
    let places = [];

    events.forEach((item, index) => {
        if(item.lat != 0 && item.lng != 0 && item.type != 'start' && item.type != 'end') {
            if (item.marker != null)
                planMap.removeLayer(item.marker);
            places.push({...item, eventIndex: index})
        }
        else if(item.type === 'start' || item.type === 'end'){
            L.marker([item.lat, item.lng]).addTo(planMap);
        }
    });

    places.forEach(item => {
        let marker = createMapMarker(item);
        events[item.eventIndex].marker = marker;
        marker.addTo(planMap);

        locations.push([marker._latlng.lat, marker._latlng.lng]);
    });

    planMap.fitBounds(locations);
    createPathBetween();
}

function createMapMarker(_place){
    let typeName = typesTitles[_place.type].name;
    let typeClass = _place.type === 'place' ? 'seenPlaceType' : (_place.type === 'meal' ? 'mealType' : 'specialType');
    let name = _place.type === 'special' ? `برنامه ویژه ${_place.number}` : _place.title;

    let iconHtml = `<div class="htmlMarker">
                            <div class="topOnPic ${typeClass}">${typeName} ${_place.number}</div>
                            <div class="imgInIcon">
                                <img src="${_place.picture}">
                            </div>
                        </div>`;

    return L.marker([_place.lat, _place.lng], {
        title: name,
        icon: L.divIcon({
            className: `myIconOnMap ${typeClass} mapMarker_${_place.eventIndex}`,
            html: iconHtml
        })
    });

}

function createPathBetween(){
    let moveIconPolyLines = [];
    let places = [];

    events.forEach(item => {
        if(item.lat != 0 && item.lng != 0)
            places.push(item)
    });

    for(let i = 0; i < places.length-1; i++){
        let line = [[places[i].lat, places[i].lng], [places[i+1].lat, places[i+1].lng]];
        let path = L.polyline(line, {
            weight: 2,
            color: 'black',
            dashArray: '5'
        });

        path.addTo(planMap);

        let nLine = [{
            lat: places[i].lat,
            lng: places[i].lng
        }, {
            lat: places[i+1].lat,
            lng: places[i+1].lng
        }];


        let rotateIcon = places[i].lng > places[i+1].lng ? '180' : '0';

        // var moveManIcon = `<div class="moveManIcon"><img src="${moveIconGif}" style="width: 100%; transform: rotateY(${rotateIcon}deg)"></div>`;
        var moveManIcon = `<div class="moveManIcon"></div>`;

        var motion = L.motion.polyline(nLine, {
            color: "transparent"
        }, null, {
            removeOnEnd: true,
            icon: L.divIcon({html: moveManIcon, iconSize: L.point(27.5, 24)})
        }).motionDuration(3000);

        moveIconPolyLines.push(motion);
    }

    if(moveIconPolyLines.length > 0) {
        moveIconTime = moveIconPolyLines.length * 3500;
        moveMarker = L.motion.seq(moveIconPolyLines).addTo(planMap);
        reloadMoveMarker();
    }
}

function reloadMoveMarker(){
    moveMarker.motionStop();
    moveMarker.motionStart();
    setTimeout(reloadMoveMarker, moveIconTime);
}

function createTourPlaces(_events){
    events = _events;
    if(events.length > 2){
        createPlanBox();
        createMarkers();
    }
    else
        document.getElementById('dayInfoSection').remove();
}
$(document).ready(() => {
    initPlanMap();
});
