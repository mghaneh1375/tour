
class AnswerComponent {

    constructor(initValue) {
        this.answer = initValue.answer;
        this.mainLikeFunction = initValue.cLikeFunction;
        this.mainSendFunction = initValue.cSendAnsFunction;
        this.random = Math.floor(Math.random() * 100000);

        this.updateAnswer(initValue);
    }
    
    updateAnswer = _ans => {
        this.userPic = window.userPic;
        this.confirmDisplay = this.answer.confirm ? 'none' : 'inline';
        this.youLikeClass = '';
        this.youDisLikeClass = '';
        if(this.answer.youLike == 1)
            this.youLikeClass = 'coloredFullIcon';
        else if(this.answer.youLike == -1)
            this.youDisLikeClass = 'coloredFullIcon';

        this.hasAns = this.answer.answersCount > 0 ? 'block' : 'none';
    }

    likeFunction = _kind =>{
        console.log(_kind, this.answer.id);
        this.mainLikeFunction(this.answer.id, _kind, '');

        // ##likeFunction##(##id##, -1, {'like': $('.likeNumberAnswer_'+${this.random}), disLike: $('.disLikeNumberAnswer_'+${this.random})}); turnOnLike(${this.random}, -1)
    };

    sendAnswerFunction = e => {
        console.log(e);
        // ##sendAnswerFunction##(##id##, $('#textareaForAns_${this.random}').val()); $(this).hide(); $(this).next().show()
    };

    returnHtml = () => {
        return `<div id="ansDiv_${this.random}" style="margin-bottom: 15px; direction: rtl">
                    <div class="eachCommentMainBox" style="margin-bottom: 0px">
                        <div class="circleBase commentsWriterProfilePic">
                            <img src="${this.answer.writerPic}" style="width: 100%; height: 100%; border-radius: 50%;">
                        </div>
                        <div class="commentsContentMainBox">
                            <b class="userProfileName userProfileNameFullReview">
                                <a href="#" target="_blank" style="font-weight:bold">${this.answer.userName}</a>
                                <span class="label inConfirmLabel" style="display: ${this.confirmDisplay}"> در انتظار تایید </span>
                                <span class="ansCommentTimeAgo">${this.answer.timeAgo}</span>
                            </b>
                            <div class="fullReviewAnsText">${this.answer.text}</div>
                        </div>
                    </div>
                    <div class="fullReviewLikeAnsSeeAllSection">
                        <div id="likeSection_${this.random}" style="display: inline-flex">
                            <span class="likeNumberAnswer_${this.random} LikeIconEmpty likedislikeAnsReviews ${this.youLikeClass}"
                                  onclick=${() => this.likeFunction(1)}>
                                ${this.answer.like}
                            </span>
                            <span class="disLikeNumberAnswer_${this.random} DisLikeIconEmpty likedislikeAnsReviews ${this.youDisLikeClass}"
                                  onclick=${() => this.likeFunction(-1)}>
                                ${this.answer.disLike}
                            </span>
                            <span class="replayBtn replayReview" onclick="showReplyToAnswerHandle(${this.random})">
                                پاسخ دهید
                            </span>
                        </div>
                        <div class="fullReviewSeeAnses" onclick="showAnswersOfAns(${this.random}, this)" style="display: ${this.hasAns}">
                            <span class="numberOfCommentsIcon commentsStatisticSpan dark-blue" style="margin-left: 20px">${this.answer.answersCount}</span>
                            <span class="seeAllText">مشاهده پاسخ‌ها</span>
                        </div>
                    </div>
                    <div id="textAreaAnsDiv_${this.random}" class="replyToCommentMainDiv ansTextAreaReview hidden" style="margin-top: 5px">
                        <div class="circleBase newCommentWriterProfilePic">
                            <img src="${this.userPic}" style="width: 100%; border-radius: 50%;">
                        </div>
                        <div class="inputBox setButtonToBot">
                            <b class="replyCommentTitle">در پاسخ به ${this.answer.userName}</b>
                            <textarea id="textareaForAns_${this.random}"
                                      class="inputBoxInput inputBoxInputComment"
                                      rows="1" placeholder="شما چه نظری دارید؟"
                                      onclick="checkLogin()"
                                      onkeydown="checkNotEmptyTextArea(this)"
                                      onchange="checkNotEmptyTextArea(this)"></textarea>
                            <button class="btn submitAnsInReview"
                                    onclick="${this.sendAnswerFunction()}"
                                    style="height: fit-content"
                                    disabled>
                                ارسال
                            </button>
                            <div class="sendQuestionBtn sendingQuestionLoading" style="display: none;" disabled>
                                <img src="${window.gearIcon}" style="width: 30px; height: 30px;">
                                در حال ثبت
                            </div>
                        </div>
                    </div>
                </div>`;
    }
}