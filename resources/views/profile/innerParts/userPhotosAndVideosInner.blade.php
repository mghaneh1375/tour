
<div class="userProfilePhotosAndVideos">
{{--    <div class="userProfilePostsFiltration photoAndVideo">--}}
{{--        <span id="userPhotoAllTab" class="active" onclick="changeShowPic('all')">همه</span>--}}
{{--        <span id="userPhotoPicTab" onclick="changeShowPic('pic')">عکس</span>--}}
{{--        <span id="userPhotoVideoTab" onclick="changeShowPic('video')">فیلم</span>--}}
{{--        <span id="userPhoto360Tab" onclick="changeShowPic('video360')">فیلم 360</span>--}}
{{--    </div>--}}

    <div class="col-xs-12 notData hidden">
        <div class="pic">
            <img src="{{URL::asset('images/mainPics/noData.png')}}" style="width: 100%">
        </div>
        <div class="info">
            @if($myPage)
                <div class="firstLine">
                    اینجا خالی است.هنوز عکس یا فیلمی بارگذاری نکرده اید...
                </div>
                <div class="sai">
                    جایی رو که دوست داری رو پیدا کن و
                    <button class="butt" onclick="openUploadPost()">عکستو بزار</button>
                </div>
            @else
                <div class="firstLine">
                    اینجا خالی است. {{$user->username}} هنوز عکسی نگذاشته...
                </div>
            @endif
        </div>
    </div>
    <div id="picPlaceHolder" style="display: none">
        <div class="profilePicturesRow kind2">
            <div class="profilePictureDiv placeHolderAnime" style="width: 33%; height: 150px"></div>
            <div class="profilePictureDiv placeHolderAnime" style="width: 33%; height: 150px"></div>
            <div class="profilePictureDiv placeHolderAnime" style="width: 33%; height: 150px"></div>
        </div>
    </div>

    <div id="pictureSection" class="photosAndVideosMainDiv"></div>
</div>

<script>
    let picAndVideoPlaceHolder = $('#picPlaceHolder').html();
    $('#picPlaceHolder').remove();

    let nowShow;
    let allPics ;
    let lastPicRow = 0;
    let showKind = {
        'pic' : true,
        'video' : true,
        'video360' : true
    };

    function createPictureRow(){
        let addedPic = 0;
        let text = '';

        if (nowShow.length == 0)
            $('.userProfilePhotosAndVideos').find('.notData').removeClass('hidden');

        for(let i = 0; i < nowShow.length; i++){
            if(addedPic == 0)
                text += '<div class="profilePicturesRow kind2">';

            if(showKind[nowShow[i]["fileKind"]]) {
                console.log(nowShow[i], showKind);
                var isVideo = nowShow[i].fileKind == 'video'|| nowShow[i].fileKind == 'video360' ? true : false;
                text += `<div class="profilePictureDiv ${isVideo ? "playIconOnPicSection" : ""}" style="width: 33%;" onclick="showThisPictures(${i})"> \\n' +
                            <img src="${nowShow[i]["sidePic"]}" class="resizeImgClass" style="width: 100%" onload="fitThisImg(this)">\\n' +
                        </div>`;
                addedPic++;
            }

            if(addedPic == 3) {
                text += '</div>';
                addedPic = 0;
                lastPicRow++;
                if(lastPicRow == 4)
                    lastPicRow = 0;
            }
        }

        $('#pictureSection').html(text);

        if(window.showAllPic == 1){
            window.showAllPic = 0; // this variable in show all picture in profile side
            showThisPictures(0);
        }
    }

    function getAllUserPicsAndVideo(){

        $('.userProfilePhotosAndVideos').find('.notData').addClass('hidden');
        $('#pictureSection').html(picAndVideoPlaceHolder+picAndVideoPlaceHolder+picAndVideoPlaceHolder);
        $.ajax({
            type: 'GET',
            url: `{{route("profile.getUserPicsAndVideo")}}?userId=${userPageId}`,
            success: function(response){
                if(response.status == 'ok'){
                    allPics = response.result;
                    nowShow = allPics;
                    createPictureRow();
                }
            },
        })
    }

    function showThisPictures(_index){
        createPhotoModal('آلبوم عکس', nowShow, _index); // in general.photoAlbumModal.blade.php
    }

    function changeShowPic(_kind){
        $('.userProfilePostsFiltration').find('.active').removeClass('active');
        showKind = {
            'pic' : false,
            'video' : false,
            'video360' : false
        };

        if(_kind == 'pic')
            showKind['pic'] = !showKind['pic'];
        else if(_kind == 'video')
            showKind['video'] = !showKind['video'];
        else if(_kind == 'video360')
            showKind['video360'] = !showKind['video360'];
        else if(_kind == 'all'){
            showKind = {
                'pic' : true,
                'video' : true,
                'video360' : true
            }
        }

        nowShow = [];
        if(showKind['pic'] && showKind['video'] && showKind['video360']) {
            $('#userPhotoAllTab').addClass('active');
            nowShow = allPics;
        }
        else{
            if(showKind['pic'])
                $('#userPhotoPicTab').addClass('active');
            if(showKind['video'])
                $('#userPhotoVideoTab').addClass('active');
            if(showKind['video360'])
                $('#userPhoto360Tab').addClass('active');

            allPics.forEach(item => {
                if(showKind[item.fileKind])
                    nowShow.push(item);
            })
        }

        createPictureRow();
    }
</script>
