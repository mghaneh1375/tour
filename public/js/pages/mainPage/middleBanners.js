var bannerIsLoaded = false;
var middleBan5Color = ['red', 'green', 'navy'];
var loadSuggestion = false;
var lastPageForSuggestion = [];
var divNames = ['newInKoochita', 'topFood', 'topTabiat', 'topRestaurant', 'topTarikhi', 'topSafarnameh']; /*'topKharid'*/
var sugg4PlaceHolder = getSuggestionPackPlaceHolder();
sugg4PlaceHolder += sugg4PlaceHolder+sugg4PlaceHolder+sugg4PlaceHolder;

divNames.forEach(item => {
    var elem = $(`.${item}`);
    elem.html(sugg4PlaceHolder);
    elem.find('.suggestionPackDiv').addClass('swiper-slide');
    elem.css('direction', 'ltr');
});

runMainSwiper('mainSuggestion');

if (typeof(Storage) !== "undefined") {
    var lastPages;
    lastPages = localStorage.getItem('lastPages');
    if(lastPages != null)
        lastPageForSuggestion = JSON.parse(lastPages);
} else
    console.log('your browser not support localStorage');

function ajaxToFillMainPageSuggestion(){
    if(!bannerIsLoaded)
        loadMainPageSliders();

    var states = [];
    lastPageForSuggestion.map(item => states.push(item.state));

    $.ajax({
        type: 'GET',
        url: `${getMainPageSuggestionURL}?lastPage=${JSON.stringify(states)}`,
        success: response => {
            createMainPageSuggestion(response);
            // fillCountNumber(response.count);
        }
    })
}

function loadMainPageSliders(){
    var cityMainPageSliderElement = $('.cityMainPageSlider');
    var text = '';

    bannerIsLoaded = true;
    if(middleBan5.length > 0){
        cityMainPageSliderElement.parent().removeClass('hidden');
        middleBan5.map((item, index) => {
            text += `<div class="swiper-slide position-relative citySliderMainPageItem">
                           <figure class="snip1091 ${middleBan5Color[index%3]}">
                               <img src="${item.pic}" alt="کوچیتا، سامانه جامع گردشگری ایران" loading="lazy" class="resizeImgClass" style="width: 100%"/>
                               <figcaption>
                                   <h2>${item.text}</h2>
                               </figcaption>
                               ${ item.link != '' ? `<a href="${item.link}"></a>` : '' }
                           </figure>
                        </div>`
        });
        cityMainPageSliderElement.html(text);

        new Swiper('.threeSlider', {
            loop: true,
            breakpoints: {
                768: {
                    slidesPerView: 'auto',
                    centeredSlides: true,
                    spaceBetween: 10,
                },
                10000: {
                    loopFillGroupWithBlank: true,
                    slidesPerView: 3,
                    spaceBetween: 20,
                }
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            }
        });
    }
    else
        cityMainPageSliderElement.parent().remove();


    if(middleBan4.length > 0){
        var Ban4Text = '';
        Baner4isLoaded = true;
        middleBan4.map((item, index) => Ban4Text += `<a href="${placeListOfMajaraUrl}" id='slide${index+1}' class='mainBlubSlider ${index == 0 ? 'up1' : ''}' style="background-image: url('${item.pic}'); ">${item.text}</a>`)
        $('#middleBan4Body').html(Ban4Text);
    }
    else
        $('#middleBan4Body').parent().parent().remove();

}

function fillCountNumber(_counts){
    // CountMiddleBanner
    $('.safarnamehCountMiddleBanner').text(_counts.safarnameh);
    $('.userCountMiddleBanner').text(_counts.userCount);
    $('.commentCountMiddleBanner').text(_counts.comment);
    $('.mahaliFoodCountMiddleBanner').text(_counts.mahaliFood);
    $('.sogatSanaieCountMiddleBanner').text(_counts.sogatSanaie);
    $('.amakenCountMiddleBanner').text(_counts.amaken);
    $('.restaurantCountMiddleBanner').text(_counts.restaurant);
    $('.hotelCountMiddleBanner').text(_counts.hotel);
    $('.boomgardyCountMiddleBanner').text(_counts.boomgardy);
}

function createMainPageSuggestion(_result){
    var food = _result.topFood;
    var tarikhi = _result.amaken;
    var tabiat = _result.majara;
    var restaurant = _result.restaurant;
    var kharid = _result.bazar;
    var safarnameh = _result.safarnameh;

    // createSuggestionPack in suggestionPack.blade.php
    createSuggestionPack('newInKoochita', _result.result, function() {
        $('.newInKoochita').find('.suggestionPackDiv').addClass('swiper-slide');
        $('.newInKoochita').css('direction', 'ltr');
    }, true);

    createSuggestionPack('topFood', food, function() {
        $('.topFood').find('.suggestionPackDiv').addClass('swiper-slide');
        $('.topFood').css('direction', 'ltr');
    }, true);

    createSuggestionPack('topTabiat', tabiat, function() {
        $('.topTabiat').find('.suggestionPackDiv').addClass('swiper-slide');
        $('.topTabiat').css('direction', 'ltr');
    }, true);

    createSuggestionPack('topRestaurant', restaurant, function() {
        $('.topRestaurant').find('.suggestionPackDiv').addClass('swiper-slide');
        $('.topRestaurant').css('direction', 'ltr');
    }, true);

    createSuggestionPack('topTarikhi', tarikhi, function() {
        $('.topTarikhi').find('.suggestionPackDiv').addClass('swiper-slide');
        $('.topTarikhi').css('direction', 'ltr');
    }, true);

    // createSuggestionPack('topKharid', kharid, function() {
    //     $('.topKharid').find('.suggestionPackDiv').addClass('swiper-slide');
    //     $('.topKharid').css('direction', 'ltr');
    // });

    createSuggestionPack('topSafarnameh', safarnameh, function() {
        $('.topSafarnameh').find('.suggestionPackDiv').addClass('swiper-slide');
        $('.topSafarnameh').css('direction', 'ltr');
        runMainSwiper('mainSuggestion')
    }, true);
}

function runMainSwiper(_class){
    new Swiper('.' + _class, {
        loop: true,
        // updateOnWindowResize: true,
        navigation: {
            prevEl: '.swiper-button-next',
            nextEl: '.swiper-button-prev',
        },
        breakpoints: {
            768: {
                slidesPerView: 'auto',
                spaceBetween: 10,
                loop: false,
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
            10000: {
                slidesPerView: 4,
                spaceBetween: 20,
            }
        }
    });
}

// this run function for mainArticlaSwiperMainPage
// runMainSwiper('mainArticlaSwiperMainPage');

if($(window).width() <= 767 && !bannerIsLoaded)
    loadMainPageSliders();

$(window).ready(() => {
    var loadSuggestionLine = document.getElementById('loadSuggestionLine').getBoundingClientRect().top;
    if (loadSuggestionLine - $(window).height() <= 0) {
        loadSuggestion = true;
        ajaxToFillMainPageSuggestion();
    }

    $(window).on('scroll', e =>{
        if(!loadSuggestion) {
            var loadSuggestionLine = document.getElementById('loadSuggestionLine').getBoundingClientRect().top;
            if (loadSuggestionLine - $(window).height() <= 0) {
                loadSuggestion = true;
                ajaxToFillMainPageSuggestion();
            }
        }
    });
});


if(numSlidesMiddleBan4 > 0){
    var svg = true;
    var click = true;
    var sliding = false;
    var Baner4isLoaded = false;

    var curpage = 1;
    var pageShift = 500;

    var transitionPrefix = "circle";
    var pagePrefixBanner4 = "slide";

    var leftMiddleBan4 = document.getElementById("banner3_left");
    var rightMiddleBan4 = document.getElementById("banner3_right");

    function leftSlide() {
        if (click && Baner4isLoaded) {
            if (curpage == 1) curpage = numSlidesMiddleBan4+1;
            sliding = true;
            curpage--;
            svg = true;
            click = false;
            for (k = 1; k <= numSlidesMiddleBan4; k++) {
                var a1 = document.getElementById(pagePrefixBanner4 + k);
                a1.className += " tran";
            }
            setTimeout(() => move(), 200);
            setTimeout(() => {
                for (k = 1; k <= numSlidesMiddleBan4; k++) {
                    var a1 = document.getElementById(pagePrefixBanner4 + k);
                    a1.classList.remove("tran");
                }
            }, 1400);
        }
    }

    function rightSlide() {
        if (click && Baner4isLoaded) {
            if (curpage == numSlidesMiddleBan4) curpage = 0;
            sliding = true;
            curpage++;
            svg = false;
            click = false;
            for (k = 1; k <= numSlidesMiddleBan4; k++) {
                var a1 = document.getElementById(pagePrefixBanner4 + k);
                a1.className += " tran";
            }
            setTimeout(() => move(), 200);
            setTimeout(() => {
                for (k = 1; k <= numSlidesMiddleBan4; k++) {
                    var a1 = document.getElementById(pagePrefixBanner4 + k);
                    a1.classList.remove("tran");
                }
            }, 1400);
        }
    }

    function move() {
        if (sliding && Baner4isLoaded) {
            sliding = false;
            if (svg) {
                for (j = 1; j <= 9; j++) {
                    var c = document.getElementById(transitionPrefix + j);
                    c.classList.remove("steap");
                    c.setAttribute("class", transitionPrefix + j + " streak");
                }
            } else {
                for (j = 10; j <= 18; j++) {
                    var c = document.getElementById(transitionPrefix + j);
                    c.classList.remove("steap");
                    c.setAttribute("class", transitionPrefix + j + " streak");
                }
            }
            setTimeout(() => {
                for (i = 1; i <= numSlidesMiddleBan4; i++) {
                    if (i == curpage) {
                        var a = document.getElementById(pagePrefixBanner4 + i);
                        a.className += " up1";
                    } else {
                        var b = document.getElementById(pagePrefixBanner4 + i);
                        b.classList.remove("up1");
                    }
                }
                sliding = true;
            }, 600);
            setTimeout(() => {
                click = true;
            }, 1700);

            setTimeout(() => {
                if (svg) {
                    for (j = 1; j <= 9; j++) {
                        var c = document.getElementById(transitionPrefix + j);
                        c.classList.remove("streak");
                        c.setAttribute("class", transitionPrefix + j + " steap");
                    }
                } else {
                    for (j = 10; j <= 18; j++) {
                        var c = document.getElementById(transitionPrefix + j);
                        c.classList.remove("streak");
                        c.setAttribute("class", transitionPrefix + j + " steap");
                    }
                    sliding = true;
                }
            }, 850);
            setTimeout(() => {
                click = true;
            }, 1700);
        }
    }
    leftMiddleBan4.onmousedown = () => leftSlide();
    rightMiddleBan4.onmousedown = () =>  rightSlide();
    setInterval(() => rightSlide(), 8000);
}


if($(window).width() > 767){
    //START middleBan1
    if(numSlidesMiddleBan1 > 0) {
        const $cont = $('.cont');
        const $slide = $('.slide');
        const $closeBtn = $('.slide__close');
        const $text = $('.slide__text');
        const $iconTwitter = $('.icon-link--twitter');
        const initialAnimDur = 7131;
        const animDelay = 1000;

        var initialAnim = true;
        var clickAnim = false;

        $(document).on('click', '.slide__bg-dark', function () {
            if (initialAnim || clickAnim) return;
            var _this = $(this).parent();
            var target = +_this.attr('data-target');
            clickAnim = true;

            _this.css({
                'transform': 'translate3d(-100%, 0, 0)',
                'transition': '750ms',
                'cursor': 'default'
            });

            _this.find('.slide__img-wrapper').css({
                'transform': 'translate3d(0, 0, 0) scale(.95, .95)',
                'transition': '2000ms'
            });

            for (var i = target, length = $slide.length; i < length; i++) {
                $('.slide--' + (i + 1)).css({
                    'transform': 'translate3d(0, 0, 0)',
                    'transition': '750ms'
                });
            }

            for (var i = target, length = $slide.length; i > 1; i--) {
                $('.slide--' + (i - 1)).css({
                    'transform': 'translate3d(-150%, 0, 0)',
                    'transition': '750ms'
                })
            }

            setTimeout(function () {
                $slide.not(_this).find('.slide__bg-dark').css({
                    'opacity': '0'
                })
            }, 750)

            $closeBtn.addClass('show-close');
            $iconTwitter.addClass('icon-show');

            _this.find('.slide__text').css({
                'transform': 'translate3d(150px, -40%, 0)',
                'opacity': '1',
                'transition': '2000ms',
                '-webkit-transition': '2000ms'
            })
        });

        $(document).on('mousemove', '.slide', function () {
            if (initialAnim || clickAnim) return;
            var _this = $(this);
            var target = +_this.attr('data-target');

            _this.css({
                'transform': 'translate3d(-' + (((100 / numSlidesMiddleBan1) * (numSlidesMiddleBan1 - (target - 1))) + numSlidesMiddleBan1) + '%, 0, 0)',
                'transition': '750ms'
            })

            _this.find('.slide__text').css({
                'transform': 'translate3d(0, -40%, 0) rotate(0.01deg)',
                '-moz-transform': 'translate3d(0, -40%, 0) rotate(0.01deg)',
                'opacity': '1',
                'transition': '750ms',
                '-webkit-transition': '750ms'
            })

            for (var i = target, length = $slide.length; i < length; i++) {
                $('.slide--' + (i + 1)).css({
                    'transform': 'translate3d(-' + (((100 / numSlidesMiddleBan1) * (numSlidesMiddleBan1 - ((i + 1) - 1))) - numSlidesMiddleBan1) + '%, 0, 0)',
                    'transition': '750ms'
                })
            }

            for (var i = target; i > 1; i--) {
                $('.slide--' + (i - 1)).css({
                    'transform': 'translate3d(-' + (((100 / numSlidesMiddleBan1) * (numSlidesMiddleBan1 - ((i - 1) - 1))) + numSlidesMiddleBan1) + '%, 0, 0)',
                    'transition': '750ms'
                })
            }

            _this.find('.slide__img-wrapper').css({
                'transform': 'translate3d(-200px, 0, 0) scale(.85, .85)',
                'transition': '750ms'
            })

            $slide.not(_this).find('.slide__img-wrapper').css({
                'transform': 'translate3d(-200px, 0, 0) scale(.90, .90)',
                'transition': '1000ms'
            })

            $slide.not(_this).find('.slide__bg-dark').css({
                'opacity': '.75'
            })
        });

        $(document).on('mouseleave', '.slide', function () {
            if (initialAnim || clickAnim) return;
            var _this = $(this);
            var target = +_this.attr('data-target');

            for (var i = 1, length = $slide.length; i <= length; i++) {

                $('.slide--' + i).css({
                    'transform': 'translate3d(-' + (100 / numSlidesMiddleBan1) * (numSlidesMiddleBan1 - (i - 1)) + '%, 0, 0)',
                    'transition': '1000ms'
                })
            }

            $slide.find('.slide__img-wrapper').css({
                'transform': 'translate3d(-200px, 0, 0) scale(1, 1)',
                'transition': '750ms'
            })

            $slide.find('.slide__bg-dark').css({
                'opacity': '0'
            })

            $text.css({
                'transform': 'translate3d(0, -50%, 0) rotate(0.01deg)',
                'opacity': '0',
                'transition': '200ms',
                '-webkit-transition': '200ms'
            })
        });

        $(document).on('click', '.slide__close', function () {

            setTimeout(function () {
                clickAnim = false;
            }, 1000);

            $closeBtn.removeClass('show-close');
            $iconTwitter.removeClass('icon-show');

            for (var i = 1, length = $slide.length; i <= length; i++) {
                $('.slide--' + i).css({
                    'transform': 'translate3d(-' + (100 / numSlidesMiddleBan1) * (numSlidesMiddleBan1 - (i - 1)) + '%, 0, 0)',
                    'transition': '1000ms',
                    'cursor': 'pointer'
                })
            }

            $text.css({
                'transform': 'translate3d(150px, -40%, 0)',
                'opacity': '0',
                'transition': '200ms',
                '-webkit-transition': '200ms'
            })

            setTimeout(function () {
                $text.css({
                    'transform': 'translate3d(0, -50%, 0)'
                })
            }, 200);
        });

        setTimeout(function () {
            $cont.addClass('active');
        }, animDelay);

        setTimeout(function () {
            initialAnim = false;
        }, initialAnimDur + animDelay);
    }
    //END middleBan1
}
