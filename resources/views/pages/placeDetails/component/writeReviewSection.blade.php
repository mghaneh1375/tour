<style>
    .editReviewPicturesSection{
        position: fixed;
        z-index: 99;
        background-color: #000000bf;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
    }
    .backEditReviewPic{
        color: var(--koochita-light-green);
        background-color: white !important;
        border: none;
        box-shadow: none;
        display: inline-block;
    }
</style>

<div id="reviewMainDivDetails" class="postModalMainDiv hidden" style="z-index: 9999;">
    <div class="modal-dialog">
        <div>
            <input type="hidden" id="storeReviewKindPlaceId" name="kindPlaceId" value="{{$kindPlaceId}}">
            <input type="hidden" id="storeReviewPlaceId" name="placeId" value="{{$place->id}}">
            <input type="hidden" id="storeReviewCode" name="code" value="{{$userCode}}">
            <input type="hidden" id="assignedMemberToReview" name="assignedUser">
            <input type="hidden" id="multiAnsInput" name="multiAns">
            <input type="hidden" id="multiQuestionInput" name="multiQuestion">
            <input type="hidden" id="rateAnsInput" name="rateAns">
            <input type="hidden" id="rateQuestionInput" name="rateQuestion">

            <div class="modal-content">
                <div class="postMainDivHeader" style="display: flex; justify-content: space-between">
                    <button type="button" class="close closeBtnPostModal" data-dismiss="modal" onclick="closeNewPostModal()">&times;</button>
                    {{__('دیدگاه شما')}}
                </div>
                <div class="commentInputMainDivModal">
                    <div class="inputBoxGeneralInfo inputBox postInputBoxModal">
                        <div class="profilePicForPostModal circleBase type2">
                            <img src="{{ $userPic }}" style="width: 100%; height: 100%; border-radius: 50%;">
                        </div>
                        <textarea id="postTextArea" class="inputBoxInput inputBoxInputComment openEmojiIcon"
                                  name="text" type="text"
                                  placeholder="{{ auth()->user()->username }}، چه فکر یا احساسی داری.....؟"
                                  style="overflow:hidden" data-emo onchange="checkReviewToSend()"></textarea>
                        <div id="emojiIcons" class="commentSmileyIcon " style="width: 300px; text-align: left"></div>
                    </div>

                    <div class="clear-both"></div>
                    <div class="row" style="width: 97%; margin: 0px auto;">
                        <div id="reviewShowPics" class="commentPhotosMainDiv"></div>
                    </div>

                    <div class="addParticipantName">
                        <span class="addParticipantSpan">با</span>
                        <div class="inputBoxGeneralInfo inputBox addParticipantInputBoxPostModal">
                            <textarea id="assignedSearch" class="inputBoxInput" placeholder="{{__('چه کسی بودید؟ نام کاربری را وارد کنید')}}" onkeyup="searchUser(this.value)"></textarea>
                            <div class="assignedResult" id="assignedResultReview"></div>
                            <div class="participantDivMainDiv" id="participantDivMainDiv"></div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-details-content">
                <center class="commentMoreSettingBar">
                    <div class="commentOptionsBoxes">
                        <label for="picReviewInput0">
                            <span class="addPhotoCommentIcon"></span>
                            <span class="commentOptionsText">{{__('عکس اضافه کنید.')}}</span>
                        </label>
                    </div>
                    <input type="file" id="picReviewInput0" accept="image/*" style="display: none"
                           onchange="uploadReviewPics(this, 0)">
                    <div class="commentOptionsBoxes">
                        <label for="videoReviewInput">
                            <span class="addVideoCommentIcon"></span>
                            <span class="commentOptionsText">{{__('ویدیو اضافه کنید.')}}</span>
                        </label>
                    </div>
                    <input type="file" id="videoReviewInput" accept="video/*" style="display: none" onchange="uploadReviewVideo(this, 0)">
                    <div class="commentOptionsBoxes">
                        <label for="video360ReviewInput">
                            <span class="add360VideoCommentIcon"></span>
                            <span class="commentOptionsText">{{__('افزودن ویدیو 360')}}</span>
                        </label>
                    </div>
                    <input type="file" id="video360ReviewInput" accept="video/*" style="display: none" onchange="uploadReviewVideo(this, 1)">
                    <div class="commentOptionsBoxes">
                        <span class="tagFriendCommentIcon"></span>
                        <span class="commentOptionsText">{{__('افزودن دوست')}}</span>
                    </div>
                </center>

                @foreach($textQuestion as $item)
                    <div id="questionDiv_{{$item->id}}" class="commentQuestionsForm">
                        <span class="addOriginCity">{{$item->description}}</span>
                        <div class="inputBoxGeneralInfo inputBox addOriginCityInputBoxPostModal">
                            <textarea id="textQuestionAns_{{$item->id}}" name="textAns[]" class="inputBoxInput inputBoxInputComment" style="border: solid gray 1px; border-radius: 5px"></textarea>
                            <input type="hidden" id="textQuestionId_{{$item->id}}" name="textId[]" value="{{$item->id}}">
                        </div>
                    </div>
                @endforeach

                @foreach($multiQuestion as $index => $item)
                    <div class="commentQuestionsForm">
                        <div class="visitKindCommentModalHeader">
                            {{$item->description}}
                        </div>
                        <div class="visitKindCommentModal">
                            @for($i = 0; $i < count($item->ans); $i++)
                                <label for="radioAns_{{$item->id}}_{{$item->ans[$i]->id}}">
                                    <b id="radioAnsStyle_{{$item->id}}_{{$item->ans[$i]->id}}"
                                       class="filterChoices multiSelectAns">
                                        {{$item->ans[$i]->ans}}
                                    </b>
                                </label>
                                <input id="radioAns_{{$item->id}}_{{$item->ans[$i]->id}}"
                                       value="{{$item->ans[$i]->id}}"
                                       name="radioAnsName_{{$item->id}}"
                                       onchange="radioChange(this.value, {{$item->id}}, {{$index}}, {{$item->ans[$i]->id}})"
                                       type="radio" style="display: none">
                            @endfor
                        </div>
                    </div>
                @endforeach

                <div class="commentQuestionsRatingsBox">
                    {{--<div class="commentQuestionsRatingsBoxHeader"></div>--}}

                    @for($i = 0; $i < count($rateQuestion); $i++)
                        <div class="display-inline-block full-width">
                            <b id="rateName_{{$i}}"
                               class="col-xs-3 font-size-15 line-height-108 pd-lt-0"></b>
                            <div class="prw_rup prw_common_bubble_rating overallBubbleRating col-xs-3 text-align-left pd-0">
                                <div class="font-size-25" style="display: flex;">
                                    <span id="rate_5_{{$i}}" class="starRating"
                                          onmouseover="momentChangeRate({{$i}}, 5, 'in')"
                                          onmouseleave="momentChangeRate({{$i}}, 5, 'out')"
                                          onclick="chooseQuestionRate({{$i}}, 5, {{$rateQuestion[$i]->id}})"></span>
                                    <span id="rate_4_{{$i}}" class="starRating"
                                          onmouseover="momentChangeRate({{$i}}, 4, 'in')"
                                          onmouseleave="momentChangeRate({{$i}}, 4, 'out')"
                                          onclick="chooseQuestionRate({{$i}}, 4, {{$rateQuestion[$i]->id}})"></span>
                                    <span id="rate_3_{{$i}}" class="starRating"
                                          onmouseover="momentChangeRate({{$i}}, 3, 'in')"
                                          onmouseleave="momentChangeRate({{$i}}, 3, 'out')"
                                          onclick="chooseQuestionRate({{$i}}, 3, {{$rateQuestion[$i]->id}})"></span>
                                    <span id="rate_2_{{$i}}" class="starRating"
                                          onmouseover="momentChangeRate({{$i}}, 2, 'in')"
                                          onmouseleave="momentChangeRate({{$i}}, 2, 'out')"
                                          onclick="chooseQuestionRate({{$i}}, 2, {{$rateQuestion[$i]->id}})"></span>
                                    <span id="rate_1_{{$i}}" class="starRating"
                                          onmouseover="momentChangeRate({{$i}}, 1, 'in')"
                                          onmouseleave="momentChangeRate({{$i}}, 1, 'out')"
                                          onclick="chooseQuestionRate({{$i}}, 1, {{$rateQuestion[$i]->id}})"></span>
                                </div>
                            </div>
                            <b class="col-xs-6 font-size-15 line-height-108">{{$rateQuestion[$i]->description}}</b>
                        </div>
                    @endfor
                </div>

                <button id="sendReviewButton" class="postMainDivFooter" type="button" onclick="checkReviewToSend('send');">
                    {{__('ارسال دیدگاه')}}
                </button>

                <div id="sendReviewLoader" class="postMainDivFooter" style="display: none; justify-content: center; align-items: center; color: #cccccc;">
                    <img src="{{URL::asset('images/icons/mGear.svg')}}" style="width: 30px; height: 30px;">
                    {{__('در حال ارسال دیدگاه')}}
                </div>

            </div>

        </div>

        <div id="editReviewPictures" class="editReviewPicturesSection backDark hidden">
            <span class="ui_overlay ui_modal photoUploadOverlay editSection">
                <div class="body_text" style="padding-top: 12px">
                   <div class="headerBar epHeaderBar"></div>
                   <div class="row">
                      <div class="col-md-12">
                         <div style="margin: 5px 15px">قاب مربع</div>
                         <div class="img-container" style="position: relative">
                            <img class="imgInEditor" id="imgEditReviewPics" alt="Picture"
                                 style="width: 100%;">
                         </div>
                      </div>
                   </div>
                   <div class="row" id="actions" >
                      <div class="col-md-12 docs-buttons">
                        <div class="editBtnsGroup">
                            <div class="editBtns">
                               <div class="flipHorizontal" data-toggle="tooltip"
                                    data-placement="top" title="Flip Horizontal"
                                    onclick="cropper.scaleY(-1)"></div>
                            </div>

                            <div class="editBtns">
                               <div class="flipVertical" data-toggle="tooltip" data-placement="top"
                                    title="Flip Vertical" onclick="cropper.scaleX(-1)"></div>
                            </div>
                        </div>
                        <div class="editBtnsGroup">
                            <div class="editBtns">
                               <div class="rotateLeft" data-toggle="tooltip" data-placement="top"
                                    title="چرخش 45 درجه ای به سمت چپ"
                                    onclick="cropper.rotate(-45)"></div>
                            </div>

                            <div class="editBtns">
                               <div class="rotateRight" data-toggle="tooltip" data-placement="top"
                                    title="چرخش 45 درجه ای به سمت راست"
                                    onclick="cropper.rotate(45)"></div>
                            </div>
                        </div>
                        <div class="editBtnsGroup">
                            <div class="editBtns">
                               <div class="cropping" data-toggle="tooltip" data-placement="top"
                                    title="برش" onclick="cropper.crop()"></div>
                            </div>

                            <div class="editBtns">
                               <div class="clearing" data-toggle="tooltip" data-placement="top"
                                    title="بازگشت به اول" onclick="cropper.clear()"></div>
                            </div>
                        </div>

                        <div class="upload" style="margin-right: auto;">
                            <div onclick="$('#editReviewPictures').addClass('hidden')" class="uploadBtn backEditReviewPic" >بازگشت</div>
                            <div onclick="cropReviewImg()" class="uploadBtn ui_button primary">تایید</div>
                        </div>

                        <div class="modal fade docs-cropped" id="getCroppedCanvasModal"
                               role="dialog" aria-hidden="true"
                               aria-labelledby="getCroppedCanvasTitle" tabindex="-1">
                           <div class="modal-dialog modal-dialog-scrollable">
                              <div class="modal-content">
                                 <div class="modal-header">
                                    <h5 class="modal-title" id="getCroppedCanvasTitle">Cropped</h5>
                                    <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                    </button>
                                 </div>
                                 <div class="modal-body"></div>
                                 <div class="modal-footer">
                                    <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Close</button>
                                    <a class="btn btn-primary" id="download"
                                       href="javascript:void(0);"
                                       download="cropped.jpg">Download</a>
                                 </div>
                              </div>
                           </div>
                        </div><!-- /.modal -->

                     </div>
                   </div>
               </div>
                <div class="ui_close_x" onclick="$('#editReviewPictures').addClass('hidden');"></div>
            </span>
        </div>
    </div>
</div>

<script>

    var rateQuestion = {!! json_encode($rateQuestion) !!} ;
    var textQuestions = {!! json_encode($textQuestion) !!};
    var rateQuestionAns = [];
    var allReviews;
    var reviewsCount;
    var assignedUser = [];
    var reviewPicNumber = 0;
    var reviewMultiAns = [];
    var reviewMultiAnsQuestionId = [];
    var reviewMultiAnsId = [];
    var reviewRateAnsQuestionId = [];
    var reviewRateAnsId = [];
    var imgCropNumber;
    var fileUploadNum = 0;

    $(window).ready(() => {
        $("#postTextArea").emojioneArea();
    })

    for (i = 0; i < rateQuestion.length; i++)
        rateQuestionAns[i] = 0;

    function newPostModal(kind = '') {
        if (!checkLogin())
            return;

        if($(window).width() > 767)
            $('html, body').animate({ scrollTop: $('#mainStoreReviewDiv').offset().top }, 800);

        $("#darkModal").show();
        $(".postModalMainDiv").removeClass('hidden');

        setTimeout(function () {
            if (kind == 'textarea')
                document.getElementById("postTextArea").focus();
            else if (kind == 'tag')
                $('#assignedSearch').focus();
        }, 500);
    }

    function momentChangeRate(_index, _value, _kind){

        if(_kind == 'in') {
            for (i = 1; i < 6; i++) {
                if (_value < i) {
                    document.getElementById('rate_' + i + '_' + _index).classList.remove('starRatingGreen');
                    document.getElementById('rate_' + i + '_' + _index).classList.add('starRating');
                }
                else {
                    document.getElementById('rate_' + i + '_' + _index).classList.remove('starRating');
                    document.getElementById('rate_' + i + '_' + _index).classList.add('starRatingGreen');
                }
            }
            switch (_value) {
                case 1:
                    text = 'اصلا راضی نبودم';
                    break;
                case 2:
                    text = 'بد نبود';
                    break;
                case 3:
                    text = 'معمولی بود';
                    break;
                case 4:
                    text = 'خوب بود';
                    break;
                case 5:
                    text = 'عالی بود';
                    break;
            }

            document.getElementById('rateName_' + _index).innerText = text;
        }
        else{
            _value = rateQuestionAns[_index];
            for (i = 1; i < 6; i++) {
                if (_value < i) {
                    document.getElementById('rate_' + i + '_' + _index).classList.remove('starRatingGreen');
                    document.getElementById('rate_' + i + '_' + _index).classList.add('starRating');
                }
                else {
                    document.getElementById('rate_' + i + '_' + _index).classList.remove('starRating');
                    document.getElementById('rate_' + i + '_' + _index).classList.add('starRatingGreen');
                }
            }
            switch (_value) {
                case 0:
                    text = '';
                    break;
                case 1:
                    text = 'اصلا راضی نبودم';
                    break;
                case 2:
                    text = 'بد نبود';
                    break;
                case 3:
                    text = 'معمولی بود';
                    break;
                case 4:
                    text = 'خوب بود';
                    break;
                case 5:
                    text = 'عالی بود';
                    break;
            }

            document.getElementById('rateName_' + _index).innerText = text;
        }
    }

    function chooseQuestionRate(_index, _value, _id){
        rateQuestionAns[_index] = _value;

        if(reviewRateAnsQuestionId.includes(_id)){
            var index = reviewRateAnsQuestionId.indexOf(_id);
            reviewRateAnsId[index] = _value;
        }
        else {
            reviewRateAnsQuestionId[reviewRateAnsQuestionId.length] = _id;
            reviewRateAnsId[reviewRateAnsId.length] = _value;
        }

        document.getElementById('rateQuestionInput').value = JSON.stringify(reviewRateAnsQuestionId);
        document.getElementById('rateAnsInput').value = JSON.stringify(reviewRateAnsId);

        checkReviewToSend();
    }

    function searchUser(_value){
        if(_value != '' && _value != ' ') {
            $.ajax({
                type: 'post',
                url: findUser,
                data: {
                    'value': _value
                },
                success: function (response) {
                    if (response == 'nok3') {
                        document.getElementById('assignedResultReview').innerHTML = '';

                        if(_value.includes('@') && _value.includes('.')){
                            text = '<ul style="list-style: none;">';
                            text += '<li onclick="assignedUserToReview(\'' + _value + '\', 0)"  style="cursor: pointer; color: blue;"> دعوت کردن دوست خود : ' + _value + '</li>';
                            text += '</ul>';

                            document.getElementById('assignedResultReview').innerHTML = text;
                        }
                    }
                    else if (response != 'nok1' && response != 'nok2') {
                        var user = JSON.parse(response);
                        var userEmail = user['email'];
                        var userName = user['userName'];

                        text = '<ul>';
                        for(i = 0; i < userName.length; i++)
                            text += '<li onclick="assignedUserToReview(\'' + userName[i]['username'] + '\')" style="cursor: pointer">' + userName[i]['username'] + '</li>';
                        for(i = 0; i < userEmail.length; i++)
                            text += '<li onclick="assignedUserToReview(\'' + userEmail[i]['email'] + '\')" style="cursor: pointer">' + userEmail[i]['email'] + '</li>';
                        text += '</ul>';
                        document.getElementById('assignedResultReview').innerHTML = text;

                    }
                }
            })
        }
        else
            document.getElementById('assignedResultReview').innerHTML = '';

    }

    function assignedUserToReview(_email, _id){

        var text =  '<div class="participantDiv">\n' +
                    '   <span class="removeParticipantBtn" onclick="removeAssignedUserToReview(this, \'' + _email + '\')" style="cursor:pointer;"></span>' + _email +
                    '</div>';

        assignedUser[assignedUser.length] = _email;

        document.getElementById('assignedMemberToReview').value = JSON.stringify(assignedUser);

        document.getElementById('assignedResultReview').innerHTML = '';
        document.getElementById('assignedSearch').value = '';
        $('#participantDivMainDiv').append(text);
    }

    function removeAssignedUserToReview(element, _email){
        $(element).parent().remove();
        var index = assignedUser.indexOf(_email);
        assignedUser[index] = null;
        document.getElementById('assignedMemberToReview').value = JSON.stringify(assignedUser);
    }

    function uploadReviewPics(input){

        if (input.files && input.files[0]) {
            var lastNumber = reviewPicNumber;
            var text = '<div id="reviewPic_' + reviewPicNumber + '" class="commentPhotosDiv commentPhotosAndVideos">\n' +
                '<div id="reviewPicLoader_' + reviewPicNumber + '" class="loaderReviewPiUpload">' +
                '<div id="reviewPicLoaderBackGround_' + reviewPicNumber + '" class="loaderReviewBackGround"></div>' +
                '<div id="reviewPicLoaderPercent_' + reviewPicNumber + '" class="loaderReviewPercent"></div>' +
                '</div>\n' +
                '<img id="showPic' + reviewPicNumber + '"  style="width: 100%; height: 100px;">\n' +
                '<input type="hidden" id="fileName_' + reviewPicNumber + '" >\n' +
                '<div class="deleteUploadPhotoComment" onclick="deleteUploadedReviewFile(' + reviewPicNumber + ')"></div>\n' +
                '<div class="editUploadPhotoComment" onclick="openEditReviewPic(' + reviewPicNumber + ')"></div>\n' +
                '</div>';
            $('#reviewShowPics').append(text);

            var reader = new FileReader();
            reader.onload = function(e) {
                var mainPic = e.target.result;
                $('#showPic' + lastNumber).attr('src', mainPic);
                uploadedWriteReviewPicture[lastNumber] = mainPic;
            };
            reader.readAsDataURL(input.files[0]);

            var data = new FormData();

            data.append('pic', input.files[0]);
            data.append('code', $('#storeReviewCode').val());

            var uploadReviewPicLoader = $('#reviewPicLoaderBackGround_' + reviewPicNumber);
            var uploadReviewPicLoaderPercent = $('#reviewPicLoaderPercent_' + reviewPicNumber);
            $.ajax({
                type: 'post',
                url: reviewUploadPic,
                data: data,
                processData: false,
                contentType: false,
                xhr: function () {
                    var xhr = new XMLHttpRequest();
                    xhr.upload.onprogress = function (e) {
                        var percent = '0';
                        var percentage = '0%';

                        if (e.lengthComputable) {

                            percent = Math.round((e.loaded / e.total) * 100);
                            percentage = percent + '%';
                            size = 160 - (percent * 1.6);
                            size += 'px';

                            uploadReviewPicLoaderPercent.text(percentage);

                            leftBottom = (percent * 1.6)/2;
                            leftBottom += 'px';

                            uploadReviewPicLoader.css('width', size);
                            uploadReviewPicLoader.css('height', size);

                            uploadReviewPicLoader.css('left', leftBottom);
                            uploadReviewPicLoader.css('bottom', leftBottom);
                        }
                    };

                    return xhr;
                },
                success: function(response){
                    if(response == 'nok2') {
                        showSuccessNotifi('{{__("فرمت فایل باید jpeg و یا png باشد")}}', 'left', 'red');
                        $('#reviewPic_' + lastNumber).remove();
                    }
                    else{
                        try {
                            response = JSON.parse(response);
                            fileName = response[1];
                            document.getElementById('fileName_' + lastNumber).value = fileName;
                            $('#reviewPicLoader_' + lastNumber).remove();
                            fileUploadNum++;
                            checkReviewToSend();
                        } catch (e) {
                            $('#reviewPic_' + lastNumber).remove();
                        }
                    }
                    reviewPicNumber++;
                },
                error: function(err){
                    $('#reviewPic_' + lastNumber).remove();
                }
            });

        }
    }

    function uploadReviewVideo(input, _is360){

        var data = new FormData();
        data.append('video', input.files[0]);
        data.append('code',  $('#storeReviewCode').val());
        data.append('isVideo', 1);
        if(_is360 == 1)
            data.append('is360', 1);

        var lastNumber = reviewPicNumber;
        var text = '<div id="reviewPic_' + reviewPicNumber + '" class="commentPhotosDiv commentPhotosAndVideos">' +
            '<div id="reviewPicLoader_' + reviewPicNumber + '" class="loaderReviewPiUpload">' +
            '<div id="reviewPicLoaderBackGround_' + reviewPicNumber + '" class="loaderReviewBackGround"></div>' +
            '<div id="reviewPicLoaderPercent_' + reviewPicNumber + '" class="loaderReviewPercent"></div>' +
            '</div>\n' +
            '<img id="showPic' + reviewPicNumber + '"  style="width: 100%; height: 100px;">\n' +
            '<input type="hidden" id="fileName_' + reviewPicNumber + '" >\n' +
            '<div class="deleteUploadPhotoComment" onclick="deleteUploadedReviewFile(' + reviewPicNumber + ')"></div>\n' +
            '<div class="videoTimeDuration" id="videoDuration_' + reviewPicNumber + '"></div>\n' +
            '</div>';
        $('#reviewShowPics').append(text);

        window.URL = window.URL || window.webkitURL;

        var files = input.files;
        var video = document.createElement('video');
        video.preload = 'metadata';
        video.onloadedmetadata = function() {
            window.URL.revokeObjectURL(video.src);
            var duration = video.duration;
            sec = Math.floor(duration);
            min = Math.floor(sec/60);
            sec = sec - (min * 60);
            document.getElementById('videoDuration_' + lastNumber).innerText = min + ':' + sec;
        }
        video.src = URL.createObjectURL(files[0]);

        var file = input.files[0];
        var fileReader = new FileReader();
        fileReader.onload = function() {
            var blob = new Blob([fileReader.result], {type: file.type});
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
                var lastNumber = reviewPicNumber;

                if (success) {
                    var img = document.getElementById('showPic' + lastNumber);
                    img.src = image;
                    uploadedWriteReviewPicture[lastNumber] = image;
                    URL.revokeObjectURL(url);
                    data.append('videoPic', image);

                    var uploadReviewPicLoader = $('#reviewPicLoaderBackGround_' + reviewPicNumber);
                    var uploadReviewPicLoaderPercent = $('#reviewPicLoaderPercent_' + reviewPicNumber);
                    $.ajax({
                        type: 'post',
                        url: reviewUploadVideo,
                        data: data,
                        processData: false,
                        contentType: false,
                        xhr: function () {
                            var xhr = new XMLHttpRequest();
                            xhr.upload.onprogress = function (e) {
                                var percent = '0';
                                var percentage = '0%';

                                if (e.lengthComputable) {
                                    percent = Math.round((e.loaded / e.total) * 100);
                                    percentage = percent + '%';
                                    size = 160 - (percent * 1.6);
                                    size += 'px';

                                    uploadReviewPicLoaderPercent.text(percentage);
                                    console.log(percentage);

                                    leftBottom = (percent * 1.6)/2;
                                    leftBottom += 'px';
                                    uploadReviewPicLoader.css('width', size);
                                    uploadReviewPicLoader.css('height', size);

                                    uploadReviewPicLoader.css('left', leftBottom);
                                    uploadReviewPicLoader.css('bottom', leftBottom);
                                }
                            };

                            return xhr;
                        },
                        success: function(response){
                            try {
                                response = JSON.parse(response);
                                fileName = response[1];
                                document.getElementById('fileName_' + lastNumber).value = fileName;
                                $('#reviewPicLoader_' + lastNumber).remove();
                                fileUploadNum++;
                                checkReviewToSend();
                            } catch (e) {
                                $('#reviewPic_' + lastNumber).remove();
                            }
                            reviewPicNumber++;
                        },
                        error: function(err){
                            $('#reviewPic_' + lastNumber).remove();
                        }
                    });
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
        fileReader.readAsArrayBuffer(file);
    }

    function radioChange(value, _questionId, _index, _ansId){
        if(reviewMultiAns[_index] != null)
            document.getElementById('radioAnsStyle_' + _questionId + '_' + reviewMultiAns[_index]).classList.remove('filterChoose');

        document.getElementById('radioAnsStyle_' + _questionId + '_' + _ansId).classList.add('filterChoose');

        if(reviewMultiAnsQuestionId.includes(_questionId)){
            var index = reviewMultiAnsQuestionId.indexOf(_questionId);
            reviewMultiAnsId[index] = _ansId;
        }
        else {
            reviewMultiAnsQuestionId[reviewMultiAnsQuestionId.length] = _questionId;
            reviewMultiAnsId[reviewMultiAnsId.length] = _ansId;
        }

        reviewMultiAns[_index] = _ansId;

        document.getElementById('multiQuestionInput').value = JSON.stringify(reviewMultiAnsQuestionId);
        document.getElementById('multiAnsInput').value = JSON.stringify(reviewMultiAnsId);

        checkReviewToSend();
    }

    function deleteUploadedReviewFile(_number){
        var fileName =  document.getElementById('fileName_' + _number).value;

        $.ajax({
            type: 'post',
            url: deleteReviewPicUrl,
            data: {
                'name': fileName,
                'code':  $('#storeReviewCode').val()
            },
            success: function(response){
                if(response == 'ok') {
                    $('#reviewPic_' + _number).remove();
                    fileUploadNum--;
                    checkReviewToSend();
                }
                else{
                    alert('problem')
                }
            }
        })
    }

    let uploadedWriteReviewPicture = [];
    function openEditReviewPic(_number){

        $('#editReviewPictures').removeClass('hidden');

        $('#imgEditReviewPics').attr('src', uploadedWriteReviewPicture[_number]);
        imgCropNumber = _number;
        startReviewCropper(1, _number);
    }

    function startReviewCropper(ratio, _number) {

        if(first) {

            'use strict';
            Cropper = window.Cropper;
            URL = window.URL || window.webkitURL;

            // container = document.querySelector('.img-container');
            download = document.getElementById('download');
            actions = document.getElementById('actions');
            dataX = document.getElementById('dataX');
            dataY = document.getElementById('dataY');
            dataHeight = document.getElementById('dataHeight');
            dataWidth = document.getElementById('dataWidth');
            dataRotate = document.getElementById('dataRotate');
            dataScaleX = document.getElementById('dataScaleX');
            dataScaleY = document.getElementById('dataScaleY');
        }
        else {
            cropper.destroy();
            inputImage.value = null;
        }
        // image = container.getElementsByTagName('img').item(0);
        image = document.getElementById('imgEditReviewPics');

        options = {
            preview: '.img-preview',
            ready: function (e) {
                console.log(e.type);
            },
            cropstart: function (e) {
                console.log(e.type, e.detail.action);
            },
            cropmove: function (e) {
                console.log(e.type, e.detail.action);
            },
            cropend: function (e) {
                console.log(e.type, e.detail.action);
            }
        };

        cropper = new Cropper(image, options);

        if(first) {
            originalImageURL = image.src;
            uploadedImageType = 'image/jpeg';
            uploadedImageName = 'cropped.jpg';
        }

        if(first) {

            // Tooltip
            $('[data-toggle="tooltip"]').tooltip();

            // Buttons
            if (!document.createElement('canvas').getContext) {
                $('button[data-method="getCroppedCanvas"]').prop('disabled', true);
            }

            if (typeof document.createElement('cropper').style.transition === 'undefined') {
                $('button[data-method="rotate"]').prop('disabled', true);
                $('button[data-method="scale"]').prop('disabled', true);
            }

            // Download
            if (typeof download.download === 'undefined') {
                download.className += ' disabled';
            }

            // Methods
            actions.querySelector('.docs-buttons').onclick = function (event) {
                e = event || window.event;
                target = e.target || e.srcElement;

                if (!cropper) {
                    return;
                }

                while (target !== this) {
                    if (target.getAttribute('data-method')) {
                        break;
                    }

                    target = target.parentNode;
                }

                if (target === this || target.disabled || target.className.indexOf('disabled') > -1) {
                    return;
                }

                data = {
                    method: target.getAttribute('data-method'),
                    target: target.getAttribute('data-target'),
                    option: target.getAttribute('data-option') || undefined,
                    secondOption: target.getAttribute('data-second-option') || undefined
                };

                cropped = cropper.cropped;

                if (data.method) {
                    if (typeof data.target !== 'undefined') {
                        input = document.querySelector(data.target);

                        if (!target.hasAttribute('data-option') && data.target && input) {
                            try {
                                data.option = JSON.parse(input.value);
                            } catch (e) {
                                console.log(e.message);
                            }
                        }
                    }

                    switch (data.method) {
                        case 'rotate':
                            if (cropped && options.viewMode > 0) {
                                cropper.clear();
                            }

                            break;

                        case 'getCroppedCanvas':
                            try {
                                data.option = JSON.parse(data.option);
                            } catch (e) {
                                console.log(e.message);
                            }

                            if (uploadedImageType === 'image/jpeg') {
                                if (!data.option) {
                                    data.option = {};
                                }

                                data.option.fillColor = '#fff';
                            }

                            break;
                    }

                    result = cropper[data.method](data.option, data.secondOption);

                    switch (data.method) {
                        case 'rotate':
                            if (cropped && options.viewMode > 0) {
                                cropper.crop();
                            }

                            break;

                        case 'scaleX':
                        case 'scaleY':
                            target.setAttribute('data-option', -data.option);
                            break;

                        case 'getCroppedCanvas':
                            if (result) {

                                // $("#editPane").addClass('hidden');
                                // $("#photoEditor").removeClass('hidden');
                            }

                            break;
                    }

                    if (typeof result === 'object' && result !== cropper && input) {
                        try {
                            input.value = JSON.stringify(result);
                        } catch (e) {
                            console.log(e.message);
                        }
                    }
                }
            };

            document.body.onkeydown = function (event) {
                var e = event || window.event;

                if (!cropper || this.scrollTop > 300) {
                    return;
                }

                switch (e.keyCode) {
                    case 37:
                        e.preventDefault();
                        cropper.move(-1, 0);
                        break;

                    case 38:
                        e.preventDefault();
                        cropper.move(0, -1);
                        break;

                    case 39:
                        e.preventDefault();
                        cropper.move(1, 0);
                        break;

                    case 40:
                        e.preventDefault();
                        cropper.move(0, 1);
                        break;
                }
            };
            first = false;
        }
        // Import image
        inputImage = document.getElementById('showPic' + _number);

        if (URL) {
            inputImage.onchange = function () {
                var files = this.files;
                var file;

                if (cropper && files && files.length) {
                    file = files[0];

                    if (/^image\/\w+/.test(file.type)) {
                        uploadedImageType = file.type;
                        uploadedImageName = file.name;

                        if (uploadedImageURL) {
                            URL.revokeObjectURL(uploadedImageURL);
                        }

                        image.src = uploadedImageURL = URL.createObjectURL(file);
                        cropper.destroy();
                        cropper = new Cropper(image, options);
                        inputImage.value = null;
                    } else {
                        window.alert('Please choose an image file.');
                    }
                }
            };
        } else {
            inputImage.disabled = true;
            inputImage.parentNode.className += ' disabled';
        }
    }

    function cropReviewImg(){
        openLoading();

        var canvas1;
        var data = new FormData();
        var name = document.getElementById('fileName_' + imgCropNumber).value;

        data.append('code',  $('#storeReviewCode').val());
        data.append('name', name);

        canvas1 = cropper.getCroppedCanvas();

        $('#editReviewPictures').addClass('hidden');

        canvas1.toBlob(function (blob){
            data.append('pic', blob, name);

            $.ajax({
                type: 'post',
                url: doEditReviewPic,
                data: data,
                processData: false,
                contentType: false,
                success: function (response){
                    if(response == 'ok')
                        $('#showPic' + imgCropNumber).attr('src', canvas1.toDataURL());
                    else
                        $('#showPic' + imgCropNumber).attr('src', uploadedWriteReviewPicture[imgCropNumber]);
                    closeLoading();
                },
                error: function(err){
                    closeLoading();
                    $('#showPic' + imgCropNumber).attr('src', uploadedWriteReviewPicture[imgCropNumber]);
                }
            })
        });
    }

    function sendWriteReview(){
        let text = $('#postTextArea').val();
        if(checkReviewToSend()) {
            let textId = [];
            let textAns = [];

            textQuestions.forEach(item => {
                textAns.push($('#textQuestionAns_'+item.id).val());
                textId.push(item.id);
            });

            $('#sendReviewButton').hide();
            $('#sendReviewLoader').css('display', 'flex');

            $.ajax({
                type: 'post',
                url: '{{route("storeReview")}}',
                data: {
                    _token: '{{csrf_token()}}',
                    kindPlaceId: $('#storeReviewKindPlaceId').val(),
                    placeId: $('#storeReviewPlaceId').val(),
                    code: $('#storeReviewCode').val(),
                    assignedUser: $('#assignedMemberToReview').val(),
                    multiAns: $('#multiAnsInput').val(),
                    multiQuestion: $('#multiQuestionInput').val(),
                    rateAns: $('#rateAnsInput').val(),
                    rateQuestion: $('#rateQuestionInput').val(),
                    text: $('#postTextArea').val(),
                    textId: textId,
                    textAns: textAns,
                },
                success: function(response){
                    try{
                        response = JSON.parse(response);
                        if(response.status == 'ok'){
                            $('#storeReviewCode').val(response.code);
                            showSuccessNotifi('{{__('دیدگاه شما با موفقیت ثبت شد.')}}', 'left', 'var(--koochita-blue)');
                            reviewPage = 1;
                            assignedUser = [];
                            $('#participantDivMainDiv').html('');
                            loadReviews();
                            clearStoreReview();
                        }
                        else{
                            console.log(response);
                            showSuccessNotifi('{{__('در ثبت دیدگاه مشکلی پیش آمده لطفا دوباره تلاش نمایید.')}}', 'left', 'red');
                        }
                    }
                    catch (e) {
                        console.log(e);
                        showSuccessNotifi('{{__('در ثبت دیدگاه مشکلی پیش آمده لطفا دوباره تلاش نمایید.')}}', 'left', 'red');
                    }

                    $('#sendReviewButton').show();
                    $('#sendReviewLoader').hide();
                },
                error: function(err){
                    console.log(err);
                    showSuccessNotifi('{{__('در ثبت دیدگاه مشکلی پیش آمده لطفا دوباره تلاش نمایید.')}}', 'left', 'red');

                    $('#sendReviewButton').show();
                    $('#sendReviewLoader').hide();
                }
            })
        }
    }

    function checkReviewToSend(_kind = ''){

        let error = false;
        let text = $('#postTextArea').val();

        if(text.trim().length > 0)
            error = true;

        if(fileUploadNum > 0)
            error = true;

        if(reviewRateAnsId.length > 0)
            error = true;

        if(reviewMultiAnsId.length > 0)
            error = true;

        if(error) {
            if(_kind == 'send')
                sendWriteReview();
            return true;
        }
        else
            return false;
    }

    function clearStoreReview(){
        $('#reviewShowPics').html('');
        $('#assignedMemberToReview').val('');
        $('#multiAnsInput').val('');
        $('#multiQuestionInput').val('');
        $('#rateAnsInput').val('');
        $('#rateQuestionInput').val('');
        $('#postTextArea').val('');

        fileUploadNum = 0;
        reviewRateAnsId = [];
        reviewMultiAnsId = [];
        assignedUser = [];
        reviewRateAnsQuestionId = [];
        reviewMultiAnsQuestionId = [];

        for(i = 0; i < rateQuestion.length; i++){
            rateQuestionAns[i] = 0;
            momentChangeRate(i, 0, 'out');
        }

        $($('#postTextArea').next().children()[0]).html('');

        textQuestions.forEach(item => $('#textQuestionAns_'+item.id).val('') );
        closeNewPostModal();
    }

    function closeNewPostModal() {
        $('#darkModal').hide();
        $(".postModalMainDiv").addClass('hidden');

        $('.showNewTextReviewArea').val($('#postTextArea').val())
    }

</script>