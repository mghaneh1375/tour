
var imgPath = ['1.jpg', '2.jpg', '3.jpg', '4.jpg'];
var titles = ['گیلان', 'بندر ترکمن', 'قشم', 'گردنه حیران'];
var photoGraphers = [' ', 'عکس از علی مهدی حقدوست', 'عکس از منصور وحدانی', 'عکس از مصطفی قوینامین'];
var currIdx;
var newElement;
var options = {
    slider_Wrap: '#pbSlider0',
   slider_Threshold: 10,
   slider_Speed:600,
   slider_Ease:'ease-out',
   slider_Drag : true,
   slider_Arrows: {
       enabled : true
   },
   slider_Dots: {
       class :'.o-slider-pagination',
       enabled : true,
       preview : true
   },
   slider_Breakpoints: {
       default: {
           height: 500
       },
       tablet: {
           height: 350,
           media: 1024
       },
       smartphone: {
           height: 250,
           media: 768
       }
   }
};

var slider_Opts = $.extend({
    slider_Wrap: 'pbSlider0', // Assign a unique ID to the div.o-sliderContainer
    slider_Item: '.o-slider--item', // Single Item
    slider_Drag: true, // Your choise.. to dragIt or not to dragIt..this is the question...
    slider_Dots: { // Wanna see dots or not?
        class: '.o-slider-pagination',
        enabled: true,
        preview: true
    },
    slider_Arrows: { // Wanna see Arrows or not?
        class: '.o-slider-arrows',
        enabled: true
    },
    slider_Threshold: 25, // Percentage of  dragX before go to next/prev slider
    slider_Speed: 1000,
    slider_Ease: 'cubic-bezier(0.5, 0, 0.5, 1)',  // see http://cubic-bezier.com/
    slider_Breakpoints: { // Kind of media queries ( can add more if you know how to do it :D and if you need )
        default: {
            height: 500 //  height on desktop
        },
        tablet: {
            height: 400, // height on tablet
            media: 1024 // tablet breakpoint
        },
        smartphone: {
            height: 300, // height on smartphone
            media: 768 // smartphone breakpoint
        }
    }
}, options);

var pbSlider = {};
pbSlider.slider_Wrap = slider_Opts.slider_Wrap;
pbSlider.slider_Item = slider_Opts.slider_Item;
pbSlider.slider_Dots = slider_Opts.slider_Dots;
pbSlider.slider_Threshold = slider_Opts.slider_Threshold;
pbSlider.slider_Active = 0;
pbSlider.slider_Count = 0;
pbSlider.slider_NavWrap = '<div class="o-slider-controls"></div>';
pbSlider.slider_NavPagination = '<ul class="o-slider-pagination"></ul>';
pbSlider.slider_NavArrows = '<ul class="o-slider-arrows"><li class="o-slider-prev"><span class="icon-left-open-big"></span></li><li class="o-slider-next"><span class="icon-right-open-big"></span></li></ul>';
var thisVal;

function changeSlider(idx) {

    $(".o-slider--item").removeClass('isActive');
    $("#sliderItem_" + idx).addClass('isActive');

}

var loaderHtml = '<div class="loaderWrap">' +
    '<div class="ball-scale-multiple">' +
    '<div></div>' +
    '<div></div>' +
    '<div></div>' +
    '<div></div>' +
    '</div></div>';
$(slider_Opts.slider_Wrap).each(function () {
    $("#pbSlider0").append(loaderHtml);
});

    "use strict";
    function pbTouchSlider() {

        newElement = "<div class='o-sliderContainer' id='pbSliderWrap0' style='margin-top: 0'>";
        newElement += "<div class='o-slider' style='display: block !important;' id='pbSlider0'></div></div";

        $("#taplc_trip_search_home_default_0").append(newElement);


        pbSlider.pbInit = function (selector) {

            pbSlider.slider_Draggable = selector;
            pbSlider.slider_Count = $(pbSlider.slider_Wrap).find(pbSlider.slider_Item).length;

            $("#pbSliderWrap0").css('width', pbSlider.slider_Count * 100 + '%');
            for(var i = 0; i < pbSlider.slider_Count; i++)
                $("#sliderItem_" + i).css({'width': 100 / pbSlider.slider_Count + '%'});

            var incrSlides = 0;
            $(pbSlider.slider_Wrap).find(pbSlider.slider_Item).each(function () {
                $(this).attr('data-id', 'slide-' + (incrSlides++));
            });

            if (slider_Opts.slider_Arrows.enabled === true || slider_Opts.slider_Dots.enabled === true) {
                $(pbSlider.slider_Wrap).append(pbSlider.slider_NavWrap);
            }

            if (slider_Opts.slider_Arrows.enabled === true) {
                $(pbSlider.slider_Wrap).append(pbSlider.slider_NavArrows);
            }

            if (slider_Opts.slider_Dots.enabled === true) {

                var incrPagination = 0;
                $(pbSlider.slider_Wrap).append(pbSlider.slider_NavPagination);
                for (incrPagination; incrPagination < pbSlider.slider_Count; incrPagination++) {

                    var activeStatus = incrPagination === pbSlider.slider_Active ? ' class="isActive"' : '';
                    var gotoSlide = 'data-increase="' + [incrPagination] + '"';
                    var background = $(pbSlider.slider_Wrap).find("[data-id='slide-" + incrPagination + "']").attr('data-image');
                    
                    //background = background.replace('url(','').replace(')','').replace(/\"/gi, "");
                    if (slider_Opts.slider_Dots.preview === true) {
                        $(pbSlider.slider_Wrap).find(pbSlider.slider_Dots.class)
                            .append(
                                '<li ' + activeStatus + ' ' + gotoSlide + '>' +
                                '<span class="o-slider--preview" style="background-image:url(' + background + ')"></span>' +
                                '</li>');
                    } else {
                        $(pbSlider.slider_Wrap).find(pbSlider.slider_Dots.class)
                            .append('<li ' + activeStatus + ' ' + gotoSlide + '></li>');
                    }
                }
            }

            setTimeout(function () {
                $(pbSlider.slider_Item + '[data-id=slide-' + pbSlider.slider_Active + ']').addClass('isActive');
            }, 400);

            $(pbSlider.slider_Wrap + ' .o-slider-pagination li').on('click', function () {

                var this_data = $(this).attr('data-increase');
                if (!$(this).hasClass('isActive')) {
                    pbSlider.pbGoslide(this_data);
                }
                //console.log(this_data + ' / ' + pbSlider.slider_Active );
            });

            $(pbSlider.slider_Wrap + ' .o-slider-prev').addClass('isDisabled');

            $(pbSlider.slider_Wrap + ' .o-slider-arrows li').on('click', function () {

                if ($(this).hasClass('o-slider-next')) {
                    pbSlider.pbGoslide(pbSlider.slider_Active + 1);
                } else {
                    pbSlider.pbGoslide(pbSlider.slider_Active - 1);
                }
            });
        };

        pbSlider.pbGoslide = function (number) {

            $(pbSlider.slider_Wrap + ' .o-slider-arrows li').removeClass('isDisabled');

            if (number < 0) {
                pbSlider.slider_Active = 0;
            } else if (number > pbSlider.slider_Count - 1) {
                pbSlider.slider_Active = pbSlider.slider_Count - 1;
            } else {
                pbSlider.slider_Active = number;
            }

            if (pbSlider.slider_Active >= pbSlider.slider_Count - 1) {
                var firstS = $(pbSlider.slider_Wrap).find(pbSlider.slider_Item).first();
                $(pbSlider.slider_Wrap + ' .o-slider-next').addClass('isDisabled');
            } else if (pbSlider.slider_Active <= 0) {
                $(pbSlider.slider_Wrap + ' .o-slider-prev').addClass('isDisabled');
            } else {
                $(pbSlider.slider_Wrap + ' .o-slider-arrows li').removeClass('isDisabled');
            }
            if (pbSlider.slider_Active != pbSlider.slider_Count - 1 && pbSlider.slider_Active != 0) {
                $(pbSlider.slider_Wrap).find(pbSlider.slider_Item).addClass('isMoving');

            }

            $(pbSlider.slider_Item).css('transform', '');

            pbSlider.slider_Draggable = "#sliderItem_" + number;

            $(pbSlider.slider_Draggable).addClass('isAnimate');
            var percentage = -(100 * pbSlider.slider_Active);
            $(pbSlider.slider_Draggable).css({
                'perspective': '1000px',
                'backface-visibility': 'hidden',
                'transform': 'translateX( ' + percentage + '% )'
            });
            clearTimeout(pbSlider.timer);

            pbSlider.timer = setTimeout(function () {
                $(pbSlider.slider_Wrap).find(pbSlider.slider_Draggable).removeClass('isAnimate');
                $(pbSlider.slider_Wrap).find(pbSlider.slider_Item).removeClass('isActive').removeClass('isMoving');
                $(pbSlider.slider_Wrap).find(pbSlider.slider_Item + '[data-id=slide-' + pbSlider.slider_Active + ']').addClass('isActive');
                $(pbSlider.slider_Wrap + ' .o-slider--item img').css('transform', 'translateX(0px )');
            }, slider_Opts.slider_Speed);
            if (slider_Opts.slider_Dots.enabled === true) {
                var sliderDots = $(pbSlider.slider_Wrap).find(pbSlider.slider_Dots.class + ' > *');
                var increase = 0;
                for (increase; increase < sliderDots.length; increase++) {
                    var className = increase == pbSlider.slider_Active ? 'isActive' : '';
                    $(pbSlider.slider_Wrap).find(sliderDots[increase]).removeClass('isActive').addClass(className);
                    $(pbSlider.slider_Wrap).find(sliderDots[increase]).children().removeClass('isActive').addClass(className);
                }
                setTimeout(function () {
                    $(pbSlider.slider_Wrap).find(sliderDots).children().removeClass('isActive');
                }, 500);
            }
            pbSlider.slider_Active = Number(pbSlider.slider_Active);
        };

        pbSlider.auto = function () {
            pbSlider.autoTimer = setInterval(function () {
                if (pbSlider.slider_Active >= pbSlider.slider_Count - 1) {
                    pbSlider.pbGoslide(0);
                } else {
                    $(pbSlider.slider_Wrap + ' .o-slider-next').trigger('click');
                }
            }, 3000);
        };

        for(currIdx = 0; currIdx < 4; currIdx++) {

            thisVal = "#sliderItem_" + currIdx;

            newElement = "<div class='o-slider--item' id='sliderItem_" + currIdx + "' data-image='" + homeURL + "/images/" + imgPath[currIdx] + "' style='background-image: url(\"" + homeURL + "/images/" + imgPath[currIdx] + "\");'>";
            newElement += "<div class='o-slider-textWrap'>";
            newElement += "<span class='a-divider'></span>";
            newElement += "<h2 class='o-slider-subTitle'>" + titles[currIdx] + "</h2>";
            newElement += "<span class='a-divider'></span>";
            newElement += "<p class='o-slider-paragraph'>" + photoGraphers[currIdx] + "</p>";
            newElement += "</div></div>";

            $("#pbSlider0").append(newElement);

            /*
            $(window).resize(function () {
                var VW = document.documentElement.clientWidth;
                if (VW >= slider_Opts.slider_Breakpoints.tablet.media) {
                    $(pbSlider.slider_Wrap + '.o-sliderContainer,' + pbSlider.slider_Wrap + ' ' + pbSlider.slider_Item).css({height: slider_Opts.slider_Breakpoints.default.height});
                } else if (VW >= slider_Opts.slider_Breakpoints.smartphone.media) {
                    $(pbSlider.slider_Wrap + '.o-sliderContainer,' + pbSlider.slider_Wrap + ' ' + pbSlider.slider_Item).css({height: slider_Opts.slider_Breakpoints.tablet.height});
                } else {
                    $(pbSlider.slider_Wrap + '.o-sliderContainer,' + pbSlider.slider_Wrap + ' ' + pbSlider.slider_Item).css({height: slider_Opts.slider_Breakpoints.smartphone.height});
                }
            });
            */



            if(currIdx == 0) {
                $('head').append(
                    '<style>' + pbSlider.slider_Wrap + ' .o-slider.isAnimate{' +
                    '-webkit-transition: all ' + slider_Opts.slider_Speed + 'ms ' + slider_Opts.slider_Ease + ';' +
                    'transition: all ' + slider_Opts.slider_Speed + 'ms ' + slider_Opts.slider_Ease + ';' +
                    '</style>'
                );
            }

            setTimeout(function () {
                var thisLoader = $(slider_Opts.slider_Wrap + ' .loaderWrap');
                $(thisLoader).hide();
            }, 200);

            $(pbSlider.slider_Wrap + ' .o-slider-controls').addClass('isVisible');
            $(pbSlider.slider_Draggable).addClass('isVisible');
            var VW = document.documentElement.clientWidth;
            if (VW >= slider_Opts.slider_Breakpoints.tablet.media) {
                $(pbSlider.slider_Wrap + '.o-sliderContainer,' + pbSlider.slider_Wrap + ' ' + pbSlider.slider_Item).css({height: slider_Opts.slider_Breakpoints.default.height});
            } else if (VW >= slider_Opts.slider_Breakpoints.smartphone.media) {
                $(pbSlider.slider_Wrap + '.o-sliderContainer,' + pbSlider.slider_Wrap + ' ' + pbSlider.slider_Item).css({height: slider_Opts.slider_Breakpoints.tablet.height});
            } else {
                $(pbSlider.slider_Wrap + '.o-sliderContainer,' + pbSlider.slider_Wrap + ' ' + pbSlider.slider_Item).css({height: slider_Opts.slider_Breakpoints.smartphone.height});
            }


            // pbSlider.auto();

            if(currIdx == 3)
                pbSlider.pbInit(thisVal);

        }
    }
