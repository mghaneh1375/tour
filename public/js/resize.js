/*
 * @author https://twitter.com/blurspline / https://github.com/zz85
 * See post @ http://www.lab4games.net/zz85/blog/2014/11/15/resizing-moving-snapping-windows-with-js-css/
 */

// Minimum resizable area
var minWidth = 60;
var minHeight = 40;

// Thresholds
var FULLSCREEN_MARGINS = -10;
var MARGINS = 4;

// End of what's configurable.
var clicked = null;
var onRightEdge, onBottomEdge, onLeftEdge, onTopEdge;

var rightScreenEdge, bottomScreenEdge;


var WINDOW_H = window.innerHeight;
var WINDOW_W = window.innerWidth;
var MARGINTOP = window.innerHeight * 0.1;
var MARGINLEFT = window.innerWidth * 0.05;

var preSnapped;

var b, x, y;
var selectedPane = 1;
var redraw = false;

var pane1 = document.getElementById('pane1');
var pane2 = document.getElementById('pane2');
var pane3 = document.getElementById('pane3');
var pane4 = document.getElementById('pane4');

var pane = pane1;

var fetchedPanes = [];
var placeStyles = [[]];
var srcCities = [[]];
var tags = [[]];
var similars = [[]];
var logPhotos = [[]];
var nearbyHotels = [[]];
var nearbyRestaurants = [[]];
var nearbyAmakens = [[]];

function changeSelectedPane(idx) {

    $("#pane1").css('border', '');
    $("#pane2").css('border', '');
    $("#pane3").css('border', '');
    $("#pane4").css('border', '');

    switch (idx) {
        case '1':
        default:
            pane = pane1;
            selectedPane = 1;
            $("#pane1").css('border-bottom', '2px solid #923019');
            $("#pane1").css('border-right', '2px solid #923019');
            break;
        case '2':
            pane = pane2;
            selectedPane = 2;
            $("#pane2").css('border-bottom', '2px solid #923019');
            $("#pane2").css('border-left', '2px solid #923019');
            break;
        case '3':
            pane = pane3;
            selectedPane = 3;
            $("#pane3").css('border-top', '2px solid #923019');
            $("#pane3").css('border-right', '2px solid #923019');
            break;
        case '4':
            pane = pane4;
            selectedPane = 4;
            $("#pane4").css('border-top', '2px solid #923019');
            $("#pane4").css('border-left', '2px solid #923019');
            break;
    }


// Mouse events
    pane.addEventListener('mousedown', onMouseDown);

    document.addEventListener('mousemove', onMove);
    document.addEventListener('mouseup', onUp);

// Touch events
    pane.addEventListener('touchstart', onTouchDown);
    document.addEventListener('touchmove', onTouchMove);
    document.addEventListener('touchend', onTouchEnd);

    animate();
}

function setBounds(element, x, y, w, h) {
    element.style.left = x + 'px';
    element.style.top = y + 'px';
    element.style.width = w + 'px';
    element.style.height = h + 'px';
}

$(document).ready(function () {
   changeSelectedPane('1');
});

// Mouse events
pane.addEventListener('mousedown', onMouseDown);

document.addEventListener('mousemove', onMove);
document.addEventListener('mouseup', onUp);

// Touch events	
pane.addEventListener('touchstart', onTouchDown);
document.addEventListener('touchmove', onTouchMove);
document.addEventListener('touchend', onTouchEnd);


function onTouchDown(e) {
    onDown(e.touches[0]);
    e.preventDefault();
}

function onTouchMove(e) {
    onMove(e.touches[0]);
}

function onTouchEnd(e) {
    if (e.touches.length ==0) onUp(e.changedTouches[0]);
}

function onMouseDown(e) {
    onDown(e);
    e.preventDefault();
}

function onDown(e) {
    calc(e);

    var isResizing = onRightEdge || onBottomEdge || onTopEdge || onLeftEdge;

    clicked = {
        x: x,
        y: y,
        cx: e.clientX,
        cy: e.clientY,
        w: b.width,
        h: b.height,
        isResizing: isResizing,
        isMoving: !isResizing && canMove(),
        onTopEdge: onTopEdge,
        onLeftEdge: onLeftEdge,
        onRightEdge: onRightEdge,
        onBottomEdge: onBottomEdge
    };
}

function canMove() {
    return x > 0 && x < b.width && y > 0 && y < b.height
        && y < 30;
}

function calc(e) {

    b = pane.getBoundingClientRect();
    x = e.clientX - b.left;
    y = e.clientY - b.top;

    onTopEdge = y < MARGINS;
    onLeftEdge = x < MARGINS;
    onRightEdge = x >= b.width - MARGINS;
    onBottomEdge = y >= b.height - MARGINS;

    rightScreenEdge = window.innerWidth - MARGINS;
    bottomScreenEdge = window.innerHeight - MARGINS;
}

var e;

function onMove(ee) {
    calc(ee);

    e = ee;

    redraw = true;

}

function changeBaseOnPane1(tmpWidth, tmpHeight) {

    pane1.style.width = tmpWidth / WINDOW_W * 100 + "%";
    pane1.style.left = MARGINLEFT / WINDOW_W * 100 + "%";
    pane1.style.top = MARGINTOP / WINDOW_H * 100 + "%";
    pane1.style.height = tmpHeight / WINDOW_H * 100 + "%";

    pane2.style.left =  (tmpWidth + MARGINLEFT) / WINDOW_W * 100 + "%";
    pane2.style.width =  (WINDOW_W - tmpWidth - MARGINLEFT * 2) / WINDOW_W * 100 + "%";
    pane2.style.top = MARGINTOP / WINDOW_H * 100 + "%";
    pane2.style.height = tmpHeight / WINDOW_H * 100 + "%";

    if(pane3 != null) {
        pane3.style.width = tmpWidth / WINDOW_W * 100 + "%";
        pane3.style.left = MARGINLEFT / WINDOW_W * 100 + "%";
        pane3.style.top = (MARGINTOP + tmpHeight) / WINDOW_H * 100 + "%";
        pane3.style.height = (WINDOW_H - MARGINTOP - tmpHeight) / WINDOW_H * 100 + "%";
    }

    if(pane4 != null) {
        pane4.style.left = (MARGINLEFT + tmpWidth) / WINDOW_W * 100 + "%";
        pane4.style.width = (WINDOW_W - tmpWidth - MARGINLEFT * 2) / WINDOW_W * 100 + "%";
        pane4.style.top = (MARGINTOP + tmpHeight) / WINDOW_H * 100 + "%";
        pane4.style.height = (WINDOW_H - MARGINTOP - tmpHeight) / WINDOW_H * 100 + "%";
    }
}

function changeBaseOnPane3(tmpWidth, tmpHeight) {
    pane1.style.width = tmpWidth / WINDOW_W * 100 + "%";
    pane1.style.left = MARGINLEFT / WINDOW_W * 100 + "%";
    pane1.style.top = MARGINTOP / WINDOW_H * 100 + "%";
    pane1.style.height = (WINDOW_H - MARGINTOP - tmpHeight) / WINDOW_H * 100 + "%";

    pane2.style.left =  (tmpWidth + MARGINLEFT) / WINDOW_W * 100 + "%";
    pane2.style.width =  (WINDOW_W - tmpWidth - MARGINLEFT * 2) / WINDOW_W * 100 + "%";
    pane2.style.top = MARGINTOP / WINDOW_H * 100 + "%";
    pane2.style.height = (WINDOW_H - MARGINTOP - tmpHeight) / WINDOW_H * 100 + "%";

    pane3.style.width = tmpWidth / WINDOW_W * 100 + "%";
    pane3.style.left = MARGINLEFT / WINDOW_W * 100 + "%";
    pane3.style.top =  (WINDOW_H - tmpHeight) / WINDOW_H * 100 + "%";
    pane3.style.height = tmpHeight / WINDOW_H * 100 + "%";

    if(pane4 != null) {
        pane4.style.left = (MARGINLEFT + tmpWidth) / WINDOW_W * 100 + "%";
        pane4.style.width = (WINDOW_W - tmpWidth - MARGINLEFT * 2) / WINDOW_W * 100 + "%";
        pane4.style.top = (WINDOW_H - tmpHeight) / WINDOW_H * 100 + "%";
        pane4.style.height = tmpHeight / WINDOW_H * 100 + "%";
    }
}

function changeBaseOnPane4(tmpWidth, tmpHeight) {

    pane1.style.width = (WINDOW_W - MARGINLEFT * 2 - tmpWidth) / WINDOW_W * 100 + "%";
    pane1.style.left = MARGINLEFT / WINDOW_W * 100 + "%";
    pane1.style.top = MARGINTOP / WINDOW_H * 100 + "%";
    pane1.style.height = (WINDOW_H - MARGINTOP - tmpHeight) / WINDOW_H * 100 + "%";

    pane2.style.left =  (WINDOW_W - MARGINLEFT - tmpWidth) / WINDOW_W * 100 + "%";
    pane2.style.width =  tmpWidth / WINDOW_W * 100 + "%";
    pane2.style.top = MARGINTOP / WINDOW_H * 100 + "%";
    pane2.style.height = (WINDOW_H - MARGINTOP - tmpHeight) / WINDOW_H * 100 + "%";

    pane3.style.width = (WINDOW_W - MARGINLEFT * 2 - tmpWidth) / WINDOW_W * 100 + "%";
    pane3.style.left = MARGINLEFT / WINDOW_W * 100 + "%";
    pane3.style.top =  (WINDOW_H - tmpHeight) / WINDOW_H * 100 + "%";
    pane3.style.height = tmpHeight / WINDOW_H * 100 + "%";

    pane4.style.left =  (WINDOW_W - MARGINLEFT - tmpWidth) / WINDOW_W * 100 + "%";
    pane4.style.width =  tmpWidth / WINDOW_W * 100 + "%";
    pane4.style.top = (WINDOW_H - tmpHeight) / WINDOW_H * 100 + "%";
    pane4.style.height = tmpHeight / WINDOW_H * 100 + "%";
}

function changeBaseOnPane2(tmpWidth, tmpHeight) {

    pane1.style.width = (WINDOW_W - MARGINLEFT * 2 - tmpWidth) / WINDOW_W * 100 + "%";
    pane1.style.left = MARGINLEFT / WINDOW_W * 100 + "%";
    pane1.style.top = MARGINTOP / WINDOW_H * 100 + "%";
    pane1.style.height = tmpHeight / WINDOW_H * 100 + "%";

    pane2.style.left =  (WINDOW_W - MARGINLEFT - tmpWidth) / WINDOW_W * 100 + "%";
    pane2.style.width =  tmpWidth / WINDOW_W * 100 + "%";
    pane2.style.top = MARGINTOP / WINDOW_H * 100 + "%";
    pane2.style.height = tmpHeight / WINDOW_H * 100 + "%";

    if(pane3 != null) {
        pane3.style.width = (WINDOW_W - MARGINLEFT * 2 - tmpWidth) / WINDOW_W * 100 + "%";
        pane3.style.left = MARGINLEFT / WINDOW_W * 100 + "%";
        pane3.style.top = (MARGINTOP + tmpHeight) / WINDOW_H * 100 + "%";
        pane3.style.height = (WINDOW_H - MARGINTOP - tmpHeight) / WINDOW_H * 100 + "%";
    }

    if(pane4 != null) {
        pane4.style.left = (WINDOW_W - MARGINLEFT - tmpWidth) / WINDOW_W * 100 + "%";
        pane4.style.width = tmpWidth / WINDOW_W * 100 + "%";
        pane4.style.top = (MARGINTOP + tmpHeight) / WINDOW_H * 100 + "%";
        pane4.style.height = (WINDOW_H - MARGINTOP - tmpHeight) / WINDOW_H * 100 + "%";
    }
}

function animate() {

    requestAnimationFrame(animate);

    if (!redraw) return;

    redraw = false;

    if (clicked && clicked.isResizing) {

        $("#borderElements").empty();

        if (clicked.onRightEdge && (selectedPane == 1 || selectedPane == 3))  {

            tmpWidth = Math.max(x, minWidth);
            tmpHeight = Math.max(minHeight, pane.style.height);

            if(selectedPane == 1)
                changeBaseOnPane1(tmpWidth, tmpHeight);
            else
                changeBaseOnPane3(tmpWidth, tmpHeight);
        }

        if (clicked.onBottomEdge) {

            if(selectedPane == 1 || selectedPane == 2) {

                tmpWidth = Math.max(x, pane.style.width);
                tmpHeight = Math.max(minHeight, y);

                if(selectedPane == 1)
                    changeBaseOnPane1(tmpWidth, tmpHeight);
                else
                    changeBaseOnPane2(tmpWidth, tmpHeight);
            }
        }

        if (clicked.onLeftEdge) {

            if(selectedPane == 2 || selectedPane == 4) {

                x1 = pane.style.width.split("px");
                if(x1.length != 2)
                    x1 = pane.style.width.split("%")[0] / 100 * WINDOW_W;
                else
                    x1 = pane.style.width.split("px")[0];

                tmpWidth = Math.max(x1 - x, minWidth);
                tmpHeight = Math.max(minHeight, pane.style.height);

                if(selectedPane == 2)
                    changeBaseOnPane2(tmpWidth, tmpHeight);
                else if(selectedPane == 4)
                    changeBaseOnPane4(tmpWidth, tmpHeight);

            }
        }

        if (clicked.onTopEdge) {
            if(selectedPane == 3 || selectedPane == 4) {

                y1 = pane.style.height.split("px");
                if(y1.length != 2) {
                    y1 = pane.style.height.split("vh");
                    if(y1.length != 2)
                        y1 = pane.style.height.split("%")[0] / 100 * WINDOW_H;
                    else
                        y1 = pane.style.height.split("vh")[0] / 100 * WINDOW_H;
                }
                else
                    y1 = pane.style.height.split("px")[0];

                var tmpHeight = Math.max(minHeight, y1 - y);
                var tmpWidth = Math.max(minWidth, pane.style.width);

                if(selectedPane == 3)
                    changeBaseOnPane3(tmpWidth, tmpHeight);
                else
                    changeBaseOnPane4(tmpWidth, tmpHeight);
            }
        }

        return;
    }

    if (clicked && clicked.isMoving) {

        if (preSnapped) {
            setBounds(pane,
                e.clientX - preSnapped.width / 2,
                e.clientY - Math.min(clicked.y, preSnapped.height),
                preSnapped.width,
                preSnapped.height
            );
            return;
        }

        // moving
        pane.style.top = (e.clientY - clicked.y) + 'px';
        pane.style.left = (e.clientX - clicked.x) + 'px';

        return;
    }

    // This code executes when mouse moves without clicking

    // style cursor
    if (onRightEdge && onBottomEdge || onLeftEdge && onTopEdge) {
        pane.style.cursor = 'nwse-resize';
    }

    else if (onRightEdge && onTopEdge || onBottomEdge && onLeftEdge) {
        pane.style.cursor = 'nesw-resize';
    }

    else if (onRightEdge || onLeftEdge) {
        pane.style.cursor = 'ew-resize';
    }

    else if (onBottomEdge || onTopEdge) {
        pane.style.cursor = 'ns-resize';
    }

    else {
        pane.style.cursor = 'default';
    }
}

animate();

function showBtns() {

    $("#borderElements").empty();

    $("#borderElements").append('<button onclick="changeMainPane(1)" id="btn12" style="background-color: #963019; color: #FFF; z-index: 10001; position: absolute; left: 5%; top: 0; width: 5%; height: 10%">' + $("#pane1").attr('data-val') + '</button>');
    $("#borderElements").append('<button onclick="changeMainPane(2)" id="btn22" style="background-color: #963019; color: #FFF; z-index: 10001; position: absolute; left: 90%; width: 5%; top: 0; height: 10%">' + $("#pane2").attr('data-val') + '</button>');
    $("#borderElements").append('<button onclick="changeMainPane(3)" id="btn32" style="background-color: #963019; color: #FFF; z-index: 10001; position: absolute; left: 5%; width: 5%; top: 80%; height: 10%">' + $("#pane3").attr('data-val') + '</button>');
    $("#borderElements").append('<button onclick="changeMainPane(4)" id="btn42" style="background-color: #963019; color: #FFF; z-index: 10001; position: absolute; left: 90%; width: 5%; top: 80%; height: 10%">' + $("#pane4").attr('data-val') + '</button>');

    $("#borderElements").append('<div id="pane11" style="background-color: rgba(77, 199, 188, 0.50); z-index: 10000; position: absolute; left: 5%; width: 5%; top: 10%; height: 70%"></div>');
    $("#borderElements").append('<div id="pane22" style="background-color: rgba(77, 199, 188, 0.50); z-index: 10000; position: absolute; left: 10%; width: 80%; top: 0; height: 10%"></div>');
    $("#borderElements").append('<div id="pane33" style="background-color: rgba(77, 199, 188, 0.50); z-index: 10000; position: absolute; left: 10%; width: 80%; top: 80%; height: 10%"></div>');
    $("#borderElements").append('<div id="pane44" style="background-color: rgba(77, 199, 188, 0.50); z-index: 10000; position: absolute; left: 90%; width: 5%; top: 10%; height: 70%"></div>');
}

function showPlaceStyles(idxArr, idxPane) {

    var newElement = "";
    var i;

    for(i = 0; i < placeStyles[idxArr].length; i++) {
        newElement += '<li class="filterItem">';
        newElement += "<div class='ui_input_checkbox'>";
        newElement += '<input onclick="filter(\'' + idxPane + '\')" type="checkbox" id="placeStyle_' + placeStyles[idxArr][i].id + '" value="placeStyle_' + placeStyles[idxArr][i].id + '" name="filterComment_' + idxPane + '[]" class="filterInput">';
        newElement += "<label class='labelForCheckBox' id='placeStyle_" + placeStyles[idxArr][i].id + "'>";
        newElement += "<span></span>&nbsp;&nbsp;" + placeStyles[idxArr][i].name;
        newElement += "</label></div></li>";
    }

    $("#placeStyles_" + idxPane).empty().append(newElement);
}

function showSrcCities(idxArr, idxPane) {

    var limit = (srcCities[idxArr].length > 4) ? 4 : srcCities[idxArr].length;
    var i;
    var newElement = "";

    for(i = 0; i < limit; i++) {
        newElement += '<li class="filterItem">';
        newElement += "<div class='ui_input_checkbox'>";
        newElement += '<input onclick="filter(\'' + idxPane + '\')" value="srcCity_' + srcCities[idxArr][i].src + '" id="srcCity_' + srcCities[idxArr][i].src + '" type="checkbox" name="filterComment_' + idxPane + '[]" class="filterInput">';
        newElement += "<label class='labelForCheckBox' for='srcCity_" + srcCities[idxArr][i].src + "'>";
        newElement += "<span></span>&nbsp;&nbsp;" + srcCities[idxArr][i].src;
        newElement += "</label></div></li>"
    }

    if(srcCities[idxArr].length > 4)
        newElement += '<li class="filterItem"><span class="toggle"></span><span onclick="toggleMoreCities(\'' + idxPane + '\')" id="moreLessSpan_' + idxPane + '" class="taLnk more">شهرهای بیشتر</span></li>';

    $("#srcCities_" + idxPane).empty().append(newElement);

    if(srcCities[idxArr].length > 4) {
        newElement = "";
        for(i = 4; srcCities[idxArr].length; i++) {
            newElement += '<li class="filterItem">';
            newElement += "<div class='ui_input_checkbox'>";
            newElement += '<input onclick="filter(\'' + idxPane + '\')" value="srcCity_' + srcCities[idxArr][i].src + '" id="srcCity_' + srcCities[idxArr][i].src + '" type="checkbox" name="filterComment_' + idxPane + '[]" class="filterInput">"';
            newElement += "<label class='labelForCheckBox' for='srcCity_" + srcCities[idxArr][i].src + "'>";
            newElement += "<span></span>&nbsp;&nbsp;" + srcCities[idxArr][i].src;
            newElement += "</label></div></li>";
        }

        $("#moreCitiesItems_" + idxPane).empty().append(newElement);
    }
}

function showTags(idxArr, idxPane) {

    var i;
    var newElement = "";

    for(i = 0; i < tags[idxArr].length; i++) {
        newElement += '<span class="ui_tagcloud fl" data-val-idx="' + tags[idxArr][i].id +'" data-content="' + tags[idxArr][i].name + '">' + tags[idxArr][i].name + '</span>';
    }

    $("#tagsItems_" + idxPane).empty().append(newElement);
}

function showSimilars(idxArr, idxPane) {

    var i;
    var newElement = "";
    
    for(i = 0; i < similars[idxArr].length; i++) {
        
        newElement += '<div style="cursor: pointer;" onclick="document.location.href = ';
        // if(placeModes[idxPane] == 'hotel')
        //     newElement += homeURL + "/hotel-details/" + similars[idxArr][i].id + "/" + similars[idxArr][i].name;
        // else if(placeModes[idxPane] == 'amaken')
        //     newElement += homeURL + "/amaken-details/" + similars[idxArr][i].id + "/" + similars[idxArr][i].name;
        // else if(placeModes[idxPane] == 'restaurant')
        //     newElement += homeURL + "/restaurant-details/" + similars[idxArr][i].id + "/" + similars[idxArr][i].name;

        if(placeModes[idxPane] == 'hotel')
            var urlKind = 'hotels';
        else if(placeModes[idxPane] == 'amaken')
            var urlKind = 'amaken';
        else if(placeModes[idxPane] == 'restaurant')
            var urlKind = 'restaurant';

        newElement += homeURL + "/show-place-details/" + urlKind + "/" + similars[idxArr][i].slug;





        newElement += '" class="ui_column is-3 rec">';
        newElement += '<div class="recommendedCard">';
        newElement += '<div class="imageContainer">';
        newElement += '<DIV class="prw_rup prw_common_centered_image">';
        newElement += '<span class="imgWrap" style="max-width:364px;max-height:166px;">';
        newElement += '<img src="' + similars[idxArr][i].pic + '" class="centeredImg" style=" min-width:209px; " width="100%"/>';
        newElement += "</span></DIV></div>";
        newElement += '<div class="content">';
        newElement += '<div class="hotelName" dir="auto" style="height: auto">' + similars[idxArr][i].name + '</div>';
        newElement += '<div class="ratings">';
        newElement += '<span><DIV class="prw_rup prw_common_bubble_rating bubbleRating">';
        switch (similars[idxArr][i].rate) {
            case 5:
                newElement += '<span class="ui_bubble_rating bubble_50" style="font-size:16px;" property="ratingValue" content="5" alt="5 of 5 bubbles"></span>';
                break;
            case 4:
                newElement += '<span class="ui_bubble_rating bubble_40" style="font-size:16px;" property="ratingValue" content="4" alt="4 of 5 bubbles"></span>';
                break;
            case 3:
                newElement += '<span class="ui_bubble_rating bubble_30" style="font-size:16px;" property="ratingValue" content="3" alt="3 of 5 bubbles"></span>';
                break;
            case 2:
                newElement += '<span class="ui_bubble_rating bubble_20" style="font-size:16px;" property="ratingValue" content="2" alt="2 of 5 bubbles"></span>';
                break;
            default:
                newElement += '<span class="ui_bubble_rating bubble_10" style="font-size:16px;" property="ratingValue" content="1" alt="1 of 5 bubbles"></span>';
        }

        newElement += '</DIV></span>';
        newElement += '<a style="text-align: left;" class="reviewCount">' + similars[idxArr][i].reviews + ' نقد</a>';
        newElement += "</div></div></div></div>";
    }

    $("#similarsItems_" + idxPane).empty().append(newElement);

}

function showLogPhotos(idxArr, idxPane) {

    var i;
    var newElement = "";
    var sum = 0;

    for(i = 0; i < logPhotos[idxArr].length; i++) {
        newElement += '<DIV class="prw_rup prw_hotels_flexible_album_thumb albumThumbnailWrap ui_column is-6">';
        newElement += '<div class="albumThumbnail">';
        newElement += '<DIV class="prw_rup prw_common_centered_image">';
        newElement += '<span class="imgWrap" style="max-width:267px;max-height:200px;">';
        newElement += '<img src="' + logPhotos[idxArr][i].text + '" class="centeredImg" style=" min-width:267px; " width="100%"/>';
        newElement += "</span></DIV>";
        newElement += '<div class="albumInfo">';
        newElement += '<span class="ui_icon camera"></span>' + logPhotos[idxArr][i].name + ' ' + logPhotos[idxArr][i].countNum;
        newElement += '</div></div></DIV>';
        sum += parseInt(logPhotos[idxArr][i].countNum);
    }
    $("#logPhotosItems_" + idxPane).empty().append(newElement);

    newElement = '<span class="ui_icon camera"></span>همه عکس ها ' + sum;
    $("#see_all_count").empty().append(newElement);
}

function showNearbyHotels(idxArr, idxPane) {

    var i;
    var newElement = "";

    for(i = 0; i < nearbyHotels[idxArr].length; i++) {

        newElement += '<div style="cursor: pointer;" onclick="document.location.href = ';
        newElement += homeURL + "/show-place-details/hotels/" + nearbyHotels[idxArr][i].slug;

        newElement += '" class="prw_rup prw_common_btf_nearby_poi_entry ui_column is-6 poiTile">';
        newElement += '<div class="ui_columns is-gapless is-mobile poiEntry shownOnMap">';
        newElement += '<DIV class="prw_rup prw_common_centered_image ui_column is-4 thumbnailWrap">';
        newElement += '<span class="imgWrap" style="max-width:94px;max-height:80px;">';
        newElement += '<img src="' + nearbyHotels[idxArr][i].pic + '" class="centeredImg" style=" min-width:80px; " width="100%"/>';
        newElement += '</span></DIV>';
        newElement += '<div class="poiInfo ui_column is-8">';
        newElement += '<div class="poiName">' + nearbyHotels[idxArr][i].name + '</div>';
        newElement += '<DIV class="prw_rup prw_common_bubble_rating rating">';
        switch (nearbyHotels[idxArr][i].rate) {
            case 5:
                newElement += '<span class="ui_bubble_rating bubble_50" style="font-size:16px;" property="ratingValue" content="5" alt="5 of 5 bubbles"></span>';
                break;
            case 4:
                newElement += '<span class="ui_bubble_rating bubble_40" style="font-size:16px;" property="ratingValue" content="4" alt="4 of 5 bubbles"></span>';
                break;
            case 3:
                newElement += '<span class="ui_bubble_rating bubble_30" style="font-size:16px;" property="ratingValue" content="3" alt="3 of 5 bubbles"></span>';
                break;
            case 2:
                newElement += '<span class="ui_bubble_rating bubble_20" style="font-size:16px;" property="ratingValue" content="2" alt="2 of 5 bubbles"></span>';
                break;
            default:
                newElement += '<span class="ui_bubble_rating bubble_10" style="font-size:16px;" property="ratingValue" content="1" alt="1 of 5 bubbles"></span>';
        }

        newElement += '</DIV>';
        newElement += '<div class="reviewCount">' + nearbyHotels[idxArr][i].reviews+' نقد</div>';
        newElement += '<div class="distance">' + nearbyHotels[idxArr][i].distance+' کلیومتر فاصله </div>';
        newElement += '<DIV class="prw_rup prw_meta_location_nearby_xsell_rec_price pricing nearby">';
        newElement += '<div class="price"></div>';
        newElement += '<div class="loadingPrices"><span class="ui_button nearbyMeta loading disabled">&nbsp;<span class="ui_loader"><span></span><span></span><span></span><span></span><span></span></span></span></div>';
        newElement += '</DIV></div></div></DIV>';
    }

    newElement += '<div style="clear: both;"></div>';

    $("#nearbyHotelsItems_" + idxPane).empty().append(newElement);

}

function showNearbyAmakens(idxArr, idxPane) {

    var i;
    var newElement = "";

    for(i = 0; i < nearbyAmakens[idxArr].length; i++) {

        newElement += '<div style="cursor: pointer;" onclick="document.location.href = ';
        newElement += homeURL + "/amaken-details/" + nearbyAmakens[idxArr][i].id + "/" + nearbyAmakens[idxArr][i].name;

        newElement += '" class="prw_rup prw_common_btf_nearby_poi_entry ui_column is-6 poiTile">';
        newElement += '<div class="ui_columns is-gapless is-mobile poiEntry shownOnMap">';
        newElement += '<DIV class="prw_rup prw_common_centered_image ui_column is-4 thumbnailWrap">';
        newElement += '<span class="imgWrap" style="max-width:94px;max-height:80px;">';
        newElement += '<img src="' + nearbyAmakens[idxArr][i].pic + '" class="centeredImg" style=" min-width:80px; " width="100%"/>';
        newElement += '</span></DIV>';
        newElement += '<div class="poiInfo ui_column is-8">';
        newElement += '<div class="poiName">' + nearbyAmakens[idxArr][i].name + '</div>';
        newElement += '<DIV class="prw_rup prw_common_bubble_rating rating">';
        switch (nearbyAmakens[idxArr][i].rate) {
            case 5:
                newElement += '<span class="ui_bubble_rating bubble_50" style="font-size:16px;" property="ratingValue" content="5" alt="5 of 5 bubbles"></span>';
                break;
            case 4:
                newElement += '<span class="ui_bubble_rating bubble_40" style="font-size:16px;" property="ratingValue" content="4" alt="4 of 5 bubbles"></span>';
                break;
            case 3:
                newElement += '<span class="ui_bubble_rating bubble_30" style="font-size:16px;" property="ratingValue" content="3" alt="3 of 5 bubbles"></span>';
                break;
            case 2:
                newElement += '<span class="ui_bubble_rating bubble_20" style="font-size:16px;" property="ratingValue" content="2" alt="2 of 5 bubbles"></span>';
                break;
            default:
                newElement += '<span class="ui_bubble_rating bubble_10" style="font-size:16px;" property="ratingValue" content="1" alt="1 of 5 bubbles"></span>';
        }

        newElement += '</DIV>';
        newElement += '<div class="reviewCount">' + nearbyAmakens[idxArr][i].reviews+' نقد</div>';
        newElement += '<div class="distance">' + nearbyAmakens[idxArr][i].distance+' کلیومتر فاصله </div>';
        newElement += '<DIV class="prw_rup prw_meta_location_nearby_xsell_rec_price pricing nearby">';
        newElement += '<div class="price"></div>';
        newElement += '<div class="loadingPrices"><span class="ui_button nearbyMeta loading disabled">&nbsp;<span class="ui_loader"><span></span><span></span><span></span><span></span><span></span></span></span></div>';
        newElement += '</DIV></div></div></DIV>';
    }

    newElement += '<div style="clear: both;"></div>';

    $("#nearbyAmakensItems_" + idxPane).empty().append(newElement);

}

function showNearbyRestaurants(idxArr, idxPane) {

    var i;
    var newElement = "";

    for(i = 0; i < nearbyRestaurants[idxArr].length; i++) {

        newElement += '<div style="cursor: pointer;" onclick="document.location.href = ';
        newElement += homeURL + "/restaurant-details/" + nearbyRestaurants[idxArr][i].id + "/" + nearbyRestaurants[idxArr][i].name;

        newElement += '" class="prw_rup prw_common_btf_nearby_poi_entry ui_column is-6 poiTile">';
        newElement += '<div class="ui_columns is-gapless is-mobile poiEntry shownOnMap">';
        newElement += '<DIV class="prw_rup prw_common_centered_image ui_column is-4 thumbnailWrap">';
        newElement += '<span class="imgWrap" style="max-width:94px;max-height:80px;">';
        newElement += '<img src="' + nearbyRestaurants[idxArr][i].pic + '" class="centeredImg" style=" min-width:80px; " width="100%"/>';
        newElement += '</span></DIV>';
        newElement += '<div class="poiInfo ui_column is-8">';
        newElement += '<div class="poiName">' + nearbyRestaurants[idxArr][i].name + '</div>';
        newElement += '<DIV class="prw_rup prw_common_bubble_rating rating">';
        switch (nearbyRestaurants[idxArr][i].rate) {
            case 5:
                newElement += '<span class="ui_bubble_rating bubble_50" style="font-size:16px;" property="ratingValue" content="5" alt="5 of 5 bubbles"></span>';
                break;
            case 4:
                newElement += '<span class="ui_bubble_rating bubble_40" style="font-size:16px;" property="ratingValue" content="4" alt="4 of 5 bubbles"></span>';
                break;
            case 3:
                newElement += '<span class="ui_bubble_rating bubble_30" style="font-size:16px;" property="ratingValue" content="3" alt="3 of 5 bubbles"></span>';
                break;
            case 2:
                newElement += '<span class="ui_bubble_rating bubble_20" style="font-size:16px;" property="ratingValue" content="2" alt="2 of 5 bubbles"></span>';
                break;
            default:
                newElement += '<span class="ui_bubble_rating bubble_10" style="font-size:16px;" property="ratingValue" content="1" alt="1 of 5 bubbles"></span>';
        }

        newElement += '</DIV>';
        newElement += '<div class="reviewCount">' + nearbyRestaurants[idxArr][i].reviews+' نقد</div>';
        newElement += '<div class="distance">' + nearbyRestaurants[idxArr][i].distance+' کلیومتر فاصله </div>';
        newElement += '<DIV class="prw_rup prw_meta_location_nearby_xsell_rec_price pricing nearby">';
        newElement += '<div class="price"></div>';
        newElement += '<div class="loadingPrices"><span class="ui_button nearbyMeta loading disabled">&nbsp;<span class="ui_loader"><span></span><span></span><span></span><span></span><span></span></span></span></div>';
        newElement += '</DIV></div></div></DIV>';
    }

    newElement += '<div style="clear: both;"></div>';

    $("#nearbyRestaurantsItems_" + idxPane).empty().append(newElement);

}

function showPane1() {

    showBtns();

    pane1.style.left = 5 + "%";
    pane1.style.width = 85 + "%";
    pane1.style.height = 70 + "%";
    pane1.style.top = 20 + "%";

    if(pane4 != null) {
        pane4.style.top = 20 + "%";
        pane4.style.width = 5 + "%";
        pane4.style.height = 70 + "%";
        pane4.style.left = 90 + "%";
    }

    if(pane3 != null) {
        pane3.style.top = 90 + "%";
        pane3.style.left = 10 + "%";
        pane3.style.width = 80 + "%";
        pane3.style.height = 10 + "%";
    }

    pane2.style.left = 10 + "%";
    pane2.style.top = 10 + "%";
    pane2.style.width = 80 + "%";
    pane2.style.height = 10 + "%";

    $("#photoSliderDiv_0").css('height', '300px');
    $('#afterCSS').empty().append('<style>.atf_meta_and_photos_wrapper:before{height: 320px !important;}</style>');
    $("#table_0").css('height', '200px');

    $("#stickyMenu_0").removeClass('hidden');

    if($('#dastoor_0').length != 0) {
        offsetHeight = $('#dastoor_0').prop('offsetHeight');
        scrollHeight = $('#dastoor_0').prop('scrollHeight');

        if (offsetHeight < scrollHeight)
            $('#showMoreDastoor_0').removeClass('hidden');
        else {
            $('#showMoreDastoor_0').addClass('hidden');
        }
    }

    if($('#introductionText_0').length != 0) {
        offsetHeight = $('#introductionText_0').prop('offsetHeight');
        scrollHeight = $('#introductionText_0').prop('scrollHeight');

        if (offsetHeight < scrollHeight)
            $('#showMore_0').removeClass('hidden');
        else {
            $('#showMore_0').addClass('hidden');
        }
    }

    init(0);
}

function showPane2() {

    showBtns();

    pane1.style.left = 5 + "%";
    pane1.style.width = 5 + "%";
    pane1.style.height = 70 + "%";
    pane1.style.top = 20 + "%";

    if(pane4 != null) {
        pane4.style.top = 20 + "%";
        pane4.style.width = 5 + "%";
        pane4.style.height = 70 + "%";
        pane4.style.left = 90 + "%";
    }

    if(pane3 != null) {
        pane3.style.top = 90 + "%";
        pane3.style.left = 10 + "%";
        pane3.style.width = 80 + "%";
        pane3.style.height = 10 + "%";
    }

    pane2.style.left = 10 + "%";
    pane2.style.top = 10 + "%";
    pane2.style.width = 80 + "%";
    pane2.style.height = 80 + "%";

    $("#stickyMenu_1").removeClass('hidden');

    $("#photoSliderDiv_1").css('height', '300px');
    $('#afterCSS').empty().append('<style>.atf_meta_and_photos_wrapper:before{height: 320px !important;}</style>');
    $("#table_1").css('height', '200px');

    if($('#dastoor_1').length != 0) {
        offsetHeight = $('#dastoor_1').prop('offsetHeight');
        scrollHeight = $('#dastoor_1').prop('scrollHeight');

        if (offsetHeight < scrollHeight)
            $('#showMoreDastoor_1').removeClass('hidden');
        else {
            $('#showMoreDastoor_1').addClass('hidden');
        }
    }

    if($('#introductionText_1').length != 0) {
        offsetHeight = $('#introductionText_1').prop('offsetHeight');
        scrollHeight = $('#introductionText_1').prop('scrollHeight');

        if (offsetHeight < scrollHeight)
            $('#showMore_1').removeClass('hidden');
        else {
            $('#showMore_1').addClass('hidden');
        }
    }

    init(1);
}

function showPane3() {

    showBtns();
    pane1.style.left = 5 + "%";
    pane1.style.width = 5 + "%";
    pane1.style.height = 70 + "%";
    pane1.style.top = 20 + "%";

    pane3.style.top = 20 + "%";
    pane3.style.width = 80 + "%";
    pane3.style.height = 80 + "%";
    pane3.style.left = 10 + "%";

    if(pane4 != null) {
        pane4.style.top = 20 + "%";
        pane4.style.left = 90 + "%";
        pane4.style.width = 5 + "%";
        pane4.style.height = 70 + "%";
    }

    pane2.style.left = 10 + "%";
    pane2.style.top = 10 + "%";
    pane2.style.width = 80 + "%";
    pane2.style.height = 10 + "%";

    $("#stickyMenu_2").removeClass('hidden');

    $("#photoSliderDiv_2").css('height', '300px');
    $('#afterCSS').empty().append('<style>.atf_meta_and_photos_wrapper:before{height: 320px !important;}</style>');
    $("#table_2").css('height', '200px');

    if($('#dastoor_2').length != 0) {
        offsetHeight = $('#dastoor_2').prop('offsetHeight');
        scrollHeight = $('#dastoor_2').prop('scrollHeight');

        if (offsetHeight < scrollHeight)
            $('#showMoreDastoor_2').removeClass('hidden');
        else {
            $('#showMoreDastoor_2').addClass('hidden');
        }
    }

    if($('#introductionText_2').length != 0) {
        offsetHeight = $('#introductionText_2').prop('offsetHeight');
        scrollHeight = $('#introductionText_2').prop('scrollHeight');

        if (offsetHeight < scrollHeight)
            $('#showMore_2').removeClass('hidden');
        else {
            $('#showMore_2').addClass('hidden');
        }
    }

    init(2);
}

function showPane4() {

    showBtns();

    pane1.style.left = 5 + "%";
    pane1.style.width = 5 + "%";
    pane1.style.height = 70 + "%";
    pane1.style.top = 20 + "%";

    pane3.style.top = 90 + "%";
    pane3.style.width = 80 + "%";
    pane3.style.height = 10 + "%";
    pane3.style.left = 10 + "%";

    pane4.style.top = 20 + "%";
    pane4.style.left = 10 + "%";
    pane4.style.width = 80 + "%";
    pane4.style.height = 70 + "%";

    pane2.style.left = 10 + "%";
    pane2.style.top = 10 + "%";
    pane2.style.width = 80 + "%";
    pane2.style.height = 10 + "%";

    $("#stickyMenu_3").removeClass('hidden');
    $("#photoSliderDiv_3").css('height', '300px');
    $('#afterCSS').empty().append('<style>.atf_meta_and_photos_wrapper:before{height: 320px !important;}</style>');
    $("#table_3").css('height', '200px');

    if($('#dastoor_3').length != 0) {
        offsetHeight = $('#dastoor_3').prop('offsetHeight');
        scrollHeight = $('#dastoor_3').prop('scrollHeight');

        if (offsetHeight < scrollHeight)
            $('#showMoreDastoor_3').removeClass('hidden');
        else {
            $('#showMoreDastoor_3').addClass('hidden');
        }
    }

    if($('#introductionText_3').length != 0) {
        offsetHeight = $('#introductionText_3').prop('offsetHeight');
        scrollHeight = $('#introductionText_3').prop('scrollHeight');

        if (offsetHeight < scrollHeight)
            $('#showMore_3').removeClass('hidden');
        else {
            $('#showMore_3').addClass('hidden');
        }
    }

    init(3);
}

function chooseMax() {

    s = [];

    x1 = pane1.style.width.split("%")[0];
    y1 = pane1.style.height.split("%")[0];
    s[0] = x1 * y1;

    x1 = pane2.style.width.split("%")[0];
    y1 = pane2.style.height.split("%")[0];
    s[1] = x1 * y1;

    if(pane3 != null) {
        x1 = pane3.style.width.split("%")[0];
        y1 = pane3.style.height.split("%")[0];
        s[2] = x1 * y1;
    }

    if(pane4 != null) {
        x1 = pane4.style.width.split("%")[0];
        y1 = pane4.style.height.split("%")[0];
        s[3] = x1 * y1;
    }

    idx = 0;
    max = s[0];

    for(i = 1; i < s.length; i++) {
        if(s[i] > max) {
            max = s[i];
            idx = i;
        }
    }

    counter = 0;
    for(i = 0; i < s.length; i++) {
        if(s[i] == max) {
            counter++;
        }
    }

    getAjaxElems(idx);

    if(counter == 1) {
        switch (idx) {
            case 0:
            default:
                return showPane1();
            case 1:
                return showPane2();
            case 2:
                return showPane3();
            case 3:
                return showPane4();
        }
    }

    switch (selectedPane) {
        case 1:
        default:
            if(s[0] == max)
                return showPane1();
            if(s[1] == max)
                return showPane2();
            return showPane3();
        case 2:
            if(s[1] == max)
                return showPane2();
            if(s[0] == max)
                return showPane1();
            return showPane4();
        case 3:
            if(s[2] == max)
                return showPane3();
            if(s[0] == max)
                return showPane1();
            return showPane4();
        case 4:
            if(s[3] == max)
                return showPane4();
            if(s[2] == max)
                return showPane3();
            return showPane2();
    }
}

function onUp(e) {

    calc(e);

    if(clicked != null && clicked.isResizing) {
        
        $(".stickyMenuDiv").addClass('hidden');
        $(".photoSliderDiv").css('height', '150px');
        $(".tableDiv").css('height', '150px');
        $('#afterCSS').empty();

        clicked = null;

        if (pane1.style.width.split("%")[0] < 30 ||
            pane1.style.height.split("%")[0] < 30 ||
            pane2.style.width.split("%")[0] < 30 ||
            pane2.style.height.split("%")[0] < 30 ||
            (pane3 != null && (pane3.style.width.split("%")[0] < 30 ||
            pane3.style.height.split("%")[0] < 30)) ||
            (pane4 != null && (pane4.style.width.split("%")[0] < 30 ||
            pane4.style.height.split("%")[0] < 30))
        )
            chooseMax();
    }
    else
        clicked = null;

}

function init(idx) {

    var mapOptions = {

        zoom: 14,

        center: new google.maps.LatLng(x, y),

        // How you would like to style the map.
        // This is where you would paste any style found on Snazzy Maps.
        styles: [	{		"featureType":"landscape",		"stylers":[			{				"hue":"#FFA800"			},			{				"saturation":0			},			{				"lightness":0			},			{				"gamma":1			}		]	},	{		"featureType":"road.highway",		"stylers":[			{				"hue":"#53FF00"			},			{				"saturation":-73			},			{				"lightness":40			},			{				"gamma":1			}		]	},	{		"featureType":"road.arterial",		"stylers":[			{				"hue":"#FBFF00"			},			{				"saturation":0			},			{				"lightness":0			},			{				"gamma":1			}		]	},	{		"featureType":"road.local",		"stylers":[			{				"hue":"#00FFFD"			},			{				"saturation":0			},			{				"lightness":30			},			{				"gamma":1			}		]	},	{		"featureType":"water",		"stylers":[			{				"hue":"#00BFFF"			},			{				"saturation":6			},			{				"lightness":8			},			{				"gamma":1			}		]	},	{		"featureType":"poi",		"stylers":[			{				"hue":"#679714"			},			{				"saturation":33.4			},			{				"lightness":-25.4			},			{				"gamma":1			}		]	}]
    };

    // Get the HTML DOM element that will contain your map
    // We are using a div with id="map" seen below in the <body>
    var mapElement = document.getElementById('map_' + idx);

    x = $("#map_" + idx).attr('data-val-x');
    y = $("#map_" + idx).attr('data-val-y');

    // Create the Google Map using our element and options defined above
    var map = new google.maps.Map(mapElement, mapOptions);

    // Let's also add a marker while we're at it
    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(x, y),
        map: map,
        title: 'Shazdemosafer!'
    });
}

function getAjaxElems(idxPane) {

    var i;
    var allow = true;

    for(i = 0; i < fetchedPanes.length; i++) {
        if(fetchedPanes[i] == idxPane) {
            allow = false;
            break;
        }
    }

    if(allow) {
        fetchedPanes[i] = idxPane;

        $("#reminderItems_" + idxPane).addClass('hidden');
        $("#loader_" + idxPane).removeClass('hidden');

        $.ajax({
            type: 'post',
            url: getPlaceStyles,
            data: {
                'kindPlaceId': kindPlaceIds[idxPane]
            },
            success: function (response) {
                placeStyles[i] = JSON.parse(response);
                showPlaceStyles(i, idxPane);
            }
        });

        $.ajax({
            type: 'post',
            url: getTags,
            data: {
                'kindPlaceId': kindPlaceIds[idxPane]
            },
            success: function (response) {
                tags[i] = JSON.parse(response);
                showTags(i, idxPane);
            }
        });

        $.ajax({
            type: 'post',
            url: getLogPhotos,
            data: {
                'placeId': placeIds[idxPane],
                'kindPlaceId': kindPlaceIds[idxPane]
            },
            success: function (response) {
                logPhotos[i] = JSON.parse(response);
                showLogPhotos(i, idxPane);
            }
        });

        $.ajax({
            type: 'post',
            url: getNearby,
            data: {
                'placeId': placeIds[idxPane],
                'kindPlaceId': kindPlaceIds[idxPane]
            },
            success: function (response) {
                var tmp = JSON.parse(response);
                nearbyHotels[i] = tmp[0];
                showNearbyHotels(i, idxPane);
                nearbyRestaurants[i] = tmp[1];
                showNearbyRestaurants(i, idxPane);
                nearbyAmakens[i] = tmp[2];
                showNearbyAmakens(i, idxPane);

                $("#reminderItems_" + idxPane).removeClass('hidden');
                $("#loader_" + idxPane).addClass('hidden');
            }
        });

        var url = (placeModes[idxPane] == 'hotel') ? getSimilarsHotel : (placeModes[idxPane] == 'amaken') ? getSimilarsAmaken : getSimilarsRestaurant;

        $.ajax({
            type: 'post',
            url: url,
            data: {
                'placeId': placeIds[idxPane]
            },
            success: function (response) {
                similars[i] = JSON.parse(response);
                showSimilars(i, idxPane);
            }
        });

        $.ajax({
            type: 'post',
            url: getSrcCities,
            data: {
                'placeId': placeIds[idxPane],
                'kindPlaceId': kindPlaceIds[idxPane]
            },
            success: function (response) {
                srcCities[i] = JSON.parse(response);
                showSrcCities(i, idxPane);
            }
        });
    }

    else {
        showPlaceStyles(i, idxPane);
        showSrcCities(i, idxPane);
        showTags(i, idxPane);
        showSimilars(i, idxPane);
        showLogPhotos(i, idxPane);
        showNearbyHotels(i, idxPane);
        showNearbyAmakens(i, idxPane);
        showNearbyRestaurants(i, idxPane);
    }
}

function changeMainPane(val) {
    
    $(".DivCol").css('border', '');

    switch (val) {
        case 1:
        default:
            $("#pane1").css('border-bottom', '2px solid #923019').css('border-right', '2px solid #923019');
            pane = pane1;
            selectedPane = 1;
            getAjaxElems(0);
            return showPane1();
        case 2:
            $("#pane2").css('border-bottom', '2px solid #923019').css('border-left', '2px solid #923019');
            pane = pane2;
            selectedPane = 2;
            getAjaxElems(1);
            return showPane2();
        case 3:
            $("#pane3").css('border-top', '2px solid #923019').css('border-right', '2px solid #923019');
            pane = pane3;
            selectedPane = 3;
            getAjaxElems(2);
            return showPane3();
        case 4:
            $("#pane4").css('border-top', '2px solid #923019').css('border-left', '2px solid #923019');
            pane = pane4;
            selectedPane = 4;
            getAjaxElems(3);
            return showPane4();
    }
}
