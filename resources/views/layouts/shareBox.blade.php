<?php
$config = \App\models\ConfigModel::first();
?>
<link rel='stylesheet' type='text/css' media='screen, print' href='{{URL::asset('css/shazdeDesigns/shareBox.css?v='.$fileVersions)}}'/>

<div id="share_box" style="width: 200px">
    <a target="_blank" class="link mg-tp-5" href="https://www.facebook.com/sharer/sharer.php?u={{$urlInThisShareBox}}">
        <img src="{{URL::asset("images/shareBoxImg/facebook.png")}}" class="display-inline-block float-right">
        <div class="display-inline-block float-right mg-rt-5">اشتراک صفحه در فیسبوک</div>
    </a>
    <a target="_blank" class="link mg-tp-5" href="https://twitter.com/home?status={{$urlInThisShareBox}}">
        <img src="{{URL::asset("images/shareBoxImg/twitter.png")}}" class="display-inline-block float-right">
        <div class="display-inline-block float-right mg-rt-5">اشتراک صفحه در توییتر</div>
    </a>
    <a target="_blank" class="link mg-tp-5 whatsappLink" href="#">
        <img src="{{URL::asset("images/shareBoxImg/whatsapp.png")}}" class="display-inline-block float-right">
        <div class="display-inline-block float-right mg-rt-5">اشتراک صفحه واتس اپ</div>
    </a>
    <a target="_blank" class="link mg-tp-5" href="https://telegram.me/share/url?url={{$urlInThisShareBox}}">
        <img src="{{URL::asset("images/shareBoxImg/telegram.png")}}" class="display-inline-block float-right">
        <div class="display-inline-block float-right mg-rt-5">اشتراک صفحه تلگرام</div>
    </a>
{{--    <a target="_blank" class="link mg-tp-5" href="https://instagram.com/share?url={{ str_replace('%20', '', $urlInThisShareBox)}}">--}}
{{--        <img src="{{URL::asset("images/shareBoxImg/instagram.png")}}" class="display-inline-block float-right">--}}
{{--        <div class="display-inline-block float-right mg-rt-5">اشتراک صفحه اینستاگرام</div>--}}
{{--    </a>--}}
{{--    <a target="_blank" class="link mg-tp-5" href="https://pinterest.com/home?status={{$urlInThisShareBox}}">--}}
{{--        <img src="{{URL::asset("images/shareBoxImg/pinterest.png")}}" class="display-inline-block float-right">--}}
{{--        <div class="display-inline-block float-right mg-rt-5">اشتراک صفحه پین ترست</div>--}}
{{--    </a>--}}
    <div class="position-relative inputBoxSharePage mg-tp-5">
        <input id="shareLinkInput" class="full-width inputBoxInputSharePage" value="{{$urlInThisShareBox}}" readonly onclick="copyLinkAddress()" style="cursor: pointer;">
        <img src="{{URL::asset("images/shareBoxImg/copy.png")}}" id="copyImgInputShareLink">
    </div>
</div>

<div id="shareBoxModalForMobile" class="modalBlackBack fullCenter shareBoxModalForMobile hideOnPc">
    <div class="modalBody">
        <a target="_blank" class="link mg-tp-5" href="https://www.facebook.com/sharer/sharer.php?u={{$urlInThisShareBox}}">
            <img src="{{URL::asset("images/shareBoxImg/facebook.png")}}" class="display-inline-block float-right">
            <div class="display-inline-block float-right mg-rt-5">اشتراک صفحه در فیسبوک</div>
        </a>
        <a target="_blank" class="link mg-tp-5" href="https://twitter.com/home?status={{$urlInThisShareBox}}">
            <img src="{{URL::asset("images/shareBoxImg/twitter.png")}}" class="display-inline-block float-right">
            <div class="display-inline-block float-right mg-rt-5">اشتراک صفحه در توییتر</div>
        </a>
        <a target="_blank" class="link mg-tp-5 whatsappLink" href="#">
            <img src="{{URL::asset("images/shareBoxImg/whatsapp.png")}}" class="display-inline-block float-right">
            <div class="display-inline-block float-right mg-rt-5">اشتراک صفحه واتس اپ</div>
        </a>
        <a target="_blank" class="link mg-tp-5" href="https://telegram.me/share/url?url={{$urlInThisShareBox}}">
            <img src="{{URL::asset("images/shareBoxImg/telegram.png")}}" class="display-inline-block float-right">
            <div class="display-inline-block float-right mg-rt-5">اشتراک صفحه تلگرام</div>
        </a>
        <a class="link mg-tp-5" href="javascript:void(0)" onclick="copyLinkAddress()">
            <div class="display-inline-block float-right mg-rt-5">کپی کردن لینک صفحه</div>
        </a>
    </div>
</div>

<input id="hiddenInputWithThisPageUrl" type="text" value="{{$urlInThisShareBox}}" style="display: none;">

<script>
    var openShareBox = false;

    function copyLinkAddress(){
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($('#hiddenInputWithThisPageUrl').val()).select();
        document.execCommand("copy");
        $temp.remove();
        alert('آدرس صفحه کپی شد.');
    }

    function toggleShareIcon(elmt) {
        $(elmt).children('div.first').toggleClass('sharePageIcon').toggleClass('sharePageIconFill');
    }

    $('#share_pic').click(function () {
        var element = $('#share_box');
        if (element.is(":hidden")) {
            openShareBox = true;

            if($(window).width() > 767) {
                element.show();
                $('.shareIconDiv').addClass('sharePageIconFill').removeClass('sharePageIcon');
            }
            else
                openMyModal('shareBoxModalForMobile');
        } else {
            openShareBox = false;
            element.hide();
            $('.shareIconDiv').removeClass('sharePageIconFill').addClass('sharePageIcon');
            closeMyModal('shareBoxModalForMobile');
        }
    });

    $(window).on('click', function(e){
        if(openShareBox){
            if(!($(e.target).attr('id') == 'share_pic' || $(e.target).hasClass('sharePageLabel')||
                $(e.target).attr('id') == 'share_pic_mobile' ||
                $(e.target.parentElement).attr('id') == 'share_pic' ||
                $(e.target.parentElement).attr('id') == 'share_pic_mobile'))
            {
                openShareBox = false;
                $('#share_box').hide();
                $('#share_box_mobile').hide();
                $('.shareIconDiv').removeClass('sharePageIconFill').addClass('sharePageIcon');
                closeMyModal('shareBoxModalForMobile');
            }
        }
    }).ready(() => {
        let encodeurlShareBox = encodeURIComponent('{{$urlInThisShareBox}}');
        let textShareBox = 'whatsapp://send?text=';
        textShareBox += 'در کوچیتا ببینید:' + ' %0a ' + encodeurlShareBox;
        $('.whatsappLink').attr('href', textShareBox);
    });
</script>

