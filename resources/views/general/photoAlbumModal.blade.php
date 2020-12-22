<link rel="stylesheet" href="{{URL::asset('css/shazdeDesigns/modalPhotos.css?v=2')}}">

<div class="modal showingPhotosModal" id="photoAlbumModal" role="dialog" style="display: none; z-index: 10000;">
    <div class="modal-dialog" style="margin-top: 2%">
        <div class="modal-content" style="background-color: #141518; border: none;">
            <div id="showingPhotosMainDivHeader">
                <button type="button" class="close" onclick="closePhotoAlbumModal()">&times;</button>
                <div class="showingPhotosTitle">
                    <div style="display: flex; direction: rtl">
                        <div id="photoAlbumTitle"></div>
                        <div id="photoAlbumNamePic"></div>
                    </div>
                </div>
            </div>

            <div class="userInfoPhotoAlbum hideOnScreen">
                <div class="fullyCenterContent userPictureDiv circleBase type2">
                    <img class="photoAlbumUserPic resizeImgClass" alt="کوچیتا، سامانه جامع گردشگری ایران"  style="width: 100%" onload="fitThisImg(this)">
                </div>
                <div class="commentWriterExperienceDetails" style="width: calc(100% - 60px)">
                    <a href="#" class="userProfileName photoAlbumUserName"></a>
                    <a href="#" target="_blank" class="photoAlbumWhere" ></a>
                    <div>
                        <div class="photoAlbumUploadTime"></div>
                    </div>
                </div>
            </div>
            <div class="clear-both"></div>
            <div class="display-flex">
                <div class="col-xs-12 col-sm-9 leftColPhotosModalMainDiv">
                    <div id="leftColPhotosModalMainDiv" class="selectedPhotoShowingModal" style="position: relative;">
                        <div style="position: relative; width: 100%;">
                            <div class="albumContent">
                                <img id="mainPhotoAlbum" alt="کوچیتا، سامانه جامع گردشگری ایران" style="max-width: 100%; max-height: 100%;">
                                <video id="mainVideoPhotoAlbum" controls style="max-width: 100%; max-height: 100%;"></video>
                            </div>
                            <div style="position: absolute; bottom: -25px; right: 0px; margin-top: 7px; display: flex; justify-content: center;">
                                <div id="photoAlbumLikeSection" class="photoAlbumLikeSection" style="display:none;">
                                    <div class="feedBackBtn" style="margin: 0px;">
                                        <div class="dislikeBox photoAlbumTopLikeButton photoAlbumTopDisLike disLikePhotoAlbum" onclick="likeAlbumPic(this,-1)">
                                            <div class="photoAlbumDisLikeCount" style="font-size: 25px"></div>
                                        </div>
                                        <div class="likeBox photoAlbumTopLikeButton photoAlbumTopLike likePhotoAlbum" onclick="likeAlbumPic(this,1)">
                                            <div class="photoAlbumLikeCount" style="font-size: 25px"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="deletePicIconsPhotoAlbum" class="deletePicIconsPhotoAlbum" dataValue="0" onclick="openDeletePhotoModal()">
                                <img alt="delete" src="{{URL::asset('images/icons/recycle-bin3.webp')}}" style="width: 35px; height: 35px">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="rightColPhotosModalMainDiv" class="col-xs-12 col-sm-3 rightColPhotosModalMainDiv" style="max-height: 85vh; overflow: hidden;">
                    <div class="userInfoPhotoAlbum hideOnPhone">
                        <div class="fullyCenterContent userPictureDiv circleBase type2">
                            <img alt="کوچیتا، سامانه جامع گردشگری ایران" class="photoAlbumUserPic resizeImgClass" style="width: 100%" onload="fitThisImg(this)">
                        </div>
                        <div class="commentWriterExperienceDetails" style="width: calc(100% - 60px)">
                            <a href="#" class="userProfileName photoAlbumUserName"></a>
                            <a href="#" target="_blank" class="photoAlbumWhere" ></a>
                            <div>
                                <div class="photoAlbumUploadTime" style="color: #9aa0a6;"></div>
                            </div>
                        </div>
                    </div>

                    <div id="sidePhotoModal" class="sidePhotoAlbumDiv"></div>

                </div>
            </div>
            <div class="photosDescriptionShowingModal">
                <div id="photoAlbumDescription" style="display: block; padding: 11px 10px; color: white;"></div>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="deletePhotoInAlbumModal" role="dialog" style="direction: rtl">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{__('پاک کردن عکس')}}</h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{__('لغو')}}</button>
                <button type="button" class="btn btn-danger" onclick="doPhotoDeleteInAlbum()">{{__('بله، حذف شود')}}</button>
            </div>
        </div>
    </div>
</div>


<script>
    var sidePics;
    var choosenIndex;
    var userInPhoto = '{{auth()->check() ? auth()->user()->username : false}}';
    var srcSidePic = `<div id="sideAlbumPic##index##" class="rightColPhotosShowingModal" onclick="##picIndex##">
                            <img src="##sidePic##" alt="##alt##" class="mainAlbumPic resizeImgClass" onload="fitThisImg(this)">
                        </div>`;

    function createPhotoModal(_title, _pics, _choosenIndex = 0){
        // _pics = [
        //     {
        //         'id' : , must be kind_idNum like => review_124 or photographer_1134
        //         'sidePic' : ,
        //         'mainPic' : ,
        //         'userPic' : ,
        //         'userName' : ,
        //         'showInfo' : show like or not (true , false) ,
        //         'where' : ,   (optional)
        //         'whereUrl' : ,   (optional)
        //         'like' : ,   (optional)
        //         'dislike' : ,    (optional)
        //         'alt' : ,    (optional)
        //         'uploadTime' : , (optional)
        //         'video': if video, (optional)
        //         'description' : ,    (optional)
        //         'userLike' : if user like this img?,     (optional)
        //     }
        // ]

        sidePics = _pics;
        $('#photoAlbumTitle').text(_title);

        for(i = 0; i < sidePics.length; i++){
                var t;
                var re;
                var text = srcSidePic;
                var fk = Object.keys(sidePics[i]);
                for (var x of fk) {
                    t = '##' + x + '##';
                    re = new RegExp(t, "g");
                    text = text.replace(re, sidePics[i][x]);
                }

                t = '##picIndex##';
                re = new RegExp(t, "g");
                text = text.replace(re, 'chooseAlbumMainPhoto(' + i + ')');

                t = '##index##';
                re = new RegExp(t, "g");
                text = text.replace(re, i);

                $('#sidePhotoModal').append(text);
            }
        $('#photoAlbumModal').modal({backdrop: 'static', keyboard: false});
        chooseAlbumMainPhoto(_choosenIndex);
    }

    function chooseAlbumMainPhoto(_index){
        var funcDislike;
        var funcLike;
        choosenIndex = _index;
        $('.chooseSidePhotoAlbum').removeClass('chooseSidePhotoAlbum');
        $('#photoAlbumDescription').text('');
        $('#photoAlbumNamePic').text('');

        if(sidePics[_index]['picName'] != undefined)
            $('#photoAlbumNamePic').text(' - ' + sidePics[_index]['picName']);

        $('.photoAlbumUploadTime').text(sidePics[_index]['uploadTime']);
        $('.photoAlbumUserName').text(sidePics[_index]['userName']);
        $('.photoAlbumUserName').attr('href', "{{url('profile/index')}}/" + sidePics[_index]['userName']);
        $('.photoAlbumWhere').text(sidePics[_index]['where'] ? sidePics[_index]['where'] : '');
        $('.photoAlbumWhere').attr('href', sidePics[_index]['whereUrl']);
        $('.photoAlbumUserPic').attr('src', sidePics[_index]['userPic']);

        $('#sideAlbumPic' + _index).addClass('chooseSidePhotoAlbum');

        if(sidePics[_index]['video'] != undefined) {
            $('#mainPhotoAlbum').css('display', 'none');
            $('#mainVideoPhotoAlbum').css('display', 'block');

            $('#mainVideoPhotoAlbum').attr('src', sidePics[_index]['video']);
        }
        else{
            $('#mainPhotoAlbum').css('display', 'block');
            $('#mainVideoPhotoAlbum').css('display', 'none');

            $('#mainPhotoAlbum').attr('src', sidePics[_index]['mainPic']);
            $('#mainPhotoAlbum').attr('alt', sidePics[_index]['alt']);
            $('#mainVideoPhotoAlbum').attr('src', '');
        }

        if(sidePics[_index]['showInfo']) {
            $('.photoAlbumTopLike').removeClass('fullLikePhotoAlbum');
            $('.photoAlbumTopDisLike').removeClass('fullDisLikePhotoAlbum');

            $('#photoAlbumLikeSection').css('display', 'block');
            $('.photoAlbumDisLikeCount').text(sidePics[_index]['dislike']);
            $('.photoAlbumLikeCount').text(sidePics[_index]['like']);

            $('.photoAlbumTopLike').attr('picId', sidePics[_index]['id']);
            $('.photoAlbumTopDisLike').attr('picId', sidePics[_index]['id']);

            if(sidePics[_index]['userLike'] == 1)
                likePhotoAlbum(1);
            else if(sidePics[_index]['userLike'] == -1)
                likePhotoAlbum(-1);
        }
        else
            $('#photoAlbumLikeSection').css('display', 'none');

        $('#photoAlbumDescription').text(sidePics[_index]['description']);
        if(userInPhoto !== false && userInPhoto == sidePics[_index].userName) {
            $('#deletePicIconsPhotoAlbum').css('display', 'flex');
            $('#deletePicIconsPhotoAlbum').attr('dataValue', sidePics[_index].id);
        }
        else {
            $('#deletePicIconsPhotoAlbum').css('display', 'none');
            $('#deletePicIconsPhotoAlbum').attr('dataValue', 0);
        }

    }

    function likePhotoAlbum(_like){
        $('.photoAlbumTopLike').removeClass('fullLikePhotoAlbum');
        $('.photoAlbumTopDisLike').removeClass('fullDisLikePhotoAlbum');
        sidePics[choosenIndex]['userLike'] = _like;

        if(_like == 1)
            $('.photoAlbumTopLike').addClass('fullLikePhotoAlbum');
        else if(_like == -1)
            $('.photoAlbumTopDisLike').addClass('fullDisLikePhotoAlbum');
    }

    function setLikeNumberInPhotoAlbum(_count, _kind){
        if(_kind == 'like') {
            $('.photoAlbumLikeCount').text(_count);
            sidePics[choosenIndex]['like'] = _count;
        }
        else if(_kind == 'dislike'){
            $('.photoAlbumDisLikeCount').text(_count);
            sidePics[choosenIndex]['dislike'] = _count;
        }
    }

    function closePhotoAlbumModal(){
        $('#mainVideoPhotoAlbum').attr('src', '');
        $('#photoAlbumModal').modal('hide');
    }

    var deletedPhotoInAlbum = false;
    function openDeletePhotoModal(){
        deletedPhotoInAlbum = $('#deletePicIconsPhotoAlbum').attr('dataValue');
        var text = 'آیا از حذف عکس خود اطمینان دارید؟ در صورت حذف محتوای مورد نظر قابل بازیابی نمی باشد.';
        openWarning(text, doPhotoDeleteInAlbum); // in general.alert.blade.php
    }

    function doPhotoDeleteInAlbum(){
        $.ajax({
            type: 'post',
            url: '{{route("album.pic.delete")}}',
            data: {
                _token: '{{csrf_token()}}',
                id: deletedPhotoInAlbum
            },
            success: function(response){
                response = JSON.parse(response);
                if(response.status == 'ok')
                    location.reload();
                else
                    showSuccessNotifi('{{__('در حذف عکس مشکلی پیش آمده لطفا دوباره تلاش نمایید.')}}', 'left', 'red'); // in general.alert.blade.php
            },
            error: function(){
                showSuccessNotifi('{{__('در حذف عکس مشکلی پیش آمده لطفا دوباره تلاش نمایید.')}}', 'left', 'red'); // in general.alert.blade.php
            }
        })
    }

    function likeAlbumPic(_element, _like){
        if(!checkLogin())
            return;

        var id = $('.photoAlbumTopLike').attr('picId');

        $.ajax({
            type: 'post',
            url: '{{route('likePhotographer')}}',
            data: {
                _token: '{{csrf_token()}}',
                id : id,
                like : _like
            },
            success: function(response){
                response = JSON.parse(response);
                if(response.status == 'ok'){
                    setLikeNumberInPhotoAlbum(response.like, 'like');
                    setLikeNumberInPhotoAlbum(response.disLike, 'dislike');
                    likePhotoAlbum(_like);
                }
            }
        });
    }
</script>
