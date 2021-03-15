<link rel="stylesheet" href="{{URL::asset('css/shazdeDesigns/modalPhotos.css?v='.$fileVersions)}}">

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
                <a href="#" class="fullyCenterContent userPictureDiv circleBase type2 userProfileLinks">
                    <img class="photoAlbumUserPic resizeImgClass" alt="کوچیتا، سامانه جامع گردشگری ایران"  style="width: 100%" onload="fitThisImg(this)">
                </a>
                <div class="commentWriterExperienceDetails" style="width: calc(100% - 60px)">
                    <a href="#" class="userProfileName photoAlbumUserName userProfileLinks"></a>
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
                                <img id="mainPhotoAlbum" alt="کوچیتا، سامانه جامع گردشگری ایران">
                                <video id="mainVideoPhotoAlbum" controls></video>
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
                        <a href="#" class="fullyCenterContent userPictureDiv circleBase type2 userProfileLinks">
                            <img alt="کوچیتا، سامانه جامع گردشگری ایران" class="photoAlbumUserPic resizeImgClass" style="width: 100%" onload="fitThisImg(this)">
                        </a>
                        <div class="commentWriterExperienceDetails photoAlbumTopUserName" style="width: calc(100% - 60px)">
                            <a href="#" class="userProfileName photoAlbumUserName userProfileLinks"></a>
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
    var deletePicInAlbumUrl = '{{route("upload.album.pic.delete")}}';
    var likePhotographerUrl = '{{route('likePhotographer')}}';
    var userProfileUrl_albume = '{{url('addPlace/index')}}';
    var sidePics;
    var choosenIndex;
    var userInPhoto = '{{auth()->check() ? auth()->user()->username : false}}';
    var srcSidePic = `<div id="sideAlbumPic##index##" class="rightColPhotosShowingModal ##isVideoClass##" onclick="##picIndex##">
                            <img src="##sidePic##" alt="##alt##" class="mainAlbumPic resizeImgClass" onload="fitThisImg(this)">
                        </div>`;

    // createPhotoModal() in forAllPages.js
</script>
