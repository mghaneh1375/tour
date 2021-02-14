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
            type: 'POST',
            url : askQuestionUrl,
            data:{
                _token: csrfTokenGlobal,
                placeId: placeId,
                kindPlaceId : kindPlaceId,
                text : text,
            },
            success: response => {
                $(_element).toggle();
                $(_element).next().toggle();

                if(response == 'ok') {
                    getQuestion();
                    showSuccessNotifi('سئوال شما با موفقیت ثبت شد', 'left', 'var(--koochita-blue)');
                    $('#questionInput').val('');
                }
                else
                    showSuccessNotifi('در ثبت سوال شما مشگلی پیش امد لطفا دوباره تلاش کنید', 'left', 'red');
            },
            error: err => {
                $(_element).toggle();
                $(_element).next().toggle();
                showSuccessNotifi('در ثبت سوال شما مشگلی پیش امد لطفا دوباره تلاش کنید', 'left', 'red');
            }
        })
    }
}

function getQuestion(){
    $.ajax({
        type: 'POST',
        url: getQuestionsUrl,
        data:{
            _token: csrfTokenGlobal,
            placeId: placeId,
            kindPlaceId : kindPlaceId,
            count : questionPerPageNum[questionPerPage],
            page : questionPage,
            isQuestionCount : isQuestionCount
        },
        success: response => {
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

$(window).ready(() => {
    getQuestion();
});
