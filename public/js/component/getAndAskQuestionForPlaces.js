var questions;
var questionCount;
var answerCount;
var isQuestionCount = true;
var questionPage = 1;
var questionPerPageIndex = 0;


function sendQuestion(_element){

    if(!checkLogin())
        return;

    var text = $('#questionInput').val();

    if(text.trim().length > 0){
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
            count : questionPerPageNum[questionPerPageIndex],
            page : questionPage,
            isQuestionCount : isQuestionCount
        },
        success: response => {
            if(response.status == 'ok') {
                questions = response.questions;

                if (isQuestionCount) {
                    questionCount = response.allCount;
                    answerCount = response.answerCount;
                    isQuestionCount = false;
                    $('#questionCount').text(questionCount);
                    $('#answerCount').text(answerCount);
                }

                if (questionCount == 0)
                    $('#questionPaginationDiv').hide();
                else {
                    $('#questionSectionDiv').empty();
                    questions.map(ques => createQuestionPack(ques, 'questionSectionDiv') /**in questoinPack**/  )
                    createQuestionPagination(questionCount);
                }
            }
        }
    })
}

function changeQuestionPerPage(_count){
    $(`#questionPerView${questionPerPageIndex}`).removeClass('color-blue');
    $(`#questionPerView${_count}`).addClass('color-blue');
    questionPerPageIndex = _count;
    questionPage = 1;
    getQuestion();
}

function changeQuestionPage(_page){
    questionPage = _page;
    getQuestion();
}

function createQuestionPagination(questionCount){
    var text = '';
    var page = Math.ceil(questionCount/questionPerPageNum[questionPerPageIndex]);


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
        for (var i = 1; i <= page; i++)
            text += `<span class="cursor-pointer ${i == questionPage ? 'color-blue' : ''} mg-rt-5" onclick="changeQuestionPage(${i})">${i}</span>`;
    }

    $('#questionPagination').html(text);
}

function createQuestionPerPage(){
    var text = '';

    for(var i = 0; i < questionPerPageNum.length; i++){
        text += `<span id="questionPerView${i}" class="mg-0-2 cursor-pointer ${i == questionPerPageIndex ? 'color-blue' : ''} " onclick="changeQuestionPerPage(${i})">${questionPerPageNum[i]}</span>`;
        if(i != (questionPerPageNum.length - 1))
            text += '-';
    }

    document.getElementById('showQuestionPerPage').innerHTML = text;
}

$(window).ready(() => {
    getQuestion();
});
