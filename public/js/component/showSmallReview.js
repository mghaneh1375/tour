var nowOpenReviewOption = null;
var allReviewsCreated = [];
var showReviewAnsInOneSee = 4; // this number mean show ans in first time and not click on "showAllReviewCommentsFullReview"
var devaredReview = 0;
var globalConfirmText = '<span class="label label-success inConfirmLabel">در انتظار تایید</span>';
var showFullReview = null;
var showFullReviewKind = null;

function getReviewPlaceHolder(){
    return smallReviewPlaceHolder;
}

function createSmallReviewHtml(item){
    allReviewsCreated.push(item);
    var text = reviewSmallSample;
    var fk = Object.keys(item);

    for (var x of fk)
        text = text.replace(new RegExp(`##${x}##`, "g"), item[x]);

    text = text.replace(new RegExp('##isVideoClass##', "g"), item.mainPicIsVideo == 1 ? "playIcon" : "");

    var t;
    var re;
    if(item.summery != null){
        text = text.replace(new RegExp('##haveSummery##', "g"), 'block');
        text = text.replace(new RegExp('##notSummery##', "g"), 'none');
    }
    else{
        text = text.replace(new RegExp('##haveSummery##', "g"), 'none');
        text = text.replace(new RegExp('##notSummery##', "g"), 'block');
    }

    text = text.replace( new RegExp('##havePic##', "g"), item.hasPic ? 'block' : 'none');
    text = text.replace(new RegExp('##hasMorePic##', "g"),item.morePic ? 'block' : 'none');
    text = text.replace(new RegExp('##isConfrim##', "g"), item.confirm == 0 ? 'block' : 'none');
    text = text.replace(new RegExp('##showWhere##', "g"), item.where == '' ? 'none' : 'block');

    var likeClass = '';
    var disLikeClass = '';
    if(item.userLike){
        if(item.userLike.like == 1)
            likeClass = 'coloredFullIcon';
        else if(item.userLike.like == -1)
            disLikeClass = 'coloredFullIcon';
    }

    text = text.replace(new RegExp('##likeClass##', "g"), likeClass);
    text = text.replace(new RegExp("##disLikeClass##", "g"), disLikeClass);

    var assignedUser = '';
    if(item["assigned"].length != 0) {
        assignedUser += '<div>با\n';
        for(j = 0; j < item["assigned"].length; j++) {
            if(item["assigned"][j]["name"])
                assignedUser += `<a href="${yourProfileUrlSmallShowReview}/${item["assigned"][j]["name"]}" target="_blank" style="color: var(--koochita-blue)">${item["assigned"][j]["name"]}</a>،\n`;
        }
        assignedUser += '</div>\n';
    }
    text = text.replace( new RegExp("##userAssigned##", "g"), assignedUser);

    return text;
}

function setSmallReviewPlaceHolder(_id){
    $('#' + _id).append(smallReviewPlaceHolder);
}

function showSmallReviewPics(_id){
    var selectReview = 0;
    var reviewPicForAlbum = [];
    for(i = 0; i < allReviewsCreated.length; i++){
        if(allReviewsCreated[i]['id'] == _id){
            selectReview = allReviewsCreated[i];
            break;
        }
    }

    if(selectReview != 0){
        revPic = selectReview['pics'];
        for(var i = 0; i < revPic.length; i++){
            reviewPicForAlbum[i] = {
                'id' : 'review_' + revPic[i]['id'],
                'sidePic' : revPic[i]['picUrl'],
                'mainPic' : revPic[i]['picUrl'],
                'video' : revPic[i]['videoUrl'],
                'userPic' : selectReview['userPic'],
                'userName' : selectReview['userName'],
                'uploadTime' : selectReview['timeAgo'],
                'where' : selectReview['where'],
                'whereUrl' : selectReview['placeUrl'],
                'showInfo' : false,
            }
        }
        createPhotoModal('عکس های پست', reviewPicForAlbum);// in general.photoAlbumModal.blade.php
    }
}

function showSmallReviewMoreText(element){
    $(element).parent().toggle();
    $(element).parent().next().toggle();
}

function showSmallReviewLessText(element){
    $(element).parent().toggle();
    $(element).parent().prev().toggle();
}

function closeFullReview(){
    closeMyModal('fullReviewModal');
}

function getSingleFullDataReview(_id, _callBack){
    openLoading();
    $.ajax({
        type: 'GET',
        url: `${getSingleReviewUrl}?id=${_id}`,
        complete: () => closeLoading(),
        success: function(response){
            if(response.status == 'ok' && typeof _callBack === 'function')
                _callBack(response.result);
        }
    })
}

function getSingleFullReview(_id){
    getSingleFullDataReview(_id, _review => showFullReviews({ review: _review, kind: 'modal' }));
}

function updateFullReview(_id){
    getSingleFullDataReview(_id, _review => setFullReviewContent(_review));
}

function showFullReviews(_input){
    var _reviews = _input.review;
    var _kind = _input.kind;
    // _kind = 'modal' open in modal
    // _kind = 'append' append to _sectionId

    _reviews['showKind'] = _kind;
    _reviews['showSectionId'] = _input.sectionId;

    var text = '';
    text += '<div id="showReview_' + _reviews["id"] + '" class="mainFullReviewDiv"></div>';

    if(_kind == 'modal') {
        openMyModal('fullReviewModal');
        $('#fullReview').html(text);
        $('#fullReview').append('<div class="closeFullReview iconClose" onclick="closeFullReview()"></div>');
    }
    else if(_kind == 'append') {
        $('#' + _input.sectionId).append(text);
        allReviewsCreated.push(_reviews);
    }

    setFullReviewContent(_reviews);
}

function setFullReviewContent(_reviews){
    var hasConfirmed = '';
    var kindPlaceId = _reviews.kindPlaceId;
    if(_reviews.confirm == 0)
        hasConfirmed = globalConfirmText;

    var text = `<div class="moreOptionFullReview" onclick="showFullReviewOptions(this, ${_reviews.id})">
                <span class="threeDotIconVertical"></span>
            </div>
            <div class="closeWithOneClick moreOptionFullReviewDetails hidden">
                <span onclick="showReportPrompt(${_reviews.id}, ${kindPlaceId})" class="">گزارش پست</span>
                <a href="${_reviews.userPageUrl}" target="_blank" >مشاهده صفحه ${_reviews["userName"]}</a>
                <a href="${policiRouteUrl}" target="_blank">صفحه قوانین و مقررات</a>`;

    if(isUserLoginCheckInSmall && _reviews.yourReview)
        text += `<span onclick="devareReviewByUserInReviews(${_reviews.id})" style="color: red">حذف پست</span>\n`;

    text += `</div>
             <div class="commentWriterDetailsShow">
                <a href="${yourProfileUrlSmallShowReview}/${_reviews.userName}" class="circleBase commentWriterPicShow">
                    <img src="${_reviews.userPic}" class="resizeImgClass" onload="fitThisImg(this)">
                </a>
                <div class="commentWriterExperienceDetails">
                    <a href="${yourProfileUrlSmallShowReview}/${_reviews.userName}" class="userProfileName userProfileNameFullReview" target="_blank" style="font-weight:bold">${_reviews.userName}</a>
                    <div class="fullReviewPlaceAndTime">
                        <div class="display-inline-block">در
                            <a href="${_reviews.placeUrl}" class="commentWriterExperiencePlace">${_reviews.where}</a>
                            ${hasConfirmed}
                        </div>`;

    if(_reviews.assigned.length != 0) {
        text += '<div>با\n';
        for(j = 0; j < _reviews.assigned.length; j++) {
            if(_reviews["assigned"][j]["name"])
                text += `<a href="${yourProfileUrlSmallShowReview}/${_reviews["assigned"][j]["name"]}" target="_blank" style="color: var(--koochita-blue)">${_reviews["assigned"][j]["name"]}</a>،`;
        }
        text += '</div>\n';
    }

    text += `<div>${_reviews.timeAgo}</div>
            </div>
            </div>
            </div>
            <div class="commentContentsShow">
               <div class="fullReviewText">${_reviews.text}</div>
            </div>
            <div class="fullReviewCommentPhotosShow">`;

    var reviewPicsCount = _reviews["pics"].length;
    var picDivClassName = '';
    var firstCol = '';
    var secCol = '';

    if(reviewPicsCount > 5)
        picDivClassName = 'quintupvarPhotoDiv';
    else if(reviewPicsCount == 5)
        picDivClassName = 'quintupvarPhotoDiv';
    else if(reviewPicsCount == 4)
        picDivClassName = 'quadruplePhotoDiv';
    else if(reviewPicsCount == 3)
        picDivClassName = 'tripvarPhotoDiv';
    else if(reviewPicsCount == 2)
        picDivClassName = 'doublePhotoDiv';
    else if(reviewPicsCount == 1)
        picDivClassName = 'singlePhotoDiv';

    for(var k = 0; k < reviewPicsCount && k < 5; k++) {
        var ttt =  `<div class="topMainReviewPic" onclick="showSmallReviewPics(${_reviews["id"]})">
                        <img src="${_reviews["pics"][k]["picUrl"]}" class="mainReviewPic resizeImgClass" onload="fitThisImg(this)">`;
        if(reviewPicsCount > 5 && k == 4) {
            ttt += `<div class="morePhotoLinkPosts">
                        به علاوه
                        <span>${reviewPicsCount - 4}</span>
                        عکس و ویدیو دیگر
                    </div>`;
        }
        ttt += '</div>\n';
        if(k%2 == 0) firstCol += ttt;
        else secCol += ttt;
    }

    if(reviewPicsCount == 1){
        text += `<div class="commentPhotosMainDiv ${picDivClassName}">
                   <div class="fullReveiwPhotosCol firstCol col-xs-12">${firstCol}</div>
                </div>`;
    }
    else if (reviewPicsCount > 1) {
        text += `<div class="commentPhotosMainDiv ${picDivClassName}">
                   <div class="fullReveiwPhotosCol secondCol col-xs-6">${secCol}</div>
                   <div class="fullReveiwPhotosCol firstCol col-xs-6">${firstCol}</div>
                </div>`;
    }

    text += `<div class="quantityOfLikes">
            </div>
            </div>`;

    if(_reviews["questionAns"].length != 0) {
        text += `<div class="commentRatingsDetailsBtn" onclick="showRatingDetailsInFullReview(this)">
                       <div class="commentRatingsDetailsBtnIcon">
                            مشاهده جزئیات امتیازدهی
                           <i class="glyphicon glyphicon-triangle-bottom"></i>
                       </div>
                    </div>
                    </div>`;

        text += '<div class="commentRatingsDetailsBox hidden">\n';

        var textAnsHtml = '';
        var multiAnsHtml = '';
        var rateAnsHtml = '';
        for(j = 0; j < _reviews["questionAns"].length; j++){
            var questionAns = _reviews["questionAns"][j];

            if(questionAns['ansType'] == 'text'){
                textAnsHtml += `<div class="display-inline-block full-width">
                                    <b class="col-xs-6 font-size-15 line-height-203 float-right" style="float: right">${questionAns["description"]}</b>
                                    <b class="col-xs-6 font-size-15 line-height-203 float-right pd-lt-0">${questionAns["ans"]}</b>
                                </div>`;
            }
            else if(questionAns['ansType'] == 'multi'){
                multiAnsHtml += `<div class="display-inline-block full-width">
                                    <b class="col-xs-6 font-size-15 line-height-203 float-right" style="float: right">${questionAns.description}</b>
                                    <b class="col-xs-6 font-size-15 line-height-203 float-right pd-lt-0">${questionAns.ans}</b>
                                </div>`;
            }
            else if(questionAns['ansType'] == 'rate'){
                var ansTexttt = '';
                if(questionAns['ans'] == 5)
                    ansTexttt = 'عالی بود';
                else if(questionAns['ans'] == 4)
                    ansTexttt = 'خوب بود';
                else if(questionAns['ans'] == 3)
                    ansTexttt = 'معمولی بود';
                else if(questionAns['ans'] == 2)
                    ansTexttt = 'بد نبود';
                else if(questionAns['ans'] == 1)
                    ansTexttt = 'اصلا راضی نبودم';

                rateAnsHtml += `<div class="display-inline-block full-width">
                                    <b class="col-xs-6 font-size-14 line-height-203" style="float: right">${questionAns["description"]}</b>
                                    <div class="prw_rup prw_common_bubble_rating overallBubbleRating float-right col-xs-4 text-align-left">
                                <div>`;

                for(var starN = 0; starN < 5; starN++){
                    if(starN <= questionAns['ans'])
                        rateAnsHtml += '<span class="starRatingGreen autoCursor"></span>\n';
                    else
                        rateAnsHtml += '<span class="starRating autoCursor"></span>\n';
                }

                rateAnsHtml +=  `</div></div>
                                <b class="col-xs-2 font-size-13 line-height-203 float-right pd-lt-0">${ansTexttt}</b>
                                </div>`;
            }
        }

        text += textAnsHtml;
        text += multiAnsHtml;
        text += rateAnsHtml;
        text += '</div>\n';
    }
    text += '</div>';

    var likeClass = '';
    var disLikeClass = '';

    if(_reviews['userLike'] != null && _reviews['userLike']['like'] == 1)
        likeClass = 'coloredFullIcon';
    else if(_reviews['userLike'] != null && _reviews['userLike']['like'] == -1)
        disLikeClass = 'coloredFullIcon';

    _reviews["bookmark"] = _reviews["bookmark"] ? 'BookMarkIcon' :'BookMarkIconEmpty';
    text += `<div class="commentFeedbackChoices">
                <div class="postsActionsChoices col-xs-6" style="display: flex; justify-content: flex-start;">
                    <div class="reviewLikeIcon_${_reviews.id} cursor-pointer LikeIconEmpty likedislikeAnsReviews ${likeClass}" onclick="likeReviewInFullReview(${_reviews.id}, 1, this);" style="font-size: 15px; direction: rtl; margin-left: 15px;">
                        <span class="reviewLikeNumber_${_reviews.id}">${_reviews.like}</span>
                    </div>
                    <div class="reviewDisLikeIcon_${_reviews.id} cursor-pointer DisLikeIconEmpty likedislikeAnsReviews ${disLikeClass}" onclick="likeReviewInFullReview(${_reviews.id}, -1, this);" style="font-size: 15px; direction: rtl; margin-left: 15px;">
                        <span class="reviewDisLikeNumber_${_reviews.id}">${_reviews.disLike}</span>
                    </div>
                    <div class="postCommentChoice" onclick="showCommentToReviewFullReview(this)" style="margin-left: 15px;">
                        <span>${_reviews.answersCount}</span>
                        <span class="showCommentsIconFeedback firstIcon"></span>
                        <span class="showCommentsClickedIconFeedback secondIcon" style="display: none"></span>
                    </div>
                </div>
                <div class="postsActionsChoices col-xs-6" style="display: flex; justify-content: flex-end;">
                    <div class="postShareChoice display-inline-block" onclick="openReviewShareBox(this)" style="direction: ltr;font-size: 25px; line-height: 0;">
                        <span class="commentsShareIconFeedback ShareIcon firstIcon"></span>
                    </div>
                    <div style="margin-right: 20px; font-size: 20px;">
                        <span class="${_reviews.bookmark}" onclick="addReviewToBookMark(this, ${_reviews.id})" style="cursor: pointer;"></span>
                    </div>
                </div>
            </div>
        <div id="sectionOfAnsToReview_${_reviews.id}" class="commentsMainBox hidden">`;

    var checkAllReviews = true;

    for(j = 0; j < _reviews["answers"].length; j++){
        var answers = _reviews["answers"][j];

        answers.likeFunction = 'likeReviewInFullReview';
        answers.sendAnswerFunction = 'sendAnsOfReviewsFullReview';
        text += createMainAnswer(answers) /**in answerPack.blade.php**/;

        if(j == _reviews["answers"].length && !checkAllReviews)
            text += '</div>';
    }

    text += '</div>';

    if(showReviewAnsInOneSee < _reviews["answers"].length) {
        var remainnn = _reviews["answers"].length - showReviewAnsInOneSee;
        text += `<div class="dark-blue mg-bt-10">
                   <span class="cursor-pointer" onclick="showAllReviewCommentsFullReview(${_reviews["id"]}, ${remainnn}, this)" style="font-size: 13px;" >مشاهده ${remainnn} نظر باقیمانده </span>
                </div>`;
    }
    text += '</div>';

    // new ans
    text += `<div class="newCommentPlaceMainDiv">
                   <div class="circleBase type2 newCommentWriterProfilePic hideOnPhone">
                       <img src="${window.userPic}">
                   </div>
                   <div class="inputBox setButtonToBot">
                       <textarea id="ansForReviews_${_reviews["id"]}" class="inputBoxInput inputBoxInputComment inputTextWithEmoji" rows="1" placeholder="شما چه نظری دارید؟" onclick="checkLogin()" onchange="checkFullSubmitFullReview(this)" style="padding-bottom: 10px"></textarea>
                       <button class="btn submitAnsInReview" onclick="sendAnsOfReviewsFullReview(${_reviews["id"]}, $('#ansForReviews_${_reviews["id"]}').val())" > ارسال</button>
                       <div class="sendQuestionBtn sendingQuestionLoading" style="display: none;"  disabled>
                           <img src="${gearIconUrl}" style="width: 30px; height: 30px;">
                           در حال ثبت نظر
                       </div>
                   </div>
                <div>`;

    text += '</div></div></div></div>';

    $('#showReview_' + _reviews["id"]).html(text);

    setTimeout(function(){
        resizeFitImg('resizeImgClass');
        autosize($('[id^="ansForReviews_"]'));

        $('#fullReviewModal').find('.postCommentChoice').click();
    }, 100);
}

function openReplayToReviewCommentFullReview(_id){
    if($('#ansOfReview_' + _id).find('.replyToCommentMainDiv').hasClass("display-inline-blockImp"))
        $('.replyToCommentMainDiv').removeClass("display-inline-blockImp");
    else{
        $('.replyToCommentMainDiv').removeClass("display-inline-blockImp");
        $('#ansOfReview_' + _id).find('.replyToCommentMainDiv').toggleClass("display-inline-blockImp");
    }
}

function likeReviewInFullReview(_logId, _like, _element){

    if(!checkLogin())
        return;

    $.ajax({
        type: 'POST',
        url: likeLogURL,
        data:{
            logId : _logId,
            like : _like
        },
        success: function(response){
            response = JSON.parse(response);
            if(response[0] == 'ok' || response[0] == 'delete'){

                like = response[1];
                dislike = response[2];

                if(typeof _element === 'object' && _element.like && _element.disLike){
                    _element.like.text(like);
                    _element.disLike.text(dislike);
                }
                else{
                    $('.reviewLikeNumber_'+_logId).text(like);
                    $('.reviewDisLikeNumber_'+_logId).text(dislike);

                    $('.reviewLikeIcon_'+_logId).removeClass('coloredFullIcon');
                    $('.reviewDisLikeIcon_'+_logId).removeClass('coloredFullIcon');
                    if(response[0] == 'ok') {
                        if (_like == 1)
                            $('.reviewLikeIcon_' + _logId).addClass('coloredFullIcon');
                        else
                            $('.reviewDisLikeIcon_' + _logId).addClass('coloredFullIcon');
                    }
                }

                for(var i = 0; i < allReviewsCreated.length; i++){
                    if(allReviewsCreated[i].id == _logId){
                        if(allReviewsCreated[i]['userLike'] == null)
                            allReviewsCreated[i]['userLike'] = [];
                        allReviewsCreated[i]['userLike']['like'] = response[0] == 'ok' ? _like : 0;
                        allReviewsCreated[i]['like'] = like;
                        allReviewsCreated[i]['disLike'] = dislike;

                        showFullReview = allReviewsCreated[i];
                        break;
                    }
                }
            }
        }
    })
}

function sendAnsOfReviewsFullReview(_logId, _value){
    if(!checkLogin())
        return;

    if(_value.trim().length > 0){
        openLoading();
        $.ajax({
            type: 'POST',
            url: ansReviewURL,
            data: {
                logId : _logId,
                text  : _value,
            },
            complete: closeLoading,
            success: response => {
                if(response.status == 'ok') {
                    showSuccessNotifi('پاسخ شما با موفقیت ثبت شد.', 'left', 'var(--koochita-blue)');
                    updateFullReview(response.reviewId);
                }
                else
                    showSuccessNotifi('در ثبت پاسخ مشکلی پیش آمده لطفا دوباره تلاش نمایید.', 'left', 'red');
            },
            error: e => {
                closeLoading();
                showSuccessNotifi('در ثبت پاسخ مشکلی پیش آمده لطفا دوباره تلاش نمایید.', 'left', 'red');
            }
        })
    }
}

function showAllReviewCommentsFullReview(_id, _remain, _element){
    var ter;
    $('#allReviews_' + _id).toggle();
    if($('#allReviews_' + _id).css('display') == 'none')
        ter = 'مشاهده ' + _remain + ' نظر باقی مانده ';
    else
        ter = 'بستن ' + _remain + ' نظر ';

    $(_element).text(ter);
}

function checkFullSubmitFullReview(_element){
    var text = $(_element).val();
    if(text.trim().length > 0)
        $(_element).next().removeAttr('disabled');
    else
        $(_element).next().attr('disabled', 'disabled');
}

function devareReviewByUserInReviews(_reviewId){
    if(_reviewId != 0)
        devaredReview = _reviewId;
    else
        devaredReview
    text = 'آیا از حذف نقد خود اطمینان دارید؟ در صورت حذف عکس ها و فیلم ها افزوده شده پاک می شوند و قابل بازیابی نمی باشد.';
    openWarning(text, doDeleteReviewByUserInReviews); // in general.alert.blade.php
}

function doDeleteReviewByUserInReviews(){
    openLoading();
    $.ajax({
        type: 'POST',
        url: deleteReviewURL,
        data: {
            _token: csrfTokenGlobal,
            id: devaredReview
        },
        success: function(response){
            closeLoading();
            if(response == 'ok'){
                closeFullReview();
                $('#showReview_' + devaredReview).remove();
                $('#smallReviewHtml_' + devaredReview).remove();
                showSuccessNotifi('نظر شما با موفقیت حذف شد.', 'left', 'green');
            }
            else
                showSuccessNotifi('در حذف نظر شما مشکلی پیش آمده لطفا دوباره تلاش کنید.', 'left', 'red');
        },
        error: function(err){
            closeLoading();
            showSuccessNotifi('در حذف نظر شما مشکلی پیش آمده لطفا دوباره تلاش کنید.', 'left', 'red');
        }
    })
}

function showRatingDetailsInFullReview(element) {
    if ($(element).next().hasClass('commentRatingsDetailsBox')) {
        $(element).next().toggleClass('hidden');
        $(element).children().children().toggleClass('glyphicon-triangle-bottom');
        $(element).children().children().toggleClass('glyphicon-triangle-top');
        $(element).toggleClass('mg-bt-10');
    }
}

function showCommentToReviewFullReview(element) {
    $(element).parent().parent().next().toggleClass('hidden');
    $(element).toggleClass('color-blue');
    $(element).children("span.firstIcon").toggle();
    $(element).children("span.secondIcon").toggle();
}

function showFullReviewOptions(_element, _id) {
    if($(_element).next().hasClass('hidden')) {
        setTimeout(() => {
            openMyModal('reviewOptionMenuBar');
            $(_element).next().removeClass('hidden');
            $(_element).addClass("bg-color-darkgrey");

            for(var i = 0; i < allReviewsCreated.length; i++){
                if(allReviewsCreated[i].id == _id) {
                    nowOpenReviewOption = allReviewsCreated[i];
                    $('.profileNameInReviewOptionModal').text('مشاهده صفحه ' + nowOpenReviewOption.userName);
                    $('.profileNameInReviewOptionModal').attr('href', yourProfileUrlSmallShowReview+'/'+nowOpenReviewOption.userName);

                    $('.reportReviwInOptionModal').attr('onClick', `showReportPrompt(${nowOpenReviewOption.id}, ${nowOpenReviewOption.kindPlaceId})`);

                if(isUserLoginCheckInSmall) {
                    if (nowOpenReviewOption.yourReview) {
                        $('#devareReviewOptionInModal').show();
                        $('#devareReviewOptionInModal').attr('onClick', `devareReviewByUserInReviews(${nowOpenReviewOption.id})`);
                    } else
                        $('#devareReviewOptionInModal').hide();
                }
                break;
                }
            }
        }, 100);
    }
}

function openReviewShareBox(_element){
    $(_element).find('.firstIcon').toggleClass('commentsShareIconFeedback');
}

function addReviewToBookMark(_elem, _id){
    $.ajax({
        type: 'POST',
        url: reviewBookMarkURL,
        data:{
            _token: csrfTokenGlobal,
            id: _id
        },
        success: response => {
            if(response == 'store'){
                $(_elem).removeClass('BookMarkIconEmpty');
                $(_elem).addClass('BookMarkIcon');
                showSuccessNotifi('پست به نشان کرده ها اضافه شد.', 'left', 'var(--koochita-blue)');
            }
            else if(response == 'devare'){
                $(_elem).addClass('BookMarkIconEmpty');
                $(_elem).removeClass('BookMarkIcon');
                showSuccessNotifi('پست از نشان کرده ها حذف شد.', 'left', 'red');
            }
            else if(response == 'notAuth'){
                showSuccessNotifi('ابتدا وارد شوید', 'left', 'red');
            }
            else{
                showSuccessNotifi('مشکلی پیش امده دوباره تلاش کنید', 'left', 'red');
            }

        },
        error: err => {
            showSuccessNotifi('مشکلی پیش امده دوباره تلاش کنید', 'left', 'red');
        }
    });

}

$(window).on('click', () => closeMyModal('reviewOptionMenuBar'));
