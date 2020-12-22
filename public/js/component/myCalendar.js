var myCalendarHtml;
$.fn.myCalendar = function(_options) {
    var date = new Date();
    var jalaliDateHtml = '';
    var settings = $.extend({
        show: false,
        code: Math.floor(Math.random()*10000),
        jDateName: ['شنبه', 'یک شنبه', 'دوشنبه', 'سه شنبه', 'چهارشنبه', 'پنج شنبه', 'جمعه'],
        selectedSJDate: [date.getJalaliFullYear(), date.getJalaliMonth(), date.getJalaliDate()],
        selectedEJDate: [null, null, null],
        selectedSGDate: [date.getFullYear(), date.getMonth(), date.getDate()],
        selectedEGDate: [null, null, null],
    }, _options );

    settings.jDateName.map(item => jalaliDateHtml += `<td>${item}</td>`);

    $(this).html(myCalendarHtml);
    $(this).find('.myCalendarJalaliHeader').html(jalaliDateHtml);

    if(settings.show)
        $(this).show();
    else
        $(this).hide();

    return this;
};

// $(window).ready(() => {
//     myCalendarHtml = $('#myCalendarHtml').html();
//     $('#myCalendarHtml').remove();
// });

