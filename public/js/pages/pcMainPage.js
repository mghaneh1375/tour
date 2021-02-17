
var swiper;
if($(window).width() > 767) {
    var setInterText = 0;
    var backgroundColorForSliderElementMainPage = $('.backgroundColorForSlider');

    swiper = new Swiper('#mainSlider', {
        spaceBetween: 30,
        centeredSlides: true,
        loop: true,
        autoplay: {
            delay: 50000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    })
        .on('slideChange', () => {
            if (mainSliderPics[swiper.realIndex]['backgroundPic'] != null)
                backgroundColorForSliderElementMainPage.css('background-image', 'url("' + mainSliderPics[swiper.realIndex]['backgroundPic'] + '")');
            else
                backgroundColorForSliderElementMainPage.css('background-color', mainSliderPics[swiper.realIndex]['textBackground']);

            if (mainSliderPics[swiper.realIndex]['text'] != null)
                consoleText(mainSliderPics[swiper.realIndex]['text'], 'text', mainSliderPics[swiper.realIndex]['textColor']);
        });

    if (mainSliderPics[0]['text'] != null)
        consoleText(mainSliderPics[0]['text'], 'text', mainSliderPics[0]['textColor']);

    if (mainSliderPics[0]['backgroundPic'] != null)
        backgroundColorForSliderElementMainPage.css('background-image', `url("${mainSliderPics[0]['backgroundPic']}")`);
    else
        backgroundColorForSliderElementMainPage.css('background-color', mainSliderPics[0]['textBackground']);

    function consoleText(words, id, colors) {
        document.getElementById('text').innerHTML = '';

        if (setInterText != 0)
            clearInterval(setInterText);

        document.getElementById(id).innerHTML = '';
        if (colors === undefined) colors = ['#fff'];
        var visible = true;
        var con = document.getElementById('console');
        var letterCount = 1;
        var x = 1;
        var waiting = false;
        var target = document.getElementById(id);
        target.setAttribute('style', 'color:' + colors);

        setInterText = window.setInterval(function () {
            if (letterCount === 0 && waiting === false) {
                waiting = true;
                target.innerHTML = words.substring(0, letterCount);
                window.setTimeout(function () {
                    var usedColor = colors.shift();
                    colors.push(usedColor);
                    var usedWord = words.shift();
                    words.push(usedWord);
                    x = 1;
                    target.setAttribute('style', 'color:' + color);
                    letterCount += x;
                    waiting = false;
                }, 10)
            } else if (waiting === false) {
                target.innerHTML = words.substring(0, letterCount);
                letterCount += x;
            }
        }, 70);
    }

}
