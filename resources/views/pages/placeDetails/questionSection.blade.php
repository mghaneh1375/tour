<style>
    @media (max-width: 767px) {
        .newQuestionContainer > div{
            font-size: 12px;
        }
    }
</style>

<div class="seperatorSections"></div>

<div id="QAndAMainDivId" class="tabContentMainWrap" style="display: flex; flex-direction: column;">
    <div class="topBarContainerQAndAs display-none"></div>
    <div class="col-md-12 col-xs-12 QAndAMainDiv" style="margin-bottom: 10px;">
        <div class="mainDivQuestions">
            <div class="QAndAMainDivHeader">
                <h3>سؤال و جواب</h3>
            </div>
            <div class="askQuestionMainDiv">
                <div class="newQuestionContainer">
                    <div class="direction-rtl text-align-right float-right full-width mg-bt-10" style="font-weight: bold;">
                        سؤلات خود را بپرسید تا با کمک دوستانتان آگاهانه‌تر سفر کنید. همچنین می‌توانید با
                        پاسخ یه سؤالات دوستانتان علاوه بر دریافت امتیاز، اطلاعات خود را به اشتراک
                        بگذارید.
                    </div>
                    <div class="display-inline-block float-right direction-rtl mg-lt-5">
                        در حال حاضر
                        <span class="color-blue" id="questionCount"></span>
                        سؤال
                        <span class="color-blue" id="answerCount"></span>
                        پاسخ موجود می‌باشد.
                    </div>

                    <div class="newQuestionMainDiv mg-tp-30 full-width display-inline-block">
                        <div class="questionInputBoxMainDiv">
                            <div class="circleBase type2 newQuestionWriterProfilePic">
                                <img src="{{ $userPic }}" style="width: 100%; height: 100%; border-radius: 50%;">
                            </div>
                            <div class="inputBox questionInputBox">
                                <textarea id="questionInput"
                                          class="inputBoxInput inputBoxInputComment"
                                          type="text" placeholder="شما چه سؤالی دارید؟"
                                          onclick="checkLogin()"></textarea>
                                <div class="sendQuestionBtn" onclick="sendQuestion(this)">ارسال</div>
                                <div class="sendQuestionBtn sendingQuestionLoading" style="display: none;"  disabled>
                                    <img src="{{URL::asset('images/icons/mGear.svg')}}" style="width: 30px; height: 30px;">
                                    {{__('در حال ثبت سوال')}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12" style="padding: 0px;">
        <div id="questionSectionDiv"></div>
    </div>

    <div id="questionPaginationDiv" class="col-xs-12 questionsMainDivFooter position-relative" style="margin-top: 0px;">
        <div class="col-xs-5 font-size-13 line-height-2">
            نمایش
            <span id="showQuestionPerPage"></span>
            پست در هر صفحه
        </div>
        <div class="col-xs-4 font-size-13 line-height-2 text-align-right float-right">
            <span class="float-right">صفحه</span>
            <span id="questionPagination"></span>
        </div>
    </div>
</div>


<script>
    var questions;
    var questionCount;
    var questionPerPage = 0;
    var questionPerPageNum = [3, 5, 10];
    var questionPage = 1;
    var answerCount;
    var isQuestionCount = true;

    function sendQuestion(_element){

        if(!checkLogin())
            return;

        var text = document.getElementById('questionInput').value;

        if(text != null && text != ''){
            $(_element).toggle();
            $(_element).next().toggle();
            $.ajax({
                type: 'post',
                url : '{{route("askQuestion")}}',
                data:{
                    'placeId': placeId,
                    'kindPlaceId' : kindPlaceId,
                    'text' : text,
                },
                success: function(response){
                    $(_element).toggle();
                    $(_element).next().toggle();

                    if(response == 'ok') {
                        getQuestion();
                        showSuccessNotifi('{{__('سئوال شما با موفقیت ثبت شد')}}', 'left', 'var(--koochita-blue)');
                        $('#questionInput').val('');
                    }
                    else
                        showSuccessNotifi('{{__('در ثبت سوال شما مشگلی پیش امد لطفا دوباره تلاش کنید')}}', 'left', 'red');
                },
                error: function(err){
                    $(_element).toggle();
                    $(_element).next().toggle();
                    showSuccessNotifi('{{__('در ثبت سوال شما مشگلی پیش امد لطفا دوباره تلاش کنید')}}', 'left', 'red');
                }
            })
        }
    }

    function getQuestion(){
        $.ajax({
            type: 'post',
            url: '{{route("getQuestions")}}',
            data:{
                'placeId': placeId,
                'kindPlaceId' : kindPlaceId,
                'count' : questionPerPageNum[questionPerPage],
                'page' : questionPage,
                'isQuestionCount' : isQuestionCount
            },
            success: function(response){
                if(response.status == 'ok') {
                    questions = response.questions;

                    if (isQuestionCount) {
                        questionCount = response.allCount;
                        answerCount = response.answerCount;
                        $('#questionCount').text(questionCount);
                        $('#answerCount').text(answerCount);
                        isQuestionCount = false;
                    }

                    if (questionCount == 0)
                        $('#questionPaginationDiv').hide();
                    else {
                        $('#questionSectionDiv').empty();
                        createQuestionPagination(questionCount);
                        questions.map(ques => createQuestionPack(ques, 'questionSectionDiv') /**in questoinPack**/  )
                    }
                }

            }
        })
    }
    getQuestion();

    function changeQuestionPerPage(_count){

        document.getElementById('questionPerView' + questionPerPage).classList.remove('color-blue');
        document.getElementById('questionPerView' + _count).classList.add('color-blue');
        questionPerPage = _count;
        questionPage = 1;
        getQuestion();
    }

    function changeQuestionPage(_page){
        questionPage = _page;
        getQuestion();
    }

    function createQuestionPagination(questionCount){
        var text = '';
        var page = Math.ceil(questionCount/questionPerPageNum[questionPerPage]);

        createQuestionPerPage();

        if(page >= 5){
            if(questionPage == 1){
                text += '<span class="cursor-pointer color-blue mg-rt-5 float-right" onclick="changeQuestionPage(1)">1</span>';
                text += '<span class="cursor-pointer mg-rt-5 float-right" onclick="changeQuestionPage(2)">2</span>';
                text += '<span class="cursor-pointer mg-rt-5 float-right" onclick="changeQuestionPage(3)">3</span>';
                text += '<span style="float: right"> >>> </span>';
                text += '<span class="cursor-pointer mg-lt-5" onclick="changeQuestionPage(' + page + ')">' + page + '</span>';
            }
            else if(questionPage == 2){
                text += '<span class="cursor-pointer mg-rt-5 float-right" onclick="changeQuestionPage(1)">1</span>';
                text += '<span class="cursor-pointer color-blue mg-rt-5 float-right" onclick="changeQuestionPage(2)">2</span>';
                text += '<span class="cursor-pointer mg-rt-5 float-right" onclick="changeQuestionPage(3)">3</span>';
                text += '<span class="float-right"> >>> </span>';
                text += '<span class="cursor-pointer mg-rt-5 float-right" onclick="changeQuestionPage(' + page + ')">' + page + '</span>';
            }
            else if(questionPage == 3){
                text += '<span class="cursor-pointer mg-rt-5 float-right" onclick="changeQuestionPage(1)">1</span>';
                text += '<span class="cursor-pointer mg-rt-5 float-right" onclick="changeQuestionPage(2)">2</span>';
                text += '<span class="cursor-pointer color-blue mg-rt-5 float-right" onclick="changeQuestionPage(3)">3</span>';
                text += '<span class="cursor-pointer mg-rt-5 float-right" onclick="changeQuestionPage(4)">4</span>';
                if(page == 5)
                    text += '<span class="cursor-pointer mg-rt-5 float-right" onclick="changeQuestionPage(5)">5</span>';
                else {
                    text += '<span class="float-right"> >>> </span>';
                    text += '<span class="cursor-pointer mg-rt-5 float-right" onclick="changeQuestionPage(' + page + ')">' + page + '</span>';
                }
            }
            else{
                text += '<span class="cursor-pointer mg-rt-5 float-right" onclick="changeQuestionPage(1)">1</span>';
                text += '<span class="float-right"> <<< </span>';

                if(questionPage == page){
                    text += '<span class="cursor-pointer mg-rt-5 float-right" onclick="changeQuestionPage(' + (questionPage-2) + ')">' + (questionPage-2) + '</span>';
                    text += '<span class="cursor-pointer mg-lt-5" onclick="changeQuestionPage(' + (questionPage-1) + ')">' + (questionPage-1) + '</span>';
                    text += '<span class="cursor-pointer color-blue mg-lt-5" onclick="changeQuestionPage(' + (questionPage) + ')">' + (questionPage) + '</span>';
                }
                else{
                    text += '<span class="cursor-pointer mg-rt-5 float-right" onclick="changeQuestionPage(' + (questionPage-1) + ')">' + (questionPage-1) + '</span>';
                    text += '<span class="cursor-pointer color-blue mg-rt-5 float-right" onclick="changeQuestionPage(' + (questionPage) + ')">' + (questionPage) + '</span>';
                    text += '<span class="cursor-pointer mg-rt-5 float-right" onclick="changeQuestionPage(' + (questionPage+1) + ')">' + (questionPage+1) + '</span>';
                    if((page - questionPage) == 2)
                        text += '<span class="cursor-pointer mg-lt-5" onclick="changeQuestionPage(' + (questionPage+2) + ')">' + (questionPage+2) + '</span>';
                }

                if((page - questionPage) >= 3){
                    text += '<span class="float-right"> >>> </span>';
                    text += '<span class="cursor-pointer mg-rt-5 float-right" onclick="changeQuestionPage(' + page + ')">' + page + '</span>';
                }


            }
        }
        else{
            for (var i = 1; i <= page; i++){
                if(i == questionPage)
                    text += '<span class="cursor-pointer color-blue mg-rt-5" onclick="changeQuestionPage(' + i + ')">' + i + '</span>';
                else
                    text += '<span class="cursor-pointer mg-rt-5" onclick="changeQuestionPage(' + i + ')">' + i + '</span>';
            }
        }

        document.getElementById('questionPagination').innerHTML = text;
    }

    function createQuestionPerPage(){
        var text = '';

        for(var i = 0; i < questionPerPageNum.length; i++){
            if(i == questionPerPage)
                text += '<span id="questionPerView' + i + '" class="mg-0-2 cursor-pointer color-blue" onclick="changeQuestionPerPage(' + i + ')">' + questionPerPageNum[i] + '</span>';
            else
                text += '<span id="questionPerView' + i + '" class="mg-0-2 cursor-pointer" onclick="changeQuestionPerPage(' + i + ')">' + questionPerPageNum[i] + '</span>';

            if(i != (questionPerPageNum.length - 1))
                text += '-';
        }

        document.getElementById('showQuestionPerPage').innerHTML = text;
    }
</script>