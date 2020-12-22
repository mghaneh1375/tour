<?php
$config = \App\models\ConfigModel::first();
?>
<link rel='stylesheet' type='text/css' media='screen, print' href='{{URL::asset('css/shazdeDesigns/shareBox.css?v=1')}}'/>

<div id="share_box" style="width: 200px">
    <a target="_blank" class="link mg-tp-5" {{($config->facebookNoFollow) ? 'rel="nofollow"' : ''}}
    href="https://www.facebook.com/sharer/sharer.php?u={{Request::url()}}">
        <img src="{{URL::asset("images/shareBoxImg/facebook.png")}}" class="display-inline-block float-right">
        <div class="display-inline-block float-right mg-rt-5">اشتراک صفحه در فیسبوک</div>
    </a>
    <a target="_blank" class="link mg-tp-5" {{($config->twitterNoFollow) ? 'rel="nofollow"' : ''}}
    href="https://twitter.com/home?status={{Request::url()}}">
        <img src="{{URL::asset("images/shareBoxImg/twitter.png")}}" class="display-inline-block float-right">
        <div class="display-inline-block float-right mg-rt-5">اشتراک صفحه در توییتر</div>
    </a>
    <a target="_blank" class="link mg-tp-5 whatsappLink" {{($config->whatsAppFollow) ? 'rel="nofollow"' : ''}}
    href="#">
        <img src="{{URL::asset("images/shareBoxImg/whatsapp.png")}}" class="display-inline-block float-right">
        <div class="display-inline-block float-right mg-rt-5">اشتراک صفحه واتس اپ</div>
    </a>
    <script>
        $(window).ready(() => {
            let encodeurlShareBox = encodeURIComponent('{{Request::url()}}');
            let textShareBox = 'whatsapp://send?text=';
            textShareBox += 'در کوچیتا ببینید:' + ' %0a ' + encodeurlShareBox;
            $('.whatsappLink').attr('href', textShareBox);
        });
    </script>

    <a target="_blank" class="link mg-tp-5" {{($config->telegramNoFollow) ? 'rel="nofollow"' : ''}}
    href="https://telegram.me/share/url?url={{Request::url()}}">
        <img src="{{URL::asset("images/shareBoxImg/telegram.png")}}" class="display-inline-block float-right">
        <div class="display-inline-block float-right mg-rt-5">اشتراک صفحه تلگرام</div>
    </a>
    <a target="_blank" class="link mg-tp-5" {{($config->instagramFollow) ? 'rel="nofollow"' : ''}}
    href="https://instagram.com/share?url={{ str_replace('%20', '', Request::url())}}">
        <img src="{{URL::asset("images/shareBoxImg/instagram.png")}}" class="display-inline-block float-right">
        <div class="display-inline-block float-right mg-rt-5">اشتراک صفحه اینستاگرام</div>
    </a>
    <a target="_blank" class="link mg-tp-5" {{($config->pinterestFollow) ? 'rel="nofollow"' : ''}}
    href="https://pinterest.com/home?status={{Request::url()}}">
        <img src="{{URL::asset("images/shareBoxImg/pinterest.png")}}" class="display-inline-block float-right">
        <div class="display-inline-block float-right mg-rt-5">اشتراک صفحه پین ترست</div>
    </a>
    <div class="position-relative inputBoxSharePage mg-tp-5">
        <input id="shareLinkInput" class="full-width inputBoxInputSharePage" value="{{Request::url()}}" readonly onclick="copyLinkAddress()" style="cursor: pointer;">
        <img src="{{URL::asset("images/shareBoxImg/copy.png")}}" id="copyImgInputShareLink">
    </div>
</div>

<input id="hiddenInputWithThisPageUrl" type="text" value="{{Request::url()}}" style="display: none;">
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
        $(elmt).children('div.first').toggleClass('sharePageIcon');
        $(elmt).children('div.first').toggleClass('sharePageIconFill');
    }

    $('#share_pic').click(function () {
        if ($('#share_box').is(":hidden")) {
            openShareBox = true;
            $('#share_box').show();
            $('.shareIconDiv').addClass('sharePageIconFill');
            $('.shareIconDiv').removeClass('sharePageIcon');
        } else {
            openShareBox = false;
            $('#share_box').hide();

            $('.shareIconDiv').removeClass('sharePageIconFill');
            $('.shareIconDiv').addClass('sharePageIcon');
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

                $('.shareIconDiv').removeClass('sharePageIconFill');
                $('.shareIconDiv').addClass('sharePageIcon');
            }
        }
    })
</script>

