@extends('pages.Business.businessLayout')


@section('head')
    <style>
        .plPc-0{
            padding-left: 0px;
        }
        .prPc-0{
            padding-right: 0px;
        }
        div[class^="col-"]{
            float: right;
        }
        @media (max-width: 991px) {
            div[class^="col-md"]{
                width: 100%;
            }
            .plPc-0{
                padding-left: 15px;
            }
            .prPc-0{
                padding-right: 15px;
            }
        }
    </style>

    <style>

    </style>
@endsection

@section('body')

    @include('component.smallShowReview')

    <div id="topInfos" class="topInfoFixed">
        <div class="infosSec">
            <div class="info">
                <h1 style="font-weight: bold;">{{$localShop->name}}</h1>
                <div class="address"> {{$localShop->address}} </div>
            </div>
            <div class="fullyCenterContent pic" onclick="openAlbum('mainPics')" style="cursor: pointer">
                <img src="{{$localShop->mainPic->pic['f']}}" class="resizeImgClass" onload="fitThisImg(this)">
            </div>
        </div>
        <div class="tabRow fastAccess">
            @if(isset($localShop->description))
                <div class="tab doubleQuet selected" onclick="goToSection('description')">
                    <div class="text">توضیحات</div>
                </div>
            @endif
            <div class="tab earthIcon" onclick="goToSection('map')">
                <div class="text">نقشه</div>
            </div>
            <div class="tab EmptyCommentIcon" onclick="goToSection('review')">
                <div class="text">دیدگاه شما</div>
            </div>
            <div class="tab questionIcon" onclick="goToSection('question')">
                <div class="text">سوال و جواب ها</div>
            </div>
        </div>

        <div class="mainHeaderButts">
            <div class="fullyCenterContent emptyCameraIconAfter">
                <div class="text">گذاشتن عکس</div>
            </div>
            <div class="fullyCenterContent BookMarkIconEmptyAfter">
                <div class="text">نشان کردن</div>
            </div>
            <div class="fullyCenterContent emptyShareIconAfter">
                <div class="text">اشتراک گذاری</div>
            </div>
        </div>
    </div>

    <div class="showHeader">
        <div class="container">
            <div class="inff">
                <h1 style="font-weight: bold;">{{$localShop->name}}</h1>
                <div class="address">{{$localShop->address}}</div>
            </div>
            <div class="mainHeaderButts">
                <div class="fullyCenterContent emptyCameraIconAfter">
                    <div class="text">گذاشتن عکس</div>
                </div>
                <div class="fullyCenterContent BookMarkIconEmptyAfter">
                    <div class="text">نشان کردن</div>
                </div>
                <div class="fullyCenterContent emptyShareIconAfter">
                    <div class="text">اشتراک گذاری</div>
                </div>
            </div>
        </div>
    </div>

    <div class="grayBackGround showBody">
        <div class="container">
            <div class="row">
                <div class="col-md-7 plPc-0">
                    <div id="mainSlider" class="fullyCenterContent bodySec imgSliderSec swiper-container" style="height: 420px">
                        <div class="swiper-wrapper">
                            @foreach($localShop->pics as $pic)
                                <div class="swiper-slide" style="overflow: hidden">
                                    <img src="{{$pic->pic['s']}}" alt="{{$localShop->name}}" class="resizeImgClass" onload="fitThisImg(this)" onclick="openAlbum('mainPics', {{$pic->id}})">
                                </div>
                            @endforeach
                        </div>
                        <div class="left-nav left-nav-header swiper-button-next mainSliderNavBut"></div>
                        <div class="right-nav right-nav-header swiper-button-prev mainSliderNavBut"></div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="bodySec infoSec">
                        <div class="iWasHere flagIcon">من اینجا بودم</div>
                        <div class="boldText">{{$localShop->name}}</div>
                        <div class="normText">{{$localShop->address}}</div>
                        <div class="phone telephoneIconAfter">
                            @foreach($localShop->telephone as $telephone)
                                <a href="tel:{{$telephone}}">{{$telephone}}</a>
                            @endforeach
                        </div>
                        <div class="groupSec">
                            <div class="boldText mr4bef clockIcon">ساعات کاری</div>
                            <div class="weekTime">
                                @if($localShop->isBoarding == 0)
                                    <div>
                                        <span>روزهای هفته:</span>
                                        <span>
                                            {{$localShop->inWeekOpenTime == null ? '' : $localShop->inWeekOpenTime}}
                                            تا
                                            {{$localShop->inWeekCloseTime == null ? '' : $localShop->inWeekCloseTime}}
                                        </span>
                                    </div>
                                    <div>
                                        <span>قبل تعطیلی:</span>
                                        @if($localShop->afterClosedDayIsOpen == 1)
                                        <span>
                                            {{$localShop->afterClosedDayOpenTime == null ? '' : $localShop->afterClosedDayOpenTime}}
                                            تا
                                            {{$localShop->afterClosedDayCloseTime == null ? '' : $localShop->afterClosedDayCloseTime}}
                                        </span>
                                        @else
                                            <span class="closse">تعطیل</span>
                                        @endif
                                    </div>
                                @else
                                    <div>
                                        <span style="color: green;">شبانه روزی</span>
                                    </div>
                                @endif
                                <div>
                                    <span>روزهای تعطیل:</span>
                                    @if($localShop->closedDayIsOpen == 1)
                                        <span>
                                            {{$localShop->closedDayOpenTime == null ? '' : $localShop->closedDayOpenTime}}
                                            تا
                                            {{$localShop->closedDayCloseTime == null ? '' : $localShop->closedDayCloseTime}}
                                        </span>
                                    @else
                                        <span class="closse">تعطیل</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{--the best localShop section--}}

{{--                        <div class="groupSec">--}}
{{--                            <div class="boldText mr4bef fullStarRating">انتخاب بهترین مغازه دار</div>--}}
{{--                            <div class="normText" style="padding: 0px 20px;">--}}
{{--                                آیا شما از مغازه و مغازه دار راضی بودید؟--}}
{{--                            </div>--}}
{{--                            <div class="ratingButtons">--}}
{{--                                <div class="likeSec" onclick="likeDisLikeShop(this, 1)">--}}
{{--                                    <div class="fullyCenterContent icon LikeIconEmpty">--}}
{{--                                        <span class="count">102</span>--}}
{{--                                    </div>--}}
{{--                                    <div class="fullyCenterContent result">--}}
{{--                                        <div>--}}
{{--                                            <span class="name">محلی : </span>--}}
{{--                                            <span class="num">100</span>--}}
{{--                                        </div>--}}
{{--                                        <div>--}}
{{--                                            <span class="name">غیر محلی : </span>--}}
{{--                                            <span class="num">32</span>--}}
{{--                                        </div>--}}
{{--                                        <div>--}}
{{--                                            <span class="name">نامشخص : </span>--}}
{{--                                            <span class="num">32</span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="disLikeSec" onclick="likeDisLikeShop(this, -1)">--}}
{{--                                    <div class="fullyCenterContent icon DisLikeIconEmpty">--}}
{{--                                        <span class="count">243</span>--}}
{{--                                    </div>--}}
{{--                                    <div class="fullyCenterContent result">--}}
{{--                                        <div>--}}
{{--                                            <span class="name">محلی : </span>--}}
{{--                                            <span class="num">100</span>--}}
{{--                                        </div>--}}
{{--                                        <div>--}}
{{--                                            <span class="name">غیر محلی : </span>--}}
{{--                                            <span class="num">32</span>--}}
{{--                                        </div>--}}
{{--                                        <div>--}}
{{--                                            <span class="name">نامشخص : </span>--}}
{{--                                            <span class="num">32</span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="fullyCenterContent bodySec adver fullRow">تبلیغ</div>
                </div>
            </div>

            <div id="stickyIndicator" class="row">
                <div class="col-md-12">
                    <div class="bodySec fastAccess">
                        @if(isset($localShop->description))
                            <div class="tab doubleQuet selected" onclick="goToSection('description')">
                                <div class="text">توضیحات</div>
                            </div>
                        @endif
                        <div class="tab earthIcon" onclick="goToSection('map')">
                            <div class="text">نقشه</div>
                        </div>
                        <div class="tab EmptyCommentIcon" onclick="goToSection('review')">
                            <div class="text">دیدگاه شما</div>
                        </div>
                        <div class="tab questionIcon" onclick="goToSection('question')">
                            <div class="text">سوال و جواب ها</div>
                        </div>
                    </div>
                </div>
            </div>

            @if(isset($localShop->description))
                <div class="row">
                    <div class="col-md-12">
                        <div class="bodySec pad-15">
                            <h2 class="headerSec doubleQuet">توضیحات</h2>
                            <div class="descriptionBody" style="color: #636363;">{{$localShop->description}}</div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-md-3">
                    <div class="fullyCenterContent bodySec adver sideMap">تبلیغ</div>
                    <div class="fullyCenterContent bodySec adver sideMap">تبلیغ</div>
                </div>
                <div class="col-md-9 prPc-0">
                    <div id="mapDiv" class="bodySec map"></div>
                </div>
            </div>

            <div class="row">
                <div id="inputReviewSec" class="col-md-8">
                    <div class="inputReviewBodies">
                        <div class="bodySec">
                            <h2 class="yourReviewHeader EmptyCommentIcon">
                                دیدگاه شما
                                <span class="iconClose" onclick="closeWriteReview()"></span>
                            </h2>
                            <div class="inputReviewSec">
                                <div class="firsRow">
                                    <div class="fullyCenterContent uPic50">
                                        <img src="{{$userPic}}" class="resizeImgClass" onload="fitThisImg(this)" style="width: 100%" >
                                    </div>
                                    <textarea id="inputReviewText" class="autoResizeTextArea Inp" placeholder="کاربر چه فکر یا احساسی داری..." onfocus="openWriteReview()"></textarea>
                                </div>
                                <div class="uploadedFiles"></div>
                                <div id="friendAddedSection" class="searchYouFriendDiv" onclick="$('#friendSearchInput').focus()">
                                    <input id="friendSearchInput"
                                           type="text"
                                           placeholder="با چه کسانی بودید؟ نام کاربری را وارد نمایید"
                                           onfocus="openWriteReview()"
                                           onkeyup="searchUserFriend(this)">
                                    <div class="searchResultUserFriend"></div>
                                </div>
                            </div>
                        </div>
                        <div class="bodySec">
                            <div class="reviewButs">
                                <label for="reviewPictureInput" class="but addPhotoIcon"> عکس اضافه کنید.</label>
                                <label for="reviewVideoInput" class="but addVideoIcon">ویدیو اضافه کنید.</label>
                                <label for="review360VideoInput" class="but addVideo360Icon">ویدیو 360 اضافه کنید.</label>
                                <div class="but addFriendIcon" onclick="openWriteReview(); $('#friendSearchInput').focus();">دوستنتان را TAG کنید.</div>

                                <input type="file" id="reviewPictureInput" accept="image/png,image/jpeg,image/jpg,image/webp" style="display: none;" onchange="uploadFileForReview(this, 'image')">
                                <input type="file" id="reviewVideoInput" accept="video/*" style="display: none;" onchange="uploadFileForReview(this, 'video')">
                                <input type="file" id="review360VideoInput" accept="video/*" style="display: none;" onchange="uploadFileForReview(this, '360Video')">
                            </div>
                            <div class="reviewQues showWhenNeed" style="display: none;"></div>
                            <div class="reviewSubmit showWhenNeed" onclick="storeReview(this)">ارسال دیدگاه</div>
                            <div class="reviewSubmit showWhenNeed hidden" style="cursor: not-allowed">
                                <img src="{{URL::asset('images/icons/mGear.svg')}}" style="width: 30px; height: 30px;">
                                درحال ارسال دیدگاه
                            </div>
                        </div>
                    </div>

                    <div class="reviewShowSection">
                        <div id="showReviewsMain1"></div>
                        <div id="showReviewsMain2"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="fullyCenterContent bodySec adver sideMap">تبلیغ</div>
                    <div class="fullyCenterContent bodySec adver sideMap">تبلیغ</div>
                </div>
{{--                <div class="col-md-8 reviewShowSection">--}}
{{--                    <div id="showReviewsMain1"></div>--}}
{{--                    <div id="showReviewsMain2"></div>--}}
{{--                </div>--}}
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="bodySec pad-15">
                        <h2 class="headerSec questionIcon">سوال و جواب</h2>
                        <div id="questionSection" class="questionBodies">
                            <div>
                                <div style="font-weight: bold; font-size: 16px;">سؤلات خود را بپرسید تا با کمک دوستانتان آگاهانه‌تر سفر کنید. همچنین می‌توانید با پاسخ یه سؤالات دوستانتان علاوه بر دریافت امتیاز، اطلاعات خود را به اشتراک بگذارید.</div>
                                <div style="margin-top: 12px; font-size: 15px;">در حال حاضر 0 سؤال 0 پاسخ موجود می‌باشد.</div>
                            </div>
                            <div class="inputQuestionSec">
                                <div class="fullyCenterContent uPic50">
                                    <img src="{{$userPic}}" class="resizeImgClass" onload="fitThisImg(this)" style="width: 100%" >
                                </div>
                                <div class="inpQ">
                                    <textarea class="autoResizeTextArea" placeholder="شما چه سوالی دارید؟"></textarea>
                                    <button>ارسال</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script async src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyCdVEd4L2687AfirfAnUY1yXkx-7IsCER0"></script>

    <script>
        var localShop = {!! $localShop !!};
        var mainMap;
        var newReview = {
            code: "{{$codeForReview}}",
            userAssigned: [],
            files: [],
        };

        $(window).ready(() => {
            initMap();
            autosize($('.autoResizeTextArea'));

            var reviewsText = [[], []];
            localShop.review.map((item, index) => reviewsText[index%2].push(createSmallReviewHtml(item)) );
            $('#showReviewsMain1').html(reviewsText[0]);
            $('#showReviewsMain2').html(reviewsText[1]);

            new Swiper('#mainSlider', {
                spaceBetween: 0,
                centeredSlides: true,
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                navigation: {
                    prevEl: '.swiper-button-next',
                    nextEl: '.swiper-button-prev',
                },
            });
        });

    </script>
    <script>
        var cancelThisReviewFile = false;
        var reviewFileInUpload = false;
        var uploadReviewFileAjax = null;

        function uploadFileForReview(_input, _kind){
            openWriteReview();
            if(_kind == 'image' && _input.files && _input.files[0]){
                var reader = new FileReader();
                reader.onload = e => {
                    newReview.files.push({
                        savedFile: '',
                        uploaded: -1,
                        image: e.target.result,
                        kind: _kind,
                        file: _input.files[0],
                        code: Math.floor(Math.random()*1000)
                    });
                    createNewFileUploadCard(newReview.files.length - 1);
                    reviewFileUploadQueue();
                };
                reader.readAsDataURL(_input.files[0]);
            }
            else if(_kind == 'video' || _kind == '360Video'){
                var ind = newReview.files.push({
                    savedFile: '',
                    thumbnailFile: '',
                    uploaded: -1,
                    image: '',
                    kind: _kind,
                    file: _input.files[0],
                    code: Math.floor(Math.random()*1000)
                });
                convertVideoFileForConvert(ind-1);
            }
        }

        function createNewFileUploadCard(_index){
            var file = newReview.files[_index];
            var text = `<div id="uplaodedImg_${file.code}" class="uploadFileCard">
                            <div class="img">
                                <img src="${file.image}" class="resizeImgClass" onload="fitThisImg(this)">
                            </div>
                            <div class="absoluteBackground tickIcon"></div>
                            <div class="absoluteBackground warningIcon"> اشکال در بارگذاری</div>
                            <div class="absoluteBackground process">
                                <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
                                <div class="processCounter">0%</div>
                            </div>
                            <div class="hoverInfos">
                                <div class="cancelButton closeIconWithCircle" onclick="deleteThisUploadedReviewFile(${file.code})" >
                                     حذف عکس
                                </div>
                            </div>
                        </div>`;
            $('.uploadedFiles').append(text);
        }

        function convertVideoFileForConvert(_index){
            var uFile = newReview.files[_index];
            window.URL = window.URL || window.webkitURL;

            var video = document.createElement('video');
            video.preload = 'metadata';
            video.src = URL.createObjectURL(uFile.file);

            var fileReader = new FileReader();
            fileReader.onload = function() {
                var blob = new Blob([fileReader.result], {type: uFile.file.type});
                var url = URL.createObjectURL(blob);
                var timeupdate = function() {
                    if (snapImage()) {
                        video.removeEventListener('timeupdate', timeupdate);
                        video.pause();
                    }
                };
                video.addEventListener('loadeddata', function() {
                    if (snapImage()) {
                        video.removeEventListener('timeupdate', timeupdate);
                    }
                });

                var snapImage = function() {
                    var canvas = document.createElement('canvas');
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                    var image = canvas.toDataURL();
                    var success = image.length > 100000;

                    if (success) {
                        newReview.files[_index].image = image;
                        URL.revokeObjectURL(url);
                        createNewFileUploadCard(_index);
                        reviewFileUploadQueue();
                    }
                    return success;
                };
                video.addEventListener('timeupdate', timeupdate);
                video.preload = 'metadata';
                video.src = url;
                video.muted = true;
                video.playsInline = true;
                video.play();
            };
            fileReader.readAsArrayBuffer(uFile.file);
        }

        function reviewFileUploadQueue(){
            if(!reviewFileInUpload){
                var uploadFileIndex = null;
                newReview.files.map((item, index) =>{
                    if(item.uploaded == -1 && uploadFileIndex == null)
                        uploadFileIndex = index;
                });
                if(uploadFileIndex != null){
                    reviewFileInUpload = true;
                    newReview.files[uploadFileIndex].uploaded = 0;
                    var uFile = newReview.files[uploadFileIndex];
                    $('#uplaodedImg_' + uFile.code).addClass('process');

                    var formData = new FormData();
                    formData.append('code', newReview.code);
                    formData.append('file', uFile.file);
                    formData.append('kind', uFile.kind);

                    uploadReviewFileAjax = $.ajax({
                        type: 'post',
                        url: '{{route("localShop.review.storePic")}}',
                        data: formData,
                        processData: false,
                        contentType: false,
                        xhr: function () {
                            var xhr = new XMLHttpRequest();
                            xhr.upload.onprogress = e => {
                                if (e.lengthComputable) {
                                    var percent = Math.round((e.loaded / e.total) * 100);
                                    $('#uplaodedImg_' + uFile.code).find('.processCounter').text(percent + '%');
                                }
                            };
                            return xhr;
                        },
                        success: response => {
                            reviewFileInUpload = false;
                            if (response.status == 'ok') {
                                if(cancelThisReviewFile) {
                                    doDeleteReviewFile(uploadFileIndex);
                                    cancelThisReviewFile = false;
                                }
                                if(uFile == 'image'){
                                    $('#uplaodedImg_' + uFile.code).removeClass('process');
                                    $('#uplaodedImg_' + uFile.code).addClass('done');
                                    newReview.files[uploadFileIndex].uploaded = 1;
                                    newReview.files[uploadFileIndex].savedFile = response.result;
                                    reviewFileUploadQueue();
                                }
                                else{
                                    newReview.files[uploadFileIndex].savedFile = response.result;
                                    uploadReviewVideoThumbnail(uploadFileIndex);
                                }
                            }
                            else{
                                $('#uplaodedImg_' + uFile.code).removeClass('process');
                                $('#uplaodedImg_' + uFile.code).addClass('error');
                                newReview.files[uploadFileIndex].uploaded = -2;
                                reviewFileUploadQueue();
                            }
                        },
                        error: err => {
                            reviewFileInUpload = false;
                            $('#uplaodedImg_' + uFile.code).removeClass('process');
                            $('#uplaodedImg_' + uFile.code).addClass('error');
                            newReview.files[uploadFileIndex].uploaded = -2;
                            reviewFileUploadQueue();
                        }
                    })
                }
            }
        }

        function uploadReviewVideoThumbnail(_index){
            var uFile = newReview.files[_index];

            var videoThumbnail = new FormData();
            videoThumbnail.append('code', newReview.code);
            videoThumbnail.append('kind', 'videoPic');
            videoThumbnail.append('file', uFile.image);
            videoThumbnail.append('fileName', uFile.savedFile);

            $.ajax({
                type: 'post',
                url: '{{route("localShop.review.storePic")}}',
                data: videoThumbnail,
                processData: false,
                contentType: false,
                success: response => {
                    if(response.status == 'ok'){
                        $('#uplaodedImg_' + uFile.code).removeClass('process');
                        $('#uplaodedImg_' + uFile.code).addClass('done');
                        newReview.files[_index].uploaded = 1;
                        newReview.files[_index].thumbnailFile = response.result;
                        reviewFileUploadQueue();
                    }
                },
                error: err => {
                    $('#uplaodedImg_' + uFile.code).removeClass('process');
                    $('#uplaodedImg_' + uFile.code).addClass('error');
                    newReview.files[_index].uploaded = -2;
                    reviewFileUploadQueue();
                }
            })
        }

        function deleteThisUploadedReviewFile(_code){
            var findedIndex = null;
            newReview.files.map((item, index) => {
               if(item.code == _code)
                   findedIndex = index;
            });

            if(findedIndex != null)
                doDeleteReviewFile(findedIndex);
        }

        function doDeleteReviewFile(_index){
            var dFile = newReview.files[_index];
            if(dFile.uploaded == 1){
                $.ajax({
                    type: 'delete',
                    url: '{{route("localShop.review.deletePic")}}',
                    data:{
                        _token: '{{csrf_token()}}',
                        fileName: dFile.savedFile,
                        code: newReview.code,
                    },
                    success: response => {
                        if(response.status == 'ok'){
                            $(`#uplaodedImg_${dFile.code}`).remove();
                            newReview.files.splice(_index, 1);
                        }
                    },
                })
            }
            else if(dFile.uploaded == 0)
                cancelThisReviewFile = true;
            else{
                $(`#uplaodedImg_${dFile.code}`).remove();
                newReview.files.splice(_index, 1);
            }
        }

        function storeReview(_element){
            var canUpload = false;
            var text = $('#inputReviewText').val();

            if(text.trim().length > 0)
                canUpload = true;

            newReview.files.map(item =>{
                if(item.uploaded == 0){
                    openWarning('یکی از فایل ها درحال آپلود می باشد. منتظر بمانید.');
                    return;
                }
                if(item.uploaded == 1)
                    canUpload = true;
            });

            $(_element).next().removeClass('hidden');
            $(_element).addClass('hidden');

            $.ajax({
                type: 'post',
                url: '{{route("localShop.review.store")}}',
                data: {
                    _token: '{{csrf_token()}}',
                    kindPlaceId: 13,
                    placeId: localShop.id,
                    code: newReview.code,
                    userAssigned: JSON.stringify(newReview.userAssigned),
                    text: text,
                },
                success: response =>{
                    $(_element).next().addClass('hidden');
                    $(_element).removeClass('hidden');

                    if(response.status == 'ok'){
                        closeWriteReview();
                        newReview.code = response.result;
                        newReview.userAssigned = [];
                        newReview.files = [];
                        $('#inputReviewText').val('');
                        $('#friendAddedSection').find('.acceptedUserFriend').remove();
                        $('.uploadedFiles').find('.uploadFileCard').remove();
                        showSuccessNotifi('دیدگاه شما با موفقیت ثبت شد.', 'left', 'var(--koochita-blue)');
                    }
                    else
                        showSuccessNotifi('در ثبت دیدگاه مشکلی پیش امده.', 'left', 'red');
                },
                error: err => {
                    console.log(err);
                    showSuccessNotifi('در ثبت دیدگاه مشکلی پیش امده.', 'left', 'red');
                    $(_element).next().addClass('hidden');
                    $(_element).removeClass('hidden');
                }
            })

        }

        function openAlbum(_kind, selectId = 0){
            if(_kind == 'mainPics'){
                var showPics = [];
                var selectIndex = 0;
                localShop.pics.map((item, index) => {
                    if(item.id == selectId)
                        selectIndex = index;
                    showPics.push({
                        id: `main_${item.id}`,
                        sidePic: item.pic.l,
                        mainPic: item.pic.main,
                        userPic: localShop.user.userPic,
                        userName: localShop.user.username,
                        showInfo: false,
                    })
                });
                createPhotoModal('آلبوم عکس', showPics, selectIndex) ; //in photoAlbumModal.blade.php
            }
        }

        function initMap(){
            var mapOptions = {
                center: new google.maps.LatLng(localShop.lat, localShop.lng),
                zoom: 15,
                styles: window.googleMapStyle
            };
            var mapElementSmall = document.getElementById('mapDiv');
            mainMap = new google.maps.Map(mapElementSmall, mapOptions);

            new google.maps.Marker({
                position: new google.maps.LatLng(localShop.lat, localShop.lng)
            }).setMap(mainMap);
        }

        function openWriteReview(){
            $('#darkModal').show();
            $('#inputReviewSec').addClass('openReviewSec');
            autosize($('#inputReviewText'));
        }

        function closeWriteReview(){
            $('#darkModal').hide();
            $('#inputReviewSec').removeClass('openReviewSec');
            $('#inputReviewText').css('height', '80px');
        }

        function likeDisLikeShop(_element, _like){
            $(_element).parent().addClass('youRate');
            $(_element).parent().find('.selected').removeClass('selected');
            $(_element).addClass('selected');
        }

        function goToSection(_section){
            var topScroll = 0;
            var topInfoHeight = $('#topInfos').height();

            if(_section == 'description')
                topScroll = $('#stickyIndicator').offset().top - 10;
            else if(_section == 'map')
                topScroll = $('#mapDiv').offset().top - topInfoHeight+10;
            else if(_section == 'review')
                topScroll = $('#inputReviewSec').offset().top - topInfoHeight+10;
            else if(_section == 'question')
                topScroll = $('#questionSection').offset().top - topInfoHeight+10;

            $('html, body').animate({ scrollTop: topScroll }, 1000);
        }

        function searchUserFriend(_element){
            var value = $(_element).val();
            $('.searchResultUserFriend').empty().removeClass('open');

            if(value.trim().length > 1){
                searchForUserCommon(value)
                    .then(response => {
                        var text = '';
                        var userName = response.userName;
                        userName.map(item => text += `<div class="UserIcon result" onclick="addToSelectedUser(this)">${item.username}</div>`);
                            $('.searchResultUserFriend').empty();
                    })
                    .catch(err => {
                        $('.searchResultUserFriend').html(text).addClass('open');
                        console.error(err);
                    });
            }
            else
                $('.searchResultUserFriend').empty().removeClass('open');
        }

        function deleteAssigned(_element, _index){
            newReview.userAssigned.splice(_index, 1);
            $(_element).parent().remove();
        }

        function addToSelectedUser(_element){
            var username = $(_element).text();
            var text = '';
            if(newReview.userAssigned.indexOf(username) == -1) {
                var index = newReview.userAssigned.push(username);
                text = `<div class="acceptedUserFriend">
                            <div class="name">${username}</div>
                            <div class="iconClose" onclick="deleteAssigned(this, ${index-1})"></div>
                        </div>`;
            }

            $('#friendSearchInput').val('').before(text);
            $('.searchResultUserFriend').empty().removeClass('open');
        }

        $(window).on('scroll', e => {
            var tabShow = '';
            var topInfoHeight = $('#topInfos').height();
            let topOfSticky = document.getElementById('stickyIndicator').getBoundingClientRect().top;
            if(topOfSticky < 0 && !$('#topInfos').hasClass('open'))
                $('#topInfos').addClass('open');
            else if(topOfSticky >= 0 && $('#topInfos').hasClass('open'))
                $('#topInfos').removeClass('open');

            var mapTopScroll = document.getElementById('mapDiv').getBoundingClientRect().top - topInfoHeight;
            var inputReviewScroll = document.getElementById('inputReviewSec').getBoundingClientRect().top - topInfoHeight;
            var questionSectionScroll = document.getElementById('questionSection').getBoundingClientRect().top - topInfoHeight;

            if(questionSectionScroll < 0)
                tabShow = 'questionIcon';
            else if(inputReviewScroll <  0)
                tabShow = 'EmptyCommentIcon';
            else if(mapTopScroll <  0)
                tabShow = 'earthIcon';
            else
                tabShow = 'doubleQuet';

            $('.tabRow.fastAccess').find('.tab.selected').removeClass('selected');
            $('.tabRow.fastAccess').find(`.tab.${tabShow}`).addClass('selected');

        });

    </script>

@endsection
