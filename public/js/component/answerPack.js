
var answerPackSample = `
        <div id="ansDiv_##random##" style="margin-bottom: 15px; direction: rtl">
            <div class="eachCommentMainBox" style="margin-bottom: 0px">
                <div class="circleBase commentsWriterProfilePic">
                    <img alt="کوچیتا، سامانه جامع گردشگری ایران" src="##writerPic##" style="width: 100%; height: 100%; border-radius: 50%;">
                </div>
                <div class="commentsContentMainBox">
                    <b class="userProfileName userProfileNameFullReview">
                        <a href="${profilePageUrlAnswerPack}/##userName##" target="_blank" style="font-weight:bold">##userName##</a>
                        <span class="label inConfirmLabel" style="display: ##confirmDisplay##">در انتظار تایید</span>
                        <span class="ansCommentTimeAgo">##timeAgo##</span>
                    </b>
                    <div class="fullReviewAnsText">##text##</div>
                </div>
            </div>
            <div class="fullReviewLikeAnsSeeAllSection">
                <div id="likeSection_##random##" style="display: inline-flex">
                    <input type="hidden" class="youLikeInputAnsPack" value="##youLike##">
                    <span class="likeNumberAnswer_##random## LikeIconEmpty likedislikeAnsReviews ##youLikeClass##"
                          onclick="##likeFunction##(##id##, 1, {'like': $('.likeNumberAnswer_##random##'), disLike: $('.disLikeNumberAnswer_##random##')}); turnOnLike(##random##, 1)">
                        ##like##
                    </span>
                    <span class="disLikeNumberAnswer_##random## DisLikeIconEmpty likedislikeAnsReviews ##youDisLikeClass##"
                          onclick="##likeFunction##(##id##, -1, {'like': $('.likeNumberAnswer_##random##'), disLike: $('.disLikeNumberAnswer_##random##')}); turnOnLike(##random##, -1)">
                        ##disLike##
                    </span>
                    <span class="replayBtn replayReview" onclick="showReplyToAnswerHandle(##random##)">پاسخ دهید</span>
    </div>
    <div class="fullReviewSeeAnses" onclick="showAnswersOfAns(##random##, this)" style="display: ##hasAns##">
        <span class="numberOfCommentsIcon commentsStatisticSpan dark-blue" style="margin-left: 20px">##answersCount##</span>
        <span class="seeAllText">مشاهده پاسخ‌ها</span>
    </div>
    </div>
            <div id="textAreaAnsDiv_##random##" class="replyToCommentMainDiv ansTextAreaReview hidden" style="margin-top: 5px">
        <div class="circleBase newCommentWriterProfilePic hideOnPhone">
            <img alt="کوچیتا، سامانه جامع گردشگری ایران" src="##userPic##" style="width: 100%; border-radius: 50%;">
        </div>
        <div class="inputBox setButtonToBot">
            <b class="replyCommentTitle">در پاسخ به ##userName##</b>
            <textarea id="textareaForAns_##random##"
                      class="inputBoxInput inputBoxInputComment"
                      rows="1" placeholder="شما چه نظری دارید؟"
                      onclick="checkLogin()"
                      onkeydown="checkNotEmptyTextArea(this)"
                      onchange="checkNotEmptyTextArea(this)"></textarea>
            <button class="btn submitAnsInReview"
                    onclick="##sendAnswerFunction##(##id##, $('#textareaForAns_##random##').val()); $(this).hide(); $(this).next().show()"
                    style="height: fit-content"
                    disabled>ارسال</button>
            <div class="sendQuestionBtn sendingQuestionLoading" style="display: none;" disabled>
                <img alt="loading" src="${window.gearIcon}" style="width: 30px; height: 30px;">
                در حال ثبت
            </div>
        </div>
        </div>
        </div>

<div class="borderInMobile hidden answerSectionAns_##random##" style="margin-top: 0px">##answersHtml##</div>
`;


var answerAnsPackSample = `<div id="ansOfAns_##random##" style="margin-bottom: 15px; direction: rtl;">
                                <div class="eachCommentMainBox"  style="margin-bottom: 0px">
                                    <div class="circleBase commentsWriterProfilePic">
                                        <img alt="userPic" src="##writerPic##" style="width: 100%; height: 100%; border-radius: 50%;">
                                    </div>
                                    <div class="commentsContentMainBox">
                                        <div class="userProfileName userProfileNameFullReview">
                                            <a href="${profilePageUrlAnswerPack}/##userName##"
                                               class="userProfileNameFullReview float-right"
                                               target="_blank"
                                               style="font-weight:bold">##userName##</a>
                                            <b class="commentReplyDesc display-inline-block">در پاسخ به ##repTo##</b>
                                            <span class="label inConfirmLabel" style="display: ##confirmDisplay##">در انتظار تایید</span>
                                        </div>
                                        <div class="fullReviewAnsText">##text##</div>
                                    </div>
                                </div>
                                <div class="fullReviewLikeAnsSeeAllSection">
                                    <div id="likeSection_##random##" style="display: inline-flex">
                                        <input type="hidden" class="youLikeInputAnsPack" value="##youLike##">
                                        <span class="likeNumberAnswer_##random## LikeIconEmpty likedislikeAnsReviews ##youLikeClass##" onclick="##likeFunction##(##id##, 1, {'like': $('.likeNumberAnswer_##random##'), disLike: $('.disLikeNumberAnswer_##random##')}); turnOnLike(##random##, 1)"> ##like## </span>
                                        <span class="disLikeNumberAnswer_##random## DisLikeIconEmpty likedislikeAnsReviews ##youDisLikeClass##" onclick="##likeFunction##(##id##, -1, {'like': $('.likeNumberAnswer_##random##'), disLike: $('.disLikeNumberAnswer_##random##')}); turnOnLike(##random##, -1)"> ##disLike## </span>
                                        <span class="replayBtn replayReview" onclick="showReplyToAnswerHandle(##random##)">پاسخ دهید</span>
                                    </div>
                                    <div class="fullReviewSeeAnses" onclick="showAnswersOfAns(##random##, this)" style="display: ##hasAns##">
                                        <span class="numberOfCommentsIcon commentsStatisticSpan dark-blue">##answersCount##</span>
                                        <span class="seeAllText">مشاهده پاسخ‌ها</span>
                                    </div>
                                </div>
                                <div id="textAreaAnsDiv_##random##" class="replyToCommentMainDiv hidden" style="margin-top: 0px;">
                                    <div class="circleBase newCommentWriterProfilePic hideOnPhone">
                                        <img alt="userPic" src="##userPic##" style="width: 100%; border-radius: 50%;">
                                    </div>
                                    <div class="inputBox setButtonToBot">
                                        <b class="replyCommentTitle">در پاسخ به ##userName##</b>
                                        <textarea id="textareaForAns_##random##" class="inputBoxInput inputBoxInputComment" rows="1" placeholder="شما چه نظری دارید؟" onclick="checkLogin()" onkeydown="checkNotEmptyTextArea(this)"></textarea>
                                        <button class="btn submitAnsInReview" onclick="##sendAnswerFunction##(##id##, $('#textareaForAns_##random##').val()); $(this).hide(); $(this).next().show()" style="height: fit-content" disabled>ارسال</button>
                                        <div class="sendQuestionBtn sendingQuestionLoading" style="display: none;" disabled>
                                            <img alt="loading" src="${window.gearIcon}" style="width: 30px; height: 30px;">
                                            در حال ثبت
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="hidden answerSectionAns_##random##" style="width: 100%">##answersHtml##</div>`;



var allCreatedAnswerPack = {};

function createMainAnswer(_ans){
    // _ans = {
    //     id,
    //     userName,
    //     confirm: 1 || 0,
    //     timeAgo,
    //     text,
    //     like,
    //     disLike,
    //     writerPic,
    //     youLike: 0 || 1 || -1,
    //     answersCount,
    //     answers: [
    //         {
    //
    //         }
    //     ],
    //     likeFunction: function(id, kind, elements),
    //     sendAnswerFunction: function(id, value),
    // };
    var randomNumber = Math.floor(Math.random() * 100000);
    var text = answerPackSample;

    _ans.userPic = window.userPic;
    _ans.random = randomNumber;
    _ans.hasAns = _ans.answersCount > 0 ? 'block' : 'none';
    _ans.confirmDisplay = _ans.confirm ? 'none' : 'inline';
    _ans.youDisLikeClass = '';
    _ans.youLikeClass = '';
    if(_ans.youLike == 1)
        _ans.youLikeClass = 'coloredFullIcon';
    else if(_ans.youLike == -1)
        _ans.youDisLikeClass = 'coloredFullIcon';

    _ans.answersHtml = '';
    if(_ans.answers.length > 0)
        _ans.answersHtml= createAnswerToAnswers(_ans.answers, _ans.likeFunction, _ans.sendAnswerFunction, _ans.userName);

    var fk = Object.keys(_ans);
    for (var x of fk)
        text = text.replace(new RegExp(`##${x}##`, "g"), _ans[x]);

    // allCreatedAnswerPack[randomNumber] = _ans;

    return text;
}

function createAnswerToAnswers(_anses, _likeFunction, _sendAnswerFunction, _repTo){
    var mainText = '';
    _anses.map(item => {

        var randomNumber = Math.floor(Math.random() * 100000);
        var text = answerAnsPackSample;
        item.userPic = window.userPic;
        item.random = randomNumber;

        item.repTo = _repTo;
        item.likeFunction = _likeFunction;
        item.sendAnswerFunction = _sendAnswerFunction;
        item.hasAns = item.answersCount > 0 ? 'block' : 'none';
        item.confirmDisplay = item.confirm ? 'none' : 'inline';
        item.youDisLikeClass = '';
        item.youLikeClass = '';
        if(item.youLike == 1)
            item.youLikeClass = 'coloredFullIcon';
        else if(item.youLike == -1)
            item.youDisLikeClass = 'coloredFullIcon';

        var fk = Object.keys(item);
        for (var x of fk)
            text = text.replace(new RegExp('##' + x + '##', "g"), item[x]);

        var answersHtml = '';
        if(item.answers.length > 0)
            answersHtml= createAnswerToAnswers(item.answers, _likeFunction, _sendAnswerFunction, item.userName);
        text = text.replace(new RegExp('##answersHtml##', "g"), answersHtml);

        mainText += text;
    });

    return mainText;
}

showReplyToAnswerHandle = _random => $('#textAreaAnsDiv_'+_random).toggleClass('hidden');

function showAnswersOfAns(_random, _element){
    $('.answerSectionAns_' + _random).toggleClass("hidden");
    textElement = $(_element).find('.seeAllText');
    textElement.text(textElement.text() == 'مشاهده پاسخ‌ها' ? 'بستن پاسخ‌ها' : 'مشاهده پاسخ‌ها');
}

function checkNotEmptyTextArea(_element){
    var text = $(_element).val();
    $(_element).next().removeAttr('disabled', text.trim().length == 0);
}

function turnOnLike(_random, _kind){
    var div = $(`#likeSection_${_random}`);
    var empty = false;
    div.find('.coloredFullIcon').removeClass('coloredFullIcon');

    if(_kind != div.find('.youLikeInputAnsPack').val()) {
        div.find('.youLikeInputAnsPack').val(_kind);
        if (_kind == 1)
            div.find('.LikeIconEmpty').addClass('coloredFullIcon');
        else if (_kind == -1)
            div.find('.DisLikeIconEmpty').addClass('coloredFullIcon');
    }
    else
        div.find('.youLikeInputAnsPack').val(0);
}
