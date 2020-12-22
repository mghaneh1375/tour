
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

    if(sL.length > 0)
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

    if(sL.length > 0)
        hasFilter = true;

    $(".dark").show();
    show(1, 1);
}

function isInFilters(key) {

    key = parseInt(key);

    for(j = 0; j < filters.length; j++) {
        if (filters[j] == key)
            return true;
    }
    return false;
}

function getBack(curr) {

    for(i = curr - 1; i >= 0; i--) {
        if(!isInFilters(i))
            return i;
    }
    return -1;
}

function getFixedFromLeft(elem) {

    if(elem.prop('id') == topContainer || elem.prop('id') == 'PAGE') {
        return parseInt(elem.css('margin-left').split('px')[0]);
    }

    return elem.position().left +
        parseInt(elem.css('margin-left').split('px')[0]) +
        getFixedFromLeft(elem.parent());
}

function getFixedFromTop(elem) {

    if(elem.prop('id') == topContainer) {
        return marginTop;
    }

    if(elem.prop('id') == "PAGE") {
        return 0;
    }

    return elem.position().top +
        parseInt(elem.css('margin-top').split('px')[0]) +
        getFixedFromTop(elem.parent());
}

function getNext(curr) {

    curr = parseInt(curr);

    for(i = curr + 1; i < total; i++) {
        if(!isInFilters(i))
            return i;
    }
    return total;
}

function bubbles(curr) {

    if(total <= 1)
        return "";

    t = total - filters.length;
    newElement = "<div class='col-xs-12' style='position: relative'><div class='col-xs-12 bubbles' style='padding: 0; margin-right: 0; margin-left: " + ((400 - (t * 18)) / 2) + "px'>";

    for (i = 1; i < total; i++) {
        if(!isInFilters(i)) {
            if(i == curr)
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

    if(hasFilter) {
        while (isInFilters(curr)) {
            curr += inc;
        }
    }

    if(getBack(curr) <= 0) {
        $("#backBtnHelp_" + curr).attr('disabled', 'disabled');
    }
    else {
        $("#backBtnHelp_" + curr).removeAttr('disabled');
    }

    if(getNext(curr) > total - 1) {
        $("#nextBtnHelp_" + curr).attr('disabled', 'disabled');
    }
    else {
        $("#nextBtnHelp_" + curr).removeAttr('disabled');
    }

    if(curr < greenBackLimit) {
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

    for(j = 0; j < indexes.length; j++) {
        if(curr == indexes[j]) {
            targetHeight += additional[j];
            break;
        }
    }

    if($("#targetHelp_" + curr).offset().top > 200) {
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
    window.ontouchmove  = preventDefault; // mobile
    document.onkeydown  = preventDefaultForScrollKeys;
}

function enableScroll() {
    if (window.removeEventListener)
        window.removeEventListener('DOMMouseScroll', preventDefault, false);
    window.onmousewheel = document.onmousewheel = null;
    window.onwheel = null;
    window.ontouchmove = null;
    document.onkeydown = null;
}
