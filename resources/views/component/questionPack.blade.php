<style>
    .questionOptionMenuBar{
        display: none !important;
        flex-direction: column;
    }
    .questionOptionMenuBar .modalBody > * {
        color: gray;
        border-bottom: solid 1px #cccccc;
        display: flex;
        justify-content: center;
        margin-bottom: 10px;
        padding-bottom: 10px;
    }
    .questionOptionMenuBar .modalBody > span:last-of-type{
        border-bottom: none;
    }

    @media (max-width: 767px) {
        .questionOptionMenuBar{
            display: unset;
        }
    }
</style>


<div id="questionOptionMenuBar" class="modalBlackBack fullCenter questionOptionMenuBar">
    <div class="modalBody"></div>
</div>

<script>
    var questionSample = `<div class="isConfirmed">
        <div class="moreOptionFullReview" onclick="showAnswersActionBoxQ(this)">
            <span class="threeDotIconVertical"></span>
        </div>
        <div class="closeWithOneClick moreOptionFullReviewDetails hidden">
            <span onclick="showReportPrompt(##id##, ##kindPlaceId##)">{{__("گزارش سوال")}}</span>
            <a target="_blank" href="{{url("profile/index")}}/##userName##">{{__("مشاهده صفحه")}} ##userName##</a>
            <a href="{{route("policies")}}" target="_blank">{{__("صفحه قوانین و مقررات")}}</a>
            @if(auth()->check())
    <span class="yourPost" onclick="deleteQuestionByUser(##id##)" style="color: red">{{__('حذف سوال')}}</span>
            @endif
    </div>
</div>

<div class="commentWriterDetailsShow">
    <div class="circleBase commentWriterPicShow">
        <img alt="userPic" src="##userPic##" style="height: 100%; width: 100%; border-radius: 50%;">
    </div>
    <div class="commentWriterExperienceDetails">
        <a href="{{url('profile/index')}}/##userName##" class="userProfileName userProfileNameFullReview" target="_blank" style="font-weight:bold">##userName##</a>
            <div class="fullReviewPlaceAndTime">
                <div class="display-inline-block">
                    در
                    <a href="##placeUrl##" class="commentWriterExperiencePlace">##placeName##، {{__('شهر')}} ##cityName##، {{__('استان')}} ##stateName##</a>
                    <span class="notConfirmed label label-success inConfirmLabel">{{__('در انتظار تایید')}}</span>
                </div>
                <div>##timeAgo##</div>
            </div>
        </div>

    </div>
    <div class="questionContentMainBox"">##text##</div>
    <div class="questionSubMenuBar">
        <div class="replyBtn replyAnswerBtn" onclick="openReplyQuestionSection(##id##)"> {{__('پاسخ دهید')}} </div>
        <div class="dark-blue float-right display-inline-black cursor-pointer" onclick="showAllQuestionAnswer(##id##, this)" style="direction: rtl">
            <span class="numberOfCommentsIcon commentsStatisticSpan dark-blue">##answersCount##</span>
            <span class="seeAllText">{{__('مشاهده پاسخ‌ها')}}</span>
        </div>
    </div>
    <div id="ansToQuestion##id##" class="hidden last newAnswerPlaceMainDiv" style="margin-top: 0px;">
        <div class="circleBase type2 newCommentWriterProfilePic">
            <img alt="userPic" src="##yourPic##" style="height: 100%; border-radius: 50%;">
        </div>
        <div class="inputBox" style="flex-direction: column">
            <div class="replyAnswerTitle">{{__("در پاسخ به سوال")}} ##userName##</div>
            <div class="questAnsText" style="width: 100%;">
                <textarea id="QanswerInputBox##id##" class="inputBoxInput inputBoxInputAnswer" placeholder="{{__("شما چه پاسخی دارید؟")}}"></textarea>
                <div class="sendQuestionBtn" onclick="sendAnswerOfQuestion(##id##, $('#QanswerInputBox##id##').val())">{{__(("ارسال"))}}</div>
                <div class="sendQuestionBtn sendingQuestionLoading" style="display: none;"  disabled>
                    <img alt="loading" src="{{URL::asset("images/icons/mGear.svg")}}" style="width: 30px; height: 30px;">
                    {{__("در حال ثبت سوال")}}
    </div>
</div>
</div>
</div>

<div id="ansOfQuestion##id##" class="hidden ansOfQuestion"></div>`;

    var questionPlaceHolderSample = `
            <div class="smallReviewMainDivShown float-right position-relative">
        <div class="commentWriterDetailsShow" style="display: flex;">
            <div class="placeHolderAnime" style="width: 55px; height: 55px; float: right; border-radius: 50%"></div>
            <div class="commentWriterExperienceDetails" style="display: flex; flex-direction: column; padding-right: 10px">
                <div class="userProfileName placeHolderAnime resultLineAnim" style="width: 100px"></div>
                <div class="userProfileName placeHolderAnime resultLineAnim" style="width: 100px"> </div>
                <div class="userProfileName placeHolderAnime resultLineAnim" style="width: 100px"></div>
            </div>
        </div>
        <div class="commentContentsShowPlaceHolder position-relative">
            <div class="userProfileName placeHolderAnime resultLineAnim reviewPlaceHolderTextLineSmallReview"></div>
            <div class="userProfileName placeHolderAnime resultLineAnim reviewPlaceHolderTextLineSmallReview"></div>
            <div class="userProfileName placeHolderAnime resultLineAnim reviewPlaceHolderTextLineSmallReview" style="width: 60%"></div>
        </div>
    </div>
    `;
</script>


<script>
    function getQuestionPlaceHolder(){
        return questionPlaceHolderSample;
    }

    function createQuestionPack(_question, _sectionId){
        if($('#questionSection_' + _question.id).length == 0) {
            var firstTime = '<div id="questionSection_' + _question.id + '" class="questionPack"></div>';
            $(`#${_sectionId}`).append(firstTime);
        }

        var obj = Object.keys(_question);
        var text = questionSample;

        text = text.replace(new RegExp(`##yourPic##`, "g"), window.userPic);
        for (var x of obj)
            text = text.replace(new RegExp(`##${x}##`, "g"), _question[x]);

        $(`#questionSection_${_question.id}`).html(text);

        if(_question.confirm == 1)
            $('#questionSection_' + _question['id']).find('.notConfirmed').remove();
        else if(!_question.yourReview)
            $('#questionSection_' + _question['id']).find('.isConfirmed').remove();

        var answersHtml = '';

        _question.answers.map(_ans => {
            _ans.likeFunction = 'likeQuestion';
            _ans.sendAnswerFunction = 'sendAnswerOfQuestion';
            answersHtml += createMainAnswer(_ans) /**in answerPack.blade.php**/;
        });
        $(`#ansOfQuestion${_question.id}`).html(answersHtml);
    }

    function sendAnswerOfQuestion(_id, _value){
        if(!checkLogin())
            return;

        if(_value.trim().length > 0){
            openLoading();

            $.ajax({
                type: 'post',
                url : '{{route("sendAns")}}',
                data:{
                    text : _value,
                    relatedTo : _id
                },
                success: function(response){
                    if(response == 'ok') {
                        getAnswerOfThisQuestion(_id);
                        showSuccessNotifi('{{__('پاسخ شما با موفقیت ثبت شد')}}', 'left', 'var(--koochita-blue)');
                        $(`#QanswerInputBox${_id}`).val('');
                    }
                    else {
                        closeLoading();
                        showSuccessNotifi('{{__('در ثبت پاسخ مشکلی پیش آمده لطفا دوباره تلاش کنید.')}}', 'left', 'red');
                    }
                },
                error: function(err){
                    closeLoading();
                    showSuccessNotifi('{{__('در ثبت پاسخ مشکلی پیش آمده لطفا دوباره تلاش کنید.')}}', 'left', 'red');
                }
            })
        }
    }

    function getAnswerOfThisQuestion(_id){
        $.ajax({
            type: 'post',
            url: '{{route("getSingleQuestion")}}',
            data: {
                _token: '{{csrf_token()}}',
                id: _id
            },
            success: function(response){
                closeLoading();
                if(response.status == 'ok')
                    createQuestionPack(response.result);
            },
            error: err => { closeLoading(); console.log(err);}
        })
    }

    function showAnswersActionBoxQ(_element){
        if($(_element).next().hasClass('hidden')) {
            setTimeout(() => {
                openMyModal('questionOptionMenuBar');
                $(_element).next().removeClass('hidden');
                $(_element).addClass("bg-color-darkgrey");
                $('#questionOptionMenuBar').find('.modalBody').html($(_element).next().html());
            }, 100);
        }
    }

    $(window).on('click', () => closeMyModal('questionOptionMenuBar'));

    function showAllQuestionAnswer(_id, _element){
        var textElement = $(_element).find('.seeAllText');
        $("#ansOfQuestion" + _id).toggleClass('hidden');
        textElement.text(textElement.text() == 'مشاهده پاسخ‌ها' ? 'بستن پاسخ‌ها' : 'مشاهده پاسخ‌ها');
    }

    function openReplyQuestionSection(_id){
        if(!checkLogin()) return;
        $('#ansToQuestion' + _id).toggleClass('hidden');
    }

    function likeQuestion(_logId, _like, _elements){

        if(!checkLogin())
            return;

        $.ajax({
            type: 'post',
            url: '{{route('likeLog')}}',
            data:{
                logId : _logId,
                like : _like
            },
            success: function(response){
                response = JSON.parse(response);
                if(response[0] == 'ok'){
                    _elements.like.text(response[1]);
                    _elements.disLike.text(response[2]);
                }
            }
        })
    }

    var deletedQuestion = 0;
    function deleteQuestionByUser(_id){
        deletedQuestion = _id;
        openWarning('آیا از حذف سوال خود اطمینان دارید؟', doDeleteQuestionByUser, 'بله، حذف شود');
    }

    function doDeleteQuestionByUser(){
        openLoading();
        $.ajax({
            type: 'post',
            url: '{{route("deleteQuestion")}}',
            data: {
                _token: '{{csrf_token()}}',
                id: deletedQuestion
            },
            success: function(response){
                closeLoading();
                if(response == 'ok'){
                    $('#deleteQuestionModal').modal('hide');
                    $('#questionSection_' + deletedQuestion).remove();
                    showSuccessNotifi('سوال شما با موفقیت حذف شد.', 'left', 'green');
                }
                else
                    showSuccessNotifi('در حذف سوال شما مشکلی پیش آمده لطفا دوباره تلاش کنید.', 'left', 'red');
            },
            error: function(err){
                closeLoading();
                showSuccessNotifi('در حذف سوال شما مشکلی پیش آمده لطفا دوباره تلاش کنید.', 'left', 'red');
            }
        })
    }

</script>
