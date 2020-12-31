<link rel="stylesheet" href="{{URL::asset('css/component/generalFolder.css?v='.$fileVersions)}}">
<link rel='stylesheet' type='text/css' media='screen, print' href='{{URL::asset('css/shazdeDesigns/abbreviations.css?v='.$fileVersions)}}'/>
<link rel='stylesheet' type='text/css' media='screen, print' href='{{URL::asset('css/shazdeDesigns/proSearch.css?v='.$fileVersions)}}'/>

<div id="darkModal" class="display-none" role="dialog"></div>

{{--this dark modal with blur--}}
<div id="darkModeMainPage" class="ui_backdrop dark" ></div>

<script>
    function resizeFitImg(_class) {
        let imgs = $('.' + _class);
        for(let i = 0; i < imgs.length; i++)
            fitThisImg(imgs[i]);
    }

    function fitThisImg(_element){
        var img = $(_element);
        var imgW = img.width();
        var imgH = img.height();

        var secW = img.parent().width();
        var secH = img.parent().height();

        if(imgH < secH){
            img.css('height', '100%');
            img.css('width', 'auto');
        }
        else if(imgW < secW){
            img.css('width', '100%');
            img.css('height', 'auto');
        }
    }
</script>

@include('general.loading')

@include('general.photoAlbumModal')

{{--@include('general.searches.proSearch')--}}

@include('general.searches.mainSearch')

@include('general.searches.globalInput')

@include('general.alerts')

@include('component.suggestionPack')

@include('component.questionPack')

@include('component.answerPack')

@include('general.reportModal')

@include('general.followerPopUp')

@if(!Auth::check())
{{--    @include('general.nLoginPopUp')--}}
@else
    @include('general.adminInPage')

    @include('general.addToTripModal')

    @include('general.uploadPhoto')

    @include('general.addSafarnameh')
@endif

<script defer src="{{URL::asset('js/component/load-image.all.min.js')}}"></script>

<script>
    var openHeadersTab = false;
    var seenToZero = false;
    var csrfTokenGlobal = '{{csrf_token()}}';
    var hasLogin = {{auth()->check() ? 1 : 0}};
    window.userPic = '{{getUserPic(auth()->check() ? auth()->user()->id : 0)}}';
    window.gearIcon = '{{URL::asset("images/icons/mGear.svg")}}';
    window.getPages = [];


    function convertNumberToEn(str) {
        let persianNumbers = [/۰/g, /۱/g, /۲/g, /۳/g, /۴/g, /۵/g, /۶/g, /۷/g, /۸/g, /۹/g];
        let arabicNumbers = [/٠/g, /١/g, /٢/g, /٣/g, /٤/g, /٥/g, /٦/g, /٧/g, /٨/g, /٩/g];
        if (typeof str === 'string') {
            for (var i = 0; i < 10; i++)
                str = str.replace(persianNumbers[i], i).replace(arabicNumbers[i], i);
        }
        return str;
    }

    function getLoginPages(_callBack){
        openLoading(false, () => {
            $.ajax({
                type: 'GET',
                url: '{{route("getPage.login")}}',
                success: response => {
                    closeLoading();
                    $('body').append(response);
                    window.getPages.push('login');
                    if(typeof _callBack === 'function')
                        _callBack();
                },
                error: err => {
                    closeLoading();
                    console.error(err);
                }
            });
        });
    }

    function checkLogin(redirect = '{{Request::url()}}'){
        if (!hasLogin) {
            if(window.getPages.indexOf('login') == -1)
                getLoginPages(() => showLoginPrompt(redirect));
            else
                showLoginPrompt(redirect);
            return false;
        }
        else
            return true;
    }

    function cleanImgMetaData(_input, _callBack){
        openLoading(false, function(){
            options = { canvas: true };
            loadImage.parseMetaData(_input.files[0], function(data) {
                if (data.exif)
                    options.orientation = data.exif.get('Orientation');

                loadImage(
                    _input.files[0],
                    function(canvas) {
                        closeLoading();
                        var imgDataURL = canvas.toDataURL();
                        if(typeof _callBack === 'function') {
                            blob = dataURItoBlob(imgDataURL);
                            _callBack(imgDataURL, blob);
                        }
                    },
                    options
                );
            });
        });
    }

    function dataURItoBlob(dataURI) {
        var byteString = atob(dataURI.split(',')[1]);
        var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0]
        var ab = new ArrayBuffer(byteString.length);
        var ia = new Uint8Array(ab);
        for (var i = 0; i < byteString.length; i++)
            ia[i] = byteString.charCodeAt(i);

        var blob = new Blob([ab], {type: mimeString});
        return blob;
    }

    function goToLanguage(_lang){
        if(_lang != 0)
            location.href = '{{url('language/')}}/' + _lang;
    }

    function openMyModal(_id){
        $('#'+_id).addClass('showModal');
    }

    function closeMyModal(_id){
        $('#'+_id).removeClass('showModal');
    }

    function closeMyModalClass(_class){
        $('.'+_class).removeClass('showModal');
    }

    function showLastPages(){
        let lastPages = localStorage.getItem('lastPages');
        lastPages = JSON.parse(lastPages);

        $('#recentlyRowMainSearch').html('');

        if(lastPages != null){
            var showRecentlyText = '';
            for(i = 0; i < lastPages.length; i++){
                var text = recentlyMainSearchSample;
                var fk = Object.keys(lastPages[i]);

                var name = lastPages[i]['name'];
                t = '##name##';
                re = new RegExp(t, "g");

                if(lastPages[i]['kind'] == 'city')
                    name +=' در ' + lastPages[i]['state'];
                else if(lastPages[i]['kind'] == 'place')
                    name +=' در ' + lastPages[i]['city'];
                else if(lastPages[i]['kind'] == 'article')
                    name = 'مقاله ' + lastPages[i]['name'];
                text = text.replace(re, name);

                for (var x of fk) {
                    var t = '##' + x + '##';
                    var re = new RegExp(t, "g");

                    if(x == 'city' && lastPages[i]['state'] != '')
                        text = text.replace(re, lastPages[i][x] + ' در ');
                    else
                        text = text.replace(re, lastPages[i][x]);
                }

                showRecentlyText += text;
            }
            $('.recentlyRowMainSearch').html(showRecentlyText);
        }
    }

    function getAlertItems() {
        $.ajax({
            type: 'get',
            url: '{{route('getAlerts')}}',
            success: function (response) {
                var newElement = "";
                var newMsg = 0;

                if (response.result.length > 0) {
                    response.result.map(item => {
                        if (item.click != 0)
                            item.color = 'white';

                        if(item.seen == 0)
                            newMsg++;

                        newElement += '<div class="alertMsgHeaderContent" style="background: ' + item.color + '" onclick="setSeenAlert(' + item.id + ', this)">\n' +
                                    '<div class="alertMsgHeaderContentImgDiv">\n' +
                                    '<img src="' + item.pic + '"  alt="کوچیتا، سامانه جامع گردشگری ایران" class="resizeImgClass" onload="fitThisImg(this)" style="width: 100%">\n' +
                                    '</div>\n' +
                                    '<div class="alertMsgHeaderContentTextDiv">\n' +
                                    '<div class="alertMsgHeaderContentText">' + item.msg + '</div>\n' +
                                    '<div class="alertMsgHeaderContentTime">' + item.time + '</div>\n' +
                                    '</div>\n' +
                                    '</div>';
                    });
                    $('.alertMsgResultDiv').html(newElement);

                    if(newMsg != 0)
                        $('.newAlertNumber').removeClass('hidden').html(newMsg);
                }
                else{
                    newElement += '<div><div class="modules-engagement-notification-dropdown"><div class="notifdd_empty">{{__('هیچ پیامی موجود نیست')}} </div></div></div>';
                    $('#headerMsgPlaceHolder').html(newElement);
                }

            }
        });
    }

    function setSeenAlert(_id = 0, _element = ''){
        let kind = _id == 0 ? 'seen' : 'click';

        if(kind == 'seen' && seenToZero)
            return;

        $.ajax({
            type: 'post',
            url: '{{route("alert.seen")}}',
            data: {
                _token: '{{csrf_token()}}',
                id: _id,
                kind: kind
            },
            success: function(response){
                if(response.status == 'ok'){
                    if(kind == 'seen') {
                        $('.newAlertNumber').addClass('hidden');
                        seenToZero = true;
                    }
                    else
                        $(_element).css('background', 'white');
                }
            }
        })
    }

    function getBookMarkForHeaderAndFooter(){
        if(checkLogin()){
            getMyBookMarkPromiseFunc().then(response => {
                var text = '';
                response.map(item =>{
                    var add = false;
                    var name = '';
                    var pic = '';
                    var state = '';
                    var kind = '';
                    var kindIcon = '';
                    if(item.kind == 'place'){
                        name = item.name;
                        pic = item.pic;
                        state = item.city + ' در ' + item.state;
                        kindIcon = window.mainIconsPlaces[item.kindPlaceName].icon;
                        kind = window.mainIconsPlaces[item.kindPlaceName].nameFa;
                        add = true;
                    }
                    else if(item.kind == 'safarnameh'){
                        name = item.title;
                        pic = item.pic;
                        kind = 'سفرنامه';
                        kindIcon = window.mainIconsPlaces['safarnameh'].icon;
                        add = true;
                    }
                    if(add) {
                        text += `<div class="bookMarkSSec">
                                    <div class="BookMarkIcon BookMarkIconEmptyAfter" onclick="deleteBookMarkState(${item.bmId}, this)"></div>
                                    <div class="imgSec" onclick="goToBookMarkSelected('${item.url}')">
                                        <img src="${pic}" class="resizeImgClass" alt="${name}" onload="fitThisImg(this)">
                                    </div>
                                    <div class="infoSec" onclick="goToBookMarkSelected('${item.url}')">
                                        <div class="type ${kindIcon}">${kind}</div>
                                        <div class="name">${name}</div>
                                        <div class="state">${state}</div>
                                    </div>
                                </div>`;
                    }
                });

                if(text != '')
                    $('.headerFooterBookMarkTab').html(text);
                else{
                    $('.headerFooterBookMarkTab').find('.bookMarkSSec').remove();
                    $('.headerFooterBookMarkTab').find('.notInfoFooterModalImg').removeClass('hidden');
                }
            })
        }
    }

    function deleteBookMarkState(_id, _element){
        $.ajax({
            type: 'post',
            url: '{{route("profile.bookMark.delete")}}',
            data: {
                _token: '{{csrf_token()}}',
                id: _id
            },
            success: response =>{
                if(response.status == 'ok')
                    $(_element).parent().remove();
                else
                    showSuccessNotifi('مشکلی در حذف نشان کرده پیش امده', 'left', 'red');
            },
            error: err => showSuccessNotifi('مشکلی در حذف نشان کرده پیش امده', 'left', 'red')
    })
    }
    function goToBookMarkSelected(_url){
        window.location.href = _url;
    }


    $(window).on('click', e => {
        if($('.modalBlackBack.closeWithClick.showModal:not(.notCloseOnClick)').length > 0){
            if($(e.target).is('.modalBlackBack, .showModal, .closeWithClick')) {
                closeMyModal($(e.target).attr('id'));
                opnedMobileFooterId = null; // for placeFooter.js
            }
        }
        if($('.modalBlackBack.fullCenter.showModal:not(.notCloseOnClick)').length > 0){
            if($(e.target).is('.modalBlackBack, .showModal, .fullCenter'))
                closeMyModal($(e.target).attr('id'));
        }

        $('.closeWithOneClick').addClass('hidden');
        $('.moreOptionFullReview').removeClass('bg-color-darkgrey');

        if(openHeadersTab)
            hideAllTopNavs();
    });

    $(window).on('resize', e => {
        resizeFitImg('resizeImgClass');
    });

    $(document, window).ready(() => {
        resizeFitImg('resizeImgClass');
        showLastPages();

        @if(Auth::check())
            getAlertItems();
            getBookMarkForHeaderAndFooter();
        @endif

        $(".login-button").click(() => checkLogin());
    });

    window.mobileAndTabletCheck = function() {
        let check = false;
        (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
        return check;
    };

</script>

<script>
    window.seenRelatedId = sessionStorage.getItem("lastPageLogId") == null ? 0 : sessionStorage.getItem("lastPageLogId");
    window.seenPageLogId = 0;
    window.userScrollPageLog = [];
    window.isMobile = window.mobileAndTabletCheck() ? 1 : 0;
    var userWindowInScrolling = null;
    var seenLogStartTime = new Date().getTime();
    var lastSeenLogScroll = 0;

    // $(window).on('scroll', () => {
    //     var time = seenLogStartTime;
    //     seenLogStartTime = new Date().getTime();
    //     if(new Date().getTime() - time > 1000){
    //         window.userScrollPageLog.push({
    //             scroll: (lastSeenLogScroll/($(document).height() - $(window).height())) * 100,
    //             time: new Date().getTime() - time
    //         })
    //     }
    //     else if(window.userScrollPageLog[window.userScrollPageLog.length-1] != 'scrolling')
    //         window.userScrollPageLog.push('scrolling');
    //
    //     if(userWindowInScrolling != null)
    //         clearTimeout(userWindowInScrolling);
    //
    //     setTimeout(() => {
    //         seenLogStartTime = new Date().getTime();
    //         lastSeenLogScroll = window.pageYOffset
    //     }, 1000);
    // });
    function sendSeenPageLog(){
        $.ajax({
            type: 'post',
            url: '{{route('log.storeSeen')}}',
            data: {
                _token: '{{csrf_token()}}',
                relatedId: window.seenRelatedId,
                seenPageLogId: window.seenPageLogId,
                scrollData: window.userScrollPageLog,
                isMobile: window.isMobile,
                windowsSize: {width: $(window).width(), height: $(window).height()},
                url: document.location.pathname
            },
            success: response => {
                if(response.status == 'ok') {
                    sessionStorage.setItem("lastPageLogId", response.seenPageLogId);
                    window.seenPageLogId = response.seenPageLogId;
                }
                // setTimeout(sendSeenPageLog, 5000);
            },
            // error: err => setTimeout(sendSeenPageLog, 5000)
        })
    }
    sendSeenPageLog();

    function numberWithCommas(x) {
        x = x.toString().replace(new RegExp(',', 'g'), '');
        var parts = x.toString().split(".");
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return parts.join(".");
    }

</script>
