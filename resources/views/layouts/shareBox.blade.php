<?php
$config = \App\models\ConfigModel::first();
$randomThisPage = rand(1000, 9999);
$idToClick = isset($idToClick) ? $idToClick : "share_pic"
?>
<link rel='stylesheet' type='text/css' media='screen, print' href='{{URL::asset('css/shazdeDesigns/shareBox.css?v='.$fileVersions)}}'/>

<div id="share_box_{{$randomThisPage}}" class="shareBoxSection share_boxDiv hidden" style="width: 200px">
    <a target="_blank" class="link mg-tp-5" href="https://www.facebook.com/sharer/sharer.php?u={{$urlInThisShareBox}}">
        <img src="{{URL::asset("images/shareBoxImg/facebook.png")}}" class="display-inline-block float-right">
        <div class="display-inline-block float-right mg-rt-5">اشتراک صفحه در فیسبوک</div>
    </a>
    <a target="_blank" class="link mg-tp-5" href="https://twitter.com/home?status={{$urlInThisShareBox}}">
        <img src="{{URL::asset("images/shareBoxImg/twitter.png")}}" class="display-inline-block float-right">
        <div class="display-inline-block float-right mg-rt-5">اشتراک صفحه در توییتر</div>
    </a>
    <a target="_blank" class="link mg-tp-5 whatsappLink whatsappLink_{{$randomThisPage}}" href="#">
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

<div id="shareBoxModalForMobile_{{$randomThisPage}}" class="modalBlackBack fullCenter shareBoxModalForMobile hideOnPc">
    <div class="modalBody">
        <a target="_blank" class="link mg-tp-5" href="https://www.facebook.com/sharer/sharer.php?u={{$urlInThisShareBox}}">
            <img src="{{URL::asset("images/shareBoxImg/facebook.png")}}" class="display-inline-block float-right">
            <div class="display-inline-block float-right mg-rt-5">اشتراک صفحه در فیسبوک</div>
        </a>
        <a target="_blank" class="link mg-tp-5" href="https://twitter.com/home?status={{$urlInThisShareBox}}">
            <img src="{{URL::asset("images/shareBoxImg/twitter.png")}}" class="display-inline-block float-right">
            <div class="display-inline-block float-right mg-rt-5">اشتراک صفحه در توییتر</div>
        </a>
        <a target="_blank" class="link mg-tp-5 whatsappLink whatsappLink_{{$randomThisPage}}" href="#">
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

    $('#{{$idToClick}}').click(function () {
        setTimeout(() => {
            var element = $('#share_box_{{$randomThisPage}}');
            if (element.hasClass("hidden")) {
                openShareBox = true;
                if($(window).width() > 767) {
                    element.removeClass('hidden');
                    $('.shareIconDiv').addClass('sharePageIconFill').removeClass('sharePageIcon');
                }
                else
                    openMyModal('shareBoxModalForMobile_{{$randomThisPage}}');

            } else {
                openShareBox = false;
                element.addClass('hidden');
                $('.shareIconDiv').removeClass('sharePageIconFill').addClass('sharePageIcon');
                closeMyModalClass('shareBoxModalForMobile');
            }
        }, 10);
    });


    $(window).on('click', function(e){
        if(openShareBox){
            if(!($(e.target).attr('id') == '{{$idToClick}}' || $(e.target).hasClass('sharePageLabel')||
                $(e.target).attr('id') == 'share_pic_mobile' ||
                $(e.target.parentElement).attr('id') == '{{$idToClick}}' ||
                $(e.target.parentElement).attr('id') == 'share_pic_mobile'))
            {
                openShareBox = false;
                $('.share_boxDiv').addClass('hidden');
                $('.shareIconDiv').removeClass('sharePageIconFill').addClass('sharePageIcon');
                closeMyModalClass('shareBoxModalForMobile');
            }
        }
    }).ready(() => {
        let encodeurlShareBox = encodeURIComponent('{{$urlInThisShareBox}}');
        let textShareBox = 'whatsapp://send?text=';
        textShareBox += 'در کوچیتا ببینید:' + ' %0a ' + encodeurlShareBox;
        $('.whatsappLink_{{$randomThisPage}}').attr('href', textShareBox);
    });
</script>

